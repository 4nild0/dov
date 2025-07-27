<?php

namespace App\Http\Controllers;

use App\Jobs\ImportarDeputadoJob;
use App\Models\Deputado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DeputadoController extends Controller
{
    public function buscar(Request $request)
    {
        $nomeInput = mb_strtolower($request->input('nome'));

        // Busca local no banco
        $deputado = Deputado::whereRaw('LOWER(nome) LIKE ?', ["%{$nomeInput}%"])
            ->with('despesas')
            ->first();

        if ($deputado) {
            $despesasFormatadas = $deputado->despesas
                ->sortByDesc('data')
                ->map(function ($d) {
                    return [
                        'data' => $d->data,
                        'tipo_despesa' => $d->tipo_despesa,
                        'valor' => floatval($d->valor),
                        'fornecedor' => $d->fornecedor ?: 'Fornecedor não informado',
                    ];
                });

            return Inertia::render('Resultado', [
                'deputado' => [
                    'id' => $deputado->id,
                    'nome' => $deputado->nome,
                    'partido' => $deputado->partido,
                    'uf' => $deputado->uf,
                    'foto_url' => $deputado->foto_url,
                    'email' => $deputado->email,
                    'idLegislatura' => $deputado->idLegislatura,
                    'despesas' => $despesasFormatadas->values(),
                ],
                'fonte' => 'banco',
            ]);
        }

        // Busca lista da API
        $resposta = Http::get('https://dadosabertos.camara.leg.br/api/v2/deputados');

        if (!$resposta->ok() || !isset($resposta['dados'])) {
            return Inertia::render('Resultado', [
                'erro' => 'Erro ao consultar a API da Câmara dos Deputados.'
            ]);
        }

        // Filtra por nome parcial
        $resultado = collect($resposta['dados'])->first(function ($dep) use ($nomeInput) {
            return str_contains(mb_strtolower($dep['nome']), $nomeInput);
        });

        if (!$resultado) {
            return Inertia::render('Resultado', [
                'erro' => 'Deputado não encontrado na base local nem na API da Câmara.'
            ]);
        }

        // Dados detalhados
        $respostaDetalhada = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$resultado['id']}");

        if (!$respostaDetalhada->ok() || !isset($respostaDetalhada['dados'])) {
            return Inertia::render('Resultado', [
                'erro' => 'Erro ao obter dados detalhados do deputado.'
            ]);
        }

        $dados = $respostaDetalhada['dados'];
        $status = $dados['ultimoStatus'] ?? [];

        $nome = $status['nome'] ?? $dados['nome'] ?? null;

        if (!$nome) {
            return Inertia::render('Resultado', [
                'erro' => 'Nome do deputado não encontrado na resposta da API.'
            ]);
        }

        ImportarDeputadoJob::dispatchSync($resultado['id']);

        // Despesas da API, ordenadas da mais recente para mais antiga
        $respostaDespesas = Http::get("https://dadosabertos.camara.leg.br/api/v2/deputados/{$resultado['id']}/despesas");

        $despesas = $respostaDespesas->ok() && isset($respostaDespesas['dados'])
            ? collect($respostaDespesas['dados'])
                ->sortByDesc('dataDocumento')
                ->map(function ($d) {
                    return [
                        'data' => $d['dataDocumento'] ?? null,
                        'tipo_despesa' => $d['tipoDespesa'] ?? '-',
                        'valor' => floatval($d['valorLiquido'] ?? 0),
                        'fornecedor' => $d['nomeFornecedor'] ?? 'Fornecedor não informado',
                    ];
                })->values()
            : collect();

        return Inertia::render('Resultado', [
            'deputado' => [
                'id'            => $dados['id'],
                'nome'          => $nome,
                'partido'       => $status['siglaPartido'] ?? '-',
                'uf'            => $status['siglaUf'] ?? '-',
                'foto_url'      => $status['urlFoto'] ?? null,
                'email'         => $status['email'] ?? null,
                'idLegislatura' => $status['idLegislatura'] ?? null,
                'despesas'      => $despesas,
            ],
            'fonte' => 'api',
        ]);
    }
}
