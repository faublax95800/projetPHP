<?php


//$client->add('efz', 'dadzadza', 'dzadza@dzadz.fr', 'dfzadzad', "client", 1);

//$client->getOne('test@test.fr');

class ClientModel {

    private $connexion; // objet pdo

    public function __construct(PDO $pdo){ // j'intégre la connexion au constructeur
        $this->connexion = $pdo;
    }

    // CRUD (Create, read, update, delete)

    // la méthode add me permet d'insérer des données en base de données (Create)
    public function add(string $firstname, string $name, string $mail, string $pass, string $rank, int $valid){ // Create pour le CRUD
        $request = $this->connexion->prepare("INSERT INTO client(firstname, name, mail, pass, rank, valid, date_created) VALUES (:firstname, :name, :mail, :pass, :rank, :valid, NOW()) ");
        // Ci-dessus, on crée une requête préparée avec du SQL en paramètre. 

        // Première possibilité.
        // $request->bindParam(':firstname', $firstname);
        // $request->bindParam(':name', $name);

        // Deuxième possibilité. 
        // $request->bindValues(':name', $name);

        // Dernière possibilité. 
        try{
            $request->execute([ // execute me permet d'executer ma requête.
                // en paramètre on propose un tableau pour remplacer pas nos valeurs, les noms en références. 
                ':firstname' => $firstname,
                ':name' => $name,
                ':mail' => $mail,
                ':pass' => $pass,
                ':rank' => $rank,
                ':valid' => $valid
            ]);
        } catch(Exception $e){
            echo $e;
        }
        // $request n'est plus un objet PDO, mais devient un objet PDOStatement.
        // echo '<pre>';
        // print_r(get_class_methods($request));
        // echo '</pre>';
    }

    public function getAll(){ // Read pour le CRUD

    }

    //getOne me permet de récupérer un client grâce à son mail. 
    public function getOne(string $mail){ // Read pour le CRUD
        $request = $this->connexion->prepare("SELECT * FROM client WHERE mail=:mail");

        $request->execute([
            ':mail' => $mail
        ]);

        /* On doit utiliser fetchAll ou fetch pour récupérer les données une fois la requête effectuée. */

        $result = $request->fetchAll(PDO::FETCH_ASSOC);

        // echo '<pre>';
        // var_dump($result);
        // echo '</pre>';

        return $result;

        // Pour fetch il faudra creer une boucle. 

        //$result = $request->fetch();

        // while($data = $request->fetch()){
        //     $client = [
        //         "id" => $data['id'],
        //         "firstname" => $data['firstname'],
        //         "name" => $data['name'],
        //         "pass" => $data['pass'],
        //         "rank" => $data['rank'],
        //         "valid" => $data['valid']
        //     ];

        //     $result[] = $client;
        // }
        
        // echo '<pre>';
        // print_r($result);
        // echo '</pre>';

    }

    public function update(){ // Update pour le CRUD

    }

    public function delete(){ // Delete pour le CRUD

    }


}




?>