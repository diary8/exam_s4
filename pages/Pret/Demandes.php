<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">

    <div class="container-fluid px-4 py-4">
        <div class="d-flex justify-content-start mb-3">
            <a href="ajout-pret.php" class="btn btn-outline-secondary">
                ← Retour au formulaire de prêt
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Liste des Demandes de Prêt</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>ID</th>
                                <th>Montant</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th>Date Demande</th>
                                <th>Durée (mois)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="demandesTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="../../assets/js/app.min.js">
<?php include include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script>
    const apiBase = "http://localhost/exam_s4/ws";

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
                <td colspan="7" class="text-center">Aucune demande trouvée</td>
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
            <td>${demande.duree_mois || 'N/A'} mois</td>
            <td class="actions-cell">
                ${(demande.statut === "En attente" || demande.statut === "En cours") ? `
                <button class="btn btn-sm btn-success me-2" 
                        onclick="traiterDemande(${demande.id}, 'approve', ${demande.banque_id}, ${demande.client_id}, ${demande.type_pret_id}, ${demande.montant}, ${demande.duree_mois})">
                    Accepter
                </button>
                <button class="btn btn-sm btn-danger" 
                        onclick="traiterDemande(${demande.id}, 'reject', ${demande.banque_id}, ${demande.client_id}, ${demande.type_pret_id}, ${demande.montant}, ${demande.duree_mois})">
                    Rejeter
                </button>
                ` : '<span class="text-muted">Terminé</span>'}
            </td>
        `;
            tbody.appendChild(tr);
        });
    }

    // Modifiez aussi la fonction traiterDemande
    function traiterDemande(demandeId, action, banqueId, clientId, typePretId, montant, dureeMois) {
        if (!confirm(`Voulez-vous vraiment ${action === 'approve' ? 'accepter' : 'rejeter'} cette demande ?`)) {
            return;
        }

        // Préparation des données
        const data = {
            banque_id: banqueId,
            client_id: clientId,
            type_pret_id: typePretId,
            montant: montant,
            duree_mois: dureeMois
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