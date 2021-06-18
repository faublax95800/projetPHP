<?php
session_start();
// index.php
// Fichier représentant la page d'accueil (tout nos produits).
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Document</title>
</head>
<body>
    <header>
        <nav>
            <ul class="menu">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="../views/login.php">Connexion</a></li>
                <li><a href="../views/inscription.php">Inscription</a></li>
            </ul>
        </nav>
    </header>
    <?php
    if(!empty($_SESSION['firstname']) && !empty(['name'])){
    echo "Vous êtes connectés : " . $_SESSION['firstname'] . ' ' . $_SESSION['name']; 
    }
    ?>
</body>
</html>