<?php
require_once ('config.php');
$filename = $_REQUEST['filename'];
$filename = str_replace('&amp;','&',$filename);
//error_log($filename);
$album = $_REQUEST['album'];
session_start();
$loggedin = false;
if (isset($_SESSION['loggedin'])) {
    $loggedin = true;
}
else {
    $loggedin = false;
}
$fullpath = $picturebase . $album . '/' . $filename;
list($width, $height, $type, $attr) = getimagesize($fullpath);
$crwidth = intval($width * 0.25);
$copyright = imagecreatefrompng('./img/copyright.png');
$stamp = imagescale($copyright,$crwidth);
$im = imagecreatefromstring(file_get_contents($fullpath));
$marge_right = 10;
$marge_bottom = 10;
$sx = imagesx($stamp);
$sy = imagesy($stamp);
if ($loggedin == false) {
    imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));
}

header("Content-Type: image/jpeg");
imagejpeg($im);
imagedestroy($im);