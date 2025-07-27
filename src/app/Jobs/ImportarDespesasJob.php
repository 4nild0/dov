<?php
// app/Jobs/ImportarDespesasJob.php

namespace App\Jobs;

use App\Models\Despesa;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ImportarDespesasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $deputadoId) {}

    public function handle(): void
    {
        $pagina = 1;

        do {
            $url = "https://dadosabertos.camara.leg.br/api/v2/deputados/{$this->deputadoId}/despesas?itens=100&pagina={$pagina}";
            $res = Http::get($url)->json();
            $despesas = $res['dados'] ?? [];

            foreach ($despesas as $d) {
                Despesa::updateOrCreate(
                    [
                        'deputado_id' => $this->deputadoId,
                        'data' => $d['dataDocumento'],
                        'tipo_despesa' => $d['tipoDespesa'],
                    ],
                    [
                        'valor' => floatval($d['valorLiquido']),
                        'fornecedor' => $d['nomeFornecedor'] ?? null,
                    ]
                );
            }

            $pagina++;
        } while (!empty($despesas));
    }
}
