<?php

function get($resource, array $params = array()){
    $apiUrl = 'http://localhost/wp-map/wordpress-4.9.6/wordpress/wp-json';
    $json = file_get_contents($apiUrl.$resource.'?'.http_build_query($params));
    //$result = json_decode($json);
    return $json;
}
$pages = get('/wp/v2/posts');

?>
<div id="demo"></div>
<script type="text/javascript">
  var i, j, x = "";

  var test = <?php echo $pages ?>;
  console.log(test);



  //document.getElementById("demo").innerHTML = apiArrayRest.acf.markers_long.val();

</script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/core.js"></script>
<div>

</div>
