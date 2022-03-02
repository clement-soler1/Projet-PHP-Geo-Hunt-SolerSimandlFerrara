<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($pagetitle); ?></title>
        <link rel="stylesheet" type="text/css" href="./view/css/games.css">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    </head>
    <body>
        <header>
      
        </header>
        <main>
              <div class="background"></div>
              <div class="container centering">
                   <div class="container--logo"><img src="./view/logo/logo.png"/></div>
                   <div class="container--navigation">
                       <div class="wrapper">
                            <nav class="divNav">
                              <a href="./index.php" ><i class="fas fa-gamepad"></i> Jeux</a>
                              <a href="./index.php?action=readPanier" ><i class="fas fa-shopping-cart"></i> Panier</a>
                              <a href="#" ><i class="fas fa-info"></i> En savoir plus</a>
                              <?php 
                                if (isset($_SESSION['user'])) {
                                    echo '<div class="acctDrop">';
                                    echo '<a class="dropdown-trigger" href="#" onclick=\'javasrcipt:showDropdown();\' data-target="dropdown1"><i class="fas fa-user"></i> Mon Compte<i class="material-icons right dr">arrow_drop_down</i></a>';
                                    echo '<ul id="dropdown1" class="dropdown-content">';
                                    echo '<li><a href="index.php?action=read&controller=user">Compte</a></li>';
                                    echo '<li><a href="index.php?action=read&controller=commande&action=readAll">Mes commandes</a></li>';
                                    echo '<li><a href="index.php?action=disconnect&controller=user">Déconnexion</a></li>';
                                    if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']) {
                                        echo '<li class="divider"></li>';
                                        echo '<li><a href="index.php?action=create&controller=jeu">Ajouter un Jeu</a></li>';
                                        echo '<li><a href="index.php?action=readAll&controller=user">Utilisateurs</a></li>';
                                    }
                                    echo '</ul>';
                                    echo '</div>';
                                } else {
                                echo '<a href="./index.php?controller=user&action=login" ><i class="fas fa-user"></i> Se Connecter</a>';
                                }
                              ?>
                            </nav>
                        </div>
                   </div>

                  <div class="search">
                      <form method="get" action="./index.php?">
                          <input type="search" class="search-box" name="research" placeholder="search a game"><br>
                          <span class="search-button">
                    <span class="search-icon">
                      <input type='hidden' name='action' value='searchGame' class="disable">
                      <input class="disable" type="submit">
                    </span>
                  </span>
                      </form>
                  </div>

    <?php
    $filepath = File::build_path(array("view", $controller, "$view.php"));
    require $filepath;
    ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="./view/js/games.js"></script>
    <script type="text/javascript" src="./view/js/404Error.js"></script>
</html>

