<?php
require_once __DIR__.'/../models/DemandePretModel.php';
require_once __DIR__.'/../models/StatusDemandeModel.php';
require_once __DIR__.'/../models/PretModel.php';
require_once __DIR__.'/../models/FondEtablissementModel.php';

class ValidationPretController {
    private $demandeModel;
    private $statusModel;
    private $pretModel;
    private $fondModel;

    public function __construct($db) {
        $this->demandeModel = new DemandePretModel($db);
        $this->statusModel = new StatusDemandeModel($db);
        $this->pretModel = new PretModel($db);
        $this->fondModel = new FondEtablissementModel($db);
    }

       public function approve($demande_id) {
        $data = Flight::request()->data;
        
        try {
            // Vérifier fonds disponibles
            $fondDisponible = $this->fondModel->checkFunds($data['banque_id']);
            if (!$fondDisponible || $fondDisponible['montant'] < $data['montant']) {
                $this->statusModel->create($demande_id, 3); // 3 = Refusé
                Flight::json(['success' => false, 'message' => 'Fonds insuffisants']);
                return;
            }

            // // Vérifier si client a déjà un prêt
            // if ($this->pretModel->clientHasPendingLoan($data['client_id'])) {
            //     $this->statusModel->create($demande_id, 3); // 3 = Refusé
            //     Flight::json(['success' => false, 'message' => 'Client a déjà un prêt']);
            //     return;
            // }

            // Créer le prêt
            $pretId = $this->pretModel->create([
                'montant' => $data['montant'],
                'date_debut_pret' => date('Y-m-d'),
                'banque_id' => $data['banque_id'],
                'type_pret_id' => $data['type_pret_id'],
                'client_id' => $data['client_id']
            ]);

            // Mettre à jour les fonds et enregistrer le mouvement (type 3 = prêt)
            $this->fondModel->updateFundsForPret($data['banque_id'], $data['montant'], $pretId);

            // Changer statut demande: 2 = Approuvé
            $this->statusModel->create($demande_id, 2);

            Flight::json([
                'success' => true,
                'message' => 'Prêt approuvé',
                'pret_id' => $pretId
            ]);

        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur validation',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function reject($demande_id) {
        try {
            $this->statusModel->create($demande_id, 3); // 3 = Refusé
            Flight::json(['success' => true, 'message' => 'Demande refusée']);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur rejet demande',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}