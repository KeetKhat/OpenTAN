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
$nom_lieu[array_search('MAI8', $code_lieu)] = '8 Mai (Rezé)';
$nom_lieu[array_search('HMVE', $code_lieu)] = '8 Mai (Vertou)';

//Ampère
$nom_lieu[array_search('APER', $code_lieu)] = 'Ampère (Carquefou)';
$nom_lieu[array_search('AMPE', $code_lieu)] = 'Ampère (La Chapelle-sur-Erdre)';

//Beau Soleil
$nom_lieu[array_search('BSSL', $code_lieu)] = 'Beau Soleil (Sainte-Luce-sur-Loire)';
$nom_lieu[array_search('BSOL', $code_lieu)] = 'Beau Soleil (Bouguenais)';

//Cambronne
$nom_lieu[array_search('CBSS', $code_lieu)] = 'Cambronne (Saint-Sébastien-sur-Loire)';
$nom_lieu[array_search('CBNA', $code_lieu)] = 'Cambronne (Nantes)';

//Europe
$nom_lieu[array_search('EUCA', $code_lieu)] = 'Europe (Thouaré-sur-Loire)';
$nom_lieu[array_search('EUVE', $code_lieu)] = 'Europe (Vertou)';

//Garotterie
$nom_lieu[array_search('GARO', $code_lieu)] = 'Garotterie (Saint-Aignan de Grand Lieu)';
$nom_lieu[array_search('GRTE', $code_lieu)] = 'Garotterie (Saint-Herblain)';

//Haute Forêt
$nom_lieu[array_search('HFVE', $code_lieu)] = 'Haute Forêt (Vertou)';
$nom_lieu[array_search('HFNA', $code_lieu)] = 'Haute Forêt (Nantes)';

//Jean Jaurès
$nom_lieu[array_search('JJNA', $code_lieu)] = 'Jean Jaurès (Nantes)';
$nom_lieu[array_search('JJCE', $code_lieu)] = 'Jean Jaurès (La Chapelle-sur-Erdre)';

//Jean Monnet
$nom_lieu[array_search('JMNT', $code_lieu)] = 'Jean Monnet (Rezé)'; 
$nom_lieu[array_search('JMON', $code_lieu)] = 'Jean Monnet (Vertou)';

//Joliverie
$nom_lieu[array_search('JLVE', $code_lieu)] = 'Joliverie (Nantes)';
$nom_lieu[array_search('JLIE', $code_lieu)] = 'Joliverie (Saint-Sébastien-sur-Loire)';

//Lechat
$nom_lieu[array_search('LECH', $code_lieu)] = 'Lechat (Nantes)';
$nom_lieu[array_search('LCHA', $code_lieu)] = 'Lechat (Rezé)';

//Mermoz
$nom_lieu[array_search('MMSS', $code_lieu)] = 'Mermoz (Saint-Sébastien-sur-Loire)';
$nom_lieu[array_search('MMNA', $code_lieu)] = 'Mermoz (Nantes)';

//Plessis
$nom_lieu[array_search('PLSS', $code_lieu)] = 'Plessis (La Chapelle-sur-Erdre)';
$nom_lieu[array_search('PLES', $code_lieu)] = 'Plessis (Sautron)';

//Point du Jour
$nom_lieu[array_search('PJOU', $code_lieu)] = 'Point du Jour (Nantes)';
$nom_lieu[array_search('PDJO', $code_lieu)] = 'Point du Jour (Thouaré-sur-Loire)';

//Portereau
$nom_lieu[array_search('PTRE', $code_lieu)] = 'Portereau (Saint-Sébastien-sur-Loire)';
$nom_lieu[array_search('PRTE', $code_lieu)] = 'Portereau (Vertou)';

//Rocher
$nom_lieu[array_search('RCHE', $code_lieu)] = 'Rocher (Vertou)';
$nom_lieu[array_search('RCER', $code_lieu)] = 'Rocher (Saint-Herblain)';

//Terte
$nom_lieu[array_search('TEBS', $code_lieu)] = 'Tertre (Saint-Jean-de-Boiseau)';
$nom_lieu[array_search('TENA', $code_lieu)] = 'Tertre (Nantes)';

//Thébaudières
$nom_lieu[array_search('THEB', $code_lieu)] = 'Thébaudières (Saint-Herblain)';
$nom_lieu[array_search('TBAU', $code_lieu)] = 'Thébaudières (Le Cellier)';

//Ecoles
$nom_lieu[array_search('EPEL', $code_lieu)] = 'Écoles (Le Pellerin)';
$nom_lieu[array_search('ESOR', $code_lieu)] = 'Écoles (Les Sorinières)';

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
