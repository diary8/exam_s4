<?php
require_once __DIR__.'/../models/DemandePretModel.php';
require_once __DIR__.'/../models/StatusDemandeModel.php';

class DemandePretController {
    private $demandeModel;
    private $statusModel;

    public function __construct($db) {
        $this->demandeModel = new DemandePretModel($db);
        $this->statusModel = new StatusDemandeModel($db);
    }

    public function create() {
    $data = Flight::request()->data;
    
    try {
        // Validation des champs requis
        $requiredFields = ['montant', 'type_pret_id', 'banque_id', 'client_id'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                Flight::json(['success' => false, 'message' => "Le champ $field est requis"], 400);
                return;
            }
        }

        // Création demande avec tous les champs
        $demandeId = $this->demandeModel->create([
            'montant' => $data['montant'],
            'type_pret_id' => $data['type_pret_id'],
            'banque_id' => $data['banque_id'],
            'client_id' => $data['client_id']
        ]);

        // Statut initial: 1 = En cours
        $this->statusModel->create($demandeId, 1);

        Flight::json([
            'success' => true,
            'message' => 'Demande créée',
            'id' => $demandeId
        ], 201);

    } catch (Exception $e) {
        Flight::json([
            'success' => false,
            'message' => 'Erreur création demande',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function findAll() {
        try {
            $demandes = $this->demandeModel->findAll();
            Flight::json(['success' => true, 'data' => $demandes]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur récupération demandes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}