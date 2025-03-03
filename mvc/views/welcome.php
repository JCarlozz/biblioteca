<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Portada - <?= APP_NAME ?></title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Portada en <?= APP_NAME ?>">
		<meta name="author" content="Robert Sallent">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/logo.png" type="image/png">	
		
		<!-- CSS -->
		<?= $template->css() ?>
	</head>
	<body>
		<?= $template->header('Portada') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs() ?>
		<?= $template->messages() ?>
		<?= $template->acceptCookies() ?>
		
		<main>
    		<h1><?= APP_NAME ?></h1>

    		<section>
        		<h2>Bienvenido!</h2>
        		
        		<p>Como parte del curso de Aplicaciones Web en el CIFO de Sabadell, hemos desarrollado un ejercicio práctico basado en la gestión 
        		de una biblioteca. Este proyecto permite administrar libros, socios y préstamos mediante un sistema web con una interfaz intuitiva 
        		y funcional. La aplicación está diseñada para facilitar la organización de los recursos bibliográficos y mejorar la eficiencia en el 
        		control de los ejemplares disponibles.</p>

				<p>El sistema implementa un CRUD (Create, Read, Update, Delete) completo, lo que permite crear, visualizar, modificar y eliminar 
				registros de libros, socios y préstamos. A través de una base de datos estructurada, los usuarios pueden consultar información sobre 
				cada ejemplar, registrar nuevos socios y llevar un seguimiento detallado de los préstamos activos. Además, se han incorporado medidas 
				para evitar la eliminación de libros que aún tengan ejemplares en circulación, garantizando así la integridad de los datos.</p>

				Para asegurar un acceso adecuado a las funcionalidades, el sistema incorpora roles de usuario con diferentes niveles de permisos. 
				Los administradores tienen control total sobre la gestión de la biblioteca, pudiendo realizar cualquier operación dentro del sistema. 
				Los empleados pueden gestionar préstamos y devoluciones, mientras que los socios registrados tienen acceso a su historial de préstamos y 
				la posibilidad de consultar la disponibilidad de libros. Esta diferenciación de roles permite una administración eficiente y segura del 
				sistema.</p>

				<p>Este ejercicio no solo ha servido para aplicar conocimientos sobre desarrollo web, sino que también ha reforzado el uso de tecnologías 
				como PHP, MySQL, HTML, CSS y JavaScript, además del manejo de frameworks y herramientas que optimizan la creación de aplicaciones 
				dinámicas. Gracias a este proyecto, los participantes del curso han adquirido experiencia práctica en el desarrollo de aplicaciones 
				CRUD con gestión de roles, preparándolos para futuras implementaciones en entornos reales.</p>
           </section>
          </main>
            
    
		<?= $template->footer() ?>
		<?= $template->version() ?>
		
	</body>
</html>

