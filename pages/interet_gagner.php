<form id="filtre-form">
    <input type="month" id="moisDebut">
    <input type="number" name="" id="anneeDebut">

    <input type="month" id="moisFin">
    <input type="number" name="" id="anneeFin">

    <button type="submit"> filtre</button>
</form>
<script src="../assets/js/ajaxFunc.js"></script>
<script>
    const filtreForm = document.getElementById('filtre-form');
    filtreForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const moisDebut = document.getElementById("moisDebut");
        const anneeDebut = document.getElementById("anneedDebut");
        
        const moisFin = document.getElementById("moisFin");
        const anneeFin = document.getElementById("anneeFin");
    })

    function filtre(moisDebut,anneeDebut,moisFin,anneeFin){
        
    }
</script>