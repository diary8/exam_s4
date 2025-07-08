<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>
<div class="body-wrapper">
    <div class="container-fluid mt-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    📋 Liste des prêts
                </h5>
            </div>

            <div class="card-body">
                <form id="typePretForm" class="needs-validation" novalidate>
                    <input type="hidden" id="typePretId">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="nom" required>
                            <div id="nom-error" class="invalid-feedback" style="display: none;"></div>
                        </div>

                        <div class="col-md-6">
                            <label for="taux" class="form-label">Taux (%)</label>
                            <input type="number" class="form-control" id="taux" step="0.01" required>
                            <div id="taux-error" class="invalid-feedback" style="display: none;"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" id="submit-btn" class="btn btn-primary">
                            💾 Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script>
    const apiBase = "http://localhost/exam_s4/ws";

    const loginForm = document.getElementById("typePretForm");

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault();

        const nom = document.getElementById("nom").value.trim();
        const taux = document.getElementById("taux").value.trim();
        const description = document.getElementById("description").value.trim();


        fetch(`${apiBase}/types_pret`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    nom: nom,
                    taux: taux,
                    description: description
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log("Type Pret Enregistrer avec Succees");
                    window.location.href = "ListeTypePret.php";
                } else {
                    console.log("erreur de l'enregistrement", data);
                }
            })
            .catch(error => {
                console.error("Erreur lors de la requête :", error);
            });
    });
</script>