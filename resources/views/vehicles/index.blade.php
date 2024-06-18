@extends('master')

@section('content')
    <div class="container mx-auto px-4">
        <h1 class="text-3xl font-bold mb-4">Lista de Veículos Motorez</h1>

        <a href="{{ route('vehicles.create') }}"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Novo
            Veículo</a>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-3 mt-5">
            <div class="pb-4 bg-white dark:bg-gray-900">
                <form action="{{ route('vehicles.index') }}" method="GET">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative mt-1">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="table-search" name="search"
                            class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Buscar...">
                    </div>
                </form>
            </div>

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="py-2 px-4 border-b">Marca</th>
                        <th class="py-2 px-4 border-b">Modelo</th>
                        <th class="py-2 px-4 border-b">Ano</th>
                        <th class="py-2 px-4 border-b">Combustível</th>
                        <th class="py-2 px-4 border-b">Quilometragem</th>
                        <th class="py-2 px-4 border-b">Preço</th>
                        <th class="py-2 px-4 border-b">Origem Cadastro</th>
                        <th class="py-2 px-4 border-b">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($vehicles->isEmpty())
                        <tr>
                            <td class="py-2 px-4 border-b" colspan="8">Nenhum veículo encontrado</td>
                        </tr>
                    @endif
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td class="py-2 px-4 border-b">{{ $vehicle->marca }}</td>
                            <td class="py-2 px-4 border-b">{{ $vehicle->modelo }}</td>
                            <td class="py-2 px-4 border-b">{{ $vehicle->ano }}</td>
                            <td class="py-2 px-4 border-b">{{ $vehicle->combustivel }}</td>
                            <td class="py-2 px-4 border-b">{{ $vehicle->km }} km</td>
                            <td class="py-2 px-4 border-b">R$ {{ $vehicle->preco }}</td>
                            <td class="py-2 px-4 border-b">{{ $vehicle->origem }}</td>
                            <td class="py-2 px-4 border-b flex flex-col">
                                <a href="{{ route('vehicles.show', ['vehicle' => $vehicle->id]) }}"
                                    class="text-blue-500">Ver</a>
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="text-yellow-500">Editar</a>
                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Você tem certeza que deseja deletar este veículo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Deletar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $vehicles->links() }}
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('button[data-modal-toggle="popup-modal"]');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const vehicleId = this.getAttribute('data-vehicle-id');
                    document.getElementById('vehicle_id').value = vehicleId;
                });
            });
        });
    </script>
@endsection
