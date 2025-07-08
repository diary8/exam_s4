CREATE DATABASE banque;
USE banque;

CREATE TABLE type_pret(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   taux DECIMAL(15,2)   NOT NULL,
   description VARCHAR(100) ,
   PRIMARY KEY(id)
);

CREATE TABLE status(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE compte_client(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2)   NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE mouvement_client(
   id INT AUTO_INCREMENT,
   date_ DATE NOT NULL,
   montant DECIMAL(15,2)   NOT NULL,
   description VARCHAR(100) ,
   compte_client_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(compte_client_id) REFERENCES compte_client(id)
);

CREATE TABLE banque(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   PRIMARY KEY(id)
);

CREATE TABLE client(
   id INT AUTO_INCREMENT,
   nom VARCHAR(50)  NOT NULL,
   email VARCHAR(50)  NOT NULL,
   mot_de_passe VARCHAR(50)  NOT NULL,
   date_de_naissance DATE NOT NULL,
   compte_client_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(compte_client_id) REFERENCES compte_client(id)
);

CREATE TABLE pret(
   id INT AUTO_INCREMENT,
   date_debut_pret DATE NOT NULL,
   montant DECIMAL(15,2)   NOT NULL,
   banque_id INT NOT NULL,
   type_pret_id INT NOT NULL,
   client_id INT NOT NULL,
   duree_mois INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(banque_id) REFERENCES banque(id),
   FOREIGN KEY(type_pret_id) REFERENCES type_pret(id),
   FOREIGN KEY(client_id) REFERENCES client(id)
);

CREATE TABLE demande_pret(
   id INT AUTO_INCREMENT,
   montant DECIMAL(15,2)   NOT NULL,
   date_demande DATE NOT NULL,
   type_pret_id INT NOT NULL,
   banque_id INT NOT NULL,
   client_id INT NOT NULL,
   duree_mois INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(type_pret_id) REFERENCES type_pret(id),
   FOREIGN KEY (banque_id) REFERENCES banque(id),
   FOREIGN KEY (client_id) REFERENCES client(id)
);

CREATE TABLE status_demande(
   id INT AUTO_INCREMENT,
   date_changement DATE NOT NULL,
   demande_pret_id INT NOT NULL,
   statut_id INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(statut_id) REFERENCES status(id),
   FOREIGN KEY(demande_pret_id) REFERENCES demande_pret(id)
);

CREATE TABLE fond_etablissement(
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
);

CREATE TABLE status_client(
    id INT AUTO_INCREMENT,
    nom VARCHAR(20),
    PRIMARY KEY(id)
);

CREATE TABLE utilisateur_banque(
   id INT AUTO_INCREMENT,
   nom VARCHAR(120),
   email VARCHAR(120),
   mot_de_passe VARCHAR(120),
   banque_id INT NOT NULL, 
   PRIMARY KEY (id),
   FOREIGN KEY (banque_id) REFERENCES banque(id)
);

CREATE TABLE client_banque(
   id INT PRIMARY KEY AUTO_INCREMENT,
   client_id INT NOT NULL,
   banque_id INT NOT NULL,
   FOREIGN KEY (client_id) REFERENCES client(id),
   FOREIGN KEY (banque_id) REFERENCES banque(id)
);
