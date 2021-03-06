        <footer>
            <script src="/ressources/js/hamburger.js"></script>
            <noscript><div class="message active"><p>Veuillez activer JavaScript</p></div></noscript>
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
                            document.getElementsByClassName("message")[0].innerHTML = '<p>Téléchargement des fichiers</p>'
                            document.getElementsByClassName("message")[0].className += ' active'
                            register.installing.addEventListener('statechange', function(e)
                            {
                                if (NouveauSW.state === 'installed')
                                {
                                        if (navigator.serviceWorker.controller)
                                        {
                                            document.getElementsByClassName("message")[0].innerHTML = '<p>Appuyez pour installer la mise à jour</p>'
                                        }
                                        else
                                        {
                                            document.getElementsByClassName("message")[0].innerHTML = '<p>Prêt à être utilisée hors-connexion</p>'
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