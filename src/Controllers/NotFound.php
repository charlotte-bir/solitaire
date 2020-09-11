<?php
/**
 * src/Controllers/NotFound.php
 * @author ADRAR - Sept.2020
 * @version 1.0.0
 * Controleur pour la page NotFound
 */
require_once(__DIR__ . '/../Core/Controllers/Controller.php');
require_once(__DIR__ . '/../Core/Controllers/InvocableInterface.php');

final class NotFound extends Controller implements InvocableInterface {

    public function __construct(){
        $this->view = __DIR__ . '/Views/notfound.view.php';
    }

    public function notFound() {
        $this->renderView();
    }

    public function invoke(array $args = []) {
        $method = array_key_exists('method', $_GET) ? $_GET['method'] : 'notFound';
         call_user_func_array(
             [
                 $this,
                 $method
             ], // Le nom de la methode ($method) de l'objet courant ($this)
             $args // Les parametres eventuels a transmettre a cette methode
         );
    }



    

}