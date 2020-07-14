<?php
    include_once "./Entidades/Usuario.php";
    // include_once "./02-Entidades/Empleado.php";
     include_once "./DAO/AccesoDatos.php";    

    class UsuarioDAO{   
        const CLASSNAME = 'Usuario';
        
        // Guarda un elemento. Retorna el id guardado. (retorna false ahora).
        public static function Insert($elemento){
            $retorno = null;           
            $query = "INSERT INTO `usuario`(`nombre`, `clave`, `sexo`, `perfil`) VALUES (:nombre, :clave, :sexo, :perfil)";            
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query);
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':clave',  $elemento->clave, PDO::PARAM_STR); 
                $sentencia->bindValue(':sexo',  $elemento->sexo, PDO::PARAM_STR); 
                $sentencia->bindValue(':perfil',  $elemento->perfil, PDO::PARAM_STR); 
                
                $sentencia->execute(); 
                
                //$retorno = $sentencia->fetch(); 
                $retorno = true;                                                                           
            } catch (PDOException $e) {
                $retorno = -1;
            }
            
            return $retorno;
        }

        // Modifica los datos de un elemento en la DB por el id.


        // Borra el registro de un elemento en DB por el id.

    }
?>