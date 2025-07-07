<?php
require_once __DIR__.'/../models/BanqueModel.php';

class BanqueController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new BanqueModel($db);
    }

    public function findAll()
    {
        try {
            $banques = $this->model->findAll();
            Flight::json([
                'success' => true,
                'data' => $banques
            ]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des banques',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function findById($id)
    {
        try {
            $banque = $this->model->findById($id);
            if ($banque) {
                Flight::json([
                    'success' => true,
                    'data' => $banque
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Banque non trouvée'
                ], 404);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de la banque',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}