<?php
require_once __DIR__.'/../controllers/ClientController.php';
require_once __DIR__.'/../db.php';

$clientController = new ClientController($db);

Flight::route('GET /clients', [$clientController, 'findAll']);

Flight::route('GET /clients/@Id', [$clientController, 'findById']);
