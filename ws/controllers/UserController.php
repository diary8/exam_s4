<?php

namespace controllers;

class UserController {
    public static function index() {
        $users = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie']
        ];

        \Flight::json($users);
    }
}
