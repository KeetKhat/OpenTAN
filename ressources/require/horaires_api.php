<?php

header('content-type:application/json');

$url_api = "http://open.tan.fr/ewp";

//Transformation des données obtenues par l'API en un tableau exploitable par PHP
$json_lieu = file_get_contents("$url_api/arrets.json");
$json_lieu = json_decode($json_lieu, true);

//Déclaration des variables par rapport au tableau
$code_lieu = array_column($json_lieu, 'codeLieu');
$nom_lieu = array_column($json_lieu, 'libelle');

/* Début de la correction des arrêts en double */

//8 Mai
$nom_lieu[1] = '8 Mai (Rezé)';
$nom_lieu[2] = '8 Mai (Vertou)';

//Ampère
$nom_lieu[11] = 'Ampère (Carquefou)';
$nom_lieu[12] = 'Ampère (La Chapelle-sur-Erdre)';

//Beau Soleil
$nom_lieu[59] = 'Beau Soleil (Sainte-Luce-sur-Loire)';
$nom_lieu[60] = 'Beau Soleil (Bouguenais)';

//Cambronne
$nom_lieu[154] = 'Cambronne (Nantes)';
$nom_lieu[155] = 'Cambronne (Saint-Sébastien-sur-Loire)';

//Europe
$nom_lieu[324] = 'Europe (Thouaré-sur-Loire)';
$nom_lieu[325] = 'Europe (Vertou)';

//Garotterie
$nom_lieu[377] = 'Garotterie (Saint-Herblain)';
$nom_lieu[378] = 'Garotterie (Saint-Aignan de Grand Lieu)';

//Haute Forêt
$nom_lieu[430] = 'Haute Forêt (Nantes)';
$nom_lieu[431] = 'Haute Forêt (Vertou)';

//Jean Jaurès
$nom_lieu[470] = 'Jean Jaurès (La Chapelle-sur-Erdre)';
$nom_lieu[471] = 'Jean Jaurès (Nantes)';

//Jean Monnet
$nom_lieu[473] = 'Jean Monnet (Rezé)'; 
$nom_lieu[474] = 'Jean Monnet (Vertou)';

//Joliverie
$nom_lieu[480] = 'Joliverie (Nantes)';
$nom_lieu[481] = 'Joliverie (Saint-Sébastien-sur-Loire)';

//Lechat
$nom_lieu[548] = 'Lechat (Rezé)';
$nom_lieu[549] = 'Lechat (Nantes)';

//Mermoz
$nom_lieu[635] = 'Mermoz (Saint-Sébastien-sur-Loire)';
$nom_lieu[636] = 'Mermoz (Nantes)';

//Plessis
$nom_lieu[768] = 'Plessis (La Chapelle-sur-Erdre)';
$nom_lieu[769] = 'Plessis (Sautron)';

//Point du Jour
$nom_lieu[775] = 'Point du Jour (Nantes)';
$nom_lieu[776] = 'Point du Jour (Thouaré-sur-Loire)';

//Portereau
$nom_lieu[801] = 'Portereau (Saint-Sébastien-sur-Loire)';
$nom_lieu[802] = 'Portereau (Vertou)';

//Rocher
$nom_lieu[862] = 'Rocher (Saint-Herblain)';
$nom_lieu[863] = 'Rocher (Vertou)';

//Terte
$nom_lieu[950] = 'Tertre (Nantes)';
$nom_lieu[951] = 'Tertre (Saint-Jean-de-Boiseau)';

//Thébaudières
$nom_lieu[953] = 'Thébaudières (Le Cellier)';
$nom_lieu[954] = 'Thébaudières (Saint-Herblain)';

//Ecoles
$nom_lieu[974] = 'Écoles (Le Pellerin)';
$nom_lieu[975] = 'Écoles (Les Sorinières)';


/* Fin de la correction des arrêts en double */

if (isset($_GET['arrets']) && !empty($_GET['arrets']))
{
    $cle_lieu = array_search($_GET['arrets'], array_column($json_lieu, 'codeLieu'));
    if (is_numeric($cle_lieu))
    {
        if (isset($_GET['ligne']) && !empty($_GET['ligne']))
        {
            //Transformation des données obtenues par l'API en un tableau exploitable par PHP
            $json_lignes = @file_get_contents("$url_api/horairesarret.json/{$_GET['arrets']}/{$_GET['ligne']}/1");

            if ($json_lignes != null) //Vérification des erreurs
            {
                $json_lignes = json_decode($json_lignes, true);
            }
            else
            {
                echo json_encode(array('code' => '404', 'message' => 'La ligne est incorrecte'));
                header('HTTP/1.1 404 Not Found');
                $erreur = true;
            }

            if (isset($_GET['sens']) && !empty($_GET['sens']))
            {
                switch ($_GET['sens'])
                {
                    case 1:
                        $json_horaires = file_get_contents("$url_api/horairesarret.json/{$_GET['arrets']}/{$_GET['ligne']}/1");
                        $json_horaires = json_decode($json_horaires, true);
                        if (@$json_horaires['horaires'] != null)
                        {
                            if (@$json_horaires['notes'] == null)
                            {
                                echo json_encode(array('horaires' => $json_horaires['horaires'], 'couleur' => $json_horaires['codeCouleur']));
                            }
                            else
                            {
                                echo json_encode(array('horaires' => $json_horaires['horaires'], 'couleur' => $json_horaires['codeCouleur'], 'notes' => $json_horaires['notes']));
                            }
                        }
                        else
                        {
                            echo json_encode(array('code' => '404', 'message' => 'Aucun horaire n\'est disponible'));
                            header('HTTP/1.1 404 Not Found');
                        }
                    break;

                    case 2:
                        $json_horaires = file_get_contents("$url_api/horairesarret.json/{$_GET['arrets']}/{$_GET['ligne']}/2");
                        $json_horaires = json_decode($json_horaires, true);
                        if (@$json_horaires['horaires'] != null)
                        {
                            if (@$json_horaires['notes'] == null)
                            {
                                echo json_encode(array('horaires' => $json_horaires['horaires'], 'couleur' => $json_horaires['codeCouleur']));
                            }
                            else
                            {
                                echo json_encode(array('horaires' => $json_horaires['horaires'], 'couleur' => $json_horaires['codeCouleur'], 'notes' => $json_horaires['notes']));
                            }
                        }
                        else
                        {
                            echo json_encode(array('code' => '404', 'message' => 'Aucun horaire n\'est disponible'));
                            header('HTTP/1.1 404 Not Found');
                        }
                    break;

                    default:
                        echo json_encode(array('code' => '404', 'message' => 'Le sens est incorrect'));
                        header('HTTP/1.1 404 Not Found');
                }
            }
            else
            {
                if (isset($erreur) && $erreur)
                {
                   return;
                }
                else
                {
                   echo json_encode(array('ligne' => $json_lignes['ligne']));
                }
            }
        }
        else
        {
            $tableau_lieu = $json_lieu["$cle_lieu"];
            echo json_encode(array_column($tableau_lieu['ligne'], 'numLigne'));
        }
    }
    else
    {
        echo json_encode(array('code' => '404', 'message' => 'L\'arrêt est incorrect'));
        header('HTTP/1.1 404 Not Found');
    }
}
else
{
    echo json_encode(array('codeArrets' => $code_lieu, 'nomArrets' => $nom_lieu));
}
?>
