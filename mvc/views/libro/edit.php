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
    		<h2>Edición de libro<?= $libro->titulo?></h2>
    		
    		<form method="POST" action="/Libro/update">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$libro->id?>">
    					
    			
    			<label>ISBN</label>
    			<input type="text" name="isbn" value="<?=old('isbn', $libro->isbn)?>">
    			<br>
    			<label>Título</label>
    			<input type="text" name="titulo" value="<?=old('titulo', $libro->titulo)?>">
    			<br>
    			<label>Editorial</label>
    			<input type="text" name="editorial" value="<?=old('editorial', $libro->editorial)?>">
    			<br>
    			<label>Autor</label>
    			<input type="text" name="autor" value="<?=old('autor', $libro->autor)?>">
    			<br>
    			<label>Idioma</label>
    			<input type="text" name="idioma" value="<?=old('idioma',$libro->idioma)?>">
    			<br>
    			<label>Edición</label>
    			<input type="number" name="edicion" value="<?=old('edicion', $libro->edicion)?>">
    			<br>
    			<label>Año</label>
    			<input type="number" name="anyo" value="<?=old('anyo', $libro->anyo)?>">
    			<br>
    			<label>Edad rec.</label>
    			<input type="number" name="edadrecomendada"
    				value="<?=old('edadrecomendado', $libro->edadrecomendada)?>">
    			<br>
    			<label>Páginas</label>
    			<input type="number" name="paginas" value="<?=old('paginas', $libro->paginas)?>">
    			<br>
    			<label>Caracte.</label>
    			<input type="text" name="caracteristicas" 
    					value="<?=old('caracteristicas', $libro->caracteristicas)?>">
    			<br>
    			<label>Sinopsis</label>
    			<textarea name="sinopsis" class="w50"><?=old('sinopsis', $libro->sinopsis)?></textarea>
    			<br>
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Libro/list">Lista de libros</a>
			</div>    		
		</main>
		<?php $template->footer()?>		
	</body>
</html>

