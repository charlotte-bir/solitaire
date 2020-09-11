<?php
/**
 * src/Models/PlayerModel.php
 * @author ADRAR-Sept 2020
 * @version 1.0.0
 * Modèle de stockage de informations relatives aux joueurs
 */

 class PlayerModel {
     /**
      * @var int $id
      * Identifiant du joueur
      */
     private $id;
     /**
      * @var string $name
      * Nom du joueur
    */
    private $name;

    /**
     * @var \DateTime $time
     * Temps mis pour finaliser la partie
     */
    private $time;

    public function __construct() {}

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setTime(\DateTime $time) {
        $this->time = $time;
    }

    public function getTime(): string {
        return $this->time->format('H:i:s');
    }

    //boucle sur instance de classe
    public function getCols(): array {
        $cols = [];

        foreach($this as $property =>$value) {
            $cols[] = $property;
        }

        return $cols;
    }
 }