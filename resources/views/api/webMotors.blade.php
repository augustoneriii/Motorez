@extends('master')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Estoque de Veículos - WebMotors</h1>
    <a href="{{ route('vehicles.index') }}" class="bg-blue-500 text-white px-4 py-1 mb-4">Voltar</a>
    <button id="import-button" class="bg-green-500 text-white px-4 py-1 mb-4">Importar</button>
    <div id="error-message" class="text-red-500 mb-4"></div>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2 px-4 border-b">Marca</th>
                <th class="py-2 px-4 border-b">Modelo</th>
                <th class="py-2 px-4 border-b">Ano</th>
                <th class="py-2 px-4 border-b">Versão</th>
                <th class="py-2 px-4 border-b">Cor</th>
                <th class="py-2 px-4 border-b">Combustível</th>
                <th class="py-2 px-4 border-b">Quilometragem</th>
                <th class="py-2 px-4 border-b">Câmbio</th>
                <th class="py-2 px-4 border-b">Portas</th>
                <th class="py-2 px-4 border-b">Preço</th>
                <th class="py-2 px-4 border-b">Data</th>
                <th class="py-2 px-4 border-b">Opcionais</th>
            </tr>
        </thead>
        <tbody id="vehicle-list">
            <!-- Conteúdo será populado via AJAX -->
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch('http://127.0.0.1:8000/api/v1/estoque')
            .then(response => response.json())
            .then(data => {
                let vehicles = data.veiculos;
                let vehicleList = document.getElementById('vehicle-list');
                vehicleList.innerHTML = '';

                vehicles.forEach(vehicle => {
                    let row = `<tr>
                        <td class="py-2 px-4 border-b">${vehicle.marca}</td>
                        <td class="py-2 px-4 border-b">${vehicle.modelo}</td>
                        <td class="py-2 px-4 border-b">${vehicle.ano}</td>
                        <td class="py-2 px-4 border-b">${vehicle.versao}</td>
                        <td class="py-2 px-4 border-b">${vehicle.cor}</td>
                        <td class="py-2 px-4 border-b">${vehicle.combustivel}</td>
                        <td class="py-2 px-4 border-b">${vehicle.km}</td>
                        <td class="py-2 px-4 border-b">${vehicle.cambio}</td>
                        <td class="py-2 px-4 border-b">${vehicle.portas}</td>
                        <td class="py-2 px-4 border-b">${vehicle.preco}</td>
                        <td class="py-2 px-4 border-b">${vehicle.date}</td>
                        <td class="py-2 px-4 border-b">
                            <ul>
                                ${vehicle.opcionais.map(opcional => `<li>${opcional}</li>`).join('')}
                            </ul>
                        </td>
                    </tr>`;
                    vehicleList.insertAdjacentHTML('beforeend', row);
                });
            })
            .catch(error => console.error('Erro ao buscar os dados da API:', error));
    });

    document.getElementById('import-button').addEventListener('click', function () {
        fetch('http://127.0.0.1:8000/api/v1/estoque')
            .then(response => response.json())
            .then(data => {
                let vehicles = data.veiculos.map(vehicle => ({
                    marca: vehicle.marca,
                    modelo: vehicle.modelo,
                    ano: vehicle.ano,
                    combustivel: vehicle.combustivel,
                    km: vehicle.km,
                    preco: vehicle.preco
                }));

                fetch('{{ route('insertWebMotors') }}', { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: vehicles
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao importar veículos.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            alert('Veículos importados com sucesso!');
                        } else {
                            alert('Erro ao importar veículos.');
                        }
                    })
                    .catch(error => {
                        document.getElementById('error-message').textContent = error.message;
                        console.error('Erro ao importar veículos:', error);
                    });
            })
            .catch(error => console.error('Erro ao buscar os dados da API:', error));
    });
</script>
@endsection