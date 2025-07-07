<?php
class StatusDemandeModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($demande_pret_id, $statut_id) {
        $query = "INSERT INTO status_demande (date_changement, demande_pret_id, statut_id) 
                  VALUES (NOW(), :demande_pret_id, :statut_id)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':demande_pret_id', $demande_pret_id, PDO::PARAM_INT);
        $stmt->bindParam(':statut_id', $statut_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}