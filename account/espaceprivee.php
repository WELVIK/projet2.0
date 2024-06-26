<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: authentifier.php");
    exit();
}

require 'db_connection.php';

$login = $_SESSION['login'];
$stmt = $conn->prepare("SELECT nom, prenom FROM administrateurs WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->bind_result($nom, $prenom);
$stmt->fetch();
$stmt->close();

$heure = date('H');
if ($heure < 18) {
    $message = "Bonjour";
} else {
    $message = "Bonsoir";
}



// Récupérer les stagiaires
$result = $conn->query("SELECT id, nom, prenom, email, date_inscription FROM utilisateurs");
$utilisateurs = [];
while ($row = $result->fetch_assoc()) {
    $utilisateurs[] = $row;
}


?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>WELVIK</title>
  <link rel='stylesheet' href='https://www.unpkg.com/tailwindcss@1.8.10/dist/tailwind-experimental.min.css'>
  <link rel="stylesheet" href="../css/animation.css">

</head>
<body>
    <div class="loading">
        <div class="three-body">
          <div class="three-body__dot"></div>
          <div class="three-body__dot"></div>
          <div class="three-body__dot"></div>
        </div>
    </div>


  <div class="flex text-gray-800 min-h-screen">
    <aside class="hidden md:block bg-white px-6 py-5 h-full w-full sm:relative sm:w-64 lg:w-1/5">
      <a href="#" class="flex min-w-max-content items-center font-bold text-lg p-2 mb-12">
        <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6 mr-2 text-red-700">
          <path d="M11 17a1 1 0 001.447.894l4-2A1 1 0 0017 15V9.236a1 1 0 00-1.447-.894l-4 2a1 1 0 00-.553.894V17zM15.211 6.276a1 1 0 000-1.788l-4.764-2.382a1 1 0 00-.894 0L4.789 4.488a1 1 0 000 1.788l4.764 2.382a1 1 0 00.894 0l4.764-2.382zM4.447 8.342A1 1 0 003 9.236V15a1 1 0 00.553.894l4 2A1 1 0 009 17v-5.764a1 1 0 00-.553-.894l-4-2z" />
        </svg>
        WELVIK
      </a>
      <nav class="text-gray-600 text-lg font-semibold min-w-max-content space-y-2">
        <a href="#" class="flex items-center flex-shrink-0 px-5 py-3 rounded-full text-red-700 bg-indigo-100 bg-opacity-25">
          <svg viewBox="0 0 20 20" fill="currentColor" class="h-7 w-7 mr-2.5 flex-shrink-0">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
          </svg>
          HOME
        </a>
        <a href="#" class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
          </svg>
          EXERCICE
        </a>
        <a href="#" class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
          COACHES
        </a>
        <a href="#" class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          PROFILE
        </a>
       
        <a href="deconnexion.php" class="flex items-center flex-shrink-0 px-5 py-3 rounded-full hover:bg-gray-100 hover:bg-opacity-50">
          <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6 mx-0.5 mr-3 text-gray-400 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
          </svg>
          LOGOUT
        </a>
      </nav>

    </aside>
    <div class="flex-grow bg-gray-100">
      <header class="flex items-center justify-between px-6 py-5 max-w-6xl mx-auto mb-4">
        <button class="block md:hidden p-2 text-gray-700 mr-2">
          <svg viewBox="0 0 20 20" fill="currentColor" class="h-6 w-6">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
          </svg>
        </button>
        <div class="relative w-full max-w-4xl mr-6 sm:mr-8 md:mr-16 lg:mr-24">
          <svg viewBox="0 0 20 20" fill="currentColor" class="absolute h-6 w-6 text-gray-400 mt-2 ml-3">
            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
          </svg>
          <input type="text" placeholder="Search for objects, contacts, documents etc." class="pl-10 w-full pr-4 py-2 border border-gray-300 shadow-sm rounded-lg" />
        </div>
        <div class="flex flex-shrink-0">
          <button class="flex items-center p-2 sm:mr-2">
          <?php echo  $nom . " " . $prenom . "!";?>
            <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 ml-2">
              <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
          </button>
          <div class="h-10 w-10 hidden sm:block border border-gray-400 bg-gray-300 overflow-hidden rounded-full">
            <img src="https://userstock.io/data/wp-content/uploads/2020/06/philipe-cavalcante-xe68QiMaDrQ-2-300x300.jpg" alt="user avatar" class="object-cover">
          </div>
        </div>
      </header>
      <main class="flex flex-col space-y-10 px-6 py-5 max-w-6xl mx-auto">
        <h1 class="text-3xl">
          <span class="text-gray-500"><?php echo $message ;?></span>
          <span class="font-semibold"><?php echo  $nom . " " . $prenom . "!";?></span>    
        </h1>
        <section class="p-6 sm:p-8 flex items-center bg-red-700 shadow-md rounded-lg">
          <div class="mr-6">
            <header class="text-xl text-indigo-50 mb-3">setup your profile form</header>
            <p class="sm:max-w-md text-black-300 leading-tight mb-5">Get a better overview of your account by having us scan  your  account for you.</p>
            <div class="flex flex-wrap">
              <button class="py-2 px-5 text-black-700 font-semibold bg-white rounded-full  mb-3 mr-5">complite your profile</button>
              <button class="py-2 px-5 text-white font-semibold bg-indigo-900 rounded-full mb-3 mr-5">Later</button>
            </div>
          </div>
          <div class="hidden sm:block mr-0 ml-auto md:mr-8">
            <div class="h-32 w-32 flex items-center justify-center text-3xl text-white font-semibold border-4 border-white rounded-full">
              100%
            </div>
          </div>
        </section>
        <section>
          <div class="flex justify-between items-center mb-6">
            <header class="text-xl font-semibold">Your objects at a glance</header>
            <a href="#" class="hidden sm:flex flex-shrink-0 items-center text-lg font-medium text-gray-500">
              More about finances
              <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 ml-1 mt-1">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="flex sm:hidden flex-shrink-0 items-center text-lg font-medium text-gray-500">
              More
              <svg viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5 ml-1 mt-1">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
          <div class="h-68 bg-white border rounded-lg shadow-md py-4 px-6">
                        
                        <div class="mt-4">
                            <header class="text-lg font-semibold">Users List<a href="inserer.php?id=<?php echo $utilisateur['id']; ?>" class="ml-2 bg-blue-500 text-white py-1 px-2 rounded">Ajouter</a></header>
                            <br>
                            
                            <ul class="list-disc pl-5">
                                <?php foreach ($utilisateurs as $utilisateurs): ?>
                                    <li><?php echo htmlspecialchars($utilisateurs['nom'] . '-' . $utilisateurs['prenom'] . ' - ' . $utilisateurs['email'] . '   /    '. $utilisateurs['date_inscription']);  ?>
                                    <a href="supprimer.php?id=<?php echo $utilisateur['id']; ?>" class="ml-2 bg-red-500 text-white py-1 px-2 rounded">Supprimer</a>
                                    <a href="modifier.php?id=<?php echo $utilisateur['id']; ?>" class="ml-2 bg-blue-500 text-white py-1 px-2 rounded">Modifier</a>
                                </li> <br>
                                <?php endforeach; ?>
                            </ul>
                        </div>
            </div>
        </section>
      </main>
    </div>
  </div>
  <script>
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
  </html>