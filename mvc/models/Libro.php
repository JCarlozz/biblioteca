<?php
    class Libro extends Model{
        
        public function getEjemplares():array{
            $consulta = "SELECT * FROM ejemplares WHERE idlibro=$this->id";
            
            //retorna una lista de Ejemplar
            return DBMysqli::selectAll($consulta, 'Ejemplar');
        }  
        
        public function addTema(int $idtema):int{
            
            $consulta="INSERT INTO temas_libros(idlibro, idtema)
                        VALUES($this->id, $idtema)";
            
            return(DB_CLASS)::insert($consulta);
        }
        
        public function removeTema(int $idtema):int{
            
            $consulta="DELETE FROM temas_libros
                        WHERE idlibro = $this->id AND idtema= $idtema ";
            
            return(DB_CLASS)::delete($consulta);
        }
    }