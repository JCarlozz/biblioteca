<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Eliminar temas - <?= APP_NAME ?></title>
		
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
		    'Temas'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Borrar tema</h2>
    		
    		<form method="POST" class="centered m2" action="/tema/destroy">
				<p>Confirmar el borrado del tema <b><?=$tema->tema?></b>.</p>
    			    			
    			<input type="hidden" name="id" value="<?=$tema->id?>">
    			<input class="button-danger" type="submit" name="borrar" value="Borrar">
    		</form>    	
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Temas/list">Lista de temas</a>
				<a class="button" href="/Temas/show/<?=$tema->id?>">Detalles</a>
				<a class="button" href="/Temas/edit/<?=$tema->id?>">Edición</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>
