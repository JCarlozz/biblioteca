<?php
class PrestamoController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        
        Auth::oneRole(['ROLE_LIBRARIAN','ROLE_ADMIN']);
        
        //analiza si hay filtro
        $filtro = Filter::apply('prestamos');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera   de libros que cumplen los criterios del filtro
            $total = V_prestamo::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Prestamo/list', $page, $limit, $total);
            
            //recupera los libros que cumplen los criterios del filtro
            $prestamos = V_prestamo::filter($filtro, $limit, $paginator->getOffset());
            
            //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = V_prestamo::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Prestamo/list', $page, $limit, $total);
            
            //recupera todos los libros
            $prestamos = V_prestamo::orderBy('titulo', 'ASC', $limit, $paginator->getOffset());
            
        }
        //carga la vista
        return view('prestamo/list', [
            'prestamos'    => $prestamos,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
    
    
    public function create(){
        
        Auth::oneRole(['ROLE_LIBRARIAN','ROLE_ADMIN']);
        
        return view('prestamo/create');
        
    }
    
    public function store(){
        
        Auth::oneRole(['ROLE_LIBRARIAN','ROLE_ADMIN']);
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibieron los datos del préstamo');
            
            $prestamo = new V_prestamo();       //crea el prestamo
            
            
            //toma los datos que llegan por POST
            $prestamo->idsocio          =request()->post('idsocio');
            $prestamo->idejemplar       =request()->post('idejemplar');
            $prestamo->limite           =request()->post('limite');
            
            
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                //guarda el libro en la base de datos
                $prestamo->save();
                
                //flashea un mensaje de éxito en sesión
                Session::success("Prestamo añadido correctamente.");
                
                //redirecciona a los detalles del nuevo libro
                return redirect("/Prestamo/list/");                
           
                
                //si falla el guardado del libro
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo añadir el prestamo.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Presatmo/create/");
            }
    }
    
    public function reminder($id){
        
        Auth::oneRole(['ROLE_LIBRARIAN','ROLE_ADMIN']);
        
        // Buscar los datos del préstamo en v_prestamo
        $prestamo = V_prestamo::findOrFail($id);
        
        if (!$prestamo) {
            Session::error("No se encontró el préstamo.");
            return redirect("/Prestamo/list");
        }
        
        // Mensaje
        $subject = "Recordatorio de devolución de libro $prestamo->titulo";
        $message = "Querido $prestamo->nombre $prestamo->apellidos,\n\n"
        . "Le recordamos que el libro '$prestamo->titulo' debía ser devuelto el $prestamo->limite.\n"
        . "Por favor, devuélvalo lo antes posible para evitar penalizaciones.\n\n"
            . "Gracias,\nBiblioteca.";
        
        $socionombre = $prestamo->nombre.'\n'.$prestamo->apellidos;
            
            try {
                $email = new Email(ADMIN_EMAIL, $prestamo->email, $socionombre, $subject, $message);
                $email->send();
                
                Session::success("Mensaje enviado a $prestamo->nombre $prestamo->apellidos.");
                return redirect("/Prestamo/list");
                
            } catch (EmailException $e) {
                Session::error("No se pudo enviar el email.");
                
                if (DEBUG) {
                    throw new EmailException($e->getMessage());
                }
                
                return redirect("/Prestamo/list");
            }
    }
    
    public function update(){
    
        Auth::oneRole(['ROLE_LIBRARIAN','ROLE_ADMIN']);
        
        if (!request()->has('actualizar')) // Si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id = intval(request()->post('id')); // Recuperar el ID vía POST
            
            $prestamo = Prestamo::findOrFail($id, "No se ha encontrado el préstamo.");
            
            try {
                // Botón "Devuelto"
                if (request()->has('devuelto')) {
                    $prestamo->devolucion = date('Y-m-d'); // Fecha actual devolución
                }
                
                // Botón más tiempo extiende 7 días
                if (request()->has('mastiempo')) {
                    $nuevaFecha = date('Y-m-d', strtotime($prestamo->limite . ' +7 days'));
                    $prestamo->limite = $nuevaFecha;
                }
                
                $prestamo->update();
                
                Session::success("Actualización del préstamo correcta.");
                return redirect("/Prestamo/list");
                
            } catch (SQLException $e) {
                Session::error("Hubo errores en la actualización del préstamo.");
                
                if (DEBUG) throw new SQLException($e->getMessage());
                
                return redirect("/Prestamo/edit/$id");
            }
    }    
}