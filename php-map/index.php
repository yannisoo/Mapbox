<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.css' rel='stylesheet' />

  <link rel="stylesheet" href="css/main.css">
</head>

<body>
  <?php

    function get($resource, array $params = array()){
        $apiUrl = 'http://localhost/wp-map/wordpress-4.9.6/wordpress/wp-json';
        $json = file_get_contents($apiUrl.$resource.'?'.http_build_query($params));
        //$result = json_decode($json);
        return $json;
    }
    $pages = get('/wp/v2/posts');

  ?>

  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <div id='map' style='width: 1000px; height: 800px;'></div>

  <script src='https://npmcdn.com/@turf/turf/turf.min.js'></script>
  <script src="js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.45.0/mapbox-gl.js'></script>
  <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>

    <script type="text/javascript">

      $( document ).ready(function() {

          var test = <?php echo $pages ?>;
          var obj = '';

          mapboxgl.accessToken = 'pk.eyJ1IjoiZmstYWdlbmN5IiwiYSI6ImNqaW13d2EyOTA4dDkzcG8yNHVocTJzaHcifQ.7SRBOUB6bhBqvLI3bZkozw';
          var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/fk-agency/cjiq3tqeo1mzn2rmn637q9cnc'
          });

          el='';
          $(test).each(function() {
            el = document.createElement('div');
            el.className = 'marker ' + $(this)[0]["acf"]["color"] ;
            var marker = new mapboxgl.Marker(el)
            .setLngLat([$(this)[0]["acf"]["markers_long"], $(this)[0]["acf"]["markers_lat"]])
            .addTo(map);
          });

                    map.on('load', function() {
            getRoute();
          });

          function getRoute() {
            var start = [test[0]["acf"]["markers_long"], test[0]["acf"]["markers_lat"]];
            var end = [test[2]["acf"]["markers_long"], test[2]["acf"]["markers_lat"]];
            var directionsRequest = 'https://api.mapbox.com/directions/v5/mapbox/cycling/' + start[0] + ',' + start[1] + ';' + end[0] + ',' + end[1] + '?steps=true&geometries=geojson&access_token=' + mapboxgl.accessToken;
            $.ajax({
              method: 'GET',
              url: directionsRequest,
            }).done(function(data) {
              console.log(data);
              var route = data.routes[0].geometry;
              map.addLayer({
                id: 'route',
                type: 'line',
                source: {
                  type: 'geojson',
                  data: {
                    type: 'Feature',
                    geometry: route
                  }
                },
                paint: {
                  'line-color': '#3887be',
                   'line-width': {
                    base: 1,
                    stops: [[12, 3], [22, 12]]
                }}
              });
              // this is where the code from the next step will go
            });
          }

      });


  </script>


  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto'); ga('send', 'pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>
