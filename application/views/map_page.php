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
  	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    }).addTo(mymap);

  	$.getJSON('<?= base_url("assets/map/").$map[0]['filename'];?>', function(data){
  		L.geoJson(data).addTo(mymap);
  	});
  </script>
</body>
</html>
