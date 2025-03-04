<?php
class LibroController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        //analiza si hay filtro
        $filtro = Filter::apply('libros');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera   de libros que cumplen los criterios del filtro
            $total = V_libro::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Libro/list', $page, $limit, $total);
            
            //recupera los libros que cumplen los criterios del filtro
            $libros = V_libro::filter($filtro, $limit, $paginator->getOffset());
        
        //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = V_libro::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Libro/list', $page, $limit, $total);
            
            //recupera todos los libros
            $libros = V_libro::orderBy('titulo', 'ASC', $limit, $paginator->getOffset());
            
        }
            //carga la vista
            return view('libro/list', [
                'libros'    => $libros,
                'paginator' => $paginator,
                'filtro'    => $filtro
            ]);        
    }
    
    public function show(int $id=0){
        
        $libro = Libro::findOrFail($id, "No se encontró el libro indicado.");
        
        $ejemplares= $libro->hasMany('Ejemplar');
        
        $temas = $libro->belongsToMany('Tema', 'temas_libros');
                
        return view('libro/show',[
            'libro'         => $libro,
            'ejemplares'    => $ejemplares,
            'temas'         => $temas
        ]);
    }
    
    public function create(){
        return view('libro/create',[
            'listaTemas' => Tema::orderBy('tema')
        ]);        
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
            
            //recupera el idtema del desplegable
            $idtema =   intval(request()->post('idtema'));
            
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                //guarda el libro en la base de datos
                $libro->save();
                $libro->addTema($idtema);       //le pone el tema principal
                
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
        
        $temas = $libro->belongsToMany('Tema', 'temas_libros');
        
        $listaTemas = array_diff(Tema::orderBy('tema'),$temas);
               
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('libro/edit',[
            'libro'         => $libro,
            'ejemplares'    => $ejemplares,
            'temas'         => $temas,
            'listaTemas'    => $listaTemas
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
    
    public function addtema(){
        
        if(empty(request()->post('add')))
            throw new FormException("No se recibió el formulario");
        
        $idlibro = intval(request()->post('idlibro'));
        $idtema  = intval(request()->post('idtema'));
        
        $libro   = Libro::findOrFail($idlibro, "No se encontró el libro");
        
        $tema    = Tema::findOrFail($idtema, "No se encontró el tema");
        
        try{
            $libro->addTema($idtema);
            
            Session::success("Se ha añadido $tema->tema a $libro->titulo.");
            return redirect("/Libro/edit/$idlibro");
            
        }catch(SQLException $e){
            
            Session::error("No se pudo añadir $tema->tema a $libro->titulo.");
            
            if(DEBUG)
                throw new SQLException($e->getMessage());
            
            return redirect("/Libro/edit/$idlibro");
        }
    }
    
    public function removetema(){
        
        if(empty(request()->post('remove')))
            throw new FormException("No se recibió el formulario");
            
            $idlibro = intval(request()->post('idlibro'));
            $idtema  = intval(request()->post('idtema'));
            
            $libro   = Libro::findOrFail($idlibro, "No se encontró el libro");
            
            $tema    = Tema::findOrFail($idtema, "No se encontró el tema");
            
            try{
                $libro->removetema($idtema);
                
                Session::success("Se ha eliminado el $tema->tema de $libro->titulo.");
                return redirect("/Libro/edit/$idlibro");
                
            }catch(SQLException $e){
                
                Session::error("No se pudo eliminar $tema->tema a $libro->titulo.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Libro/edit/$idlibro");
            }
    }
}