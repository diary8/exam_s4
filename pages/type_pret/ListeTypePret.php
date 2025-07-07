<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Types de Prêt</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Types de Prêt</h1>
    <div>
        <input type="hidden" id="id">
        <input type="text" id="nom" placeholder="Nom">
        <input type="number" id="taux" placeholder="Taux">
        <input type="text" id="description" placeholder="Description">
        <button onclick="ajouterOuModifier()">Modifier</button>
    </div>

    <table id="table-types-pret">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Taux</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        const apiBase = "http://localhost/git/exam_s4/ws";

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
                        // Mise à jour de la ligne existante
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
                        // Suppression de la ligne
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
</body>
</html>