<?php
require_once __DIR__ . '/../models/UtilisateurBanqueModel.php';
require_once __DIR__ . '/../helpers/Utils.php';

class UtilisateurBanqueController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new UtilisateurBanqueModel($db);
    }

    public function login()
    {
        $data = Flight::request()->data;
        if ($data && isset($data->email, $data->password)) {
            $email = $data->email;
            $password = $data->password;

            $result = $this->model->authenticate($email, $password);

            if ($result) {
                if (session_status() !== PHP_SESSION_ACTIVE) {
                    session_start();
                }

                $_SESSION['banque_id'] = $result['banque_id'];
                $_SESSION['user_id'] = $result['id'];

                Flight::json([
                    'success' => true,
                    'message' => 'Connexion réussie',
                    'user' => $result
                ], 200);
                return;
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Email ou mot de passe incorrect'
                ], 401);
                return;
            }
        }

        Flight::json([
            'success' => false,
            'message' => 'Champs email et mot de passe requis'
        ], 400);
    }
}
