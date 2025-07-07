<?php
require 'vendor/autoload.php';
require 'db.php';

require 'routes/etudiant_routes.php';
require 'routes/utilisateur_banque_routes.php';
require 'routes/type_pret_routes.php';
require 'routes/pret_routes.php';
require 'routes/banque_routes.php';
require 'routes/client_routes.php';
require 'routes/demande_pret_routes.php';
require 'routes/validation_pret_routes.php';

Flight::start();