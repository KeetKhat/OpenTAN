<?php
    $titre = "Réglages";
    require_once("ressources/require/head.php"); ?>
    <body>
        <?php require_once("ressources/require/header.php"); ?>
        <main>
             <h1>Réglages d'OpenTAN</h1>
                <div class="settings">
                        <div class="settings_categories">
                                <span>Thème sombre</span>
                                <div class="checkbox sombre"></div>
                        </div>
                        <div class="settings_categories">
                                <span>Notifications</span>
                                <div class="checkbox notifications"></div>
                        </div>
                        <div class="settings_categories">
                                <span>Version 1.4_DEV</span>
                        </div>
                </div>
                <script src="ressources/js/settings.js"></script>
        </main>
        <?php require_once("ressources/require/footer.php"); ?>