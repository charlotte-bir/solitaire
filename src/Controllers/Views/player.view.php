<?php
/**
 * src/Controllers/Views/players.view.php
 *  Vue avec les données des joueurs
 */
?>
<!doctype html>
<html lang="fr">
    <head>
        <title>Player</title>
    </head>

    <body>
        <h1>Un joueur</h1>
        <ul>
            <?php
                echo '<strong>' . $controller->getRepository()->findById($_GET["id"])->getName() .'</strong>';
                echo ' : ' . $controller->getRepository()->findById($_GET["id"])->getTime();
            ?>
        </ul>
    </body>
</html>