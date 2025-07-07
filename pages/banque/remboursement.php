<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
    <div class="body-wrapper-inner">
        <form id="formPret">
            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="date_debut" name="date_debut" required>
            </div>

            <div class="mb-3">
                <label for="montant" class="form-label">Montant</label>
                <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
            </div>

            <div class="mb-3">
                <label for="banque" class="form-label">Banque</label>
                <select class="form-select" id="banque" name="banque" required>
                </select>
            </div>

            <div class="mb-3">
                <label for="type_pret" class="form-label">Type de prêt</label>
                <select class="form-select" id="type_pret" name="type_pret" required>
                </select>
            </div>

            <div class="mb-3">
                <label for="client" class="form-label">Client</label>
                <select class="form-select" id="client" name="client" required>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>