<?php
/**
 * src/Core/Database/AbstractDayabaseLayer.php
 * Couche d'abstraction de connexion aux bases de données
 */
abstract class AbstractDatabaseLayer {
    
    /**
     * @var string $host
     * L'adresse ou le domaine du serveur de bases de données
     */
    protected $host;

    /**
     * @var integer $port
     * Numero du port derriere lequel le service repond
     */
    protected $port;

    /**
     * @var string $dbName
     * Nom de la base de données a utiliser
     */
    protected $dbName;

    /**
     * @var string $username
     * Utilisateur autorisé sur le serveur de la base de données
     */
    protected $username;

    /**
     * @var string $password
     * Mot de passe associé a l'utilisateur de la base de données
     */
    protected $password;
    
    /**
     * @var $db
     * Contient l'instance de connexion a la base de données
     */
    protected $db;

    /**
     * Retourne l'instance de connexion a la base de données
     */
    public function  getInstance() {
        return $this->db;
    }
}