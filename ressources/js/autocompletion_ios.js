// Bravo à Apple qui ne supporte pas la balise datalist et qui force l'utilisation de WebKit sur iOS :)

window.onload = function()
{
    var liste_arrets = document.getElementsByTagName("select")[0]
    var bouton_envoyer = document.getElementById("bouton_envoyer")

    document.getElementsByClassName("message")[0].innerHTML = '<p>Chargement de la liste</p>'
    document.getElementsByClassName("message")[0].className += ' active'
    bouton_envoyer.disabled = true;

    fetch('/ressources/require/horaires_api.php').then(response =>
        {
            return response.json()
        }).then(data => {
        
            var liste_noms_arrets = data.nomArrets
            
            liste_noms_arrets.forEach(function(objet)
            {
                var option = document.createElement('option');
                option.value = objet
                option.innerHTML = objet
                liste_arrets.appendChild(option)
            })
        
            bouton_envoyer.disabled = false;
            document.getElementsByClassName("message")[0].classList.remove('active')
        
        }).catch(err => {
            if (navigator.onLine)
            {
                document.getElementsByClassName("message")[0].innerHTML = '<p>Échec du chargement</p>'
                console.log('Erreur de connexion à l\'API - Erreur API')
            }
            else
            {
                document.getElementsByClassName("message")[0].innerHTML = '<p>Vous êtes hors-connexion</p>'
                console.log('Erreur de connexion à l\'API - Hors-connexion')
            }
        })
}