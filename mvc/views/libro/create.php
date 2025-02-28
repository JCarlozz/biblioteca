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
		    'Libros'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Nuevo libro</h2>
			
			<form method="POST" enctype="multipart/form-data" action="/Libro/store">
				<div class="flex2">
					<label>ISBN</label>
					<input type="text" name="isbn" value="<?=old('isbn')?>">
					<br>
					<label>Título</label>
					<input type="text" name="titulo" value="<?=old('titulo')?>">
					<br>
					<label>Editorial</label>
					<input type="text" name="editorial" value="<?=old('editorial')?>">
					<br>
					<label>Autor</label>
					<input type="text" name="autor" value="<?=old('autor')?>">
					<br>
					<label>Idioma</label>
					<select name="idioma">
						<option value="Castellano" <?=oldSelected('idioma','Castellano')?>>
							Castellano</option>
						<option value="Catalán" <?=oldSelected('idioma','Catalán')?>>
							Catalán</option>
						<option value="Otros" <?=oldSelected('idioma','Otros')?>>
							Otros</option>
					</select>
					<br>
					<label>Edición</label>
					<input type="number" name="edicion" value"<?=old('edicion')?>">
					<br>
					<label>Año</label>
					<input type="number" name="anyo" value"<?=old('anyo')?>">
					<br>
					<label>Edad rec.</label>
					<input type="number" name="edadrecomendada"
							value"<?=old('edadrecomendado')?>">
					<br>
					<label>Páginas</label>
					<input type="number" name="paginas" value"<?=old('paginas')?>">
					<br>
					<label>Caracte.</label>
					<input type="text" name="caracteristicas" 
							value"<?=old('caracteristicas')?>">
					<br>
					<label>Sinopsis</label>
					<textarea name="sinopsis" class="w50"><?=old('sinopsis')?></textarea>
					<br>
					<div class="centrado my2">
						<input type="submit" class="button" name="guardar" value="Guardar">
						<input type="reset" class="button" value="Reset">
					</div>    
				</div>
			</div>			
			</form>
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/Libro/list">Lista de libros</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
