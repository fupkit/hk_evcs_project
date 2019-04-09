<?php
/**
 * Created by PhpStorm.
 * User: kwokyuho
 * Date: 3/25/2019
 * Time: 8:21 PM
 */

//1. foreign key?
//2. table already created?
//3. avoid duplication?

//path to clp's data
$path = "https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=EN";
//create a domdocument, load the data and extract information
$xmlDoc = new DOMDocument();
$xmlDoc->load($path);

include("station_class.php");
include("district_class.php");
include("database_helper_class.php");

$dbHelper = new DatabaseHelper();
//$dbHelper->create_district_table();
//$dbHelper->create_station_table();

$area = $xmlDoc->getElementsByTagName("area");
foreach($area as $a) {
    $a_na = $a->getElementsByTagName('name')->item(0)->nodeValue;
    $district = $a->getElementsByTagName("district");
    foreach($district as $d){
        $d_na = $d->getElementsByTagName('name')->item(0)->nodeValue;
        $district = new District($a_na, $d_na);
       // $dbHelper->insert_district($district);
        //echo $district->toString()."<BR>";
    }
}
echo "districts are inserted";
print("======<BR>");
$station = $xmlDoc->getElementsByTagName("station");
$station_arr = array();
foreach($station as $s){
    $no = $s->getElementsByTagName('no')->item(0)->nodeValue;
    $lo = $s->getElementsByTagName('location')->item(0)->nodeValue;
    $la =  $s->getElementsByTagName('lat')->item(0)->nodeValue;
    $ln = $s->getElementsByTagName('lng')->item(0)->nodeValue;
    $station = new Station($no, $lo, $la, $ln);
    //$dbHelper->insert_station($station);
    array_push($station_arr, $station);
}
$dbHelper->insert_stations($station_arr);
echo "stations are inserted";