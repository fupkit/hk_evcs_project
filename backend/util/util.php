<?php
function isNullOrEmptyString($str){
    return (!isset($str) || trim($str) === '');
}
?>