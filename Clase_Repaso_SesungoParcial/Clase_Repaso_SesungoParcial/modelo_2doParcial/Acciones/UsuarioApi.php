<?php
    include_once "./DAO/UsuarioDAO.php";
    require_once './Entidades/Usuario.php';
    require_once './Interfaces/IAccionesABM.php';
    // require_once './03-DAO/AutenticacionDAO.php';
    class UsuarioApi implements IAccionesABM {

        public function CargarUno($request, $response, $args){
            $data = $request->getParsedBody();        
            
            $elemento = new Usuario();
            $elemento->nombre = isset($data["nombre"])?$data["nombre"]:null;
            $elemento->clave = isset($data["clave"])?$data["clave"]:null;
            $elemento->sexo = isset($data["sexo"])?$data["sexo"]:null;
            $elemento->perfil = isset($data["perfil"])?$data["perfil"]:"usuario";                        
            var_dump($elemento);
            $response->write(UsuarioDAO::Insert($elemento));   
            return $response;
            }

            public function TraerUno($request, $response, $args){}

            public function TraerTodos($request, $response, $args){} 
            public function BorrarUno($request, $response, $args){}
            public function ModificarUno($request, $response, $args){}


    }  

    ?>