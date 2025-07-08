<?php
require_once __DIR__ . '/../db.php';

class TypePretModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Récupère tous les types de prêt
     * @return array
     */
    public function findAll()
    {
        $query = "SELECT * FROM type_pret";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un type de prêt par son ID
     * @param int $id
     * @return array|null
     */
    public function findById($id)
    {
        $query = "SELECT * FROM type_pret WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Crée un nouveau type de prêt
     * @param array $data
     * @return int L'ID du nouveau type de prêt
     */
    public function create($data)
    {
        $query = "INSERT INTO type_pret (nom, taux, description) 
                  VALUES (:nom, :taux, :description)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':taux', $data['taux']);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    /**
     * Met à jour un type de prêt existant
     * @param array $data Doit contenir l'id
     * @return bool
     */
    public function update($data)
    {
        $query = "UPDATE type_pret SET 
                  nom = :nom, 
                  taux = :taux, 
                  description = :description 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
        $stmt->bindParam(':taux', $data['taux']);
        $stmt->bindParam(':description', $data['description'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Supprime un type de prêt
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $query = "DELETE FROM type_pret WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}