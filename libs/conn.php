<?php

$host = 'localhost';
$username = 'root';
$pass = '201282';
$db = 'getLavoro';

$conn = new mysqli($host, $username, $pass, $db);

if($conn->connect_errno > 0)
    die('Errore nella connessione: ' . $conn->connect_error);