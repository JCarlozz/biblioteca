<?php
class EjemplarController extends Controller{
    
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
            
    public function create(int $idlibro= 0){       
        
        return view('ejemplar/create');       
    }
    public function store(){
        
        //comprueba que la petición venga del formulario
        if (!request()->has('guardar'))
            throw new FormException('No se recibieron los datos del ejemplar');
            
            $ejemplar = new Ejemplar();       //crea el Ejemplar
            
            
            //toma los datos que llegan por POST
            $ejemplar->idlibro      =request()->post('idlibro');
            $ejemplar->anyo         =request()->post('anyo');
            $ejemplar->precio       =floatval(request()->post('precio'));
            $ejemplar->estado       =request()->post('estado');
                        
            //intenta guardar el libro, en caso que la inserción falle vamos a
            //evitar ir a la página de error y volver al formulario "nuevo libro"
            
            try{
                
                //guarda el libro en la base de datos
                $ejemplar->save();
                
                //flashea un mensaje de éxito en sesión
                Session::success("Ejemplar añadido correctamente.");
                
                //redirecciona a los detalles del nuevo libro
                return redirect("/Libro/edit/");
                
                //si falla el guardado del libro
            }catch (SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo añadir el ejemplar.");
                
                //si está en modo DEBUG vuelve a lanzar la excepción
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberián haberse borrado si usamos los helpers old()
                    return redirect("/Ejemplar/create/");
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