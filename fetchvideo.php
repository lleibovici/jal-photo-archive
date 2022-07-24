
<?php
require_once ('config.php');
$filename = $_REQUEST['filename'];

$file = $picturebase . 'Videos/' . $filename;

require_once ('videostream.php');
$stream = new VideoStream($file);
$stream->start();
?>
