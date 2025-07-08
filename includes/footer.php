</div> <!-- Fin de body-wrapper -->
</div> <!-- Fin de page-wrapper -->

<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
<script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="../assets/libs/simplebar/dist/simplebar.js"></script>

<script>
    $(document).ready(function () {
        const currentPage = window.location.pathname.split("/").pop();
        $('#sidebarnav a').each(function () {
            if ($(this).attr('href') === currentPage) {
                $(this).addClass('active');
                $(this).parents('.collapse').addClass('show');
                $(this).parents('.sidebar-item').find('.has-arrow').attr('aria-expanded', 'true');
            }
        });
    });
</script>
</body>
</html>
