<?php
header('Access-Control-Allow-Origin: *');
require_once '../db/district_dao.php';
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
$districtDAO = new DistrictDAO();
if ($REQUEST_METHOD == 'GET') {
    if (sizeof($args) > 1) {
        if($args[1] === 'area') {
            $res->areas = $districtDAO->get_area($lang);
            $res->result = true;
        } else {
            $res->districts = $districtDAO->get_district($lang);
            $res->result = true;
        }
    } else {
        $res->districts = $districtDAO->get_district($lang);
        $res->result = true;
    }
} else {
    $res->result = false;
    $res->message = 'Invalid http method! Only GET is accepted.';
}

if ($format === 'xml') {
    echo XMLSerializer::generateValidXmlFromObj($res, 'data', 'station');
} else {
    echo json_encode($res, JSON_NUMERIC_CHECK);
}
