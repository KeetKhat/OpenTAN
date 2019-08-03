var menu_opacite = document.getElementsByClassName("opacite")[0]
var menu = document.getElementsByTagName("nav")[0]

document.getElementById("hamburger").addEventListener("click", function()
{
    if (menu_opacite.classList.contains("opacite"))
    {
        menu_opacite.className += " active"
        menu.classList.add("active")
    }
})

menu_opacite.addEventListener("click", function()
{
    menu_opacite.classList.remove("active")
    menu.classList.remove("active")
})

if (navigator.onLine)
{
    document.getElementsByClassName("info_trafic_etat")[0].className += " connexion"
}