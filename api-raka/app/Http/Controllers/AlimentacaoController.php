<?php

namespace App\Http\Controllers;

use Google\Auth\Credentials\ServiceAccountCredentials;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AlimentacaoController extends Controller
{
    public function recomendacaoAlimentacao($peso)
    {
        // Texto para a Google Gemini API com o peso
        $texto = "Dado um peso médio de {$peso} kg, faça uma consulta e diga qual é a alimentação ideal para um rebanho de gado de corte que precisa engordar, de uma resposta de tipos de alimentação apenas, nada alem disso, de resposta das melhores para as piores opções";

        // Caminho para o arquivo JSON de credenciais
        $credentialsPath = base_path('storage/credentials/gen-lang-client-0368632601-e5e17e25f3d3.json');

        // Carregar credenciais do JSON manualmente
        $scopes = ['https://www.googleapis.com/auth/generative-language'];
        $credentials = new ServiceAccountCredentials($scopes, $credentialsPath);

        // Cria um cliente Guzzle personalizado para desativar a verificação SSL
        $httpClient = new Client(['verify' => false]);

        // Define um callable que usa o Guzzle HTTP Client
        $httpHandler = function ($request) use ($httpClient) {
            return $httpClient->send($request);
        };

        // Obter o token de acesso usando o httpHandler personalizado
        $token = $credentials->fetchAuthToken($httpHandler)['access_token'];

        // URL da API com o modelo Gemini
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent';

        $data = [
            "contents" => [
                [
                    "parts" => [
                        ["text" => $texto]
                    ]
                ]
            ]
        ];

        try {
            // Chamada HTTP para a API, ignorando a verificação SSL
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->post($url, $data);

            if ($response->successful()) {
                return response()->json([
                    'recomendacao' => $response->json(),
                ], 200);
            } else {
                return response()->json([
                    'erro' => 'Não foi possível obter a recomendação de alimentação.',
                    'detalhe' => $response->json(),
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'erro' => 'Ocorreu um erro ao se comunicar com a API.',
                'detalhe' => $e->getMessage(),
            ], 500);
        }
    }
}
