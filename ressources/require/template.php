<?php

class template
{
    function display($include_file)
    {
        $include_file = file_get_contents("$include_file");
        $include_file = preg_replace('#<!--\sINCLUDE\s(.+)\s-->#isU', '<?php require_once("ressources/html/$1"); ?>', $include_file);

        ob_start();
        eval(' ?>' . $include_file);
        $contenu = ob_get_contents();
        ob_end_clean();

        $contenu = str_replace('{TITRE_PAGE}', 'Accueil', $contenu); //A Ameliorer

        echo $contenu;
    }

}