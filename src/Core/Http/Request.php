<?php
/**
 * src/Http/Request.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 * Récupère les infos d'une requête HTTP
 */
class Request {
    /**
     * @var string $requestType
     * Type de la requête HTTP : GET | POST | PUT | DELETE | PATCH
     */
    private $requestType;

    /**
     * @var array $requestParams
     * Collection des parametres de la requête HTTP (QueryString)
     */
    private $requestParams;

    /**
     * @var  string $requestURI
     * URI qui a conduit jusqu'a index.php
     */
    private $requestURI;

    /**
     * @var string $controllerName
     * Nom du controleur a instancier
     */
    private $controllerName;


    /**
     * @var string $controller
     * Nom de la class a instancier
     */
    private $controller;

    /**
     * @var string $fallback
     * controleur par defaut a afficher si aucun controleur n'a ete trouvé
     */
    private $fallback;

    /**
     * @var array $routes
     * Contient les "routes" de l'application
     */
    private $routes = [
        [
            'path' => '/players',
            'httpMethod' => 'GET',
            'controller' => 'Players',
            'method' => 'bestof'
        ],
        [
            'path' => '/players',
            'httpMethod' => 'POST',
            'controller' => 'Players',
            'method' => 'addPlayer'
        ]
    ];

    public function __construct( string $fallback = null) {
        $this->requestType = $_SERVER['REQUEST_METHOD'];
        $this->requestParams = $_GET;

        //on travaille avec des URI
        $this->requestURI = $_SERVER['REQUEST_URI'];
        $this->_traiterURI();

        $this->fallback = $fallback;
        
        //$this->_setControllerName();// defini le nom du fichier qui contient le controleur
    }

    public function getRequestType(): string {
        return $this->requestType;
    }

    public function getRequestParams(): string {
        $output = '';
        foreach ($this->requestParams as $requestParam => $value) {
            $output .= $requestParam . ' : ' . $value . "<br>";
        }
        return $output;
    }

    public function getControllerName(): string {
        return $this->controllerName;
    }

    public function getController(): string {
        return $this->controller;
    }



    private function _setControllerName() {
        if (array_key_exists('controller', $this->requestParams)) {
            $name = $this->requestParams['controller']; //recupere la valeur associé a la cle controller
            $this->controllerName = ucfirst($name) . '.php';
            // pareil que
            //$this->controllerName = ucfirst($this->requestParams['controller']) . '.php';
            if (file_exists(__DIR__ . '/../../Controllers/' . $this->controllerName)) {
                $this->controller = ucfirst($name);
            } else {
                $this->controllerName = 'NotFound.php';
                $this->controller = 'NotFound';
            }
            
        } else {
            $this->controllerName = 'NotFound.php'; //fallback (par defaut, se sera NotFound.php)
            $this->controller = 'NotFound';
        }
    }

    private function _traiterURI() {
        $laRoute = null;
        foreach ($this->routes as $route) {
            if ($this->requestURI === $route['path'] && $this->requestType === $route['httpMethod']) {
                $laRoute= $route;
                break;
            }
        }

        
        // Si on a trouvé la route...
        if ($laRoute) {
            $this->controllerName = $laRoute['controller'] . '.php';
            $this->controller = $laRoute['controller'];
            // Pauvre implementation de la methode a utiliser dans le controleur
            $_GET['method'] = $laRoute['method'];
        } else {
            if (!is_null($this->fallback)) {
                $this->controllerName = $this->fallback . ".php";
                $this->controller = $this->fallback;
            } else {
                $this->controllerName = "NotFound.php";
                $this->controller = "NotFound";
            } 
        }
    }
}