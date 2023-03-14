<?php

$username = 'root';
$password = 'root';

$host = 'localhost';
$dbname = 'fewnews';

$dsn = "mysql:host=".$host.";dbname=".$dbname.";charset=utf8";

return $database = new PDO($dsn, $username, $password);