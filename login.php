<?php
session_start();
require 'db.php'; // On se connecte à patisserie_db

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 1. On vérifie si cet email est déjà dans la table 'utilisateurs'
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        // 2. S'il n'existe pas, on l'ajoute direct ! 
        // C'est ici que l'enregistrement automatique se fait dans phpMyAdmin
        $insert = $pdo->prepare("INSERT INTO utilisateurs (email, password) VALUES (?, ?)");
        $insert->execute([$email, $password]);
        
        // On récupère ses nouvelles infos (notamment son ID auto-généré)
        $stmt->execute([$email]);
        $user = $stmt->fetch();
    }

    // 3. On crée la session pour qu'il puisse naviguer sur la boutique
    $_SESSION['auth'] = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];

    // 4. Direction la boutique !
    header("Location: boutique.php");
    exit();
}
?>