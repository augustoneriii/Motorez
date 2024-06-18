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
        parent::__construct();
        $this->vehicle = new Vehicle();
    }

    public function index(Request $request)
    {
        $query = Vehicle::query();

        $appUrl = $this->appUrl;

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('marca', 'LIKE', '%' . $search . '%')
                    ->orWhere('modelo', 'LIKE', '%' . $search . '%')
                    ->orWhere('ano', 'LIKE', '%' . $search . '%')
                    ->orWhere('origem', 'LIKE', '%' . $search . '%');
            });
        }

        $vehicles = $query->paginate(10);
        return view('vehicles.index', compact('vehicles', 'appUrl'));
    }

    public function checkIfExists($idExternal)
    {
        $exists = Vehicle::where('idExternal', $idExternal)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        try {
            $created = $this->vehicle->create([
                'marca' => $request->input('marca'),
                'modelo' => $request->input('modelo'),
                'ano' => $request->input('ano'),
                'combustivel' => $request->input('combustivel'),
                'km' => $request->input('km'),
                'preco' => $request->input('preco'),
                'origem' => $request->input('origem')
            ]);
            if ($created) {
                return redirect()->route('vehicles.index')->with('success', 'Veículo criado com sucesso!');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar veículo: ' . $e->getMessage());
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
        try {
            Vehicle::findOrFail($id)->delete();
            return redirect()->route('vehicles.index')->with('success', 'Veículo deletado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao deletar veículo: ' . $e->getMessage());
        }
    }
    

    public function getWebMotors()
    {
        $appUrl = $this->appUrl;
        $appPort = $this->appPort;

        return view('api.webmotors', compact('appUrl', 'appPort'));
    }

    public function getRevendaMais()
    {
        $appUrl = $this->appUrl;
        $appPort = $this->appPort;

        return view('api.revendaMais', compact('appUrl', 'appPort'));
    }
}
