<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
<section class="login-dark">
    <form method="post" action="">
        <h2 class="visually-hidden">Signup Form</h2>
        <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
        <div class="mb-3"><input class="form-control" type="text" name="username" placeholder="Username"></div>
        <div class="mb-3"><input class="form-control" type="email" name="email" placeholder="Email"></div>
        <div class="mb-3"><input class="form-control" type="password" name="password" placeholder="Password"></div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Sign Up</button></div>
        <a class="forgot" href="?action=login&controller=user">I already have an account ! Log In</a>
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="controller" value="user">
    </form>
</section>