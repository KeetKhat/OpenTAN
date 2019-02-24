        <footer>
            <script src="/ressources/js/hamburger.js"></script>
            <noscript><div class="message active"><p>Veuillez activer JavaScript afin d'utiliser OpenTAN</p></div></noscript>
            <div class="message"></div>
            <script>
                let NouveauSW;

                document.getElementsByClassName("message")[0].addEventListener('click', function()
                {
                    NouveauSW.postMessage({ action: 'wait_update' })
                })

                if ('serviceWorker' in navigator)
                {
                    navigator.serviceWorker.register('/service_worker.js').then(function(register)
                    {
                        register.addEventListener('updatefound', function() 
                        {
                            NouveauSW = register.installing;
                            register.installing.addEventListener('statechange', function(e)
                            {
                                if (NouveauSW.state === 'installed')
                                {
                                        if (navigator.serviceWorker.controller)
                                        {
                                            document.getElementsByClassName("message")[0].innerHTML = '<p>Une nouvelle version est disponible, appuyez sur ce message pour l\'installer</p>'
                                            document.getElementsByClassName("message")[0].className += ' active'
                                        }
                                        else
                                        {
                                            document.getElementsByClassName("message")[0].innerHTML = '<p>L\'application est prête à être utilisée hors-connexion</p>'
                                            document.getElementsByClassName("message")[0].className += ' active'
                                            setTimeout(function()
                                            {
                                                document.getElementsByClassName("message")[0].classList.remove('active')
                                            }, 3000)
                                        }
                                }

                            })
                                    
                        })

                        console.log('Enregistrement du Service Worker effectué dans le chemin ' + register.scope)
                    }).catch(function(error)
                    {
                        console.log('Échec de l\'enregistrement du Service Worker. Erreur : ' + error)
                    })

                    let rafraichissement
                    navigator.serviceWorker.addEventListener('controllerchange', function()
                    {
                        if (rafraichissement)
                        {
                            return
                        }
                        else
                        {
                            window.location.reload()
                            rafraichissement = true
                        }

                    })

                }
            </script>
        </footer>
    </body>
</html>