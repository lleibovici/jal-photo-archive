<?php
$albumname = $_REQUEST['album'];

require_once('config.php');

$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$sql = 'SELECT * FROM videos WHERE album = ? ORDER BY sortorder';
//error_log($sql);
$sth = $dbh->prepare($sql);
$sth->execute([$albumname]);
//$dir = 'img/' . $_REQUEST['album'];
$videos = array();
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    array_push($videos,$row);
}
//$sth->finish();
$sql = "SELECT * FROM albums WHERE album= ?";
//zerror_log($sql);
$sth1 = $dbh->prepare($sql);
$sth1->execute([$albumname]);
$row = $sth1->fetch();
$album['albumname'] = $row['album'];
$album['description'] = $row['description'];
$album['description_en'] = $row['description_en'];
$album['name-en'] = $row['name_en'];
$album['albumtype'] = $row['albumtype'];
$ret = [];
array_push($ret,$album);
array_push($ret,$videos);
header('Content-type: application/json');
echo json_encode($ret);