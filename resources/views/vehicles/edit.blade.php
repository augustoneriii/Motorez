@extends('master')

@section('content')
<div class="container mx-auto mt-5 px-4">
    <div id="toast-container" class="fixed bottom-0 right-0 mb-8 mr-8 flex flex-col space-y-2"></div>

    @if (session()->has('success'))
        <script>
            createToast('{{ session('success') }}', 'success');
            setTimeout(() => {
                window.location.href = "{{ route('vehicles.index') }}";
            }, 3000);
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            createToast('{{ session('error') }}', 'error');
        </script>
    @endif

    <form method="POST" action="{{ route('vehicles.update', $vehicle->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="origem" value="{{ $vehicle->origem }}">
        <div class="bg-white mx-auto shadow-md rounded-lg p-4 w-3/5">
            <h1 class="text-2xl">Editar Veículo</h1>
            <div class="border-b border-gray-200 my-4"></div>
            <div class="grid grid-cols-3 gap-2">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="marca">
                        Marca
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="marca" type="text" name="marca" value="{{ $vehicle->marca }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="modelo">
                        Modelo
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="modelo" type="text" name="modelo" value="{{ $vehicle->modelo }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="ano">
                        Ano
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="ano" type="number" name="ano" value="{{ $vehicle->ano }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="combustivel">
                        Combustível
                    </label>
                    <select style="background-color: white !important;"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="combustivel" type="text" name="combustivel" value="{{ $vehicle->combustivel }}" required>
                        <option value="">Selecione</option>
                        <option value="Gasolina">Gasolina</option>
                        <option value="Álcool">Álcool</option>
                        <option value="Diesel">Diesel</option>
                        <option value="Flex">Flex</option>
                        <option value="Gás Natural">Gás Natural</option>
                        <option value="Híbrido">Híbrido</option>
                        <option value="Elétrico">Elétrico</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="km">
                        Quilometragem
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="km" type="number" name="km" value="{{ $vehicle->km }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="preco">
                        Preço
                    </label>
                    <input
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="preco" type="number" name="preco" value="{{ $vehicle->preco }}" required>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-start gap-x-6">
                <a href="{{ route('vehicles.index') }}">Voltar</a>
                <button
                    class="bg-blue-700 hover:bg-blue-900 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    Atualizar Veículo
                </button>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/toast.js') }}"></script>
@endsection