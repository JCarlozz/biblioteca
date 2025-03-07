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
    			<label>Imagen de perfil</label>
    			<input type="file" name="picture" accept="image/*" id="file-with-preview">
    			<br>    			
    			
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
    		<section>
    			<script>
    				function confirmar(id){
    					if(confirm('Seguro que deseas eliminar?'))
    						location.href='/Ejemplar/destroy/'+id
    				}
    			</script>
    			<section>
                    <h2>Roles de <?= $user->displayname ?></h2>
                
                
                    <?php if(empty($user->roles)) { ?>
                        <div class='warning p2'><p>No se han indicado roles.</p></div>
                    <?php } else { ?>
                        <table class="table w100">
                            <tr>
                                <th>Rol</th><th>Operaciones</th>
                            </tr>
                            <?php foreach($users as $u) { ?>
                                <tr>    						
                                    <td><?= arrayToString($u->roles) ?></td>
                                    <td class="centrado">
                                        <form method="POST" class="no-border" action="/User/removerole">
                                            <input type="hidden" name="id" value="<?= $u->id ?>">
                                            <input type="submit" class="button-danger" name="remove" value="Borrar">
                                        </form>
                                    </td>	
                                </tr>
                            <?php } ?>
                        </table>
                    <?php } ?>
                
                    <form class="w50 m0 no-border" method="POST" action="/User/addrole">
                        <input type="hidden" name="id" value="<?= $user->id ?>">    						
                        <select name="roles">
                            <?php foreach (USER_ROLES as $roleName) { ?>
                                <option value="<?= $roleName ?>"><?= $roleName ?></option>
                            <?php } ?>
                        </select>
                        <input class="button-success" type="submit" name="add" value="Añadir rol">
                    </form>   		
                </section>
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/User/list">Lista de usuarios</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>

