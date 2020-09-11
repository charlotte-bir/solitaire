<?php
/**
 * src/Controllers/Views/player.view.php
 * Vue avec les données des joueurs
 */
?>
<!doctype html>
<html lang="fr">
    <head>
        <title>The player</title>
    </head>

    <body>
        <h1>Un joueur</h1>
        <!-- liste des players -->
        <ul>
            <?php 
                echo '<strong>' . $controller->getRepository()->findById($_GET["id"])->getName() . '</strong>';
                echo ' : ' . $controller->getRepository()->findById($_GET["id"])->getTime();
            ?>
        </ul>
       
    </body>