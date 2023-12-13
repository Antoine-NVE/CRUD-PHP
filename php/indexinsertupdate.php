<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>
    <?php
    // Change le titre en fonction du cas présent
    if (isset($_GET["id"])) {
      echo "Modifier un membre";
    } else {
      echo "Ajouter un membre";
    }
    ?>
  </title>

  <link rel="stylesheet" href="../css/style.css">

  <script src="../js/scriptindexupdate.js" defer></script>
</head>

<body>
  <?php
  // Récupère les informations de connexion
  require_once("connect.php");

  // Test du prénom
  function prenomTest()
  {
    if (isset($_POST["submit"])) {
      $_POST["prenom"] = ucfirst($_POST["prenom"]);
      if ($_POST["prenom"] === "") {
        return "<p class='erreur'>Veuillez saisir un prénom</p>";
      } elseif (!preg_match('^[A-Z][A-Za-z\é\è\ê\-]+$^', $_POST["prenom"])) {
        return "<p class='erreur'>Veuillez saisir un prénom valide</p>";
      } else {
        return false;
      }
    }
  }
  prenomTest();

  // Test du nom
  function nomTest()
  {
    if (isset($_POST["submit"])) {
      $_POST["nom"] = strtoupper($_POST["nom"]);
      if ($_POST["nom"] === "") {
        return "<p class='erreur'>Veuillez saisir un nom</p>";
      } elseif (!preg_match('^[A-Z][A-Z]+$^', $_POST["nom"])) {
        return "<p class='erreur'>Veuillez saisir un nom valide</p>";
      } else {
        return false;
      }
    }
  }
  nomTest();

  // Si on est dans le cas d'une modification :
  if (isset($_GET["id"])) {

    // Récupère les données d'un membre grâce à son ID
    $sql = "select * from membres where id_membre= :id";
    $reponse = $connexion->prepare($sql);
    $reponse->execute([":id" => $_GET["id"]]);
    $data = $reponse->fetch();

    // Création de la page HTML
    echo "<h1>Modifier un membre</h1>"
      . "<form action='' method='post'>"
      . "<div><label for='identifiant'>Id : </label><input disabled type='text' id='identifiant' value='"
      . $data['id_membre'] . "'><input type='hidden' name='identifiant' value='"
      . $data['id_membre'] . "'></div>"
      . "<div><label for='prenom'>Prénom : </label><input type='text' id='prenom' name='prenom' value='";


    // On vérifie si l'utilisateur a tenté de soumettre le formulaire
    if (isset($_POST["prenom"])) {
      echo $_POST["prenom"];
    } else {
      echo $data['login_membre'];
    }

    // Affichage message d'erreur prénom
    echo "'></div>"
      . prenomTest()
      . "<div><label for='nom'>Nom : </label><input type='text' id='nom' name='nom' value='";


    // On vérifie si l'utilisateur a tenté de soumettre le formulaire
    if (isset($_POST["nom"])) {
      echo $_POST["nom"];
    } else {
      echo $data['nom_membre'];
    }

    // Affichage message d'erreur nom
    echo "'></div>"
      . nomTest();

    // Si le formulaire est soumis
    if (isset($_POST["submit"]) && !prenomTest() && !nomTest()) {
      // Modifie le membre à partir de son ID et des données rentrées
      $sql = "update membres set nom_membre= :nom, login_membre= :prenom where id_membre= :id";
      $reponse = $connexion->prepare($sql);
      $reponse->bindValue(":nom", $_POST["nom"], PDO::PARAM_STR);
      $reponse->bindValue(":prenom", $_POST["prenom"], PDO::PARAM_STR);
      $reponse->bindValue(":id", $_POST["identifiant"], PDO::PARAM_STR);
      $reponse->execute();

      // Renvoie à la page d'accueil
      header("location:../index.php");
    }
  }

  // Sinon on est dans le cas d'un ajout :
  else {
    // Création de la page HTML
    echo "<h1>Ajouter un membre</h1>"
      . "<form action='' method='post'>"
      . "<div><label for='prenom'>Prénom : </label><input type='text' id='prenom' name='prenom' value='";

    // On vérifie si l'utilisateur a tenté de soumettre le formulaire
    if (isset($_POST["prenom"])) {
      echo $_POST["prenom"];
    }

    // Affichage message d'erreur prénom
    echo "'></div>"
      . prenomTest()
      . "<div><label for='nom'>Nom : </label><input type='text' id='nom' name='nom' value='";

    // On vérifie si l'utilisateur a tenté de soumettre le formulaire
    if (isset($_POST["nom"])) {
      echo $_POST["nom"];
    }

    // Affichage message d'erreur nom
    echo "'></div>"
      . nomTest();

    // Si le formulaire est soumis
    if (isset($_POST["submit"]) && !prenomTest() && !nomTest()) {
      // Ajoute un membre à l'aide des données rentrées
      $sql = "insert into membres (nom_membre, login_membre) values (:nom, :prenom)";
      $reponse = $connexion->prepare($sql);
      $reponse->bindValue(":nom", $_POST["nom"], PDO::PARAM_STR);
      $reponse->bindValue(":prenom", $_POST["prenom"], PDO::PARAM_STR);
      $reponse->execute();

      // Renvoie à la page d'accueil
      header("location:../index.php");
    }
  }
  ?>
  <div>
    <button type="submit" name="submit">
      <?php
      // Change le bouton en fonction du cas présent
      if (isset($_GET["id"])) {
        echo "Modifier";
      } else {
        echo "Ajouter";
      }
      ?>
    </button>
    <button type="reset">Annuler</button>
    <button id="retour">Retour</button>
  </div>
</body>

</html>