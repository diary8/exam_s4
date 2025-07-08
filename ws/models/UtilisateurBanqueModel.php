<?php

class UtilisateurBanqueModel{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function authenticate($email,$password){
        $sql = "SELECT * FROM utilisateur_banque WHERE email = ? AND mot_de_passe = ?";
        $result = null;
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$email,$password]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $result;
    }
}