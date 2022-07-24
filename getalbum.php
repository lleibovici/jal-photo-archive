<?php
$albumname = $_REQUEST['album'];

require_once('config.php');

$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$sql = 'SELECT * FROM pictures WHERE album = ? ORDER BY modified';
//error_log($sql);
$sth = $dbh->prepare($sql);
$sth->execute([$albumname]);
//$dir = 'img/' . $_REQUEST['album'];
$filenames = array();
while ($row = $sth->fetch()) {
    array_push($filenames,$row['filename']);
}
//$sth->finish();
$sql = "SELECT * FROM albums WHERE album= ?";
//zerror_log($sql);
$sth1 = $dbh->prepare($sql);
$sth1->execute([$albumname]);
$row = $sth1->fetch();
$album['albumname'] = $row['album'];
$album['description'] = $row['description'];
$ret = [];
array_push($ret,$album);
array_push($ret,$filenames);
header('Content-type: application/json');
echo json_encode($ret);