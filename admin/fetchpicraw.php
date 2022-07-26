<?php
require_once ('../config.php');
$filename = &$_REQUEST['filename'];
$album = $_REQUEST['album'];

$fullpath = $picturebase . $album . '/' . $filename;
list($width, $height, $type, $attr) = getimagesize($fullpath);

$mime = image_type_to_mime_type($type);
$im = imagecreatefromstring(file_get_contents($fullpath));
$exif = @exif_read_data($fullpath);

if ($exif && !empty($exif['Orientation']))
{
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
}


header("Content-Type: $mime");
if ($mime == 'image/jpeg') {
    imagejpeg($buffer,null,90);
}
if ($mime == 'image/png') {
    imagepng($buffer);
}
imagedestroy($im);
imagedestroy($buffer);