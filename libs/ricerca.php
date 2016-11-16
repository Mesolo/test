<?php

include('conn.php');

$criteri = array_filter($_POST);

if(isset($criteri['nominativo'])) {
    $nominativo = explode(",", $criteri['nominativo']);

   $criteri['nome'] = trim($nominativo[0]);
   $criteri['cognome'] = trim($nominativo[1]);
    unset($criteri['nominativo']);
}

$sql = "SELECT studenti.*, corsi.corso, facolta.facolta 
FROM studenti 
JOIN corsi ON studenti.cdcorso=corsi.cdcorso 
JOIN facolta ON studenti.cdfacolta = facolta.cdfacolta";

$count = 1;
foreach($criteri as $key => $value) {
    if($count == 1)
        $sql .= " WHERE studenti.$key = '$value'";
    else
        $sql .= " AND studenti.$key = '$value'";
    $count++;
}

$studenti = $conn->query($sql);
if(! $studenti)
    echo $conn->error;

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/jquery-3.1.1.min.js"></script>
</head>
<body>

<div class="row">

    <div class="col-md-8 col-md-offset-2">

        <h3 class="text-muted text-center">Risultati ricerca</h3>

        <div class="row">

            <div class="col-md-12">

                <table class="table table-striped table-hover">
                    <thead>
                        <th>Matricola</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        <th>Data nascita</th>
                        <th>Luogo Nascita</th>
                        <th>Facoltà</th>
                        <th>Corso Laurea</th>
                    </thead>
                    <tbody>
                        <?php if($studenti->num_rows < 1): ?>
                            <tr>
                                <td colspan="7" class="text-center">Nessun risultato trovato.</td>
                            </tr>
                        <?php else: ?>

                            <?php while($res = $studenti->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $res['matricola'] ?></td>
                                    <td><?php echo $res['nome'] ?></td>
                                    <td><?php echo $res['cognome'] ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($res['dtnascita'])) ?></td>
                                    <td><?php echo $res['luogo'] ?></td>
                                    <td><?php echo $res['facolta'] ?></td>
                                    <td><?php echo $res['corso'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="form-group">
                    <div class="col-sm-10">
                        <a href="../ricerca.php" class="btn btn-primary">Altra ricerca</a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>


<script src="../js/bootstrap.min.js"></script>

</body>
</html>
