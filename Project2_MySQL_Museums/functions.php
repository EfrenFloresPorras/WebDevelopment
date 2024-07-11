<?php

function getFilterOptions($conn, $filter) {
    $query = "SELECT DISTINCT $filter FROM visitas ORDER BY $filter";
    $result = $conn->query($query);
    $options = [];
    while ($row = $result->fetch_assoc()) {
        $options[] = $row[$filter];
    }
    return $options;
}

function buildSearchQuery($postData) {
    $query = "SELECT * FROM visitas WHERE 1=1";
    foreach ($postData as $key => $value) {
        if ($value !== '' && $key !== 'search') {
            $query .= " AND $key = '$value'";
        }
    }
    return $query;
}

function getSummaryData($conn, $query) {
    $totalQuery = str_replace("SELECT *", "SELECT COUNT(*) as total", $query);
    $result = $conn->query($totalQuery);
    $totalVisits = $result->fetch_assoc()['total'];

    $nationalQuery = $query . " AND nacionalidad = 'México'";
    $nationalQuery = str_replace("SELECT *", "SELECT COUNT(*) as national", $nationalQuery);
    $result = $conn->query($nationalQuery);
    $nationalVisits = $result->fetch_assoc()['national'];

    $foreignVisits = $totalVisits - $nationalVisits;

    $languageQuery = str_replace("SELECT *", "SELECT primera_leng, COUNT(*) as count", $query);
    $languageQuery .= " GROUP BY primera_leng ORDER BY count DESC LIMIT 2";
    $result = $conn->query($languageQuery);
    $languages = $result->fetch_all(MYSQLI_ASSOC);

    return [
        'total_visits' => $totalVisits,
        'national_visits' => $nationalVisits,
        'foreign_visits' => $foreignVisits,
        'first_language' => $languages[0]['primera_leng'] ?? 'N/A',
        'second_language' => $languages[1]['primera_leng'] ?? 'N/A'
    ];
}

function getTableData($conn, $query) {
    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'Estado' => $row['estado'],
            'Sexo' => $row['sexo'],
            'Edad' => $row['edad'],
            'País de residencia' => $row['residencia'],
            'Nacionalidad' => $row['nacionalidad'],
            'Estudios' => $row['escolaridad'],
            'Grado' => $row['estado_escolar'],
            '1ra Lengua' => $row['primera_leng'],
            '2da Lengua' => $row['segunda_leng'],
            'Frecuencia' => $row['frecuencia_visita'],
            'Medio de Comunicación' => $row['medio_com'],
            'Motivo de Visita' => $row['motivo'],
            'Medio de Transporte' => $row['medio_transporte'],
            'Tipo de Acompañantes' => $row['tipo_grupo'],
            'Tamaño del Grupo' => $row['tamaño_grupo'],
            'Menores de 12 en el grupo' => $row['menores_grupo'],
            'Duración de visita [min]' => $row['duracion']
        ];
    }
    return $data;
}

?>