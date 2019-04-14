<?php


class District {
    private $name;
    private $area;
    public function __construct($na, $ar){
        $this->name = $na;
        $this->area = $ar;
    }

    public function to_string(){
        return "$this->name - $this->area <BR>";
    }

    public function __get($name) {
        return $this->$name;
    }
}

?>