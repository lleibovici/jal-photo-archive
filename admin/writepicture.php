<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['pictureidx'])) {
    $data = $_REQUEST['data'];
    $pidx= $_REQUEST['pictureidx'];
    $sql = "UPDATE pictures SET description = ? WHERE id=?";
    $q = $dbh->prepare($sql);
    $q->execute([$data,$pidx]);
}
//error_log($data);
header('Content-Type: text/plain');
