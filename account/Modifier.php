<?php
require 'db_connection.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM stagiaires WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$stagiaire = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $filiere = $_POST['filiere'];

    $stmt = $conn->prepare("UPDATE stagiaires SET nom = ?, prenom = ?, email = ?, filiere = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nom, $prenom, $email, $filiere, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: espaceprivee.php");
    exit();
}

$result = $conn->query("SELECT * FROM utilisateurs");

echo '<form method="POST">';
echo '<label for="nom">Nom:</label><input type="text" name="nom" value="' . $stagiaire['nom'] . '" required>';
echo '<label for="prenom">Prénom:</label><input type="text" name="prenom" value="' . $stagiaire['prenom'] . '" required>';
echo '<label for="email">Email:</label><input type="email" name="email" value="' . $stagiaire['email'] . '" required>';
echo '<label for="filiere">Filière:</label><select name="filiere" required>';

while ($row = $result->fetch_assoc()) {
    $selected = $row['intitule'] == $stagiaire['filiere'] ? 'selected' : '';
    echo '<option value="' . $row['intitule'] . '" ' . $selected . '>' . $row['intitule'] . '</option>';
}

echo '</select>';
echo '<button type="submit">Modifier</button>';
echo '</form>';
?>
