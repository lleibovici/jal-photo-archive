<?php
require_once ('../config.php');
$filename = &$_REQUEST['filename'];
$album = $_REQUEST['album'];
if (isset($_REQUEST['album']) && isset($_REQUEST['filename'])) {
    $fullpath = $picturebase . $album . '/' . $filename;
    if (file_exists($fullpath)) {

        $mime = image_type_to_mime_type($type);
        $image = file_get_contents($fullpath);
        $exif = @exif_read_data($fullpath);

        header('Content-Description: File Transfer');
        header("Content-Type: $mime");
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fullpath));
        readfile($fullpath);
        exit;
    } else {
        echo "Album: $album Filename: $filename Not Found";
    }
}
else {
    header('Content-Type: Text/Plain');
    echo "Both album and filename must be specified";
}