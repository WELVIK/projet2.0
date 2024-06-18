<?php
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sssss", $nom, $prenom, $email);
    $stmt->execute();
    $stmt->close();

    header("Location: espaceprivee.php");
    exit();
}

$result = $conn->query("SELECT * FROM utilisateurs");

echo '<form method="POST" enctype="multipart/form-data">';
echo '<label for="nom">Nom:</label><input type="text" name="nom" required>';
echo '<label for="prenom">Prénom:</label><input type="text" name="prenom" required>';
echo '<label for="email">Email:</label><input type="email" name="email" required>';

while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['intitule'] . '">' . $row['intitule'] . '</option>';
}


echo '<button type="submit">Ajouter</button>';
echo '</form>';
?>
