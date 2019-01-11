<?php
/**
 * Created by PhpStorm.
 * User: PhiTam
 * Date: 11/9/18
 * Time: 11:10 AM
 */
$servername = "localhost";
$username = "root";
$password = "rootss";
$db = "db_taka";

$con = mysqli_connect($servername, $username, $password, $db);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

?>