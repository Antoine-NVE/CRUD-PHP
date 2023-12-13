<?php

// Informations de connexion
$dsn = "mysql:dbname=formation;host=localhost;charset=utf8";
try {
  $option = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
  $connexion = new PDO($dsn, "root", "", $option);
} catch (PDOException $e) {
  echo "Echec connexion :" . $e->getMessage();
}
