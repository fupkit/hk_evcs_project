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
        $id = 1;
        $id_sql = "SELECT IFNULL(MAX(id), 0) + 1 AS id FROM ".self::TABLE_NAME;
        if ($result = $this->mysqli->query($id_sql)) {
            while ($row = mysqli_fetch_object($result)) {
                $id = $row->id;
            }
        }
        $en_sql = "INSERT INTO ".self::TABLE_NAME." (id, lang, district_id, location, lat, lng, type, address, provider, parkingNo, img) VALUES 
            ($id, 'en', (SELECT id FROM district WHERE area = '$en_station->districtL' AND district = '$en_station->districtS' and lang = 'en'),
            '$en_station->location', $en_station->lat, $en_station->lng, '$en_station->type', '$en_station->address', '$en_station->provider', '$en_station->parkingNo', '$en_station->img')";
        $tc_sql = "INSERT INTO ".self::TABLE_NAME." (id, lang, district_id, location, lat, lng, type, address, provider, parkingNo, img) VALUES 
            ($id, 'tc', (SELECT id FROM district WHERE area = '$tc_station->districtL' AND district = '$tc_station->districtS' and lang = 'tc'),
            '$tc_station->location', $tc_station->lat, $tc_station->lng, '$tc_station->type', '$tc_station->address', '$tc_station->provider', '$tc_station->parkingNo', '$tc_station->img')";
        if ($this->mysqli->query($en_sql) && $this->mysqli->query($tc_sql)) {
            $this->mysqli->query("COMMIT");
            return true;
        } else {
            $res = mysqli_error($this->mysqli);
            $this->mysqli->query("ROLLBACK");
            return $res;
        }
    }

    public function update($id, $lang, $station)
    {
        if ($lang == 'en' || $lang == 'tc') {
            $i = 0;
            foreach ($station as $key => $value) {
                if ($value != null && $key != 'id' && $key != 'lang') {
                    $i++;
                }
            }

            if ($i > 0) {
                $j = 0;
                $sql = "UPDATE ".self::TABLE_NAME." SET ";
                foreach ($station as $key => $value) {
                    if ($value != null && $key != 'id' && $key != 'lang') {
                        if ($key != 'districtL' && $key != 'districtS') {
                            $sql .= "$key = '$value'";
                            $j++;
                            if ($j+1 < $i) {
                                $sql .= ", ";
                            }
                        } elseif ($key == 'districtS') {
                            $sql .= "district_id = (SELECT id FROM district WHERE area = '$station->districtL' AND district = '$station->districtS' LIMIT 1)";
                            $j++;
                            if ($j+1 < $i) {
                                $sql .= ", ";
                            }
                        }
                        
                        
                    }
                }
                $sql .= "WHERE id = $id AND lang = '$lang'";
                if ($this->mysqli->query($sql)) {
                    return true;
                } else {
                    return mysqli_error($this->mysqli);
                }
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
        $sql = "SELECT S.*, D.area AS districtL, D.district AS districtS FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id AND D.lang = S.lang".
        " WHERE LOWER(D.area) LIKE '%$loc_name%' OR LOWER(D.district) LIKE '%$loc_name%' OR LOWER(S.address) LIKE '%$loc_name%'";
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
        $sql = "SELECT S.*, D.area AS districtL, D.district AS districtS  FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id AND D.lang = S.lang ORDER BY S.id ASC";
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
        $sql = "SELECT S.*, D.area AS districtL, D.district AS districtS  FROM ".self::TABLE_NAME." S"
        ." LEFT JOIN district D ON S.district_id = D.id AND D.lang = S.lang".
        " WHERE S.id = $id";
        if ($result = $this->mysqli->query($sql)) {
            while ($row = mysqli_fetch_object($result)) {
                array_push($res, $row);
            }
        }
        return $res;
    }

    public function delete($id) {
        $sql = "DELETE FROM station WHERE id = $id";
        if ($this->mysqli->query($sql)) {
            return true;
        } else {
            return mysqli_error($this->mysqli);
        }
    }
}
