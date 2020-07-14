<?php
    include_once "./Acciones/UsuarioApi.php";
    // include_once "./04-Acciones/AutenticacionApi.php";

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    require './vendor/autoload.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(['settings' => $config]);
    
    // Empleados ABM
    $app->group('/usuario', function () {

        // $this->get('/{id}', \EmpleadoApi::class . ':TraerUno');

        // $this->get('/', \EmpleadoApi::class . ':TraerTodos');

        $this->post('/', \UsuarioApi::class . ':CargarUno');

        // $this->put('/', \EmpleadoApi::class . ':ModificarUno');

        // $this->delete('/', \EmpleadoApi::class . ':BorrarUno');      
        // $this->post('/login', \AutenticacionApi::class . ':Login');
        $this->post('/validar', \AutenticacionApi::class . ':AutenticarToken');
    });

    $app->run();
?>