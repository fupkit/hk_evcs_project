<?php
$requires = glob('../class/*.php');
foreach ($requires as $file) {
    require_once($file);   
}
require_once('../db/db_connnector.php');
require_once('../util/util.php');

extract($_SERVER);


?>