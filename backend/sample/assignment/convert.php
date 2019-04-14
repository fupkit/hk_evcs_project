<?php

$doc = new DOMDocument();
$doc->load("https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=en");

$areas = $doc->getElementsByTagName("area");
$stations = $doc->getElementsByTagName("station");

include("district_class.php");
include("station_class.php");
include("dbhelper_class.php");
$dbHelper = new DBHelper();
$dbHelper->create_area_table();
$dbHelper->create_station_table();

foreach($areas as $area){
    $a_name = $area->getElementsByTagName("name")[0]->nodeValue;
    $districts = $area->getElementsByTagName("district");
    foreach($districts as $district) {
        $d_name = $district->getElementsByTagName("name")[0]->nodeValue;
        $dis = new District($d_name, $a_name);
        $dbHelper->insert_district($dis);
        echo "inserted: " . $dis->to_string();
    }
}

$station_arr = array();
foreach($stations as $station){
    $no = $station->getElementsByTagName("no")[0]->nodeValue;
    $lo = $station->getElementsByTagName("location")[0]->nodeValue;
    $ty = $station->getElementsByTagName("type")[0]->nodeValue;
    $la = $station->getElementsByTagName("lat")[0]->nodeValue;
    $ln = $station->getElementsByTagName("lng")[0]->nodeValue;

    $sta = new Station($no, $lo, $ty, $la, $ln);
    //$dbHelper->insert_station($sta);
    //echo "inserted: " . $sta->to_string();
    //array_push($station_arr, $sta);
}

//$dbHelper->insert_stations($station_arr);
echo "all stations inserted <BR>";

?>