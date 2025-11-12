<?php
$actions = isset($_REQUEST['actions']) ? $_REQUEST['actions'] : null;
if($actions==1){
    $start = $_REQUEST['start'];
    $length = $_REQUEST['length'];      
    $search = $_REQUEST['search']['value'];

    $vercontenidopagina = ClienteData::vercontenidopaginado($start, $length, $search);
    $totalregistros = ClienteData::totalregistros();
    $totalregistrosbuscados = ClienteData::totalregistrosbuscados($search);
    $data = array(
        "draw" => intval($_REQUEST['draw']),
        "recordsTotal" => intval($totalregistros),
        "recordsFiltered" => intval($totalregistrosbuscados),
        "data" => $vercontenidopagina
    );
    echo json_encode($data);
    exit;
}
if($actions==2){
    $id = $_REQUEST['id'];
    $data = ClienteData::verid($id);
    echo json_encode($data);
    exit;
}
?>