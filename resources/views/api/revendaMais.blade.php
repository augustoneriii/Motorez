@extends('master')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-4">Estoque de Veículos - Revenda Mais</h1>
    <a href="{{ route('vehicles.index') }}" class="bg-blue-500 text-white px-4 py-1 mb-4">Voltar</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        fetch('http://127.0.0.1:8000/api/estoque')
            .then(response => response.text())
            .then(data => {
                let parser = new DOMParser();
                let xmlDoc = parser.parseFromString(data, "text/xml");

                let vehicles = xmlDoc.getElementsByTagName("veiculo");
                let vehicleList = document.getElementById('vehicle-list');
                vehicleList.innerHTML = '';

                for (let i = 0; i < vehicles.length; i++) {
                    let vehicle = vehicles[i];
                    let opcionais = vehicle.getElementsByTagName('opcional');
                    let opcionaisList = [];
                    for (let j = 0; j < opcionais.length; j++) {
                        opcionaisList.push(opcionais[j].textContent);
                    }

                    let row = `<tr>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('marca')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('modelo')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('ano')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('versao')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('cor')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('tipoCombustivel')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('quilometragem')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('cambio')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('portas')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('precoVenda')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">${vehicle.getElementsByTagName('ultimaAtualizacao')[0].textContent}</td>
                        <td class="py-2 px-4 border-b">
                            <ul>
                                ${opcionaisList.map(opcional => `<li>${opcional}</li>`).join('')}
                            </ul>
                        </td>
                    </tr>`;
                    vehicleList.insertAdjacentHTML('beforeend', row);
                }
            })
            .catch(error => console.error('Erro ao buscar os dados da API:', error));
    });
</script>
@endsection
