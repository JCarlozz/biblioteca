<?php
class PanelController extends Controller{
    
    public function index(){
        
        Auth::role('ROLE_LIBRARIAN');
        
        return view('panel/list');
    }
    
    public function admin(){
        
        Auth::admin();
        
        return view('panel/paneladmin');
    }    
    
}