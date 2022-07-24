<?php
require_once ('../config.php');
$filename = &$_REQUEST['filename'];
$album = $_REQUEST['album'];

$fullpath = $picturebase . $album . '/' . $filename;
list($width, $height, $type, $attr) = getimagesize($fullpath);

$mime = image_type_to_mime_type($type);
$im = imagecreatefromstring(file_get_contents($fullpath));

header("Content-Type: $mime");
if ($mime == 'image/jpeg') {
    imagejpeg($im);
}
if ($mime == 'image/png') {
    imagepng($im);
}
imagedestroy($im);