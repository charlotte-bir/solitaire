<?php
/**
 * src/Core/Database/Repository/Repository.php
 * Abstraction de Repository
 */

abstract class Repository{
    protected $scols;

    protected $table;

    protected $db;

    /**
     * @var array $repository
     *  Tableau qui contient l'ensemble des objets PlayerModel
     */
    protected $repository;

    /**
     * @var string $modelClass
     * Contient le nom de la classe du modèle à traiter
     */
    private $modelClass;

    protected $byId;

    public function _construct(string $model){

        $this->repository = []; // Initialise le repository

        // Connexion à la base de données
        $connexion= new PDOMySQL();
        $connexion->connect();
        $this->db = $connexion->getInstance();

        $this->modelClass= $model . 'Model';

        // requiert le fichier qui conteint la classe du model à traiter
        require_once(__DIR__ . '/../../../Models/' . $this->modelClass . '.php');
        $instance=$this->modelClass;
        $modelInstance=new $instance();

        //Récupérer les colonnes
        $this->cols=$modelInstance->getCols();

        $this->table = strtolower($model);

        $this->byId=$this->db->prepare('SELECT ' . implode(',',$this->cols) . ' FROM ' .  $this->table . ' WHERE id= :id;');
    }

    public function getRepository(): array {
        return $this->repository;
    }

    public function findAll(){
        $sqlQuery = 'SELECT ' . implode(',',$this->cols) . ' FROM ' .  $this->table . ';';
        $results=$this->db->query($sqlQuery);
        return $results;
    }

    public function findById(int $id){
        // Executer la requête préparée
        $this->byId->execute(['id'=>$id]);

        $result=$this->byId->fetch();

        return $result;
    }
}