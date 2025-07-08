<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
    <div class="body-wrapper-inner">
        <div class="container-fluid mt-5">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">liste emprunt</h4>
                </div>
                <div class="card-body">
                    <table id="pret-table" class="table table-striped table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Client</th>
                                <th>Date début</th>
                                <th>durée</th>
                                <th>Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>