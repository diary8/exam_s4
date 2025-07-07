<?php
require_once __DIR__.'/../models/TypePretModel.php';

class TypePretController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new TypePretModel($db);
    }

    public function index()
    {
        
    }
    /**
     * Récupère tous les types de prêt
     */
    public function findAll()
    {
        try {
            $typesPret = $this->model->findAll();
            Flight::json(['success' => true,'data' => $typesPret]);
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des types de prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Récupère un type de prêt par son ID
     */
    public function findById($id)
    {
        try {
            $typePret = $this->model->findById($id);
            
            if ($typePret) {
                Flight::json([
                    'success' => true,
                    'data' => $typePret
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Type de prêt non trouvé'
                ], 404);
            }
        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération du type de prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crée un nouveau type de prêt
     */
    public function create()
    {
        try {
            $data = Flight::request()->data;
            
            // Validation minimale
            if (empty($data['nom'])) {
                Flight::json([
                    'success' => false,
                    'message' => 'Le nom est obligatoire'
                ], 400);
                return;
            }

            if (!isset($data['taux']) || !is_numeric($data['taux'])) {
                Flight::json([
                    'success' => false,
                    'message' => 'Le taux doit être un nombre'
                ], 400);
                return;
            }

            $id = $this->model->create([
                'nom' => $data['nom'],
                'taux' => $data['taux'],
                'description' => $data['description'] ?? null
            ]);

            Flight::json([
                'success' => true,
                'message' => 'Type de prêt créé avec succès',
                'id' => $id
            ], 201);

        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la création du type de prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Met à jour un type de prêt
     */
    public function update($id)
    {
        try {
            $data = Flight::request()->data;
            
            // Vérifie si le type existe
            $existing = $this->model->findById($id);
            if (!$existing) {
                Flight::json([
                    'success' => false,
                    'message' => 'Type de prêt non trouvé'
                ], 404);
                return;
            }

            // Validation minimale
            if (empty($data['nom'])) {
                Flight::json([
                    'success' => false,
                    'message' => 'Le nom est obligatoire'
                ], 400);
                return;
            }

            $success = $this->model->update([
                'id' => $id,
                'nom' => $data['nom'],
                'taux' => $data['taux'],
                'description' => $data['description'] ?? null
            ]);

            if ($success) {
                Flight::json([
                    'success' => true,
                    'message' => 'Type de prêt mis à jour avec succès'
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Aucune modification effectuée'
                ]);
            }

        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour du type de prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Supprime un type de prêt
     */
    public function delete($id)
    {
        try {
            // Vérifie si le type existe
            $existing = $this->model->findById($id);
            if (!$existing) {
                Flight::json([
                    'success' => false,
                    'message' => 'Type de prêt non trouvé'
                ], 404);
                return;
            }

            $success = $this->model->delete($id);

            if ($success) {
                Flight::json([
                    'success' => true,
                    'message' => 'Type de prêt supprimé avec succès'
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'Erreur lors de la suppression'
                ]);
            }

        } catch (Exception $e) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la suppression du type de prêt',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}