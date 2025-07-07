<?php

require_once __DIR__ . '/../models/BanqueModel.php';
require_once __DIR__ . '/../helpers/Utils.php';


class BanqueController
{
    private $banqueModel;

    public function __construct($db)
    {
        $this->banqueModel = new BanqueModel($db);
    }

    public function findIntererMensuel()
    {
        // $data = Flight::request()


        $id_banque = $_SESSION['id_banque'];
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
    }
}
