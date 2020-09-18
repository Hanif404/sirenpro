<div>
  <?php $this->load->view('head_side_content');?>
  <div class="div-block"></div>
  <div class="sidebar-wrapper">
    <h5>Input Data</h5>
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#hargaSatuanModal">Harga Satuan Pekerjaan</a>
      <?php if($_SESSION['is_admin'] == "1"):?>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#kategoriModal">Warna Garis</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#koordinatModal">Import Koordinat Jalan</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#penggunaModal">Pengguna</a>
      <?php endif;?>
    </div>
  </div>
  <div class="sidebar-wrapper">
    <h5>Kemantapan Jalan</h5>
    <select class="periode select-2" name="periode" style="width:100%"></select>
    <div class="div-block"></div>
    <select class="daerah select-2" name="daerah" style="width:100%">
      <option value=""></option>
      <option value="garut">Garut</option>
      <option value="sumedang">Sumedang</option>
    </select>
    <div class="div-block"></div>
    <select class="ksp select-2" name="ksp" style="width:100%"></select>
    <div class="div-block"></div>
    <select class="ruas select-2" name="ruas" style="width:100%"></select>
    <div class="div-block"></div>
    <button id="btnView" class="btn btn-block btn-primary disabled">Tampilkan Data</button>
    <button id="btnRekap" class="btn btn-block btn-success disabled">Rekap Data</button>
  </div>
  <?php $this->load->view('modal_content');?>
