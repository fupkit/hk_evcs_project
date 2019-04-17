<?php


class Station {
    private $id;
    private $location;
    private $lat;
    private $lng;
    private $type;
    private $district_id;
    private $districtL;
    private $districtS;
    private $address;
    private $provider;
    private $parkingNo;
    private $img;
    public function __construct(){
    }

    public function __set($name, $value) {
        $this->$name = $value;
    }

    public function __get($name) {
        return $this->$name;
    }
}

?>