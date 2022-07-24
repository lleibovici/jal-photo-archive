<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['data'])) {
    $data = $_REQUEST['data'];
    $page= $_REQUEST['page'];
    $sql = "INSERT INTO pagetext (page,text) VALUES(?,?)";
    $q = $dbh->prepare($sql);
    $q->execute([$page,$data]);
}
//error_log($data);
header('Content-Type: text/plain');
