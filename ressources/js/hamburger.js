var menu_opacite = document.getElementsByClassName("opacite")[0]
var menu = document.getElementsByTagName("nav")[0]

document.getElementById("hamburger").addEventListener("click", function(e)
{
    if (menu_opacite.classList.contains("opacite"))
    {
        menu_opacite.className += " active"
        menu.classList.add("active")
    }
})

menu_opacite.addEventListener("click", function(e)
{
    menu_opacite.classList.remove("active")
    menu.classList.remove("active")
})