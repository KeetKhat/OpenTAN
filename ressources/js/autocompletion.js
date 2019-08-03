var arrets_completion = document.getElementById("liste_arrets")
var champ_arrets = document.getElementById("arrets")
var bouton_envoyer = document.getElementById("bouton_envoyer")

champ_arrets.placeholder = "Chargement de la liste..."
bouton_envoyer.disabled = true;

fetch('https://api.' + window.location.hostname + '/horaires.php').then(response =>
{
    return response.json()
}).then(data => {

    var liste_noms_arrets = data.nomArrets
    
    liste_noms_arrets.forEach(function(objet)
    {
        var option = document.createElement('option');
        option.value = objet
        arrets_completion.appendChild(option)
    })

    bouton_envoyer.disabled = false;
    champ_arrets.placeholder = "Entrez votre arrêt actuel"

}).catch(err => {
    if (navigator.onLine)
    {
        champ_arrets.placeholder = "Échec du chargement"
        console.log('Erreur de connexion à l\'API - Erreur API')
    }
    else
    {
        champ_arrets.placeholder = "Hors-connexion"
        console.log('Erreur de connexion à l\'API - Hors-connexion')
    }
})