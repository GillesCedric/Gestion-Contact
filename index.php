<?php

require('class/config.php');
require('class/import.php');
require('class/export.php');
require('class/fichier.php');
$connection = new Config();
$connection = $connection->setConnection();
$msg = "";
if (isset($_POST['submit'])) {
	if (isset($_FILES['fichier']) && !empty($_FILES['fichier']['name'])) {
		$import = new Import($_FILES['fichier'], $connection);
		$msg = $import->moveFile();
		$msg = $import->readFile();
	} else {
		$msg = "Veuillez choisir un fichier";
	}
}
if (isset($_POST['download'])) {
	Export::exportContacts($_POST['format'], intval($_POST['numero']), $connection);
	exit(200);
}
$fichiers = Fichier::getFichiersInDatabase($connection);
?>
<html lang="fr">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">

	<title>GesContacts</title>
	<style>
		.error {
			color: red;
		}
	</style>
</head>

<body>
	<center>
		<br>
		<div class="card text-center" style="width: 60%;">
			<div class="card-header">
				<h1>GesContacts</h1>
			</div>
			<div class="card-body">
				<p style="display: inline-block; font-weight:bold;font-size:25px;">Uploader un fichier de contact</p>
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="row center">
						<div class="col">
							<input type="file" class="form-control-file" name="fichier">
						</div>
						<div class="col">
							<input type="submit" name="submit" class="btn btn-primary" value="Importer">
						</div>
					</div>
					<br>
					<p style="font-weight:bold;font-size:25px;">Télécharger les contacts</p>
					<!-- 
					<div class="row center" id="center">
						<ul class="list-group">
							/<?php /*foreach ($fichiers as $value) { ?>
								<li class="list-group-item"><a href="<?= $value['url'] ?>"><?= $value['nom'] ?></a></li>
							<?php } */ ?>
						</ul>
					</div>
					-->
					<div class="form-group">
						<label for="niveau">Format</label>
						<select class="form-control" id="format" name="format">
							<option value="csv">CSV</option>
							<option value="vcf">VCF</option>
						</select>
					</div>
					<div class="form-group">
						<label for="niveau">A partir de</label>
						<input type="number" name="numero" class="form-control" placeholder="Entrer le numéro du client (client1)">
					</div>
					<input type="submit" name="download" class="btn btn-primary" value="Télécharger">
			</div>
			<div class="card-footer text-muted">
				développé par ANOUMEDEM Gilles Cédric. Tous droits reservés!!!<br>Version 1.0.0
			</div>
			<div class="text-muted">
				<?php
				echo "<div class='error'>$msg</div>";
				?>
			</div>
	</center>
	<script src="js/bootstrap.min.js"></script>

</body>

</html>