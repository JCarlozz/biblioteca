<?php
class LibroController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(){
        
        $libros = Libro::orderBy('titulo', 'ASC');
        
        return view('libro/list', [
            'libros'=>$libros
        ]);
    }
    
    public function show(int $id=0){
        
        $libro = Libro::findOrFail($id, "No se encontró el libro indicado.");
        
        return view('libro/show',[
            'libro' => $libro
        ]);
    }
    
    public function create(){
        return view('libro/create');

    }
    
    public function store(){
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
        
            $libro = new Libro();       //crea el Libro
            
            
            //toma los datos que llegan por POST
            $libro->isbn            =request()->post('isbn');
            $libro->titulo          =request()->post('titulo');
            $libro->editorial       =request()->post('editorial');
            $libro->autor           =request()->post('autor');
            $libro->idioma          =request()->post('idioma');
            $libro->edicion         =request()->post('edicion');
            $libro->anyo            =request()->post('anyo');
            $libro->edadrecomendada =request()->post('edadrecomendada');
            $libro->paginas         =request()->post('paginas');
            $libro->caracteristicas =request()->post('caracteristicas');
            $libro->sinopsis        =request()->post('sinopsis');
       
        //intenta guardar el libro, en caso que la inserción falle vamos a
        //evitar ir a la página de error y volver al formulario "nuevo libro"
            
        try{
            
            //guarda el libro en la base de datos
            $libro->save();
            
            //flashea un mensaje de éxito en sesión            
            Session::success("Guardado del libro $libro->titulo correcto.");
            
            //redirecciona a los detalles del nuevo libro
            return redirect("/Libro/show/$libro->id");
            
        //si falla el guardado del libro
        }catch (SQLException $e){
            
            //flashea un mensaje de error en sesión
            Session::error("No se pudo guardar el libro $libro->titulo.");
            
            //si está en modo DEBUG vuelve a lanzar la excepción
            //esto hará que acabemos en la página de error
            if(DEBUG)
                throw new SQLException($e->getMessage());
            
            //regresa al formulario de creación de libro
            //los valores no deberián haberse borrado si usamos los helpers old()
            return redirect("/Libro/create");
        }
    }
}