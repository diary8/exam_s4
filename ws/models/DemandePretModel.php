<?php
class DemandePretModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

  public function create(array $data) {
    $query = "INSERT INTO demande_pret 
              (montant, type_pret_id, banque_id, client_id, date_demande) 
              VALUES 
              (:montant, :type_pret_id, :banque_id, :client_id, NOW())";
    
    $stmt = $this->db->prepare($query);
    $stmt->bindParam(':montant', $data['montant']);
    $stmt->bindParam(':type_pret_id', $data['type_pret_id']);
    $stmt->bindParam(':banque_id', $data['banque_id']);
    $stmt->bindParam(':client_id', $data['client_id']);
    
    return $stmt->execute() ? $this->db->lastInsertId() : false;
}

public function findAll() {
    $query = "SELECT dp.id, dp.montant, dp.date_demande, 
                     dp.banque_id, dp.client_id, dp.type_pret_id,
                     tp.nom as type_pret, 
                     s.nom as statut, 
                     sd.date_changement
              FROM demande_pret dp
              JOIN type_pret tp ON dp.type_pret_id = tp.id
              JOIN status_demande sd ON dp.id = sd.demande_pret_id
              JOIN status s ON sd.statut_id = s.id
              WHERE sd.id = (
                  SELECT MAX(id) FROM status_demande 
                  WHERE demande_pret_id = dp.id
              )";
    $stmt = $this->db->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}