<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$message = "OK";
if (isset($_REQUEST['pictureidx'])) {
    $sql = "SELECT * FROM pictures WHERE id=?";

    $pidx= $_REQUEST['pictureidx'];
    $qq = $dbh->prepare($sql);
    $qq->execute([$pidx]);
    $row = $qq->fetch(PDO::FETCH_ASSOC);
    $album = $row['album'];
    $filename = $row['filename'];

    $sql = "SELECT COUNT(*) FROM pictures WHERE album='$album' AND filename='$album'";
    $qqq= $dbh->prepare($sql);
    $qqq->execute();
    $row = $qqq->fetch();
    $cnt = $row[0];

    $sql = "DELETE FROM pictures WHERE id=?";
    $q = $dbh->prepare($sql);
    $q->execute([$pidx]);
    if ($cnt == 1) { //only delete file if it was referenced only once - could have been uploaded twice
        $fullpath = $picturebase . $album . '/' . $filename;
        $thumbpath = $picturebase . $album . '/thumbs/' . $filename;
        unlink($thumbpath);
        unlink($fullpath);
    }

}
else {
    $message="No pictureidx specified";
}
//error_log($data);
header('Content-Type: text/plain');
