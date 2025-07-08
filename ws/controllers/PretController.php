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

    public function findAllByBanqueId(){
        $id_banque = $_SESSION['banque_id'];
    }

    public function create()
    {
        $data = Flight::request()->data;

        // Validation des données
        $requiredFields = ['date_debut', 'montant', 'banque', 'type_pret', 'client'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                Flight::json([
                    'success' => false,
                    'message' => "Le champ $field est obligatoire"
                ], 400);
                return;
            }
        }

        try {
            $id = $this->model->create([
                'date_debut' => $data['date_debut'],
                'montant' => $data['montant'],
                'banque' => $data['banque'],
                'type_pret' => $data['type_pret'],
                'client' => $data['client']
            ]);

            Flight::json([
                'success' => true,
                'message' => 'Prêt créé avec succès',
                'id' => $id
            ], 201);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la création du prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
