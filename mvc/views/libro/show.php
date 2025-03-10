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
		<script src="/js/BigPicture.js"></script>
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
    		<section id="detalles" class="flex-container gap2">
    			<div class="flex2">
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
    			</div>
    			<figure class="flex1 centrado p2">
    				<img src="<?=BOOK_IMAGE_FOLDER.'/'.($libro->portada ?? DEFAULT_BOOK_IMAGE)?>"
    					class="cover enlarge-image"
    					alt="Portada del libro <?=$libro->titulo?>">
    				<figcaption>Portada de <?="$libro->titulo, de $libro->autor"?></figcaption>
    			</figure>
    		</section>
    		
    		<section>
    			<h2>Sinosis</h2>
    			<p><?=$libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>   		
    		</section>
    		
    		<section id="temas">
    			<h2>Temas tratados en <?= $libro->titulo?></h2>
    			<?php 
    			if(!$temas){
    			    echo "<div class='warning p2'><p>No se han indicado temas.</p></div>";
    			}else{ ?>
    				<table class="table w100">
    					<tr>
    						<th>ID</th><th>Tema</th>
    					</tr>
    				<?php foreach($temas as $tema){?>
    					<tr>
    						<td><?=$tema->id ?></td>
    						<td><a href='/Tema/show/<?=$tema->id?>'><?=$tema->tema?></a>
    						</td>    							
    					</tr>
    				<?php }?>    				
    				</table>
    			<?php }?>    		
    		</section>		
    		<?php if(Login::oneRole(['ROLE_LIBRARIAN'])){?>
    		<section>
    			<script>
    				function confirmar(id){
    					if(confirm('Seguro que deseas eliminar?'))
    						location.href ='/Ejemplar/destroy/'+id
    				}
    			</script> 		
							
    			<h2>Ejemplares de <?= $libro->titulo?></h2>
    				<?php if(Login::oneRole(['ROLE_LIBRARIAN'])){?>    			
    				<a class="button" href="/Ejemplar/create/<?=$libro->id?>">
    					Nuevo ejemplar
    				</a>
    				<?php } ?>
    				<?php 
    			 	if (!$ejemplares){
    				    echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
    				}else{ ?>    				
        				<table class="table w100 centered-block">
        					<tr>    					
        						<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th><th>Operaciones</th>
        					</tr>        					
        				<?php foreach($ejemplares as $ejemplar){ ?>			     			     	
            				<tr>
            					<td><?=$ejemplar->id?></td>
            					<td><?=$ejemplar->anyo?></td>
            					<td><?=$ejemplar->precio?></td>
            					<td><?=$ejemplar->estado?></td>
            					<td class="centered">
                                    <?php if (!$ejemplar->hasAny('Prestamo')) { ?>
                                        <a class="button" onclick="confirmar(<?= $ejemplar->id ?>)">Borrar</a>
                                    <?php } else { ?>
                                        <a class="button-warning" href="/Ejemplar/incidencia/<?= $ejemplar->id ?>">Incidencia</a>
                                    <?php } ?>
                                </td>
            				</tr>            			
            			<?php } ?>
            			</table>
            		<?php } ?>
            	</section>
				<?php } ?>
    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<?php if(Login::oneRole(['ROLE_LIBRARIAN'])){?>
    			<a class="button" href="/libro/list/">Lista de libros</a>
    			<a class="button" href="/libro/edit/<?= $libro->id?>">Editar</a>
    			<a class="button" href="/libro/delete/<?= $libro->id?>">Borrar</a> 
    			<?php } ?>   		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>