var checkbox_sombre = document.getElementsByClassName("checkbox")[0] //Case mode sombre
var checkbox_notification = document.getElementsByClassName("checkbox")[1] //Case notifications

// MODE SOMBRE

if ("sombre" in localStorage && localStorage.getItem("sombre") === "true")
{
    checkbox_sombre.className += " active"
}

checkbox_sombre.addEventListener("click", function() 
{
    if (localStorage.getItem("sombre") === "true")
    {
        localStorage.setItem("sombre", "false")
        checkbox_sombre.classList.remove("active")
        window.location.reload()
    }
    else
    {
        localStorage.setItem("sombre", "true")
        checkbox_sombre.classList.add("active")
        window.location.reload()
    }
})

// FIN MODE SOMBRE

//NOTIFICATIONS

if (Notification.permission === "granted")
{
    checkbox_notification.classList.add("active")
}
else
{
    checkbox_notification.addEventListener("click", function()
    {
            Notification.requestPermission().then(function(result)
            {
                switch(result)
                {
                    case "denied":
                        document.getElementsByClassName("message")[0].innerHTML = '<p>Notifications bloquées</p>'
                        document.getElementsByClassName("message")[0].className += ' active'
                        setTimeout(function()
                        {
                            document.getElementsByClassName("message")[0].classList.remove('active')
                        }, 2000)
                    break;

                    case "granted":
                        checkbox_notification.classList.add("active")
                        document.getElementsByClassName("message")[0].innerHTML = '<p>Notifications autorisées</p>'
                        document.getElementsByClassName("message")[0].className += ' active'
                        setTimeout(function()
                        {
                            document.getElementsByClassName("message")[0].classList.remove('active')
                        }, 2000)
                    break;
                }
            })
    })
}

// FIN NOTIFICATIONS