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
    <table id="table-types-pret">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Taux</th>
                <th>Description</th>
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
                        // Vérifie si la réponse contient un tableau data
                        if (response.data && Array.isArray(response.data)) {
                            callback(response.data);
                        } else if (Array.isArray(response)) {
                            callback(response);
                        } else {
                            console.error("Format de réponse inattendu:", response);
                            alert("Erreur: Format de données inattendu");
                        }
                    } else {
                        console.error("Erreur API:", xhr.status, xhr.statusText);
                        alert("Erreur lors du chargement des données");
                    }
                }
            };
            xhr.send(data ? JSON.stringify(data) : null);
        }

        function chargerTypePret() {
            ajax("GET", "/types_pret", null, (types) => {
                const tbody = document.querySelector("#table-types-pret tbody");
                tbody.innerHTML = "";
                
                types.forEach(type => {
                    const tr = document.createElement("tr");
                    tr.innerHTML = `
                        <td>${type.nom || ''}</td>
                        <td>${type.taux || ''}</td>
                        <td>${type.description || ''}</td>
                    `;
                    tbody.appendChild(tr);
                });
            });
        }

        // Charger les données au démarrage
        document.addEventListener('DOMContentLoaded', chargerTypePret);
    </script>
</body>
</html>