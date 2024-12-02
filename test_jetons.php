<?php
require '/../src/Modele/modele_jeton.php';

// Connexion à la base de données (à adapter selon votre configuration)
$db = new PDO('mysql:host=localhost;dbname=votre_base_de_donnees', 'votre_utilisateur', 'votre_mot_de_passe');

// Création de l'objet modèle
$modeleJeton = new Modele_Jeton($db);

// Test d'insertion d'un jeton
$userId = 1; // ID de l'utilisateur
$token = bin2hex(random_bytes(16)); // Génération d'un jeton aléatoire
$expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // Expiration dans 1 heure
$insertResult = $modeleJeton->insertToken($userId, $token, $expiry);
echo $insertResult ? "Insertion réussie\n" : "Échec de l'insertion\n";

// Test de recherche d'un jeton
$searchResult = $modeleJeton->searchToken($token);
echo $searchResult ? "Jeton trouvé : " . print_r($searchResult, true) . "\n" : "Jeton non trouvé\n";

// Test de mise à jour d'un jeton pour le déclarer utilisé
$updateResult = $modeleJeton->updateTokenAsUsed($token);
echo $updateResult ? "Mise à jour réussie\n" : "Échec de la mise à jour\n";

// Vérification que le jeton est maintenant marqué comme utilisé
$searchResultAfterUpdate = $modeleJeton->searchToken($token);
echo $searchResultAfterUpdate ? "Jeton trouvé après mise à jour : " . print_r($searchResultAfterUpdate, true) . "\n" : "Jeton non trouvé après mise à jour\n";
?>