<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="manifest" href="/ressources/js/manifest.json">
        <meta name="theme-color" content="#31aa4e" />
        <meta property="og:title" content="OpenTAN" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="https://opentan.cf/" />
        <meta property="og:image" content="https://opentan.cf/ressources/images/logo/logo_image.png" />
        <meta property="og:image:width" content="512" />
        <meta property="og:image:height" content="512" />
        <meta property="og:description" content="OpenTAN vous permet de trouver facilement et simplement les horaires en temps réel de vos différentes lignes" />
        <link rel="icon" type="image/png" href="/ressources/images/logo/logo_image.png" />
        <link rel="stylesheet" href="/ressources/css/style.css" type="text/css" />
        <script>
        if ("sombre" in localStorage && localStorage.getItem("sombre") === "true")
        {
            document.write("<link rel=\"stylesheet\" href=\"/ressources/css/sombre.css\" type=\"text/css\" />")
        }
        </script>
        <title><?php if (isset($titre)){ echo $titre; } else { echo "Default"; }?> - OpenTAN</title>
    </head>