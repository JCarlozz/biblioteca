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
        
        $ejemplares= $libro->hasMany('Ejemplar');
                
        return view('libro/show',[
            'libro'         => $libro,
            'ejemplares'    => $ejemplares
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
    
    public function edit(int $id=0){
        
        //busca el libro con ese ID
        $libro = Libro::findOrFail($id, "No se encontró el libro.");
        
        $ejemplares= $libro->hasMany('Ejemplar');
        
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('libro/edit',[
            'libro'         => $libro,
            'ejemplares'    => $ejemplares
        ]);
    }
    
    public function update(){
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $libro= Libro::findOrFail($id, "No se ha encontrado el libro.");
            
            $libro->isbn                =request()->post('isbn');
            $libro->titulo              =request()->post('titulo');
            $libro->editorial           =request()->post('editorial');
            $libro->autor               =request()->post('autor');
            $libro->idioma              =request()->post('idioma');
            $libro->edicion             =request()->post('edicion');
            $libro->anyo                =request()->post('anyo');
            $libro->edadrecomendada     =request()->post('edadrecomendada');
            $libro->paginas             =request()->post('paginas');
            $libro->caracteristicas     =request()->post('caracteristicas');
            $libro->sinopsis            =request()->post('sinopsis');
            
            //intenta actualizar el libro
            try{
                $libro->update();
                Session::success("Actualización del libro $libro->titulo correcta.");
                return redirect("/Libro/edit/$id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del libro $libro->titulo.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Libro/edit/$id");
            }
    }
    
    public function delete(int $id = 0){
        
        $libro = Libro::findOrFail($id, "No existe el libro.");
        
        return view('libro/delete', [
            'libro'=>$libro
        ]);
    }
    
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $libro = Libro::findOrFail($id);            //recupera el libro
            
            //sie lelibro tiene ejemplares, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            if ($libro->hasAny('Ejemplar'))
                throw new Exception("No se puede borrar el libro mientras tenga ejemplares.");
                
                try{
                    $libro->deleteObject();
                    Session::success("Se ha borrado el libro $libro->titulo.");
                    return view("/Libro/list");
                    
                }catch (SQLException $e){
                    
                    Session::error("No se pudo borrar el libro $libro->titulo.");
                    
                    if (DEBUG)
                        throw new SQLException($e->getMessage());
                        
                        return redirect("/Libro/delete/$id");
                        
                }
    }
}