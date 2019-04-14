<?php

class DBHelper {
    private $host = "localhost";
    private $user = "root";
    private $pwd = "";
    private $db = "evcs";

    public function create_area_table(){
        $conn = $this->get_connection();
        $sql = "CREATE TABLE `evcs`.`district` ( `id` INT NOT NULL AUTO_INCREMENT , `name` TEXT NOT NULL , `area` TEXT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
        $conn->query($sql);
        $conn->close();
    }

    public function insert_stations($stations)
    {
        $conn = $this->get_connection();
        $sql = "";
        foreach ($stations as $station) {
            $sql .= "INSERT INTO `station` (`no`, `location`, `type`, `lat`, `lng`) VALUES ('$station->no', '$station->location', '$station->type', '$station->lat', '$station->lng');";
        }
        $conn->multi_query($sql);
        $conn->close();
    }

    public function insert_station($station) {
        $conn = $this->get_connection();
        $sql = "INSERT INTO `station` (`no`, `location`, `type`, `lat`, `lng`) VALUES ('$station->no', '$station->location', '$station->type', '$station->lat', '$station->lng');";
        $conn->query($sql);
        $conn->close();
    }

    public function insert_district($district) {
        $conn = $this->get_connection();
        $sql = "INSERT INTO `district` (`id`, `name`, `area`) VALUES (NULL, '$district->name', '$district->area')";
        $conn->query($sql);
        $conn->close();
    }

    public function create_station_table(){
        $conn = $this->get_connection();
        $sql = "CREATE TABLE `evcs`.`station` ( `no` INT NOT NULL AUTO_INCREMENT , `location` TEXT NOT NULL , `type` TEXT NOT NULL , `lat` INT NOT NULL , `lng` DOUBLE NOT NULL , PRIMARY KEY (`no`)) ENGINE = InnoDB;";
        $conn->query($sql);
        $conn->close();
    }

    public function get_connection(){
        $conn = new mysqli($this->host, $this->user,
            $this->pwd, $this->db);
        return $conn;
    }

    public function get_stations($type=""){
        $conn = $this->get_connection();
        $sql = "SELECT * FROM `evcs`.`station`";
        if($type != ""){{
            $sql .= " where type like '%$type%'";
        }}
        $result = $conn->query($sql);
        $station_arr = array();
        while($row = $result->fetch_assoc()) {
            $no = $row["no"];
            $lo = $row["location"];
            $ty = $row["type"];
            $la = $row["lat"];
            $ln = $row["lng"];
            $station = new Station($no, $lo, $ty, $la, $ln);
            array_push($station_arr, $station);
        }
        $conn->close();
        return $station_arr;
    }

    public function get_station($no){
        $conn = $this->get_connection();
        $sql = "SELECT * FROM `evcs`.`station` where no = $no";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()) {
            $no = $row["no"];
            $lo = $row["location"];
            $ty = $row["type"];
            $la = $row["lat"];
            $ln = $row["lng"];
            $station = new Station($no, $lo, $ty, $la, $ln);
            $conn->close();
            return $station;
        }
        $conn->close();
        return null;
    }

    public function delete_station($no){
        $conn = $this->get_connection();
        $sql = "DELETE FROM `evcs`.`station` where no = $no";
        $result = $conn->query($sql);
        return "{\"success\":true}";
    }
}

?>