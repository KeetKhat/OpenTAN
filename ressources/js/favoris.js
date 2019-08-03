var request = indexedDB.open("favoris") //Nous ouvrons la base de données

request.onupgradeneeded = function() //Si la création s'est bien déroulée, on ajoute des tables
{
    var db = request.result
    var objectStore = db.createObjectStore("horaires", { keyPath: "nom" })
    objectStore.createIndex("nom", "nom")
    objectStore.createIndex("couleur", "couleur")
    objectStore.createIndex("contenu", "contenu")
}

request.onerror = function() //Si l'ouverture a échoué, on envoie un message à l'utilisateur
{
    window.onload = function()
    {
        document.getElementsByClassName("message")[0].innerHTML = '<p>Impossible d\'ajouter des horaires aux favoris</p>'
        document.getElementsByClassName("message")[0].className += ' active'
        setTimeout(function()
        {
            document.getElementsByClassName("message")[0].classList.remove('active')
        }, 2000)
    }
}

if (location.pathname.substring(1) === "horaires.php") //Traitement à effectuer quand nous sommes sur la page des horaires
{
    var bouton_favoris = document.getElementById("ajout_favoris")

    if (document.getElementById("couleur_jour").innerHTML === "Mouvement social")
    {
        window.onload = function()
        {
            bouton_favoris.parentNode.removeChild(bouton_favoris)
        }
    }

    request.onsuccess = function() //Notre base de données est ouverte
    {
        var db = request.result
        var nom_actif = document.getElementsByClassName("container_centered")[0].getElementsByTagName("h2")[0].innerHTML + " - " + document.getElementById("couleur_jour").innerHTML

        db.transaction("horaires").objectStore("horaires").get(nom_actif).onsuccess = function(e)
        {
            if (e.target.result) //On vérifie si la valeur existe
            {
                if (nom_actif === e.target.result.nom) //Vérification du nom et de la couleur du jour
                {
                    bouton_favoris.innerHTML = "Retirer des favoris"
                }
            }
        }

        bouton_favoris.addEventListener("click", function()
        {
            db.transaction("horaires").objectStore("horaires").get(nom_actif).onsuccess = function(e)
            {
                if (e.target.result && nom_actif === e.target.result.nom) //Vérification du nom et de la couleur du jour pour supprimer la valeur correspondante
                {
                    request = db.transaction("horaires", "readwrite").objectStore("horaires").delete(nom_actif)
                    request.onsuccess = function()
                    {
                        if (bouton_favoris.innerHTML === "Retirer des favoris") //Affichage des données comme quoi la valeur a bien été retiré
                        {
                            document.getElementsByClassName("message")[0].innerHTML = '<p>Retiré des favoris</p>'
                            document.getElementsByClassName("message")[0].className += ' active'
                            setTimeout(function()
                            {
                                document.getElementsByClassName("message")[0].classList.remove('active')
                            }, 2000)
                            bouton_favoris.innerHTML = "Ajouter aux favoris" //Remplacement par un bouton d'ajout
                        }
                    }
                }
                else //Si elle n'existe pas c'est qu'on doit l'ajouter
                {
                    var ajout_horaire = db.transaction("horaires", "readwrite").objectStore("horaires").put( 
                    {
                        nom: document.getElementsByClassName("container_centered")[0].getElementsByTagName("h2")[0].innerHTML + " - " + document.getElementById("couleur_jour").innerHTML,
                        couleur: document.getElementById("couleur_jour").innerHTML,
                        contenu: document.getElementById("horaires").innerHTML
                    })

                    ajout_horaire.onsuccess = function()
                    {
                        if (bouton_favoris.innerHTML === "Ajouter aux favoris") //Affichage des données comme quoi la valeur a bien été ajouté
                        {   
                            document.getElementsByClassName("message")[0].innerHTML = '<p>Ajouté aux favoris</p>'
                            document.getElementsByClassName("message")[0].className += ' active'
                            setTimeout(function()
                            {
                                document.getElementsByClassName("message")[0].classList.remove('active')
                            }, 2000)
                            bouton_favoris.innerHTML = "Retirer des favoris" //Remplacement par un bouton de retrait
                        }
                    }
                }
            }
        })
    }
}

if (location.pathname.substring(1) === "favoris.php") //Traitement à effectuer quand nous sommes sur la page des favoris
{
    request.onerror = function(e)
    {
        document.getElementsByClassName("container_centered")[0].innerHTML = "<h2>Impossible d'accéder aux favoris</h2>"
    }

    request.onsuccess = function() //Notre base de données est ouverte
    {
        var db = request.result
        db.transaction("horaires").objectStore("horaires").getAll().onsuccess = function(e) //Nous listons tous les arrêts enregistrés, l'API renvoie onsuccess même si la base est vide
        {
            if (e.target.result != "") //Vérification si la base de données contient des données
            {
                document.getElementsByClassName("container_centered")[0].innerHTML = "<h2>Arrêts ajoutés aux favoris</h2>"
                for (i = 0; e.target.result.length > i; i++)
                {
                    document.getElementsByClassName("container_centered")[0].innerHTML += "<span><a href=#" + i + ">⭐ " + e.target.result[i].nom + "</a></span>"
                }

                    if (window.location.hash.substr(1) != "") //Vérification si l'URL contient un hash (Quand l'utilisateur a cliqué sur un lien)
                    {
                        document.getElementsByClassName("container_centered")[0].innerHTML = "<h2>" + e.target.result[window.location.hash.substr(1)].nom + "</h2>"
                        document.getElementsByClassName("container_centered")[0].innerHTML += "<div id='barre'><p><b id='retour_arriere'>Retour</b></p><p><b id='ajout_favoris'>Retirer</b></p></div>" 
                        document.getElementsByClassName("container_centered")[0].innerHTML += "<div id='horaires'>" + e.target.result[window.location.hash.substr(1)].contenu + "</div>"
    
                        document.getElementById("retour_arriere").addEventListener("click", function() //Évenement pour gérer le clique sur le bouton "Revenir en arrière"
                        {
                            window.location.hash = ""
                            window.location.reload()
                        })
    
                        document.getElementById("ajout_favoris").addEventListener("click", function() //Évenement pour gérer le clique sur le bouton "Retirer"
                        {
                            request = db.transaction("horaires", "readwrite").objectStore("horaires").delete(document.getElementsByTagName("h2")[0].innerHTML)
                            request.onsuccess = function()
                            {
                                window.location.hash = ""
                                window.location.reload()
                            }
                        })
                    }

                for (var i = 0; i < document.getElementsByClassName("container_centered")[0].getElementsByTagName("a").length; i++) //Rafraîchissement automatique quand on clique sur un des liens
                {
                    document.getElementsByClassName("container_centered")[0].getElementsByTagName("a")[i].onclick = function()
                    {
                        setTimeout(function() //Ajout d'un sleep car certains navigateurs n'affichent pas les horaires si le rafraîchissement est déclenché trop rapidement
                        {
                            window.location.reload()
                        }, 50)
                    }
                }
            }
            else //Si la base ne contient aucune données, on affiche ce message
            {
                document.getElementsByClassName("container_centered")[0].innerHTML = "<h2>Aucun arrêt enregistré en favoris</h2>"
            }
        }
    }
}