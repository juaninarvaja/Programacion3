<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Mesa.php";
    include_once "./03-DAO/AccesoDatos.php"; 

    class MesaDAO {   
        const CLASSNAME = 'Mesa';
        
                // Traigo Elemento por id.
        public static function GetById($id){
            $retorno = null;           
            
            $query = "SELECT id FROM `mesa` WHERE id= :id";
            
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
        
                public static function GetByIdAndState($id,$estado_id){
                    $retorno = null;           
                    
                    $query = "SELECT id,estado_id FROM `mesa` WHERE id= :id AND estado_id=:estado_id";

                    try{
                        $db = AccesoDatos::DameUnObjetoAcceso();               
                        $sentencia = $db->RetornarConsulta($query); 
                        $sentencia->bindValue(':id',  $id, PDO::PARAM_INT);
                        $sentencia->bindValue(':estado_id',  $estado_id, PDO::PARAM_INT); 
                        
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
            
            $query = "SELECT id, clave, estado_id, cliente FROM `mesa`"; 

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

        // Modifica los datos de un elemento en la DB por el id.
        public static function Update($elemento){
            $retorno = null;           
            $query = "UPDATE `mesa` SET `estado_id`= :estado_id WHERE id = :id";                    
            //var_dump($elemento);
            if($elemento->estado_id <= 5 && $elemento->estado_id > 1)
            {
                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query); 
                    $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                    $sentencia->bindValue(':estado_id',  $elemento->estado_id, PDO::PARAM_INT);
                    
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