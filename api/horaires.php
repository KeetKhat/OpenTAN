<?php
header('content-type:application/json');

$url_api = "http://open.tan.fr/ewp";
$user_agent = "OpenTAN Bot/1.0";

$curl = curl_init("$url_api/arrets.json");
curl_setopt($curl,CURLOPT_USERAGENT, $user_agent);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$retour = curl_exec($curl);
curl_close($curl);

$retour = json_decode($retour, true);

//Déclaration des variables par rapport au tableau
$code_lieu = array_column($retour, 'codeLieu');
$nom_lieu = array_column($retour, 'libelle');

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

//Correction du bug de l'API
$nom_lieu[array_search('OTAG', $code_lieu)] = '50 Otages';

/* Fin de la correction des arrêts en double */

if (isset($_GET['arrets']) && !empty($_GET['arrets'])) //On regarde les lignes disponibles pour l'arrêt choisi
{
    $demande_lieu = array_search($_GET['arrets'], array_column($retour, 'codeLieu'));

    if (isset($_GET['ligne']) && !empty($_GET['ligne'])) //On regarde les horaires pour la ligne choisie
    {
        $curl = curl_init("$url_api/horairesarret.json/{$_GET['arrets']}/{$_GET['ligne']}/1");
        curl_setopt($curl,CURLOPT_USERAGENT, $user_agent);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $retour = curl_exec($curl);

        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200) //On vérifie si la ligne existe et si ce n'est pas le cas on envoie une erreur
        {
            echo json_encode(array('code' => '404', 'message' => 'La ligne est incorrecte'));
            header('HTTP/2 404 Not Found');
            exit();
        }
        elseif (!isset($_GET['sens']))
        {
            echo $retour;
        }

        curl_close($curl);

        if (isset($_GET['sens']))
        {
            //Correction de l'API qui renvoie des légendes manquantes
            $curl = curl_init("https://www.tan.fr/ewp/mhv.php/horairesarrets.html?codeArret={$_GET['arrets']}&numLigne={$_GET['ligne']}&sens={$_GET['sens']}");
            curl_setopt($curl,CURLOPT_USERAGENT, $user_agent);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $retour = curl_exec($curl);
            preg_match_all("/<div class=\"direction-txt\">([A-Za-z])\s\:\s([A-Za-z éàèôûù\/.]+)<\/div>/", $retour, $correction_notes, PREG_SET_ORDER, 0);
            curl_close($curl);
            //FIN
            
            if ($_GET['sens'] == 1 || $_GET['sens'] == 2)
            {
                $curl = curl_init("$url_api/horairesarret.json/{$_GET['arrets']}/{$_GET['ligne']}/{$_GET['sens']}");
                curl_setopt($curl,CURLOPT_USERAGENT, $user_agent);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $retour = curl_exec($curl);
                curl_close($curl);

                $horaires = json_decode($retour, true);

                if (isset($horaires['horaires']))
                {
                    //Correction de l'API qui renvoie des légendes manquantes
                    if (isset($horaires['notes']))
                    {
                        for($i = 0; count($correction_notes) > $i; $i++)
                        {
                        $horaires['notes'][$i]['libelle'] = $correction_notes[$i][2];
                        }
                    }
                    //FIN

                    if (!isset($horaires['notes']))
                    {
                        echo json_encode(array('horaires' => $horaires['horaires'], 'couleur' => $horaires['codeCouleur'],  'prochainsHoraires' => $horaires['prochainsHoraires']));
                    }
                    else
                    {
                        echo json_encode(array('horaires' => $horaires['horaires'], 'couleur' => $horaires['codeCouleur'], 'notes' => $horaires['notes'], 'prochainsHoraires' => $horaires['prochainsHoraires']));
                    }
                }
                else
                {
                    echo json_encode(array('code' => '404', 'message' => 'Aucun horaire n\'est disponible pour cet arrêt'));
                    header('HTTP/2 404 Not Found');
                    exit();
                }
            }
            else
            {
                echo json_encode(array('code' => '404', 'message' => 'Le sens est incorrect'));
                header('HTTP/2 404 Not Found');
                exit();
            }
        }
        elseif (count($_GET) >= 3)
        {
            echo json_encode(array('code' => '400', 'message' => 'Mauvaise requête GET'));
            header('HTTP/2 400 Bad Request');
            exit();
        }
    }
    else //Si $_GET['ligne'] n'est pas déclaré on affiche les lignes de l'arrêt
    {
        //On vérifie si le tableau qui affiche les lignes est déclaré
        if (isset($retour["$demande_lieu"])) //Sinon on continue le traitement
        {
            $tableau_ligne = $retour["$demande_lieu"];
            echo json_encode(array_column($tableau_ligne['ligne'], 'numLigne'));
        }
        else //Si il ne l'est pas c'est que l'arrêt n'existe pas donc on envoie une erreur
        {
            echo json_encode(array('code' => '404', 'message' => 'L\'arrêt est incorrect'));
            header('HTTP/2 404 Not Found');
            exit();
        }
    }
}
else //Si $_GET['arrets'] n'est pas déclaré on affiche la liste des arrêts
{
    echo json_encode(array('codeArrets' => $code_lieu, 'nomArrets' => $nom_lieu));
}
