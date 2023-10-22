<?php  
session_start();
require_once 'header.php';

$server = 'localhost';
$login = 'root';
$bd = 'Commandes';
$mdp = '';

try {
    $bdd = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    function lno_secure($datas)
	{
	    $datas = htmlspecialchars($datas);
	    $datas = trim($datas);
	    $datas = addslashes($datas);
	    $datas = strip_tags($datas);
	    return $datas;
	}

    $errorInscInsc = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['inscription'])) {
        $email = lno_secure($_POST['email']);
        $nom = lno_secure($_POST['nom']);
        $VQ = lno_secure($_POST['VQ']);
        $pwd = lno_secure($_POST['pwd']);

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $nom_length = strlen($nom);
            $VQ_length = strlen($VQ);

            // Vérifiez la longueur du nom et de la ville
            if ($nom_length >= 10 && $VQ_length >= 10) {
                // Vérifiez le mot de passe avec une expression régulière
                if (preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8}$/', $pwd)) {
                    // Vérifiez si l'email n'existe pas déjà dans la base de données
                    $checkEmailQuery = $bdd->prepare('SELECT email FROM CLIENTS WHERE email = :email');
                    $checkEmailQuery->bindParam(':email', $email, PDO::PARAM_STR);
                    $checkEmailQuery->execute();

                    if ($checkEmailQuery->rowCount() == 0) {
                        // L'email n'existe pas, vous pouvez l'insérer dans la base de données
                        $hashedPassword = password_hash($pwd, PASSWORD_DEFAULT);

                        $insertQuery = $bdd->prepare('INSERT INTO CLIENTS(email, nom, VQ, pwd) VALUES(:email, :nom, :VQ, :pwd)');

                        $insertQuery->bindParam(':email', $email);
                        $insertQuery->bindParam(':nom', $nom);
                        $insertQuery->bindParam(':VQ', $VQ);
                        $insertQuery->bindParam(':pwd', $hashedPassword);

                        $insertQuery->execute();
                        header('Location: index.php');
                    } else {
                        $errorInscInsc = 'Cet email est déjà enregistré.';
                    }
                } else {
                    $errorInscInsc = 'Le mot de passe ne respecte pas les règles (doit avoir exactement 8 caractères MAJ, MIN et Chiffre(s)).';
                }
            } else {
                $errorInscInsc = 'Le nom et la ville doivent avoir au moins 10 caractères';
            }
        } else {
            $errorInscInsc = 'L\'email n\'est pas valide';
        }
    }






   
    $loginError = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['connexion'])) {
        $emailCon = htmlspecialchars($_POST['emailCon']); // Nettoyer l'entrée de l'utilisateur
        $pwdCon = $_POST['pwdCon'];

        if (!empty($emailCon) && !empty($pwdCon)) {
            $stmt = $bdd->prepare('SELECT * FROM CLIENTS WHERE email = :emailCon');
            $stmt->bindParam(':emailCon', $emailCon, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch();

                if (password_verify($pwdCon, $user['pwd'])) {
                    $_SESSION['user_id'] = $user['idClient'];

                    header('Location: Espace_CLIENT/index.php?idClient='.$user['idClient']);
                    exit();
                } else {
                    $loginError = 'Login ou mot de passe incorrect.';
                }
            } else {
                $loginError = 'Login ou mot de passe incorrect.';
            }
        } else {
            $loginError = 'L\'email et le mot de passe sont requis.';
        }
    }

} catch (Exception $e) {
    $errorInscInsc = array(
        'message' => $e->getMessage(),
        'ligne' => $e->getLine()
    );
    echo(json_encode($errorInscInsc));
     $loginError = array(
        'message' => $e->getMessage(),
        'ligne' => $e->getLine()
    );
    echo(json_encode($loginError));
}
?>










<!-- INSCRIPTION -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document"> <!-- contient le contenu du modal -->
        <div class="modal-content">   <!-- contenu de la boîte de dialogue modale -->
            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">
                    Inscription client
                 </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form" method="post" action="">
                
                <div class="modal-body">
                  <div class="form-group">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="votre email">
                  </div>

                  <div class="form-group">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom">
                  </div>

                  <div class="form-group">
                    <label for="VQ">Ville-Quartier :</label>
                    <input type="text" class="form-control" id="VQ" name="VQ" placeholder="Votre Ville et Quartier">
                  </div>

                  <div class="form-group">
                    <label for="pwd">Mot de passe : </label>
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Votre mot de passe">
                  </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" name="inscription">S'inscrire</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
<div class="text-danger"><?php if(isset($errorInscInsc)) echo($errorInscInsc); ?></div>




<!-- CONNEXION -->
<?php
// if (!isset($_SESSION['user_id'])) {
?>
<div class="modal fade" id="con" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document"> <!-- contient le contenu du modal -->
            
        <div class="modal-content">   <!-- contenu de la boîte de dialogue modale -->

            <div class="modal-header">
                <h5 class="modal-title text-info" id="exampleModalLabel">
                    Connexion client
                 </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="form" method="post" action="">
                
                <div class="modal-body">
                  <div class="form-group">
                    <label for="emailCon">Email :</label>
                    <input type="email" class="form-control" id="emailCon" name="emailCon" placeholder="votre email">
                  </div>

                  <div class="form-group">
                    <label for="pwdCon">Mot de passe : </label>
                    <input type="password" class="form-control" id="pwdCon" name="pwdCon" placeholder="Votre mot de passe">
                  </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary" name="connexion">Se connecter</button>
                </div>
                
            
            </form>

        </div>

    </div>

</div>
<div class="text-danger"><?php if(isset($loginError)) echo($loginError); ?></div>

<?php
// }
// else{
//     header('Location: clients.php');
// }


require_once 'footer.php';
?>

