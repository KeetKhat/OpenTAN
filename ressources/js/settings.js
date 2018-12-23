var checkbox = document.getElementsByClassName("checkbox_sombre")[0]

if ("sombre" in localStorage && localStorage.getItem("sombre") === "true")
{
    checkbox.className += " active"
}

checkbox.addEventListener("click", function(e)
{
    if (localStorage.getItem("sombre") === "true")
    {
        localStorage.setItem("sombre", "false")
        checkbox.classList.remove("active")
        window.location.reload()
    }
    else
    {
        localStorage.setItem("sombre", "true")
        checkbox.classList.add("active")
        window.location.reload()
    }
})