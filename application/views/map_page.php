<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
	<title>MAP</title>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
  <style>
  #mapid {
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 100%;
  }
  </style>
</head>
<body>
  <div id="mapid"></div>
  <script>
    $(document).ready(function() {

  	});

  	var mymap = L.map('mapid').setView([-7.232236136, 107.90085746], 10);
    console.log(mymap);
  	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
  		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
  		maxZoom: 18,
  		id: 'mapbox/streets-v11',
  		tileSize: 512,
  		zoomOffset: -1,
  		accessToken: 'pk.eyJ1IjoiaGFuaWZrNDA0IiwiYSI6ImNrZWY1enl6cTE4ZnUyc3J2eGZobXo1cXUifQ.88_Q6x8ktPdlE-FtCUZT-g'
  	}).addTo(mymap);

  	$.getJSON('<?= base_url("assets/map/").$map[0]['filename'];?>', function(data){
  		L.geoJson(data).addTo(mymap);
  	});
  </script>
</body>
</html>
