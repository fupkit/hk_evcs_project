<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Origin, Content-Type, Authorization, X-Auth-Token');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');

require_once '../db/station_dao.php';
$requires = glob('../class/*.php');
foreach ($requires as $file) {
    require_once $file;
}
$utils = glob('../util/*.php');
foreach ($utils as $file) {
    require_once $file;
}

extract($_SERVER);

$format='json';
$lang='en';
if (isset($_GET['format']) && (strtolower($_GET['format']) === 'json' || strtolower($_GET['format']) === 'xml')) {
    $format = strtolower($_GET['format']);
}
if (isset($_GET['lang']) && (strtolower($_GET['lang'])==='en' || strtolower($_GET['lang'])==='tc')) {
    $lang = strtolower($_GET['lang']);
}

$args = array();
if (isset($PATH_INFO)) {
    $args = explode("/", $PATH_INFO);
}
$res = new stdClass();
$stationDAO = new StationDAO();
if ($REQUEST_METHOD == 'GET') {
    if (isset($_GET['loc'])) {
        $res->stations = $stationDAO->get_by_loc($_GET['loc']);
    } elseif (sizeof($args) > 1) {
        $res->stations = $stationDAO->get_by_id($args[1]);
    } else {
        $res->stations = $stationDAO->get_all();
    }
} elseif ($REQUEST_METHOD == 'DELETE') {
    if (sizeof($args) > 1) {
        $result = $stationDAO->delete($args[1]);
        if ($result === true) {
            $res->result = true;
            $res->message = 'Delete success!';
        } else {
            $res->result = false;
            $res->message = $result;
        }
    } else {
        $res->result = false;
        $res->message = 'Please specify the station you want to delete!';
    }
} elseif ($REQUEST_METHOD == 'PUT') {
    if (sizeof($args) > 1) {
        $data = json_decode(file_get_contents('php://input'));
        $language = strtolower($data->station->lang);
        if ($language === 'en'  || $language ==='tc') {
            $result = $stationDAO->update($args[1], $language, $data->station);
            if ($result === true) {
                $res->result=true;
                $res->message = 'Update Success!';
            } else {
                $res->result= false;
                $res->message = $result;
            }
        } else {
            $res->result = false;
            $res->message = 'Please specify the station data language!';
        }
    } else {
        $res->result = false;
        $res->message = 'Please specify the station you want to update!';
    }
} elseif ($REQUEST_METHOD == 'POST') {
    $data = json_decode(file_get_contents('php://input'));
    $res->message = json_encode($data, JSON_UNESCAPED_SLASHES);
    $en_station = $data->station->en;
    $tc_station = $data->station->tc;
    $result = $stationDAO->insert($en_station, $tc_station);
    if ($result === true) {
        $res->result = true;
        $res->message = 'Insert Success!';
    } else {
        $res->result = false;
        $res->message = $result;
    }
}

if($format === 'xml') {
    echo XMLSerializer::generateValidXmlFromObj($res, 'data', 'station');
} else {
    echo json_encode($res, JSON_NUMERIC_CHECK);
}

