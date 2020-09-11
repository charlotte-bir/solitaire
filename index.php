<?php
/**
 * /index.php
 * @author charlotte.bironlalanne@sfr.fr - Sept. 2020
 * @version 1.0.0
 * Point d'entrée de l'application PHP
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

 // Charger les fichiers contenant les classes utilisées
 
 require_once(__DIR__ . '/src/Core/Http/Request.php');

 require_once(__DIR__ . '/src/Core/Database/PDOMySQL.php');

 $connexion = new PDOMySQL();
 $connexion->connect();

// Traiter la requete HTTP
 //Créer une instance de l'objet Request
 $request = new Request();

 require_once(__DIR__ . '/src/Controllers/' . $request->getControllerName());

 $class = $request->getController();
 $controller = new $class(); //new NotFound() ou new Players() en fonction de la requête HTTP

 //Comment appeler une methode en particulier de ce controleur
 $controller->invoke();//i.e $controller->bestof()

 // retourner une réponse HTTP
 $controller->sendResponse();