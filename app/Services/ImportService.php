<?php
namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Http;

class ImportService
{
    public function importWebMotors()
    {
        $response = Http::get('http://127.0.0.1:8000/api/v1/estoque');
        $vehicles = $response->json('veiculos');

        foreach ($vehicles as $data) {
            Vehicle::updateOrCreate(
                ['id' => $data['id']],
                [
                    'marca' => $data['marca'],
                    'modelo' => $data['modelo'],
                    'ano' => $data['ano'],
                    'combustivel' => $data['combustivel'],
                    'km' => $data['km'],
                    'preco' => $data['preco']
                ]
            );
        }
    }

    public function importRevendaMais()
    {
        $response = Http::get('http://127.0.0.1:8000/api/estoque');
        $vehicles = simplexml_load_string($response->body())->veiculos->veiculo;

        foreach ($vehicles as $data) {
            Vehicle::updateOrCreate(
                ['id' => (int)$data->codigoVeiculo],
                [
                    'marca' => (string)$data->marca,
                    'modelo' => (string)$data->modelo,
                    'ano' => (int)$data->ano,
                    'combustivel' => (string)$data->tipoCombustivel,
                    'km' => (int)$data->quilometragem,
                    'preco' => (float)$data->precoVenda
                ]
            );
        }
    }
}
