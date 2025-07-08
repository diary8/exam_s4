<?php

use PDO;

class PretModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findByIdDetails($idPret){
        $sql = "SELECT pret.*,client.nom,client.email,type_pret.taux,statut_pret.mensualite  FROM pret 
        JOIN client ON client.id = pret.client_id 
        JOIN type_pret ON type_pret.id = pret.type_pret_id
        JOIN statut_pret ON statut_pret.pret_id = pret.id
        WHERE pret.id = ?
        
        ";
        $result = null;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPret]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($idPret){
        $sql = "SELECT * FROM pret WHERE id = ?";
        $result = null;
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPret]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findAll()
    {
        $sql = "SELECT * FROM v_pret";
        $result = [];
        try {
            $stmt = $this->db->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $result;
    }

    public function findPretBanque($banque_id)
    {
        $sql = "SELECT pret.*,mf.*,sp.montant_prete,sp.montant_rembourse,client.nom AS nom_client,client.email AS email_client FROM pret 
            JOIN mouvement_fond mf ON mf.pret_id = pret.id 
            JOIN statut_pret sp ON sp.pret_id = pret.id
            JOIN client ON client.id = sp.client_id
            WHERE pret.banque_id = ? 
            AND mf.type_mouvement_id = 3
        ";

        // $sql = "SELECT 
        //             pret.*,
        //             mf.*,
        //             pret.montant AS montant_prete,
        //             client.nom AS nom_client,
        //             client.email AS email_client,
        //         JOIN mouvement_fond mf ON mf.pret_id = pret.id
        //         JOIN client ON client.id = pret.client_id
        //         WHERE pret.banque_id = ?
        //         AND mf.type_mouvement_id = 3
        // ";

        $result = [];
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$banque_id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $result;
    }

    public function create($data)
    {
        $query = "INSERT INTO pret (date_debut_pret, montant, banque_id, type_pret_id, client_id) 
                  VALUES (:date_debut, :montant, :banque, :type_pret, :client)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date_debut', $data['date_debut'], PDO::PARAM_STR);
        $stmt->bindParam(':montant', $data['montant']);
        $stmt->bindParam(':banque', $data['banque'], PDO::PARAM_STR);
        $stmt->bindParam(':type_pret', $data['type_pret'], PDO::PARAM_STR);
        $stmt->bindParam(':client', $data['client'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}
