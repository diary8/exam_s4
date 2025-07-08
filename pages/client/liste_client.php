<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

<div class="main-content">
  <?php include __DIR__ . '/template/sidebar.php'; ?>

  <div class="content-wrapper container-fluid">
    <div class="card shadow mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Liste des clients</h6>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="clients-table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="clients-list">
              <!-- Rempli par JavaScript -->
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

// Code JavaScript spécifique à la page
document.addEventListener('DOMContentLoaded', function() {
  // Initialisation
  loadClients();
  
  // Fonction pour charger les clients
  function loadClients() {
    fetch('${apiBase}/client/')
      .then(response => response.json())
      .then(data => {
        const tbody = document.getElementById('clients-list');
        tbody.innerHTML = '';
        
        data.forEach(client => {
          const row = `
            <tr>
              <td>${client.id}</td>
              <td>${client.nom}</td>
              <td>${client.prenom}</td>
              <td>${client.email}</td>
              <td>
                <button class="btn btn-sm btn-primary" onclick="viewClient(${client.id})">
                  Voir
                </button>
              </td>
            </tr>
          `;
          tbody.insertAdjacentHTML('beforeend', row);
        });
      });
  }
  
  window.viewClient = function(id) {
    window.location.href = `${apiBase}/client/detail?id=${id}`;
  }
});
</script>