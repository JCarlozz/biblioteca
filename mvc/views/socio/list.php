<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de socios - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.png" type="image/png">	
		
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
    		
    		<p><a class="button float-right" href="/Socio/create/">Nuevo socio</a></p>

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
    						<a class='button'href='/Socio/show/<?= $socio->id ?>'tittle="Ver">
    							<i class="fas fa-eye"></i></a> -
    						<a class='button' href='/Socio/edit/<?= $socio->id ?>'tittle="Editar">
    							<i class="fas fa-edit"></i></a> -
    						<a class='button' href='/Socio/delete/<?= $socio->id ?>'tittle="Eliminar">
    							<i class="fas fa-trash-alt"></i></a>
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
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>