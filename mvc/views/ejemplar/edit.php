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
		<script src="/js/Preview.js"></script>
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header("Edicion del $libro->titulo") ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros'=>'/libro',
		    $libro->titulo=>"/Libro/show/$libro->id",
		    'Incidencia'=>NULL
		]) ?>
		<?= $template->messages() ?>
		
    		<main>
                <h2>Reportar incidencia - Ejemplar ID <?= $ejemplar->id ?></h2>
                
                <form method="POST" action="/Ejemplar/guardarIncidencia">
                    <input type="hidden" name="id" value="<?= $ejemplar->id ?>">
                    
                    <label>Describa la incidencia:</label>
                    <textarea name="descripcion" rows="5" required></textarea>
                    
                    <div class="centrado my2">
                        <button type="submit" class="button-warning">Guardar Incidencia</button>
                        <a class="button" onclick="history.back()">Cancelar</a>
                    </div>
                </form>
            </main>

		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>

