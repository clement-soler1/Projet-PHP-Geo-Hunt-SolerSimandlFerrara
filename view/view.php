<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo htmlspecialchars($pagetitle); ?></title>
        <link rel="stylesheet" type="text/css" href="./view/css/games.css">
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./view/assets/bootstrap.min.css">
    </head>
    <body>
        <?php
            $header = File::build_path(array("view", "header.php"));
            require $header;
        ?>
        <main>
            <div class="background">
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
    <script type="text/javascript" src="./view/assets/bootstrap.min.js"></script>
</html>

