<?php
require_once ('../config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");

$sql = 'SELECT id, album FROM albums ORDER BY album';
$sth = $dbh->query($sql);
$sortorder= 2;
while ($row = $sth->fetch()) {
    $album = $row['album'];
    if ($album != 'Odd Shots of People') {
        $ID = $row['id'];
        $sq = "UPDATE albums SET sortorder=$sortorder WHERE id=$ID";
        $q = $dbh->prepare($sq);
        $q->execute();
        $sortorder++;
    }
}
$sq = 'UPDATE albums SET sortorder=1 WHERE album="Odd Shots of People"';
$q = $dbh->prepare($sq);
$q->execute();
