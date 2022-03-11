
<link rel="stylesheet" type="text/css" href="./assets/css/user.css">


<h1 class="titleUsr">Utilisateurs</h1>

<div id="formUser">
    <div class="user">
        <p class="iconUtilityTxt adminTxt">Admin</p>
        <p class="logUser">Username</p>
        <p class="logUser">(email)</p>
        <p class="iconUtilityTxt icopad">Edit</p>
        <p class="iconUtilityTxt icopad">Delete</p>
        <p class="iconUtilityTxt icopad sa">Set Admin</p>
    </div>

<?php
    if (isset($tab_usr)){
        foreach ($tab_usr as $usr) {
            $usr->afficher();
        }
    }
?>

</div>
