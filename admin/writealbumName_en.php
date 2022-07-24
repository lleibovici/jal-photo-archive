<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['album'])) {
    $data = $_REQUEST['data'];
    $album= $_REQUEST['album'];
    $sql = "UPDATE albums SET name_en =? WHERE album=?";
    $q = $dbh->prepare($sql);
    $q->execute([$data,$album]);
}
header('Content-Type: text/plain');
