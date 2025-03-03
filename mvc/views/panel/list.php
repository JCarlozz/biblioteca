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
		
		<?= $template->header('Panel de control') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel de control'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Panel de control</h2>
    		
    		<section class="three-columns">
    		  <div>
        		<div class="table w100">
        			<ul>
        				<h2>Libros</h2>    						
    			        <li><a href="/Libro/list/">Lista de libros.</a></li>
                        <li><a href="/Libro/create/">Nuevo libo.</a></li>
                    </ul>
                </div>
            
                <div class="table w100">	
                    <ul>	
                    	<h2>Socios</h2>    				
                        <li><a href="/Socio/list/">Lista de socios.</a></li>
                        <li><a href="/Socio/create/">Nuevo socio.</a></li>
                    </ul>
                </div>
            
                <div class="table w100">
                    <ul>                    
                        <h2>Temas</h2>    			                
                        <li><a href="/Tema/list/">Lista de temas.</a></li>
                        <li><a href="/Tema/create/">Nuevo tema.</a></li>
                    </ul>                
                </div>
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