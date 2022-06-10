<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="login-dark">
    <h1 class="titleHnt">Mes pistes</h1>
    <div class="myMapsBody" id="readBody">
        <div id='map' style="margin: 2vw"></div>
        <div id='huntInfo'>
            <h1 style="color: white">WE'RE PLAYING GUBBLE</h1>
        </div>
    </div>

    <script>
        mapboxgl.accessToken = '<?php echo $MAPBOX_TOKEN;?>';
        this.map = new mapboxgl.Map({
            container: 'map', // container ID
            style: 'mapbox://styles/mapbox/streets-v11', // style URL
            center: [6.0209, 43.1372], // starting position [lng, lat]
            zoom: 13, // starting zoom
            attributionControl: false
        });

        this.map.on('load', () => {
            this.map.addSource('hunts', {
                'type':'geojson',
                'data': {
                    'type': 'FeatureCollection',
                    'features': [
                    <?php
                    $usr = unserialize($_SESSION["user"]);
                    if (isset($my_hunts)){
                        foreach ($my_hunts as $hunt){
                            if($hunt->getUser_id() == $usr->getUser_id())
                            echo "
                                {
                                    'type':'Feature',
                                    'properties':{'description':'".$hunt->getHunt_Title()."'},
                                    'geometry': {'type':'Point','coordinates':[".$hunt->getLon().",".$hunt->getLat()."]}
                                },
                            ";
                        }
                    }
                    ?>
                    ]
                }
            });
            this.map.addLayer({
                'id': 'hunts',
                'type': 'symbol',
                'source': 'hunts',
                'layout': {
                    'icon-image': 'pitch-15',
                    'icon-size': 1.25,
                    'icon-allow-overlap': true
                },
                "paint": {
                    /*"text-size": 10,*/
                }
            });

            this.map.on('click', 'hunts', (e) => {
               /* const coordinates = e.features[0].geometry.coordinates.slice();
                const description = e.features[0].properties.description;

                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);*/
                ani();
            });
        });

        function ani() {
            document.getElementById('readBody').style.height = "80vh";
            document.getElementById('huntInfo').style.display = "block";
        }
    </script>

</section>