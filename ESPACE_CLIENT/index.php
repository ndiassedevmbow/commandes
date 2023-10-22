<?php
// session_name('nom_de_ma_session');
// session_start();
$serveur = 'localhost';
$utilisateur = 'root';
$base_de_donnees = 'commandes';
$mot_de_passe = '';

try {
    $bdd = new PDO("mysql:host=$serveur;dbname=$base_de_donnees", $utilisateur, $mot_de_passe);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Gestion des etudiants </title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
</head>
<body>



<div class="container">
    
    <div class="jumbotron">

        <div class="card">
            <h2> Gestion des etudiants </h2>
        </div>
        

        <div class="card">
            <div class="card-body">

<?php
    if(!isset($_GET['idClient']))
    {
        echo("User pas defini");
    }
    else{
        $idClient = $_GET['idClient'];


        $query = $bdd->prepare("SELECT * FROM Clients WHERE idClient = :idClient");
        $query->bindParam(':idClient', $idClient);
        $query->execute();
?>
                    <table id="datatableid" class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th>ID CLIENT</th>
                                <th>EMAIL CLIENT</th>
                                <th>NOM CLIENT</th>
                                <th>VILLE CLIENT</th>
                                <th scope="col"> Modification </th>
                                <th scope="col"> Suppresion </th>
                            </tr>
                        </thead>
<?php
        while($res = $query->fetch())
        {
?>
        <tbody>
            <tr>
                <td> <?php echo $res['idClient']; ?> </td>
                <td> <?php echo $res['email']; ?> </td>
                <td> <?php echo $res['nom']; ?> </td>
                <td> <?php echo $res['VQ']; ?> </td>
                <td>
                    <button type="button" class="btn btn-success editbtn"> Modification </button>
                </td>
                <td>
                    <button type="button" class="btn btn-danger deletebtn"> Suppression </button>
                </td>
            </tr>
        </tbody>
<?php           
        }
?>
                    </table>
                </div>
            </div>
    </div>
</div>


<a type="button" href="logout.php" class="btn btn-lg btn-block btn-danger" style="color: white">Deconnexion</a>
<hr>



<!-- MODIFIER -->
<div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        
    <div class="modal-dialog" role="document">
            
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Modifier l'etudiant </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST">

                <div class="modal-body">

                    <input type="hidden" name="update_id" id="update_id">

                    <div class="form-group">
                        <label for="email"> Email </label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Votre email" value="<?php echo $row['email']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="nom"> Nom </label>
                        <input type="text" id="nom" name="nom" class="form-control" placeholder="Votre nom" value="<?php echo $row['nom']; ?>">
                    </div>

                    <div class="form-group">
                        <label for="VQ"> VILLE </label>
                        <input type="text" id="VQ" name="VQ" class="form-control" placeholder="Votre VQ" value="<?php echo $row['VQ']; ?>">
                    </div>

                </div>


                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                    <button type="submit" name="updatedata" class="btn btn-primary">Mettre à jour</button>
                </div>

            </form>

        </div>

    </div>

</div>

<?php  
}
} catch (Exception $e) {
    echo 'Error : ' .$e->getMessage();
}
?>




<!-- SUPPRIMER -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        
    <div class="modal-dialog" role="document">
    
        <div class="modal-content">
                
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Supprimer etudiant </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="" method="POST">

                <div class="modal-body">

                    <input type="hidden" name="delete_id" id="delete_id">

                    <h4> Voulez-vous vraiment supprimer ??</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Non </button>
                    <button type="submit" name="deletedata" class="btn btn-primary"> Oui !! supprimer. </button>
                </div>

            </form>

        </div>

    </div>

</div>







<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function () {
    	$('#datatableid').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search Your Data",
            }
        });
    });
</script>
<script>
    $(document).ready(function () {

        $('.deletebtn').on('click', function () {

            $('#deletemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

        	$('#delete_id').val(data[0]);

       });
        
    });
</script>
<script>
    $(document).ready(function () {

        $('.editbtn').on('click', function () {

            $('#editmodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#update_id').val(data[0]);
            $('#email').val(data[1]);
            $('#nom').val(data[2]);
            $('#VQ').val(data[3]);
         });

    });
</script>


</body>
</html>




<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection, 'commandes');

    if(isset($_POST['updatedata']))
    {   
        $id = $_POST['update_id'];
        
        $email = $_POST['email'];
        $nom = $_POST['nom'];
        $VQ = $_POST['VQ'];

        $query = "UPDATE clients SET email='$email', nom='$nom', VQ='$VQ' WHERE idClient='$id'  ";
        $query_run = mysqli_query($connection, $query);
    }
?>



<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection, 'commandes');

if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];

    $query = "DELETE FROM clients WHERE idClient='$id'";
    $query_run = mysqli_query($connection, $query);
}

?>