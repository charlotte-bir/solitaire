<?php
/**
 * src/Repositories/PlayerRepository.php
 * @author ADRAR - Sept. 2020
 * @version 1.0.0
 * Collectionne l'ensemble des joueurs de solitaire
 */
require_once(__DIR__ . '/../Models/PlayerModel.php');
require_once(__DIR__ . '/../Core/Database/PDOMySQL.php');
require_once(__DIR__ . '/../Core/Database/Repository/Repository.php');

 class PlayerRepository extends Repository {

      public function __construct() {
          //Appeler explicitement le constructeur de la class parente
          parent::__construct(substr(get_class($this), 0, strpos(get_class($this),'Repository')));

          
      }
      public function save(): PlayerModel {
        // Recuperer les données du "frontend"
        $input = json_decode(file_get_contents('php://input'));
        
        $sqlQuery = 'INSERT INTO ' . $this->table . '(';
        foreach ($this->cols as $col) {
            $sqlQuery .= $col . ',';
        }

        // ne pas oublier d'enlever la derniere virgule inutile
        $sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 1);

        //continuer la requete
        $sqlQuery .= ') VALUES (';
        foreach ($this->cols as $col) {
            $sqlQuery .= ':' . $col . ',';
        }
        // ne pas oublier d'enlever la derniere virgule inutile
        $sqlQuery = substr($sqlQuery, 0, strlen($sqlQuery) - 1);

        //Terminer la requete
        $sqlQuery .= ');';
        echo($sqlQuery);

        //INSERT INTO player (id,name,time) VALUES (:id,:name,:time);

        //Affecter les valeurs a chasque placeholder
        $values = [];
        foreach ($this->cols as $col) {
            if ($col === 'id') {
                $values[$col] = null;
            }else {
                $values[$col] = $input->{$col};
            }
            
        }
        // Le tableau sera : 
        //['id' => , 'name' => 'Casper le fantome', 'time'=>'00.12.00'] 

        //On peut preparer la requete a executer
        $statement = $this->db->prepare($sqlQuery);
        $statement->execute($values);

        return new PlayerModel();
      } 

      public function findAll(): array {
          $results = parent::findAll();

          foreach ($results as $row) {
            $player = new PlayerModel();
            $player->setId($row['id']);
            $player->setName($row['name']);
            $player->setTime(\DateTime::createFromFormat('H:i:s', $row['time']));

            $this->repository[] = $player;
        }

        return $this->repository;
      }

      public function findById(int $id): PlayerModel {
        $result = parent::findById($id);

        $player = new PlayerModel();
        $player->setId($result['id']);
        $player->setName($result['name']);
        $player->setTime(\DateTime::createFromFormat('H:i:s', $result['time']));

        return $player;
    }

      public function findByName(string $name): PlayerModel {
          $model = null; //Par defaut , on considere un model null
          
          foreach ($this->repository as $playerModel) {
              if ($playerModel->getName() === $name) {
                  $model = $playerModel;
              }
          }
          return $model;
      }

      private function _hydrate() {
          $this->repository[] = new PlayerModel('Cha', new \DateTime());
          $this->repository[] = new PlayerModel('Murielle', new \DateTime());
          $this->repository[] = new PlayerModel('Alphonse', new \DateTime());
            
          // Ancienne facon d'ajouter un element dans une tableau PHP (fonctionnel)
          array_push($this->repository, new PlayerModel('Maurice', new \DateTime()));
      }
 }