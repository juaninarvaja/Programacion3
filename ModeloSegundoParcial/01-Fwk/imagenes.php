<?php
    class Imagenes{        

        public static function GuardarImagen($fileData, $destino){
            $extension = explode("/", $fileData["type"]);
            $origen = $fileData["tmp_name"];             
            $retorno = "Error Imagen.";
            
            // agrego la extensión 
            $destino .= ".$extension[1]";            

            // guardo foto.
            if(move_uploaded_file($origen, $destino)){
                $retorno = $destino;
            }

            return $retorno;
        }

        // Copia imagen en urlBackup con la misma extensión.
        public static function BackUpImagen($destino, $urlBackup){
            $ArrayExtension = explode(".", $destino);
            $extension = count($ArrayExtension)!=0? $ArrayExtension[count($ArrayExtension)-1]:"error";      
            $retorno = "Error Imagen.";
            
            // agrego la extensión
            $urlBackup .= ".$extension";
            
            // copio en backup
            if(file_exists($destino))
            {                        
                copy($destino, $urlBackup);
                unlink($destino);
                $retorno = $urlBackup;
            }

            return $retorno;
        }    
    }

?>