<?php

//namespace src\config\;

//$pdo = new PDO('mysql:host=localhost;dbname=php', "root", "");

// echo '<pre>';
// print_r(get_class_methods($pdo));
// echo '</pre>';
// $connexion = new Database();

// echo '<pre>';
// print_r($connexion->getPDO());
// echo '</pre>';

class Database {

    private $host = "localhost"; // propriété host.

    private $dbname = "php"; // propriété php.

    private $user = "root"; // propriété root.

    private $pass = ""; // Si vous êtes sur Mamp il faut écrire "root".



    public function getPDO(){
        try{// le try permet d'essayer du code. Si jamais une erreur est retournée, alors le catch s'execute.
            // $pdo = new PDO('mysql:host=localhost;dbname=php', "root", "");
            $pdo = new PDO('mysql:host=' . $this->host .';dbname='. $this->dbname, $this->user, $this->pass); // PDO est l'objet utilisé pour créer la connexion.
            return $pdo; // $pdo contient ma connexion. 
        }catch(PDOException $e){ // Ici on récupère une erreur PDOException, pour connaitre preciser le problème de notre connexion. 

            return $e; // On peut retourner l'erreur.
            //exit($e); // On peut utiliser exit ou die pour fermer le script.
        }
    }

}

?>