<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de temas - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de temas') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Nuevo tema</h2>
			
			<form method="POST" enctype="multipart/form-data" action="/Tema/store">
				<div class="flex2">
					<label>Tema</label>
					<input type="text" name="tema" value="<?=old('tema')?>">
					<br>
					<label>Descripción</label>
					<input type="text" name="descripcion" value="<?=old('descripcion')?>">
					<br>
					
					<div class="centrado my2">
						<input type="submit" class="button" name="guardar" value="Guardar">
						<input type="reset" class="button" value="Reset">
					</div>    
				</div>
			</div>			
			</form>
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Tema/list">Lista de temas</a>
			</div>    		
		</main>
		<?php $template->footer()?>		
	</body>
</html>
