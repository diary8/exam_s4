<table>
    <tr>
        <th>Client</th>
        <th>date début</th>
        <th>montant</th>
        <th>type prêt</th>
    </tr>
    <tr id="pret_container"></tr>
</table>
<script src="../assets/js/ajaxFunc.js"></script>
<script>
    const pret_container = document.getElementById("pret_container");

    ajax("GET", "/pret", null, function(data) {
        console.log(data);
    });
</script>