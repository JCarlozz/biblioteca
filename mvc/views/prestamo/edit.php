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
		<?= $template->header("Edicion del $prestamo->titulo") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Prestamos'=>'/prestamos',
		    $prestamo->titulo=>NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Edición del préstamo<?= $prestamo->prestamo?></h2>
    		
    		<form method="POST" action="/Libro/update">
			
    			<!-- input oculto que contiene ID -->
    			<input type="hidden" name="id" value="<?=$prestamo->id?>">
    			    			    			
    			<label>Título</label>
    			<input type="text" name="titulo" value="<?=old('titulo', $prestamo->titulo)?>">
    			<br>
    			<label>Nombre</label>
    			<input type="text" name="nombre" value="<?=old('nombre', $prestamo->nombre)?>">
    			<br>
    			<label>Apellidos</label>
    			<input type="text" name="apellidos" value="<?=old('apellidos', $prestamo->apellidos)?>">
    			<br>
    			<label>Fecha de devolución</label>
    			<input type="date" name="devolucion" value="<?=old('devolucion',$prestamo->devolucion)?>">
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
    			    				
    			<h2>Prestamo de <?= $prestamo->titulo?></h2>
    				
    			<a class="button" href="/Prestamo/create/<?=$prestamo->id?>">
    				Nuevo Prestamo
    			</a>    			
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

