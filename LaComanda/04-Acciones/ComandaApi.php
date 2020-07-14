<?php
    include_once "./03-DAO/ComandaDAO.php";
    require_once './02-Entidades/Comanda.php';
    require_once './05-Interfaces/IAccionesABM.php';

    class ComandaApi implements IAccionesABM{
        
        // Retorna json del elemento.
        public function TraerUno($request, $response, $args) {

            $id = $args["id"];
            //$obj = ComandaDAO::GetById($id);
         
            $lista = PedidoDAO::GetByIdComanda($id);            
            
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
                
         
            // $JsonResponse = $response->withJson($obj, 200);        
            // return $JsonResponse;
        }

        // Retorna array json de todos los elementos.
        public function TraerTodos($request, $response, $args) {
            $lista = ComandaDAO::GetAll();
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

        public function GetByIdConPedido($request, $response, $args) {
            $id = $args["id"];
            $lista = ComandaDAO::GetByIdConPedido($id);
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
            
            $elemento = new Comanda();
            $elemento->codigo = isset($data["codigo"])?$data["codigo"]:null;
            $elemento->mesa = isset($data["mesa"])?$data["mesa"]:null; 
            $elemento->foto = isset($data["foto"])?$data["foto"]:null; 
               
            if(ComandaDAO::Insert($elemento)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }
            
            return $JsonResponse;
        }

        // Crea un Elemento y se lo pasa al DAO para que haga el Update.
        public function ModificarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
                        
            $elemento = new Comanda();
            $elemento->id = isset($data["id"])?$data["id"]:null;
            $elemento->codigo = isset($data["codigo"])?$data["codigo"]:null;
            $elemento->mesa = isset($data["mesa"])?$data["mesa"]:null; 
            $elemento->foto = isset($data["foto"])?$data["foto"]:null;  
                
            if(ComandaDAO::Update($elemento)){
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
            
            if(ComandaDAO::Delete($id)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }

            return $JsonResponse;
        }
    }
?>