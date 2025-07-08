<?php
require_once __DIR__.'/../controllers/ValidationPretController.php';
require_once __DIR__.'/../db.php';

$validationController = new ValidationPretController($db);

Flight::route('POST /demandes_pret/@demande_id/approve', [$validationController, 'approve']);
Flight::route('POST /demandes_pret/@demande_id/reject', [$validationController, 'reject']);