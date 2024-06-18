<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT);
    $date_naissance = $_POST['date_naissance'];
    $genre = $_POST['genre'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    if (empty($nom) || empty($prenom) || empty($email) || empty($mot_de_passe)) {
        $error = "Les champs nom, prénom, email et mot de passe sont obligatoires.";
        header("Location: inscription.php?error=" . urlencode($error));
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, date_naissance, genre, adresse, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nom, $prenom, $email, $mot_de_passe, $date_naissance, $genre, $adresse, $telephone);

    if ($stmt->execute()) {
        $_SESSION['login'] = $email;
        header("Location: login.php");
    } else {
        $error = "Erreur lors de l'inscription.";
        header("Location: inscription.php?error=" . urlencode($error));
    }

    $stmt->close();
    $conn->close();
}
?>
