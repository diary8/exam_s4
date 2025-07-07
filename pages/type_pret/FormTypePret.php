<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../../assets/css/styles.min.css"> -->
    <title>Document</title>
</head>
<body>
    <div class="tab-content">
            <div class="tab-pane active" id="form-section">
                <div class="well">
                    <h3 id="form-title">Ajouter un Type de Prêt</h3>
                    
                    <div id="alert-message" class="alert" style="display: none;"></div>
                    
                    <form id="typePretForm" class="form-horizontal">
                        <input type="hidden" id="typePretId">
                        
                        <div class="form-group">
                            <label for="nom" class="col-sm-2 control-label">Nom</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nom" required>
                                <span id="nom-error" class="help-block" style="display: none;"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="taux" class="col-sm-2 control-label">Taux (%)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="taux" step="0.01" required>
                                <span id="taux-error" class="help-block" style="display: none;"></span>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" id="submit-btn" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-floppy-disk"></span> Enregistrer
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
</body>
</html>

<script>
  const apiBase = "http://localhost/git/exam_s4/ws";

  const loginForm = document.getElementById("typePretForm");

  loginForm.addEventListener("submit", function(event) {
    event.preventDefault();

    const nom = document.getElementById("nom").value.trim();
    const taux = document.getElementById("taux").value.trim();
    const description = document.getElementById("description").value.trim();

    
    fetch(`${apiBase}/types_pret`, 
    {
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
          console.log("erreur de l'enregistrement",data); 
        }
      })
      .catch(error => {
        console.error("Erreur lors de la requête :", error);
      });
  });
</script>