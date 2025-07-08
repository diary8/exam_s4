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

    <div class="container-fluid mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Liste des prêts</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="pret-table" class="table table-striped table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Client</th>
                                <th>Date début</th>
                                <th>Montant prêté</th>
                                <th>Montant à rendre</th>
                                <th>Montant remboursé</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Les lignes seront insérées dynamiquement ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
<script>
    const pret_table_body = document.querySelector("#pret-table tbody");

    ajax("GET", "/pret/banque", null, function(data) {
        data.list_pret.forEach(element => {
            const tableRow = document.createElement("tr");

            tableRow.innerHTML = `
                <td>
                ${element.nom_client}
                ${element.email_client}
                </td>
                <td>${element.date_debut_pret}</td>
                <td>${element.montant_prete}</td>
                <td></td>
                <td>${element.montant_rembourse}</td>
                <td>
                    <button onclick="getTableauRemboursement(${element.pret_id})" class="btn btn-sm btn-primary d-flex align-items-center justify-content-center">
                        Voir
                    </button>
                </td>
                `;

            pret_table_body.appendChild(tableRow);
        });
    });

    function getTableauRemboursement($id_pret){
        window.location.href = "http://localhost/exam_s4/pages/banque/TableauRemboursement.php?idPret="+$id_pret;
    }
</script>