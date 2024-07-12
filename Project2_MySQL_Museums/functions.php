<?php

function getFilterOptions($conn, $filter) {
    $tableMap = [
        'medio_transporte' => 'transporte',
        'tipo_grupo' => 'relacion',
        'motivo' => 'motivos',
        'residencia' => 'pais',
        'nacionalidad' => 'pais',
        'primera_leng' => 'lenguaje',
        'segunda_leng' => 'lenguaje',
        'frecuencia_visita' => 'frec_visita',
        'estado' => 'estado',
        'medio_com' => 'comunicacion',
        'escolaridad' => 'escolaridad',
        'estado_escolar' => 'escolaridad'
    ];

    $possibleNameColumns = ['Nombre', 'nombre', 'name', 'Descripcion', 'descripcion', 'Rango', 'rango', 'Medio', 'medio', 'Motivo', 'motivo', 'Grado', 'grado'];

    if (isset($tableMap[$filter])) {
        $table = $tableMap[$filter];
        
        // Get the column names for this table
        $columnQuery = "SHOW COLUMNS FROM $table";
        $columnResult = $conn->query($columnQuery);
        $columns = [];
        while ($row = $columnResult->fetch_assoc()) {
            $columns[] = $row['Field'];
        }

        // Find the first matching column name
        $nameColumn = 'ID'; // Default to ID if no match found
        foreach ($possibleNameColumns as $possibleColumn) {
            if (in_array($possibleColumn, $columns)) {
                $nameColumn = $possibleColumn;
                break;
            }
        }

        $query = "SELECT ID, $nameColumn FROM $table ORDER BY $nameColumn";
    } else {
        $query = "SELECT DISTINCT $filter FROM visitas ORDER BY $filter";
    }

    $result = $conn->query($query);
    if (!$result) {
        die("Error in query: " . $conn->error);
    }

    $options = [];
    while ($row = $result->fetch_assoc()) {
        if (isset($row['ID']) && isset($row[$nameColumn])) {
            $options[$row['ID']] = $row[$nameColumn];
        } else {
            $options[$row[$filter]] = $row[$filter];
        }
    }
    return $options;
}

function buildSearchQuery($postData) {
    $query = "SELECT v.* FROM visitas v";
    $joins = [];
    $conditions = [];

    $tableMap = [
        'medio_transporte' => 'transporte',
        'tipo_grupo' => 'relacion',
        'motivo' => 'motivos',
        'residencia' => 'pais',
        'nacionalidad' => 'pais',
        'primera_leng' => 'lenguaje',
        'segunda_leng' => 'lenguaje',
        'frecuencia_visita' => 'frec_visita',
        'estado' => 'estado',
        'medio_com' => 'comunicacion',
        'escolaridad' => 'escolaridad',
        'estado_escolar' => 'escolaridad'
    ];

    foreach ($postData as $key => $value) {
        if ($value !== '' && $key !== 'search') {
            if (isset($tableMap[$key])) {
                $table = $tableMap[$key];
                $alias = substr($table, 0, 1);
                $joins[] = "LEFT JOIN $table $alias ON v.$key = $alias.ID";
                $conditions[] = "$alias.Nombre = '$value'";
            } else {
                $conditions[] = "v.$key = '$value'";
            }
        }
    }

    if (!empty($joins)) {
        $query .= ' ' . implode(' ', $joins);
    }

    if (!empty($conditions)) {
        $query .= ' WHERE ' . implode(' AND ', $conditions);
    }

    return $query;
}

function getSummaryData($conn, $query) {
    $totalQuery = str_replace("SELECT v.*", "SELECT COUNT(*) as total", $query);
    $result = $conn->query($totalQuery);
    $totalVisits = $result->fetch_assoc()['total'];

    $hasWhere = stripos($query, 'WHERE') !== false;
    
    $mexicoQuery = preg_replace('/^SELECT.*?FROM/is', 'SELECT COUNT(*) as mexico FROM', $query);
    $mexicoCondition = "v.nacionalidad IN (SELECT ID FROM pais WHERE Nombre = 'México')";
    if ($hasWhere) {
        $mexicoQuery .= " AND $mexicoCondition";
    } else {
        $mexicoQuery .= " WHERE $mexicoCondition";
    }
    
    $result = $conn->query($mexicoQuery);
    if (!$result) {
        die("Error in Mexico query: " . $conn->error);
    }
    $mexicoVisits = $result->fetch_assoc()['mexico'];
    echo $mexicoVisits;

    $foreignVisits = $totalVisits - $mexicoVisits;

    $languageQuery = str_replace("SELECT v.*", "SELECT l.Nombre as primera_leng, COUNT(*) as count", $query);
    $languageQuery .= " LEFT JOIN lenguaje l ON v.primera_leng = l.ID GROUP BY l.Nombre ORDER BY count DESC LIMIT 2";
    $result = $conn->query($languageQuery);
    $languages = $result->fetch_all(MYSQLI_ASSOC);

    return [
        'total_visits' => $totalVisits,
        'national_visits' => $mexicoVisits,
        'foreign_visits' => $foreignVisits,
        'first_language' => $languages[0]['primera_leng'] ?? 'N/A',
        'second_language' => $languages[1]['primera_leng'] ?? 'N/A'
    ];
}

function getTableData($conn, $query) {
    $query = str_replace("SELECT v.*", "SELECT 
        e.Nombre as Estado,
        v.sexo as Sexo,
        v.edad as Edad,
        p1.Nombre as 'País de residencia',
        p2.Nombre as Nacionalidad,
        esc.Grado as Estudios,
        v.estado_escolar as Grado,
        l1.Nombre as '1ra Lengua',
        l2.Nombre as '2da Lengua',
        fv.Rango as Frecuencia,
        c.Medio as 'Medio de Comunicación',
        m.Motivo as 'Motivo de Visita',
        t.Nombre as 'Medio de Transporte',
        r.Nombre as 'Tipo de Acompañantes',
        v.tamaño_grupo as 'Tamaño del Grupo',
        v.menores_grupo as 'Menores de 12 en el grupo',
        v.duracion as 'Duración de visita [min]'", $query);

    $query .= " LEFT JOIN estado e ON v.estado = e.ID
                LEFT JOIN pais p1 ON v.residencia = p1.ID
                LEFT JOIN pais p2 ON v.nacionalidad = p2.ID
                LEFT JOIN escolaridad esc ON v.escolaridad = esc.ID
                LEFT JOIN lenguaje l1 ON v.primera_leng = l1.ID
                LEFT JOIN lenguaje l2 ON v.segunda_leng = l2.ID
                LEFT JOIN frec_visita fv ON v.frecuencia_visita = fv.ID
                LEFT JOIN comunicacion c ON v.medio_com = c.ID
                LEFT JOIN motivos m ON v.motivo = m.ID
                LEFT JOIN transporte t ON v.medio_transporte = t.ID
                LEFT JOIN relacion r ON v.tipo_grupo = r.ID";

    $result = $conn->query($query);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

?>