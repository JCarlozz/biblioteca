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
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<section>
    			<h2><?= $socio->nombre. $socio->apellidos?></h2>
    			
    			<p><b>DNI:</b>				<?=$socio->dni?></p>
    			<p><b>Nombre:</b>			<?=$socio->nombre?></p>
                <p><b>Apellidos:</b>		<?=$socio->apellidos?><p>
                <p><b>Fecha de nacimiento:</b><?$socio->nacimiento?><p>
                <p><b>Email:</b>			<?=$socio->email?></p>
    			<p><b>Dirección:</b>		<?=$socio->direccion?></p>
                <p><b>Codigo Postal:</b>	<?=$socio->cp?><p>
                <p><b>Población:</b>		<?=$socio->poblacion?><p>
                <p><b>Provincia:</b>		<?=$socio->provincia?></p>
    			<p><b>Teléfono:</b>			<?=$socio->telefono?></p>
            </section>
    		    		
    		<div class="centrado">
    			<a class="button" onclick="history.back()">Atrás</a>
    			<a class="button" href="/socio/list/">Lista de socios</a>
    			<a class="button" href="/socio/edit/<?= $socio->id?>">Editar</a>
    			<a class="button" href="/socio/delete/<?= $socio->id?>">Borrar</a>    		
    		</div>
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>		
	</body>
</html>