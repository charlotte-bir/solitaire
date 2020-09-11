<?php
/**
 * src/Controllers/Views/players.view.php
 * Vue avec les données des joueurs
 * 
 */
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Best of joueurs</title>
    <!--  Load defined stylesheets from the controller  -->
    <?php
        if (count($stylesheets) >0){
            foreach ($stylesheets as $stylesheet){?>
            <link 
                rel="stylesheet" 
                href="<?php echo $stylesheet["href"]; ?>" 
                integrity="<?php echo $stylesheet["integrity"]; ?>" 
                crossorigin="<?php echo $stylesheet["crossorigin"]; ?>"
                > 
            <?php }
        }
    ?>
</head>

<body>
    <div class="container">
        <header class="header row">
            <h1 class="xs-12"><?php echo $controller->getTitle(); ?></h1>
        </header>
        <main class="row">
            <ul class="list-unstyled xs-12">
                <?php
                foreach ($controller->getRepository()->findAll() as $player) {
                    echo '<li>';
                    echo '<a href="index.php?controller=players&method=onePlayer&id=' . $player->getId() . '"  data-original-title="'. $player->getName() .'" data-content="'. $player->getTime() .'" data-toggle="popover" tabindex="0" data-trigger="hover">';
                    echo  '<li class="list-group-item">' . $player->getName() . '</li>';
                    echo '</a></li>';
                }
                ?>
            </ul>
        </main>
    </div>

    <?php
        if (count($scripts) >0){
            foreach ($scripts as $script){?>
            <script 
                src="<?php echo $script["href"]; ?>" 
                integrity="<?php echo $script["integrity"]; ?>" 
                crossorigin="<?php echo $script["crossorigin"]; ?>"
                ></script> 
            <?php }
        }
        // Activer les popovers
        if ($controller->isPopoverEnabled()){?>
            <script>
                $('[data-toggle="popover"]').popover();
            </script>
        <?php }
    ?>

</body>

</html>