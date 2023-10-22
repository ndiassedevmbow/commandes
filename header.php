<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Gestion Commandes</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
</head>




<body>
  
  <div class="page-header well well-lg text-justify">
    <h1>Gestion Commandes</h1>
  </div>


<div class="navbar navbar-inverse">
  <div class="container-fluid">

    <button class="navbar-toggle" data-toggle="collapse" data-target="#lnoMenu">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>

    <div class="navbar-header">
      <a href="index.php" class="navbar-brand">Gestion Commandes</a>
    </div>

    <div class="collapse navbar-collapse" id="lnoMenu">

      <ul class="nav navbar-nav">
        <li class="active">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">APPLICATION<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li>
                <a href="index.php">Accueil</a>
              </li>
              <li>
                <a href="Commandes.php">Commandes</a>
              </li>
            </ul>
        </li>

      </ul>

    </div>

    <ul class="nav navbar-nav navbar-right">
      <li>
        <div class="card">
            <div class="card-body" style="margin-right: 20px;">
              <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#add">
                  S'inscrire
            </button>
            </div>
        </div>
      </li>
      <li>
        <div class="card">
            <div class="card-body" style="margin-right: 20px;">
              <button type="button" class="btn btn-lg btn-default" data-toggle="modal" data-target="#con">
                  Se connecter
            </button>
            </div>
        </div>
      </li>
    </ul>

      

  </div> 
</div>
