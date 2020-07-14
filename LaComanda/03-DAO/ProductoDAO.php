<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Producto.php";
    include_once "./03-DAO/AccesoDatos.php"; 
    include_once './05-Interfaces/IDaoABM.php';   

    class ProductoDAO implements IDaoABM{   
        const CLASSNAME = 'Producto';
        
        // Traigo Elemento por id.
        public static function GetById($id){
            $retorno = null;           
            
            $query = "SELECT id, nombre, rol_encargado as rolEncargado, precio FROM `producto` WHERE id= :id";
            
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
            
            $query = "SELECT id, nombre, rol_encargado as rolEncargado, precio FROM `producto`"; 

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
        public static function Insert($elemento){
            $retorno = false;           
            
            $query = "INSERT INTO `producto`(`nombre`, `rol_encargado`, `precio`) VALUES (:nombre, :rol, :precio)";                        
            if($elemento->rolEncargado <= 6)
            {
                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                    $sentencia->bindValue(':rol',  $elemento->rolEncargado, PDO::PARAM_INT); 
                    $sentencia->bindValue(':precio',  $elemento->precio, PDO::PARAM_INT);                 
                    
                    $sentencia->execute();                     
                    $retorno = true;                                                                          
                } catch (PDOException $e) {
                    $retorno = false;
                }
                
            }

            return $retorno;
        }

        // Modifica los datos de un elemento en la DB por el id.
        public static function Update($elemento){
            $retorno = null;           
            $query = "UPDATE `producto` SET `nombre`= :nombre, `rol_encargado`= :rol, `precio`= :precio WHERE id = :id";
            $pr = ProductoDAO::GetById($elemento->id);
                           
            if($elemento->rolEncargado <= 6 && $pr != false)
            {
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                $sentencia->bindValue(':nombre',  $elemento->nombre, PDO::PARAM_STR);
                $sentencia->bindValue(':rol',  $elemento->rolEncargado, PDO::PARAM_INT); 
                $sentencia->bindValue(':precio',  $elemento->precio, PDO::PARAM_INT);   
                
                $sentencia->execute();                     
                $retorno = true;                
            } catch (PDOException $e) {
                $retorno = -1;
            }
        }
            return $retorno;
        }

        // Borra el registro de un elemento en DB por el id.
        public static function Delete($id){
            $retorno = null; 
            $rt = ProductoDao::GetById($id);
            if($rt != false)
            {
                      
            $query = "DELETE FROM `producto` WHERE id = :id";
            
            try {
                $db = AccesoDatos::DameUnObjetoAcceso(); 
                $sentencia = $db->RetornarConsulta($query);
                $sentencia->bindValue(':id',  $id, PDO::PARAM_INT);
                
                $sentencia->execute();             
                $retorno = true;
            } catch (PDOException $e) {
                $retorno = -1;
            }
            }
            
            return $retorno;
        }
    }
?>