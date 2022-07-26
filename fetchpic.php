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
$im = imagecreatefromstring(file_get_contents($fullpath));

$exif = exif_read_data($fullpath);
if ($exif && !empty($exif['Orientation']))
{
    $buffer = $im;
    switch($exif['Orientation']) {
        case 8:
            $buffer = imagerotate($im, 90, 0);
            break;
        case 3:
            $buffer = imagerotate($im, 180, 0);
            break;
        case 6:
            $buffer = imagerotate($im, -90, 0);
            break;
        case 5: // vertical flip + 90 rotate right
            $buffer = imagerotate($im, -90, 0);
            break;
        case 7: // horizontal flip + 90 rotate right
            $buffer = imagerotate($im, -90, 0);
            break;
    }
    $im = $buffer;
    imagedestroy($buffer);
}
$width = imagesx($im);
$height = imagesy($im);
$crwidth = intval($width * 0.25);
$copyright = imagecreatefrompng('./img/copyright.png');
$stamp = imagescale($copyright,$crwidth);

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