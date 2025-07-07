<?php
require 'vendor/autoload.php';
require 'db.php';
require 'routes/etudiant_routes.php';
require 'routes/utilisateur_banque_routes.php';
require 'routes/type_pret_routes.php';
require 'routes/pret_routes.php';

Flight::start();