<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("team.css") ?>">
<h1>Créer une Equipe</h1>

<form id="team_create" method="post" action="<?php echo File::fileDirection("/teams/created"); ?>">
    <input type="text" name="team_name" placeholder="nom de l'équipe" required>
    <button type="submit" class="btn btn-success">Créer</button>
</form>