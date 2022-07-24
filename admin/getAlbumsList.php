<?php
session_start();
$loggedin = false;
if (isset($_SESSION['loggedin'])) {
    $loggedin = true;
}
require_once('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$sql = 'SELECT albums.id, albums.album, albums.private, albums.description, albums.description_en, albums.name_en, albums.parent FROM albums WHERE albums.albumtype = 0 ORDER BY albums.parent, albums.sortorder';
$sth = $dbh->query($sql);

$albumArray = [];

while ($row = $sth->fetch()) {
    $albuminfo = [];
    $albuminfo['id'] = $row['id'];
    $albuminfo['albumname'] = $row['album'];
    $albuminfo['name_en'] = $row['name_en'];
    $albuminfo['description'] = $row['description'];
    $albuminfo['description_en'] = $row['description_en'];
    $albuminfo['albumtype'] = 0;
    $albuminfo['parent'] = $row['parent'];
    array_push($albumArray, $albuminfo);
}
/*$sql = 'SELECT albums.* FROM albums WHERE albumtype=1';
$q = $dbh->query($sql);
$row1 = $q->fetch();
$albuminfo = [];
$albuminfo['id'] = $row1['id'];
$albuminfo['albumname'] = $row1['album'];
$albuminfo['imagename'] = 'Videos.jpg';
$albuminfo['name_en'] = $row1['name_en'];
$albuminfo['description'] = $row1['description'];
$albuminfo['description_en'] = $row1['description_en'];
$albuminfo['private'] = 0;
$albuminfo['albumtype'] = 1;
array_push($albumArray, $albuminfo);*/



header('Content-type: application/json');
echo json_encode($albumArray);