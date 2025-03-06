<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de usuarios - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de usuarios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Usuarios'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		<div>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de usuarios</h2>    		
    		<p><a class="button right" href="/User/create/">Nuevo usuario</a></p>
		</div>
    		<?php if ($users) { ?>
    		
    		<div class="right">
    			<?= $paginator->stats() ?>
    		</div>
    		
    		<?php 
    		if ($filtro){
    		    echo $template->removeFilterForm($filtro, '/User/list');
    		    
    		}else{
    		    echo $template->filterForm(
    		        [
    		            'Nombre'=>'displayname',
                        'Email'=>'email',
    		            'Teléfono'=>'phone',
    		            'Roles'=>'roles',
    		            'Bloqueado'=>'blocked_at'
    		        ],
    		        [
    		            'Nombre'=>'displayname',
    		            'Email'=>'email',
    		            'Teléfono'=>'phone',
    		            'Roles'=>'roles',
    		            'Bloqueado'=>'blocked_at'
    		        ],
    		        'Nombre',
    		        'Nombre'    		        
    		        );   		
    		  } ?>
    		 			
    			<table class="table w100">
    				<tr>
    					<th>Nombre</th>
    					<th>Email</th>
    					<th>Teléfono</th>
    					<th>Roles</th>
    					<th>Bloqueado</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($users as $user){?>
    				<tr>
    					<td><a href='/User/show/<?= $user->id ?>'><?=$user->displayname?></a></td>
    					<td><?= $user->email ?></td>
    					<td><?= $user->phone ?></td>
    					<td><?= $user->roles ?></td>
    					<td><?= $user->blocked_at ?></td>
    					<td class="centrado">
    						<a class='button' href='/User/show/<?= $user->id ?>'tittle="Ver">
    							<i class="fas fa-eye"></i></a> -
    						<a class='button' href='/User/edit/<?= $user->id ?>'tittle="Editar">
    							<i class="fas fa-edit"></i></a>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?= $paginator->ellipsisLinks() ?>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay usuarios que mostrar.</p>
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