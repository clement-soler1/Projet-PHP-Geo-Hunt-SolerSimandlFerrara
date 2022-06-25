<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="login-dark">
    <div id="playBody">
        <div class="quizz">
            <h2><?php echo $hunt->getHunt_Title() ?></h2>
            <div id='map' style="min-width: 100px;margin: 2vw"></div>
            <h2 class="qu_title" style="text-align: center"></h2>
            <p class="qu_text" style="text-align: center"></p>
            <button id="validateBtn" class="btn btn-primary d-block w-100" type="button" style="visibility: collapse">Trouvé!</button>
        </div>
    </div>

    <script>
        mapboxgl.accessToken = '<?php echo $MAPBOX_TOKEN;?>';
        this.map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [6.0209, 43.1372],
            zoom: 13,
            attributionControl: false
        });
        marker = new mapboxgl.Marker();
        var from = [<?php echo $results[0]->getLon() ?>,<?php echo $results[0]->getLat() ?>];
        this.marker.setLngLat(from).addTo(this.map);
        var geolocate = new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true,
            showUserHeading: true
        })
        map.addControl(geolocate);
        geolocate.on('geolocate', function(e) {
            var lon = e.coords.longitude;
            var lat = e.coords.latitude
            var position = [lon, lat];
            var options = {
                units: 'kilometers'
            };
            var distance = turf.distance(from, position, options);
            console.log(distance);
            if(distance<0.025) {
                $('.qu_title').text(`<?php echo $results[0]->getQu_Title() ?>`);
                $('.qu_text').text(`<?php echo $results[0]->getQu_Text() ?>`);
            }else {
                $('.qu_title').text('');
                $('.qu_text').text('');
            }
        });
        var add_marker = function (event) {
            var coordinates = [event.lngLat.lng,event.lngLat.lat];
            this.marker1.setLngLat(coordinates).addTo(this.map);
            var options = {
                units: 'kilometers'
            };
            var distance = turf.distance(from, coordinates, options);
            if(distance<0.025) {
                $('.qu_title').text(`<?php echo $results[0]->getQu_Title() ?>`);
                $('.qu_text').text(`<?php echo $results[0]->getQu_Text() ?>`);
                $('#validateBtn').css('visibility','visible');
            }else {
                $('.qu_title').text('');
                $('.qu_text').text('');
                $('#validateBtn').css('visibility','collapse');
            }
        }
        marker1 = new mapboxgl.Marker();
        map.on('click', add_marker.bind(this));
        $('#validateBtn').on('click', function (){
            location.href = '<?php echo File::fileDirection("/hunts/".$hunt->getHunt_Id()."/playNext") ?>';
        })
    </script>
</section>
