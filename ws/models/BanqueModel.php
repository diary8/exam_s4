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


    public function getFontEtablissementId($id_banque)
    {
        $sql = "SELECT * FROM fond_etablissement WHERE banque_id = ? ";
        $result = null;
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id_banque]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $result['id'];
    }

    public function findClientBanqueAvecPret($banque_id)
    {
        $sql = "SELECT * FROM v_client_banque WHERE banque_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->excecute([$banque_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function enregistrerPayement($pret_id, $mois, $annee, $dateRemboursement, $id_banque)
    {
        $id_fond_etablissement = $this->getFontEtablissementId($id_banque);
        $mensualite = $this->getMesualitePret($pret_id);

        $sql = "INSERT INTO mouvement_fond (pret_id, type_mouvement_id, date_ustilisation, montant_utilise, fond_etablissement_id)
                VALUES (?, ?, ?, ?, ?)";

        if ($dateRemboursement == null) {
            throw new Exception("date remboursement null");
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                $pret_id,
                1,
                $dateRemboursement,
                $mensualite,
                $id_fond_etablissement
            ]);

            $mouvement_id = $this->db->lastInsertId();

            $sql = "INSERT INTO Remboursement (mouvement_fond_id, mois, annee) VALUES (?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$mouvement_id, $mois, $annee]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getTauxAnuelPret($id_pret)
    {
        $sql = "SELECT type_pret.taux FROM pret 
                JOIN type_pret ON pret.type_pret_id = type_pret.id 
                WHERE pret.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_pret]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['taux'] : null;
    }

    public function getTauxMensuekPret($id_pret)
    {
        $taux_annuel = $this->getTauxAnuelPret($id_pret);
        $taux_mensuel = $taux_annuel / 12;
        return $taux_mensuel;
    }

    public function getTotalARembourser($id_pret){
        $info_pret = $this->getInfoPret($id_pret);
        $duree = $info_pret['duree_mois'];
        $mensualite = $this->getMesualitePret($id_pret);
        return $mensualite*$duree;
    }

    public function getMesualitePret($id_pret)
    {
        $sql = "SELECT * FROM statut_pret WHERE pret_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_pret]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) return null;

        // $duree_mois = $result['duree_mois'];
        // $montant = $result['montant'];
        // $taux_mensuel = $this->getTauxMensuekPret($id_pret);
        return $result['mensualite'];
        // return ($montant * $taux_mensuel) / (1 - pow(1 + $taux_mensuel, -$duree_mois));
    }



    public function getInfoPret($id_pret)
    {
        $sql = "SELECT * FROM pret WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_pret]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRenboursmentPret($id_pret)
    {
        $sql = "SELECT * FROM Remboursement r 
        JOIN mouvement_fond mf ON mf.id = r.mouvement_fond_id
        WHERE mf.pret_id = ?
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id_pret]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findTableauRemboursement($id_pret)
    {
        $info_pret = $this->getInfoPret($id_pret);
        $mensualite = $this->getMesualitePret($id_pret);
        $date_debut = $info_pret['date_debut_pret'];
        $duree = $info_pret['duree_mois'];

        $echeances = [];
        $date = new DateTime($date_debut);
        for ($i = 0; $i < $duree; $i++) {
            $mois = $date->format('Y-m');
            $echeances[$mois] = [
                'date' => $date->format('Y-m-d'),
                'montant' => round($mensualite, 2),
                'statut' => 'Non payé'
            ];
            $date->modify('+1 month');
        }

        $remboursements = $this->getRenboursmentPret($id_pret);
        if ($remboursements == null) {
            $remboursements = [];
        }
        foreach ($remboursements as $r) {
            $annee = $r['annee'];
            $mois = str_pad($r['mois'], 2, "0", STR_PAD_LEFT);

            $cle = "{$annee}-{$mois}";

            if (isset($echeances[$cle])) {
                $echeances[$cle]['statut'] = 'Payé';
            }
        }

        return $echeances;
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
