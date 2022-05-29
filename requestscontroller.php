<?php

function getAll($connect) {
    $watermellons = pg_query($connect, "SELECT * FROM \"public\".\"watermellons\"");

    $rows = [];

    while($row = pg_fetch_object($watermellons)) {
        //echo $row->id." ".$row->row_collumn." ".$row->status." ".$row->weight_gramms."</br>";
        $rows[] = $row;
    }

    echo json_encode($rows);
}

function getWm($connect, $wm){
    $watermellons = pg_query($connect, "SELECT * FROM \"public\".\"watermellons\" WHERE row_collumn[1] = $wm[0] AND row_collumn[2] = $wm[1]");

    if (pg_num_fields($watermellons) === 0){
        http_response_code(404);

        $ret = [
            "status" => false,
            "message" => "watermellon not found"];

        echo json_encode($ret);
    }else{
        $row = pg_fetch_object($watermellons);

        echo json_encode($row);
    }
    
}

function addWm($connect, $order, $id) {
    $address = $order['address'];
    $delivery_date = $order['delivery_date'];
    $phone_number = $order['phone_number'];
    pg_query($connect, "UPDATE \"public\".\"watermellons\" SET \"address\" = '".$address."' , \"delivery_date\" = '".$delivery_date."' , \"phone_number\" = '".$phone_number."' WHERE id = ".$id." ;");

    http_response_code(200);

    $ret = [
        "status" => true,
        "message" => "watermellon is ordered"];

    echo json_encode($ret);
}