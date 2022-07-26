<?php
require_once('config.php');
$filename = $_REQUEST['filename'];
$filename = str_replace('&amp;','&',$filename);
//error_log($filename);
$album = $_REQUEST['album'];
$fullpath = $picturebase . $album . '/thumbs/' .$filename;

//$thumb = `/usr/bin/convert '$fullpath' -resize 250x180 -background white -gravity center -extent 250x180 jpg:-`;
$thumb = file_get_contents($fullpath);
header("Content-Type: image/jpeg");
echo $thumb;
