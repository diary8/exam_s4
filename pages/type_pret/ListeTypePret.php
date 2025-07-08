<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">

    <div class="container py-4">
        <h1 class="mb-4">📘 Types de Prêt</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="form-type-pret" onsubmit="event.preventDefault(); ajouterOuModifier();">
                    <input type="hidden" id="id">

                    <div class="row g-3">
                        <div class="col-md-4">
                            <input type="text" id="nom" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col-md-4">
                            <input type="number" id="taux" class="form-control" placeholder="Taux (%)" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="description" class="form-control" placeholder="Description">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary">
                            💾 Enregistrer / Modifier
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table-types-pret" class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Taux (%)</th>
                                <th>Description</th>
                                <th class="text-center">Actions</th>
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

<script>
    const apiBase = "http://localhost/exam_s4/ws";

    function ajax(method, url, data, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open(method, apiBase + url, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = () => {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    callback(response);
                } else {
                    console.error("Erreur API:", xhr.status, xhr.statusText);
                    alert("Erreur lors de l'opération");
                }
            }
        };
        xhr.send(data ? JSON.stringify(data) : null);
    }

    function chargerTypePret() {
        ajax("GET", "/types_pret", null, (response) => {
            const tbody = document.querySelector("#table-types-pret tbody");
            tbody.innerHTML = "";

            const types = response.data || response;
            types.forEach(type => {
                ajouterLigneTableau(type);
            });
        });
    }

    function ajouterLigneTableau(type) {
        const tbody = document.querySelector("#table-types-pret tbody");
        const tr = document.createElement("tr");
        tr.setAttribute('data-id', type.id);
        tr.innerHTML = `
                <td>${type.nom || ''}</td>
                <td>${type.taux || ''}</td>
                <td>${type.description || ''}</td>
                <td>
                    <button onclick="remplirFormulaire(${type.id})">✏️</button>
                    <button onclick="supprimerTypePret(${type.id})">🗑️</button>
                </td>
            `;
        tbody.appendChild(tr);
    }

    function ajouterOuModifier() {
        const id = document.getElementById("id").value;
        const nom = document.getElementById("nom").value;
        const taux = document.getElementById("taux").value;
        const description = document.getElementById("description").value;

        const data = {
            nom: nom,
            taux: parseFloat(taux),
            description: description
        };

        ajax("PUT", `/types_pret/${id}`, data, (response) => {
            if (response.success) {
                const row = document.querySelector(`tr[data-id="${id}"]`);
                if (row) {
                    row.innerHTML = `
                                <td>${nom}</td>
                                <td>${taux}</td>
                                <td>${description}</td>
                                <td>
                                    <button onclick="remplirFormulaire(${id})">✏️</button>
                                    <button onclick="supprimerTypePret(${id})">🗑️</button>
                                </td>
                            `;
                }
                resetForm();
            }
        });
    }

    function remplirFormulaire(id) {
        ajax("GET", `/types_pret/${id}`, null, (response) => {
            if (response.success) {
                const type = response.data;
                document.getElementById("id").value = type.id;
                document.getElementById("nom").value = type.nom;
                document.getElementById("taux").value = type.taux;
                document.getElementById("description").value = type.description;
            }
        });
    }

    function supprimerTypePret(id) {
        if (confirm("Supprimer ce Type Pret ?")) {
            ajax("DELETE", `/types_pret/${id}`, null, (response) => {
                if (response.success) {
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) {
                        row.remove();
                    }
                }
            });
        }
    }

    function resetForm() {
        document.getElementById("id").value = "";
        document.getElementById("nom").value = "";
        document.getElementById("taux").value = "";
        document.getElementById("description").value = "";
    }

    document.addEventListener('DOMContentLoaded', chargerTypePret);
</script>