-- Banque
INSERT INTO banque (nom) VALUES 
('Banque Centrale'), 
('Banque Populaire'), 
('Banque Internationale');

-- Type de prêt
INSERT INTO type_pret (nom, taux, description) VALUES 
('Crédit Immobilier', 3.50, 'Prêt pour achat immobilier'),
('Crédit Automobile', 5.00, 'Prêt pour achat de voiture'),
('Crédit Personnel', 6.75, 'Prêt à la consommation');

-- Statuts de demande
INSERT INTO status (nom) VALUES 
('En attente'), 
('Approuvée'), 
('Rejetée');

-- Statuts client
INSERT INTO status_client (nom) VALUES 
('Actif'), 
('Inactif');

-- Comptes clients
INSERT INTO compte_client (montant) VALUES 
(5000.00), 
(12000.50), 
(1500.75);

-- Clients
INSERT INTO client (nom, email, mot_de_passe, date_de_naissance, compte_client_id) VALUES 
('Jean Dupont', 'jean@example.com', 'mdp123', '1990-05-14', 1),
('Fatou Ndiaye', 'fatou@example.com', 'motdepasse', '1985-09-23', 2),
('Ali Omar', 'ali@example.com', 'securepwd', '2000-01-10', 3);

-- Mouvements client
INSERT INTO mouvement_client (date_, montant, description, compte_client_id) VALUES 
('2025-07-01', -200.00, 'Paiement facture eau', 1),
('2025-07-03', 1000.00, 'Virement salaire', 2),
('2025-07-05', -150.00, 'Paiement internet', 3);

-- Prêts
INSERT INTO pret (date_debut_pret, montant, banque_id, type_pret_id, client_id) VALUES 
('2025-01-10', 100000.00, 1, 1, 1),
('2025-02-15', 15000.00, 2, 2, 2);


-- Fonds établissement
INSERT INTO fond_etablissement (montant, banque_id) VALUES 
(1000000.00, 1),
(500000.00, 2);

-- Mouvements des fonds
INSERT INTO mouvement_fond (date_ustilisation, montant_utilise, fond_etablissement_id,) VALUES 
('2025-07-01', 25000.00, 1),
('2025-07-05', 10000.00, 2);

-- Utilisateurs banque
INSERT INTO utilisateur_banque (nom, email, mot_de_passe, banque_id) VALUES 
('Admin Banque Centrale', 'admin1@central.com', 'adminpass', 1),
('Employé Banque Populaire', 'employe@populaire.com', 'emp123', 2);

INSERT INTO fond_etablissement (montant, banque_id) VALUES 
(1000000000.00, 3);

INSERT INTO type_mouvement (nom) VALUES 
('Remboursement'),
('Ajouts Fonds'),
('pret');