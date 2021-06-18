<?php
// session_start();

require_once('../src/controllers/LoginController.php');
require_once('../src/config/database.php');

echo '<pre>';
var_dump($_POST);
echo '</pre>';

$connexion = new Database();

if(!empty($_POST['mail']) && !empty($_POST['pass'])){
    $clientController = new LoginController($connexion->getPDO());

    $clientController->login($_POST['mail'], $_POST['pass']);

    var_dump($_SESSION['firstname']);

}
// Fichier comprenant le formulaire de connexion.
require_once('./templates/header.php'); // J'intégre le template du header.
?>

<!-- Ici se trouvera du HTML -->
<form action="login.php" method="post"> <!-- action sur le ClientController et méthode post -->
    <!-- NE SURTOUT PAS OUBLIER LES ATTRIBUTS NAME -->
    <label for="mail">Email</label>
    <input type="email" id="mail" name="mail">

    <label for="pass">Mot de passe</label>
    <input type="password" id="pass" name="pass" minlength="5">

    <button>Se connecter</button>
</form>

<?php require_once('./templates/footer.php'); // J'intégre le template du footer. ?>