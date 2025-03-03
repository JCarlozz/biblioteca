<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de libros - <?= APP_NAME ?></title>
		
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
		    'Libros'=>'/libro',
		    $libro->titulo=>NULL 
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section>
    			<h2><?= $libro->titulo?></h2>
    			
    			<p><b>ISBN:</b>			<?=$libro->isbn?></p>
    			<p><b>Título:</b>		<?=$libro->titulo?></p>
    			<p><b>Editorial:</b>	<?=$libro->editorial?></p>
    			<p><b>Autor:</b>		<?=$libro->autor?></p>
    			<p><b>Idioma:</b>		<?=$libro->idioma?></p>
    			<p><b>Edición:</b>		<?=$libro->edicion?></p>
    			
    			<p><b>Edad Recomendada:</b>
    			<?=$libro->edadrecomendada ?? 'Pendiente de calificación';?></p>
    		
    			<p><b>Año:</b><?=$libro->anyo ?? '--'?></p>
    			<p><b>Páginas:</b><?=$libro->paginas ?? '--'?></p>
    			<p><b>Características:</b><?=$libro->caracteristicas ?? '--'?></p>    		
    			
    		</section>
    		
    		<section>
    			<h2>Sinosis</h2>
    			<p><?=$libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>   		
    		</section>
    		<section>
    		<table class="bloquecentradow100">
				<tr>			
    				<h2>Ejemplares de <?= $libro->titulo?></h2>
    				<?php 
    				if (!$ejemplares){
    				    echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
    				}else{?>
    				
    				<table class="table w100 centered-block">
    					<tr>    					
    						<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th>
    					</tr>
    					<?php
    					foreach($ejemplares as $ejemplar){?>			     			     	
        				<tr>
        					<td><?=$ejemplar->id?></td>
        					<td><?=$ejemplar->anyo?></td>
        					<td><?=$ejemplar->precio?></td>
        					<td><?=$ejemplar->estado?></td>
        				</tr>
        			<?php } ?>
        			<div class="p1 right">
        				Existen <?= sizeof($ejemplares)?> ejemplares de este libro.
        			</div>		
				</table>
				<?php } ?>
			</section>
    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/libro/list/">Lista de libros</a>
    			<a class="button" href="/libro/edit/<?= $libro->id?>">Editar</a>
    			<a class="button" href="/libro/delete/<?= $libro->id?>">Borrar</a>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>