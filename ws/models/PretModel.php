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

        public function create($data)
    {
        $query = "INSERT INTO pret (date_debut_pret, montant, banque_id, type_pret_id, client_id) 
                  VALUES (:date_debut, :montant, :banque, :type_pret, :client)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':date_debut', $data['date_debut'], PDO::PARAM_STR);
        $stmt->bindParam(':montant', $data['montant']);
        $stmt->bindParam(':banque', $data['banque'], PDO::PARAM_STR);
        $stmt->bindParam(':type_pret', $data['type_pret'], PDO::PARAM_STR);
        $stmt->bindParam(':client', $data['client'], PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }
}