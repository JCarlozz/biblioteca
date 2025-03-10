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
		<div>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Lista completa de préstamos</h2>
    		
    		<p><a class="button right" href="/Prestamo/create/">Nuevo préstamo</a></p>
		</div>
    		<?php if ($prestamos) { ?>
    		
    			<!-- Enlaces creados por el paginador -->
    		<div class="right">
    			<?= $paginator->stats() ?>
    		</div>
    		
    		<?php 
    		if ($filtro){
    		    echo $template->removeFilterForm($filtro, '/Prestamo/list');
    		    
    		}else{
    		    echo $template->filterForm(
    		        [
    		            'Titulo'=>'titulo',
                        'Nombre'=>'nombre',
    		            'Apellidos'=>'apellidos',
    		            'Limite'=>'limite'
    		        ],
    		        [
    		            'Titulo'=>'titulo',
    		            'Nombre'=>'nombre',
    		            'Apellidos'=>'apellidos',
    		            'Limite'=>'limite'
    		        ],
    		        'Titulo',
    		        'Titulo'    		        
    		        );   		
    		  } ?>
    			
    			<table class="table w100">
    				<tr>
    					<th>ID</th>
    					<th>Título</th>
    					<th>Nombre</th>
    					<th>Apellidos</th>
    					<th>Préstamo</th>
    					<th>Devolución</th>
    					<th>Limite</th> 
    					<th>Operación</th>   					
    				</tr>
    			<?php foreach ($prestamos as $prestamo){?>
    				<tr>
    					<td><?= $prestamo->id ?></td>
    					<td><?= $prestamo->titulo?></td>
    					<td><?= $prestamo->nombre ?></td>
    					<td><?= $prestamo->apellidos ?></td>
    					<td><?= $prestamo->prestamo ?></td>
    					<td><?= $prestamo->devolucion ?></td>
    					<td><?= $prestamo->limite ?></td>
    					<td class="centered">
                            <?php if (empty($prestamo->devolucion)) { ?>
                                <form method="POST" action="/Prestamo/update">
                                    <input type="hidden" name="actualizar" value="1">
                                    <input type="hidden" name="id" value="<?= $prestamo->id ?>">
                                    <button type="submit" class="button" name="devuelto">Devuelto</button>
                                    <button type="submit" class="button" name="mas_tiempo">Más tiempo</button>
                                </form>
                            <?php } else { ?>
                                <span class="button-success">Devuelto</span>
                            <?php } ?>
                        </td>	 
    				</tr>
    			<?php } ?>    			
    			</table>
    			<?= $paginator->ellipsisLinks() ?>
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