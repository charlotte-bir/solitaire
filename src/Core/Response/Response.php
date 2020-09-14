<?php
/**
 * src/Core/Response/Response.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 *  
 */
abstract class Response {

    /**
     * @var string $httpHeaders
     */
    protected $httpHeaders;

    /**
     * @var string $content
     */
    protected $content;


    public function send(){

    }

    protected function addHeaders():string{

    }

    protected function sendHeaders(){

    }

    public function setContent(){}

}