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

 public function create(array $data) {
    $query = "INSERT INTO pret 
              (montant, date_debut_pret, banque_id, type_pret_id, client_id, duree_mois) 
              VALUES 
              (:montant, :date_debut, :banque_id, :type_pret_id, :client_id, :duree_mois)";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':montant', $data['montant']);
    $stmt->bindParam(':date_debut', $data['date_debut_pret']);
    $stmt->bindParam(':banque_id', $data['banque_id']);
    $stmt->bindParam(':type_pret_id', $data['type_pret_id']);
    $stmt->bindParam(':client_id', $data['client_id']);
    $stmt->bindParam(':duree_mois', $data['duree_mois'], PDO::PARAM_INT);
    
    return $stmt->execute() ? $this->db->lastInsertId() : false;
}

    public function clientHasPendingLoan($client_id) {
        $query = "SELECT COUNT(*) FROM pret WHERE client_id = :client_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':client_id', $client_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}