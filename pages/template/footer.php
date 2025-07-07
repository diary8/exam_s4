</div> <!-- /.content-wrapper -->
            
            <footer class="main-footer bg-white mt-auto py-3">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-0">&copy; <?php echo date('Y'); ?> Banque XYZ - Tous droits réservés</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <p class="mb-0">Version 1.0.0</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div> <!-- /.main-content -->
    </div> <!-- /.app-container -->
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Flexy Bootstrap JS -->
    <script src="/assets/js/flexy-bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/assets/js/custom.js"></script>
    
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>