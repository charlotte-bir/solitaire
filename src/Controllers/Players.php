<?php
/**
 * src/Controllers/Players.php
 * @author ADRAR - Sept.2020
 * @version 1.0.0
 * Controleur pour la gestion des joueurs du solitaire
 */
require_once(__DIR__ . '/../Core/Controllers/Controller.php');
require_once(__DIR__ . '/../Repositories/PlayerRepository.php');
require_once(__DIR__ . '/../Core/Controllers/InvocableInterface.php');

final class Players extends Controller implements InvocableInterface {

    /**
     * @var PlayerRepository $repository
     * Depot des donnees des joueurs
     */
    private $repository;
    /**
     * @var string $title
     * Titre qui sera passé à la vue
     */
   private $title;

   /**
     * @var string $title
     * Sous-titre qui sera passé à la vue
     */
   private $subTitle;

   
   public function __construct(){
        $this->title = 'Hall of Fame';
      
       // Instancier le depot de données
       $this->repository = new PlayerRepository();
   }

   public function bestof() {
       $this->view = __DIR__ . '/Views/players.view.php';
       $this->renderView();
   }

   public function onePlayer() {
        $this->view = __DIR__ . '/Views/player.view.php';
        $this->renderView();
   }

   public function addPlayer(){
        $player = $this->repository->save();
        
        $this->view = __DIR__ . '/Views/add.json.php';
        $this->renderView();
   }

   public function invoke(array $args = []) {
       $method = array_key_exists('method', $_GET) ? $_GET['method'] : 'bestof';
        call_user_func_array(
            [
                $this,
                $method
            ], // Le nom de la methode ($method) de l'objet courant ($this)
            $args // Les parametres eventuels a transmettre a cette methode
        );
   }
   public function getRepository(): PlayerRepository {
       return $this->repository;
   }


   /**
    * Défini la valeur de l'attribut privé "title"
    * avec la valeur du paramètre "title" transmis
    * => setter
    */
   public function setTitle(string $title) {
       if (is_numeric($title)){
           die('pas de valeur numérique');
       } 
       
       $this->title = $title;
   }

   /**
    * Retourne la valeur "title" de l'objet courant (this)
    * => getter
    */
   public function getTitle(): string{
       return $this->title;
   }

   public function setSubTitle(string $subTitle){
       $this->subTitle = $subTitle;
   }

   public function getSubTitle(): string{
       return $this->subTitle;
   }

   public function htmlTitle(): string {
       return '<h1>' .$this->title . '</h1>' . '<h2>' . $this->subTitle . '</h2>';
   }
}