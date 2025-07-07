<?php
require_once __DIR__ . '/../models/PretModel.php';
require_once __DIR__ . '/../helpers/Utils.php';

class PretController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new PretModel($db);
    }

    public function findAll()
    {
        $result = $this->model->findAll();

        if ($result) {
            Flight::json([
                'success' => true,
                'message' => 'recupérer avec success',
                'list_pret' => $result
            ], 200);
            return;
        } else {
            Flight::json([
                'success' => false,
                'message' => "aucun donnée disponible"
            ], 401);
            return;
        }
    }
}
