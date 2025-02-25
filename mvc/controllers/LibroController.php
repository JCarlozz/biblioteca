<?php
class LibroController extends Controller{
    
    public function index(){
        return $this->list();
    }
    
    public function list(){
        
        $libros = Libro::all();
        
        return view('libro/list', [
            'libros'=>$libros
        ]);
    }
}