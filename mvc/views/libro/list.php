<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de libros - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de libros</h2>
    		
    		<p><a class="button float-right" href="/Libro/create/">Nuevo libro</a></p>

    		<?php if ($libros) { ?>
    			<table class="table w100">
    				<tr>
    					<th>ISBN</th>
    					<th>Título</th>
    					<th>Autor</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($libros as $libro){?>
    				<tr>
    					<td><?= $libro->isbn ?></td>
    					<td><a href='/Libro/show/<?= $libro->id ?>'><?=$libro->titulo?></a></td>
    					<td><?= $libro->autor ?></td>
    					<td class="centrado">
    						<a href='/Libro/show/<?= $libro->id ?>'tittle="Ver">
    							<i class="fas fa-eye"></i></a> -
    						<a href='/Libro/edit/<?= $libro->id ?>'tittle="Editar">
    							<i class="fas fa-edit"></i></a> -
    						<a href='/Libro/delete/<?= $libro->id ?>'tittle="Eliminar">
    							<i class="fas fa-trash-alt"></i></a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay libros que mostrar.</p>
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