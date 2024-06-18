@extends('master')

@section('content')
<div class="container mx-auto mt-5 px-4">
    <h1 class="text-3xl font-bold mb-4">Detalhes do Veículo</h1>
    <div class="bg-white mx-auto shadow-md rounded-lg p-4">
        <h2 class="text-2xl">{{ $vehicle->marca }} - {{ $vehicle->modelo }}</h2>
        <div class="border-b border-gray-200 my-4"></div>
        <div class="grid grid-cols-3 gap-4">
            <p><strong>Ano:</strong> {{ $vehicle->ano }}</p>
            <p><strong>Combustível:</strong> {{ $vehicle->combustivel }}</p>
            <p><strong>Quilometragem:</strong> {{ $vehicle->km }}</p>
            <p><strong>Preço:</strong> {{ $vehicle->preco }}</p>
            <p><strong>Origem do Cadastro:</strong> {{ $vehicle->origem }}</p>
            <p><strong>Data de Criação:</strong> {{ $vehicle->created_at }}</p>
            <p><strong>Última Atualização:</strong> {{ $vehicle->updated_at }}</p>
        </div>
        <div class="border-b border-gray-200 my-4"></div>
        <div class="flex items-center justify-start gap-x-6">
            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Deletar</button>
            </form>
            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-yellow-500">Editar</a>
        </div>
    </div>
    <div class="mt-5 px-4">
        <a href="{{ route('vehicles.index') }}" class="text-zinc-600">Voltar</a>
    </div>
</div>
@endsection