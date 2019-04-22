<?php
require_once '../db/db_connector.php';
$requires = glob('../class/*.php');
foreach ($requires as $file) {
    require_once $file;
}
require_once '../util/util.php';

extract($_SERVER);
$args = array();
if (isset($PATH_INFO)) {
    $args = explode("/", $PATH_INFO);
}

$res = new stdClass();
if ($REQUEST_METHOD == 'GET') {
    if (sizeof($args) > 1) {
        $res->message = 'get ' . implode(', ', $args);
    } else {
        $res->message = 'get all';
    }

} else if ($REQUEST_METHOD == 'DELETE') {
    if (sizeof($args) > 1) {
        $res->message = 'DELETE  ' . implode(', ', $args);
    } else {
        $res->message = 'Please specify the station you want to delete!';
    }
} else if ($REQUEST_METHOD == 'PUT') {
    $sta = new Station();
    $sta->__set('id', $no);
    $sta->__set('location', $lo);
    $sta->__set('lat', $la);
    $sta->__set('lng', $ln);
    $sta->__set('type', $ty);
    $sta->__set('address', $ad);
    $sta->__set('districtL', $dl);
    $sta->__set('districtS', $ds);
    $sta->__set('provider', $pr);
    $sta->__set('parkingNo', $no);
    $sta->__set('img', $img);
    if (sizeof($args) > 1) {
        $data = json_decode(file_get_contents('php://input'), true);
        $res->message = 'PUT ' . implode(', ', $data);
    } else {
        $res->message = 'Please specify the station you want to update!';
    }

} else if ($REQUEST_METHOD == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $res->message = 'POST ' . implode(', ', $data);
}

echo json_encode($res);
