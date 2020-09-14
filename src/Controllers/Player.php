<?php
/**
 * src/Controllers/Player.php
 * Contrôleur pour l'affichage d'in joueur en oarticulier
 */
require_once(__DIR__ . '/../Core/Controllers/Controller.php');
require_once(__DIR__ . '/../Repositories/PlayerRepository.php');

final class Player extends Controller{
    private $repository;

    public function __construct(){
        $this->view = __DIR__ . '/Views/player.view.php';
        // Instancier le dépôt des données
        $this->repository=new PlayerRepository();
    }

    public function getRepository():PlayerRepository{
        return $this->repository;
    }
}