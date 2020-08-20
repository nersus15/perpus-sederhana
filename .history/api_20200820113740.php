<?php
    include_once './function.php';
    function getBuku(){
        $jenis = $_GET['jenis'];
        $data = getDataBuku($jenis, true);
        echo json_encode(['data' => $data]);
    }