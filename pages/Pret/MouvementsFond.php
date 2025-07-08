<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mouvements de Fonds</title>
    <link rel="stylesheet" href="../../assets/css/styles.min.css">
    <style>
        .form-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .entree { color: green; font-weight: bold; }
        .sortie { color: red; font-weight: bold; }
        .filters { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Mouvements de Fonds</h2>
            
            <div class="filters row mb-4">
                <div class="col-md-4">
                    <label for="banque_id" class="form-label">Banque</label>
                    <select class="form-select" id="banque_id">
                        <option value="">Chargement...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="type_mouvement" class="form-label">Type de mouvement</label>
                    <select class="form-select" id="type_mouvement">
                        <option value="">Tous</option>
                        <option value="1">Remboursement</option>
                        <option value="2">Ajout de fonds</option>
                        <option value="3">Prêt</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary" onclick="chargerMouvements()">Filtrer</button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Sens</th>
                            <th>Prêt lié</th>
                            <th>Montant prêt</th>
                        </tr>
                    </thead>
                    <tbody id="mouvementsTable">
                        <!-- Les données seront chargées ici -->
                    </tbody>
                </table>
            </div>
            
            <nav aria-label="Pagination">
                <ul class="pagination justify-content-center mt-4" id="pagination">
                </ul>
            </nav>
        </div>
    </div>

    <script src="../../assets/js/app.min.js"></script>
    <script>
        const apiBase = "http://localhost/git/exam_s4/ws";
        let currentPage = 1;
        const perPage = 10;

        // Charger les banques
        function chargerBanques() {
            fetch(`${apiBase}/banques`)
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById("banque_id");
                    select.innerHTML = '<option value="">Toutes les banques</option>';
                    
                    data.data.forEach(banque => {
                        const option = document.createElement("option");
                        option.value = banque.id;
                        option.textContent = banque.nom;
                        select.appendChild(option);
                    });
                    
                    // Charger les mouvements après avoir chargé les banques
                    chargerMouvements();
                });
        }

        // Charger les mouvements
        function chargerMouvements() {
            const banqueId = document.getElementById("banque_id").value;
            const typeMouvement = document.getElementById("type_mouvement").value;
            
            if (!banqueId) return;
            
            let url = `${apiBase}/fonds/mouvements/${banqueId}?page=${currentPage}`;
            if (typeMouvement) url += `&type=${typeMouvement}`;
            
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        afficherMouvements(data.data.mouvements);
                        setupPagination(data.data.total, data.data.per_page);
                    } else {
                        throw new Error(data.message || "Erreur de chargement");
                    }
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    alert("Erreur: " + error.message);
                });
        }

        // Afficher les mouvements
        function afficherMouvements(mouvements) {
            const tbody = document.getElementById("mouvementsTable");
            tbody.innerHTML = "";
            
            if (mouvements.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center">Aucun mouvement trouvé</td>
                    </tr>
                `;
                return;
            }
            
            mouvements.forEach(mouvement => {
                const tr = document.createElement("tr");
                const sensClass = mouvement.sens_mouvement === 'ENTREE' ? 'entree' : 'sortie';
                
                tr.innerHTML = `
                    <td>${new Date(mouvement.date_mouvement).toLocaleDateString()}</td>
                    <td>${mouvement.type_mouvement}</td>
                    <td>${mouvement.montant_utilise} €</td>
                    <td class="${sensClass}">${mouvement.sens_mouvement}</td>
                    <td>${mouvement.pret_id ? 'Prêt #' + mouvement.pret_id : 'N/A'}</td>
                    <td>${mouvement.montant_pret ? mouvement.montant_pret + ' €' : 'N/A'}</td>
                `;
                tbody.appendChild(tr);
            });
        }

        // Pagination
        function setupPagination(total, perPage) {
            const totalPages = Math.ceil(total / perPage);
            const pagination = document.getElementById("pagination");
            pagination.innerHTML = "";
            
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement("li");
                li.className = `page-item ${i === currentPage ? 'active' : ''}`;
                li.innerHTML = `<a class="page-link" href="#" onclick="changePage(${i})">${i}</a>`;
                pagination.appendChild(li);
            }
        }

        function changePage(page) {
            currentPage = page;
            chargerMouvements();
            window.scrollTo(0, 0);
        }

        // Initialisation
        document.addEventListener("DOMContentLoaded", chargerBanques);
    </script>
</body>
</html>