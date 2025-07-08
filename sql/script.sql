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


voici ma nouvelle structure de la base : CREATE TABLE fond_etablissement(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2)   NOT NULL,
   banque_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(banque_id) REFERENCES banque(id)
);


CREATE TABLE type_mouvement
(
   id INT AUTO_INCREMENT,
   nom VARCHAR(100), 
   PRIMARY KEY(id)
);

CREATE TABLE mouvement_fond(
   id INT AUTO_INCREMENT,
   type_mouvement_id INT NOT NULL,
   date_ustilisation DATE NOT NULL,
   montant_utilise DECIMAL(15,2)   NOT NULL,
   fond_etablissement_id INT NOT NULL,
   pret_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(fond_etablissement_id) REFERENCES fond_etablissement(id),
   FOREIGN KEY(type_mouvement_id) REFERENCES type_mouvement(id),
   FOREIGN KEY(pret_id) REFERENCES pret(id)
);CREATE TABLE pret(
   id INT AUTO_INCREMENT,
   date_debut_pret DATE NOT NULL,
   montant DECIMAL(15,2)   NOT NULL,
   banque_id INT NOT NULL,
   type_pret_id INT NOT NULL,
   client_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(banque_id) REFERENCES banque(id),
   FOREIGN KEY(type_pret_id) REFERENCES type_pret(id),
   FOREIGN KEY(client_id) REFERENCES client(id)
);quelles changement faire pour que tout marche comme avant sachant que dans type_mouvement, nous avons 1 pour remboursement, 2 pour ajouts de fonds et 3 pour pret avec 1 et 2 une augmentation des fonds de l'etablissement et une diminution dans le 3 