<?php
    include_once './function.php';
    $function = $_GET['func'];

    switch($function){
        case 'databuku':
            call_user_func(getBuku());
        break;
    }
    function getBuku(){
        $jenis = $_GET['jenis'];
        $data = getDataBuku($jenis, true);
        echo json_encode(['data' => $data]);
    }