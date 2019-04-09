<?php
class District {
    private $area;
    private $name;
    public function __construct($a, $n)
    {
        $this->area = $a;
        $this->name = $n;
    }

    public function __get($name)
    {
        return $this->$name;
    }


    public function toString(){
        return "$this->area, $this->name";
    }
}
?>