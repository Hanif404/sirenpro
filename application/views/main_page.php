<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SIRENPRO</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css" integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==" crossorigin=""/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?= base_url('assets/css/index.css')?>"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js" integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==" crossorigin=""></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/js/all.min.js" integrity="sha512-YSdqvJoZr83hj76AIVdOcvLWYMWzy6sJyIMic2aQz5kh2bPTd9dzY3NtdeEAzPp/PhgZqr4aJObB3ym/vsItMg==" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/1.0.11/jquery.csv.min.js" integrity="sha512-Y8iWYJDo6HiTo5xtml1g4QqHtl/PO1w+dmUpQfQSOTqKNsMhExfyPN2ncNAe9JuJUSKzwK/b6oaNPop4MXzkwg==" crossorigin="anonymous"></script>
	<script src="<?= base_url('assets/js/jquery.md5.js')?>"></script>
	<script src="<?= base_url('assets/js/jquery.loading.block.js')?>"></script>
</head>
<body>
	<?php $this->load->view('main_right_content'); ?>
  <div class="container-fluid main-page" style="padding:0px !important;">
    <div class="row">
      <div class="col-lg-3" collapse style="padding-right:0px !important;height: 100vh;">
        <?php $this->load->view('main_side_content'); ?>
      </div>
      <div class="col-lg-9" style="padding-left:0px !important;">
        <div id="mapid"></div>
				<div id="contentData" class="content-view shadow">
					<table id="listKemantapan" class="table table-striped table-bordered" style="width:100%">
							<thead>
									<tr>
											<th>Panjang</th>
											<th>Lebar</th>
											<th>Luas</th>
											<th>KM Awal</th>
											<th>KM Akhir</th>
											<th>Posisi</th>
											<th>Kategori</th>
											<th>Nama Survey</th>
											<th>Tgl. Survey</th>
											<th>&nbsp;</th>
									</tr>
							</thead>
					</table>
				</div>
      </div>
    </div>
  </div>
	<script>
	$(document).ready(function() {

	});

	var ruasLayer;
	var mymap = L.map('mapid').setView([-7.232236136, 107.90085746], 10);
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		maxZoom: 18,
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1,
		accessToken: 'pk.eyJ1IjoiaGFuaWZrNDA0IiwiYSI6ImNrZWY1enl6cTE4ZnUyc3J2eGZobXo1cXUifQ.88_Q6x8ktPdlE-FtCUZT-g'
	}).addTo(mymap);

	$.getJSON('<?= base_url("assets/map/wilayah_kerja_uptd4.geojson");?>', function(data){
		L.geoJson(data).addTo(mymap);
	});

	$.getJSON('<?= base_url("assets/map/jalan_propinsi_all.geojson");?>', function(data){
		L.geoJson(data, {
			style: function(feature) {
				return {
					color: "#000",
					weight: 1
				};
			}
		}).addTo(mymap);
	});

	$.get('<?= base_url("rawan/getLongsor");?>', function(data) {
		for (var i = 0; i < data.length; i++) {
			var latlng = new L.LatLng(data[i].latitude, data[i].longtitude)
			var marker = L.marker(latlng, {
			  icon: L.icon({
			    iconUrl: '<?= base_url("assets/image/rawan_longsor.png")?>',
			    className: 'blinking'
			  })
			}).bindPopup("KM "+data[i].lokasi).addTo(mymap);
		}
	}, 'json');

	$.get('<?= base_url("rawan/getBanjir");?>', function(data) {
		for (var i = 0; i < data.length; i++) {
			var latlng = new L.LatLng(data[i].latitude, data[i].longtitude)
			var marker = L.marker(latlng, {
				icon: L.icon({
					iconUrl: '<?= base_url("assets/image/rawan_banjir.png")?>',
					className: 'blinking'
				})
			}).bindPopup("KM "+data[i].lokasi).addTo(mymap);
		}
	}, 'json');

	$.get('<?= base_url("rawan/getKecelakaan");?>', function(data) {
		for (var i = 0; i < data.length; i++) {
			var latlng = new L.LatLng(data[i].latitude, data[i].longtitude)
			var marker = L.marker(latlng, {
				icon: L.icon({
					iconUrl: '<?= base_url("assets/image/rawan_kecelakaan.png")?>',
					className: 'blinking'
				})
			}).bindPopup("KM "+data[i].lokasi).addTo(mymap);
		}
	}, 'json');

	function showLine(id) {
		resetView();

		$.get('<?= base_url("ruas/getData/");?>' + id, function(data) {
			var dataJson = JSON.parse(data);
			mymap.panTo(new L.LatLng(dataJson[0].lat_awal, dataJson[0].long_awal));
			mymap.setZoom(17);
		});

		$.get('<?= base_url("ruas/getKoordinat/");?>' + id, function(data) {
			ruasLayer = L.geoJSON(JSON.parse(data), {
				style: function(feature) {
					return {
						color: feature.properties.color,
						weight: 3
					};
				}
			}).addTo(mymap);
		});
	}

	function clearLine(){
		mymap.setZoom(10);
		mymap.removeLayer(ruasLayer);
	}

	$.get('<?= base_url("ruas/getLegenda");?>', function(data) {
		var obj = jQuery.parseJSON(data);
		var content = '';
		content += '<ul>';
		content += '<li><h6>Legenda :</h6></li>';

		$.each(obj, function(key, value) {
			content += '<li><div class="legenda-line" style="background-color:' + value['warna'] + '"></div> ' + value['name'] + '</li>';
		});
		content += '<li><img src="<?php echo base_url('assets/image/rawan_longsor.png')?>"> Lokasi Rawan Longsor</li>';
		content += '<li style="padding-top:5px"><img src="<?php echo base_url('assets/image/rawan_banjir.png')?>"> Lokasi Rawan Banjir</li>';
		content += '<li style="padding-top:5px"><img src="<?php echo base_url('assets/image/rawan_kecelakaan.png')?>"> Lokasi Rawan Kecelakaan</li>';
		content += '</ul>';
		$('.sidemenu-legenda').html(content);
	});

	$.get('<?= base_url("auth/getProfile");?>', function(data) {
		var result = JSON.parse(data);
		if (result.code == 200) {
			var url = '<?= base_url("assets/image/upload/");?>' + result.data[0].photo;

			$('#profile_name').text(result.data[0].nama);
			$('#profile_nip').text(result.data[0].nip);
			$('.profile_photo').attr("src", url);
		}
	});

	function blockShow(){
		$.loadingBlockShow({
		 imgPath: '<?php echo base_url() ?>assets/image/icon.gif',
		 imgStyle: {
			 width: 'auto',
			 textAlign: 'center',
			 marginTop: '20%'
		 },
		 style: {
				position: 'fixed',
				width: '100%',
				height: '100%',
				background: 'rgba(0, 0, 0, .8)',
				left: 0,
				top: 0,
				zIndex: 10000
			}
		});
	}

	function blockHide(){
		$.loadingBlockHide();
	}
	</script>
</body>
</html>
