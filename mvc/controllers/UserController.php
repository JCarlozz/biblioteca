<?php
    class UserController extends Controller {
        
        public function home(){
            
            Auth::check();
            
            return view('user/home', [
               'user'=>Login::user() 
            ]);
        }
        
        public function create(){
            
            Auth::admin();
            
            return view('user/create');
        }
        
        public function store(){
            
            Auth::admin();
            
            if(!request()->has('guardar'))
                throw new FormException('No se recibió el formulario');
            
            $user = new User();
            
            $user->password =md5($_POST['password']);
            $repeat         =md5($_POST['repeatpassword']);
            
            if ($user->password != $repeat)
                throw new ValidationException("Las claves no coinciden.");
            
            $user->displayname   = request()->post('displayname');
            $user->email         = request()->post('email');
            $user->phone         = request()->post('phone');
                            
            $user->addRole('ROLE_USER', $this->request->post('roles'));
            
            //$user->picture(request()->post('picture') ?? 'DEFAULT_USERS_IMAGE');
            
            try{
                $user->save();
                
                $file = request()->file(
                    'picture',
                    8000000,
                    ['image/png', 'image/jpeg', 'image/gif']
                 );
                
                if ($file) {
                    $user->picture = $file->store('../public/' .USER_IMAGES_FOLDER, 'user_');
                    $user->update();
                }
                
                Session::success("Nuevo usuario $user->displayname creado con éxito.");
                return redirect("/Panel/admin");
            
            }catch (ValidationException $e){
                
                Session::error($e->getMessage());
                return redirect("/User/create");
            
            }catch (SQLException $e){
                
                Session::error("Se produjo un error al guardar el usuario $user->displayname.");
                
                if(DEBUG)
                    throw new Exception($e->getMessage());
                return redirect("/User/create");
            
            }catch (UploadException $e){
                Session::warning("El usuario se guardó correctamente, pero no se pudo subir el fichero de imagen.");
                
                if (DEBUG)
                    throw new Exception($e->getMessage());
                
                    return redirect("User/edit/$user->id");
                    
            }
      }
      
      public function index(){
          return $this->list();
      }
      
      public function list(int $page = 1){
          //analiza si hay filtro
          $filtro = Filter::apply('users');
          
          //recupera el número de resultados por página
          $limit = RESULTS_PER_PAGE;
          
          //si hay filtro
          if($filtro){
              //recupera   de libros que cumplen los criterios del filtro
              $total = User::filteredResults($filtro);
              
              //crea el objeto paginador
              $paginator = new Paginator('/User/list', $page, $limit, $total);
              
              //recupera los libros que cumplen los criterios del filtro
              $users = User::filter($filtro, $limit, $paginator->getOffset());
              
              //si no hay filtro
          }else{
              
              //recupera el total de libros
              $total = User::total();
              
              //crea el objeto paginador
              $paginator = new Paginator('/User/list', $page, $limit, $total);
              
              //recupera todos los libros
              $users = User::orderBy('displayname', 'ASC', $limit, $paginator->getOffset());
              
          }
          //carga la vista
          return view('user/list', [
              'users'    => $users,
              'paginator' => $paginator,
              'filtro'    => $filtro
          ]);
      }
      
      public function show(int $id=0){
          
          $user = User::findOrFail($id, "No se encontró el usuario indicado.");
          
          return view('user/show',[
              'user'         => $user
          ]);
      }
      
      public function edit(int $id=0){
          
          //busca del usuario con ese ID
          $user = User::findOrFail($id, "No se encontró el usuario.");
                              
          //retorna una ViewResponse con la vista con la vista con el formulario de edición
          return view('user/edit',[
              'user'      => $user              
          ]);
      }
      
      public function update(){
          
          if (!request()->has('actualizar'))      //si no llega el formulario...
              throw new FormException('No se recibieron datos');
              
              $id= intval(request()->post('id'));     //recuperar el ID vía POST
              
              $user= User::findOrFail($id, "No se ha encontrado el usuario.");
              
              $user->displayname           =request()->post('displayname');
              $user->email                 =request()->post('email');
              $user->phone                 =request()->post('phone');
              
              
              //intenta actualizar el usuario
              try{
                  $user->update();
                  
                  $file = request()->file(
                      'picture',
                      8000000,
                      ['image/png', 'image/jpeg', 'image/gif', 'image/webp']
                      );
                  
                  //si hay fichero, lo guardo y actualizamos el campo "portada"
                  if ($file){
                      if ($user->picture)    //elimina el fichero anterior (si lo hay)
                          File::remove('../public/'.USERS_IMAGE_FOLDER.'/'.$user->picture);
                          
                          $user->picture = $file->store('../public/'.USERS_IMAGE_FOLDER, 'USER_');
                          $user->addRole(request()->post('roles'));
                          $user->update();
                  }
                  Session::success("Actualización del usuario $user->displayname correcta.");
                  return redirect("/User/list");
                  
                  //si se produce un error al guardar el libro...
              }catch (SQLException $e){
                  
                  Session::error("Hubo errores en la actualización del usuario $user->displayname.");
                  
                  if(DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
                      
              }catch (UploadException $e){
                  Session::warning("Cambios guardados, pero no se modificó la imagen.");
                  
                  if(DEBUG)
                      throw new UploadException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
              }
      }  
      
      public function delete(int $id = 0){
          
          $user = User::findOrFail($id, "No existe el usuario.");
          
          return view('user/delete', [
              'user'=>$user
          ]);
      }
      
      public function addrole(){
          
          if(empty(request()->post('add')))
              throw new FormException("No se recibió el formulario");
              
              $id = intval(request()->post('id'));            
              
              $users   = User::findOrFail($id, "No se encontró el usuario");              
              
              try{
                  $users->addRole($id);
                  
                  Session::success("Se ha añadido $users->roles al $users->displayname.");
                  return redirect("/User/list/");
                  
              }catch(SQLException $e){
                  
                  Session::error("No se pudo añadir el $users->roles al $users->displayname.");
                  
                  if(DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
              }
      }
      
      public function removerole(){
          
          if(empty(request()->post('remove')))
              throw new FormException("No se recibió el formulario");
              
              $id = intval(request()->post('id'));
              
              $users   = User::findOrFail($id, "No se encontró el usuario");
              
              
              try{
                  $users->removerole($id);
                  
                  Session::success("Se ha eliminado el $users->roles de $users->displayname.");
                  return redirect("/User/list/");
                  
              }catch(SQLException $e){
                  
                  Session::error("No se pudo eliminar $users->roles de $users->displayname.");
                  
                  if(DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
              }
      }
            
      public function dropcover(){
          
          if (!request()->has('borrar'))
              throw new FormException('Faltan datos para completar la operación');
              
              
              $id = request()->post('id');
              $user = User::findOrFail($id, "No se ha encontrado el usuario.");
              
              $tmp = $user->picture;
              $user->picture = NULL;
              
              try{
                  $user->update();
                  File::remove('../public/'.USERS_IMAGE_FOLDER.'/'.$tmp, true);
                  
                  Session::success("Borrado de la foto del $user->displayname realizada.");
                  return redirect("/User/edit/$id");
                  
              }catch (SQLException $e){
                  Session::error("No se pudo eliminar la portada");
                  
                  if (DEBUG)
                      throw new SQLException($e->getMessage());
                      
                      return redirect("/User/edit/$id");
                      
              }catch (FileException $e){
                  Session::warning("No se pudo eliminar el fichero del disco");
                  
                  if (DEBUG)
                      throw new FileException($e->getMessage());
                      
                      return redirect("/User/edit/$user->id");
                      
              }
              
      }
      
}
     
  