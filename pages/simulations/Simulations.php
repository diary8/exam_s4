<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulation de Prêt</title>
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
        .result-container {
            margin-top: 30px;
            padding: 20px;
            border: 1px solid #28a745;
            border-radius: 5px;
            background-color: #f0fff4;
            display: none;
        }
        .taux-info {
            font-size: 0.9em;
            color: #6c757d;
            font-style: italic;
        }
        .loading {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Simulation de Prêt</h2>
            <form id="formSimulation">
                <div class="mb-3">
                    <label for="type_pret" class="form-label">Type de prêt</label>
                    <select class="form-select" id="type_pret" required disabled>
                        <option value="">Chargement des types de prêt...</option>
                    </select>
                    <div class="taux-info">Le taux annuel est indiqué entre parenthèses</div>
                </div>
                
                <div class="mb-3">
                    <label for="montant" class="form-label">Montant du prêt (€)</label>
                    <input type="number" min="1000" step="100" class="form-control" id="montant" required>
                </div>
                
                <div class="mb-3">
                    <label for="duree_mois" class="form-label">Durée de remboursement (mois)</label>
                    <input type="number" min="12" max="360" class="form-control" id="duree_mois" required>
                    <div class="taux-info">Entre 1 et 30 ans (12 à 360 mois)</div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary" id="btn-calculer" disabled>
                        Calculer la mensualité
                    </button>
                </div>
            </form>
            
            <div id="resultat" class="result-container">
                <h4 class="text-center">Résultat de la simulation</h4>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <p><strong>Mensualité :</strong></p>
                        <p><strong>Coût total :</strong></p>
                        <p><strong>Taux annuel :</strong></p>
                        <p><strong>Coût des intérêts :</strong></p>
                    </div>
                    <div class="col-md-6">
                        <p id="mensualite">-</p>
                        <p id="cout_total">-</p>
                        <p id="taux_annuel">-</p>
                        <p id="cout_interets">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const apiBase = "http://localhost/git/exam_s4/ws";

        // Charger les types de prêt depuis l'API
        function chargerTypesPret() {
            const select = document.getElementById("type_pret");
            select.innerHTML = '<option value="">Chargement en cours...</option>';
            
            fetch(`${apiBase}/types_pret`)
                .then(response => {
                    if (!response.ok) throw new Error("Erreur de réseau");
                    return response.json();
                })
                .then(data => {
                    if (!data.success) throw new Error(data.message || "Erreur de données");
                    
                    select.innerHTML = '<option value="">Sélectionnez un type...</option>';
                    
                    data.data.forEach(type => {
                        const option = document.createElement("option");
                        option.value = type.id;
                        option.textContent = `${type.nom} (${type.taux}%)`;
                        option.setAttribute('data-taux', type.taux);
                        select.appendChild(option);
                    });
                    
                    select.disabled = false;
                    document.getElementById("btn-calculer").disabled = false;
                })
                .catch(error => {
                    console.error("Erreur:", error);
                    select.innerHTML = '<option value="">Erreur de chargement</option>';
                    // Options de secours statiques
                    const optionsSecours = [
                        {id: 1, nom: "Prêt Personnel", taux: 5},
                        {id: 2, nom: "Prêt Immobilier", taux: 3},
                        {id: 3, nom: "Prêt Automobile", taux: 7}
                    ];
                    
                    optionsSecours.forEach(type => {
                        const option = document.createElement("option");
                        option.value = type.id;
                        option.textContent = `${type.nom} (${type.taux}%)`;
                        option.setAttribute('data-taux', type.taux);
                        select.appendChild(option);
                    });
                    
                    select.disabled = false;
                    document.getElementById("btn-calculer").disabled = false;
                });
        }

        // Calcul de la mensualité
        document.getElementById("formSimulation").addEventListener("submit", function(e) {
            e.preventDefault();
            
            const typePret = document.getElementById("type_pret");
            const selectedOption = typePret.options[typePret.selectedIndex];
            
            if (!selectedOption.value) {
                alert("Veuillez sélectionner un type de prêt");
                return;
            }
            
            const tauxAnnuel = parseFloat(selectedOption.getAttribute('data-taux')) / 100;
            const montant = parseFloat(document.getElementById("montant").value);
            const dureeMois = parseInt(document.getElementById("duree_mois").value);
            
            if (isNaN(montant)) {
                alert("Veuillez entrer un montant valide");
                return;
            }
            
            if (isNaN(dureeMois)) {
                alert("Veuillez entrer une durée valide");
                return;
            }

            // Calculs financiers
            const tauxMensuel = tauxAnnuel / 12;
            const mensualite = (montant * tauxMensuel) / (1 - Math.pow(1 + tauxMensuel, -dureeMois));
            const coutTotal = mensualite * dureeMois;
            const coutInterets = coutTotal - montant;

            // Affichage des résultats
            document.getElementById("mensualite").textContent = mensualite.toFixed(2) + " €";
            document.getElementById("cout_total").textContent = coutTotal.toFixed(2) + " €";
            document.getElementById("taux_annuel").textContent = (tauxAnnuel * 100).toFixed(2) + " %";
            document.getElementById("cout_interets").textContent = coutInterets.toFixed(2) + " €";
            
            // Afficher le résultat
            document.getElementById("resultat").style.display = "block";
        });

        // Initialisation au chargement de la page
        document.addEventListener("DOMContentLoaded", chargerTypesPret);
    </script>
</body>
</html>