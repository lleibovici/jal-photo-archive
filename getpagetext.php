<?php
require_once ('config.php');
$dbh = new PDO("mysql:host=$dbhost;dbname=$database","$dbuser","$dbpassword");
$page = $_REQUEST['page'];
$sql = 'SELECT text FROM pagetext WHERE page= ? AND timestamp = (SELECT MAX(timestamp) FROM pagetext WHERE page=?)';
$q = $dbh->prepare($sql);
$q->execute([$page,$page]);
$row = $q->fetch();
$pagetext = $row['text'];
header("Content-Type: text/html");
echo $pagetext;
