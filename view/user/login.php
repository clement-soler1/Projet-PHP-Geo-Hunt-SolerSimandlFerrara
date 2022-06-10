<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("login.css") ?>">
<section class="login-dark">
    <form method="post" action="<?php echo File::fileDirection("/") ?>index.php?action=connect&controller=user">
        <h2 class="visually-hidden">Login Form</h2>
        <?php
            if (isset($errMessage)) {
                echo '<p style="color: red;width: 100%;text-align: center;margin-bottom: 1vw;">'. $errMessage .'</p>';
            }
        ?>
        <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
        <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"
            <?php if(isset($errType)){
                if ($errType != "mail") {
                    echo 'value="'. $dataBack["email"] .'"';
                }
            } ?>
            ></div>
        <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Log In</button></div>
        <a class="forgot" href="#">Forgot your email or password?</a>
        <a class="forgot" href="<?php echo File::fileDirection("/") ?>index.php?action=signup&controller=user" style="margin-top: 20px;">Don't have an account ? Sign Up</a>
    </form>
</section>

