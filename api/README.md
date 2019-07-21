# OpenTAN API
Ce dossier pointe vers le sous-domaine https://api.opentan.fr/

## horaires.php
Affiche la liste des arrêts avec leur code et leur nom, chaque code est lié à un numéro qui concorde avec son nom  
Exemple : 50 Otages est au numéro 0 donc son code sera aussi au numéro 0

Le paramètre ?arrets= doit contenir le code de l'arrêt choisi  
Exemple : horaires.php?arrets=COMM

Le paramètre &ligne= doit contenir le numéro de la ligne choisie  
Exemple : horaires.php?arrets=COMM&ligne=C2

Le paramètre &sens= doit contenir le numéro du sens choisi  
Exemple : horaires.php?arrets=COMM&ligne=C2&sens=2 nous renvoie vers les horaires du trajet vers "Gare Sud"
