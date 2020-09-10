<div>
  <?php $this->load->view('head_side_content');?>
  <div class="div-block"></div>
  <div class="sidebar-wrapper">
    <h5>Input Data</h5>
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#hargaSatuanModal">Harga Satuan Pekerjaan</a>
      <?php if($_SESSION['is_admin'] == "1"):?>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#kategoriModal">Warna Garis</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#koordinatModal">Import Ruas Koordinat</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#penggunaModal">Pengguna</a>
      <?php endif;?>
    </div>
  </div>
  <div class="div-block"></div>
  <div class="sidebar-wrapper">
    <h5>Kemantapan Jalan</h5>
    <select class="periode select-2" name="periode" style="width:100%"></select>
    <div class="div-block"></div>
    <select class="ruas select-2" name="ruas" style="width:100%"></select>
    <div class="div-block"></div>
    <button id="btnView" class="btn btn-block btn-primary">Tampilkan Data</button>
  </div>
  <?php $this->load->view('modal_content');?>
</div>
<script>
  var tableKemantapan, tableSatuan, tablePengguna, tableKategori;
  var isShowTable = false;
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

      var $form = $('.form-satuan-pekerjaan');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
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

      var $form = $('.form-kategori');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
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
            for (i = 0; i < lines.length-1; ++i)
            {
              //no get header
              if(i>0){
                arr.push(createJSON(lines[i]));
              }
            }
            var postdata = JSON.stringify(arr);
            var $form = $('.form-koordinat');
            $.post($form.attr('action'), {body:postdata}, function(data){
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
  				"defaultContent": '<button id="btnDataView" class="btn btn-xs btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> LIHAT</button>'
  			}]
  		});
    }else{
      tableKemantapan.destroy();
      tableKemantapan = $('#listKemantapan').DataTable({
  			"ajax": '<?= base_url("ruas/getDetail/");?>'+value,
  			"columnDefs": [{
  				"targets": -1,
  				"data": null,
  				"defaultContent": '<button id="btnDataView" class="btn btn-xs btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> LIHAT</button>'
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
        showLine(id);
      });
    });
  }
</script>
