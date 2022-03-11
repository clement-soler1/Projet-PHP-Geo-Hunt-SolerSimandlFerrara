<script>require('leaflet.js');</script>
<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
<section class="login-dark">
    <form method="post" action="">
        <h2 class="visually-hidden">Signup Form</h2>
        <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
        <div class="mb-3"><input class="form-control" type="text" name="title" placeholder="title"></div>
        <div class="mb-3" style="display: flex; flex-direction: row">
            <p>private</p>
            <input type="checkbox" name="privacy" placeholder="privacy" style="margin-left: 25vh">
        </div>
        <div class="mb-3"><button class="btn btn-primary d-block w-100" type="submit">Create</button></div>
        <a class="forgot" href="?action=createquestion&controller=question">No questions? create some!</a>
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="controller" value="user">
    </form>

    <div id='map'></div>
    <script>
        L.mapbox.accessToken = 'pk.eyJ1IjoidGFnZ2VyMDYiLCJhIjoiY2wwbWV5ZzFvMDl5bjNjbnRvcXpydjBmaSJ9.qR8ING20xL9FR5mapnRO3A';
        var map = L.mapbox.map('map')
            .setView([40, -74.50], 9)
            .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/streets-v11'));
    </script>

</section>