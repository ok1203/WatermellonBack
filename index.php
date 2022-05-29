<?php 

header('Content-type: json/application');
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, PATCH');
header("Access-Control-Allow-Headers: *");
header ("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
header ("Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Accept-Language, X-Authorization");
header('Access-Control-Max-Age: 86400');

$connect = pg_connect("host = localhost port=5432 dbname = postgres user = postgres");

require 'requestscontroller.php';

$method = $_SERVER['REQUEST_METHOD'];
$request = $_GET['q'];
$requestParams = explode('/', $request);
$type = $requestParams[0];
$wm = [];
$wm[0] = $requestParams[1];
$wm[1] = $requestParams[2];


if($method === "GET"){
    if($type === 'watermellons'){

        if(isset($wm[0])){
            getWm($connect, $wm);
        } else {
            getAll($connect);
        }
    }
} elseif ($method === "PATCH") {
    if($type === "watermellons"){
        if(isset($wm[0])){
            $order = file_get_contents('php://input');
            $order = json_decode($order, true);
            addWm($connect, $order, $wm[0]);
        }
        addWm($connect, $_POST);
    }
}

pg_close($connect);