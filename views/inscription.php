<?php

    // J'ai décalé ici les conditions pour instancier la classe ClientController.

    require_once('../src/config/database.php'); // class database se trouvant dans config

    // require_once('../src/models/database.php'); // class database se trouvant dans models

    require_once('../src/controllers/ClientController.php');

    // use src\config\Database;

    $connexion = new Database();
    
    // $connexion = new src\models\Database();

    if(!empty($_POST['firstname']) && !empty($_POST['name']) && !empty($_POST['mail']) && !empty($_POST['pass'])){
        $client = new ClientController($_POST, $connexion->getPDO()); // On passe le tableau $_POST au constructeur de ma classe. 
        $client->inscription();
    } else {
        echo "L'un des champs n'a pas été remplis";
    }
    // Fichier comprenant le formulaire d'inscription.
    
    require_once('./templates/header.php');


?>

<form action="inscription.php" method="post"> <!-- action sur inscription.php et méthode post -->
    <!-- NE SURTOUT PAS OUBLIER LES ATTRIBUTS NAME -->
    <label for="firstname">Prénom</label>
    <input type="text" id="firstname" name="firstname">

    <label for="name">Nom</label>
    <input type="text" id="name" name="name">

    <label for="mail">Email</label>
    <input type="email" id="mail" name="mail">

    <label for="pass">Mot de passe</label>
    <input type="password" id="pass" name="pass" minlength="5">

    <button>S'inscrire</button>
</form>

<?php require_once('./templates/footer.php'); ?>
