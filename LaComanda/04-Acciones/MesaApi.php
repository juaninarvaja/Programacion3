<?php
    include_once "./03-DAO/MesaDAO.php";
    require_once './02-Entidades/Mesa.php';

    class MesaApi{        

        // Retorna array json de todos los elementos.
        public function TraerTodos($request, $response, $args) {
            $lista = MesaDAO::GetAll();
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

        // Crea un Elemento y se lo pasa al DAO para que haga el Update.
        public function ModificarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
                        
            $elemento = new Mesa();
            $elemento->id = isset($data["id"])?$data["id"]:null;
            $elemento->estado_id = isset($data["estado"])?$data["estado"]:null;               
            if(MesaDAO::Update($elemento)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }

            return $JsonResponse;
        }
    }
?>