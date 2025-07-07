<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demandes de Prêt</title>
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
    <style>
        .form-container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .status-pending { color: orange; font-weight: bold; }
        .status-approved { color: green; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
        .actions-cell { white-space: nowrap; }
        .btn-return {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="FormPret.php" class="btn btn-secondary btn-return">
            ← Retour au formulaire de prêt
        </a>
        
        <div class="form-container">
            <h2 class="text-center mb-4">Liste des Demandes de Prêt</h2>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Montant</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th>Date Demande</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="demandesTable">
                        <!-- Les données seront chargées ici via JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="../../assets/js/app.min.js">
    <script>
        const apiBase = "http://localhost/git/exam_s4/ws";

        // Charger les demandes
        function chargerDemandes() {
            fetch(`${apiBase}/demandes_pret`)
                .then(response => {
                    if (!response.ok) throw new Error("Erreur réseau");
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        afficherDemandes(data.data);
                    } else {
                        throw new Error(data.message || "Erreur de données");
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    alert("Erreur lors du chargement: " + error.message);
                });
        }

      function afficherDemandes(demandes) {
    const tbody = document.getElementById("demandesTable");
    tbody.innerHTML = "";

    if (demandes.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center">Aucune demande trouvée</td>
            </tr>
        `;
        return;
    }

    demandes.forEach(demande => {
        const tr = document.createElement("tr");
        
        // Style selon statut
        let statusClass = "";
        if (demande.statut === "En attente" || demande.statut === "En cours") {
            statusClass = "status-pending";
        } else if (demande.statut === "Approuvé") {
            statusClass = "status-approved";
        } else if (demande.statut === "Refusé") {
            statusClass = "status-rejected";
        }

        tr.innerHTML = `
            <td>${demande.id}</td>
            <td>${demande.montant} €</td>
            <td>${demande.type_pret}</td>
            <td class="${statusClass}">${demande.statut}</td>
            <td>${new Date(demande.date_demande).toLocaleDateString()}</td>
            <td class="actions-cell">
                ${(demande.statut === "En attente" || demande.statut === "En cours") ? `
                <button class="btn btn-sm btn-success me-2" 
                        onclick="traiterDemande(${demande.id}, 'approve', ${demande.banque_id}, ${demande.client_id}, ${demande.type_pret_id}, ${demande.montant})">
                    Accepter
                </button>
                <button class="btn btn-sm btn-danger" 
                        onclick="traiterDemande(${demande.id}, 'reject', ${demande.banque_id}, ${demande.client_id}, ${demande.type_pret_id}, ${demande.montant})">
                    Rejeter
                </button>
                ` : '<span class="text-muted">Terminé</span>'}
            </td>
        `;
        tbody.appendChild(tr);
    });
}

// Modifiez aussi la fonction traiterDemande
function traiterDemande(demandeId, action, banqueId, clientId, typePretId, montant) {
    if (!confirm(`Voulez-vous vraiment ${action === 'approve' ? 'accepter' : 'rejeter'} cette demande ?`)) {
        return;
    }

    // Préparation des données
    const data = {
        banque_id: banqueId,
        client_id: clientId,
        type_pret_id: typePretId,
        montant: montant
    };

    // Envoi de la requête
    fetch(`${apiBase}/demandes_pret/${demandeId}/${action}`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) throw new Error("Erreur serveur");
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(`Demande ${action === 'approve' ? 'approuvée' : 'rejetée'} avec succès`);
            chargerDemandes(); // Actualiser le tableau
        } else {
            throw new Error(data.message || "Échec de l'opération");
        }
    })
    .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur: " + error.message);
    });
}

        // Chargement initial
        document.addEventListener("DOMContentLoaded", chargerDemandes);
    </script>
</body>
</html>