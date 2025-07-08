<?php 
class MouvementFondController {
    private $fondModel;

    public function __construct($db) {
        $this->fondModel = new FondEtablissementModel($db);
    }

    public function addFunds() {
        $data = Flight::request()->data;
        
        try {
            // Validation
            $required = ['banque_id', 'montant', 'type_mouvement_id'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    Flight::json(['success' => false, 'message' => "Champ $field manquant"], 400);
                    return;
                }
            }

            // Types valides pour augmentation (1: remboursement, 2: ajout de fonds)
            if (!in_array($data['type_mouvement_id'], [1, 2])) {
                Flight::json(['success' => false, 'message' => 'Type de mouvement invalide'], 400);
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
                'message' => 'Fonds ajoutés avec succès'
            ]);
            
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur ajout fonds',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}