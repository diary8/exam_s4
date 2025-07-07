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
            $result = $stmt->execute([$email,$password]);
        } catch (\Throwable $th) {
            throw $th;
        }
        return $result;
    }
}