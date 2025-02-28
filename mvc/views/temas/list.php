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
		    'Temas'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de temas</h2>

    		<?php if ($temas) { ?>
    			<table class="table w100">
    				<tr>
    					<th>Tema</th>
    					<th>Descripción</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($temas as $tema){?>
    				<tr>
    					<td><a href='/Tema/show/<?= $tema->id ?>'><?=$tema->tema?></a></td>
    					<td><?= $tema->descripcion ?></td>
    					<td class="centrado">
    						<a href='/Tema/show/<?= $tema->id ?>'>Ver</a> -
    						<a href='/Tema/edit/<?= $tema->id ?>'>Editar</a> -
    						<a href='/Tema/delete/<?= $tema->id ?>'>Eliminar</a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay temas que mostrar.</p>
    				</div>
    			<?php } ?>
    			
    			<div class="centred">
    				<a class="button" onclick="history.back()">Atrás</a>
    			</div>
		</main>
		<?php $template->footer()?>		
	</body>
</html>