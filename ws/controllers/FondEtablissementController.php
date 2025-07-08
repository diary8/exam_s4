<?php 
require_once __DIR__.'/../models/FondEtablissementModel.php';

class FondEtablissementController 
{
    private $fondModel;

    public function __construct($db) {
        $this->fondModel = new FondEtablissementModel($db);
    }

    public function addFunds() {
        $data = Flight::request()->data;
        
        try {
            // Validation
            $requiredFields = ['banque_id', 'montant', 'type_mouvement_id'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    Flight::json(['success' => false, 'message' => "Le champ $field est requis"], 400);
                    return;
                }
            }

            // Vérification du type de mouvement (1: remboursement, 2: ajout de fonds)
            if (!in_array($data['type_mouvement_id'], [1, 2])) {
                Flight::json(['success' => false, 'message' => 'Type de mouvement invalide'], 400);
                return;
            }

            // Pour les remboursements (type 1), vérifier la présence du pret_id
            if ($data['type_mouvement_id'] == 1 && empty($data['pret_id'])) {
                Flight::json(['success' => false, 'message' => 'Le champ pret_id est requis pour un remboursement'], 400);
                return;
            }

            // Ajouter les fonds
            $this->fondModel->addFunds(
                $data['banque_id'], 
                $data['montant'], 
                $data['type_mouvement_id'],
                $data['pret_id'] ?? null
            );

            Flight::json([
                'success' => true,
                'message' => 'Opération sur les fonds enregistrée avec succès'
            ]);
            
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de l\'opération sur les fonds',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Nouvelle méthode pour consulter les mouvements
    public function getMovements($banque_id, $page = 1, $perPage = 10, $type_mouvement = null) {
        try {
            $result = $this->fondModel->getMovementsByBank($banque_id, $page, $perPage, $type_mouvement);
            
            return [
                'success' => true,
                'data' => $result
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur récupération mouvements',
                'error' => $e->getMessage()
            ];
        }
    }

    public function getAllBanks() {
        try {
            $banques = $this->fondModel->getAllBanks();
            
            return [
                'success' => true,
                'data' => $banques
            ];
            
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Erreur récupération banques',
                'error' => $e->getMessage()
            ];
        }
    }
}