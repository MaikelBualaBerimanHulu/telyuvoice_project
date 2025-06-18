<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "telyuvoice";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    die ("Gagal tersambung dalam database!");
}
?>