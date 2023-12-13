<?php
// Récupère les informations de connexion
require_once("connect.php");

// Supprime le membre à partir de son ID
$sql = "delete from membres where id_membre= :id";
$reponse = $connexion->prepare($sql);
$reponse->execute([":id" => $_GET["id"]]);

// Renvoie à la page d'accueil
header("location:../index.php");
