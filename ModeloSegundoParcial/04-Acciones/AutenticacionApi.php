<?php
include_once "./03-DAO/UsuarioDAO.php";
require_once './02-Entidades/Usuario.php';
require_once './04-Acciones/ProductoApi.php';

use \Firebase\JWT\JWT;

class AutenticacionAPI{    
    private const CLAVE = "claveSecreta";

    // Evalua la existencia de la tupla nombre-clave y retorna token o false.
    public function Login($request, $response, $next) {
        $data = $request->getParsedBody(); 
        
        $elemento = new Usuario();
        //var_dump($elemento);
        $elemento->nombre = isset($data["nombre"])?$data["nombre"]:null;
        $elemento->clave = isset($data["clave"])?$data["clave"]:null; 
        $elemento->perfil = isset($data["perfil"])?$data["perfil"]:"usuario"; 
        $elemento->sexo = isset($data["sexo"])?$data["sexo"]:null; 

        if($elemento->nombre !== null && $elemento->clave !== null){
            $token = $this->CrearToken($elemento);
            $response->write($token);
        }
        else{
            $response->write(false);
        }
        
        return $response;
    }

    // Valida el Token 
    public function ValidarSession($request, $response, $next) {        
        $data = getallheaders();        
        $token = isset($data["token"])?$data["token"]:"";

        $rol = $this->ValidarToken($token);
        
        if($rol != false){
            $response = $next($request, $response);            
            return $response;            
        }
        else{
            $response->write("inválido");
            return $response;
        }        
    }   

    // Valida el Token rol admin
    public function ValidarSessionSocio($request, $response, $next) {        
        $data = getallheaders();        
        $token = isset($data["token"])?$data["token"]:"";

        $deco = $this->ValidarToken($token);
       // var_dump($deco);

        if($deco != null && $deco->rol == "admin"){
            $response = $next($request, $response);   
            //echo "es admin y entra";         
            return $response;            
        }
        else{
            $response->write("hola");
            return $response;
        }        
    } 

        // Valida el Token rol admin
        public function ValidarSessionRegistrado($request, $response, $next) {        
            $data = getallheaders();        
            $token = isset($data["token"])?$data["token"]:"";
    
            $deco = $this->ValidarToken($token);
           // var_dump($deco);
    
            if($deco != false){
                $response = $next($request, $response);   
                //echo "es admin y entra";   ;      
                return $response;            
            }
            else{
                $response->write("hola");
                return $response;
            }        
        } 

            // Valida el Token rol Admin para el get
    public function ValidarSessionGetCompra($request, $response, $next) {
        $data = getallheaders();        
        $token = isset($data["token"])?$data["token"]:"";
        $deco = $this->ValidarToken($token);
        if($deco != false){ 
            // Agrego parametro id del usuario logeado. 
            $parametros = $request->getParsedBody(); 
            $parametros["rol"] = $deco->rol; 
            $request = $request->withParsedBody($parametros); 
            if( $parametros["rol"] == "admin")
            {
                $response = $next($request, $response);            
                return $response;    
            }
            else
            {
                $nombre = $deco->nombreUsu;
                //var_dump($nombre);
                 $obj = ProductoApi::TraerUnoPorNombre($nombre);
                $response->write($obj);
                return $response;
            }
        
        }
        else{
            $response->write("inválido");
            return $response;
        }     
          
    }   

    public function ObtenerNombreToken($token) {

        $deco = AutenticacionApi::ValidarToken($token);
        if($deco != false){ 
            //var_dump($deco);
            $nombre = $deco->nombreUsu;
            //var_dump($nombre);
            return $nombre;
        
        }
        else{
            return $null;
        }     
    }
    // Crea un token asociado al rol del usuario logueado.
    private function CrearToken($elemento){
        $token = false;
        $ahora = time();
        
        $rol = UsuarioDAO::ConsultarUsuario($elemento);
        //echo "el rol es";
        //var_dump($rol->perfil);
        if ($rol != null){        
            $payload = array(
                'iat' => $ahora,
                //'exp' => $ahora + (300),
                'app' => "API JN",
                'rol' => $rol->perfil,
                'nombreUsu' => $rol->nombre
            );
    
            $token = JWT::encode($payload, self::CLAVE);
            }
        
        return $token;
    } 

    // Verifica que el token sea vàlido y lo retorna como un objeto.
    private function ValidarToken($token){
        $valido = false;        

        if(empty($token) || $token === ""){
            //throw new Exception("Token vacio.");            
        }
        else
        {
            try
            {
                $decodificado = JWT::decode(
                    $token,
                    self::CLAVE,
                    ['HS256']
                );

                if($decodificado !== null && $decodificado != ""){
                    $valido = $decodificado;
                }
            }
            catch(Exception $ex)
            {                
                $valido = false;                
            }
        }
        
        return $valido;
    }
}
?>