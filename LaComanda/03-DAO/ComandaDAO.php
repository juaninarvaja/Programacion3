<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Comanda.php";
    include_once "./03-DAO/AccesoDatos.php"; 
    include_once './05-Interfaces/IDaoABM.php';   

    class ComandaDAO implements IDaoABM{   
        const CLASSNAME = 'Comanda';
        
        // Traigo Elemento por id.
        public static function GetById($id){
            $retorno = null;           
            
            $query = "SELECT id, codigo, mesa_id as mesa, foto FROM `comanda` WHERE id= :id";
          
        
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
            
            $query = "SELECT id, codigo, mesa_id as mesa, foto FROM `comanda`"; 

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
            
            $query = "INSERT INTO `comanda`(`codigo`, `mesa_id`, `foto`) VALUES (:codigo, :mesa, :foto)";                        
            $ms = MesaDAO::GetById($elemento->mesa);
            $msSt = MesaDAO::GetByIdAndState($elemento->mesa,5);
            if($ms != false && $msSt != false)
            {
                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':codigo',  $elemento->codigo, PDO::PARAM_STR);
                    $sentencia->bindValue(':mesa',  $elemento->mesa, PDO::PARAM_INT); 
                    $sentencia->bindValue(':foto',  $elemento->foto, PDO::PARAM_STR);                 
                    
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
            $query = "UPDATE `comanda` SET `codigo`=:codigo, `mesa_id`=:mesa, `foto`=:foto WHERE id = :id";                    
            $ms = mesaDAO::GetById($elemento->mesa);
            $co = comandaDao::GetById($elemento->id);
            $msSt = mesaDAO::GetByIdAndState($elemento->mesa,5);

            if($ms != false && $co != false && $msSt != false)
            {
                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query); 
                    $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                    $sentencia->bindValue(':codigo',  $elemento->codigo, PDO::PARAM_STR);
                    $sentencia->bindValue(':mesa',  $elemento->mesa, PDO::PARAM_INT); 
                    $sentencia->bindValue(':foto',  $elemento->foto, PDO::PARAM_STR);   
                    
                    $sentencia->execute();                     
                    $retorno = true;                
                } catch (PDOException $e) {
                    $retorno = -1;
                }
            }
            if($msSt == false)
            {
                echo "esta mesa esta ocupada";
            }
            
            return $retorno;
        }

        // Borra el registro de un elemento en DB por el id.
        public static function Delete($id){
            $retorno = null;           
            $query = "DELETE FROM `comanda` WHERE id = :id";
            $co = comandaDao::GetById($id);
         

            if($co != false)
            {
                $msSt = mesaDAO::GetByIdAndState($co->mesa,5);
                
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
            if($msSt != false)
            {
                echo "aviso, esa mesa no estaba vacia";
            }
            return $retorno;
        }
  

    }
?>