<?php
/**
 * src/Core/Database/AbstractDatabaseLayer.php
 * Couche d'abstraction de connexion aux bases de données
 */

 abstract class AbstractDatabaseLayer{
    /**
     * @var string $host
     * L'adresse ou le domaine du serveur de base de données
     */
    protected $host;

    /**
     * @var integer $port
     * N° du port derrière lequel le service répond
     */
    protected $port;

    /**
     * @var string $dbName
     * Nom de la base de données à utiliser
     */
    protected $dbName;

    /**
     * @var string $username
     * Utilisateur autorisé sur le serveur et la base de données
     */
    protected $username;

    /**
     * @var string $password
     * Mot de passe associé à l'utilisateur de la base de données
     */
    protected $password;

    /**
     * @var ? $db
     * Contient l'instance de connexion à la base de données
     */
    protected $db;

    /**
     * Retourne l'instance de connexion à la base de données
     */
    public function getInstance(){
        return $this->db;
    }
 }