<?php
class PrestamoController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(){
        
        $prestamos = V_prestamo::orderBy('prestamo','DESC');
        
        return view('prestamo/list', [
            'presatmos' => $prestamos
        ]);
    }
    
    public function create(int $id= 0){
        
        $prestamo = V_prestamo::findOrFail($id);
        
        return view('prestamo/create', [
            'prestamo'=>$prestamo
        ]);
    }
    public function store(){
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibieron los datos del ejemplar');
            
            $prestamo = new V_prestamo();       //crea el prestamo
            
            
            //toma los datos que llegan por POST
            $prestamo->id               =intval(request()->post('id'));
            $prestamo->limite           =request()->post('limite');
            $prestamo->devolucion       =request()->post('devolucion');
            $prestamo->incidencia       =request()->post('incidencia');
            $prestamo->nombre           =request()->post('nombre');
            $prestamo->apellidos        =request()->post('apellidos');
            $prestamo->titulo           =request()->post('titulo');
            
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                //guarda el libro en la base de datos
                $ejemplar->save();
                
                //flashea un mensaje de éxito en sesión
                Session::success("Ejemplar añadido correctamente.");
                
                //redirecciona a los detalles del nuevo libro
                return redirect("/Libro/edit/$ejemplar->idlibro");
                
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
                    return redirect("/Ejemplar/create/$ejempalr->idlibro");
            }
    }
    public function destroy(int $id=0){
        
        $ejemplar = Ejemplar::findOrFail($id, "No se encontró el ejemplar.");
        
        //comprueba que llega el formulario de confirmación
        if ($ejemplar->hasAny('Prestamo', 'idejemplar'))
            throw new Exception('Este ejemplar no se puede borrar, tiene préstamos.');
            
            try{
                $ejemplar->deleteObject();
                Session::success("Ejemplar eliminado correctamente.");
                return redirect("/Libro/edit/$ejemplar->idlibro");
                
            }catch (SQLException $e){
                
                Session::error("No se pudo borrar el ejemplar.");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Libro/edit/$ejemplar->idlibro");
                    
            }
    }
}