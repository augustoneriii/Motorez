<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\DTOs\WebMotorsDTO;
use App\DAO\VehicleDAO;

class VehicleController extends Controller
{
    protected $vehicle;

    public function __construct()
    {
        $this->vehicle = new Vehicle();
    }

    public function index(Request $request)
    {
        $query = Vehicle::query();

        if ($request->has('marca')) {
            $query->where('marca', $request->input('marca'));
        }
        if ($request->has('modelo')) {
            $query->where('modelo', $request->input('modelo'));
        }
        if ($request->has('ano')) {
            $query->where('ano', $request->input('ano'));
        }

        $vehicles = $query->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        try {
            $vehicles = $request->input('vehicles');
            
            foreach ($vehicles as $vehicleData) {
                $dto = WebMotorsDTO::fromArray($vehicleData);
                $this->vehicle->create([
                    'marca' => $dto->marca,
                    'modelo' => $dto->modelo,
                    'ano' => $dto->ano,
                    'combustivel' => $dto->combustivel,
                    'km' => $dto->km,
                    'preco' => $dto->preco
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', ['vehicle' => $vehicle]);
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', ['vehicle' => $vehicle]);
    }

    public function update(Request $request, $id)
    {
        $updated = $this->vehicle->where('id', $id)->update($request->except(['_token', '_method']));

        if ($updated) {
            return redirect()->back()->with('message', 'Vehicle updated successfully');
        }

        return redirect()->back()->with('message', 'Error updating vehicle');
    }

    public function destroy($id)
    {
        $this->vehicle->where('id', $id)->delete();
        return redirect()->route('vehicles.index');
    }

    public function getWebMotors()
    {
        return view('api.webmotors');
    }

    public function insertWebMotors(Request $request)
    {
        dd($request->all());
        $vehicles = $request->input('vehicles');
        $webMotorsDAO = new VehicleDAO();
        $webMotorsDTOs = [];

        foreach ($vehicles as $vehicleData) {
            $dto = WebMotorsDTO::fromArray($vehicleData);
            $webMotorsDTOs[] = $dto;

            $this->vehicle->create([
                'marca' => $dto->marca,
                'modelo' => $dto->modelo,
                'ano' => $dto->ano,
                'combustivel' => $dto->combustivel,
                'km' => $dto->km,
                'preco' => $dto->preco
            ]);
        }

        $webMotorsDAO->insertWebMotors($webMotorsDTOs);
        return response()->json(['success' => true]);
    }   

    public function getRevendaMais()
    {
        return view('api.revendaMais');
    }
}
