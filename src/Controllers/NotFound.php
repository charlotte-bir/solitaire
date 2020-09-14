<?php
/**
 * src/Controllers/NotFound.php
 */
require_once(__DIR__ . '/../Core/Controllers/Controller.php');
require_once(__DIR__ . '/../Core/Controllers/InvocableInterface.php');

class NotFound extends Controller implements InvocableInterface{

    public function __construct() {
        $this->view = __DIR__ . '/Views/notfound.view.php';
    }

    public function notFound(){
        $this->renderView();
    }

    public function invoke(array $args = []){
        $method = array_key_exists('method',$_GET)? $_GET['method']:'notFound';
        call_user_func_array(
            [
                $this,
                $method
            ], // nom de la méthode ($method) de l'objet courrant ($this)
            $args // les paramètres éventuels à transmettre à cette méthode
        );
    }
}