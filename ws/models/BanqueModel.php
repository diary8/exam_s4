<?php

use PDO;


class BanqueModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "SELECT * FROM banque";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $query = "SELECT * FROM banque WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findInteretMoisBetween($banque_id, $moisDebut, $anneeDebut, $moisFin, $anneeFin)
    {
        $sql = "
            SELECT
                b.nom AS banque,
                YEAR(p.date_debut_pret) AS annee,
                MONTH(p.date_debut_pret) AS mois,
                SUM(p.montant * tp.taux / 100 / 12) AS interet_mensuels
            FROM pret p
            JOIN type_pret tp ON p.type_pret_id = tp.id
            JOIN banque b ON p.banque_id = b.id
            WHERE p.banque_id = ?
            AND (
                (YEAR(p.date_debut_pret) > ? OR 
                 (YEAR(p.date_debut_pret) = ? AND MONTH(p.date_debut_pret) >= ?))
            )
            AND (
                (YEAR(p.date_debut_pret) < ? OR 
                 (YEAR(p.date_debut_pret) = ? AND MONTH(p.date_debut_pret) <= ?))
            )
            GROUP BY b.nom, annee, mois
            ORDER BY annee, mois;
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $banque_id,
                $anneeDebut,
                $anneeDebut,
                $moisDebut,
                $anneeFin,
                $anneeFin,
                $moisFin
            ]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

}

