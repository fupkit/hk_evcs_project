<?php

// Connect to the db
class Connection
{
    public function connect()
    {
        $host = 'localhost';
        $user = 'root';
        $pass = 'root';
        $db = 'evcs';
        $connection = mysqli_connect($host, $user, $pass, $db);
        return $connection;
    }
}
