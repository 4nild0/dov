<?php

namespace App\Jobs;

use App\Models\Deputado;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportarDeputadoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $deputadoId) {}

    public function handle(): void
    {
        $resposta = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$this->deputadoId}");

        if (!$resposta->ok()) {
            logger()->error('Erro ao buscar deputado na API', [
                'id' => $this->deputadoId,
                'status' => $resposta->status(),
                'body' => $resposta->body(),
            ]);
            return;
        }

        $json = $resposta->json();

        if (!isset($json['dados'])) {
            logger()->error('Resposta inválida da API ao buscar deputado', [
                'id' => $this->deputadoId,
                'json' => $json,
            ]);
            return;
        }

        $data = $json['dados'];
        $ultimoStatus = $data['ultimoStatus'] ?? [];

        $nome = $ultimoStatus['nome'] ?? $data['nome'] ?? null;

        if (!$nome) {
            logger()->error('Nome do deputado não encontrado na resposta da API', [
                'id' => $this->deputadoId,
                'data' => $data,
            ]);
            return;
        }

        $deputado = Deputado::updateOrCreate(
            ['id' => $data['id']],
            [
                'nome'          => $nome,
                'partido'       => $ultimoStatus['siglaPartido'] ?? '-',
                'uf'            => $ultimoStatus['siglaUf'] ?? '-',
                'foto_url'      => $ultimoStatus['urlFoto'] ?? null,
                'email'         => $ultimoStatus['email'] ?? null,
                'idLegislatura' => $ultimoStatus['idLegislatura'] ?? null,
            ]
        );

        // Importa despesas de forma síncrona para garantir consistência
        ImportarDespesasJob::dispatchSync($deputado->id);
    }
}
