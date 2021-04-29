<?php
// se debe configurar un rute api donde se puede reponder a travez de api rest en formato json


require_once "Router.php";

require_once "./api/EncuestaApiController.php";

define("BASE_URL", 'http://'.$_SERVER["SERVER_NAME"].':'.$_SERVER["SERVER_PORT"].dirname($_SERVER["PHP_SELF"]).'/');

    // recurso solicitado
$resource = $_GET["resource"];

    // método utilizado
$method = $_SERVER["REQUEST_METHOD"];
    
$router = new Router();

$router->addRoute("respuestas/:ID", "GET", "EncuestaController", "verRespuestas");
$router->addRoute("respuestas/:ID", "PUT", "EncuestaController", "cambiarRespuestas");
$router->addRoute("encuesta/:ID", "GET", "EncuestaController", "verOpciones");
$router->addRoute("encuesta/:ID", "GET", "EncuestaController", "verRespuesta");
$router->addRoute("encuesta/:TITULO", "GET", "EncuestaController", "verEncuesta");
$router->addRoute("respuesta/:ID", "DELETE", "EncuestaController", "verEncuesta");
$router->addRoute("encuesta/:ID", "INSERT", "EncuestaController", "votarSimple");
$router->addRoute("encuesta/:ID", "INSERT", "EncuestaController", "votarMultiple");

