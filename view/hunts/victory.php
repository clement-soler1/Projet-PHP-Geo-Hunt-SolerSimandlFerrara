<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="winner">
    <div class="winbody">
        <i class='fa-solid fa-trophy fa-10x'></i>
        <h2>Vous Avez gagner!</h2>
        <button class="btn btn-primary" id="scoreboard">Afficher les scores</button>
    </div>

    <script>
        $('#scoreboard').on('click', function (){
            location.href = '<?php echo File::fileDirection("/hunts/".$hunt->getHunt_Id()."/showHighscore") ?>';
        });
    </script>
</section>