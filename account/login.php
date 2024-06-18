<?php
session_start();
require 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        $error = "Les données d’authentification sont obligatoires.";
        header("Location: login.php?error=" . urlencode($error));
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM administrateurs WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['login'] = $login;
        header("Location: espaceprivee.php");
    } else {
        $error = "Les données d’authentification sont incorrects.";
        header("Location: login.php?error=" . urlencode($error));
    }
    $stmt->close();
    $conn->close();
}
?>
<! DOCTYPE HTML>
<HTML>
<head>
    <meta charset="utf-8">
    <title>Se connecter</title>
    <link rel="stylesheet" type="text/css" href="../css/stylelogin.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-dyWA3wzflXzF+FFtGRH8GuNn7bVu3cbsV6zTckr38qJTXtEyhK2T9n7B+FxiYCBF" crossorigin="anonymous">
</head>
<body>
<div class="loading">
        <div class="three-body">
          <div class="three-body__dot"></div>
          <div class="three-body__dot"></div>
          <div class="three-body__dot"></div>
        </div>
</div>
<div class="container" id="container">
    <div class="form-container sign-up-container">
        <form action="inscription.php" method="POST">
            <h1>Create Account</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your email for registration</span>
            <input type="text" name="nom" placeholder="Nom" required />
            <input type="text" name="prenom" placeholder="Prénom" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required />
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <div class="form-container sign-in-container">
        <form action="login.php" method="POST">
            <h1>Sign in</h1>
            <div class="social-container">
                <a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
                <a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <span>or use your account</span>
            <input type="text" name="login" placeholder="Login" required />
            <input type="password" name="password" placeholder="Password" required />
            <a href="#">Forgot your password?</a>
            <button type="submit">Sign In</button>
        </form>
    </div>
    <div class="overlay-container">
        <div class="overlay">
            <div class="overlay-panel overlay-left">
                <h1>Welcome Back!</h1>
                <p>To keep connected with us please login with your personal info</p>
                <button class="ghost" id="signIn">Sign In</button>
            </div>
            <div class="overlay-panel overlay-right">
                <h1>Hello, Friend!</h1>
                <p>Enter your personal details and start journey with us</p>
                <button class="ghost" id="signUp">Sign Up</button>
            </div>
        </div>
    </div>
</div>
<script>document.addEventListener("DOMContentLoaded", function() {
    const loadingElement = document.querySelector('.loading');
    const mainContent = document.querySelector('.main-content');

    
    setTimeout(function() {
        loadingElement.style.display = 'none';
        mainContent.style.display = 'block';
    }, 1000); 
});

    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });


    //loading
    document.addEventListener("DOMContentLoaded", function() {
    const loadingElement = document.querySelector('.loading');
    const mainContent = document.querySelector('.main-content');

    
    setTimeout(function() {
        loadingElement.style.display = 'none';
        mainContent.style.display = 'block';
    }, 1000); 
});
</script>
</body>
</HTML>