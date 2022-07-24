<?php
$username = $_POST['login'];
$password = $_POST['password'];

if ($username == 'hasenson' && $password == 'aprjap2021!') {
    session_start();
    $_SESSION['username'] = $username;
    $_SESSION['loggedin'] = true;
}
header("Location: /index.html");
die();
