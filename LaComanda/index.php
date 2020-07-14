<?php
    include_once "./04-Acciones/UsuarioApi.php";
    include_once "./04-Acciones/ProductoApi.php";
    include_once "./04-Acciones/MesaApi.php";
    include_once "./04-Acciones/ComandaApi.php";
    include_once "./04-Acciones/PedidoApi.php";
    include_once "./04-Acciones/AutenticacionApi.php";

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
	
	header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    require './vendor/autoload.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(['settings' => $config]);    
    
    // Login
    $app->post('/login', \AutenticacionApi::class . ':Login');

    // Usuario ABM
    $app->group('/usuarios', function () {
        $this->get('/{id}', \UsuarioApi::class . ':TraerUno');

        $this->get('/', \UsuarioApi::class . ':TraerTodos');

        $this->post('/', \UsuarioApi::class . ':CargarUno');

        $this->put('/', \UsuarioApi::class . ':ModificarUno');

        $this->delete('/', \UsuarioApi::class . ':BorrarUno');  

    })->add(\AutenticacionApi::class . ':ValidarSessionSocio');
    
    // Producto ABM
    $app->group('/productos', function () {
        $this->get('/{id}', \ProductoApi::class . ':TraerUno');

        $this->get('/', \ProductoApi::class . ':TraerTodos');

        $this->post('/', \ProductoApi::class . ':CargarUno');    

        $this->put('/', \ProductoApi::class . ':ModificarUno');

        $this->delete('/', \ProductoApi::class . ':BorrarUno'); 

    })->add(\AutenticacionApi::class . ':ValidarSessionSocio');

    // Mesa ABM
    $app->group('/mesas', function () {
        $this->get('/', \MesaApi::class . ':TraerTodos');

        $this->put('/', \MesaApi::class . ':ModificarUno');

    })->add(\AutenticacionApi::class . ':ValidarSessionSocio');

    // Comanda ABM
    $app->group('/comandas', function () {
        $this->get('/{id}', \ComandaApi::class . ':TraerUno');

        $this->get('/', \ComandaApi::class . ':TraerTodos');

        $this->post('/', \ComandaApi::class . ':CargarUno');    

        $this->put('/', \ComandaApi::class . ':ModificarUno');

        $this->delete('/', \ComandaApi::class . ':BorrarUno'); 

    })->add(\AutenticacionApi::class . ':ValidarSessionSocio');

    // Pedido ABM
    $app->group('/pedidos', function () {
        $this->get('/{rol}/{estado}', \PedidoApi::class . ':TraerPorRolYEstado');

        $this->post('/', \PedidoApi::class . ':CargarUno');

        $this->put('/', \PedidoApi::class . ':ModificarEstado');
        $this->delete('/', \PedidoApi::class . ':BorrarUno');
        

    })->add(\AutenticacionApi::class . ':ValidarSessionSocio');

    $app->run();
?>