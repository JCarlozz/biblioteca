<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel de control - <?= APP_NAME ?></title>
		
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
		    'Panel de contro'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Panel de contro</h2>
			
			<section class="three-columns">
				
                <div class="p1 box-shadow">
                    <h2>Libros</h2>
                    <h3><a href="/Libro/list/">Lista de libros.</a></h3>
                    <h3><a href="/Libro/create/">Nuevo libo.</a></h3>
                </div>
                <div class="p1 box-shadow">
                    <h2>Socios</h2>
                    <h3><a href="/Socio/list/">Lista de socios.</a></h3>
                    <h3><a href="/Socio/create/">Nuevo socio.</a></h3>
                </div>
                <div class="p1 box-shadow">
                    <h2>Temas</h2>
                    <h3><a href="/Tema/list/">Lista de temas.</a></h3>
                    <h3><a href="/Tema/create/">Nuevo tema.</a></h3>
                </div>
               
            </section>
            
            <div class="centred">
    				<a class="button" onclick="history.back()">Atrás</a>
    		</div>
    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>