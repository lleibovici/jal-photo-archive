<?php
$pictureidx = $_REQUEST['pictureidx'];


require_once('config.php');

$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$sql = 'SELECT * FROM pictures WHERE id = ?';
//error_log($sql);
$sth = $dbh->prepare($sql);
$sth->execute([$pictureidx]);
$row = $sth->fetch(PDO::FETCH_ASSOC);
header('Content-type: application/json');
echo json_encode($row);