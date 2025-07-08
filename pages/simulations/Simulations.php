<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
    <div class="body-wrapper-inner">
        <div class="container-fluid py-4 mt-5">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h4 class="mb-0">📊 Simulation de Prêt</h4>
                </div>
                <div class="card-body">
                    <form id="formSimulation" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="type_pret" class="form-label">Type de prêt</label>
                            <select class="form-select" id="type_pret" required disabled>
                                <option value="">Chargement des types de prêt...</option>
                            </select>
                            <div class="form-text text-muted">Le taux annuel est indiqué entre parenthèses</div>
                        </div>

                        <div class="mb-3">
                            <label for="montant" class="form-label">Montant du prêt (€)</label>
                            <input type="number" min="1000" step="100" class="form-control" id="montant" required>
                        </div>

                        <div class="mb-3">
                            <label for="duree_mois" class="form-label">Durée de remboursement (mois)</label>
                            <input type="number" min="12" max="360" class="form-control" id="duree_mois" required>
                            <div class="form-text text-muted">Entre 1 et 30 ans (12 à 360 mois)</div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary" id="btn-calculer" disabled>
                                🧮 Calculer la mensualité
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="resultat" class="card shadow-sm border-0 mt-4 d-none">
                <div class="card-header bg-light text-center">
                    <h5 class="mb-0">📈 Résultat de la Simulation</h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6 text-end fw-semibold">
                            <p>Mensualité :</p>
                            <p>Coût total :</p>
                            <p>Taux annuel :</p>
                            <p>Coût des intérêts :</p>
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
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script>
    const apiBase = "http://localhost/exam_s4/ws";

    document.addEventListener("DOMContentLoaded", () => {
        chargerTypesPret();

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

            if (isNaN(montant) || montant <= 0) {
                alert("Veuillez entrer un montant valide");
                return;
            }

            if (isNaN(dureeMois) || dureeMois < 12 || dureeMois > 360) {
                alert("Veuillez entrer une durée entre 12 et 360 mois");
                return;
            }

            const tauxMensuel = tauxAnnuel / 12;
            const mensualite = (montant * tauxMensuel) / (1 - Math.pow(1 + tauxMensuel, -dureeMois));
            const coutTotal = mensualite * dureeMois;
            const coutInterets = coutTotal - montant;

            document.getElementById("mensualite").textContent = mensualite.toFixed(2) + " €";
            document.getElementById("cout_total").textContent = coutTotal.toFixed(2) + " €";
            document.getElementById("taux_annuel").textContent = (tauxAnnuel * 100).toFixed(2) + " %";
            document.getElementById("cout_interets").textContent = coutInterets.toFixed(2) + " €";

            document.getElementById("resultat").classList.remove("d-none");
        });
    });

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

                select.innerHTML = '<option value="">Types par défaut (hors ligne)</option>';
                const optionsSecours = [{
                        id: 1,
                        nom: "Prêt Personnel",
                        taux: 5
                    },
                    {
                        id: 2,
                        nom: "Prêt Immobilier",
                        taux: 3
                    },
                    {
                        id: 3,
                        nom: "Prêt Automobile",
                        taux: 7
                    }
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
</script>