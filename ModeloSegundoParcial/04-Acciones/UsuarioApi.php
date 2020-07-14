<?php
    include_once "./03-DAO/UsuarioDAO.php";
    require_once './02-Entidades/Usuario.php';
    require_once './05-Interfaces/IAccionesABM.php';

    class UsuarioApi{
        
        #region Métodos
        // Recibe datos en el body y pasa objeto al DAO para insertarlo. 
        public function CargarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
            
            $elemento = new Usuario();
            $elemento->nombre = isset($data["nombre"])?$data["nombre"]:null;
            $elemento->clave = isset($data["clave"])?$data["clave"]:null;  
            $elemento->perfil = isset($data["perfil"])?$data["perfil"]:"usuario"; 
            $elemento->sexo = isset($data["sexo"])?$data["sexo"]:null;                         
            
            if(UsuarioDAO::Insert($elemento)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }
            
            return $JsonResponse;
        }

                // Retorna array json de todos los empleados.
       public function TraerTodos($request, $response, $args) {
            $lista = UsuarioDAO::GetAll();
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





        #endregion

        #region Sin Uso
        /*
        // Retorna json del empleado.
        public function TraerUno($request, $response, $args) {
            $id = $args["id"];
            $obj = UsuarioDAO::GetById($id);            
            
            $JsonResponse = $response->withJson($obj, 200);        
            return $JsonResponse;
        }



        // Crea un Elemento y se lo pasa al DAO para que haga el Update.
        public function ModificarUno($request, $response, $args) {
            $data = $request->getParsedBody();        
                        
            $elemento = new Usuario();   
            $elemento->id = isset($data["id"])?$data["id"]:null;
            $elemento->nombre = isset($data["nombre"])?$data["nombre"]:null;         
            $clave = isset($data["clave"])?$data["clave"]:null;
            $elemento->rol = isset($data["rol"])?$data["rol"]:null;
                
            if(UsuarioDAO::Update($elemento, $clave)){
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
            
            if(UsuarioDAO::Delete($id)){
                $JsonResponse = $response->withJson(true, 200);     
            }
            else{
                $JsonResponse = $response->withJson(false, 400);                    
            }

            return $JsonResponse;
        }
        */
        #endregion
    }
?>