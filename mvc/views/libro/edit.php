<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de libros - <?= APP_NAME ?></title>
		
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
		<?= $template->header("Edicion del $libro->titulo") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros'=>'/libro',
		    $libro->titulo=>'titulo',
		    'Edición'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Edición de libro<?= $libro->titulo?></h2>
    		
    		<form method="POST" action="/Libro/update">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$libro->id?>">
    					
    			
    			<label>ISBN</label>
    			<input type="text" name="isbn" value="<?=old('isbn', $libro->isbn)?>">
    			<br>
    			<label>Título</label>
    			<input type="text" name="titulo" value="<?=old('titulo', $libro->titulo)?>">
    			<br>
    			<label>Editorial</label>
    			<input type="text" name="editorial" value="<?=old('editorial', $libro->editorial)?>">
    			<br>
    			<label>Autor</label>
    			<input type="text" name="autor" value="<?=old('autor', $libro->autor)?>">
    			<br>
    			<label>Idioma</label>
    			<input type="text" name="idioma" value="<?=old('idioma',$libro->idioma)?>">
    			<br>
    			<label>Edición</label>
    			<input type="number" name="edicion" value="<?=old('edicion', $libro->edicion)?>">
    			<br>
    			<label>Año</label>
    			<input type="number" name="anyo" value="<?=old('anyo', $libro->anyo)?>">
    			<br>
    			<label>Edad rec.</label>
    			<input type="number" name="edadrecomendada"
    				value="<?=old('edadrecomendado', $libro->edadrecomendada)?>">
    			<br>
    			<label>Páginas</label>
    			<input type="number" name="paginas" value="<?=old('paginas', $libro->paginas)?>">
    			<br>
    			<label>Caracte.</label>
    			<input type="text" name="caracteristicas" 
    					value="<?=old('caracteristicas', $libro->caracteristicas)?>">
    			<br>
    			
    			<label>Sinopsis</label>
    			<textarea name="sinopsis" class="w50"><?=old('sinopsis', $libro->sinopsis)?></textarea>
    			<br>
    			<div class="centrado my2">
    				<input type="submit" class="button" name="actualizar" value="Actualizar">
    				<input type="reset" class="button" value="Reset">
    			</div>
    		</form>
    		<section>
    			<script>
    				function confirmar(id){
    					if(confirm('Seguro que deseas eliminar?'))
    						location.href='/Ejemplar/destroy/'+id
    				}
    			</script>
    			<section>
    			<h2>Temas tratados en <?= $libro->titulo?></h2>
    			<?php 
    			if(!$temas){
    			    echo "<div class='warning p2'><p>No se han indicado temas.</p></div>";
    			}else{ ?>
    				<table class="table w100">
    					<tr>
    						<th>ID</th><th>Tema</th><th>Operaciones</th>
    					</tr>
    				<?php foreach($temas as $tema){?>
    					<tr>
    						<td><?=$tema->id ?></td>
    						<td><a href='/Tema/show/<?=$tema->id?>'>
    							<?=$tema->tema?></a>
    						</td>
    						<td class="centrado">
    							<form method="POST" class="no-border" action="/Libro/removetema">
    								<input type="hidden" name="idlibro" value="<?=$libro->id?>">
    								<input type="hidden" name="idtema" value="<?=$tema->id?>">
    								<input type="submit" class="button-danger" name="remove" value="Borrar">
    							</form>
    						</td>	
    					</tr>
    				<?php }?>    				
    				</table>
    			<?php }?> 
    			<form class="w50 m0 no-border" method="POST" action="/Libro/addtema">
    				<input type="hidden" name="idlibro" value="<?= $libro->id?>">
    				<select name="idtema">
    				<?php 
    				    foreach ($listaTemas as $nuevoTema)
    				        echo "<option value='$nuevoTema->id'>$nuevoTema->tema</option>\n";
    				?>
    				</select>
    				<input class="button-success" type="submit" name="add" value="Añadir tema">
    			</form>   		
    		</section>
    		
    			    				
    			<h2>Ejemplares de <?= $libro->titulo?></h2>
    				
    			<a class="button" href="/Ejemplar/create/<?=$libro->id?>">
    				Nuevo Ejemplar
    			</a>
    			
    			<?php 
    			if (!$ejemplares){
    			    echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
    			}else{?>
    				
    				<table class="table w100 centered-block">
    					<tr>    					
    						<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th>
    					</tr>
    					
    				<?php foreach($ejemplares as $ejemplar){?>			     			     	
        				<tr>
        					<td><?=$ejemplar->id?></td>
        					<td><?=$ejemplar->anyo?></td>
        					<td><?=$ejemplar->precio?></td>
        					<td><?=$ejemplar->estado?></td>
        					
        				</tr>
        			<?php } ?>		
				</table>
				<?php } ?>
			</section>
			
    				
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Libro/list">Lista de libros</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

