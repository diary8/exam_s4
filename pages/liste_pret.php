<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des prêts</title>
    <link rel="stylesheet" href="../assets/css/styles.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Liste des prêts</h4>
        </div>
        <div class="card-body">
            <table id="pret-table" class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Client</th>
                        <th>Date début</th>
                        <th>Montant</th>
                        <th>Type prêt</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="../assets/js/ajaxFunc.js"></script>
<script>
    const pret_table_body = document.querySelector("#pret-table tbody");

    ajax("GET", "/pret", null, function(data) {
        data.list_pret.forEach(element => {
            const tableRow = document.createElement("tr");

            tableRow.innerHTML = `
                <td>${element.nom_client}</td>
                <td>${element.date_debut_pret}</td>
                <td>${element.montant}</td>
                <td>${element.nom_type_pret}</td>
            `;

            pret_table_body.appendChild(tableRow);
        });
    });
</script>

</body>
</html>
