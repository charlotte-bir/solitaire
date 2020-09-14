<?php
/**
 * /index.php
 * @author IDea Factory - jean-luc.a@ideafactory.fr - Sept. 2020
 * @version 1.0.0
 *  Point d'entrée de l'application PHP
 */
ini_set('display_errors', true);
error_reporting(E_ALL);



// Charger les fichiers contenant les classes utilisées

require_once(__DIR__ . '/src/Core/Http/Request.php');


// Traiter la requête HTTP
// Créer une instance de l'objet Request
$request = new Request();

require_once(__DIR__ . '/src/Controllers/' . $request->getControllerName());

$class = $request->getController();
$controller = new $class(); // new NotFound() ou new Players() en fonction de la requête HTTP

$controller->invoke();

// Retourner une réponse HTTP
$controller->sendResponse();

require_once(__DIR__ . '/src/Core/Response/Response.php');
require_once(__DIR__ . '/src/Core/Response/HtmlResponse.php');
require_once(__DIR__ . '/src/Core/Response/JsonResponse.php');

$HtmlResponse=new HtmlResponse();
$JsonResponse= new JsonResponse();

$HtmlResponse->send();
$JsonResponse->send();