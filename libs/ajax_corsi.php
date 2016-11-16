<?php

include('conn.php');

$cdfacolta = $_POST['cdfacolta'];

$corso = $conn->query("SELECT corso, cdcorso FROM corsi WHERE cdfacolta = $cdfacolta");

$buffer = '<option selected disabled style="display:none;">Seleziona ...</option>';
while($res = $corso->fetch_assoc()) {
    $buffer .= "<option value={$res['cdcorso']}>{$res['corso']}</option>";
}

echo $buffer;