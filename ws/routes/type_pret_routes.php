<?php 
require_once __DIR__.'/../controllers/TypePretController.php';
require_once __DIR__ . '/../db.php';

$typePretController = new TypePretController($db);

Flight::route('GET /types_pret', [$typePretController, 'findAll']);
Flight::route('GET /types_pret/@id', [$typePretController, 'findById']);
Flight::route('POST /types_pret', [$typePretController, 'create']);
Flight::route('PUT /types_pret/@id', [$typePretController, 'update']);
Flight::route('DELETE /types_pret/@id', [$typePretController, 'delete']);