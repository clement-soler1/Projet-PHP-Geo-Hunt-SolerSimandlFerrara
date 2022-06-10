<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("forbidden.css") ?>">


<div class="container">
    <div class="forbidden-sign"></div>
    <h1>Access to this page is restricted.</h1>
    <p>Ensure you have sufficient permissions.</p>
</div>

<div id="ctnrrethome" class="">
    <div class="col-md-12 text-center">
        <form action="<?php echo File::fileDirection("/")  ?>">
            <button type="submit" class="btn btn-light centerBtn">Retour à l'Accueil</button>
        </form>
    </div>
</div>