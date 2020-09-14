<?php
/**
 * src/Core/Controllers/Controller.php
 *  Classe parente qui définit le modèle de TOUS les contrôleurs
 */
abstract class Controller {
    /**
     * @var string $view
     *  Le chemin vers la vue associée au contrôleur
     */
    protected $view;

    private $parseTemplate;

    /**
     * @var array $stylesheets
     * Contient la collection des fueilles de style à utiliser
     */
    private $stylesheets=[
        [
            'href'=>'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css',
            'integrity' => 'sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z',
            'crossorigin' => 'anonymous'
        ]
    ];

    private $scripts=[
        [
            'src'=>'https://code.jquery.com/jquery-3.5.1.slim.min.js',
            'integrity'=>'sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj',
            'crossorigin'=>'anonymous'
        ],[
            'src'=>'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js',
            'integrity'=>'sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN',
            'crossorigin'=>'anonymous'
        ],[
            'src'=>'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js',
            'integrity'=>'sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV',
            'crossorigin'=>'anonymous'
        ]
    ];

    /**
     * @var boolean $enablePopover
     * Détermine si les popovers sont activés ou non
     */
    private $enablePopover=true;

    public function isPopoverEnabled():bool{
        return $this->enablePopover;
    }

    public function togglePopover(){
        $this->enablepopover=!$this->enablepopover;
    }

    public function getStylesheets():array{
        return $this->stylesheets;
    }

    public function getScripts():array{
        return $this->scripts;
    }

    protected function renderView() {
        $controller = $this; // Définit une variable égale au contrôleur courant
        $stylesheets=$this->stylesheets;
        $scripts=$this->scripts;
        ob_start();
        include($this->view);
        $this->parseTemplate = ob_get_contents();
        ob_end_clean();
    }

    public function sendResponse() {
        // header('Content-Type: text/html', false, 200);
        header('Acces-Control-Allow-Origin: http://127.0.0.1:8080');
        header('Acces-Control-Allow-Headers: *');
        echo $this->parseTemplate;
    }
}