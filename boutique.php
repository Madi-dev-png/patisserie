<?php
session_start();
require 'db.php';
if (!isset($_SESSION['auth'])) { header("Location: index.php"); exit(); }

$stmt = $pdo->query("SELECT * FROM produits");
$produits = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Boutique - L'Exquise</title>
    <style>
        .cart-sidebar { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .cart-open { transform: translateX(0); }
        .cart-closed { transform: translateX(100%); }
    </style>
</head>
<body class="bg-stone-50 font-['Poppins'] overflow-x-hidden">

    <nav class="p-6 bg-white flex justify-between items-center shadow-sm sticky top-0 z-50">
        <div class="flex items-center space-x-12">
            <h1 class="font-['Playfair_Display'] text-2xl italic">L'Exquise</h1>
            <div class="hidden md:flex space-x-6 uppercase text-xs tracking-widest font-bold">
                <a href="#" class="hover:text-amber-600 transition">Accueil</a>
                <a href="#" class="text-amber-600 border-b-2 border-amber-600">Boutique</a>
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <button onclick="toggleCart()" class="relative p-2 bg-stone-100 rounded-full hover:bg-amber-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-stone-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-badge" class="absolute -top-1 -right-1 bg-amber-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">0</span>
            </button>
            <a href="index.php" class="text-xs uppercase font-bold text-red-500 hover:text-red-700 transition">Déconnexion</a>
        </div>
    </nav>

    <div id="cart-overlay" class="fixed inset-0 bg-black/40 z-[60] hidden backdrop-blur-sm" onclick="toggleCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-[70] shadow-2xl cart-sidebar cart-closed p-8 flex flex-col">
        <div class="flex justify-between items-center mb-8 border-b pb-4">
            <h2 class="font-['Playfair_Display'] text-3xl">Mon Panier</h2>
            <button onclick="toggleCart()" class="text-stone-400 hover:text-black text-2xl">&times;</button>
        </div>
        <div id="cart-content" class="flex-grow overflow-y-auto space-y-6"></div>

    <div id="form-livraison" class="mt-6 p-4 bg-stone-50 rounded-2xl space-y-3 hidden">
    <h3 class="font-bold text-xs uppercase tracking-widest text-stone-500 mb-2">Infos de livraison</h3>
    <input type="text" id="nom_client" placeholder="Votre nom complet" class="w-full p-3 rounded-lg border border-stone-200 text-sm focus:outline-amber-600">
    <input type="text" id="lieu_livraison" placeholder="Ville / Quartier" class="w-full p-3 rounded-lg border border-stone-200 text-sm focus:outline-amber-600">
    <textarea id="precision_lieu" placeholder="Précisions (ex: Immeuble, porte...)" class="w-full p-3 rounded-lg border border-stone-200 text-sm focus:outline-amber-600"></textarea>
    <input type="text" id="tel_client" placeholder="Numéro de téléphone" class="w-full p-3 rounded-lg border border-stone-200 text-sm focus:outline-amber-600">
    <input type="datetime-local" id="date_livraison" class="w-full p-3 rounded-lg border border-stone-200 text-sm focus:outline-amber-600">
</div>
        <div class="border-t pt-6 mt-6">
            <div class="flex justify-between items-center mb-6">
                <span class="text-stone-500 uppercase tracking-widest text-sm font-semibold">Total</span>
                <span id="cart-total" class="font-['Playfair_Display'] text-3xl text-amber-900 font-bold">0.00 €</span>
            </div>
            <button onclick="validerCommande()" class="w-full bg-stone-900 text-white py-4 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-amber-800 transition shadow-lg">
                Commander
            </button>
        </div>
    </div>

    <div class="relative h-[450px] overflow-hidden">
        <div id="slider" class="flex transition-transform duration-700 h-full">
            <img src="https://images.unsplash.com/photo-1551024601-bec78aea704b?w=1600" class="min-w-full h-full object-cover">
            <img src="https://images.unsplash.com/photo-1606313564200-e75d5e30476c?w=1600" class="min-w-full h-full object-cover">
        </div>
        <div class="absolute inset-0 flex items-center justify-between px-4">
            <button onclick="slide(-1)" class="bg-white/20 p-3 rounded-full text-white hover:bg-white/40">❮</button>
            <button onclick="slide(1)" class="bg-white/20 p-3 rounded-full text-white hover:bg-white/40">❯</button>
        </div>
    </div>

    <section class="max-w-7xl mx-auto py-20 px-6">
        <h2 class="font-['Playfair_Display'] text-5xl text-center mb-16 italic text-stone-800">Nos Créations</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <?php foreach($produits as $p): 
                $nom_securise = addslashes($p['nom']); 
            ?>
            <div class="bg-white rounded-3xl overflow-hidden shadow-lg border border-stone-50 transition-all hover:shadow-2xl group">
                <div class="h-64 overflow-hidden relative">
                    <img src="<?= $p['image_url'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-1 rounded-full font-bold text-amber-900 shadow-sm">
                        <?= $p['prix'] ?> €
                    </div>
                </div>
                <div class="p-8 text-center">
                    <h3 class="text-2xl font-['Playfair_Display'] mb-4"><?= $p['nom'] ?></h3>
                    <button onclick="addToCart('<?= $nom_securise ?>', <?= $p['prix'] ?>, '<?= $p['image_url'] ?>', <?= $p['id'] ?>)" 
                            class="w-full bg-stone-900 text-white py-4 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-amber-800 transition active:scale-95 shadow-md">
                        Ajouter au panier
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <footer class="bg-stone-900 text-stone-400 py-12 px-6">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center border-b border-stone-800 pb-8">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h3 class="font-['Playfair_Display'] text-white text-2xl italic mb-2">L'Exquise</h3>
                <p class="text-xs uppercase tracking-widest">Haute Pâtisserie Française</p>
            </div>
            <div class="flex space-x-8 text-xs font-bold uppercase tracking-widest">
                <a href="#" class="hover:text-amber-500 transition">À propos</a>
                <a href="#" class="hover:text-amber-500 transition">Contact</a>
                <a href="#" class="hover:text-amber-500 transition">Instagram</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-8 text-[10px] text-center uppercase tracking-widest opacity-50">
            &copy; 2024 L'Exquise - Tous droits réservés.
        </div>
    </footer>

    <script>
        let panier = [];

        function slide(dir) {
            let cur = 0;
            cur = (cur + dir + 2) % 2;
            document.getElementById('slider').style.transform = `translateX(-${cur * 100}%)`;
        }

        function toggleCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');
            sidebar.classList.toggle('cart-closed');
            sidebar.classList.toggle('cart-open');
            overlay.classList.toggle('hidden');
        }

        function addToCart(nom, prix, img, id) {
            const index = panier.findIndex(item => item.id === id);
            if (index !== -1) {
                panier[index].qty++;
            } else {
                panier.push({ id, nom, prix, img, qty: 1 });
            }
            updateUI();
        }

        function updateQty(id, delta) {
            const index = panier.findIndex(item => item.id === id);
            if (index !== -1) {
                panier[index].qty += delta;
                if (panier[index].qty <= 0) panier.splice(index, 1);
            }
            updateUI();
        }

        function removeItem(id) {
            panier = panier.filter(item => item.id !== id);
            updateUI();
        }

        function updateUI() {
            const content = document.getElementById('cart-content');
            const badge = document.getElementById('cart-badge');
            const totalDisplay = document.getElementById('cart-total');
            let total = 0, count = 0;

            if (panier.length === 0) {
                content.innerHTML = '<p class="text-center text-stone-400 italic mt-10">Votre panier est encore vide...</p>';
            } else {
                content.innerHTML = panier.map(item => {
                    total += item.prix * item.qty;
                    count += item.qty;
                    return `
                        <div class="flex items-center space-x-4 bg-stone-50 p-3 rounded-2xl relative">
                            <img src="${item.img}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                            <div class="flex-grow">
                                <h4 class="font-bold text-stone-800 text-sm uppercase">${item.nom}</h4>
                                <p class="text-amber-700 font-semibold text-xs">${item.prix} €</p>
                                <div class="flex items-center space-x-3 mt-2">
                                    <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-full border border-stone-200 flex items-center justify-center hover:bg-white font-bold">-</button>
                                    <span class="text-sm font-bold">${item.qty}</span>
                                    <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-full border border-stone-200 flex items-center justify-center hover:bg-white font-bold">+</button>
                                </div>
                            </div>
                            <button onclick="removeItem(${item.id})" class="text-stone-300 hover:text-red-500 transition px-2 text-xl">&times;</button>
                        </div>`;
                }).join('');
            }
            badge.innerText = count;
            totalDisplay.innerText = total.toFixed(2) + " €";
        }

        function validerCommande() {
    const form = document.getElementById('form-livraison');
    
    if (panier.length === 0) {
        afficherNotification("Votre panier est vide !", "erreur");
        return;
    }

    // Afficher le formulaire au premier clic
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        afficherNotification("Veuillez remplir vos infos de livraison", "succes");
        return;
    }

    // Récupérer les infos
    // Dans la partie "Récupérer les infos", modifie comme ceci :
