<?php
class FondEtablissementModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function checkFunds($banque_id) {
        $query = "SELECT id, montant FROM fond_etablissement WHERE banque_id = :banque_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':banque_id', $banque_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateFundsForPret($banque_id, $montant, $pret_id) {
        $this->db->beginTransaction();
        
        try {
            // 1. Mettre à jour le fonds (diminution)
            $query = "UPDATE fond_etablissement 
                      SET montant = montant - :montant 
                      WHERE banque_id = :banque_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':banque_id', $banque_id);
            $stmt->execute();
            
            // 2. Récupérer l'ID du fonds
            $fond = $this->checkFunds($banque_id);
            
            // 3. Enregistrer le mouvement (type 3 = prêt)
            $query = "INSERT INTO mouvement_fond 
                      (type_mouvement_id, date_ustilisation, montant_utilise, fond_etablissement_id, pret_id) 
                      VALUES 
                      (3, NOW(), :montant, :fond_id, :pret_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':fond_id', $fond['id']);
            $stmt->bindParam(':pret_id', $pret_id);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    public function addFunds($banque_id, $montant, $type_mouvement_id, $pret_id = null) {
        $this->db->beginTransaction();
        
        try {
            // 1. Mettre à jour le fonds (augmentation)
            $query = "UPDATE fond_etablissement 
                      SET montant = montant + :montant 
                      WHERE banque_id = :banque_id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':banque_id', $banque_id);
            $stmt->execute();
            
            // 2. Récupérer l'ID du fonds
            $fond = $this->checkFunds($banque_id);
            
            // 3. Enregistrer le mouvement (type 1 ou 2)
            $query = "INSERT INTO mouvement_fond 
                      (type_mouvement_id, date_ustilisation, montant_utilise, fond_etablissement_id, pret_id) 
                      VALUES 
                      (:type_id, NOW(), :montant, :fond_id, :pret_id)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':type_id', $type_mouvement_id);
            $stmt->bindParam(':montant', $montant);
            $stmt->bindParam(':fond_id', $fond['id']);
            $stmt->bindParam(':pret_id', $pret_id, $pret_id ? PDO::PARAM_INT : PDO::PARAM_NULL);
            $stmt->execute();
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

     public function getMovementsByBank($banque_id, $page = 1, $perPage = 10, $type_mouvement = null) {
        $offset = ($page - 1) * $perPage;
        
        $query = "SELECT SQL_CALC_FOUND_ROWS
                    mf.id,
                    mf.date_ustilisation as date_mouvement,
                    mf.montant_utilise,
                    tm.nom as type_mouvement,
                    p.id as pret_id,
                    p.montant as montant_pret,
                    CASE 
                        WHEN tm.id IN (1, 2) THEN 'ENTREE'
                        WHEN tm.id = 3 THEN 'SORTIE'
                    END as sens_mouvement
                  FROM mouvement_fond mf
                  JOIN type_mouvement tm ON mf.type_mouvement_id = tm.id
                  LEFT JOIN pret p ON mf.pret_id = p.id
                  JOIN fond_etablissement fe ON mf.fond_etablissement_id = fe.id
                  WHERE fe.banque_id = :banque_id";
        
        if ($type_mouvement) {
            $query .= " AND mf.type_mouvement_id = :type_mouvement";
        }
        
        $query .= " ORDER BY mf.date_ustilisation DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':banque_id', $banque_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        
        if ($type_mouvement) {
            $stmt->bindParam(':type_mouvement', $type_mouvement, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $mouvements = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Récupérer le total
        $stmt = $this->db->query("SELECT FOUND_ROWS() as total");
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        return [
            'mouvements' => $mouvements,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage
        ];
    }

    public function getAllBanks() {
        $stmt = $this->db->query("SELECT id, nom FROM banque");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}