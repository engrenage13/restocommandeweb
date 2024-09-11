<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv as Dot;
$dotenv = Dot::createImmutable(__DIR__);
$dotenv->safeLoad();

include('./src/helpers/dbconnect.php');

$req = "SELECT COUNT(id) nb FROM utilisateur";
$resultat = mysqli_query($connexion, $req) or die(mysqli_error($connexion));
while ($ligne = mysqli_fetch_array($resultat)) {
  $utilisateurs = $ligne['nb'];
}
?>

<html>
  <head>
    <title>Resto commande - Accueil</title>
    <link rel="stylesheet" href="global.css" />
    <link rel="icon" type="image/x-icon" href="public/favicon.ico" />
  </head>
  <body>
    <h1 class="title">Resto Commande</h1>
    <p class="text"><?php echo $utilisateurs == 0 ? 'Aucun' : $utilisateurs; ?> <?php echo $utilisateurs <= 1 ? 'utilisateur' : 'utilisateurs'; ?></p>
  </body>
</html>