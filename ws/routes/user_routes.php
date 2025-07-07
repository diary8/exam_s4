<?php

use controllers\UserController;

Flight::route('GET /api/users', [UserController::class, 'index']);