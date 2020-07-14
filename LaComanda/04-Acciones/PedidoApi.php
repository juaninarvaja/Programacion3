<?php
    include_once "./03-DAO/PedidoDAO.php";
    require_once './02-Entidades/Pedido.php';

    class PedidoApi{
        
        // Retorna json de los elementos.
        public function TraerPorRolYEstado($request, $response, $args) {
            $rol = $args["rol"];
            $estado = $args["estado"];
            
            $lista = PedidoDAO::GetPedidosByRolEstado($rol, $estado);            
            
            if(count($lista)<1){
                $strRespuesta = "No existen registros.";
            }
            else{
                for($i=0; $i<count($lista); $i++){
                    $strRespuesta[] = $lista[$i];
                }                
            }
            
            $JsonResponse = $response->withJson($strRespuesta, 200);                    
            return $JsonResponse;
        }

        // Retorna array json de todos los elementos.
        public function TraerTodos($request, $response, $args) {
            $lista = ProductoDAO::GetAll();
            $strRespuesta;                              
  
            if(count($lista)<1){
                $strRespuesta = "No existen registros.";
            }
            else{
                for($i=0; $i<count($lista); $i++){
                    $strRespuesta[] = $lista[$i];
                }                
            }
            
            $JsonResponse = $response->withJson($strRespuesta, 200);                    
            return $JsonResponse; 
        }

        // Recibe datos en el body y pasa objeto al DAO para insertarlo. 
        public function CargarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
            
            $elemento = new Pedido();
            $elemento->comanda = isset($data["comanda"])?$data["comanda"]:null;
            $elemento->producto = isset($data["producto"])?$data["producto"]:null; 
            $elemento->estado = isset($data["estado"])?$data["estado"]:null; 
            $elemento->tiempoEstimado = isset($data["tiempo"])?$data["tiempo"]:null; 
               
            if(PedidoDAO::Insert($elemento)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }
            
            return $JsonResponse;
        }

        // Crea un Elemento y se lo pasa al DAO para que haga el Update.
        public function ModificarEstado($request, $response, $args) {
            $data = $request->getParsedBody();        
                        
            $elemento = new Pedido();
            $elemento->id = isset($data["id"])?$data["id"]:null;
            $elemento->estado = isset($data["estado"])?$data["estado"]:null;
            $elemento->tiempoEstimado = isset($data["tiempoEstimado"])?$data["tiempoEstimado"]:null;

                
            if(PedidoDAO::Update($elemento)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }

            return $JsonResponse;
        }

        // Elimina un Elemento por id.
        public function BorrarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
            $id = isset($data["id"])?$data["id"]:null;
            
            if(PedidoDAO::Delete($id)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }

            return $JsonResponse;
        }
    }
?>