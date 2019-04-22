<?php
require_once('db_connector.php');
class StationDAO extends DBConnector
{
    const TABLE_NAME = 'station';
    public $mysqli;
    public function __construct()
    {
        $this->mysqli = DBConnector::getInstance()->connect_db();
    }

    public function insert($en_station, $tc_station)
    {
        $this->mysqli->query("START TRANSACTION");
        $en_sql = "INSERT INTO ".self::TABLE_NAME." (id, lang, district_id, location, lat, lng, type, address, provider, parkingNo, img) VALUES 
            ((SELECT IFNULL(MAX(number), 0) + 1 FROM ".self::TABLE_NAME."), 'en', (SELECT id FROM district WHERE area = '$en_station->districtL' AND district = '$en_station->districtS' and lang = 'en')
            '$en_station->location', $en_station->lat, $en_station->lng, '$en_station->type', '$en_station->address', '$en_station->provider', '$en_station->parkingNo', '$en_station->img')";
        $tc_sql = "INSERT INTO ".self::TABLE_NAME." (id, lang, district_id, location, lat, lng, type, address, provider, parkingNo, img) VALUES 
            ((SELECT IFNULL(MAX(number), 0) + 1 FROM ".self::TABLE_NAME."), 'tc', (SELECT id FROM district WHERE area = '$tc_station->districtL' AND district = '$tc_station->districtS' and lang = 'tc')
            '$tc_station->location', $tc_station->lat, $tc_station->lng, '$tc_station->type', '$tc_station->address', '$tc_station->provider', '$tc_station->parkingNo', '$tc_station->img')";
        if ($this->mysqli->query($en_sql) && $this->mysqli->query($tc_sql)) {
            $this->mysqli->query("COMMIT");
        } else {
            $this->mysqli->query("ROLLBACK");
            return mysqli_error($this->mysqli);
        }
    }

    public function update($id, $lang, $station)
    {
        if ($lang == 'en' || $lang == 'tc') {
            $i = 0;
            foreach ($station as $key => $value) {
                if ($value != null && $key != 'id') {
                    $i++;
                }
            }
            if ($i > 0) {
                $j = 0;
                $sql = "UPDATE ".self::TABLE_NAME." SET (";
                foreach ($station as $key => $value) {
                    if ($value != null && $key != 'id') {
                        if ($key != 'districtL' && $key != 'districtS' && $key != 'id') {
                            $sql .= "$key = '$value'";
                        } elseif ($key == 'districtS') {
                            $sql .= "district_id = (SELECT id FROM district WHERE area = '$station->districtL' AND district = '$station_districtS' LIMIT 1)";
                        }
                        $j++;
                        if ($j < $i) {
                            $sql .= ", ";
                        } else {
                            $sql .= ") ";
                        }
                    }
                }
                $sql .= "WHERE id = $id AND lang = $lang";
            } else {
                return 'Invalid parameters!';
            }
        } else {
            return 'Bad Language support : '.$lang;
        }
    }

    public function get_by_loc($loc_name)
    {
        $res = array();
        $sql = "SELECT S.*, D.* FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id".
        " WHERE D.area LIKE '%$loc_name%' OR D.district LIKE '%$loc_name%' OR S.address LIKE D.area LIKE '%$loc_name%'";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }

    public function get_all()
    {
        $res = array();
        $sql = "SELECT S.*, D.* FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }

    public function get_by_id($id)
    {
        $res = array();
        $sql = "SELECT S.*, D.* FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id".
        " WHERE D.id = $id";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }
}
