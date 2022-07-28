<?php
require_once('config.php');

$albumname = "";
$album = [];
$dbh = new PDO("mysql:host=$dbhost;dbname=$database", "$dbuser", "$dbpassword");

$sql = "";
if (isset($_REQUEST['album'])) {
    $albumname = $_REQUEST['album'];
    $sql = "SELECT * FROM albums WHERE album= ?";
    $sth1 = $dbh->prepare($sql);
    $sth1->execute([$albumname]);
    $row = $sth1->fetch();
    $album['id'] = $row['id'];
    $album['albumname'] = $row['album'];
    $album['name_en'] = $row['name_en'];
    $album['description'] = $row['description'];
    $album['description_en'] = $row['description_en'];
    $album['parentid'] = $row['parent'];
    $albumid = $album['id'];
}
if (isset($_REQUEST['albumid'])) {
    $albumid = $_REQUEST['albumid'];
    $sql = "SELECT * FROM albums WHERE id=?";
    $sth1 = $dbh->prepare($sql);
    $sth1->execute([$albumid]);
    $row = $sth1->fetch();
    $album['id'] = $row['id'];
    $album['albumname'] = $row['album'];
    $album['name_en'] = $row['name_en'];
    $album['description'] = $row['description'];
    $album['description_en'] = $row['description_en'];
    $album['parentid'] = $row['parent'];
    $albumname = $album['albumname'];
}

$sql = "SELECT COUNT(*) FROM albums WHERE parent = $albumid";
$sth0 = $dbh->prepare($sql);
$sth0->execute();
$row = $sth0->fetch();
$cnt = $row[0];
if ($cnt > 0) {
    $album['parent'] = true;
} else {
    $album['parent'] = false;
}

$ret = [];
/*if ($cnt == 0) {*/

$sql = 'SELECT * FROM pictures WHERE albumid = ? ORDER BY sortorder,modified';
//error_log($sql);
$sth = $dbh->prepare($sql);
$sth->execute([$albumid]);
$pictures = array();
while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    array_push($pictures, $row);
}

//$album['parent'] = false;
array_push($ret, $album);
array_push($ret, $pictures);
/*}
else {
    $album['parent'] = true;
    array_push($ret, $album);
}*/

header('Content-type: application/json');
echo json_encode($ret);