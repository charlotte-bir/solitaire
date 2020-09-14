<?php
/**
 * src/Controllers/Views/players.view.php
 *  Vue avec les données des joueurs
 */
?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <title>Best of joueurs</title>
        <!-- Load defined stylesheets from the controller -->
        <?php
            if(count($stylesheets)>0){
                foreach ($stylesheets as $stylesheet) { ?>
                    <link 
                        href="<?php echo $stylesheet["href"]; ?>" 
                        rel="stylesheet" 
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
                <ul class="list-group xs-12">
                <?php
                        foreach ($controller->getRepository()->findAll() as $player) {
                            echo '<li class="list-group-item"><a href="index.php?controller=players&method=onePlayer&id=' . $player->getId() . '"data-original-title="'. $player->getName() .'" data-content="' . $player->getTime() . '" data-toggle="popover" data-trigger="hover">';
                            echo $player->getName();
                            echo '</a></li>';
                        }
                    ?>
                </ul>
            </main>
        </div>
        <?php
            if(count($scripts)>0){
                foreach ($scripts as $script) { ?>
                    <script
                        src="<?php echo $script["src"]; ?>" 
                        integrity="<?php echo $script["integrity"]; ?>" 
                        crossorigin="<?php echo $script["crossorigin"]; ?>"
                    >
                    </script>
                <?php }
            }   
            // Activer le popovers
            if($controller->isPopoverEnabled()){?>
                <script>
                    $('[data-toggle="popover"]').popover()
                </script>
            <?php }
        ?>
    </body>
</html>