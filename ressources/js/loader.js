var header = document.getElementsByTagName("header")[0]
var div_loader = document.createElement("div")

if (document.getElementById("bouton_envoyer"))
{
    var bouton = document.getElementById("bouton_envoyer")
}

if (document.getElementById("lignes"))
{
    var liens_horaires = document.getElementById("lignes").getElementsByTagName("a")
}
else
{
    if (document.getElementById("sens"))
    {
        var liens_horaires = document.getElementById("sens").getElementsByTagName("a")
    }
}

function loader()
{
    header.appendChild(div_loader)
    div_loader.classList.add("loader")
    div_loader.innerHTML="<h2>Chargement</h2>"
}

if (bouton)
{
    bouton.addEventListener("click", function(e)
    {
        loader()
    })
}

if (liens_horaires)
{
    for (var i = 0; i < liens_horaires.length; i++)
    {
        liens_horaires[i].onclick = loader
    }
}
