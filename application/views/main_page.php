<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SIMPJANTAN</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="<?= base_url('assets/libs/Leaflet.iconlabel/src/Icon.Label.css')?>"/>
	<link rel="stylesheet" href="<?= base_url('assets/css/index.css')?>"/>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
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
	<script src="<?= base_url('assets/js/clear.form.js')?>"></script>
	<script src="<?= base_url('assets/js/leaflet.textpath.js') ?>"></script>
	<script src="<?= base_url('assets/libs/Leaflet.iconlabel/src/Icon.Label.js') ?>"></script>
	<script src="<?= base_url('assets/libs/Leaflet.iconlabel/src/Icon.Label.Default.js') ?>"></script>
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
	
	var SweetIcon = L.Icon.Label.extend({
		options: {
			iconUrl: '<?= base_url("assets/image/bitmap.png");?>',
			shadowUrl: null,
			iconSize: new L.Point(24, 24),
			iconAnchor: new L.Point(0, 0),
			labelAnchor: new L.Point(26, 0),
			wrapperAnchor: new L.Point(15, 25),
			labelClassName: 'sweet-deal-label'
		}
	});

	var mymap = L.map('mapid').setView([-7.232236136, 107.90085746], 10);
	//Group Layer
	var layerRawanLongsor = L.layerGroup().addTo(mymap);
	var layerRawanBanjir = L.layerGroup().addTo(mymap);
	var layerRawanKecalakaan = L.layerGroup().addTo(mymap);
	var layerRuasJalan = L.layerGroup().addTo(mymap);
	var layerRuasJalanCenter = L.layerGroup().addTo(mymap);
	var layerRuasJalanMarker = L.layerGroup().addTo(mymap);

	L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
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
			}).bindPopup("KM "+data[i].location).addTo(layerRawanLongsor);
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
			}).bindPopup("KM "+data[i].location).addTo(layerRawanBanjir);
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
			}).bindPopup("KM "+data[i].location).addTo(layerRawanKecalakaan);
		}
	}, 'json');

	function showLine(periode, id) {
		resetView();

		$.get('<?= base_url("ruas/getData/");?>' + id, function(data) {
			var dataJson = JSON.parse(data);
			mymap.panTo(new L.LatLng(dataJson[0].lat_awal, dataJson[0].long_awal));
			mymap.setZoom(17);
		});

		$.get('<?= base_url("ruas/getKoordinat/");?>' + id, function(data) {
			L.geoJSON(JSON.parse(data), {
				style: function(feature) {
					return {
						color: feature.properties.color,
						weight: 3
					};
				}
			}).addTo(layerRuasJalan);
		});

		$.get('<?= base_url("ruas/getLabelKoordinat/");?>' + id + '/'+ periode, function(data) {
			for (var i = 0; i < data.length; i++) {
				L.marker([data[i].latitude, data[i].longtitude], { icon: new SweetIcon({ labelText: data[i].label })}).addTo(layerRuasJalanMarker);
			}
		},'json');

		$.get('<?= base_url("ruas/getCenterKoordinat/");?>'+periode+'/'+id, function(data) {
			L.geoJSON(JSON.parse(data), {
				style: function(feature) {
					return {
						color: feature.properties.color,
						weight: 3
					};
				}
			}).addTo(layerRuasJalanCenter);
		});
	}

	function clearLine(){
		mymap.setZoom(10);
		layerRuasJalanCenter.clearLayers();
		layerRuasJalan.clearLayers();
		layerRuasJalanMarker.clearLayers();
	}

	$.get('<?= base_url("ruas/getLegenda");?>', function(data) {
		// var obj = jQuery.parseJSON();
		var content = '';
		content += '<ul>';
		content += '<li><h6>Legenda :</h6></li>';

		$.each(data, function(key, value) {
			if(value['jenis'] === "2"){
				if(value['id'] === "8"){
					content += '<hr style="margin-top:3px;margin-bottom:3px"/>';
				}
				content += '<li><div class="legenda-line" style="background-color:' + value['warna'] + '"></div> ' + value['name'] + '</li>';
			}else if(value['jenis'] === "3"){
				if(value['nilai_kondisi'] === "1"){
					content += '<hr style="margin-top:3px;margin-bottom:3px"/>';
				}
				if(value['nilai_kondisi'] > 0){
					var title = value['nilai_kondisi'] == 1 ? 'NK0-NK1' : 'NK'+value['nilai_kondisi'];
					var file = "<?php echo base_url()?>assets/image/simbol_jembatan_NK"+ value['nilai_kondisi'] +".png";
					content += '<li style="padding-top:5px"><img src="'+ file +'"> ' + title + '</li>';
				}
			}else{
				content += '<li><div class="legenda-line" style="background-color:' + value['warna'] + '"></div> ' + value['name'] + '</li>';
			}
		});
		content += '<hr style="margin-top:3px;margin-bottom:3px"/>';
		content += '<li><img src="<?php echo base_url('assets/image/rawan_longsor.png')?>"> Lokasi Rawan Longsor</li>';
		content += '<li style="padding-top:5px"><img src="<?php echo base_url('assets/image/rawan_banjir.png')?>"> Lokasi Rawan Banjir</li>';
		content += '<li style="padding-top:5px"><img src="<?php echo base_url('assets/image/rawan_kecelakaan.png')?>"> Lokasi Rawan Kecelakaan</li>';
		content += '</ul>';
		$('.sidemenu-legenda').html(content);
	},'json');

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

	Number.prototype.toMoney = function(decimals, decimal_sep, thousands_sep)
  {
     var n = this,
     c = isNaN(decimals) ? 2 : Math.abs(decimals), //if decimal is zero we must take it, it means user does not want to show any decimal
     d = decimal_sep || ',', //if no decimal separator is passed we use the dot as default decimal separator (we MUST use a decimal separator)

     /*
     according to [https://stackoverflow.com/questions/411352/how-best-to-determine-if-an-argument-is-not-sent-to-the-javascript-function]
     the fastest way to check for not defined parameter is to use typeof value === 'undefined'
     rather than doing value === undefined.
     */
     t = (typeof thousands_sep === 'undefined') ? '.' : thousands_sep, //if you don't want to use a thousands separator you can pass empty string as thousands_sep value

     sign = (n < 0) ? '-' : '',

     //extracting the absolute value of the integer part of the number and converting to string
     i = parseInt(n = Math.abs(n).toFixed(c)) + '',

     j = ((j = i.length) > 3) ? j % 3 : 0;
     return "Rp. "+sign + (j ? i.substr(0, j) + t : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : '');
  }
	</script>
</body>
</html>
