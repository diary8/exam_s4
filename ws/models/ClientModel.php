<?php
class ClientModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "SELECT c.*, cc.montant 
                  FROM client c
                  JOIN compte_client cc ON c.compte_client_id = cc.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT c.*, cc.*,p.*
                  FROM client c
                  JOIN compte_client cc ON c.compte_client_id = cc.id
                  LEFT JOIN pret p ON p.client_id = c.id
                  WHERE c.id = :id ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getSolde($id){
        $query = "SELECT (c.montant - SUM(m.montant) AS solde
                    FROM compte_client c
                    JOIN mouvement_client m ON m.compte_client_id = c.id
                    WHERE c.id = :id ";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }

}