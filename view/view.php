<?php
//define const
$MAPBOX_TOKEN = 'pk.eyJ1IjoidGFnZ2VyMDYiLCJhIjoiY2wwbWV5ZzFvMDl5bjNjbnRvcXpydjBmaSJ9.qR8ING20xL9FR5mapnRO3A';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php if (isset($pagetitle)) {echo htmlspecialchars($pagetitle);} ?></title>
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="./assets/bootstrap.min.css">
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>
    </head>
    <body>
        <?php
            $header = File::build_path(array("view", "header.php"));
            require $header;
        ?>
        <main>
            <div class="background">
                <?php
                    if (isset($controller) && isset($view)) {
                        $filepath = File::build_path(array("view", $controller, "$view.php"));
                        require $filepath;
                    }
                ?>
            </div>
        </main>
        <footer>
        </footer>
    </body>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/bootstrap.min.js"></script>
</html>

