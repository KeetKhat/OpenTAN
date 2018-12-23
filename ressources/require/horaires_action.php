<?php
$url = "http://{$_SERVER['HTTP_HOST']}/ressources/require/horaires_api.php";

	function ParseArrets()
	{
		$liste_arrets = json_decode(file_get_contents($GLOBALS['url']), true);
		$cle_arrets = array_search($_GET['arrets'], $liste_arrets['nomArrets']); //Numéro de l'arrêt dans le tableau
		if (is_numeric($cle_arrets))
		{
			$_GET['arrets'] = $liste_arrets['codeArrets'][$cle_arrets];
		}
		else
		{
			if ($liste_arrets == null || empty($_GET['arrets']))
			{
				header('Location: /horaires.php');
			}
			else
			{
				return;
			}
		}
	}

	function ChoixLigne()
	{
		$liste_arrets = json_decode(file_get_contents($GLOBALS['url']), true);
		$liste_ligne = json_decode(file_get_contents("{$GLOBALS['url']}?arrets={$_GET['arrets']}"), true);

		if ($liste_ligne == null)
		{
			header('Location: /horaires.php');
		}

		$nombre_ligne = count($liste_ligne);
		$cle_arrets = array_search($_GET['arrets'], $liste_arrets['codeArrets']);

		$boutons_ligne = NULL;
		echo "<h2>{$liste_arrets['nomArrets'][$cle_arrets]}</h2>";

		for ($i = 0; $i < $nombre_ligne; $i++)
		{
			$boutons_ligne .= "<a href=\"/horaires.php?arrets={$_GET['arrets']}&ligne={$liste_ligne[$i]}\"><img src=\"/ressources/images/lignes/{$liste_ligne[$i]}.gif\" alt=\"{$liste_ligne[$i]}\"/></a>";
		}
		echo "<div id=\"lignes\">$boutons_ligne</div>";
	}

	function ChoixSens()
	{
		if (empty($_GET['ligne']))
		{
			header('Location: /horaires.php');
		}

		$liste_arrets = json_decode(file_get_contents($GLOBALS['url']), true);
		$liste_sens = json_decode(file_get_contents("{$GLOBALS['url']}?arrets={$_GET['arrets']}&ligne={$_GET['ligne']}"));

		if ($liste_sens == null) //On vérifie si la ligne entrée est correct
		{
			header('Location: /horaires.php'); //Si elle est fausse on effectue un retour vers horaires.php
		}

		$cle_arrets = array_search($_GET['arrets'], $liste_arrets['codeArrets']);
		echo "<h2>{$liste_arrets['nomArrets'][$cle_arrets]} - Ligne {$_GET['ligne']}</h2>";

		echo "<div id=\"sens\">";
		echo "<a href=\"/horaires.php?arrets={$_GET['arrets']}&ligne={$_GET['ligne']}&sens=1\">{$liste_sens->ligne->directionSens1}</a>";
		echo "<a href=\"/horaires.php?arrets={$_GET['arrets']}&ligne={$_GET['ligne']}&sens=2\">{$liste_sens->ligne->directionSens2}</a>";
		echo "</div>";
	}

	function AfficherHoraires()
	{
		if ($_GET['sens'] == 1 || $_GET['sens'] == 2) //On vérifie si le sens entrée est correct
		{
			$liste_arrets = json_decode(file_get_contents($GLOBALS['url']), true);
			$liste_sens = json_decode(file_get_contents("{$GLOBALS['url']}?arrets={$_GET['arrets']}&ligne={$_GET['ligne']}"));
			$ligne_horaires = json_decode(@file_get_contents("{$GLOBALS['url']}?arrets={$_GET['arrets']}&ligne={$_GET['ligne']}&sens={$_GET['sens']}"), true);

			if ($ligne_horaires == null)
			{
				echo "<h2>Aucun horaire n'est disponible pour cet arrêt</h2>";
				return false;
			}

			$cle_arrets = array_search($_GET['arrets'], $liste_arrets['codeArrets']);

			switch ($_GET['sens'])
			{
				case 1:
					$nom_sens_ligne = $liste_sens->ligne->directionSens1;
				break;

				case 2:
					$nom_sens_ligne = $liste_sens->ligne->directionSens2;
				break;
			}

			echo "<h2>{$liste_arrets['nomArrets'][$cle_arrets]} - Ligne {$_GET['ligne']} vers {$nom_sens_ligne}</h2>";
			$nombre_heures = count($ligne_horaires['horaires']);

			echo "<div id=\"horaires\">";

			$couleur = array(
				"1" => "Bleu",
				"2" => "Vert",
				"3" => "Jaune",
				"4" => "Violet",
				"5" => "Blanc"
			);

			$horaires_span = NULL;
			$minutes_span = NULL;

			for ($i = 0; $i < $nombre_heures; $i++)
			{
				$ligne_minute = NULL;
				$minute = NULL;
				$nombre_minutes = count($ligne_horaires['horaires'][$i]['passages']);
				for ($i_minutes = 0; $i_minutes < $nombre_minutes; $i_minutes++)
				{
					$ligne_minute = $ligne_horaires['horaires'][$i]['passages'][$i_minutes];
					$minute .= "$ligne_minute ";
				}

				echo "<div class=\"horaires_ligne_tableau\"><div class=\"heures\"><span>{$ligne_horaires['horaires'][$i]['heure']}</span></div>";
				echo "<div class=\"minutes\"><span>$minute</span></div></div>";
				
			}

			echo "<p><b>Jour {$couleur[$ligne_horaires['couleur']]}</b></p>";

			if (@$ligne_horaires['notes'] != null)
			{
				$nombre_notes = count($ligne_horaires['notes']);

				for ($i = 0; $i < $nombre_notes; $i++)
				{
					if ($ligne_horaires['notes'][$i]['libelle'] != null)
					{
						echo "<p><b>{$ligne_horaires['notes'][$i]['code']}</b> : {$ligne_horaires['notes'][$i]['libelle']}</p>";
					}
					else
					{
						echo "<p><b>{$ligne_horaires['notes'][$i]['code']}</b> : Aucune information disponible</p>";
					}
				}
			}
			echo "</div>";
			
		}
		else
		{
			header('Location: /horaires.php'); //S'il est faux on effectue un retour vers horaires.php
		}
	}
?>