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

-- Fonds établissement
INSERT INTO fond_etablissement (montant, banque_id) VALUES 
(1000000.00, 1),
(500000.00, 2);

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

INSERT INTO compte_client (montant) VALUES
(125000.00), -- id = 1 (Jean Dupont)
(87500.00),  -- id = 2 (Fatou Ndiaye)
(96000.00),  -- id = 3 (Ali Omar)
(105000.00), -- id = 4
(72000.00),  -- id = 5
(138500.00), -- id = 6
(64300.00),  -- id = 7
(112000.00), -- id = 8
(99750.00),  -- id = 9
(83000.00),  -- id = 10
(91000.00),  -- id = 11
(101200.00), -- id = 12
(110000.00); -- id = 13

INSERT INTO client (nom, email, mot_de_passe, date_de_naissance, compte_client_id) VALUES
('Marie Tchoumba', 'marie.tchou@example.com', 'marie1234', '1992-11-30', 4),
('Ahmed Saleh', 'ahmed.saleh@example.com', 'ahmedpwd', '1988-07-19', 5),
('Brigitte Nkot', 'brigitte.nkot@example.com', 'nkotpass', '1995-03-22', 6),
('David Kim', 'david.kim@example.com', 'dkim321', '1999-12-05', 7),
('Amina Hassan', 'amina.hassan@example.com', 'hassan123', '1983-04-17', 8),
('Jonas Mvula', 'jonas.mvula@example.com', 'mvulapass', '1978-08-09', 9),
('Noura El Fassi', 'noura.elfassi@example.com', 'noura2023', '1996-06-01', 10),
('Eric Kouadio', 'eric.kouadio@example.com', 'ekouadio', '1991-02-28', 11),
('Lucie Dlamini', 'lucie.dlamini@example.com', 'luciedl', '2001-10-13', 12),
('William Okeke', 'will.okeke@example.com', 'willok2024', '1993-01-07', 13);

INSERT INTO pret (date_debut_pret, montant, banque_id, type_pret_id, client_id) VALUES
('2025-03-05', 50000.00, 1, 1, 3),
('2025-03-25', 25000.00, 1, 2, 4),
('2025-04-10', 75000.00, 1, 3, 5),
('2025-04-20', 32000.00, 1, 1, 6),
('2025-05-02', 120000.00, 1, 2, 7),
('2025-05-15', 30000.00, 1, 3, 8),
('2025-06-01', 10000.00, 1, 1, 9),
('2025-06-18', 20000.00, 1, 2, 10),
('2025-07-04', 88000.00, 1, 3, 11),
('2025-07-12', 45000.00, 1, 1, 12),
('2025-07-25', 110000.00, 1, 2, 13);
