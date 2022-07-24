<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['sortorder'])) {
    $sortOrder = $_REQUEST['sortorder'];
    $n = count($sortOrder);
    for ($i = 0; $i < $n; $i++) {
        $id = $sortOrder[$i];
        $so = $i + 1;
        //$sql = "UPDATE pictures SET sortorder=" . $so . " WHERE id=" . $id;
        $sql = "UPDATE pictures SET sortorder=? WHERE id=?";
        $q = $dbh->prepare($sql);
        $q->execute([$so, $id]);
        //error_log($sql);
    }
}