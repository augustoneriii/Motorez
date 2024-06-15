@extends('master')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Detalhes do Veículo</h1>
        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-2xl">{{ $vehicle->marca }} - {{ $vehicle->modelo }}</h2>
            <p><strong>Ano:</strong> {{ $vehicle->ano }}</p>
            <p><strong>Combustível:</strong> {{ $vehicle->combustivel }}</p>
            <p><strong>Quilometragem:</strong> {{ $vehicle->km }}</p>
            <p><strong>Preço:</strong> {{ $vehicle->preco }}</p>
            <p><strong>Data de Criação:</strong> {{ $vehicle->created_at }}</p>
            <p><strong>Última Atualização:</strong> {{ $vehicle->updated_at }}</p>
        </div>
    </div>
@endsection
