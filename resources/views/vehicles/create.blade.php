@extends('master')

@section('content')
    <h1>Criar Veículo</h1>
    <form method="POST" action="{{ route('vehicles.store') }}">
        @csrf
        <label>Marca</label>
        <input type="text" name="marca" required>
        <label>Modelo</label>
        <input type="text" name="modelo" required>
        <label>Ano</label>
        <input type="number" name="ano" required>
        <label>Combustível</label>
        <input type="text" name="combustivel" required>
        <label>Quilometragem</label>
        <input type="number" name="km" required>
        <label>Preço</label>
        <input type="number" name="preco" required>
        <button type="submit">Criar</button>
    </form>
@endsection
