<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de socios - <?= APP_NAME ?></title>
		
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
		    'Socios'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de socios</h2>

    		<?php if ($socios) { ?>
    			<table class="table w100">
    				<tr>
    					<th>DNI</th>
    					<th>Nombre</th>
    					<th>Población</th>
    					<th>Teléfono</th>
    					<th>Email</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($socios as $socio){?>
    				<tr>
    					<td><?= $socio->dni ?></td>
    					<td><a href='/Socio/show/<?= $socio->id ?>'><?=$socio->nombre?> <?=$socio->apellidos?></a></td>
    					<td><?= $socio->poblacion ?></td>
    					<td><?= $socio->telefono ?></td>
    					<td><?= $socio->email ?></td>
    					<td class="centrado">
    						<a href='/Socio/show/<?= $Socio->id ?>'>Ver</a> -
    						<a href='/Socio/edit/<?= $socio->id ?>'>Editar</a> -
    						<a href='/Socio/delete/<?= $socio->id ?>'>Eliminar</a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay socios que mostrar.</p>
    				</div>
    			<?php } ?>
    			
    			<div class="centred">
    				<a class="button" onclick="history.back()">Atrás</a>
    			</div>
		</main>
		<?php $template->footer()?>		
	</body>
</html>