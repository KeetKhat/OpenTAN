<?php

header('content-type:application/json');

$url_api = "http://open.tan.fr/ewp";

//Transformation des données obtenues par l'API en un tableau exploitable par PHP
$json_lieu = file_get_contents("$url_api/arrets.json");
$json_lieu = json_decode($json_lieu, true);

//Déclaration des variables par rapport au tableau
$code_lieu = array_column($json_lieu, 'codeLieu');
$nom_lieu = array_column($json_lieu, 'libelle');

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