<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar el socio<?=$socio->id?> - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/Preview.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios'=> 'list',
		    $socio->nombre."\n". $socio->apellidos =>'nombre, apellidos',
		    'Editar'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Editar el socio ID <?= $socio->id?></h2>
    		<section class="flex-container gap2">
    		
    		<form method="POST" action="/Socio/update" class="flex2 no-border" enctype="multipart/form-data">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$socio->id?>">
    					
    			
    			<label>DNI</label>
    			<input type="text" name="dni" value="<?=old('dni', $socio->dni)?>">
    			<br>
    			<label>Nombre</label>
    			<input type="text" name="nombre" value="<?=old('nombre', $socio->nombre)?>">
    			<br>
    			<label>Apellidos</label>
    			<input type="text" name="apellidos" value="<?=old('apellidos', $socio->apellidos)?>">
    			<br>
    			<label>Fecha de nacimiento</label>
    			<input type="text" name="nacimiento" value="<?=old('nacimiento', $socio->nacimiento)?>">
    			<br>
    			<label>Email</label>
    			<input type="text" name="email" value="<?=old('email',$socio->email)?>">
    			<br>
    			<label>Foto</label>
    			<input type="file" name="foto" accept="image/*" id="file-with-preview">
    			<br>
    			<label>Dirección</label>
    			<input type="text" name="direccion" value="<?=old('direccion', $socio->direccion)?>">
    			<br>
    			<label>Codigo postal</label>
    			<input type="number" name="cp" value="<?=old('cp', $socio->cp)?>">
    			<br>
    			<label>Población</label>
    			<input type="text" name="poblacion"	value="<?=old('poblacion', $socio->poblacion)?>">
    			<br>
    			<label>Provincia</label>
    			<input type="text" name="provincia" value="<?=old('provincia', $socio->provincia)?>">
    			<br>
    			<label>Teléfono</label>
    			<input type="number" name="telefono" 
    					value="<?=old('telefono', $socio->telefono)?>">
    			<br>
    			
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		<figure class="flex1 centrado p2">
    			<img src="<?=MEMBERS_IMAGE_FOLDER.'/'.($socio->foto ?? DEFAULT_MEMBERS_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la foto">
    			<figcaption>Foto del socio <?="$socio->nombre $socio->apellidos"?></figcaption>
    			<?php if($socio->foto) {?>
    			<form method="POST" action="/Socio/dropcover" class="no-border">
    				<input type="hidden" name="id" value="<?=$socio->id?>">
    				<input type="submit" class="button-danger" name="borrar" value="Eliminar portada">
    			</form>
    			<?php } ?>	
    		</figure>
    		</section>
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Socio/list">Lista de socios</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>

