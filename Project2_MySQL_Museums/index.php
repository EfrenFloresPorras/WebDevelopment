<?php
// Expected files to runn first are config.php and functions.php
require_once 'config.php';
require_once 'functions.php';

// After finding the files, All the next starts
session_start();

// Establish database connection
$conn = new mysqli($DB_data['server'], $DB_data['connInfo']['UID'], $DB_data['connInfo']['PWD'], $DB_data['Database']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get filter options, summary data, and table data
$filters = [
    'medio_transporte', 'tipo_grupo', 'motivo', 'residencia', 'nacionalidad',
    'primera_leng', 'frecuencia_visita', 'estado', 'medio_com', 'escolaridad', 'estado_escolar'
];

$filterOptions = [];
foreach ($filters as $filter) {
    $filterOptions[$filter] = getFilterOptions($conn, $filter);
}

// Get summary data and table data
$summaryData = [];
$tableData = [];

// If search form submitted, get data based on search query
if (isset($_POST['search'])) {
    $query = buildSearchQuery($_POST);
    $summaryData = getSummaryData($conn, $query);
    $tableData = getTableData($conn, $query);
    $_SESSION['last_query'] = $_POST;
} elseif (isset($_SESSION['last_query'])) {
    $query = buildSearchQuery($_SESSION['last_query']);
    $summaryData = getSummaryData($conn, $query);
    $tableData = getTableData($conn, $query);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INEGI DATA - Visitas a Museos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container-fluid">
        <h1 class="my-4 text-center">INEGI DATA - Visitas a Museos</h1>
        
        <!-- Filters Button -->
        <div class="mb-4">
            <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#filtersCollapse" aria-expanded="false" aria-controls="filtersCollapse">
                <i class="bi bi-filter"></i> Filtros
            </button>
        </div>

        <!-- Filters Form -->
        <div class="collapse" id="filtersCollapse">
            <form method="POST" id="searchForm"> <!-- Formulario de búsqueda, method POST, ALL this data is sent -->
                <div id="filters" class="row mb-4">

                    <!-- Filtros, this searches each filter and each option that appear in those -->
                    <?php foreach ($filters as $filter): ?>
                    <div class="col-md-3 mb-3">
                        <label for="<?php echo $filter; ?>" class="form-label"><?php echo ucfirst(str_replace('_', ' ', $filter)); ?></label>
                        <select name="<?php echo $filter; ?>" id="<?php echo $filter; ?>" class="form-select"> <!-- Selects the filter -->
                            <option value="">Todos</option> 
                            <?php foreach ($filterOptions[$filter] as $value => $label): ?> <!-- Searches which options are in the filter -->
                            <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endforeach; ?>

                </div>

                <!-- I'm tired, its 00:14 and this are simple buttons -->
                <div class="mb-4">
                    <button type="submit" name="search" class="btn btn-primary">Buscar</button>
                    <button type="button" id="clearAll" class="btn btn-secondary">Clear All</button>
                </div>
            </form>
        </div>

        <?php if (!empty($summaryData)): ?>
        <div id="summary" class="mb-4 p-3 rounded d-flex justify-content-between align-items-center">
            <div class="summary-item">
                <h3><?php echo $summaryData['total_visits']; ?></h3>
                <p>Visitas</p>
            </div>
            <div class="summary-item">
                <h3><?php echo $summaryData['national_visits']; ?></h3>
                <p>No. Nacionales</p>
            </div>
            <div class="summary-item">
                <h3><?php echo $summaryData['foreign_visits']; ?></h3>
                <p>No. Extranjeros</p>
            </div>
            <div class="summary-item">
                <h3><?php echo $summaryData['first_language']; ?></h3>
                <p>Primera Lengua</p>
            </div>
            <div class="summary-item">
                <h3><?php echo $summaryData['second_language']; ?></h3>
                <p>Segunda Lengua</p>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($tableData)): ?>
        <div class="table-responsive">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <?php foreach (array_keys($tableData[0]) as $header): ?>
                        <th><?php echo $header; ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tableData as $row): ?>
                    <tr>
                        <?php foreach ($row as $cell): ?>
                        <td><?php echo $cell; ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>