<?php
session_start();
require 'db.php';

$donnees = json_decode(file_get_contents('php://input'), true);

if (!empty($donnees['articles']) && !empty($donnees['livraison'])) {
   // REMPLACE TON BLOC TRY DANS PASSER_COMMANDE.PHP
try {
    $pdo->beginTransaction();
    
    $livraison = $donnees['livraison'];
    $articles = $donnees['articles'];

    foreach ($articles as $item) {
        $total_ligne = $item['prix'] * $item['qty'];
        
        // Requête SQL avec toutes les nouvelles colonnes
        $stmt = $pdo->prepare("INSERT INTO commandes (nom_produit, prix, quantite, total_ligne, nom_client, tel_client, lieu_livraison, precision_lieu, date_livraison) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $item['nom'],
            $item['prix'],
            $item['qty'],
            $total_ligne,
            $livraison['nom'],
            $livraison['tel'], // Ton numéro 07 89... arrivera ici
            $livraison['lieu'],
            $livraison['precision'],
            $livraison['date']
        ]);
    }
    
    $pdo->commit();
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
} else {
    echo json_encode(['status' => 'error', 'message' => 'Données incomplètes']);
}
?>