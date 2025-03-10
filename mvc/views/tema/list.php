<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de temas - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de temas') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
		<div>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de temas</h2>
    		
    		<?php if(Login::oneRole(['ROLE_LIBRARIAN', 'ROLE_ADMIN'])){?>    		
    		<p><a class="button right" href="/Tema/create/">Nuevo tema</a></p>
		</div>
			<?php }?>
    		<?php if ($temas) { ?>
    		
    		<div class="right">
    			<?= $paginator->stats() ?>
    		</div>
    		
    		<?php 
    		if ($filtro){
    		    echo $template->removeFilterForm($filtro, '/Tema/list');
    		    
    		}else{
    		    echo $template->filterForm(
    		        [
    		            'Tema'=>'tema',
                        'Descripción'=>'descripcion'    		              		            
    		        ],
    		        [
    		            'Tema'=>'tema',
    		            'Descripción'=>'descripcion'
    		        ],
    		        'Tema',
    		        'Tema'    		        
    		        );   		
    		  } ?>
    		 			
    			<table class="table w100">
    				<tr>
    					<th>Tema</th>
    					<th>Descripción</th>
    					<th class="centrado">Operaciones</th>
    				</tr>
    			<?php foreach ($temas as $tema){?>
    				<tr>
    					<td><a href='/Tema/show/<?= $tema->id ?>'><?=$tema->tema?></a></td>
    					<td><?= $tema->descripcion ?></td>
    					<td class="centrado">
    						<a class='button' href='/Tema/show/<?= $tema->id ?>'tittle="Ver">
    							<i class="fas fa-eye"></i></a>
    							<?php if(Login::oneRole(['ROLE_LIBRARIAN', 'ROLE_ADMIN'])){?> -
    						<a class='button' href='/Tema/edit/<?= $tema->id ?>'tittle="Editar">
    							<i class="fas fa-edit"></i></a> -
    						<a class='button' href='/Tema/delete/<?= $tema->id ?>'tittle="Eliminar">
    							<i class="fas fa-trash-alt"></i></a>
    							<?php }?>
    					</td>
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?= $paginator->ellipsisLinks() ?>
    			<?php }else{?>
    				<div class="danger p2">
    					<p>No hay temas que mostrar.</p>
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