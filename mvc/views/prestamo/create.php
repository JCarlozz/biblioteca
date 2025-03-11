<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de préstamos - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
		<script>
    			window.addEventListener('load', function () {
                    idsocio.addEventListener('change', function () {
                        fetch("/Prestamo/checkidsocio/" + this.value, {
                            method: "GET"
                            })
    					.then(function(respuesta){
                			return respuesta.json();
                		})
                		.then(function(json){
                			if(json.status == 'OK')
                				comprobacionidsocio.innerHTML =
                					json.data.found ? `${json.data.nombre} ${json.data.apellidos}` : '';
    						else
    							comprobacionidsocio.innerHTML = 'No se pudo comprobar.';
        					});
        				});
        			});		
       	</script>
       	<script>
    			window.addEventListener('load', function () {
                    idejemplar.addEventListener('change', function () {
                        fetch("/Prestamo/checkidejemplar/" + this.value, {
                            method: "GET"
                            })
    					.then(function(respuesta){
                			return respuesta.json();
                			
                			
                		})
                		.then(function(json){
                             if(json.status == 'OK')
                        	     comprobacionidejemplar.innerHTML =
                            	     json.data.found ? `${json.data.titulo}` : '';
                             else
                                 comprobacionidejemplar.innerHTML = 'No se pudo comprobar.';
                            });
        				});
        			});		
       	</script>
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de préstamos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Nuevo préstamo'=> NULL
		]) ?>
		<?= $template->messages() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>
    		<h2>Nuevo préstamos</h2>
			
			<form method="POST" enctype="multipart/form-data" action="/Prestamo/store">
				<div class="flex2">
					<label>ID socio</label>
					<input type="number" name="idsocio" id="idsocio" value="<?=old('idsocio')?>">
					<output id="comprobacionidsocio" class="mini"></output>					
					<br>					
										
					<label>ID Ejemplar</label>
					<input type="number" name="idejemplar" id="idejemplar" value="<?=old('idejemplar')?>">					
					<output id="comprobacionidejemplar" class="mini"></output>
					<br>
					
					<label>Fecha de devolución</label>
					<input type="date" name="limite" value="<?= date('Y-m-d', strtotime('+15 days')) ?>">
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
				<a class="button" href="/Prestamo/list">Lista de prestamos</a>
			</div>    		
		</main>
		<?= $template->footer() ?>
		<?= $template->version() ?>	
	</body>
</html>
