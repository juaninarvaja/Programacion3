<?php
include_once "./03-DAO/UsuarioDAO.php";

use \Firebase\JWT\JWT;

class AutenticacionAPI{    
    private const CLAVE = "claveSecreta";

    // Evalua la existencia de la tupla nombre-clave y retorna token o false.
    public function Login($request, $response, $next) {
        
        $data = $request->getParsedBody(); 
        
        $nombre = isset($data["nombre"])?$data["nombre"]:null;
        $clave = isset($data["clave"])?$data["clave"]:null;

        if($nombre !== null && $clave !== null){
            $token = $this->CrearToken($nombre, $clave);
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

    // Valida el Token rol 5
    public function ValidarSessionSocio($request, $response, $next) {        
        $data = getallheaders();        
        $token = isset($data["token"])?$data["token"]:"";

        $deco = $this->ValidarToken($token);
        //var_dump($deco);

        if($deco->rol == 5){
            $response = $next($request, $response);            
            return $response;            
        }
        else{
            $response->write("inválido");
            return $response;
        }        
    } 

    // Crea un token asociado al rol del usuario logueado.
    private function CrearToken($nombre, $clave){
        $token = false;
        $ahora = time();
        $rol = UsuarioDAO::ConsultarUsuario($nombre, $clave);
       
 
        if ($rol != null){        
            $payload = array(
                'iat' => $ahora,
                //'exp' => $ahora + (300),
                'app' => "API FM",
                'rol' => $rol[0]
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