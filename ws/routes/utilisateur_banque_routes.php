<?php
require_once __DIR__ . '/../controllers/UtilisateurBanqueController.php';
require_once __DIR__.'/../db.php';

$db = getDB();
$utilisateur_banque_controller = new UtilisateurBanqueController($db);

// Flight::route('GET /utilisateur', [$utilisateur_banque_controller, 'getAll']);
Flight::route('POST /utilisateur/login', [$utilisateur_banque_controller, 'login']);
// Flight::route('POST /utilisateur/login', function(){
//     Flight::json(["message"=>"ça marche"]);
// });