<?php
session_start(); // Je lance la connexion avec session_start();

require_once('../src/controllers/ClientController.php');


class LoginController extends ClientController {

    private $client; // Si le client qui se connecte existe, alors on récupère ses données. 

    public function __construct(PDO $pdo){
        $this->connexion = $pdo;

        // $this->setMail($data['mail']);
        // $this->setPass($data['pass']);
    }

    public function login($mail, $pass){
        $mail = $this->setMail($mail); // vérifie si l'email existe
        
        if(is_array($mail)){ // is_array renvoie TRUE si $mail est un tableau. 
            if($this->setPass($pass)){
                $_SESSION['id'] = $this->client[0]['id'];
                $_SESSION['firstname'] = $this->client[0]['firstname'];
                $_SESSION['name'] = $this->client[0]['name'];
                $_SESSION['mail'] = $this->client[0]['mail'];
                $_SESSION['rank'] = $this->client[0]['rank'];
                $_SESSION['valid'] = $this->client[0]['valid'];

                header('Location: ../public/index.php');
            }
        } else {
            echo $mail;
        }
    }

    public function setMail($mail){
        $clientModel = new ClientModel($this->connexion);

        if(count($clientModel->getOne($mail)) === 1){
            return $this->client = $clientModel->getOne($mail);
        } else
        {
            return "Votre email ou votre mot de passe de correspondent pas.";
        }
    }

    public function setPass($pass){
        // echo '<pre>';
        // var_dump($this->client[0]['pass']);
        // echo '</pre>';

        if(password_verify($pass, $this->client[0]['pass'])){
            return TRUE;
        } else
        {
            echo "Votre email ou votre mot de passe de correspondent pas.";
        }
    }
}

?>