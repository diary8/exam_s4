<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Prêt</title>
    <!-- <link rel="stylesheet" href="../../assets/css/styles.min.css"> -->
</head>
<body>
    <div class="container mt-5">
        <h2>Nouveau Prêt</h2>
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
                    <!-- Options chargées dynamiquement via AJAX -->
                </select>
            </div>
            
            <div class="mb-3">
                <label for="type_pret" class="form-label">Type de prêt</label>
                <select class="form-select" id="type_pret" name="type_pret" required>
                    <!-- Options chargées dynamiquement via AJAX -->
                </select>
            </div>
            
            <div class="mb-3">
                <label for="client" class="form-label">Client</label>
                <select class="form-select" id="client" name="client" required>
                    <!-- Options chargées dynamiquement via AJAX -->
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
    </div>

    <script>
  const apiBase = "http://localhost/git/exam_s4/ws";

  const pretForm = document.getElementById("formPret");

  pretForm.addEventListener("submit", function(event) {
    event.preventDefault();

    const date_debut = document.getElementById("date_debut").value.trim();
    const montant = document.getElementById("montant").value.trim();
    const banque = document.getElementById("banque").value.trim();
    const type_pret = document.getElementById("type_pret").value.trim();
    const client = document.getElementById("client").value.trim();

    fetch(`${apiBase}/pret`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        date_debut: date_debut,
        montant: montant,
        banque: banque,
        type_pret: type_pret,
        client: client
      })
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        console.log("Prêt enregistré avec succès");
        window.location.href = "ListePrets.php"; // Redirection vers la liste
      } else {
        console.log("Erreur lors de l'enregistrement", data);
        alert("Erreur: " + (data.message || "Échec de l'enregistrement"));
      }
    })
    .catch(error => {
      console.error("Erreur lors de la requête :", error);
      alert("Une erreur réseau est survenue");
    });
  });

  // Fonction pour charger les options des select
  function chargerOptions(endpoint, selectId) {
    fetch(`${apiBase}${endpoint}`)
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById(selectId);
        const options = data.data || data;
        
        options.forEach(option => {
          const optElement = document.createElement("option");
          optElement.value = option.id;
          optElement.textContent = option.nom || `${option.prenom || ''} ${option.nom || ''}`.trim();
          select.appendChild(optElement);
        });
      })
      .catch(error => console.error("Erreur:", error));
  }

  // Charger les options au démarrage
  document.addEventListener("DOMContentLoaded", function() {
    chargerOptions("/banques", "banque");
    chargerOptions("/types_pret", "type_pret");
    chargerOptions("/clients", "client");
  });
</script>
</body>
</html>