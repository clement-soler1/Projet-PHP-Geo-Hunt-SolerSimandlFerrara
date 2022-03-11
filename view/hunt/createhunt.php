<link rel="stylesheet" type="text/css" href="./assets/css/hunt.css">
<section class="login-dark">
    <form method="post" action="">
        <h2 class="visually-hidden">Créer une piste</h2>
        <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
        <div class="mb-3"><input class="form-control" type="text" name="title" placeholder="title"></div>
        <div class="mb-3" style="display: flex; flex-direction: row">
            <p style="margin-right: 15vh;margin-bottom: 0.5rem">piste privée :</p>
            <input type="checkbox" name="privacy" placeholder="privacy">
        </div>
        <p>début de piste :</p>
        <div id='map'></div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Create</button></div>
        <a class="forgot" href="?action=createquestion&controller=question">No questions? create some!</a>
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="controller" value="user">
    </form>

    <script>
        mapboxgl.accessToken = '<?php echo $MAPBOX_TOKEN;?>';
        const map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [-74.5, 40], // starting position [lng, lat]
            zoom: 9 // starting zoom
        });
    </script>

</section>