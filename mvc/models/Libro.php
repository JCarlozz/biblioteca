<?php
    class Libro extends Model{
        
        public function getEjemplares():array{
            $consulta = "SELECT * FROM ejemplares WHERE idlibro=$this->id";
            
            //retorna una lista de Ejemplar
            return DBMysqli::selectAll($consulta, 'Ejemplar');
        }       
    }