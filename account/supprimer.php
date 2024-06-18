<?php
require 'db_connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Afficher l'ID pour débogage
    echo "ID à supprimer: " . htmlspecialchars($id) . "<br>";

    // Préparer la requête de suppression
    $stmt = $conn->prepare("DELETE FROM utilisateurs WHERE id = ?");
    
    if ($stmt) {
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Utilisateur supprimé avec succès.<br>";
        } else {
            echo "Erreur lors de l'exécution de la requête: " . $stmt->error . "<br>";
        }

        $stmt->close();
    } else {
        echo "Erreur de préparation de la requête: " . $conn->error . "<br>";
    }

    header("Location: espaceprivee.php");
    exit();
} else {
    echo "ID non fourni.<br>";
}
?>
