<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Perfil usuario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuarios'=> '/user',
		    $user->displayname =>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
    			<h2><?=$user->displayname?></h2>
    			
    			<p><b>Nombre:</b>		<?=$user->displayname?></p>
    			<p><b>Email:</b>		<?=$user->email?></p>
    			<p><b>Teléfono:</b>		<?=$user->phone?></p>
    			<p><b>Roles:</b> 		<?= implode(', ', $user->roles) ?></p>
    			<p><b>Bloqueado:</b>	<?=$user->blocked_at?></p>
    			</div>
    			<figure class="flex1 centrado p2">
    				<img src="<?=USERS_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USERS_IMAGE)?>"
    					class="cover enlarge-image"
    					alt="Foto del usuario <?=$user->displayname?>">
    				<figcaption>Foto del usuario <?="$user->displaynames"?></figcaption>
    			</figure>
    		</section>
    		
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/User/list/">Lista de usuarios</a>
    			<a class="button" href="/User/edit/<?= $user->id?>">Editar</a>
    			<a class="button" href="/User/delete/<?= $user->id?>">Borrar</a>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>