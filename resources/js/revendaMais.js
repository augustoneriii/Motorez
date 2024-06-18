document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('table-search');
    const vehicleList = document.getElementById('vehicle-list');
    const importButton = document.getElementById('import-button');
    const appUrl = window.appUrl;
    const appPort = window.appPort;

    searchInput.addEventListener('input', function () {
        const searchText = searchInput.value.toLowerCase();
        const rows = vehicleList.getElementsByTagName('tr');

        Array.from(rows).forEach(row => {
            const cells = row.getElementsByTagName('td');
            const found = Array.from(cells).some(cell => cell.textContent.toLowerCase().includes(searchText));
            row.style.display = found ? '' : 'none';
        });
    });
    //ok
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
        createToast('Dados importados com sucesso!', {
            color: 'bg-green-100 dark:bg-green-800',
            icon: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>',
            label: 'Success'
        });
    }

    function showToastError(message) {
        createToast(`Erro ao importar dados! ${message}`, {
            color: 'bg-red-100 dark:bg-red-800',
            icon: '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/></svg>',
            label: 'Error'
        });
    }

    function checkVehicleExistence(vehicle) {
        fetch(`${appUrl}/vehicles/check/${vehicle.id}`)
            .then(response => response.json())
            .then(data => {
                console.log('Veículo já existe:', data.exists);
                addVehicleToTable(vehicle, data.exists);
            })
            .catch(error => console.error('Erro ao verificar existência do veículo:', error));
    }

    function addVehicleToTable(vehicle, exists) {
        let row = `<tr>
                <td class="py-2 px-4 border-b">
                    ${exists ?
                '<svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' : '<svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>'}
                </td>
                <td class="py-2 px-4 border-b">${vehicle.marca}</td>
                <td class="py-2 px-4 border-b">${vehicle.modelo}</td>
                <td class="py-2 px-4 border-b">${vehicle.ano}</td>
                <td class="py-2 px-4 border-b">${vehicle.versao}</td>
                <td class="py-2 px-4 border-b">${vehicle.cor}</td>
                <td class="py-2 px-4 border-b">${vehicle.tipoCombustivel}</td>
                <td class="py-2 px-4 border-b">${vehicle.quilometragem}</td>
                <td class="py-2 px-4 border-b">${vehicle.cambio}</td>
                <td class="py-2 px-4 border-b">${vehicle.portas}</td>
                <td class="py-2 px-4 border-b">${vehicle.precoVenda}</td>
                <td class="py-2 px-4 border-b">
                    <ul>
                        ${vehicle.opcionais.map(opcional => `<li>${opcional}</li>`).join('')}
                    </ul>
                </td>
            </tr>`;
        document.getElementById('vehicle-list').insertAdjacentHTML('beforeend', row);
    }

    function fetchAndParseVehicles(url) {
        return fetch(url)
            .then(response => response.text())
            .then(data => {
                let parser = new DOMParser();
                let xmlDoc = parser.parseFromString(data, "application/xml");
                let vehicles = xmlDoc.getElementsByTagName("veiculo");

                let vehicleArray = [];
                for (let i = 0; i < vehicles.length; i++) {
                    let vehicle = vehicles[i];

                    let getTextContent = (tag) => {
                        let element = vehicle.getElementsByTagName(tag)[0];
                        return element ? element.textContent : '';
                    };

                    let opcionais = Array.from(vehicle.getElementsByTagName('opcional')).map(opcional => opcional.textContent);

                    vehicleArray.push({
                        id: getTextContent('codigoVeiculo'),
                        marca: getTextContent('marca'),
                        modelo: getTextContent('modelo'),
                        ano: getTextContent('ano'),
                        versao: getTextContent('versao'),
                        cor: getTextContent('cor'),
                        tipoCombustivel: getTextContent('tipoCombustivel'),
                        quilometragem: getTextContent('quilometragem'),
                        cambio: getTextContent('cambio'),
                        portas: getTextContent('portas'),
                        precoVenda: getTextContent('precoVenda'),
                        opcionais: opcionais
                    });
                }

                return vehicleArray;
            })
            .catch(error => console.error('Erro ao buscar os dados da API:', error));
    }

    fetchAndParseVehicles(`${appUrl}/api/estoque`)
        .then(vehicles => {
            vehicleList.innerHTML = '';
            vehicles.forEach(vehicle => {
                checkVehicleExistence(vehicle);
            });
        })
        .catch(error => console.error('Erro ao buscar os dados da API:', error));


    importButton.addEventListener('click', function () {
        let modal = document.getElementById('modalImport');
        modal.classList.remove('hidden');

        fetchAndParseVehicles(`${appUrl}/api/estoque`)
            .then(vehicles => {
                let promises = vehicles.map(vehicle => {
                    vehicle.origem = 'Revenda Mais';
                    return fetch(`${appUrl}/api/mockApi/store`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            id: vehicle.id,
                            marca: vehicle.marca,
                            modelo: vehicle.modelo,
                            ano: parseInt(vehicle.ano),
                            combustivel: vehicle.tipoCombustivel,
                            km: parseInt(vehicle.quilometragem),
                            preco: parseFloat(vehicle.precoVenda),
                            origem: vehicle.origem
                        })
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
                });

                Promise.all(promises)
                    .then(() => {
                        window.location.href = '/vehicles';
                        console.log('Todos os dados importados com sucesso!');
                    })
                    .catch(error => console.error('Erro ao importar todos os dados:', error));
            })
            .then(() => {
                console.log('Todos os dados importados com sucesso!');
            })
            .catch(error => console.error('Erro ao importar os dados:', error))
            .finally(() => {
                modal.classList.add('hidden');
            });

    });
});
