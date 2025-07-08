<?php
require_once __DIR__.'/../controllers/MouvementFondController.php';
require_once __DIR__.'/../db.php';

$mouvementFondController = new MouvementFondController($db);

Flight::route('POST /fonds/add', [$mouvementFondController, 'addFunds']);