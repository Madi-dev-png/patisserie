 function validerConnexion() {
            const email = document.getElementById('login-email').value.trim();
            const password = document.getElementById('login-password').value.trim();
            
            // Vérification que l'email se termine par @gmail.com
            const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
            if (!emailRegex.test(email)) {
                alert("Veuillez utiliser une adresse Gmail valide (ex: nom@gmail.com)");
                return;
            }
            
            // Vérification que le mot de passe n'est pas vide (optionnel)
            if (password === "") {
                alert("Veuillez entrer un mot de passe");
                return;
            }
            
            // Redirection vers la boutique
            window.location.href = "boutique.html";
        }