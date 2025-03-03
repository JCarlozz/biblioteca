<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Préstamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Préstamos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Préstamos'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de préstamos</h2>
    		
    		<p><a class="button float-right" href="/Prestamo/create/">Nuevo préstamo</a></p>

    		<?php if ($prestamos) { ?>
    			<table class="table w100">
    				<tr>
    					<th>Título</th>
    					<th>Nombre</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($prestamos as $prestamo){?>
    				<tr>
    					<td><a href='/Prestamo/show/<?= $prestamo->id ?>'><?=$prestamo->titulo?></a></td>
    					<td><?= $prestamo->nombre ?></td>
    					<td class="centrado">
    						<a href='/Prestamo/show/<?= $prestamo->id ?>'tittle="Ver">
    							<i class="fas fa-eye"></i></a> -
    						<a href='/Prestamo/edit/<?= $prestamo->id ?>'tittle="Editar">
    							<i class="fas fa-edit"></i></a> -
    						<a href='/Prestamo/delete/<?= $prestamo->id ?>'tittle="Eliminar">
    							<i class="fas fa-trash-alt"></i></a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay préstamos que mostrar.</p>
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