<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Filtre d'intérêt</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
</head>
<body class="p-4">

  <div class="container">
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
        <!-- Données ici -->
      </tbody>
    </table>
  </div>

  <script src="../assets/js/ajaxFunc.js"></script>
  <script>
    const filtreForm = document.getElementById('filtre-form');
    const resultBody = document.getElementById('result-body');

    filtreForm.addEventListener("submit", function (event) {
      event.preventDefault();

      const moisDebut = document.getElementById("moisDebut").value.split("-")[1];
      const anneeDebut = document.getElementById("anneeDebut").value;

      const moisFin = document.getElementById("moisFin").value.split("-")[1];
      const anneeFin = document.getElementById("anneeFin").value;

      filtre(moisDebut, anneeDebut, moisFin, anneeFin);
    });

    function filtre(moisDebut, anneeDebut, moisFin, anneeFin) {
      const queryParams = `?moisDebut=${moisDebut}&anneeDebut=${anneeDebut}&moisFin=${moisFin}&anneeFin=${anneeFin}`;

      ajax("GET", "/banque/interet" + queryParams, null, function (data) {
        console.log(data);
        resultBody.innerHTML = "";
        if (!data || data.length === 0) {
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
      });
    }
  </script>
</body>
</html>
