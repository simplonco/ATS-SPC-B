<?php

$host = 'localhost';
$db_user = 'root';
$db_password = 'simplonco';
$db_name = 'ATS_SPC';

try {
    $conn = new pdo("mysql:host=$host;dbname=$db_name", $db_user, $db_password);
} catch (PDOException $e) {
    echo 'not connected :'.$e->getMessage();
}
