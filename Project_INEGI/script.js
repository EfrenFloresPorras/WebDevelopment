document.addEventListener('DOMContentLoaded', function () {
    const motivoSelect = document.getElementById('motivoVisita');
    const summaryDiv = document.getElementById('summary');
    const tableBody = document.querySelector('#visitasTable tbody');

    function loadData(motivo = '') {
        fetch(`getData.php?motivo=${motivo}`)
            .then(response => response.json())
            .then(data => {
                updateTable(data.datos);
                updateSumm(data.estadisticas);
            })
            .catch(error => console.error('Error:', error));
    }

    function updateTable(datos) {
        tableBody.innerHTML = '';
        datos.forEach(visita => {
            const row = tableBody.insertRow();
            row.insertCell(0).textContent = visita.entidad;
            row.insertCell(1).textContent = visita.fecha;
            row.insertCell(2).textContent = visita.motivo;
            row.insertCell(3).textContent = visita.pais_residencia === '000' ? 'México' : 'Extranjero';
            row.insertCell(4).textContent = visita.primera_lengua;
        });
    }

    function updateSumm(estadisticas) {
        summaryDiv.innerHTML = `
            <div class="row">
                <div class="row">
                    <h2 class="fs-2 text-center">Resumen</h2>
                </div>
                <div class="row text-center">
                    <div class="col">
                        <p class="fs-5">Visitantes Nacionales: </p><p> ${estadisticas.nacionales}</p>
                    </div>
                    <div class="col">
                        <p class="fs-5">Visitantes Extranjeros: </p><p> ${estadisticas.extranjeros}</p>
                    </div>
                    <div class="col">
                        <p class="fs-5">Lenguas más habladas: </p><p> ${estadisticas.topLenguas.join(', ')}</p>
                    </div>
                </div>
            </div>
        `;
    }

    motivoSelect.addEventListener('change', function () {
        loadData(this.value);
    });

    // Carga inicial de datos
    loadData();
});
