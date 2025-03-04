<?php
class PrestamoController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(){
        
        $prestamos = V_prestamo::orderBy('devolucion', 'DESC');
        
        return view('prestamo/list', [
            'prestamos' => $prestamos
        ]);
    } 
    
    public function create(){
        return view('prestamo/create');
        
    }
    
    public function store(){
        
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
}