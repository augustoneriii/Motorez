<?php
namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\DTO\WebMotorsDTO;
use Illuminate\Support\Facades\Http;

class ImportService
{
    protected $vehicle;
    protected $appUrl;
    protected $appPort;

    public function __construct($appUrl, $appPort)
    {
        $this->vehicle = new Vehicle();
        $this->appUrl = $appUrl;
        $this->appPort = $appPort;
    }

    public function validateVehicle($id)
    {
        return $this->vehicle->where('idExternal', $id)->exists();
    }

    public function Import($request)
    {
        $idExternal = $request->input('id');
        $isValid = $this->validateVehicle($idExternal);

        if ($isValid) {
            return response()->json(['message' => 'Veículo já cadastrado'], 400);
        }

        $dto = WebMotorsDTO::fromArray([
            'id' => $request->input('id'),
            'marca' => $request->input('marca', 'Sem marca registrada'),
            'modelo' => $request->input('modelo', 'Sem modelo registrado'),
            'ano' => $request->input('ano', 0),
            'combustivel' => $request->input('combustivel', 'Sem combustível registrado'),
            'km' => $request->input('km', 0),
            'preco' => $request->input('preco', 0),
            'origem' => $request->input('origem', 'Sem origem registrada')
        ]);

        $created = $this->vehicle->create([
            'idExternal' => $dto->id,
            'marca' => $dto->marca,
            'modelo' => $dto->modelo,
            'ano' => $dto->ano,
            'combustivel' => $dto->combustivel,
            'km' => $dto->km,
            'preco' => $dto->preco,
            'origem' => $dto->origem
        ]);

        if (!$created) {
            return response()->json(['message' => 'Erro ao cadastrar veículo'], 500);
        }

        return response()->json(['message' => 'Veículo cadastrado com sucesso'], 201);
    }
}
