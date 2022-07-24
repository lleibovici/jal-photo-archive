<?php
require_once('../config.php');
if(isset($_POST['submit_image']))
{
    $so = 0;
    $dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

    if (isset($_REQUEST['album'])) {
        $album = $_POST['album'];
    }
    $make = $_POST['albumMake'];

    if ($make == 'existing') {
        $folder = $picturebase . $album . '/';
        $sql = "SELECT MAX(sortorder) FROM pictures WHERE album=?";
        $q = $dbh->prepare($sql);
        $q->execute([$album]);
        $row = $q->fetch();
        $so = $row[0];
    }
    else {
        $sql = "SELECT MAX(sortorder) FROM albums";
        $qs = $dbh->prepare($sql);
        $qs->execute();
        $r = $qs->fetch();
        $aso = $r[0];
        $aso++;
        $newalbum = $_POST['newalbum'];
        $folder = $picturebase . $newalbum;
        mkdir($folder,0777);
        $folder .= '/';
        mkdir($folder . 'thumbs');
        $sql = 'INSERT INTO albums (album, name_en, private, albumtype,sortorder) VALUES(?,?,0,0,?)';
        $q = $dbh->prepare($sql);
        $q->execute([$newalbum, $newalbum, $aso]);
        $album = $newalbum;
    }

    $sql = "SELECT id FROM albums WHERE album =?";
    $q0 = $dbh->prepare($sql);
    $q0-> execute([$album]);
    $row0 = $q0->fetch();
    $albumid = $row0['id'];



    for($i=0;$i<count($_FILES["upload_file"]["name"]);$i++)
    {
        $filename = $_FILES["upload_file"]["name"][$i];
        $filename = htmlspecialchars_decode($filename);
        $uploadfile= $folder . $filename;
        //error_log("Uploadfile->" . $uploadfile);
        $thumbname = $folder . 'thumbs/' . $filename;
        if (! move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], $uploadfile)) {
            error_log('Filed to move uploaded file '. $uploadfile);
        }
        $cmdstr = "/usr/bin/convert \"$uploadfile\" -resize 250x180 -background white -gravity center -extent 250x180 \"$thumbname\"";
        //error_log($cmdstr);
        system($cmdstr);
        $filetime = date('Y-m-d H:i:s', filemtime($uploadfile));
        $so ++;
        $sql = "INSERT INTO pictures VALUES (NULL,?,?,?,?,'','','',?)";
        //$sql = "INSERT INTO pictures VALUES (NULL,'$album','$filename','$filetime','','','',$so)";
        error_log($sql);
        $q1 = $dbh->prepare($sql);
        $q1->execute([$album,$albumid,$filename,$filetime,$so]);
        //$q1->execute();
    }
    exit();
}
?>