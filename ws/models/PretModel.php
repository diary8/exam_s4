<?php

class PretModel{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll(){
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

 public function create($data) {
        $query = "INSERT INTO pret (date_debut_pret, montant, banque_id, type_pret_id, client_id) 
                  VALUES (NOW(), :montant, :banque_id, :type_pret_id, :client_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':montant', $data['montant']);
        $stmt->bindParam(':banque_id', $data['banque_id'], PDO::PARAM_INT);
        $stmt->bindParam(':type_pret_id', $data['type_pret_id'], PDO::PARAM_INT);
        $stmt->bindParam(':client_id', $data['client_id'], PDO::PARAM_INT);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function clientHasPendingLoan($client_id) {
        $query = "SELECT COUNT(*) FROM pret WHERE client_id = :client_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}