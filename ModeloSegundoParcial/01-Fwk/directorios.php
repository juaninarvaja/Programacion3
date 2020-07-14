<?php
    class Directorio {

        // Retorna una lista con sólo los nombres de los archivos del directorio.
        public static function GetFilesList($directorio){
            $list = array();
            
            if ($gestor = opendir($directorio)) {
                while (false !== ($entrada = readdir($gestor))) {                    
                    if ($entrada != "." && $entrada != ".." && is_file($directorio.$entrada)){                        
                        $list[] = $entrada;                                                                                                
                    }
                }        
                closedir($gestor);
                
            }

            return $list;
        }
    }

?>