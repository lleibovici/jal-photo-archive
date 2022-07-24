<?php
session_start();
$loggedin = false;
if (isset($_SESSION['loggedin'])) {
    $loggedin = true;
}
else {
    $loggedin = false;
}
$retArray['loggedin'] = $loggedin;


header('Content-type: application/json');
echo json_encode($retArray);