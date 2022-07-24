<?php
require_once('config.php');
$filename = &$_REQUEST['filename'];
//$album = $_REQUEST['album'];
$album = 'Videos';
$fullpath = $picturebase . $album . '/thumbs/' .$filename;
error_log($fullpath);
$thumb = file_get_contents($fullpath);
header("Content-Type: image/jpeg");
echo $thumb;
