<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Usuario.php";
    include_once "./03-DAO/AccesoDatos.php";    
    include_once './05-Interfaces/IDaoABM.php';

    class UsuarioDAO{   
        const CLASSNAME = 'Usuario';
        
        // Traigo Elemento por id.
        public static function GetById($id){
            $retorno = null;                       
            
            $query = "SELECT `id`, `nombre`, `rol` FROM `usuario` WHERE `id` = :id";            

            try{
                $db = AccesoDatos::DameUnObjetoAcceso();               
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $id, PDO::PARAM_INT); 
                
                $sentencia->execute(); 
                
                $retorno = $sentencia->fetchObject(self::CLASSNAME);                                    
                                                  
            } catch (PDOException $e) {
                $retorno = -1;                  
            }
            
            return $retorno;
        }   
        
        // Traigo todos los Elementos de la DB.
        public static function GetAll(){
            $retorno = array();           
            
            $query = "SELECT `id`, `nombre`, `rol` FROM `usuario`";
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();               
                $sentencia = $db->RetornarConsulta($query); 
                
                $sentencia->execute(); 
                                
                $retorno = $sentencia->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);                                                                                      
            } catch (PDOException $e) {
                $retorno = -1;                 
            }
            
            return $retorno;
        }

        // Guarda un elemento. Retorna el id guardado. (retorna false ahora).
        public static function Insert($elemento, $clave){
            
            $retorno = false;           
            
            $query = "INSERT INTO `usuario`(`nombre`, `clave`, `rol`) ";
            $query .="VALUES (:nombre, :clave, :rol)"; 

                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                    $sentencia->bindValue(':clave',  $clave, PDO::PARAM_STR); 
                    $sentencia->bindValue(':rol',  $elemento->rol, PDO::PARAM_INT);                     
                    
                    $sentencia->execute(); 
                    
                     
                    $retorno = true; //retorna true si no inserta también.                                                                          
                } catch (PDOException $e) {
                    $retorno = false;
                }

        

            return $retorno;
        }

        // Modifica los datos de un elemento en la DB por el id.
        public static function Update($elemento, $clave){
            $retorno = false;           
            
            $query = "UPDATE `usuario` SET `nombre`= :nombre, `clave`= :clave, `rol`=:rol WHERE `id`= :id";                        
            $rt = UsuarioDao::GetById($elemento->id);
            if($rt != false)
            {
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':clave',  $clave, PDO::PARAM_STR); 
                $sentencia->bindValue(':rol',  $elemento->rol, PDO::PARAM_INT);                  
                
                $sentencia->execute(); 
                //var_dump($sentencia);
                $retorno = true;                                  
            } catch (PDOException $e) {
                $retorno = false;
            }  
            }      
            
            return $retorno;
        }

        // Borra el registro de un elemento en DB por el id.
        public static function Delete($id){
            $rt = UsuarioDao::GetById($id);
            $retorno = false; 
            if($rt != false)
            {
                $query = "DELETE FROM `usuario` WHERE id = :id";            
                try {
                    $db = AccesoDatos::DameUnObjetoAcceso(); 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':id',  $id, PDO::PARAM_INT);
                    $sentencia->execute(); 
                    $retorno = true;                            
                } catch (PDOException $e) {
                    $retorno = false;
                }
            }
            return $retorno;
        }

        // Consulta rol de usuario por nombre y clave.
        public static function ConsultarUsuario($nombre, $clave){
            $retorno = false;           
            $query = "SELECT u.rol FROM usuario as u WHERE u.nombre= :nombre AND u.clave = :clave";
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();
                $sentencia = $db->RetornarConsulta($query);
                $sentencia->bindValue(':nombre',  $nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':clave',  $clave, PDO::PARAM_STR);
                $sentencia->execute();        
                $retorno = $sentencia->fetch();
                //var_dump($retorno); 
            } catch (PDOException $e) {
                $retorno = false;                  
            }
           
            return $retorno;
        }
    }
?>