<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
    <div class="body-wrapper-inner">
        <div class="container-fluid mt-5">
            <form id="filtre-form" class="d-flex flex-wrap gap-3 mb-4 align-items-end">
                <div>
                    <label for="moisDebut" class="form-label">Mois Début</label>
                    <input type="month" id="moisDebut" class="form-control" required>
                </div>

                <div>
                    <label for="anneeDebut" class="form-label">Année Début</label>
                    <input type="number" id="anneeDebut" class="form-control" min="1900" required>
                </div>

                <div>
                    <label for="moisFin" class="form-label">Mois Fin</label>
                    <input type="month" id="moisFin" class="form-control" required>
                </div>

                <div>
                    <label for="anneeFin" class="form-label">Année Fin</label>
                    <input type="number" id="anneeFin" class="form-control" min="1900" required>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </form>

            <table class="table table-bordered table-hover" id="result-container">
                <thead>
                    <tr>
                        <th>Année</th>
                        <th>Mois</th>
                        <th>Intérêt mensuel</th>
                    </tr>
                </thead>
                <tbody id="result-body">
                </tbody>
            </table>

            <h2 class="text-center mb-4">Évolution des intérêts mensuels</h2>

            <div class="d-flex justify-content-center">
                <div class="card w-100" style="max-width: 800px;">
                    <div class="card-body">
                        <canvas id="interestChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
<script>
    const filtreForm = document.getElementById('filtre-form');
    const resultBody = document.getElementById('result-body');

    filtreForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const moisDebut = document.getElementById("moisDebut").value.split("-")[1];
        const anneeDebut = document.getElementById("anneeDebut").value;

        const moisFin = document.getElementById("moisFin").value.split("-")[1];
        const anneeFin = document.getElementById("anneeFin").value;

        filtre(moisDebut, anneeDebut, moisFin, anneeFin);
    });

    function filtre(moisDebut, anneeDebut, moisFin, anneeFin) {
        const queryParams = `?moisDebut=${moisDebut}&anneeDebut=${anneeDebut}&moisFin=${moisFin}&anneeFin=${anneeFin}`;

        ajax("GET", "/banque/interet" + queryParams, null, function(data) {
            console.log(data);
            resultBody.innerHTML = "";
            if (!data || !data.interer_mensuel || data.interer_mensuel.length === 0) {
                resultBody.innerHTML = "<tr><td colspan='4'>Aucun résultat trouvé</td></tr>";
                return;
            }

            data.interer_mensuel.forEach((item) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                <td>${item.annee}</td>
                <td>${item.mois}</td>
                <td>${parseFloat(item.interet_mensuels).toFixed(2)} Ar</td>
            `;
                resultBody.appendChild(row);
            });

            dessinerGraphe(data.interer_mensuel);
        });
    }

    let interestChartInstance = null;

    function dessinerGraphe(intererMensuel) {
        const ctx = document.getElementById('interestChart').getContext('2d');

        const labels = intererMensuel.map(item => {
            const moisNames = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
            return `${moisNames[item.mois - 1]} ${item.annee}`;
        });

        const dataPoints = intererMensuel.map(item => parseFloat(item.interet_mensuels));

        if (interestChartInstance) {
            interestChartInstance.destroy();
        }

        interestChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Intérêt mensuel (Ar)',
                    data: dataPoints,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (context) => `${context.formattedValue} Ar`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Montant (Ariary)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mois'
                        }
                    }
                }
            }
        });
    }
</script>