CREATE DATABASE tp_flight CHARACTER SET utf8mb4;

USE tp_flight;

CREATE TABLE etudiant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100),
    prenom VARCHAR(100),
    email VARCHAR(100),
    age INT
);

-- Demandes de prêt
INSERT INTO demande_pret (montant, date_demande, type_pret_id) VALUES 
(20000.00, '2025-06-01', 3),
(50000.00, '2025-06-10', 1);

-- Statuts des demandes
INSERT INTO status_demande (date_changement, demande_pret_id, statut_id) VALUES 
('2025-06-02', 1, 1),  -- En attente
('2025-06-11', 2, 2);  -- Approuvée