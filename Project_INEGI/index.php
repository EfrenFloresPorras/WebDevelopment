<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Visitas a Museos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body class="bg-dark">
    <div class="container mt-4">
        <div id="summary" class="summary rounded-4 text-center">
            <h2>INEGI DATA</h2>
            <p>Cargando resumen...</p>
        </div>

        <div class="filter">
            <label for="motivoVisita" class="fs-4">Motivo de la visita:</label>
            <select id="motivoVisita" class="form-select form-select-sm sm" aria-label="Small select example">
                <option value="">Todos</option>
                <option value="cultura">Cultura general</option>
                <option value="acomp">Acompañar a alguien</option>
                <option value="aprend">Aprendizaje</option>
                <option value="escolar">Motivos escolares</option>
                <option value="laboral">Motivos laborales</option>
                <option value="conocer">Conocer la exposición</option>
                <option value="entrete">Entretenimiento</option>
                <option value="edifici">Ver el edificio</option>
                <option value="taller">Participar en taller</option>
                <option value="otro">Otro</option>
            </select>
        </div>
        <table id="visitasTable">
            <thead class="bg-dark">
                <tr>
                    <th>Entidad de Registro</th>
                    <th>Fecha</th>
                    <th>Motivos</th>
                    <th>País de Residencia</th>
                    <th>Primera Lengua</th>
                </tr>
            </thead>
            <tbody>
                <!-- Los datos se cargarán aquí dinámicamente -->
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="script.js"></script>
</body>

</html>