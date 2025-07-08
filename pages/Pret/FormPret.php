<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Prêt</title>
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Nouvelle Demande de Prêt</h2>
            <form id="formPret">
                <div class="mb-3">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="date_debut" required>
                </div>
                
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant</label>
                    <input type="number" step="0.01" class="form-control" id="montant" required>
                </div>
                
                <div class="mb-3">
                    <label for="banque" class="form-label">Banque</label>
                    <select class="form-select" id="banque" required>
                        <option value="">Chargement en cours...</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="type_pret" class="form-label">Type de prêt</label>
                    <select class="form-select" id="type_pret" required>
                        <option value="">Chargement en cours...</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="client" class="form-label">Client</label>
                    <select class="form-select" id="client" required>
                        <option value="">Chargement en cours...</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="duree_mois" class="form-label">Durée du prêt (mois)</label>
                    <input type="number" min="1" max="360" class="form-control" id="duree_mois" required>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        Soumettre la demande
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="../../assets/js/app.min.js"></script>
    <script>
        const apiBase = "http://localhost/git/exam_s4/ws";

           // Charger les options dynamiques
        function chargerOptions(endpoint, selectId) {
            fetch(`${apiBase}${endpoint}`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById(selectId);
                    select.innerHTML = '<option value="">Sélectionnez...</option>';
                    
                    const options = data.data || data;
                    options.forEach(item => {
                        const option = document.createElement("option");
                        option.value = item.id;
                        option.textContent = item.nom || `${item.prenom} ${item.nom}`;
                        select.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error(`Erreur chargement ${selectId}:`, error);
                    document.getElementById(selectId).innerHTML = '<option value="">Erreur de chargement</option>';
                });
        }


        // Gestion de la soumission
        document.getElementById("formPret").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const formData = {
                date_debut: document.getElementById("date_debut").value,
                montant: document.getElementById("montant").value,
                banque_id: document.getElementById("banque").value,
                type_pret_id: document.getElementById("type_pret").value,
                client_id: document.getElementById("client").value,
                duree_mois: document.getElementById("duree_mois").value // Nouveau champ
            };

            // Validation rapide
            if (!formData.date_debut || !formData.montant || !formData.banque_id || 
                !formData.type_pret_id || !formData.client_id || !formData.duree_mois) {
                alert("Tous les champs sont obligatoires");
                return;
                }

            // Envoi de la demande
            fetch(`${apiBase}/demandes_pret`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    montant: formData.montant,
                    type_pret_id: formData.type_pret_id,
                    client_id: formData.client_id,
                    banque_id: formData.banque_id,
                    duree_mois: formData.duree_mois 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirection vers la page des demandes après succès
                    window.location.href = "Demandes.php";
                } else {
                    alert("Erreur: " + (data.message || "Échec de la création"));
                }
            })
            .catch(error => {
                console.error("Erreur:", error);
                alert("Erreur lors de la soumission");
            });
        });

        // Chargement initial
        document.addEventListener("DOMContentLoaded", function() {
            chargerOptions("/banques", "banque");
            chargerOptions("/types_pret", "type_pret");
            chargerOptions("/clients", "client");
        });
    </script>
</body>
</html>