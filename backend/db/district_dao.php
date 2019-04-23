<?php
require_once('db_connector.php');
class DistrictDAO extends DBConnector
{
    const TABLE_NAME = 'district';
    public $mysqli;
    public function __construct()
    {
        $this->mysqli = DBConnector::getInstance()->connect_db();
    }

    public function get_district($lang)
    {
        $res = array();
        $sql = "SELECT * FROM ".self::TABLE_NAME." WHERE lang = '$lang'";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }


    public function get_area($lang)
    {
        $res = array();
        $sql = "SELECT area FROM ".self::TABLE_NAME." WHERE lang = '$lang' group by area";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }



  
}
