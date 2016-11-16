<?php

include('libs/conn.php');

//prendo le facoltà da mostrare nel dropdown relativo
$facolta = $conn->query("SELECT * FROM facolta");

//prendo tutti i corsi disponibioli da mostrare nel dropdown relativo
$corsi = $conn->query("SELECT cdcorso, corso FROM corsi");

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/validation.css">
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
</head>
<body>

<div class="row">

    <div class="col-md-8 col-md-offset-2">

        <h3 class="text-muted text-center">Ricerca Studente</h3>

        <div class="alert alert-warning alert-dismissible" role="alert" id="errore-ricerca">
            <button type="button" class="close" data-dismiss="alert" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
            <p class="text-center">Inserisci almeno un criterio di ricerca.</p>
        </div>

        <form class="form-horizontal" method="post" action="libs/ricerca.php" id="formRicerca">

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="matricola" class="col-sm-4 control-label">Matricola</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="matricola" name="matricola" placeholder="Matricola">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <label for="cdfacolta" class="col-sm-4 control-label">Facoltà</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="cdfacolta" id="cdfacolta" required>
                            <option selected disabled style="display: none">Seleziona ...</option>
                            <?php while($res = $facolta->fetch_assoc()): ?>
                                <option value="<?php echo $res['cdfacolta'] ?>"><?php echo $res['facolta'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="nominativo" class="col-sm-4 control-label">Nominativo</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nominativo" name="nominativo" placeholder="Nome, Cognome">
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="cdcorso" class="col-sm-4 control-label">Corso di Studi</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="cdcorso" id="cdcorso">
                            <option selected disabled style="display:none;">Seleziona ...</option>
                            <?php while($res = $corsi->fetch_assoc()): ?>
                                <option value="<?php echo $res['cdcorso'] ?>"><?php echo $res['corso'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10">
                    <button type="submit" class="btn btn-primary">Ricerca</button>
                </div>
            </div>

        </form>

    </div>

</div>


<script src="js/bootstrap.min.js"></script>
<script>
    $("#formRicerca").on('submit', function (event) {
        var okForSubmit = false;
        $(this).find("input[type=text], select").each(function (index, field) {
            if($(field).val() != "" && $(field).val() != null)
                okForSubmit = true;
        });
        if(! okForSubmit) {
            event.preventDefault();
            $("#errore-ricerca").show();
        }
    });
</script>

</body>
</html>
