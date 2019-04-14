<?php
include("db_connector.php");
class DBCreator
{
    private static $HTTP_DATA_SOURCE = 'https://opendata.clp.com.hk/GetChargingSectionXML.aspx?lang=';
    private static $create_sql = file_get_contents('evcs_create.sql');
    public function __construct()
    {
    }
    public function create()
    {
        if ($conn->query($create_sql) === TRUE) {
            echo "Database created successfully";

        } else {
            echo "Error creating database: " . $conn->error;
        }
    }

    public function get_en_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE.'en');
        $areas = $doc->getElementsByTagName("area");
        $stations = $doc->getElementsByTagName("station");
        foreach($areas as $area){
            $a_name = $area->getElementsByTagName("name")[0]->nodeValue;
            $districts = $area->getElementsByTagName("district");
            foreach($districts as $district) {
                $d_name = $district->getElementsByTagName("name")[0]->nodeValue;
                $dis = new District($d_name, $a_name);
                $dbHelper->insert_district($dis);
                echo "inserted: " . $dis->to_string();
            }
        }
    }
    public function get_tc_data()
    {
        $doc = new DOMDocument();
        $doc->load(self::$HTTP_DATA_SOURCE.'tc');
        $areas = $doc->getElementsByTagName("area");
        $stations = $doc->getElementsByTagName("station");

    }
}
