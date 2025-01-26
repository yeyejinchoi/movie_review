<?php

$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'siss';

$db_conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$db_conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
