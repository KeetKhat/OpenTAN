<?php

//Déclaration de la variable erreur
$erreur = NULL;

//Vérifie si la variable existe
if (!isset($_GET['erreur'])) //Si non = on renvoie vers une erreur 404
{
    header("Location: erreur.php?erreur=404");
    exit();
}
else //Si oui = on la déclare en GET
{
    $erreur = htmlspecialchars($_GET['erreur']);
}

switch($erreur)
{
    case '403':
        header('HTTP/1.1 403 Forbidden');
        $titre = "Erreur 403";
    break;

    case '404':
        header('HTTP/1.1 404 Not Found');
        $titre = "Erreur 404";
    break;
    
    default:
        header('HTTP/1.1 404 Not Found');
}
    require_once("ressources/require/head.php"); ?>
    <body>
        <?php require_once("ressources/require/header.php"); ?>
        <main>
        <h1><?php if (isset($erreur)) { echo "Erreur $erreur"; } ?></h1>
            <p>
            <?php
                switch($erreur)
                {
                    case '403':
                        echo "Accès interdit";
                    break;

                    case '404':
                        echo "La page n'existe pas ou a été supprimé";
                    break;
                    
                    default:
                        echo "Erreur";
                }
            ?>
            </p>
        </main>
        <?php require_once("ressources/require/footer.php"); ?>