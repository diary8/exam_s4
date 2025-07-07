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