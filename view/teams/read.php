<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("team.css") ?>">


<h1>Mon équipe</h1>
<h2 id="tm-name"><?php echo $team->getTeam_Name();  ?></h2>



<h1>Membres</h1>

<div class="tm-spacer"></div>

<div class="teammate-head">
    <div class="tm-admin"><p>Administrateur</p></div>
    <p class="tm-username">Username</p>
    <div class="iconUtility"><p>Expulser</p></div>
    <div class="iconUtility"><p>Set Admin</p></div>
</div>

<div id="teammates">
    <?php
    $usr = unserialize($_SESSION['user']);

    $usr_isTeamAdmin = false;
    $key = array_search($usr->getUser_id(),array_column($members, 'user_id'));
    $usr_isTeamAdmin = (intval($members[$key]["rank"]) === 1);

    foreach($members as $m) {
        $m_admin = '';
        if (intval($m["rank"]) === 1) {
            $m_admin = '<i class="material-icons iconUtility">font_download</i>';
        }

        echo '<div class="teammate" data-uid="'. htmlspecialchars($m["user_id"]) .' data-tid="'. htmlspecialchars($m["team_id"]) .'">';
        echo '<div class="tm-admin">'. $m_admin .'</div>';
        echo '<p class="tm-username">'. $m["username"] .'</p>';

        if ($usr->isAdmin() || $usr_isTeamAdmin) {
            echo '<div class="iconUtility"><i class="material-icons iconUtility icoDlt">group_remove</i></div>';
            echo '<div class="iconUtility"><i class="material-icons iconUtility icoSetAdmin">font_download</i></div>';
        } else {
            echo '<div class="iconUtility"></div>';
            echo '<div class="iconUtility"></div>';
        }

        echo '</div>';
    } ?>
    <!--<div class="teammate">
        <div class="tm-admin"><i class="material-icons iconUtility">font_download</i></div>
        <p class="tm-username">Username</p>
        <div class="iconUtility"><i class="material-icons iconUtility icoDlt">group_remove</i></div>
        <div class="iconUtility"><i class="material-icons iconUtility icoSetAdmin">font_download</i></div>
    </div>-->
</div>

<div class="tm-spacer"></div>
<div id="tm-leave">
    <button type="button" class="btn btn-danger">Quitter mon équipe</button>
</div>