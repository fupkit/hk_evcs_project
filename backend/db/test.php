<?php
require_once 'db_connector.php';

$dbc = DBConnector::getInstance();
$conn = $dbc->connect_db();
$sql = "SELECT * FROM `evcs`.`district`";
$result = $conn->query($sql);
$station_arr = array();
while ($row = $result->fetch_assoc()) {
    $no = $row["id"];
    $lo = $row["lang"];
    $ty = $row["area"];
    $la = $row["district"];
    echo ('<br>' . $no . ' | ' . $lo . ' | ' . $ty . ' | ' . $la);
}
$conn->close();
