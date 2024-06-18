<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Http\Response;
use App\Services\ImportService;
use App\DTO\WebMotorsDTO;

class MockApiController extends Controller
{
    public function store(Request $request)
    {
        $importService = new ImportService($this->appUrl, $this->appPort);
        return $importService->Import($request);
    }

    public function webmotors()
    {
        $data = [
            'veiculos' => [
                [
                    'id' => 12345,
                    'marca' => 'Chevrolet',
                    'modelo' => 'Onix',
                    'ano' => 2024,
                    'versao' => 'LT',
                    'cor' => 'Branco',
                    'km' => 10000,
                    'combustivel' => 'Gasolina',
                    'cambio' => 'Automático',
                    'portas' => 4,
                    'preco' => 85000.00,
                    'date' => '2024-06-11 19:30:21',
                    'opcionais' => [
                        'Ar condicionado',
                        'Vidros elétricos',
                        'Direção hidráulica',
                        'Travas elétricas'
                    ]
                ],
                [
                    'id' => 67890,
                    'marca' => 'Fiat',
                    'modelo' => 'Argo',
                    'ano' => 2023,
                    'versao' => 'Trek',
                    'cor' => 'Prata',
                    'km' => 20000,
                    'combustivel' => 'Flex',
                    'cambio' => 'Manual',
                    'portas' => 4,
                    'preco' => 72000.00,
                    'date' => '2024-06-14 07:20:41',
                    'opcionais' => [
                        'Ar condicionado',
                        'Vidros elétricos',
                        'Direção hidráulica'
                    ]
                ],
                [
                    'id' => 23456,
                    'marca' => 'Volkswagen',
                    'modelo' => 'T-Cross',
                    'ano' => 2022,
                    'versao' => 'Comfortline',
                    'cor' => 'Preto',
                    'km' => 30000,
                    'cambio' => 'Automático',
                    'portas' => 5,
                    'preco' => 98000.00,
                    'date' => '2024-06-14 09:15:01',
                    'opcionais' => [
                        'Ar condicionado',
                        'Vidros elétricos',
                        'Direção hidráulica',
                        'Teto solar',
                        'Faróis de LED'
                    ]
                ]
            ]
        ];

        return response()->json($data);
    }

    public function revendaMais()
    {
        $data = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<estoque>
    <veiculos>
        <veiculo>
            <codigoVeiculo>12345</codigoVeiculo>
            <marca>Chevrolet</marca>
            <modelo>Onix</modelo>
            <ano>2024</ano>
            <versao>LT</versao>
            <cor>Branco</cor>
            <quilometragem>10000</quilometragem>
            <tipoCombustivel>Gasolina</tipoCombustivel>
            <cambio>Automatica</cambio>
            <portas>4</portas>
            <precoVenda>85000.00</precoVenda>
            <ultimaAtualizacao>12/06/2024 18:10</ultimaAtualizacao>
            <opcionais>
                <opcional>Ar Condicionado</opcional>
                <opcional>Vidros Eletricos</opcional>
                <opcional>Direcao Hidraulica</opcional>
                <opcional>Travas Eletricas</opcional>
            </opcionais>
        </veiculo>
        <veiculo>
            <codigoVeiculo>67890</codigoVeiculo>
            <marca>Fiat</marca>
            <modelo>Argo</modelo>
            <ano>2023</ano>
            <versao>Trek</versao>
            <cor>Prata</cor>
            <quilometragem>20000</quilometragem>
            <tipoCombustivel>Flex</tipoCombustivel>
            <cambio>Manual</cambio>
            <portas>4</portas>
            <precoVenda>72000.00</precoVenda>
            <ultimaAtualizacao>14/06/2024 09:01</ultimaAtualizacao>
            <opcionais>
                <opcional>Ar Condicionado</opcional>
                <opcional>Vidros Eletricos</opcional>
                <opcional>Direcao Hidraulica</opcional>
            </opcionais>
        </veiculo>
        <veiculo>
            <codigoVeiculo>23456</codigoVeiculo>
            <marca>Volkswagen</marca>
            <modelo>T-Cross</modelo>
            <ano>2022</ano>
            <versao>Comfortline</ano>
            <cor>Preto</cor>
            <quilometragem>30000</quilometragem>
            <tipoCombustivel>Gasolina</tipoCombustivel>
            <cambio>Automatica</cambio>
            <portas>5</portas>
            <precoVenda>98000.00</precoVenda>
            <ultimaAtualizacao>14/06/2024 10:17</ultimaAtualizacao>
            <opcionais>
                <opcional>Ar Condicionado</opcional>
                <opcional>Vidros Eletricos</opcional>
                <opcional>Direcao Hidraulica</opcional>
                <opcional>Teto Solar</opcional>
                <opcional>Faróis de LED</opcional>
            </opcionais>
        </veiculo>
    </veiculos>
</estoque>
XML;

        return response($data, 200)->header('Content-Type', 'application/xml');
    }
}
