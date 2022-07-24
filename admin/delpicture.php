<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

if (isset($_REQUEST['pictureidx'])) {
    $sql = "SELECT * FROM pictures WHERE id=?";

    $pidx= $_REQUEST['pictureidx'];
    $qq = $dbh->prepare($sql);
    $qq->execute([$pidx]);
    $row = $qq->fetch(PDO::FETCH_ASSOC);
    $album = $row['album'];
    $filename = $row['filename'];

    //$album = $_REQUEST['album'];
    $sql = "DELETE FROM pictures WHERE id=?";
    $q = $dbh->prepare($sql);
    $q->execute([$pidx]);
    $fullpath = $picturebase . $album . '/' . $filename;
    $thumbpath = $picturebase . $album . '/thumbs/' . $filename;
    unlink($thumbpath);
    unlink($fullpath);

}
//error_log($data);
header('Content-Type: text/plain');