const infos = {
    nom: document.getElementById('nom_client').value,
    tel: document.getElementById('tel_client').value, // <-- Ajout ici
    lieu: document.getElementById('lieu_livraison').value,
    precision: document.getElementById('precision_lieu').value,
    date: document.getElementById('date_livraison').value
};

// Modifie aussi la vérification pour bloquer si le tel est vide :
if (!infos.nom || !infos.tel || !infos.lieu || !infos.date) {
    afficherNotification("Merci de remplir tous les champs !", "erreur");
    return;
}

    // On envoie le panier + les infos de livraison
    fetch('passer_commande.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ articles: panier, livraison: infos })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            afficherNotification("✨ Commande reçue ! On prépare vos délices.", "succes");
            panier = [];
            form.classList.add('hidden'); // On recache le formulaire
            updateUI();
            setTimeout(toggleCart, 1500);
        } else {
            afficherNotification("❌ Erreur : " + data.message, "erreur");
        }
    });
}

        function afficherNotification(message, type) {
            const node = document.createElement('div');
            node.className = `fixed bottom-10 left-1/2 -translate-x-1/2 px-8 py-4 rounded-full shadow-2xl z-[100] transition-all duration-500 transform translate-y-20 opacity-0 font-bold text-sm tracking-widest uppercase`;
            if (type === "succes") {
                node.classList.add('bg-stone-900', 'text-amber-400', 'border', 'border-amber-400');
            } else {
                node.classList.add('bg-red-500', 'text-white');
            }
            node.innerText = message;
            document.body.appendChild(node);
            setTimeout(() => node.classList.remove('translate-y-20', 'opacity-0'), 100);
            setTimeout(() => {
                node.classList.add('translate-y-20', 'opacity-0');
                setTimeout(() => node.remove(), 500);
            }, 4000);
        }
        
        updateUI();
    </script>
</body>
</html>