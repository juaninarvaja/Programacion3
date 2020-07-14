<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Mesa.php";
    include_once "./03-DAO/AccesoDatos.php"; 

    class MesaDAO {   
        const CLASSNAME = 'Mesa';
        
        // Traigo todos los Elementos de la DB.
        public static function GetAll(){
            $retorno = array();           
            
            $query = "SELECT id, clave, estado_id as estado FROM `mesa`"; 

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
            $query = "UPDATE `mesa` SET `estado_id`= :estado WHERE id = :id";                    
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                $sentencia->bindValue(':estado',  $elemento->estado, PDO::PARAM_INT);
                
                $sentencia->execute();                     
                $retorno = true;                
            } catch (PDOException $e) {
                $retorno = -1;
            }
            
            return $retorno;
        }
    }
?>