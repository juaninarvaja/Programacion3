<?php
    
    class Indentificadores{
        public static $Rol  = array(
            "Bartender" => 1,
            "Cervecero" => 2,
            "Cocinero" => 3,
            "Mozo" => 4,
            "Socio" => 5, 
            "Cliente" => 6                   
        );  
        
        public static $Sector = array(
            "Barra de tragos y vinos" => 1,
            "Barra de cerveza" => 2,
            "Cocina" => 3,
            "Candy bar" => 4,
            "Administración" => 5,
            "Mesas" => 6
        );

        public static $Estado = array(
            "Barra de tragos y vinos" => 1,            
        );

        public static function GetDescriptionById($array, $id){        
            $tarea = "Tarea no registrada";                        
            
            foreach($array as $clave => $valor){
                if ($valor == $id) {
                    $tarea = $clave;
                    break;
                }                            
            }

            return $tarea;
        }
    } 
?>