<?php

include('station_class.php');
include("district_class.php");
include("dbhelper_class.php");

extract($_SERVER);
$args = array();
if(isset($PATH_INFO)) {
    $args = explode("/", $PATH_INFO);
}

if( $REQUEST_METHOD == 'GET') {
    if(sizeof($args) > 1) {
        get_station($args[1]);
    } else {
        get_stations();
    }

} else if($REQUEST_METHOD == 'DELETE') {
    if(sizeof($args) > 1) {
        delete_station($args[1]);
    } else {
        print("prompt error");
    }
}

function delete_station($no){
    $dbhelper = new DBHelper();
    $result = $dbhelper->delete_station($no);
    echo $result;
}

function get_station($no){
    $dbhelper = new DBHelper();
    extract($_GET);
    $station = $dbhelper->get_station($no);
    if (isset($output)) {

    } else {
       if($station != null){
           print($station->to_json());
       } else {
           print("error");
       }
    }
}

function get_stations(){
    $dbhelper = new DBHelper();
    extract($_GET);

    if(isset($type)) {
        $stations = $dbhelper->get_stations($type);
    } else{
        $stations = $dbhelper->get_stations();
    }

    //json_encode($stations);
    if (isset($output)) {
        print("<stations>");
        for ($i = 0; $i < sizeof($stations); $i++) {
            $station = $stations[$i];
            print($station->to_xml());
        }
    } else {
        print("</stations>");
        print("{ \"stations\": [");
        for ($i = 0; $i < sizeof($stations); $i++) {
            $station = $stations[$i];
            print($station->to_json());
            if ($i != sizeof($stations) - 1) {
                print(",");
            }
        }
        print("] }");
    }
}

?>