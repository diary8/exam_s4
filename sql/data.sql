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

-- Demandes de prêt
INSERT INTO demande_pret (montant, date_demande, type_pret_id) VALUES 
(20000.00, '2025-06-01', 3),
(50000.00, '2025-06-10', 1);

-- Statuts des demandes
INSERT INTO status_demande (date_changement, demande_pret_id, statut_id) VALUES 
('2025-06-02', 1, 1),  -- En attente
('2025-06-11', 2, 2);  -- Approuvée

-- Fonds établissement
INSERT INTO fond_etablissement (montant, banque_id) VALUES 
(1000000.00, 1),
(500000.00, 2);

-- Mouvements des fonds
INSERT INTO mouvement_fond (date_ustilisation, montant_utilise, fond_etablissement_id) VALUES 
('2025-07-01', 25000.00, 1),
('2025-07-05', 10000.00, 2);

-- Utilisateurs banque
INSERT INTO utilisateur_banque (nom, email, mot_de_passe, banque_id) VALUES 
('Admin Banque Centrale', 'admin1@central.com', 'adminpass', 1),
('Employé Banque Populaire', 'employe@populaire.com', 'emp123', 2);


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
INSERT INTO client (nom, email, telephone, adresse, mot_de_passe, date_de_naissance, compte_client_id) VALUES
('Jean Dupont', 'jean.dupont@email.com', '0612345678', '12 rue de Paris, 75001', 'mdp123', '1985-05-15', 1),
('Marie Lambert', 'marie.lambert@email.com', '0698765432', '34 avenue Victor Hugo, 69002', 'mdp456', '1990-07-22', 2),
('Pierre Martin', 'pierre.martin@email.com', '0711223344', '56 boulevard Voltaire, 13003', 'mdp789', '1978-11-30', 3),
('Sophie Bernard', 'sophie.bernard@email.com', '0622334455', '78 rue de la République, 31000', 'mdpabc', '1982-03-10', 4),
('Thomas Petit', 'thomas.petit@email.com', '0644556677', '90 chemin des Oliviers, 06000', 'mdpdef', '1995-09-18', 5),
('Laura Durand', 'laura.durand@email.com', '0766554433', '32 rue Pasteur, 44000', 'mdpghi', '1988-12-05', 6),
('Nicolas Leroy', 'nicolas.leroy@email.com', '0688776655', '45 avenue Foch, 59000', 'mdpjkl', '1975-06-25', 7),
('Emma Moreau', 'emma.moreau@email.com', '0799887766', '67 boulevard Gambetta, 33000', 'mdpmno', '1992-04-12', 8);

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