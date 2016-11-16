<?php

session_start();
include('conn.php');

$nome = $_POST['nome'];
$cognome = $_POST['cognome'];
$dataRaw = str_replace("/", "-", $_POST['dnascita']);
$dnascita = date('Ymd', strtotime($dataRaw));
$luogo = $_POST['luogo'];
$cdfacolta = $_POST['facolta'];
$cdcorso = $_POST['corso'];

$sql = "INSERT INTO studenti VALUES (null, '$nome', '$cognome', $dnascita, '$luogo', $cdfacolta, $cdcorso)";

if ($conn->query($sql) === TRUE) {
    $_SESSION['insert_ok'] = true;
    header("Location: http://localhost/getlavoro/index.php");
} else {
    echo "Errore: " . $sql . "<br>" . $conn->error;
}

$conn->close();

