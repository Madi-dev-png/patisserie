<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Hiram Délices - Spécial Ramadan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,900;1,900&display=swap" rel="stylesheet">
    <style>
        .font-playfair { font-family: 'Playfair Display', serif; }
        .btn-hiram {
            background: #0f3460;
            color: #f4e4bc;
            padding: 1rem 2rem;
            border-radius: 9999px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            font-size: 0.75rem;
            transition: all 0.3s;
        }
        .btn-hiram:hover { transform: scale(1.05); background: #16447a; }
    </style>
</head>
<body class="bg-white">

    <section class="relative h-[60vh] flex items-center justify-center overflow-hidden bg-[#0f3460]">
        <div class="absolute inset-0 opacity-20">
            <img src="https://i.pinimg.com/1200x/aa/b6/61/aab661cab2d4c06176b1437a57c72fc8.jpg" class="w-full h-full object-cover">
        </div>
        <div class="relative text-center px-6">
            <span class="text-[#f4e4bc] font-black uppercase text-[10px] tracking-[0.5em] mb-4 block">Hiram Délices présente</span>
            <h1 class="font-playfair text-6xl md:text-8xl text-white italic leading-none">L'Iftar <br> <span class="text-[#f4e4bc]">Gourmand</span></h1>
            <p class="text-white/70 mt-8 max-w-lg mx-auto font-bold text-sm uppercase tracking-widest">Des box généreuses pour rompre le jeûne dans la douceur et la tradition.</p>
        </div>
    </section>

    <section class="max-w-7xl mx-auto py-24 px-6">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 border-b-2 border-[#f4e4bc] pb-8">
        <h3 class="font-playfair text-5xl font-black text-[#0f3460] uppercase tracking-tighter italic">Nos Box Ramadan</h3>
        <p class="text-gray-400 font-bold uppercase text-[10px] tracking-widest">Offres Spéciales Ftour</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
        <div class="group bg-[#fdfaf2] rounded-[3rem] p-10 shadow-sm border border-[#f4e4bc]/30">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h4 class="font-playfair text-4xl font-black text-[#0f3460] mb-2 uppercase">Box Nour</h4>
                    <ul class="text-[#0f3460]/60 text-[11px] font-bold mb-6 space-y-1 uppercase tracking-tight">
                        <li>• Jus</li>
                        <li>• Dates</li>
                        <li>• Sucre</li>
                        <li>• Lait</li>
                        <li>• Thé</li>
                        <li>• Riz</li>
                    </ul>
                    <div class="text-3xl font-black text-[#0f3460] mb-6">7 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Nour', 7000, 'img/nour.jpg', 905)" class="btn-hiram w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>

        <div class="group bg-[#0f3460] rounded-[3rem] p-10 shadow-sm text-white">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h4 class="font-playfair text-4xl font-black text-white mb-2 uppercase italic">Box Baraka</h4>
                    <ul class="text-white/60 text-[11px] font-bold mb-6 space-y-1 uppercase tracking-tight">
                        <li>• Dates</li>
                        <li>• Sucre</li>
                        <li>• Biscuit</li>
                        <li>• Thé</li>
                        <li>• Bonne rouge</li>
                        <li>• Jus</li>
                        <li>• Petit pois</li>
                    </ul>
                    <div class="text-3xl font-black text-[#f4e4bc] mb-6">10 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Baraka', 10000, 'img/baraka.jpg', 906)" class="btn-hiram !bg-[#f4e4bc] !text-[#0f3460] w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-24">
        <div class="group bg-[#fdfaf2] rounded-[3rem] p-10 shadow-sm border border-[#f4e4bc]/30">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h4 class="font-playfair text-4xl font-black text-[#0f3460] mb-2 uppercase tracking-tighter">Box Sakina</h4>
                    <ul class="text-[#0f3460]/60 text-[11px] font-bold mb-6 space-y-1 uppercase tracking-tight">
                        <li>• Jus</li>
                        <li>• Dates</li>
                        <li>• Sucre</li>
                        <li>• Lait</li>
                        <li>• Thé</li>
                        <li>• Nescafé</li>
                        <li>• Fromage</li>
                        <li>• Chocolat</li>
                        <li>• Millo</li>
                    </ul>
                    <div class="text-3xl font-black text-[#0f3460] mb-6">15 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Sakina', 15000, 'img/sakina.jpg', 907)" class="btn-hiram w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>

        <div class="group bg-[#0f3460] rounded-[3rem] p-10 shadow-sm text-white">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h4 class="font-playfair text-4xl font-black text-white mb-2 uppercase italic">Box Amana</h4>
                    <ul class="text-white/60 text-[11px] font-bold mb-6 space-y-1 uppercase tracking-tight">
                        <li>• Dates</li>
                        <li>• Sucre</li>
                        <li>• Biscuit</li>
                        <li>• Nutella</li>
                        <li>• Miel</li>
                        <li>• Lait Candia</li>
                        <li>• Confiture</li>
                        <li>• Jus</li>
                        <li>• Couscous</li>
                    </ul>
                    <div class="text-3xl font-black text-[#f4e4bc] mb-6">25 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Amana', 25000, 'img/amana.jpg', 908)" class="btn-hiram !bg-[#f4e4bc] !text-[#0f3460] w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-24">
        <div class="group bg-[#fdfaf2] rounded-[3rem] p-10 shadow-sm border border-[#f4e4bc]/30">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h4 class="font-playfair text-4xl font-black text-[#0f3460] mb-2 uppercase tracking-tighter">Box Misk</h4>
                    <div class="grid grid-cols-2 gap-x-4">
                        <ul class="text-[#0f3460]/60 text-[11px] font-bold space-y-1 uppercase tracking-tight">
                            <li>• Jus</li>
                            <li>• Dates</li>
                            <li>• Sucre</li>
                            <li>• Lait Bonne Rouge</li>
                            <li>• Thé</li>
                            <li>• Cappuccino</li>
                        </ul>
                        <ul class="text-[#0f3460]/60 text-[11px] font-bold space-y-1 uppercase tracking-tight">
                            <li>• Fromage</li>
                            <li>• Nutella</li>
                            <li>• Lait Candia</li>
                            <li>• Miel</li>
                            <li>• Fruits</li>
                            <li>• Grain de Mil</li>
                            <li>• Mayonnaise</li>
                        </ul>
                    </div>
                    <div class="text-3xl font-black text-[#0f3460] mt-6 mb-6">40 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Misk', 40000, 'img/misk.jpg', 909)" class="btn-hiram w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>

        <div class="group bg-[#0f3460] rounded-[3rem] p-10 shadow-sm text-white border-4 border-[#f4e4bc]/20">
            <div class="flex flex-col lg:flex-row gap-8 items-center">
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <div class="flex items-center gap-2 mb-2">
                        <h4 class="font-playfair text-4xl font-black text-white uppercase italic">Box Boss</h4>
                        <span class="bg-[#f4e4bc] text-[#0f3460] text-[8px] font-black px-2 py-0.5 rounded-full uppercase">Premium</span>
                    </div>
                    <div class="grid grid-cols-2 gap-x-4">
                        <ul class="text-white/60 text-[11px] font-bold space-y-1 uppercase tracking-tight">
                            <li>• Dates</li>
                            <li>• Sucre</li>
                            <li>• Biscuit</li>
                            <li>• Milo</li>
                            <li>• Fruits</li>
                            <li>• Lait Candia</li>
                            <li>• Lait Bonne rouge</li>
                        </ul>
                        <ul class="text-white/60 text-[11px] font-bold space-y-1 uppercase tracking-tight">
                            <li>• Lait Sucré</li>
                            <li>• Couscous</li>
                            <li>• Grain de Mil</li>
                            <li>• Confiture</li>
                            <li>• Fromage</li>
                            <li>• Cappuccino</li>
                            <li>• Petit pois</li>
                            <li>• Thé</li>
                        </ul>
                    </div>
                    <div class="text-3xl font-black text-[#f4e4bc] mt-6 mb-6">50 000 <span class="text-sm">FCFA</span></div>
                    <button onclick="addToCart('Box Boss', 50000, 'img/boss.jpg', 910)" class="btn-hiram !bg-[#f4e4bc] !text-[#0f3460] w-full">Ajouter au Panier</button>
                </div>
            </div>
        </div>
    </div>
    

</section>
 <footer class="bg-[#0f3460] text-[#f4e4bc] py-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <h4 class="font-playfair text-4xl font-black italic mb-4 uppercase">Hiram Délices</h4>
            <div class="w-20 h-1 bg-[#f4e4bc] mx-auto mb-8"></div>
            <div class="flex justify-center space-x-12 text-[10px] font-bold uppercase tracking-[0.3em]">
                <a href="https://www.instagram.com/hiram_delices?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==    Coucou  
J’espère que tu vas bien 🫶🏽 
Peux-tu partager, aller liker et t'abonner ? 🙏🏽 
Merciii d’avance 🫶🏽" class="hover:text-white">Instagram</a>
                <a href="#" class="hover:text-white">Contact</a>
                <a href="#" class="hover:text-white">Mentions</a>
            </div>
            <p class="mt-16 text-[9px] opacity-40 uppercase tracking-widest">&copy; 2026 Hiram Délices - Tous droits réservés</p>
        </div>
    </footer>

    <script>
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
</script>
    
</body>
</html>