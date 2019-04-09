<?php
/**
 * Created by PhpStorm.
 * User: kwokyuho
 * Date: 3/25/2019
 * Time: 8:54 PM
 */

class DatabaseHelper {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "station";


    private function get_conn(){
        return new mysqli($this->host, $this->user, $this->pass, $this->db);
    }

    function create_district_table(){
        $conn = $this->get_conn();
        $query = "CREATE TABLE `station`.`district` ( `id` INT NOT NULL AUTO_INCREMENT , `area` TEXT NOT NULL , `name` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $conn->query($query);
        $conn->close();
        echo "district table created<br>";
    }

    function create_station_table() {
        $conn = $this->get_conn();
        $query = "CREATE TABLE `station`.`station` ( `id` INT NOT NULL AUTO_INCREMENT , `no` INT NOT NULL , `location` TEXT NOT NULL , `lat` DOUBLE NOT NULL , `lng` DOUBLE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $conn->query($query);
        $conn->close();
        echo "station table created<br>";
    }

    function insert_district($district){
        $conn = $this->get_conn();
        $query = "INSERT INTO `district` (`id`, `area`, `name`) VALUES (NULL, '".$district->area."', '".$district->name."');";
        $conn->query($query);
        $conn->close();

    }

    function insert_station($station){
        $conn = $this->get_conn();
        $query = "INSERT INTO `station` (`id`, `no`, `location`, `lat`, `lng`) VALUES (NULL, $station->no, '$station->location', $station->lat, $station->lng);";
        $conn->query($query);
        $conn->close();
    }

    function insert_stations($stations){
        $conn = $this->get_conn();
        $query = "";
        foreach($stations as $station){
            $query .= "INSERT INTO `station` (`id`, `no`, `location`, `lat`, `lng`) VALUES (NULL, $station->no, '$station->location', $station->lat, $station->lng); ";
        }
        //echo $query;
        $conn->multi_query($query);
        $conn->close();
    }
}
?>