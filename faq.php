<?php
    $titre = "FAQ";
    require_once("ressources/require/head.php"); ?>
    <body>
        <?php require_once("ressources/require/header.php"); ?>
        <main>
            <h1>Foire aux questions</h1>
            <p><b>D'où viennent les données concernant les transports ?</b> <br />Les données proviennent de "l'API Temps réel TAN" d'Open Data Nantes Métropole</p>
            <p><b>Puis-je utiliser ce site web hors-connexion ?</b> <br />Oui mais certaines fonctionnalités peuvent être indisponible tant que vous êtes hors-connexion</p>
            <p><b>J'ai des suggestions ou des rapports de bugs à vous faire</b> <br />Utilisez la page de <a href="contact.php">contact</a> afin de nous faire part de vos problèmes ou suggestions</p>
            <p><b>Je souhaite voir le code source du site</b> <br />Le lien vers le dépôt GitHub est disponible sur la page <a href="open_source.php">Licences Open Source</a></p>
            <p><b>Quand je rentre mon arrêt il me renvoie sur la page de sélection des arrêts</b> <br />L'arrêt que vous avez rentré est incorrect, comporte des fautes ou des majuscules manquantes. Veillez à sélectionner le bon arrêt à l'aide de la liste déroulante si votre appareil l'affiche</p>
            <p><b>Quand je clique sur une ligne il me renvoie vers la page de sélection des arrêts</b> <br />Le problème vient de l'API de la SEMITAN qui renvoie une erreur serveur. Nous ne pouvons rien faire de notre côté pour corriger cela</p>
        </main>
        <?php require_once("ressources/require/footer.php"); ?> 