<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <title>L'Exquise | Accueil</title>
</head>
<body class="font-['Poppins'] overflow-hidden">

    <div class="h-screen bg-[url('https://images.unsplash.com/photo-1488477181946-6428a0291777?q=80&w=1920')] bg-cover bg-center flex items-center justify-center relative">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative z-10 text-center">
            <h1 class="font-['Playfair_Display'] text-7xl md:text-9xl text-white italic mb-8">L'Exquise</h1>
            <button onclick="document.getElementById('modal').classList.remove('hidden')" class="bg-amber-600 hover:bg-amber-700 text-white px-12 py-5 rounded-full font-bold transition transform hover:scale-110 shadow-2xl">
                Se Connecter
            </button>
        </div>
    </div>

    <div id="modal" class="fixed inset-0 bg-black/60 hidden backdrop-blur-sm z-50 flex items-center justify-center">
        <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-md">
            <h2 class="font-['Playfair_Display'] text-3xl text-amber-950 mb-6 text-center">Espace Gourmet</h2>
            <form action="login.php" method="POST" class="space-y-4">
                <input type="email" name="email" placeholder="Votre Email" required class="w-full p-4 border rounded-xl outline-none focus:ring-2 focus:ring-amber-500">
                <input type="password" name="password" placeholder="Mot de passe" required class="w-full p-4 border rounded-xl outline-none focus:ring-2 focus:ring-amber-500">
                <button type="submit" class="w-full bg-stone-900 text-white py-4 rounded-xl font-bold hover:bg-amber-800 transition">Entrer</button>
            </form>
            <button onclick="document.getElementById('modal').classList.add('hidden')" class="w-full mt-4 text-gray-400 text-sm">Fermer</button>
        </div>
    </div>

</body>
</html>