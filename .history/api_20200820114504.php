<?php
    include_once './function.php';
    $function = $_GET['func'];

    switch($function){
        case 'databuku':
            call_user_func(getBuku(), '');
        break;
    }
    function getBuku(){
        $jenis = isset($_GET['jenis']) ? $_GET['jenis'] : 'semua';
        $data = getDataBuku($jenis, true);
        echo json_encode(['data' => $data]);
    }