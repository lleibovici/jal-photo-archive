<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    $parentid = $_REQUEST['parentid'];
    $sql = "UPDATE albums SET parent = ? WHERE id = ?";
    $q = $dbh->prepare($sql);
    $q->execute([$parentid, $id]);
}