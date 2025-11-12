<?php
$actions = isset($_REQUEST['actions']) ? $_REQUEST['actions'] : null;

if ($actions == 1) {
    $start  = $_REQUEST['start'];
    $length = $_REQUEST['length'];
    $search = $_REQUEST['search']['value'];

    $vercontenidopagina = MetodoPagoData::vercontenidopaginado($start, $length, $search);
    $totalregistros = MetodoPagoData::totalregistros();
    $totalregistrosbuscados = MetodoPagoData::totalregistrosbuscados($search);

    $data = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => intval($totalregistros),
        "recordsFiltered" => intval($totalregistrosbuscados),
        "data" => $vercontenidopagina
    );

    echo json_encode($data);
    exit;
}

if ($actions == 2) { 
    $id = $_REQUEST['id'];
    $data = MetodoPagoData::verid($id);
    echo json_encode($data);
    exit;
}
?>
