<?php
require_once('../config.php');

$filename = $_FILES['file']['name'];
$filename = htmlspecialchars_decode($filename);
$album = $_POST['album'];
$albumid = $_POST['albumid'];
$sortorder = $_POST['sortorder'];

$location = $picturebase. $album . '/' .$filename;
$thumbname = $picturebase . $album .'/thumbs/' . $filename;
$path = $picturebase . $album;


$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

$uploadOk = 1;

if($uploadOk == 0){
    echo 0;
}else{
    /* Upload file */
    if(move_uploaded_file($_FILES['file']['tmp_name'], $location)){
        $filetime = date('Y-m-d H:i:s', filemtime($location));
        $cmdstr = "/usr/bin/convert \"$location\" -resize 250x180 -background white -gravity center -extent 250x180 \"$thumbname\"";
        system($cmdstr);
        $sql = "INSERT INTO pictures VALUES (NULL,?,?,?,?,?,'','',?)";
        $qi = $dbh->prepare($sql);
        $qi->execute([$album,$albumid,$filename,$filetime,$filename,$sortorder]);
        echo $location;
    }else{
        error_log("Failed to move uploaded file $location/$filename");
        echo 0;
    }
}
?>
