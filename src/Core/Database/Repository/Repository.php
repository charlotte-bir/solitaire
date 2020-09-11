<?php
/**
 * src/Core/Repository/Repository.php
 * Abstraction de Repository
 */
abstract class Repository {
    protected $cols;

    protected $table;


    protected $db;

    /**
      * @var array $repository
      * Tableau qui contient l'ensemble des objets Playermodel
      */
      protected $repository;

      /**
       * @var string $modelClass
       * Contient le nom de la class du model a traiter
       */
      private $modelClass;

      protected $byId;

    public function __construct(string $model) {

        $this->repository = []; // Initialise le repository

         //connexion a la base de données
        $connexion = new PDOMySQL();
        $connexion->connect();
        $this->db = $connexion->getInstance();

        $this->modelClass =$model . 'Model';

        //Requiert le fichier qui contient la classe du modele a traiter
        require_once(__DIR__ . '/../../../Models/' . $this->modelClass . '.php');
        $instance = $this->modelClass;
        $modelInstance = new $instance(); //i.e nex PlayerModel()
    
        //recuperer les colonnes
        $this->cols = $modelInstance->getCols();

        $this->table = strtolower($model);
        $this->byId = $this->db->prepare('SELECT ' . implode(',', $this->cols) . ' FROM ' . $this->table . ' WHERE id = :id;');
    }

    public function getRepository(): array {
        return $this->repository;
    }

    public function findAll() {
        $sqlQuery = 'SELECT ' . implode(',', $this->cols) . ' FROM ' . $this->table . ';';
        $results = $this->db->query($sqlQuery);
          
        return $results;
    }

    public function findById(int $id) {
        $this->byId->execute(['id' => $id]);
        $result = $this->byId->fetch();// recupere le seul et unique resultat

        return $result;
    }
}