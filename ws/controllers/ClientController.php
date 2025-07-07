<?php
require_once __DIR__.'/../models/ClientModel.php';

class ClientController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new ClientModel($db);
    }

    public function findAll()
    {
        try {
            $clients = $this->model->findAll();
            Flight::json([
                'success' => true,
                'data' => $clients
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des clients',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function findById($id)
    {
        try {
            $client = $this->model->findById($id);
            if ($client) {
                Flight::json([
                    'success' => true,
                    'data' => $client
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Client non trouvé'
                ], 404);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du client',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}