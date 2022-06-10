<header>
    <?php
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_SESSION['user'])) {
        echo '
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="'. File::fileDirection("/") .'">Geo-Hunt</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Jouer</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>';

                echo '<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Equipe
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                if (isset($_SESSION['asTeam']) && $_SESSION['asTeam']) {
                        echo '<a class="dropdown-item" href="'. File::fileDirection("/teams/". unserialize($_SESSION["team"])->getTeam_id() ."/read") .'">Mon équipe</a>';
                        } else {
                    echo '<a class="dropdown-item" href = "'. File::fileDirection("/teams/readAll") .'" > Rejoindre une équipe </a>
                    <a class="dropdown-item" href = "'. File::fileDirection("/teams/create") .'" > Créer une équipe </a>';
                    }
                    echo '</div>
                </li>';}

    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
        echo '
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Administration
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="'. File::fileDirection("/user/readAll") .'">Utilisateurs</a>
                        <a class="dropdown-item" href="#">TODO</a>
                        <a class="dropdown-item" href="#">TODO</a>
                    </div>
                </li>';}
    if (isset($_SESSION['user'])) {
        echo '
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <form method="post" action="'. File::fileDirection("/user/disconnect") .'">
                <button style="margin-left: 1vw" class="btn btn-outline-danger" >Déconnexion</button>
            </form>
        </div>
    </nav>';
    } else {
        echo '
        <nav class="navbar navbar-light bg-light">
          <span class="navbar-brand mb-0 h1">Geo-Hunt</span>
          <form method="post" action="'. File::fileDirection("/global/login") .'">
            <button class="btn btn-outline-success my-2 my-sm-0">Connexion</button>
          </form>
        </nav>';
    }
    ?>
</header>