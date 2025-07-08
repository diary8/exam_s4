CREATE OR REPLACE VIEW v_pret AS (
    SELECT 
        pret.*,
        type_pret.nom AS nom_type_pret,
        type_pret.taux,
        client.nom AS nom_client
    FROM pret
    JOIN type_pret ON pret.type_pret_id = type_pret.id
    JOIN client ON client.id = pret.client_id
);


CREATE OR REPLACE VIEW v_client_banque AS (
    SELECT
        ROW_NUMBER() OVER (ORDER BY client.id,banque.id) AS row_num,
        client.id AS client_id,
        client.nom,
        client.email,
        client.date_de_naissance,
        client.compte_client_id,
        banque.id AS banque_id,
        banque.nom AS banque
    FROM client 
    JOIN client_banque ON client.id = client_banque.client_id
    JOIN banque ON banque.id = client_banque.banque_id
);


CREATE OR REPLACE VIEW v_mouvement_pret AS
SELECT 
    ROW_NUMBER() OVER (ORDER BY pret.id, mf.id) AS row_num,
    pret.id AS pret_id,
    pret.date_debut_pret,
    pret.montant,
    pret.banque_id,
    pret.type_pret_id,
    pret.client_id,
    mf.date_ustilisation,
    mf.montant_utilise,
    mf.fond_etablissement_id
FROM pret
JOIN mouvement_fond mf ON mf.pret_id = pret.id
WHERE mf.type_mouvement_id = 3;


CREATE OR REPLACE VIEW v_mouvement_remboursement AS
SELECT
    ROW_NUMBER() OVER (ORDER BY pret.id, mf.id) AS row_num,
    pret.id AS pret_id,
    pret.date_debut_pret,
    pret.montant,
    pret.banque_id,
    pret.type_pret_id,
    pret.client_id,
    mf.date_ustilisation,
    mf.montant_utilise,
    mf.fond_etablissement_id
FROM pret
JOIN mouvement_fond mf ON mf.pret_id = pret.id
WHERE mf.type_mouvement_id = 1;

CREATE OR REPLACE VIEW statut_pret AS
SELECT
    vp.pret_id,
    vp.date_debut_pret,
    vp.banque_id,
    vp.client_id,
    vp.montant AS montant_prete,
    COALESCE(SUM(vr.montant_utilise), 0) AS montant_rembourse
FROM v_mouvement_pret vp
LEFT JOIN v_mouvement_remboursement vr ON vr.pret_id = vp.pret_id
GROUP BY vp.pret_id, vp.date_debut_pret, vp.banque_id, vp.client_id, vp.montant;