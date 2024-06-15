@extends('master')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Lista de Veículos</h1>

    <a href="{{ route('vehicles.create') }}" class="bg-blue-500 text-white px-4 py-1 mb-4">Novo Veículo</a>    
    <a href="{{ route('webmotors') }}" class="bg-green-500 text-white px-4 py-1 mb-4">Dados API WebMotors</a> 
    <a href="{{ route('revendaMais') }}" class="bg-green-500 text-white px-4 py-1 mb-4">Dados API Revenda Mais</a> 

    <div>
        <form method="GET" action="{{ route('vehicles.index') }}" class="mb-4">
            <input type="text" name="marca" placeholder="Marca" value="{{ request('marca') }}" class="border px-2 py-1">
            <input type="text" name="modelo" placeholder="Modelo" value="{{ request('modelo') }}" class="border px-2 py-1">
            <input type="number" name="ano" placeholder="Ano" value="{{ request('ano') }}" class="border px-2 py-1">
            <button type="submit" class="bg-blue-500 text-white px-4 py-1">Filtrar</button>
        </form>
    </div>

    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Marca</th>
                <th class="py-2 px-4 border-b">Modelo</th>
                <th class="py-2 px-4 border-b">Ano</th>
                <th class="py-2 px-4 border-b">Combustível</th>
                <th class="py-2 px-4 border-b">Quilometragem</th>
                <th class="py-2 px-4 border-b">Preço</th>
                <th class="py-2 px-4 border-b">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehicles as $vehicle)
                <tr>
                    <td class="py-2 px-4 border-b">{{ $vehicle->marca }}</td>
                    <td class="py-2 px-4 border-b">{{ $vehicle->modelo }}</td>
                    <td class="py-2 px-4 border-b">{{ $vehicle->ano }}</td>
                    <td class="py-2 px-4 border-b">{{ $vehicle->combustivel }}</td>
                    <td class="py-2 px-4 border-b">{{ $vehicle->km }}</td>
                    <td class="py-2 px-4 border-b">{{ $vehicle->preco }}</td>
                    <td class="py-2 px-4 border-b">
                        <a href="{{ route('vehicles.show', $vehicle->id) }}" class="text-blue-500">Ver</a>
                        <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-yellow-500">Editar</a>
                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Deletar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $vehicles->links() }}
</div>
@endsection
