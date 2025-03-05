<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de socio. <?=$socio->nombre?> - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		<script src="/js/BigPicture.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios'=> '/socio',
		    $socio->nombre. $socio->apellidos =>NULL
		     
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<div class=flex-container></div>
        		<h1 class="flex2"><?= APP_NAME ?></h1>
        		<div class="flex2 derecha">    			
        			<a class="button" href="/Socio/edit/<?= $socio->id?>">Editar</a>   			    		
        		</div>
    		</div>
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
        			<h2><?=$socio->nombre?> <?=$socio->apellidos?></h2>
        			
        			<p><b>DNI:</b>				<?=$socio->dni?></p>
        			<p><b>Nombre:</b>			<?=$socio->nombre?></p>
                    <p><b>Apellidos:</b>		<?=$socio->apellidos?><p>
                    <p><b>Fecha de nacimiento:</b><?=$socio->nacimiento?><p>
                    <p><b>Email:</b>			<?=$socio->email?></p>
        			<p><b>Dirección:</b>		<?=$socio->direccion?></p>
                    <p><b>Codigo Postal:</b>	<?=$socio->cp?><p>
                    <p><b>Población:</b>		<?=$socio->poblacion?><p>
                    <p><b>Provincia:</b>		<?=$socio->provincia?></p>
        			<p><b>Teléfono:</b>			<?=$socio->telefono?></p>
    			</div>
    			<figure class="flex1 centrado p2">
    				<img src="<?=MEMBERS_IMAGE_FOLDER.'/'.($socio->foto ?? DEFAULT_MEMBERS_IMAGE)?>"
    					class="cover enlarge-image"
    					alt="Foto del socio <?=$socio->nombre.' '. $socio->apellidos?>">
    				<figcaption>Foto del socio <?="$socio->nombre $socio->apellidos"?></figcaption>
    			</figure>
            </section>
            <section>
    		<table class="bloquecentradow100">
				<tr>			
    				<h2>Prestamos de <?= $socio->nombre?> <?= $socio->apellidos?></h2>
    			</tr>
    				<?php 
    				if (!$prestamos){
    				    echo "<div class='warning p2'><p>No hay prestamos de este socio.</p></div>";
    				}else{?>
    				
    				<table class="table w100 centered-block">
    					<tr>    					
    						<th>ID</th><th>Limite</th><th>Devolución</th><th>Libro</th><th>Incidencia</th>
    					</tr>
    					<?php
    					foreach($prestamos as $prestamo){?>			     			     	
        				<tr>
        					<td><?=$prestamo->id?></td>
        					<td><?=$prestamo->limite?></td>
        					<td><?=$prestamo->devolucion?></td>
        					<td><?=$prestamo->titulo?></td>
        					<td><?=$prestamo->incidencia?></td>        					
        				</tr>
        			<?php } ?>
        			<div class="p1 right">
        				Existen <?= sizeof($prestamos)?> prestamos de este socio.
        			</div>
        					
					</table>
				<?php } ?>
				</table>								
			</section>
			
			
			
    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/Socio/list/">Lista de socios</a>
    			<a class="button" href="/Socio/edit/<?= $socio->id?>">Editar</a>
    			<a class="button" href="/Socio/delete/<?= $socio->id?>">Borrar</a>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>