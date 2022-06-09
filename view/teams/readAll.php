<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("team.css") ?>">



<h1 class="titleUsr">Equipes</h1>
<div style="width: 30%; margin-left: 35%;margin-top: 2vw;">
    <input id="team-search" class="form-control mr-sm-2" type="search" placeholder="Search Team" aria-label="Search">
</div>

<div id="formTeam">
    <div class="team">
        <p class="iconUtilityTxt adminTxt">Admin</p>
        <p class="logTeam">Nom de l'équipe</p>
        <p class="iconUtilityTxt icopad sa">Join</p>
        <p class="iconUtilityTxt icopad">Edit</p>
        <p class="iconUtilityTxt icopad">Delete</p>
    </div>

    <!--<div class="team">
        <p class="iconUtilityTxt adminTxt">Username</p>
        <p class="logTeam">Nom de l'équipe</p>
        <i class="material-icons iconUtility icoSetAdmin">group_add</i>
        <i class="material-icons iconUtility icoUpt">create</i>
        <i class="material-icons iconUtility icoDlt">delete</i>
    </div>-->

    <?php
    if (isset($tab_team)){
        foreach ($tab_team as $team) {
            $team->afficher();
        }
    }
    ?>

</div>