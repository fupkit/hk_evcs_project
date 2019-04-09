<?php
/**
 * Created by PhpStorm.
 * User: kwokyuho
 * Date: 3/25/2019
 * Time: 8:32 PM
 */

class Station {
    private $no;
    private $location;
    private $lat;
    private $lng;

    function __construct($no, $lo, $la, $ln)
    {
        $this->no = $no;
        $this->location = $lo;
        $this->lat = $la;
        $this->lng = $ln;
    }

    function  __get($name)
    {
        return $this->$name;
    }

    function toString(){
        return "$this->no, $this->location";
    }
}




?>