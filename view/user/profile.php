<?php
//$usr=unserialize($_SESSION['user']);

?>
<main class="profile">
    <link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("profile.css") ?>">
    <h1 class="profile-title">
        <b>Profil</b>
    </h1>
    <div class="image-container">
        <img alt="profile_pic" class="avatar" src="https://image.freepik.com/free-vector/coloured-knight-design_1152-54.jpg" />
    </div>
    <p class="profile_entry">Username : <?php echo $usr->getUsername() ;?></p>
    <p class="profile_entry">Email : <?php echo $usr->getEmail() ;?></p>
    <p class="profile_entry">Description : <?php echo $usr->getDescription() ;?></p>

    <h1 class="profile-title bestAttempts"><b>
        Meilleurs Scores
    </b></h1>

    <div>
    </div>

    <div class="profile-action">
        <button type="button" id="btnDeleteMyAccount" class="btn btn-danger">Supprimer</button>
        <button type="button" onclick="location.href = '<?php echo File::fileDirection("/user/". $usr->getUser_id() ."/update") ?>'" class="btn btn-success">Editer</button>
    </div>

    <script>
        let del_link = "<?php echo File::fileDirection("/user/". $usr->getUser_id() ."/delete") ?>";
        $(document).ready(() => {
            $("#btnDeleteMyAccount").off("click").on("click", (e) => {
                if (confirm("Etes-vous sur de vouloir supprimer vôtre compte ?") == true) {
                    location.href = del_link;
                }
            });

        });
    </script>

</main>