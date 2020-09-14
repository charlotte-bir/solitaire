<?php
/**
 * src/Core/Response/JsonResponse.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 *  
 */

require_once(__DIR__ . '/Response.php');

class JsonResponse extends Response{

    public function send(){
        echo 'Je suis un contenu JSON' ;
    }
    
}