<?php
/**
 * src/Repositories/PlayerRepository.php
 * @author ADRAR - Sept 2020
 * @version 1.0.0
 *  Collectionne l'ensemble des joueurs de solitaire
 */

require_once(__DIR__ . '/../Models/PlayerModel.php');
require_once(__DIR__ . '/../Core/Database/PDOMySQL.php');
require_once(__DIR__ . '/../Core/Database/Repository/Repository.php');

class PlayerRepository extends Repository{

    public function __construct() {

        //Appeler explicitement le constructeur de la classe parente
        parent::_construct(substr(get_class($this), 0, strpos(get_class($this),'Repository')));

    }

    public function save():PlayerModel{
        // Récupérer les données du "frontend"
        $input=json_decode(file_get_contents('php://input'));

        $sqlQuery= 'INSERT INTO ' . $this->table .'(';
        foreach ($this->cols as $col) {
            $sqlQuery .= $col . ',';
        }
        // ne pas oublier d'enlever la dernière virgule inutile
        $sqlQuery =substr($sqlQuery,0,strlen($sqlQuery)-1);

        $sqlQuery.=') VALUES (';

        foreach ($this->cols as $col) {
            $sqlQuery .= ':' .$col . ',';
        }
        // ne pas oublier d'enlever la dernière virgule inutile
        $sqlQuery =substr($sqlQuery,0,strlen($sqlQuery)-1);

        $sqlQuery.= ');';

        $values=[];
        foreach ($this->cols as $col) {
            if($col ==='id'){
                $values[$col]=null;
            }else{
                $values[$col] = $input->{$col};
            }
        }
        $statement = $this->db->prepare($sqlQuery);
        $statement->execute($values);
        return new Playermodel();
    }

    public function findByName(string $name): PlayerModel {
        $model = null; // Par défaut, on considère un model null
        
        foreach ($this->repository as $playerModel) {
            if ($playerModel->getName() === $name) {
                $model = $playerModel;
            }
        }
        return $model;
    }

    /**
     * Override
     * @see Repository::findAll()
     */
    public function findAll():array{
        $results=parent::findAll();

        foreach ($results as $row) {
            $player= new PlayerModel();
            $player->setName($row['name']);
            $player->setTime(\DateTime::createFromFormat('H:i:s',$row['time']));
            $player->setId($row['id']);
            $this->repository[]=$player;
        }

        return $this->repository;
    }

    public function findById(int $id){
        $result=parent::findById($id);

        $player= new PlayerModel();
        $player->setName($result['name']);
        $player->setTime(\DateTime::createFromFormat('H:i:s',$result['time']));
        $player->setId($result['id']);

        return $player;
    }
    
    private function _hydrate() {
        $this->repository[] = new PlayerModel('Jean-Luc', new \DateTime());
        $this->repository[] = new PlayerModel('Murielle', new \DateTime());
        $this->repository[] = new PlayerModel('Alphonse', new \DateTime());
        // Ancienne façon d'ajouter un élément dans un tableau PHP (fonctionnel)
        array_push($this->repository, new PlayerModel('Maurice', new \DateTime()));
    }

}