</div> <!-- Fin de body-wrapper -->
</div> <!-- Fin de page-wrapper -->

<script src="http://localhost/exam_s4/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="http://localhost/exam_s4/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="http://localhost/exam_s4/assets/js/sidebarmenu.js"></script>
<script src="http://localhost/exam_s4/assets/js/app.min.js"></script>
<script src="http://localhost/exam_s4/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
<script src="http://localhost/exam_s4/assets/libs/simplebar/dist/simplebar.js"></script>

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
