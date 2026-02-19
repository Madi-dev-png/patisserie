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
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <title>Boutique - Hiram Délices</title>
    <style>
        :root {
            --hiram-blue: #0f3460; /* Le bleu de ton logo */
            --hiram-gold: #f4e4bc; /* Le beige/doré de ton logo */
            --hiram-white: #ffffff;
        }
        .font-playfair { font-family: 'Playfair Display', serif; }
        .cart-sidebar { transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1); }
        .cart-open { transform: translateX(0); }
        .cart-closed { transform: translateX(100%); }
        
        /* Bouton Signature */
        .btn-hiram {
            background-color: var(--hiram-blue);
            color: var(--hiram-gold);
            padding: 12px 28px;
            border-radius: 50px;
            text-transform: uppercase;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        .btn-hiram:hover {
            background-color: white;
            color: var(--hiram-blue);
            border-color: var(--hiram-blue);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-[#fafafa] font-['Poppins'] overflow-x-hidden">

    <div class="bg-[#0f3460] text-[#f4e4bc] text-[10px] py-2 text-center font-bold uppercase tracking-[0.2em]">
    PROFITEZ DE -50% SUR VOTRE PREMIÈRE COMMANDE
</div>

<nav class="px-10 py-4 bg-white sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto flex items-center justify-between">
        
        <div class="hidden lg:flex items-center space-x-8 text-[10px] font-extrabold uppercase tracking-widest text-gray-800 flex-1">
            <a href="#" class="hover:text-[#0f3460] transition">À Propos</a>
            <div class="flex items-center group cursor-pointer">
                <span class="hover:text-[#0f3460] transition">Blog & Actus</span>
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"></path></svg>
            </div>
            <a href="#" class="text-[#0f3460] border-b border-[#f4e4bc]">Notre Menu</a>
        </div>

        <div class="flex-shrink-0 text-center px-10">
            <h1 class="font-playfair text-xl font-black text-[#0f3460] leading-none uppercase">
                Hiram <br>
                <span class="text-[9px] tracking-[0.4em] font-bold text-gray-400">Délices</span>
            </h1>
        </div>

        <div class="flex items-center justify-end space-x-8 flex-1">
            <div class="hidden lg:flex items-center space-x-8 text-[10px] font-extrabold uppercase tracking-widest text-gray-800">
                <a href="#" class="hover:text-[#0f3460] transition">Membres</a>
                <a href="#" class="hover:text-[#0f3460] transition">Services</a>
                <a href="ramadan.php" class="text-[#0f3460] font-bold uppercase text-[10px] tracking-widest hover:text-[#f4e4bc] transition">
   🌙 Spécial Ramadan
</a>
                <div class="flex items-center group cursor-pointer">
                    <span class="hover:text-[#0f3460] transition">Pages</span>
                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"></path></svg>
                </div>
            </div>

            <button onclick="toggleCart()" class="relative p-2 group ml-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-800 group-hover:text-[#0f3460] transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
                <span id="cart-badge" class="absolute top-0 right-0 bg-[#0f3460] text-[#f4e4bc] text-[8px] font-black px-1.5 py-0.5 rounded-full shadow-sm">0</span>
            </button>

            <button class="lg:hidden text-gray-800 ml-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
            </button>
        </div>
    </div>
</nav>

    <div id="cart-overlay" class="fixed inset-0 bg-[#0f3460]/20 z-[60] hidden backdrop-blur-sm" onclick="toggleCart()"></div>
    <div id="cart-sidebar" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-[70] shadow-2xl cart-sidebar cart-closed p-8 flex flex-col border-l-4 border-[#f4e4bc]">
        <div class="flex justify-between items-center mb-8 border-b border-gray-100 pb-4">
            <h2 class="font-playfair text-3xl font-black text-[#0f3460]">Ma Sélection</h2>
            <button onclick="toggleCart()" class="text-gray-300 hover:text-black text-3xl">&times;</button>
        </div>
        
        <div id="cart-content" class="flex-grow overflow-y-auto space-y-4"></div>

        <div id="form-livraison" class="mt-6 p-4 bg-[#fcf9f2] rounded-2xl space-y-3 hidden border border-[#f4e4bc]">
            <h3 class="font-bold text-[10px] uppercase tracking-widest text-[#0f3460] mb-2">Détails de livraison</h3>
            <input type="text" id="nom_client" placeholder="Nom complet" class="w-full p-3 rounded-xl border-gray-200 text-sm focus:ring-[#0f3460]">
            <input type="text" id="lieu_livraison" placeholder="Ville / Quartier" class="w-full p-3 rounded-xl border-gray-200 text-sm focus:ring-[#0f3460]">
            <textarea id="precision_lieu" placeholder="Précisions" class="w-full p-3 rounded-xl border-gray-200 text-sm focus:ring-[#0f3460]"></textarea>
            <input type="text" id="tel_client" placeholder="Téléphone" class="w-full p-3 rounded-xl border-gray-200 text-sm focus:ring-[#0f3460]">
            <input type="datetime-local" id="date_livraison" class="w-full p-3 rounded-xl border-gray-200 text-sm focus:ring-[#0f3460]">
        </div>

        <div class="pt-6 border-t border-gray-100 mt-6">
            <div class="flex justify-between items-center mb-6">
                <span class="uppercase text-[10px] font-black text-gray-400 tracking-[0.2em]">Total</span>
                <span id="cart-total" class="font-playfair text-3xl font-black text-[#0f3460]">0.00 €</span>
            </div>
            <button onclick="validerCommande()" class="btn-hiram w-full py-4 shadow-xl">Finaliser la commande</button>
        </div>
    </div>

   <header class="relative min-h-[85vh] flex items-center overflow-hidden">
    
    <div class="absolute inset-0 z-0">
        <img src="https://i.pinimg.com/736x/4c/bc/7b/4cbc7bc3bcd7b8c481e4f035c1936d64.jpg" 
             class="w-full h-full object-cover" 
             alt="Gâteau Hiram Délices">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0f3460]/90 via-[#0f3460]/60 to-transparent"></div>
    </div>

    <div class="max-w-7xl mx-auto px-10 w-full relative z-10">
        <div class="lg:w-2/3 text-white">
            
            <div class="flex items-center space-x-3 mb-6">
                <span class="h-[2px] w-12 bg-[#f4e4bc]"></span>
                <span class="uppercase text-[11px] font-black tracking-[0.4em] text-[#f4e4bc]">L'excellence artisanale</span>
            </div>

            <h2 class="font-playfair text-[5rem] lg:text-[8rem] leading-[0.85] font-black uppercase tracking-tighter text-white">
                L'Art de <br>
                <span class="text-[#f4e4bc] text-4xl lg:text-5xl font-normal lowercase tracking-normal italic block my-4">votre</span>
                Bonheur <br>
                <span class="text-white">Gourmand</span>
            </h2>

            <div class="mt-12 flex flex-col sm:flex-row sm:items-center space-y-6 sm:space-y-0 sm:space-x-10">
                <div class="flex items-center space-x-3">
                    <span class="text-[#f4e4bc] font-bold text-xs uppercase tracking-widest italic">Hiram Délices</span>
                    <span class="h-[1px] w-12 bg-[#f4e4bc]/30"></span>
                </div>
                
                <button onclick="document.getElementById('nos-creations').scrollIntoView({behavior: 'smooth'})" 
                        class="bg-[#f4e4bc] text-[#0f3460] px-12 py-5 rounded-full text-[12px] font-black uppercase tracking-[0.2em] hover:bg-white transition-all duration-500 shadow-2xl transform hover:-translate-y-1">
                    Découvrir la Boutique
                </button>
            </div>

            <div class="mt-20 grid grid-cols-2 md:grid-cols-3 gap-8 border-t border-white/10 pt-10">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full border border-[#f4e4bc]/50 flex items-center justify-center text-[#f4e4bc]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"></path></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/80 leading-tight">100% Naturel <br><span class="text-[#f4e4bc]">Sans conservateurs</span></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full border border-[#f4e4bc]/50 flex items-center justify-center text-[#f4e4bc]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"></path></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/80 leading-tight">Fait Maison <br><span class="text-[#f4e4bc]">Avec Passion</span></p>
                </div>
                <div class="flex items-center space-x-4 hidden md:flex">
                    <div class="w-10 h-10 rounded-full border border-[#f4e4bc]/50 flex items-center justify-center text-[#f4e4bc]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"></path></svg>
                    </div>
                    <p class="text-[10px] font-bold uppercase tracking-widest text-white/80 leading-tight">Livraison <br><span class="text-[#f4e4bc]">Ultra Rapide</span></p>
                </div>
            </div>

        </div>
    </div>
</header>
   <section id="nos-creations" class="max-w-7xl mx-auto py-24 px-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 border-b-2 border-[#f4e4bc] pb-8">
        <h3 class="font-playfair text-5xl font-black text-[#0f3460] uppercase tracking-tighter italic">La Carte Hiram</h3>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest mt-4 md:mt-0">Commandez au : 0717817965</p>
    </div>

    <?php 
    // Configuration du menu selon ton image
    $categories = [
        "Saveurs Salées" => [
            ['id' => 101, 'nom' => '10 Ailerons', 'prix' => 4500, 'img' => 'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?auto=format&fit=crop&w=500'],
            ['id' => 102, 'nom' => '10 Quiches', 'prix' => 6000, 'img' => 'https://i.pinimg.com/736x/5c/18/73/5c1873b72fdc8d9739fdbeaa1dc88113.jpg'],
            ['id' => 103, 'nom' => '10 Burgers', 'prix' => 6000, 'img' => 'https://i.pinimg.com/1200x/91/9b/20/919b202e5d32027ce01983ca367b2fc3.jpg'],
            ['id' => 104, 'nom' => '10 Nems', 'prix' => 3000, 'img' => 'https://i.pinimg.com/1200x/00/69/e6/0069e653e889112b095f93caed9a2738.jpg'],
            ['id' => 105, 'nom' => '10 Samoussas', 'prix' => 4500, 'img' => 'https://images.unsplash.com/photo-1601050690597-df0568f70950?auto=format&fit=crop&w=500']
        ],
        "Collection Crêpes Signature" => [
            ['id' => 201, 'nom' => '8 Crêpes Nature', 'prix' => 3000, 'img' => 'https://i.pinimg.com/736x/ba/ec/5d/baec5d221b0d12d324d0f7c43ffc4dd5.jpg'],
            ['id' => 202, 'nom' => '8 Crêpes Chocolat', 'prix' => 4000, 'img' => 'https://i.pinimg.com/1200x/cf/ff/b7/cfffb77d0cb85c53b318ee6f5d53f5a9.jpg'],
            ['id' => 203, 'nom' => '8 Crêpes Miel', 'prix' => 4000, 'img' => 'https://i.pinimg.com/736x/14/1e/5c/141e5c46a27c3a597336179eb0f7ec6b.jpg'],
            ['id' => 204, 'nom' => '8 Crêpes Fourrées', 'prix' => 6500, 'img' => 'https://i.pinimg.com/1200x/fb/04/e6/fb04e6191c9971b42a7062e08c818adb.jpg']
        ],
        "Délices en Miniature" => [
            ['id' => 301, 'nom' => '10 Beignets', 'prix' => 4000, 'img' => 'https://i.pinimg.com/736x/bf/51/ef/bf51ef1c410437db7f317f0cda04533f.jpg'],
            ['id' => 302, 'nom' => '10 Mini Pizza', 'prix' => 4000, 'img' => 'https://i.pinimg.com/736x/34/f6/6b/34f66b66b25160a42874fd643bf36f67.jpg'],
            ['id' => 303, 'nom' => '10 Pastels', 'prix' => 3000, 'img' => 'https://i.pinimg.com/736x/1f/cf/80/1fcf803447978920c19584f80b73890b.jpg'],
            ['id' => 304, 'nom' => '10 Mini Sandwich', 'prix' => 4500, 'img' => 'https://i.pinimg.com/1200x/ed/f7/2b/edf72bf3fa9dc7667067f19cfd09897c.jpg'],
            ['id' => 305, 'nom' => '10 Mini Tacos Viande', 'prix' => 4500, 'img' => 'https://i.pinimg.com/736x/5a/fd/83/5afd8349808ece4505e86a2ef91dc06b.jpg'],
            ['id' => 306, 'nom' => '10 Mini Tacos Poulet', 'prix' => 4500, 'img' => 'https://i.pinimg.com/736x/60/80/78/608078a7afbb856ebbedf1cc6e73b02e.jpg'],
            ['id' => 307, 'nom' => 'Naveyye viande', 'prix' => 4500, 'img' => 'https://i.pinimg.com/1200x/8a/92/33/8a923316cc8327e5414ede71c446bc12.jpg']
        ],
        "Boissons Faits Maison" => [
            ['id' => 401, 'nom' => 'Bissap', 'prix' => 1500, 'img' => 'https://i.pinimg.com/736x/e1/be/f7/e1bef7c4a8e6b95a9e62b3dadf5206bb.jpg'],
            ['id' => 402, 'nom' => 'Gnamankoudji', 'prix' => 2000, 'img' => 'https://i.pinimg.com/1200x/19/30/d5/1930d534161cac21d6c468b3df488c78.jpg'],
            ['id' => 403, 'nom' => 'Degue', 'prix' => 3500, 'img' => 'https://i.pinimg.com/736x/4b/4a/0e/4b4a0e9dca04a84d941ddc0e5e3ccab5.jpg'],
            ['id' => 404, 'nom' => 'Tomi', 'prix' => 2000, 'img' => 'https://i.pinimg.com/1200x/d6/fc/e4/d6fce40df4fb782a3e7ed2d5b5d32ff4.jpg']
        ]
    ];

    foreach($categories as $catNom => $items): ?>
        <div class="mb-20">
            <h4 class="text-2xl font-black text-[#0f3460] mb-8 flex items-center uppercase tracking-widest">
                <span class="bg-[#f4e4bc] w-10 h-10 rounded-full flex items-center justify-center mr-4 text-sm shadow-sm">#</span>
                <?= $catNom ?>
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach($items as $p): 
                    $nom_securise = addslashes($p['nom']); 
                ?>
                <div class="group">
                    <div class="relative overflow-hidden rounded-[2.5rem] bg-gray-50 aspect-square mb-6 shadow-sm group-hover:shadow-xl transition-all duration-500 border border-gray-100">
                        <img src="<?= $p['img'] ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-6 left-6 bg-[#0f3460] px-4 py-1.5 rounded-full text-[10px] font-black text-[#f4e4bc] border border-[#f4e4bc]">
                            <?= number_format($p['prix'], 0, ',', ' ') ?> FCFA
                        </div>
                    </div>
                    <div class="flex flex-col px-2">
                        <h5 class="font-playfair text-lg font-bold text-[#0f3460] mb-3 leading-tight"><?= $p['nom'] ?></h5>
                        <button onclick="addToCart('<?= $nom_securise ?>', <?= $p['prix'] ?>, '<?= $p['img'] ?>', <?= $p['id'] ?>)" 
                                class="btn-hiram !py-3 !text-[10px] w-full uppercase tracking-widest font-black">
                            Ajouter au panier
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

    <footer class="bg-[#0f3460] text-[#f4e4bc] py-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h4 class="font-playfair text-4xl font-black italic mb-4 uppercase">Hiram Délices</h4>
            <div class="w-20 h-1 bg-[#f4e4bc] mx-auto mb-8"></div>
            <div class="flex justify-center space-x-12 text-[10px] font-bold uppercase tracking-[0.3em]">
                <a href="#" class="hover:text-white">Instagram</a>
                <a href="#" class="hover:text-white">Contact</a>
                <a href="#" class="hover:text-white">Mentions</a>
            </div>
            <p class="mt-16 text-[9px] opacity-40 uppercase tracking-widest">&copy; 2026 Hiram Délices - Tous droits réservés</p>
        </div>
    </footer>

  <script>
    // --- AJOUT : RÉCUPÉRATION INITIALE DEPUIS LE STOCKAGE ---
    // On vérifie si un panier existe déjà dans le navigateur (sauvegardé par ramadan.php)
    let panier = JSON.parse(localStorage.getItem('panier_hiram')) || [];

    // --- AJOUT : OUVERTURE AUTO SI REDIRECTION ---
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('openCart') === 'true') {
            toggleCart(); // Ouvre ton sidebar actuel
        }
        updateUI(); // Rafraîchit ton interface avec les box récupérées
    };

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
        // Optionnel : afficher notification lors de l'ajout
        afficherNotification("Ajouté : " + nom, "succes");
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
        // --- AJOUT : SAUVEGARDE SYSTÉMATIQUE ---
        // On enregistre à chaque changement pour que ramadan.php et boutique.php soient toujours synchronisés
        localStorage.setItem('panier_hiram', JSON.stringify(panier));

        const content = document.getElementById('cart-content');
        const badge = document.getElementById('cart-badge');
        const totalDisplay = document.getElementById('cart-total');
        let total = 0, count = 0;

        if (panier.length === 0) {
            content.innerHTML = '<p class="text-center text-gray-400 italic mt-10">Votre panier est vide...</p>';
        } else {
            content.innerHTML = panier.map(item => {
                total += item.prix * item.qty;
                count += item.qty;
                return `
                    <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-3xl border border-gray-100 mb-3">
                        <img src="${item.img}" class="w-16 h-16 object-cover rounded-xl shadow-sm">
                        <div class="flex-grow">
                            <h4 class="font-bold text-[#0f3460] text-xs uppercase">${item.nom}</h4>
                            <p class="text-[#0f3460]/70 font-bold text-[10px]">${item.prix.toLocaleString()} FCFA</p>
                            <div class="flex items-center space-x-3 mt-2">
                                <button onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-full bg-white flex items-center justify-center font-bold text-xs shadow-sm border border-gray-100">-</button>
                                <span class="text-xs font-bold">${item.qty}</span>
                                <button onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-full bg-white flex items-center justify-center font-bold text-xs shadow-sm border border-gray-100">+</button>
                            </div>
                        </div>
                        <button onclick="removeItem(${item.id})" class="text-gray-300 hover:text-red-500 text-xl transition">&times;</button>
                    </div>`;
            }).join('');
        }
        badge.innerText = count;
        totalDisplay.innerText = total.toLocaleString() + " FCFA";
    }

    function afficherNotification(message, type) {
        const node = document.createElement('div');
        node.className = `fixed bottom-10 left-1/2 -translate-x-1/2 px-8 py-4 rounded-full shadow-2xl z-[100] transition-all duration-500 transform translate-y-20 opacity-0 font-bold text-sm tracking-widest uppercase`;
        if (type === "succes") {
            node.classList.add('bg-[#0f3460]', 'text-[#f4e4bc]', 'border', 'border-[#f4e4bc]');
        } else {
            node.classList.add('bg-red-600', 'text-white');
        }
        node.innerText = message;
        document.body.appendChild(node);
        setTimeout(() => node.classList.remove('translate-y-20', 'opacity-0'), 100);
        setTimeout(() => {
            node.classList.add('translate-y-20', 'opacity-0');
            setTimeout(() => node.remove(), 500);
        }, 4000);
    }

    function validerCommande() {
        const form = document.getElementById('form-livraison');
        if (panier.length === 0) {
            afficherNotification("Votre panier est vide !", "erreur");
            return;
        }
        if (form.classList.contains('hidden')) {
            form.classList.remove('hidden');
            afficherNotification("Veuillez remplir vos infos de livraison", "succes");
            return;
        }
        const infos = {
            nom: document.getElementById('nom_client').value,
            tel: document.getElementById('tel_client').value,
            lieu: document.getElementById('lieu_livraison').value,
            precision: document.getElementById('precision_lieu').value,
            date: document.getElementById('date_livraison').value
        };
        if (!infos.nom || !infos.tel || !infos.lieu || !infos.date) {
            afficherNotification("Merci de remplir tous les champs !", "erreur");
            return;
        }
        fetch('passer_commande.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ articles: panier, livraison: infos })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                afficherNotification("✨ Commande reçue ! À bientôt.", "succes");
                panier = [];
                // --- AJOUT : VIDER LE STOCKAGE AUSSI ---
                localStorage.removeItem('panier_hiram');
                form.classList.add('hidden');
                updateUI();
                setTimeout(toggleCart, 1500);
            } else {
                afficherNotification("❌ Erreur : " + data.message, "erreur");
            }
        });
    }

    updateUI();
</script>
</body>
</html>