<?php
/**
 * Created by PhpStorm.
 * User: kwokyuho
 * Date: 3/29/2019
 * Time: 8:07 PM
 */

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