</div>
<script>
  var tableKemantapan, tableSatuan, tablePengguna, tableKategori;
  var isShowTable = false;
  var selectDaerah = "";
  $(document).ready(function() {
    loadDropdown();
    loadSatuanPekerjaanForm();
    loadPenggunaForm();
    loadKategoriForm();
    loadKoordinatForm();
  });

  function loadSatuanPekerjaanForm(){
    tableSatuan = $('#listHargaSatuan').DataTable({
      "ajax": '<?= base_url("satuan");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('#btnSubmitSatuan').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-satuan-pekerjaan');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
          blockHide();
          if(data.code === 200){
            Swal.fire({
              icon: 'success',
              title: 'Submit Data',
              text: 'Data berhasil tersimpan'
            })
            $('.form-satuan-pekerjaan')[0].reset();
            tableSatuan.ajax.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Submit Data',
              text: 'Gagal menyimpan data'
            })
          }
        }, 'json');
      }
      return false;
    });

    $('.form-satuan-pekerjaan').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			jenis_pekerjaan : {
  				required: true
  			},
  			harga_pekerjaan : {
  				required: true
  			},
  			satuan_pekerjaan : {
  				required: true
  			}
  		}
  	});

    $('#listHargaSatuan tbody').on( 'click', '#btnEdit', function () {
  		var data = tableSatuan.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("satuan/getDetailItem/");?>' + data[3], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id_pekerjaan]').val(dataJson.data[0].id);
          $('input[name=jenis_pekerjaan]').val(dataJson.data[0].nama);
          $('input[name=harga_pekerjaan]').val(dataJson.data[0].harga);
          $('input[name=satuan_pekerjaan]').val(dataJson.data[0].satuan);
        }
      }, 'json');
  	});

    $('#listHargaSatuan tbody').on( 'click', '#btnDelete', function () {
  		var data = tableSatuan.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("satuan/deleteItem/");?>' + data[3], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    tableSatuan.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }

  function loadPenggunaForm(){
    tablePengguna = $('#listPengguna').DataTable({
      "ajax": '<?= base_url("pengguna");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('#btnSubmitPengguna').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-pengguna');
      if ($form.valid()){
        var data_input = new FormData();

        //Form data
        var form_data = $form.serializeArray();
        $.each(form_data, function (key, input) {
            data_input.append(input.name, input.value);
        });

        //File data
        var file_data = $('input[name="file_image"]')[0].files;
        for (var i = 0; i < file_data.length; i++) {
            data_input.append("file_image", file_data[i]);
        }
        $.ajax({
            url: $form.attr('action'),
            dataType:'json',
            method: "post",
            processData: false,
            contentType: false,
            data: data_input,
            success: function (data) {
                blockHide();
                if(data.code === 200){
                  Swal.fire({
                    icon: 'success',
                    title: 'Submit Data',
                    text: 'Data berhasil tersimpan'
                  })
                  $('.form-pengguna').validate().settings.ignore = "input[type=hidden]";
                  $('.form-pengguna')[0].reset();
                  $('.is-active').val("1"); // Select the option with a value of '1'
                  $('.is-active').trigger('change'); // Notify any JS components that the value changed
                  tablePengguna.ajax.reload();
                }else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Submit Data',
                    text: 'Gagal menyimpan data'
                  })
                }
            },
            error: function (e) {
                //error
            }
        });
      }
      return false;
    });

    $('.form-pengguna').validate({
      ignore: 'input[type=hidden]',
      rules: {
        nama : {
          required: true
        },
        email : {
          required: true
        },
        password : {
          required: true
        }
      }
    });

    $('#listPengguna tbody').on( 'click', '#btnEdit', function () {
      var data = tablePengguna.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("pengguna/getDetailItem/");?>' + data[4], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=nama]').val(dataJson.data[0].nama);
          $('input[name=email]').val(dataJson.data[0].email);
          $('input[name=nip]').val(dataJson.data[0].nip);
          $('input[name=password_old]').val(dataJson.data[0].password);
          $('input[name=file_profile_old]').val(dataJson.data[0].photo);

          $('.form-pengguna').validate().settings.ignore = "input[name=password]";
          $('.is-active').val(dataJson.data[0].is_active); // Select the option with a value of '1'
          $('.is-active').trigger('change'); // Notify any JS components that the value changed
        }
      }, 'json');
    });

    $('#listPengguna tbody').on( 'click', '#btnDelete', function () {
      var data = tablePengguna.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("pengguna/deleteItem/");?>' + data[4], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    tablePengguna.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
    });
  }

  function loadKategoriForm(){
    tableKategori = $('#listKategori').DataTable({
      "ajax": '<?= base_url("kategori");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('#btnSubmitKategori').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-kategori');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
          blockHide();
          if(data.code === 200){
            Swal.fire({
              icon: 'success',
              title: 'Submit Data',
              text: 'Data berhasil tersimpan'
            })
            $('.form-kategori')[0].reset();
            tableKategori.ajax.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Submit Data',
              text: 'Gagal menyimpan data'
            })
          }
        }, 'json');
      }
      return false;
    });

    $('.form-kategori').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			name : {
  				required: true
  			},
  			warna : {
  				required: true
  			}
  		}
  	});

    $('#listKategori tbody').on( 'click', '#btnEdit', function () {
  		var data = tableKategori.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("kategori/getDetailItem/");?>' + data[2], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=name]').val(dataJson.data[0].name);
          $('input[name=warna]').val(dataJson.data[0].warna);
        }
      }, 'json');
  	});

    $('#listKategori tbody').on( 'click', '#btnDelete', function () {
  		var data = tableKategori.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("kategori/deleteItem/");?>' + data[2], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    tableKategori.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }

  function loadKoordinatForm(){
    $('#btnSubmitKoordinat').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var filecsv = $("input[name=file_csv]")[0].files[0];
      var ext = $("input[name=file_csv]").val().split(".").pop().toLowerCase();
      if($.inArray(ext, ["csv"]) == -1) {
        alert('Upload CSV');
        return false;
      }
      if (filecsv != undefined) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var arr = [];
            var lines = e.target.result.split('\r\n');
            var dataSplit = lines[1].split(";");

            var main = {};
            main["no_ruas"] = dataSplit[0];
            for (i = 0; i < lines.length-1; ++i)
            {
              //no get header
              if(i>0){

                arr.push(createJSON(lines[i]));
              }
            }
            main["data"] = arr;

            var postdata = JSON.stringify(main);
            var $form = $('.form-koordinat');
            $.post($form.attr('action'), {body:postdata}, function(data){
              blockHide();
              if(data.code === 200){
                Swal.fire({
                  icon: 'success',
                  title: 'Submit Data',
                  text: 'Data berhasil tersimpan'
                }).then((result) => {
                  if (result.isConfirmed) {
                    location.reload();
                  }
                });
              }else{
                Swal.fire({
                  icon: 'error',
                  title: 'Submit Data',
                  text: 'Gagal menyimpan data'
                }).then((result) => {
                  if (result.isConfirmed) {
                    $("input[name=file_csv]").val('');
                  }
                });
              }
            }, 'json');
        };
        reader.readAsText(filecsv);
      }
      return false;
    });

    function createJSON(data) {
      var dataSplit = data.split(";");

      item = {}
      item["hash"] = $.md5(dataSplit[0]+dataSplit[2]+dataSplit[3]);
      item["lat_data"] = dataSplit[4];
      item["long_data"] = dataSplit[5];
      return item;
    }
  }

  $('#btnView').click(function(){
    var value = $('.ruas').val();
    if(value != null){
      showTable(value);
      $('#contentData').show();
      $('.sidemenu-legenda').css("bottom", "200px");
      $('#mapid').css("bottom", "205px");
    }
  });

  $('#btnRekap').click(function(){
    $('#rekapModal').modal('show');
    var periode = $(".periode option:selected").val();
    var daerah = $(".daerah option:selected").val();
    var ksp = $(".ksp option:selected").val();
    $('.tableRekap').empty();
    viewRekap1(periode, daerah, ksp);
  });

  function viewRekap1(periode, daerah, ksp){
    var header = '<tr class="table-header"> <th rowspan="3">No</th> <th rowspan="3">Nama ruas jalan</th> <th rowspan="3">Kuantitas</th> <th rowspan="3">total</th> <th colspan="7">kondisi jalan</th> </tr> <tr class="table-header"> <th colspan="3">mantap</th> <th colspan="4">tidak mantap</th> </tr> <tr class="table-header"> <th>sangat baik</th> <th>baik</th> <th>sedang</th> <th>jelek</th> <th>parah</th> <th>sangat parah</th> <th>hancur</th> </tr>';
    $('.tableRekap').append(header);
    $.post("<?php echo base_url('ruas/getDataRekap')?>", {periode:periode, daerah:daerah, ksp:ksp}, function(data){
      var urut = 1;
      var total_all = 0, total_luas = 0;
      var total_1 = 0, persentase_1 = 0, total_km_1 = 0;
      var total_2 = 0, persentase_2 = 0, total_km_2 = 0;
      var total_3 = 0, persentase_3 = 0, total_km_3 = 0;
      var total_4 = 0, persentase_4 = 0, total_km_4 = 0;
      var total_5 = 0, persentase_5 = 0, total_km_5 = 0;
      var total_6 = 0, persentase_6 = 0, total_km_6 = 0;
      var total_7 = 0, persentase_7 = 0, total_km_7 = 0;
      for (var i = 0; i < data.length; i++) {
        var view_luas = parseFloat(data[i].total_m2_all);
        var view_m2_1 = parseFloat(data[i].total_m2_1);
        var view_m2_2 = parseFloat(data[i].total_m2_2);
        var view_m2_3 = parseFloat(data[i].total_m2_3);
        var view_m2_4 = parseFloat(data[i].total_m2_4);
        var view_m2_5 = parseFloat(data[i].total_m2_5);
        var view_m2_6 = parseFloat(data[i].total_m2_6);
        var view_m2_7 = parseFloat(data[i].total_m2_7);
        var view_km_1 = parseFloat(data[i].total_km_1);
        var view_km_2 = parseFloat(data[i].total_km_2);
        var view_km_3 = parseFloat(data[i].total_km_3);
        var view_km_4 = parseFloat(data[i].total_km_4);
        var view_km_5 = parseFloat(data[i].total_km_5);
        var view_km_6 = parseFloat(data[i].total_km_6);
        var view_km_7 = parseFloat(data[i].total_km_7);

        var content = "<tr class=\"table-body\">";
        content += "<td>"+ urut +"</td>";
        content += "<td>"+data[i].nama_ruas+"</td>";
        content += "<td>M2<br/>KM</td>";
        content += "<td>"+view_luas.toFixed(3)+"<br/>"+parseFloat(data[i].panjang).toFixed(3)+"</td>";
        content += "<td>"+view_m2_1.toFixed(3)+"<br/>"+view_km_1.toFixed(3)+"</td>";
        content += "<td>"+view_m2_2.toFixed(3)+"<br/>"+view_km_2.toFixed(3)+"</td>";
        content += "<td>"+view_m2_3.toFixed(3)+"<br/>"+view_km_3.toFixed(3)+"</td>";
        content += "<td>"+view_m2_4.toFixed(3)+"<br/>"+view_km_4.toFixed(3)+"</td>";
        content += "<td>"+view_m2_5.toFixed(3)+"<br/>"+view_km_5.toFixed(3)+"</td>";
        content += "<td>"+view_m2_6.toFixed(3)+"<br/>"+view_km_6.toFixed(3)+"</td>";
        content += "<td>"+view_m2_7.toFixed(3)+"<br/>"+view_km_7.toFixed(3)+"</td>";
        content += "</tr>";
        $('.tableRekap').append(content);

        // Total
        total_luas = parseFloat(total_luas) + view_luas;
        total_all = parseFloat(total_all) + parseFloat(data[i].panjang);
        total_1 = parseFloat(total_1) + view_m2_1;
        total_2 = parseFloat(total_2) + view_m2_2;
        total_3 = parseFloat(total_3) + view_m2_3;
        total_4 = parseFloat(total_4) + view_m2_4;
        total_5 = parseFloat(total_5) + view_m2_5;
        total_6 = parseFloat(total_6) + view_m2_6;
        total_7 = parseFloat(total_7) + view_m2_7;
        total_km_1 = parseFloat(total_km_1) + view_km_1;
        total_km_2 = parseFloat(total_km_2) + view_km_2;
        total_km_3 = parseFloat(total_km_3) + view_km_3;
        total_km_4 = parseFloat(total_km_4) + view_km_4;
        total_km_5 = parseFloat(total_km_5) + view_km_5;
        total_km_6 = parseFloat(total_km_6) + view_km_6;
        total_km_7 = parseFloat(total_km_7) + view_km_7;

        urut++;
      }
      // Persentase
      persentase_1 = (total_1/total_luas) * 100;
      persentase_2 = (total_2/total_luas) * 100;
      persentase_3 = (total_3/total_luas) * 100;
      persentase_4 = (total_4/total_luas) * 100;
      persentase_5 = (total_5/total_luas) * 100;
      persentase_6 = (total_6/total_luas) * 100;
      persentase_7 = (total_7/total_luas) * 100;

      // add footer total
      var content = "<tr class=\"table-body\">";
      content += "<td></td>";
      content += "<td>Jumlah</td>";
      content += "<td></td>";
      content += "<td>"+total_all.toFixed(3)+"</td>";
      content += "<td>"+total_1.toFixed(3)+"</td>";
      content += "<td>"+total_2.toFixed(3)+"</td>";
      content += "<td>"+total_3.toFixed(3)+"</td>";
      content += "<td>"+total_4.toFixed(3)+"</td>";
      content += "<td>"+total_5.toFixed(3)+"</td>";
      content += "<td>"+total_6.toFixed(3)+"</td>";
      content += "<td>"+total_7.toFixed(3)+"</td>";
      content += "</tr>";
      $('.tableRekap').append(content);

      // add footer presentasi
      var content = "<tr class=\"table-body\">";
      content += "<td></td>";
      content += "<td>Persentasi</td>";
      content += "<td></td>";
      content += "<td></td>";
      content += "<td>"+persentase_1.toFixed(3)+"%</td>";
      content += "<td>"+persentase_2.toFixed(3)+"%</td>";
      content += "<td>"+persentase_3.toFixed(3)+"%</td>";
      content += "<td>"+persentase_4.toFixed(3)+"%</td>";
      content += "<td>"+persentase_5.toFixed(3)+"%</td>";
      content += "<td>"+persentase_6.toFixed(3)+"%</td>";
      content += "<td>"+persentase_7.toFixed(3)+"%</td>";
      content += "</tr>";
      $('.tableRekap').append(content);

      var km_mantap = total_km_1+total_km_2+total_km_3;
      var km_tmantap = total_km_4+total_km_5+total_km_6+total_km_7;
      $('#km_mantap').text(km_mantap.toFixed(2)+" Km");
      $('#km_tmantap').text(km_tmantap.toFixed(2)+" Km");

      var persentase_mantap = persentase_1+persentase_2+persentase_3;
      var persentase_tmantap = persentase_4+persentase_5+persentase_6+persentase_7;
      $('#persentase_mantap').text(persentase_mantap.toFixed(2)+" %");
      $('#persentase_tmantap').text(persentase_tmantap.toFixed(2)+" %");
    }, 'json');
  }

  function resetView(){
    $('#contentData').hide();
    $('.sidemenu-legenda').css("bottom", "0px");
  }

  function showTable(value) {
    if(isShowTable === false){
      isShowTable=true;
  	  tableKemantapan = $('#listKemantapan').DataTable({
  			"ajax": '<?= base_url("ruas/getDetail/");?>'+value,
  			"columnDefs": [{
  				"targets": -1,
  				"data": null,
  				"defaultContent": '<button id="btnDataView" class="btn btn-xs btn-primary btn-margin-bottom">LIHAT</button>'
  			}]
  		});
    }else{
      tableKemantapan.destroy();
      tableKemantapan = $('#listKemantapan').DataTable({
  			"ajax": '<?= base_url("ruas/getDetail/");?>'+value,
  			"columnDefs": [{
  				"targets": -1,
  				"data": null,
  				"defaultContent": '<button id="btnDataView" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> LIHAT</button>'
  			}]
  		});
    }

    $('#listKemantapan tbody').on( 'click', '#btnDataView', function () {
  		var data = tableKemantapan.row( $(this).parents('tr') ).data();
      var dataJson = JSON.parse(data[9]);
      mymap.setView([dataJson.latitude, dataJson.longtitude], 18);
      L.popup()
        .setLatLng([dataJson.latitude, dataJson.longtitude])
        .setContent("Kategori : "+ data[6])
        .openOn(mymap);
  	});
	}

  function loadDropdown(){
    $('.is-active').select2({
      placeholder: "Pilih Active",
      allowClear: false,
      minimumResultsForSearch: Infinity
    });

    $('.daerah').select2({
      placeholder: "Pilih Kabupaten/Kota",
      allowClear: true,
      minimumResultsForSearch: Infinity
    }).on('select2:select', function(e) {
      var id = e.params.data.id;
      loadKsp(id);
    });
    loadKsp("");

    function loadKsp(id){
      $('.ksp').select2({
        placeholder: "Pilih KSP",
        allowClear: true,
        ajax: {
            url: "<?= base_url('ruas/getComboKsp/') ?>"+id,
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, page) {
              return {
                results: $.map(data, function(obj) {
                    return { id: obj.id, text: obj.nama };
                })
              };
            },
            cache: false
          }
      });
    }

    $('.ruas').select2({
      placeholder: "Pilih Ruas",
      allowClear: true,
    });

    $('.periode').select2({
      placeholder: "Pilih Periode",
      allowClear: true,
      ajax: {
          url: "<?= base_url('periode/getCombo') ?>",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
              page: params.page
            };
          },
          processResults: function (data, page) {
            return {
              results: $.map(data, function(obj) {
                  return { id: obj.id, text: obj.nama };
              })
            };
          },
          cache: true
        }
    }).on('select2:select', function(e) {
      var id = e.params.data.id;
      $('#btnRekap').removeClass('disabled');

      $('.ruas').select2({
        placeholder: "Pilih Ruas",
        allowClear: true,
        ajax: {
            url: "<?= base_url('ruas/getCombo/') ?>"+id,
            dataType: 'json',
            delay: 250,
            data: function (params) {
              return {
                q: params.term, // search term
                page: params.page
              };
            },
            processResults: function (data, page) {
              return {
                results: $.map(data, function(obj) {
                    return { id: obj.id, text: obj.nama };
                })
              };
            },
            cache: true
          }
      }).on('select2:select', function(e) {
        var id = e.params.data.id;

        $('#btnView').removeClass('disabled');
        showLine(id);
      }).on('select2:clear', function(e) {
        clearLine();
        $('#btnView').addClass('disabled');
        $('#contentData').hide();
        $('.sidemenu-legenda').css("bottom", "0px");
        $('#mapid').css("bottom", "0px");
      });
    });
  }
</script>
