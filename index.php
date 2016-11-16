<?php

session_start();
include('libs/conn.php');

//prendo le facoltà da mostrare nel dropdown relativo
$facolta = $conn->query("SELECT * FROM facolta");

//prendo l'ultima matricola da mostrare nel placeholder
$matricolaQuery = $conn->query("SELECT MAX(matricola) AS matricola FROM studenti");
$matricola = ($matricolaQuery->fetch_assoc())['matricola'] + 1;

?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="css/validation.css">
	<script src="js/jquery-3.1.1.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
</head>
<body>

<div class="row">
	
	<div class="col-md-8 col-md-offset-2">
	
	<h3 class="text-muted text-center">Inserimento nuovo studente</h3>

		<?php if(isset($_SESSION['insert_ok']) && $_SESSION['insert_ok']): ?>

			<div class="alert alert-success alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Chiudi"><span aria-hidden="true">&times;</span></button>
				<p class="text-center">Studente inserito correttamente.</p>
			</div>

		<?php $_SESSION['insert_ok'] = false; endif; ?>

	<form class="form-horizontal" method="post" action="libs/insert.php" id="formStudenti">

		<div class="form-group">
			<label for="matricola" class="col-sm-2 control-label">Matricola</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="matricola" placeholder="<?php echo $matricola ?>" disabled>
			</div>
		</div>
		<div class="form-group">
			<label for="nome" class="col-sm-2 control-label">Nome</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required>
			</div>
		</div>
		<div class="form-group">
			<label for="cognome" class="col-sm-2 control-label">Cognome</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="cognome" name="cognome" placeholder="Cognome" required>
			</div>
		</div>
		<div class="form-group">
			<label for="dnascita" class="col-sm-2 control-label">Data Nascita</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="dnascita" name="dnascita" placeholder="dd/mm/yyyy" required>
			</div>
		</div>
		<div class="form-group">
			<label for="luogo" class="col-sm-2 control-label">Luogo Nascita</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" id="luogo" name="luogo" placeholder="Luogo" required>
			</div>
		</div>
		<div class="form-group">
			<label for="facolta" class="col-sm-2 control-label">Facoltà</label>
			<div class="col-sm-10">
				<select class="form-control" name="facolta" id="facolta" required>
					<option selected disabled style="display: none">Seleziona ...</option>
					<?php while($res = $facolta->fetch_assoc()): ?>
						<option value="<?php echo $res['cdfacolta'] ?>"><?php echo $res['facolta'] ?></option>
					<?php endwhile; ?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="corso" class="col-sm-2 control-label">Corso di Laurea</label>
			<div class="col-sm-10">
				<select class="form-control" name="corso" id="corso" disabled required>
					<option selected disabled style="display:none;">Seleziona ...</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-primary">Inserisci</button>
			</div>
		</div>
	</form>

		<div class="clear"></div>
		<div class="col-md-6 col-md-offset-3">
			<a href="ricerca.php" class="btn btn-primary btn-block">Ricerca Studenti</a>
		</div>
	
	</div>
	
</div>


<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.min.js"></script>
<script src="js/bootstrap-datepicker.it.min.js"></script>
<script>
	$(function () {
		$("#dnascita").datepicker({
			format: "dd/mm/yyyy",
			todayBtn: "linked",
			language: "it",
			autoclose: true,
			todayHighlight: true
		});

		$("#formStudenti").validate({
			nome: "required"
		});
	});

	$("#facolta").on('change', function() {
		$.ajax({
			url: 'libs/ajax_corsi.php',
			method: 'post',
			data: {cdfacolta: $(this).val()},
			dataType: 'html',
			success: function(data) {
				$("#corso").html("").append(data).removeAttr('disabled');
			}
		});
	});
</script>

</body>
</html>
