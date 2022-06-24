<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="login-dark">
    <div id="playBody">
        <div class="quizz">
            <h2><?php echo $hunt->getHunt_Title() ?></h2>
            <h2 id="qu_title"></h2>
            <p id="qu_text"></p>
        </div>
        <div id='map' style="min-width: 100px;margin: 2vw"></div>
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
                $('#qu_title').text(`<?php echo $results[0]->getQu_Title() ?>`);
                $('#qu_text').text(`<?php echo $results[0]->getQu_Text() ?>`);
            }else {
                $('#qu_title').text('');
                $('#qu_text').text('');
            }
        });
        /*var add_marker = function (event) {
            var coordinates = [event.lngLat.lng,event.lngLat.lat];
            this.marker1.setLngLat(coordinates).addTo(this.map);
            var options = {
                units: 'kilometers'
            };
            var distance = turf.distance(from, coordinates, options);
            if(distance<0.025) {
                $('#qu_title').text(`<?php echo $results[0]->getQu_Title() ?>`);
                $('#qu_text').text(`<?php echo $results[0]->getQu_Text() ?>`);
            }else {
                $('#qu_title').text('');
                $('#qu_text').text('');
            }
        }
        marker1 = new mapboxgl.Marker();
        map.on('click', add_marker.bind(this));*/
    </script>
</section>
