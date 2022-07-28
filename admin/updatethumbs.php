<?php
require_once('../config.php');
if (isset($_REQUEST['album'])) {
    $files = [];
    $album = $_REQUEST['album'];
    $folder = $picturebase . $album . '/';

    $dbh = new PDO("mysql:host=$dbhost;dbname=$database", "$dbuser", "$dbpassword");
    $sql = "SELECT filename FROM pictures WHERE album='$album'";
    $q = $dbh->prepare($sql);
    $q->execute();

    while ($row = $q->fetch()) {
        $filename = $row['filename'];
        $filepath = $folder . $filename;
        $thumbname = $folder . 'thumbs/' . $filename;
        $cmdstr = "/usr/bin/convert \"$filepath\" -resize 250x180 -background white -gravity center -extent 250x180 \"$thumbname\"";
        if (!system($cmdstr) ) {
            error_log($cmdstr . 'failed');
        }
        else {
            $files[] = $filename;
        }
   }
    header('Content-type: application/json');
    echo json_encode($files);
}
else {
    header('Content-type: text/plain');
    echo "No Album supplied";
}