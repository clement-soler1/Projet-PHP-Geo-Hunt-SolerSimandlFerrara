<?php

//var_dump($usr);

?>

<main class="profile">
    <link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("profile.css") ?>">
    <h1 class="profile-title">
        <b>Profil</b>
    </h1>
    <form method="post" action="<?php echo File::fileDirection("/user/". $usr->getUser_id() ."/updated") ?>">
        <div class="image-container">
            <img alt="profile_pic" class="avatar" src="https://image.freepik.com/free-vector/coloured-knight-design_1152-54.jpg" />
        </div>
        <div class="profile-input">
            <p class="profile_entry">Username : </p>
            <input type="text" name="username" value="<?php echo $usr->getUsername() ;?>">
        </div>
        <div class="profile-input">
            <p class="profile_entry">Email : </p>
            <input type="text" name="email" value="<?php echo $usr->getEmail() ;?>">
        </div>
        <div class="profile-input-desc">
            <p class="profile_entry">Description : </p>
            <textarea name="description"><?php echo $usr->getDescription() ;?></textarea>
        </div>

        <div class="profile-action">
            <button type="button" onclick="location.href = '<?php echo File::fileDirection("/user/". $usr->getUser_id() ."/read") ?>'" class="btn btn-danger">Annuler</button>
            <button type="submit" class="btn btn-success">Valider</button>
        </div>
    </form>

</main>
