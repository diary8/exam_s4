<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; 
?>


<div class="body-wrapper">
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

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
<script>

document.addEventListener('DOMContentLoaded', function() {
    loadClients();
});

function loadClients() {
    ajax("GET", "/clients", null, 
        function(data) {
            const tbody = document.getElementById('clients-list');
            tbody.innerHTML = '';
            
           
                data.data.forEach(client => {
                    const row = `
                        <tr>
                            <td>${client.id}</td>
                            <td>${client.nom || ''}</td>
                            <td>${client.email || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="viewClient(${client.id})">
                                    Voir 
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                    window.viewClient = function(id) {
                    window.location.href = `description.php?id=${client.id}`;
                    }
               
            } );
            
        },
        function(error) {
            console.error('AJAX Error:', error);
            const tbody = document.getElementById('clients-list');
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="text-danger">
                        Erreur de chargement: ${error.message || 'Erreur serveur'}
                    </td>
                </tr>
            `;
        }
    );
}


</script>