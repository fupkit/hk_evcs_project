<?php


class District {
    private $id;
    private $name;
    private $area;
    private $lang;
    public function __construct(){
    }

    public function to_string(){
        return "$this->name - $this->area <BR>";
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($property, $value) {
            $this->$property = $value;
    }
}

?>