<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
    <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <ul class="navbar-nav">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

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
</div>

<?php include include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
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

