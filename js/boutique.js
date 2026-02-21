        // Initialisation du panier
        let panier = JSON.parse(localStorage.getItem('panier_hiram')) || [];

        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('openCart') === 'true') {
                toggleCart();
            }
            updateUI();
        };

        function toggleCart() {
            const sidebar = document.getElementById('cart-sidebar');
            const overlay = document.getElementById('cart-overlay');
            sidebar.classList.toggle('cart-closed');
            sidebar.classList.toggle('cart-open');
            overlay.classList.toggle('hidden');
        }

        function toggleMobileMenu() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-menu-overlay');
            sidebar.classList.toggle('-translate-x-full');
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

            let texteWhatsApp = `*NOUVELLE COMMANDE - HIRAM DÉLICES*\n\n`;
            texteWhatsApp += `*CLIENT :* ${infos.nom}\n`;
            texteWhatsApp += `*TEL :* ${infos.tel}\n`;
            texteWhatsApp += `*LIEU :* ${infos.lieu}\n`;
            if(infos.precision) texteWhatsApp += `*PRECISION :* ${infos.precision}\n`;
            texteWhatsApp += `*DATE :* ${infos.date}\n\n`;
            texteWhatsApp += `*ARTICLES :*\n`;

            let totalGlobal = 0;
            panier.forEach(item => {
                let sousTotal = item.prix * item.qty;
                texteWhatsApp += `- ${item.qty}x ${item.nom} (${sousTotal.toLocaleString()} FCFA)\n`;
                totalGlobal += sousTotal;
            });

            texteWhatsApp += `\n*TOTAL : ${totalGlobal.toLocaleString()} FCFA*`;

            const lienWA = `https://wa.me/2250717817965?text=${encodeURIComponent(texteWhatsApp)}`;
            window.open(lienWA, '_blank');

            afficherNotification("✨ Commande envoyée sur WhatsApp !", "succes");
            panier = [];
            localStorage.removeItem('panier_hiram');
            form.classList.add('hidden');
            updateUI();
            setTimeout(toggleCart, 1500);
        }

        updateUI();
