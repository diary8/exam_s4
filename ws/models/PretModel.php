<?php

class PretModel{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll(){
        $sql = "SELECT * FROM pret";
        $result = [];
        try {
            $stmt = $this->db->query($sql);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $result;
    }
}