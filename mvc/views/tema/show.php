<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de temas - <?= APP_NAME ?></title>
		
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
		<?= $template->header('Lista de temas') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas'=> '/tema',
		    $tema->tema =>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section>
    			<h2><?=$tema->tema?></h2>
    			
    			<p><b>Tema:</b>			<?=$tema->tema?></p>
    			<p><b>Descripción:</b>	<?=$tema->descripcion?></p>
    		</section>
    		<section>
    			<h2>Libros que tratados del tema <?= $tema->tema?></h2>
    			<?php 
    			if(!$libros){
    			    echo "<div class='warning p2'><p>No se han indicado temas.</p></div>";
    			}else{ ?>
    				<table class="table w100">
    					<tr>
    						<th>Titulo</th><th>Tema</th><th>Operaciones</th>
    					</tr>
    				<?php foreach($libros as $libro){?>
    					<tr>
    						<td><?=$libro->titulo ?></td>
    						<td><a href='/Tema/show/<?=$libro->id?>'>
    							<?=$tema->tema?></a>
    						</td>
    						<td class="centrado">
    							<form method="POST" class="no-border" action="/Libro/removetema">
    								<input type="hidden" name="idlibro" value="<?=$libro->id?>">
    								<input type="hidden" name="idtema" value="<?=$tema->id?>">
    								<?php if(Login::oneRole(['ROLE_LIBRARIAN'])){?>
    								<input type="submit" class="button-danger" name="remove" value="Borrar">
    								<?php } ?>
    							</form>
    						</td>	
    					</tr>
    				<?php }?>    				
    				</table>
    			<?php }?>    			  		
    		</section>
    		
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/Tema/list/">Lista de temas</a>
    			<a class="button" href="/Tema/edit/<?= $tema->id?>">Editar</a>
    			<a class="button" href="/Tema/delete/<?= $tema->id?>">Borrar</a>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>