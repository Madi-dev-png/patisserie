    function addToCart(nom, prix, img, id) {
        // 1. On récupère le panier déjà stocké (s'il existe)
        let panier = JSON.parse(localStorage.getItem('panier_hiram')) || [];

        // 2. On vérifie si la box est déjà dedans
        const index = panier.findIndex(item => item.id === id);
        if (index !== -1) {
            panier[index].qty++;
        } else {
            // Sinon on l'ajoute
            panier.push({ id, nom, prix, img, qty: 1 });
        }

        // 3. ON ENREGISTRE dans le localStorage (c'est l'étape clé)
        localStorage.setItem('panier_hiram', JSON.stringify(panier));

        // 4. On redirige vers la boutique en disant d'ouvrir le panier
        window.location.href = "boutique.php?openCart=true";
    }
