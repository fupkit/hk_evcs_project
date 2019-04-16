<?php
class DBCreator
{
    private static $HTTP_DATA_SOURCE = 'https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=';

    private $conn;
    public function __construct()
    {
    }
    public function create($conn)
    {
        $this->conn = $conn;
        $create_sql = file_get_contents('evcs_create.sql');
        if ($this->dbImportSQL($create_sql) === true) {
            if (mysqli_select_db($this->conn, 'evcs')) {
                $this->get_en_data();
                $this->get_tc_data();
                echo "Database created successfully";
            }
        } else {
            echo "Error creating database: " . $this->conn->error;
        }
    }

    public function get_en_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE.'en');
        $this->insert_from_api($doc, 'en');
    }
    public function get_tc_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE.'tc');
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
                //echo  '<br>'.$d_id.' | '.$lang.' | '.$a_name.' | '.$d_name;
                $d_id++;
            }
        }
    }

    private function dbImportSQL($sql, $needle = '')
    {
        $sentences = explode($needle . ';', $sql);
        // PREPARE THE QUERIES
        $var_l = count($sentences);
        $s_temp = '';
        for ($var_k=0;$var_k<$var_l;$var_k++) {
            $s = $s_temp.$sentences[$var_k];
            if (!empty($s) && trim($s)!='') {
                $s .= $needle;
                $simple_comma = substr_count($s, "'");
                $scaped_simple_comma = substr_count($s, "\'");
                if (($simple_comma-$scaped_simple_comma)%2==0) {
                    $sentences[$var_k] = $s;
                    $s_temp = '';
                //echo "[OK] ".$s." <br />";
                } else {
                    unset($sentences[$var_k]);
                    $s_temp = $s.";";
                    //echo "[FAIL] ".$s." <br />";
                }
            } else {
                unset($sentences[$var_k]);
            }
        }

        foreach ($sentences as $s) {
            $s = trim($s);
            if (!empty($s)) {
                $s = trim($s);// . $needle;
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
