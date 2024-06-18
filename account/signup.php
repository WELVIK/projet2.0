<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    if (empty($name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
        header("Location: index.html?error=" . urlencode($error));
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);
    
    if ($stmt->execute()) {
        $_SESSION['login'] = $email;
        header("Location: espaceprivee.php");
    } else {
        $error = "Registration failed.";
        header("Location: index.html?error=" . urlencode($error));
    }
    
    $stmt->close();
    $conn->close();
}
?>
