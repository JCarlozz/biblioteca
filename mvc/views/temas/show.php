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
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section>
    			<h2><?= tema->tema?></h2>
    			
    			<p><b>Tema:</b>			<?=$tema->tema?></p>
    			<p><b>Descripción:</b>	<?=$tema->descripcion?></p>
    		</section>
    		
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/Tema/list/">Lista de temas</a>
    			<a class="button" href="/Tema/edit/<?= $tema->id?>">Editar</a>
    			<a class="button" href="/Tema/delete/<?= $tema->id?>">Borrar</a>    		
    		</div>
		</main>
		<?php $template->footer()?>		
	</body>
</html>