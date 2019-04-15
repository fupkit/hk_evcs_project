<?php


class Station {
    private $no;
    private $location;
    private $type;
    private $lat;
    private $lng;
    public function __construct(){
    }

    public function to_string(){
        return "$this->no $this->location $this->type $this->lat $this->lng <BR>";
    }

    public function to_xml(){
        $xml = "<station>";
        $xml .= "<no>$this->no</no>";
        $xml .= "</station>";
        return $xml;
    }

    public function to_json(){
        $json = "{";
        $json .= "\"no\":$this->no,";
        $json .= "\"location\":\"$this->location\",";
        $json .= "\"type\":\"$this->type\",";
        $json .= "\"lat\":$this->lat,";
        $json .= "\"lng\":$this->lng";
        $json .= "}";
        return $json;
    }

    public function __get($name) {
        return $this->$name;
    }
}

?>