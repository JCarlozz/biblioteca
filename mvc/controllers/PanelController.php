<?php
class PanelController extends Controller{
    
    public function index(){
        
        Auth::role('ROLE_LIBRARIAN');
        
        return view('panel/list');
    }
    
    public function admin(){
        
        Auth::role('ROLE_ADMIN');
        
        return view('panel/paneladmin');
    }    
    
}