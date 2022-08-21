<?php
require_once('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

$album = $_REQUEST['album'];
$path = $picturebase . $album;
if (!is_dir($path)) { //create album folder if necessary
    mkdir($path,0777);
    $thumbs = $path . '/' . 'thumbs';
    mkdir($thumbs,0777);
}

$sql = "SELECT COUNT(*) FROM albums WHERE album = '$album'";
$qa = $dbh->prepare($sql);
$qa->execute();
$row = $qa->fetch(PDO::FETCH_NUM);
$cnt = $row[0];
if ($cnt == 0) { // add album to database if necessay
    $so = 0;
    $dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
    $sql = "SELECT MAX(sortorder) FROM albums";
    $qso = $dbh->prepare($sql);
    $qso->execute();
    $row = $qso->fetch(PDO::FETCH_NUM);
    $so = $row[0] + 1;
    $sql = "INSERT INTO albums (album,name_en, private, albumtype, sortorder ) VALUES(?,?,0,0,?)";
    $qna = $dbh->prepare($sql);
    $qna->execute([$album,$album,$so]);
}

$sql = "SELECT id FROM albums WHERE album=?";
$q0 = $dbh->prepare($sql);
$q0->execute([$album]);
$row0 = $q0->fetch(PDO::FETCH_NUM);
$albumid = $row0[0];

$sql = "SELECT MAX(sortorder) FROM pictures WHERE albumid=$albumid";
$q = $dbh->prepare($sql);
$q->execute();
$row = $q->fetch(PDO::FETCH_NUM);
$so = $row[0] + 1;

$data = array("album" => $album, "albumid" => $albumid, "sortorder" => $so);
header("Content-Type: application/json");
echo json_encode($data);
exit();