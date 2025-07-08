<?php
require_once __DIR__ . '/../models/BanqueModel.php';
require_once __DIR__ . '/../models/PretModel.php';

class BanqueController
{
    private $banqueModel;
    private $pretModel;

    public function __construct($db)
    {
        $this->banqueModel = new BanqueModel($db);
        $this->pretModel = new PretModel($db);
    }

    public function findAll()
    {
        try {
            $banques = $this->banqueModel->findAll();
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
            $banque = $this->banqueModel->findById($id);
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


    public function findPretBanque()
    {

        $id_banque = ($_SESSION['banque_id'] == null) ? 1 : $_SESSION['banque_id'];
        try {
            $result = $this->pretModel->findPretBanque($id_banque);
            if ($result) {
                Flight::json([
                    'success' => true,
                    'liste_pret' => $result
                ]);
            } else {
                Flight::json([
                    'success' => false,
                    'message' => 'liste non trouvée'
                ], 404);
            }
        } catch (\Throwable $th) {
            Flight::json([
                'success' => false,
                'message' => 'Erreur lors de la récupération de les pret',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    public function findIntererMensuel()
    {
        $data = Flight::request()->query;
        $data_is_ok = isset($data->moisDebut, $data->anneeDebut, $data->moisFin, $data->anneeFin);
        if ($data && $data_is_ok) {
            $moisDebut = $data->moisDebut;
            $anneeDebut = $data->anneeDebut;
            $moisFin = $data->moisFin;
            $anneeFin = $data->anneeFin;

            // $id_banque = $_SESSION['id_banque'];
            $id_banque = 1;
            $result = $this->banqueModel->findInteretMoisBetween($id_banque, $moisDebut, $anneeDebut, $moisFin, $anneeFin);
            if ($result) {
                Flight::json([
                    'success' => true,
                    'message' => 'recupérer avec success',
                    'interer_mensuel' => $result
                ], 200);
                return;
            } else {
                Flight::json([
                    'success' => false,
                    'message' => "aucun donnée disponible"
                ], 401);
                return;
            }
        } else {
            Flight::json([
                'success' => false,
                'message' => 'champs de filtre complet requis'
            ], 400);
        }
    }
}
