<?php
header('Content-Type: application/json');

function cargarDatos() {
    $jsonData = file_get_contents('assets/visitas.json');
    return json_decode($jsonData, true);
}

function filtrarDatos($datos, $motivo) {
    if (empty($motivo)) {
        return $datos;
    }
    return array_filter($datos, function($item) use ($motivo) {
        $campoMotivo = 'MV_' . strtoupper($motivo);
        return isset($item[$campoMotivo]) && $item[$campoMotivo] == 1;
    });
}

function calcularEstadisticas($datos) {
    $nacionales = 0;
    $extranjeros = 0;
    $lenguas = [
        '1' => 0,
        '2' => 0,
        '3' => 0,
        '4' => 0,
        '5' => 0,
        '6' => 0,
        '7' => 0,
        '8' => 0,
        '9' => 0,
    ];

    foreach ($datos as $visita) {
        if ($visita['PAIS_RESID'] == '000') {
            $nacionales++;
        } else {
            $extranjeros++;
        }
        
        if (isset($lenguas[$visita['LENGUA_1']])) {
            $lenguas[$visita['LENGUA_1']]++;
        } 
        if (isset($lenguas[$visita['LENGUA_2']])) {
            $lenguas[$visita['LENGUA_2']]++;
        }
        if (isset($lenguas[$visita['LENGUA_3']])) {
            $lenguas[$visita['LENGUA_3']]++;
        }
        
    }

    arsort($lenguas);
    $topLenguas = array_slice(array_keys($lenguas), 0, 2);

    return [
        'nacionales' => $nacionales,
        'extranjeros' => $extranjeros,
        'topLenguas' => $topLenguas
    ];
}

function obtenerMotivosVisita($visita) {
    $motivos = [];
    $motivosVisita = [
        'Cultura General' => 'MV_CULTURA',
        'Acompañar a Alguien' => 'MV_ACOMP',
        'Aprender' => 'MV_APREND',
        'Escolar' => 'MV_ESCOLAR',
        'Laboral' => 'MV_LABORAL',
        'Conocer la Exposición' => 'MV_CONOCER',
        'Entretenimiento y Diversión' => 'MV_ENTRETE',
        'Ver el Edificio (o Zona)' => 'MV_EDIFICI',
        'Talleres o Cursos' => 'MV_TALLER',
        'otro' => 'MV_OTRO'
    ];

    foreach ($motivosVisita as $motivo => $campo) {
        if ($visita[$campo] == 1) {
            $motivos[] = $motivo;
        }
    }

    return implode(', ', $motivos);
}

$datos = cargarDatos();
$motivo = $_GET['motivo'] ?? '';
$datosFiltrados = filtrarDatos($datos, $motivo);
$estadisticas = calcularEstadisticas($datosFiltrados);

$datosMostrar = array_slice($datosFiltrados, 0, 1000); // Limitar a 1000 registros (para no saturar la tabla) y por tiemmpo
$datosTabla = array_map(function($visita) {
    return [
        'entidad' => $visita['ENT_REGIS'],
        'fecha' => $visita['ANIO_ESTAD'] . '-' . str_pad($visita['MES_ENTREV'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($visita['DIA_ENTREV'], 2, '0', STR_PAD_LEFT),
        'motivo' => obtenerMotivosVisita($visita),
        'pais_residencia' => $visita['PAIS_RESID'],
        'primera_lengua' => $visita['LENGUA_1']
    ];
}, $datosMostrar);

echo json_encode([
    'datos' => $datosTabla,
    'estadisticas' => $estadisticas
]);
?>