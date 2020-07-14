<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Usuario.php";
    include_once "./03-DAO/AccesoDatos.php";    
    include_once './05-Interfaces/IDaoABM.php';

    class UsuarioDAO{   
        const CLASSNAME = 'Usuario';
        
        #region Métodos
        // Guarda un elemento. Retorna el id guardado. (retorna false ahora).
        public static function Insert($elemento){
            $retorno = false;           
            
            $query = "INSERT INTO `usuario`(`nombre`, `clave`, `perfil`, sexo) ";
            $query .="VALUES (:nombre, :clave, :perfil, :sexo)";                         
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query);
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':clave',  $elemento->clave, PDO::PARAM_STR); 
                $sentencia->bindValue(':perfil',  $elemento->perfil, PDO::PARAM_STR);
                $sentencia->bindValue(':sexo',  $elemento->sexo, PDO::PARAM_STR);                     
                
                $sentencia->execute(); 
                
                $retorno = true; //retorna true si no inserta también.                                                                          
            } catch (PDOException $e) {
                $retorno = false;
            }
        
            return $retorno;
        }

        // Consulta usuario 
        public static function ConsultarUsuario($elemento){
            $retorno = false;           
            $query = 
            "SELECT u.nombre, u.perfil, u.sexo, u.clave
            FROM usuario as u
            WHERE 
                u.nombre = :nombre AND
                u.perfil = :perfil AND
                u.sexo = :sexo AND
                u.clave = :clave";
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();               
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':perfil',  $elemento->perfil, PDO::PARAM_STR);
                $sentencia->bindValue(':sexo',  $elemento->sexo, PDO::PARAM_STR);
                $sentencia->bindValue(':clave', $elemento->clave, PDO::PARAM_STR); 
                
                $sentencia->execute();                 
                $retorno = $sentencia->fetchObject(self::CLASSNAME);                                     
            } catch (PDOException $e) {
                $retorno = false;           
                
            }
            return $retorno;
        }

        #endregion

        #region Métodos Sin Usar
        /*
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
        */
        public static function GetAll(){
            $retorno = array();           
            
            $query = "SELECT `id`, `nombre`,`perfil`,`sexo`, `clave` FROM `usuario`";
            
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
/*
        // Modifica los datos de un elemento en la DB por el id.
        public static function Update($elemento, $clave){
            $retorno = false;           
            
            $query = "UPDATE `usuario` SET `nombre`= :nombre, `clave`= :clave, `rol`=:rol WHERE `id`= :id";                        
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':clave',  $clave, PDO::PARAM_STR); 
                $sentencia->bindValue(':rol',  $elemento->rol, PDO::PARAM_INT);                  
                
                $sentencia->execute(); 
                
                $retorno = true;                                  
            } catch (PDOException $e) {
                $retorno = false;
            }        
            
            return $retorno;
        }

        // Borra el registro de un elemento en DB por el id.
        public static function Delete($id){
            $retorno = false;           
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
            
            return $retorno;
        }

        
        */
        #endregion

    }
?>