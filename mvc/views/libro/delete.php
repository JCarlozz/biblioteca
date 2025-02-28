<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de libros - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Borrar libro</h2>
    		    		
    		<form method="POST" class="centered m2" action="/Libro/destroy">
				<p>Confirmar el borrado del libro <b><?=$libro->titulo?></b>.</p>
    			    			
    			<input type="hidden" name="id" value="<?=$libro->id?>">
    			<input class="button-danger" type="submit" name="borrar" value="Borrar">
    		</form> 
    		
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Libro/list">Lista de libros</a>
				<a class="button" href="/Libro/show/<?=$libro->id?>">Detalles</a>
				<a class="button" href="/Libro/edit/<?=$libro->id?>">Edición</a>
			</div>    		
		</main>
		<?php $template->footer()?>		
	</body>
</html>
