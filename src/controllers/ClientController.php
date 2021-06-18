<?php


// Class ClientController
// Ce controlleur va venir traiter les données en rapport avec les utilisateurs.

// echo '<pre>';
// print_r(get_declared_classes()); qui permet d'obtenir la liste de toutes les classes appartenant à PHP.
// echo '</pre>';

require_once('../src/models/ClientModel.php'); // J'intégre ClientModel.php




// echo '<p>'.$client->getFirstname().'</p>'; // On affiche la propriété du prénom.
// echo '<p>'.$client->getName().'</p>'; // On affiche la propriété du nom.
// echo '<p>'.$client->getMail().'</p>'; // On affiche la propriété du mail.
// echo '<p>'.$client->getPass().'</p>'; // On affiche la propriété du mot de passe. 


class ClientController
{

    //private $login;

    protected $connexion; // propriété de connexion. 

    private $firstname; // propriété du prénom.

    private $name; // propriété du nom.

    protected $mail; // propriété du mail.

    protected $pass; // propriété du mot de passe. 

    private const valid = 1; // Pour une constante on ne met pas de $.

    private const rank = "client"; // Données par défaut.

    public function __construct(array $data, PDO $pdo)
    { // le constructeur permet de récupérer $_POST et PDO à la création de l'objet.
        $this->connexion = $pdo; // on récupére la connexion PDO 
        // On envoie toutes les données récupérées grâce à $_POST dans les différents setter créés. 
        //if(isset($data['firstname']) && isset($data['name']))
        //{
        $this->setFirstname($data['firstname']);
        $this->setName($data['name']);
        //} else
        //{
        //$this->setLogin(TRUE);
        //}
        $this->setMail($data['mail']);
        $this->setPass($data['pass']);
    }

    // Inscription me permet d'inscrire les données du formulaire en base de données. 
    public function inscription()
    {
        $clientModel = new ClientModel($this->connexion);

        if (!empty($this->mail) && !empty($this->pass) && !empty($this->firstname) && !empty($this->name)) 
        {
            $clientModel->add($this->firstname, $this->name, $this->mail, $this->pass, self::rank, self::valid);
        }
    }

    ////////////////////////////
    // VERIFICATION ET NETTOYAGE
    ////////////////////////////

    // La méthode cleanData permet de nettoyer les données provenants des formulaires. 
    private function cleanData($data)
    {
        $data = trim($data); // permet d'enlever les espaces de début et de fin dans une chaine de caractère.
        $data = stripslashes($data); // permet d'enlever les antislash. /!\ Si vous passez la valeur du mot de passe dedans. 
        $data = strip_tags($data); // permet d'enlever les balises HTML et PHP.
        //$data = htmlspecialchars($data);
        return $data;
    }

    //preg_match permet de comparer une regex à une donnée. 
    private function checkRegex($data)
    {
        if (preg_match('/^[a-zA-Zçàéè-]+$/', $data)) {
            return $data;
        } else {
            return null;
            //echo "Votre prénom ou votre nom ne doivent contenir que des lettres ou des traits d'unions."; 
        }
    }


    ///////////////////////
    // GETTER / SETTER
    ///////////////////////

    public function getFirstname()
    { // afficher ou de récupérer une propriété mise en private.
        return $this->firstname;
    }

    public function setFirstname($firstname)
    { // modifier ou de créer une propriété. 
        //$firstname = $this->cleanData($firstname);
        if (!is_null($this->checkRegex($firstname))) {
            return $this->firstname = $firstname;
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        //$name = $this->cleanData($name);
        if (!is_null($this->checkRegex($name))) // On essaye la regex sur le name.
        {
            return $this->name = $name;
        }
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $clientModel = new ClientModel($this->connexion); // On instancie ClientModel pour utiliser getOne();

        //$mail = $this->cleanData($mail);
        if (filter_var($mail, FILTER_VALIDATE_EMAIL)) { // On vient vérifier si la structure du mail est correct
            if (count($clientModel->getOne($mail)) === 0) { // Ici on vérifie si l'email n'existe pas déjà en base de données. 
                return $this->mail = $mail;
            } else {
                echo "Un compte existe avec cet email.";
            }
            // if($this->login === TRUE)
            // {
            //     // Démarche connexion
            //     if(count($clientModel->getOne($mail)) === 0){ // Ici on vérifie si l'email n'existe pas déjà en base de données. 
            //         echo "Aucun compte n'existe avec cet email.";
            //     } else
            //     {
            //         var_dump($clientModel->getOne($mail));
            //     }
            // }else{
            //     // Démarche inscription
            //     if(count($clientModel->getOne($mail)) === 0){ // Ici on vérifie si l'email n'existe pas déjà en base de données. 
            //         return $this->mail = $mail;
            //     } else
            //     {
            //         echo "Un compte existe avec cet email.";
            //     }
            // }  
        } else {
            echo "Votre email n'est pas correctement écrit.";
        }
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        if (strlen($pass) > 7) { // on vérifie si le mot de passe fait plus de 7 caractères. 
            $pass = password_hash($pass, PASSWORD_BCRYPT); // On vient hasher le mot de passe pour le sécuriser 
            return $this->pass = $pass;
        } else {
            echo "Votre mot de passe ne contient pas assez de caractères (8 minimum).";
        }
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin(bool $boolean)
    {
        return $this->login = $boolean;
    }
}
