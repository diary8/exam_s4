<?php
class FondEtablissementModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkFunds($banque_id) {
        $query = "SELECT montant FROM fond_etablissement WHERE banque_id = :banque_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':banque_id', $banque_id, PDO::PARAM_INT);
        $stmt->execute();
        $fond = $stmt->fetch(PDO::FETCH_ASSOC);
        return $fond;
    }

    public function updateFunds($banque_id, $montant) {
        $query = "UPDATE fond_etablissement 
                  SET montant = montant - :montant 
                  WHERE banque_id = :banque_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':montant', $montant);
        $stmt->bindParam(':banque_id', $banque_id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}