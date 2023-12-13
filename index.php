<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Liste des Membres</title>
  <link rel="stylesheet" href="css/style.css">
  <script src="js/script.js" defer></script>
</head>

<?php
// Récupère les informations de connexion
require_once("php/connect.php");

// Récupère toutes les données de la table membres
$sql = "select * from membres";
$reponse = $connexion->prepare($sql);
$reponse->execute();
?>

<body>
  <h1>Liste des Membres</h1>

  <table>
    <thead>
      <tr>
        <th>ID Membre</th>
        <th>Prénom Membre</th>
        <th>Nom Membre</th>
        <th>Suppression</th>
      </tr>
    </thead>

    <tbody>
      <?php

      // Crée le tableau
      foreach ($reponse as $ligne) {
        echo "<tr>";
        echo "<td>" . $ligne["id_membre"] . "</td>";
        echo "<td><a href='php/indexinsertupdate.php?id=" .
          $ligne["id_membre"] .
          "'>" .
          $ligne["login_membre"] .
          "</a></td>";
        echo "<td>" . $ligne["nom_membre"] . "</td>";
        echo "<td><a class='supprimer' id=" . $ligne['id_membre'] . ">Supprimer</a></td>";
        echo "</tr>";
      } ?>
    </tbody>

    <tfoot>
      <tr>
        <td colspan=4><a href="php/indexinsertupdate.php">Ajouter un membre</a></td>
      </tr>
    </tfoot>
  </table>
</body>

</html>