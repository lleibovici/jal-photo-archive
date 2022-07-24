<?php
session_start();
$loggedin = false;
if (isset($_SESSION['loggedin'])) {
    $loggedin = true;
}
$parent = 0;
if (isset($_REQUEST['parent'])) {
    $parent = $_REQUEST['parent'];
}
require_once('config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$sql = "SELECT MIN(modified) AS modified, pictures.album, albums.id, albums.private, albums.description, albums.description_en, albums.name_en, filename FROM pictures, albums WHERE pictures.albumid = albums.id AND albums.albumtype = 0 AND parent = $parent GROUP BY album, albums.sortorder ORDER BY albums.sortorder";
$sth = $dbh->query($sql);

$albumArray = [];

while ($row = $sth->fetch()) {
    $albuminfo = [];
    $albuminfo['id'] = $row['id'];
    $albuminfo['albumname'] = $row['album'];
    $albuminfo['imagename'] = $row['filename'];
    $albuminfo['name_en'] = $row['name_en'];
    $albuminfo['description'] = $row['description'];
    $albuminfo['description_en'] = $row['description_en'];
    if ($loggedin) {
        $albuminfo['private'] = 0;
    }
    else {
        $albuminfo['private'] = $row['private'];
    }
    $albuminfo['albumtype'] = 0;
    array_push($albumArray, $albuminfo);
}
if ($parent == 0) {
    $sql = 'SELECT albums.* FROM albums WHERE albumtype=1';
    $q = $dbh->query($sql);
    while ($row1 = $q->fetch()) {
        $albuminfo = [];
        $albuminfo['id'] = $row1['id'];
        $albuminfo['albumname'] = $row1['album'];
        $albuminfo['imagename'] = 'Videos.jpg';
        $albuminfo['name_en'] = $row1['name_en'];
        $albuminfo['description'] = $row1['description'];
        $albuminfo['description_en'] = $row1['description_en'];
        $albuminfo['private'] = 0;
        $albuminfo['albumtype'] = 1;
        array_push($albumArray, $albuminfo);
    }
}


header('Content-type: application/json');
echo json_encode($albumArray);