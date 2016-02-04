<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>El Caracol - Rodada</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
</head>
<body>
<div class="container">
<div class="col-md-6 col-md-offset-3">
<?php if ($_POST): ?>
<?php
	$servername = "localhost";
	$username = "userdb";
	$password = "passdb";
	$dbname = "namedb";
	$conn = new mysqli($servername, $username, $password, $dbname);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 
	$sql = "INSERT INTO reportes (latlng, personas) VALUES ('".$_POST['latlng']."', '".$_POST['personas']."')";
	if ($conn->query($sql) === TRUE) {
	    echo '<div class="alert alert-success" role="alert"><strong>Gracias!</strong> Sigue participando #ContigoSomosMas</div>';
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$conn->close();
?>
<?php endif ?>
	<form action="" method="post">
		<div class="form-group">
			<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
			<article>
				<p>Ubicación: <span id="status">buscando...</span></p>
			</article>
		</div>
		<div class="form-group">
			<label for="Personas">Número de personas</label>
			<input type="number" class="form-control" id="Personas" name="personas" placeholder="# personas" required>
		</div>
		<div class="form-group">
			<label for="Foto">Foto</label>
			<input type="file" id="Foto">
		</div>
		<div id="inphide"></div>
		<button type="submit" class="btn btn-primary btn-lg btn-block">Crear Reporte</button>
	</form>
</div>
</div>
<script>
function success(position) {
  var s = document.querySelector('#status');
  if (s.className == 'success') { 
    return;
  }
  var mapcanvas = document.createElement('div');
  mapcanvas.id = 'mapcanvas';
  mapcanvas.style.height = '125px';
  mapcanvas.style.width = '100%';
  document.querySelector('article').appendChild(mapcanvas);
  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  s.innerHTML = "localizada! latlong: " + latlng;
  s.className = 'success';
  var myOptions = {
    zoom: 15,
    center: latlng,
    mapTypeControl: false,
    navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL},
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  var map = new google.maps.Map(document.getElementById("mapcanvas"), myOptions);
  var marker = new google.maps.Marker({
      position: latlng, 
      map: map
  });
  $('#inphide').append('<input type="hidden" name="latlng" value="' + latlng + '" />');
}
  function error(msg) {
    var s = document.querySelector('#status');
    s.innerHTML = typeof msg == 'string' ? msg : "falló - asegurate de activar la geolocalización de tu dispositivo.";
    s.className = 'fail';
  }
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error);
  } else {
    error('no soportado');
  }
</script>
</body>
</html>
