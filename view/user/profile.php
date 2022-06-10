<?php
$usr=unserialize($_SESSION['user']);

?>
<main class="profile">
    <link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("profile.css") ?>">
    <h1 class="profile-title">
        Profile
    </h1>
    <div class="profile-container">
        <div class="user">
            <div class="image-container">
                <img alt="" class="avatar" src="https://image.freepik.com/free-vector/coloured-knight-design_1152-54.jpg" />
            </div>
            <div class="user-info">
                <p class="user-name">
                    <?php echo $usr->getUsername() ;?>
                </p>
            </div>
        </div>
        <div class="info-container">
            <div class="info">
                <div class="title">
                    Date d'inscription :
                </div>
                <div class="description">
                    <?php echo $usr->getJoin_Date() ;?>
                </div>
            </div>
            <div class="info">
                <div class="title">
                    Email :
                </div>
                <div class="description">
                    <?php echo $usr->getEmail() ;?>
                </div>
            </div>
            <div class="info">
                <div class="title">
                    Description :
                </div>
                <div class="description">
                </div>
                <?php echo $usr->getDescription() ;?>

            </div>
        </div>
    </div>
</main>