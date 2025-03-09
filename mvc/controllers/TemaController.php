<?php
class TemaController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        //analiza si hay filtro
        $filtro = Filter::apply('temas');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera   de libros que cumplen los criterios del filtro
            $total = Tema::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Tema/list', $page, $limit, $total);
            
            //recupera los libros que cumplen los criterios del filtro
            $temas = Tema::filter($filtro, $limit, $paginator->getOffset());
            
            //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = Tema::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Tema/list', $page, $limit, $total);
            
            //recupera todos los libros
            $temas = Tema::orderBy('tema', 'ASC', $limit, $paginator->getOffset());
            
        }
        //carga la vista
        return view('tema/list', [
            'temas'    => $temas,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
         
    public function show(int $id=0){
        
        $tema = Tema::findOrFail($id, "No se encontró el tema indicado.");
        
        $libros = $tema->belongsToMany('Libro', 'temas_libros');
        
        return view('tema/show',[
            'tema' => $tema, 
            'libros'=> $libros
        ]);
    }
    
    public function create(){
        
        Auth::role(ROLE_BIBLARIAN);
        
        return view('tema/create');
        
    }
    
    public function store(){
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $tema = new Tema();       //crea el tema
            
            
            //toma los datos que llegan por POST
            $tema->tema             =request()->post('tema');
            $tema->descripcion      =request()->post('descripcion');
            
            //intenta guardar el tema, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                //guarda el libro en la base de datos
                $tema->save();
                
                //flashea un mensaje de éxito en sesión
                Session::success("Guardado del tema $tema->tema correcto.");
                
                //redirecciona a los detalles del nuevo tema
                return redirect("/Temas/show/$tema->id");
                
                //si falla el guardado del tema
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el tema $tema->tema.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de tema
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Tema/create");
            }
    }
    
    public function edit(int $id=0){
        
        //busca el tema con ese ID
        $tema = Tema::findOrFail($id, "No se encontró el tema.");
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('tema/edit', [
            'tema'=> $tema
        ]);
    }
    
    public function update(){
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $tema= Tema::findOrFail($id, "No se ha encontrado el tema.");
            
            $tema->tema                 =request()->post('tema');
            $tema->descripcion          =request()->post('descripcion');
            
            //intenta actualizar el tema
            try{
                $tema->update();
                Session::success("Actualización del tema $tema->tema correcta.");
                return redirect("/Tema/edit/$id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del tema $tema->tema.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Tema/edit/$id");
            }
    }
    
    public function delete(int $id = 0){
        
        $tema = Tema::findOrFail($id, "No existe el tema.");
        
        return view('tema/delete', [
            'tema'=>$tema
        ]);
    }
    
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $tema = Tema::findOrFail($id);            //recupera el tema
            
            //si el tema tiene libros, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            //if ($tema->hasAny('Libro'))
                //throw new Exception("No se puede borrar el libro mientras tenga ejemplares.");
                
                try{
                    $tema->deleteObject();
                    Session::success("Se ha borrado el tema $tema->tema.");
                    return view("/Tema/list");
                    
                }catch (SQLException $e){
                    
                    Session::error("No se pudo borrar el tema $tema->tema.");
                    
                    if (DEBUG)
                        throw new SQLException($e->getMessage());
                        
                        return redirect("/Tema/delete/$id");
                        
                }
    }
}
