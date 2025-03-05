<?php
class SocioController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(int $page = 1){
        //analiza si hay filtro
        $filtro = Filter::apply('socios');
        
        //recupera el número de resultados por página
        $limit = RESULTS_PER_PAGE;
        
        //si hay filtro
        if($filtro){
            //recupera   de libros que cumplen los criterios del filtro
            $total = Socio::filteredResults($filtro);
            
            //crea el objeto paginador
            $paginator = new Paginator('/Socio/list', $page, $limit, $total);
            
            //recupera los libros que cumplen los criterios del filtro
            $socios = Socio::filter($filtro, $limit, $paginator->getOffset());
            
            //si no hay filtro
        }else{
            
            //recupera el total de libros
            $total = Socio::total();
            
            //crea el objeto paginador
            $paginator = new Paginator('/Socio/list', $page, $limit, $total);
            
            //recupera todos los libros
            $socios = Socio::orderBy('nombre', 'ASC', $limit, $paginator->getOffset());
            
        }
        //carga la vista
        return view('socio/list', [
            'socios'    => $socios,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
    
            
    public function show(int $id=0){   
        
        
        $socio = Socio::findOrFail($id, "No se encontró el socio indicado.");
        
        $prestamos = $socio->hasMany('V_prestamo');
        
        return view('socio/show',[
            'socio' => $socio,
            'prestamos'=>$prestamos
        ]);
    }
    
    public function create(){
        return view('socio/create');
        
    }
    
    public function store(){
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
            
            $socio = new Socio();       //crea el Socio
            
            
            //toma los datos que llegan por POST
            $socio->dni             =request()->post('dni');
            $socio->nombre          =request()->post('nombre');
            $socio->apellidos       =request()->post('apellidos');
            $socio->nacimiento      =request()->post('nacimiento');
            $socio->email           =request()->post('email');
            $socio->direccion       =request()->post('direccion');
            $socio->cp              =request()->post('cp');
            $socio->poblacion       =request()->post('poblacion');
            $socio->provincia       =request()->post('provincia');
            $socio->telefono        =request()->post('telefono');
                        
            //intenta guardar el socio, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo socio"
            
            try{
                
                //guarda el libro en la base de datos
                $socio->save();
                
                //recupera la portada como objeto UploadFile es null si no llega)
                $file = request()->file(
                    'foto',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                    );
                
                //si hay fichero, lo guardo y actualizamos el campo "portada"
                if ($file){
                    $socio->foto = $file->store('../public/'.MEMBERS_IMAGE_FOLDER, 'MEMBER_');
                    $socio->update();
                }                
                
                //flashea un mensaje de éxito en sesión
                Session::success("Guardado el socio $socio->nombre $socio->apellidos correcto.");
                
                //redirecciona a los detalles del nuevo socio
                return redirect("/Socio/show/$socio->id");
                
                //si falla el guardado del nuevo socio
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el socio $socio->nombre $socio->apellidos.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Socio/create");
                    
            }catch(UploadException $e){
                
                Session::warning("El socio se guardó correctamente, pero no se pudo
                                subir el fichero de imagen.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    redirect("/Socio/edit/$socio->id");
            }
    }
    
    public function edit(int $id=0){
        
        //busca el socio con ese ID
        $socio = Socio::findOrFail($id, "No se encontró el socio.");
        
        //retorna una ViewResponse con la vista con la vista con el formulario de edición
        return view('socio/edit', [
            'socio'=> $socio
        ]);
    }
    
    public function update(){
        
        if (!request()->has('actualizar'))      //si no llega el formulario...
            throw new FormException('No se recibieron datos');
            
            $id= intval(request()->post('id'));     //recuperar el ID vía POST
            
            $socio= Socio::findOrFail($id, "No se ha encontrado el socio.");
            
            $socio->dni             =request()->post('dni');
            $socio->nombre          =request()->post('nombre');
            $socio->apellidos       =request()->post('apellidos');
            $socio->nacimiento      =request()->post('nacimiento');
            $socio->email           =request()->post('email');
            $socio->direccion       =request()->post('direccion');
            $socio->cp              =request()->post('cp');
            $socio->poblacion       =request()->post('poblacion');
            $socio->provincia       =request()->post('provincia');
            $socio->telefono        =request()->post('telefono');
                        
            //intenta actualizar el socio
            try{
                $socio->update();
                
                $file = request()->file(
                    'foto',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                    );
                
                //si hay fichero, lo guardo y actualizamos el campo "portada"
                if ($file){
                    if ($socio->foto)    //elimina el fichero anterior (si lo hay)
                        File::remove('../public/'.MEMBERS_IMAGE_FOLDER.'/'.$socio->foto);
                        
                        $socio->foto = $file->store('../public/'.MEMBERS_IMAGE_FOLDER, 'MEMBER_');
                        $socio->update();
                }                     
                
                Session::success("Actualización del socio $socio->nombre $socio->apellidos correcta.");
                return redirect("/Socio/show/$id");
                
                //si se produce un error al guardar el libro...
            }catch (SQLException $e){
                
                Session::error("Hubo errores en la actualización del socio $socio->nombre $socio->apellidos.");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
                    
            }catch (UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la portada.");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
            }
    }
    
    public function delete(int $id = 0){
        
        $socio = Socio::findOrFail($id, "No existe el socio.");
        
        return view('socio/delete', [
            'socio'=>$socio
        ]);
    }
    
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if (!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación.');
            
            $id = intval(request()->post('id'));        //recupera el identificador
            $socio = Socio::findOrFail($id);            //recupera el socio
            
            //si el socio tiene prestamos, no permetimos el borrado
            //más adelante ocultaremos el botón de "Borrar" en estos casos
            //para que no el usuario no llegue al formulario de confirmación
            if ($socio->hasMany('V_Prestamo'))
                throw new Exception("No se puede borrar el socio mientras tenga prestamos.");
                
                try{
                    $socio->deleteObject();
                    
                    if ($socio->foto)
                        File::remove('../public/'.MEMBERS_IMAGE_FOLDER.'/'.$socio->foto, true);
                        
                        
                    Session::success("Se ha borrado de el socio $socio->nombre.");
                    return view("/Socio/list");
                    
                }catch (SQLException $e){
                    
                    Session::error("No se pudo borrar el socio $socio->nombre $socio->apellidos.");
                    
                    if (DEBUG)
                        throw new SQLException($e->getMessage());
                        
                        return redirect("/Socio/delete/$id");
                        
                }catch (FileException $e){
                    Session::warning("Se eliminó el socio pero no se pudo eliminar el fichero del disco.");
                    
                    if (DEBUG)
                        throw new FileException($e->getMessage());
                        
                        return redirect("/Socio");
                        
                }
    }
    public function dropcover(){
        
        if (!request()->has('borrar'))
            throw new FormException('Faltan datos para completar la operación');
            
            
            $id = request()->post('id');
            $socio = Socio::findOrFail($id, "No se ha encontrado el socio.");
            
            $tmp = $socio->foto;
            $socio->foto = NULL;
            
            try{
                $socio->update();
                File::remove('../public/'.MEMBERS_IMAGE_FOLDER.'/'.$tmp, true);
                
                Session::success("Borrado de la foto del $socio->nombre $socio->apellidos realizada.");
                return redirect("/Socio/edit/$id");
                
            }catch (SQLException $e){
                Session::error("No se pudo eliminar la portada");
                
                if (DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
                    
            }catch (FileException $e){
                Session::warning("No se pudo eliminar el fichero del disco");
                
                if (DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("/Socio/edit/$socio->id");
                    
            }
            
    }
    
    
}
