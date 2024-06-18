document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('table-search');
    const vehicleList = document.getElementById('vehicle-list');

    searchInput.addEventListener('input', function () {
        let searchText = searchInput.value.toLowerCase();
        Array.from(vehicleList.getElementsByTagName('tr')).forEach(function (row) {
            let isVisible = Array.from(row.getElementsByTagName('td')).some(td => td.textContent.toLowerCase().includes(searchText));
            row.style.display = isVisible ? '' : 'none';
        });
    });

    function createToast(message, status) {
        const toast = document.createElement('div');
        toast.className = `flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800`;
        toast.innerHTML = `
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 ${status.color} rounded-lg">
            ${status.icon}
            <span class="sr-only">${status.label} icon</span>
        </div>
        <div class="ms-3 text-sm font-normal">${message}</div>
        <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" onclick="this.parentNode.remove()">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    `;
        document.getElementById('toast-container').appendChild(toast);
    }

    function showToastSuccess() {
        createToast('Dados importados com sucesso!', { color: 'bg-green-100 dark:bg-green-800', icon: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>', label: 'Success' });
    }

    function showToastError(message) {
        createToast(`Erro ao importar dados! ${message}`, { color: 'bg-red-100 dark:bg-red-800', icon: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>', label: 'Success' });
    }

    let row;

    function checkVehicleExistence(vehicle) {
        fetch(`http://127.0.0.1:8000/vehicles/check/${vehicle.id}`)
            .then(response => response.json())
            .then(data => {
                addVehicleToTable(vehicle, data.exists);
            })
            .catch(error => console.error('Erro ao verificar existência do veículo:', error));
    }


    function addVehicleToTable(vehicle, exists) {
        row = `<tr>
                <td class="py-2 px-4 border-b">
                    ${exists ?
                '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'}
                </td>
                <td class="py-2 px-4 border-b">${!vehicle.marca ? 'N/A' : vehicle.marca}</td>
                <td class="py-2 px-4 border-b">${!vehicle.modelo ? 'N/A' : vehicle.modelo}</td>
                <td class="py-2 px-4 border-b">${!vehicle.ano ? 'N/A' : vehicle.ano}</td>
                <td class="py-2 px-4 border-b">${!vehicle.versao ? 'N/A' : vehicle.versao}</td>
                <td class="py-2 px-4 border-b">${!vehicle.cor ? 'N/A' : vehicle.cor}</td>
                <td class="py-2 px-4 border-b">${!vehicle.combustivel ? 'N/A' : vehicle.combustivel}</td>
                <td class="py-2 px-4 border-b">${!vehicle.km ? 'N/A' : vehicle.km}</td>
                <td class="py-2 px-4 border-b">${!vehicle.cambio ? 'N/A' : vehicle.cambio}</td>
                <td class="py-2 px-4 border-b">${!vehicle.portas ? 'N/A' : vehicle.portas}</td>
                <td class="py-2 px-4 border-b">${!vehicle.preco ? 'N/A' : vehicle.preco}</td>
                <td class="py-2 px-4 border-b">
                    <ul>
                        ${vehicle.opcionais.map(opcional => `<li>${opcional}</li>`).join('')}
                    </ul>
                </td>
        </tr>`;
        document.getElementById('vehicle-list').insertAdjacentHTML('beforeend', row);
    }

    fetch('http://127.0.0.1:8000/api/v1/estoque')
        .then(response => response.json())
        .then(data => {
            let vehicles = data.veiculos;

            vehicles.forEach(vehicle => {
                checkVehicleExistence(vehicle);
            });

        })
        .catch(error => console.error('Erro ao buscar os dados da API:', error));


    document.getElementById('import-button').addEventListener('click', function () {
        fetch('http://127.0.0.1:8000/api/v1/estoque')
            .then(response => response.json())
            .then(data => {
                let vehicles = data.veiculos;
                let promises = vehicles.map(vehicle => {
                    vehicle.origem = 'Web Motors';
                    return fetch('http://127.0.0.1:8000/api/mockApi/store', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(vehicle)
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    showToastError(errorData.message);
                                    throw new Error(errorData.message);
                                });
                            }
                            showToastSuccess();
                            return response.json();
                        })
                        .then(result => {
                            console.log('Dados importados com sucesso:', result);
                        })
                        .catch(error => {
                            console.error('Erro ao importar os dados:', error);
                        });
                });

                Promise.all(promises)
                    .then(() => {
                        window.location.href = '/vehicles';
                    })
                    .catch(error => console.error('Erro ao importar todos os dados:', error));
            })
            .catch(error => console.error('Erro ao buscar os dados da API:', error));
    });
});