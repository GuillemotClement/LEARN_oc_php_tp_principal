<?php 

session_start();

require_once(__DIR__ . '/functions.php');

//Détruire la session
session_unset();
session_destroy();

//rediriger l'utilisateur vers la page d'accueil
redirectToUrl('index.php');