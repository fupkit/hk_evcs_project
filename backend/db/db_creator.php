<?php

require_once('../util/util.php');

class DBCreator
{
    private static $HTTP_DATA_SOURCE = 'https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=';
    private static $STATION_URL_PREFIX = 'https://www.clp.com.hk';
    private $conn;
    public function __construct()
    {
    }
    public function create($conn)
    {
        $this->conn = $conn;
        $create_sql = file_get_contents("../db/evcs_create.sql");
        if ($this->dbImportSQL($create_sql) === true) {
            if (mysqli_select_db($this->conn, 'evcs')) {
                $this->get_en_data();
                $this->get_tc_data();
            }
        } else {
            echo "Error creating database: " . $this->conn->error;
        }
    }

    public function get_en_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE . 'en');
        $this->insert_from_api($doc, 'en');
    }
    public function get_tc_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE . 'tc');
        $this->insert_from_api($doc, 'tc');
    }
    private function insert_from_api($doc, $lang)
    {
        $a_id = 1;
        $d_id = 1;
        $areas = $doc->getElementsByTagName("area");
        $stations = $doc->getElementsByTagName("station");
        foreach ($areas as $area) {
            $a_name = $area->getElementsByTagName("name")[0]->nodeValue;
            $districts = $area->getElementsByTagName("district");
            foreach ($districts as $district) {
                $d_name = $district->getElementsByTagName("name")[0]->nodeValue;
                $sql = 'insert into district (id, lang, area, district) values (?, ?, ?, ?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("dsss", $d_id, $lang, $a_name, $d_name);
                $stmt->execute();
                $stmt->close();
                $d_id++;
            }

            foreach ($stations as $station) {
                $no = $station->getElementsByTagName("no")[0]->nodeValue;
                $lo = $station->getElementsByTagName("location")[0]->nodeValue;
                $la = $station->getElementsByTagName("lat")[0]->nodeValue;
                $ln = $station->getElementsByTagName("lng")[0]->nodeValue;
                $ty = $station->getElementsByTagName("type")[0]->nodeValue;
                $dl = $station->getElementsByTagName("districtL")[0]->nodeValue;
                $ds = $station->getElementsByTagName("districtS")[0]->nodeValue;
                $ad = $station->getElementsByTagName("address")[0]->nodeValue;
                $pr = $station->getElementsByTagName("provider")[0]->nodeValue;
                $pa = $station->getElementsByTagName("parkingNo")[0]->nodeValue;
                $img = '';
                if (!isNullOrEmptyString($station->getElementsByTagName("img")[0]->nodeValue)) {
                    $img = self::$STATION_URL_PREFIX.$station->getElementsByTagName("img")[0]->nodeValue;
                }
                
                


                $sql = 'insert into station (id, lang,  location, lat, lng, type, address, district_id, provider, parkingNo, img) 
                values (?, ?, ?, ?, 
                ?, ?, ?, 
                (select id from district where area = ? and district = ? and lang = ?),
                 ?, ?, ?)';
                $stmt = $this->conn->prepare($sql);
                $stmt->bind_param("dssddssssssss", $no, $lang, $lo, $la, $ln, $ty, $ad, $dl, $ds, $lang, $pr, $no, $img);
                $stmt->execute();
                $stmt->close();
            }
        }
    }

    private function dbImportSQL($sql, $needle = '')
    {
        $sentences = explode($needle . ';', $sql);
        // PREPARE THE QUERIES
        $var_l = count($sentences);
        $s_temp = '';
        for ($var_k = 0; $var_k < $var_l; $var_k++) {
            $s = $s_temp . $sentences[$var_k];
            if (!empty($s) && trim($s) != '') {
                $s .= $needle;
                $simple_comma = substr_count($s, "'");
                $scaped_simple_comma = substr_count($s, "\'");
                if (($simple_comma - $scaped_simple_comma) % 2 == 0) {
                    $sentences[$var_k] = $s;
                    $s_temp = '';
                //echo "[OK] ".$s." <br />";
                } else {
                    unset($sentences[$var_k]);
                    $s_temp = $s . ";";
                    //echo "[FAIL] ".$s." <br />";
                }
            } else {
                unset($sentences[$var_k]);
            }
        }

        foreach ($sentences as $s) {
            $s = trim($s);
            if (!empty($s)) {
                $s = trim($s); // . $needle;
                $this->conn->query($s);
            }
        }
        $conn_errno = $this->conn->errno;

        if ($conn_errno != 0) {
            return false;
        }
        return true;
    }
}
