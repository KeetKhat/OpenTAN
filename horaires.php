	<?php
        $titre = "Horaires";
        require_once("ressources/require/head.php");
    ?>
    <body>
    <?php require_once("ressources/require/horaires_action.php");
         require_once("ressources/require/header.php"); ?>
        <main>
            <h1>Horaires</h1>
            <div class="container_centered">
                    <?php if (!isset($_GET['arrets']))
                        {
                    ?>
                    <form action="horaires.php" method="get">
                        <h2>Entrez votre arrêt actuel</h2>
                        <?php if ((strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') || strstr($_SERVER['HTTP_USER_AGENT'],'iPod') || strstr($_SERVER['HTTP_USER_AGENT'],'iPad'))) {     echo "<p>La liste déroulante n'est pas géré sur iOS, vous devez taper manuellement le nom de l'arrêt en respectant son orthographe et les majuscules</p>"; } ?>
                            <input list="liste_arrets" id="arrets" name="arrets" type="text" />
                                <datalist id="liste_arrets">
                                </datalist>
                            <input type="submit" id="bouton_envoyer" value="Suivant" />
                    </form>
                    <script src="/ressources/js/autocompletion.js"></script>
                    <?php
                        }
                        else
                        {
                            ParseArrets();
                            
                            if (!isset($_GET['ligne']))
                            {
                                ChoixLigne();
                            }
                            else
                            {
                                if (!isset($_GET['sens']))
                                {
                                    ChoixSens();
                                }
                                else
                                {
                                    AfficherHoraires();
                                }
                            }
                        }
                    ?>
            </div>
            <script src="/ressources/js/loader.js"></script>
        </main>
        <?php require_once("ressources/require/footer.php"); ?>