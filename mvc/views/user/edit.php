<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar el usuario <?=$user->id?> - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Edición del usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuario'=> '/list',
		    $user->displayname =>'/show',
		    'Editar usuario'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Editar el usuario ID <?= $user->id?></h2>
    		<section class="flex-container gap2">
    		
    		<form method="POST" action="/User/update" class="flex2 no-border" enctype="multipart/form-data">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$user->id?>">
    					
    			
    			<label>Nombre</label>
    			<input type="text" name="displayname" value="<?=old('displayname', $user->displayname)?>">
    			<br>
    			<label>Email</label>
    			<input type="text" name="email" value="<?=old('email', $user->email)?>">
    			<br>
    			<label>Teléfono</label>
    			<input type="text" name="phone" value="<?=old('phone', $user->phone)?>">
    			<br>
    			<label>Bloquear usuario</label>
    				<select name="bloqueo" id="bloqueo">
  				      <option value="">No bloquear</option>
        			  <option value="<?= time(); ?>">Bloquear</option>
    				</select>
    			<br>
    			<label>Teléfono</label>
    			<input type="text" name="phone" value="<?=old('phone', $user->phone)?>">
    			<br>
    			<label>Imagen de perfil</label>
    			<input type="file" name="picture" accept="image/*" id="file-with-preview">
    			<br>
    					
    			<label>Rol</label>
    					
    			<select name="roles">
    				<?php foreach (USER_ROLES as $roleName =>$roleValue){ ?>
    					<option value="<?=$roleValue ?>"><?=$roleName?></option>
    				<?php } ?>
    			</select>
    			
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		<figure class="flex1 centrado p2">
    			<img src="<?=USERS_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USERS_IMAGE)?>"
    				class="cover" id="preview-image" alt="Previsualización de la foto">
    			<figcaption>Foto del usuario <?="$user->displayname"?></figcaption>
    			<?php if($user->picture) {?>
    			<form method="POST" action="/User/dropcover" class="no-border">
    				<input type="hidden" name="id" value="<?=$user->id?>">
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

