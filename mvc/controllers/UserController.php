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
}
     
  