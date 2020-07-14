<?php
    include_once "./02-Entidades/Identificadores.php";
    include_once "./02-Entidades/Pedido.php";
    include_once "./03-DAO/AccesoDatos.php";   

    class PedidoDAO {   
        const CLASSNAME = 'Pedido';
        
        // Traigo lista de pedidos por rol encargado y estado del pedido.

        public static function GetById($id){
            $retorno = null;           
            
            $query = "SELECT id, comanda_id, producto_id,estado_id,tiempo_estimado FROM `pedido` WHERE id= :id";
            
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




        public static function GetPedidosByRolEstado($rol, $estado){
            $retorno = null;           
            
            $query = 
            "SELECT 
                pe.id, pe.comanda_id as comanda, 
                pe.producto_id as producto, 
                pe.estado_id as estado, 
                pe.tiempo_estimado as tiempoEstimado, 
                pe.tiempo_inicio as tiempoInicio 
            FROM pedido as pe, producto as pr 
            WHERE 
                pe.estado_id = :estado AND 
                pe.producto_id = pr.id AND 
                pr.rol_encargado = :rol";
            
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();               
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':rol',  $rol, PDO::PARAM_INT);
                $sentencia->bindValue(':estado',  $estado, PDO::PARAM_INT); 
                
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
            
            $query = "INSERT INTO `pedido`(`comanda_id`, `producto_id`, `estado_id`, `tiempo_estimado`) VALUES (:comanda, :producto, :estado, :tiempo)";                        
            $cm = ComandaDAO::GetById($elemento->comanda);
            $pr = productoDAO::GetById($elemento->producto);
            if($cm != false && $elemento->estado <= 3 && $elemento->estado > 0 && $pr !=false)
            {
                try{
                    $db = AccesoDatos::DameUnObjetoAcceso();                 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':comanda',  $elemento->comanda, PDO::PARAM_INT);
                    $sentencia->bindValue(':producto',  $elemento->producto, PDO::PARAM_INT); 
                    $sentencia->bindValue(':estado',  $elemento->estado, PDO::PARAM_INT);                 
                    $sentencia->bindValue(':tiempo',  $elemento->tiempoEstimado, PDO::PARAM_STR);                 
                    
                    $sentencia->execute();
                    
                    // $lastId = $db->lastInsertId();                  
                    // var_dump($lastId);                   
                    
                    $retorno = true;                                                                          
                } catch (PDOException $e) {
                    $retorno = false;
                }                          
            }
            return $retorno;
        }
        
        
        public static function Update($elemento){
            $retorno = null;           
            $query = "UPDATE `pedido` SET `estado_id`= :estado,`tiempo_estimado`= :tiempo_estimado  WHERE id = :id";
            $ped = PedidoDAO::GetById($elemento->id);
         
                           
            if($ped != false && $elemento->estado > 0 && $elemento->estado <= 3)
            {
            try{
                $db = AccesoDatos::DameUnObjetoAcceso();                 
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $elemento->id, PDO::PARAM_INT);
                $sentencia->bindValue(':estado',  $elemento->estado, PDO::PARAM_INT);
                $sentencia->bindValue(':tiempo_estimado',  $elemento->tiempoEstimado, PDO::PARAM_STR); 
                // $sentencia->bindValue(':precio',  $elemento->precio, PDO::PARAM_INT);   
                
                $sentencia->execute();                     
                $retorno = true;                
            } catch (PDOException $e) {
                $retorno = -1;
            }
        }
            return $retorno;
        }


        public static function Delete($id){
            $retorno = null;           
            $query = "DELETE FROM `pedido` WHERE id = :id";
            $ped = pedidoDAO::GetById($id);

            if($ped != false)
            {                
                try {
                    $db = AccesoDatos::DameUnObjetoAcceso(); 
                    $sentencia = $db->RetornarConsulta($query);
                    $sentencia->bindValue(':id', $id, PDO::PARAM_INT);
                    
                    $sentencia->execute();             
                    $retorno = true;
                } catch (PDOException $e) {
                    $retorno = -1;
                }
            }
            return $retorno;
        }

        public static function GetByIdComanda($id){
            $retorno = null;           
            
            $query =      "SELECT 
            pe.id, pe.comanda_id as comanda, 
            pe.producto_id as producto, 
            pe.estado_id as estado, 
            pe.tiempo_estimado as tiempoEstimado, 
            pe.tiempo_inicio as tiempoInicio,
            co.mesa_id as mesa 
            FROM pedido as pe, comanda as co 
            WHERE pe.comanda_id=:id AND co.id=:id";

            try{
                $db = AccesoDatos::DameUnObjetoAcceso();               
                $sentencia = $db->RetornarConsulta($query); 
                $sentencia->bindValue(':id',  $id, PDO::PARAM_INT); 
                
                $sentencia->execute();                 
                $retorno = $sentencia->fetchAll(PDO::FETCH_CLASS, self::CLASSNAME);       
                //$retorno = $sentencia->fetchObject(self::CLASSNAME);                                                                                      
            } catch (PDOException $e) {
                $retorno = -1;                  
            }
            
            return $retorno;
        }  
   

    }
?>