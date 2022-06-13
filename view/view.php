<?php
//define const
$MAPBOX_TOKEN = 'pk.eyJ1IjoidGFnZ2VyMDYiLCJhIjoiY2wwbWV5ZzFvMDl5bjNjbnRvcXpydjBmaSJ9.qR8ING20xL9FR5mapnRO3A';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php if (isset($pagetitle)) {echo htmlspecialchars($pagetitle);} ?></title>
        <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo File::assetsFilePath("bootstrap.min.css") ?>">
<!--        <link href="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css" rel="stylesheet">-->


        <!--script loaded on head to be load before view-->
<!--        <script src="https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js"></script>-->
        <?php
        if (!isset($use_mapbox)) {
            $use_mapbox = false;
        }

        if ($use_mapbox) {
            echo '<link href="'. File::assetsFilePath("mapbox/mapbox-gl.css") .'" rel="stylesheet">';
            echo '<script src="'. File::assetsFilePath("mapbox/mapbox-gl.js") .'"></script>';
        }
        ?>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo File::assetsFilePath("bootstrap.min.js") ?>"></script>
        <script src='https://unpkg.com/@turf/turf/turf.min.js'></script>
    </head>
    <body>
        <?php
            if (!isset($show_header)) {
                $show_header = true;
            }
            if ($show_header) {
                $header = File::build_path(array("view", "header.php"));
                require $header;
            }
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
</html>

