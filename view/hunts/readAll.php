<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("hunt.css") ?>">
<section class="rall-dark">
    <h1 class="titleHnt">Mes pistes</h1>
    <div class="myMapsBody" id="readBody">
        <div id='map2' style="margin: 2vw;min-width: 100px;"></div>
        <div id='huntInfo'>
            <h1 style="color: white">WE'RE PLAYING GUBBLE</h1>
            <button type="button" class="btn btn-success">Jouer</button>
        </div>
    </div>

    <script>
        mapboxgl.accessToken = '<?php echo $MAPBOX_TOKEN;?>';
        this.map = new mapboxgl.Map({
            container: 'map2', // container ID
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
                    if (isset($my_hunts)){
                        foreach ($my_hunts as $hunt){
                            if($hunt->getUser_id() == $usr->getUser_id())
                            echo "
                                {
                                    'type':'Feature',
                                    'properties':{'title':'".$hunt->getHunt_Title()."'},
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
                console.log(e);
                console.log(e.features[0].properties);
               /* const coordinates = e.features[0].geometry.coordinates.slice();
                const description = e.features[0].properties.description;

                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                }

                new mapboxgl.Popup()
                    .setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);*/
                ani(e.features[0].properties);
            });
        });

        function ani(data) {
            document.getElementById('readBody').style.height = "80vh";
            document.getElementById('huntInfo').style.display = "flex";

            $("#huntInfo > h1")[0].innerHTML = data.title;
        }
    </script>
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiaHlyb25vcyIsImEiOiJjazFqYW1jNnUwdml3M2tqeWxybDh0MGN6In0.i4-4y55whFwhGNAlyBQiSw';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11'
        });
    </script>

</section>