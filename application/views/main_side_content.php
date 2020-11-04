<div style="top: 0;bottom:0;position:fixed;overflow-y:scroll;overflow-x:hidden;width: 24%;">
  <?php $this->load->view('head_side_content');?>
  <div class="div-block" style="margin-top:40px"></div>
  <div class="sidebar-wrapper">
    <h5>Input Data</h5>
    <div class="list-group list-group-flush">
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#penangananModal">Program Penanganan</a>
      <?php if($_SESSION['is_admin'] == "1" || $_SESSION['is_admin'] == "2" ):?>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#pekerjaanModal">Harga Satuan Pekerjaan</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#jenisKerjaModal">Jenis Pekerjaan</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#rawanModal">Rawan Bencana</a>
      <?php endif;?>
      <?php if($_SESSION['is_admin'] == "1"):?>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#kategoriModal">Warna Garis</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#koordinatModal">Import Koordinat Jalan</a>
      <a href="#" class="list-group-item list-group-item-action bg-light" data-toggle="modal" data-target="#penggunaModal">Pengguna</a>
      <?php endif;?>
    </div>
  </div>
  <div class="sidebar-wrapper" style="padding-bottom: 10px;">
    <h5>Skema Kemantapan Jalan</h5>
    <select class="periode select-2" name="periode" style="width:100%"></select>
    <div class="div-block"></div>
    <select class="ruas select-2" name="ruas" style="width:100%"></select>
    <div class="div-block"></div>
    <div class="div-block"></div>
    <h5>Tabel Rekap Kemantapan</h5>
    <select class="periode select-2" id="periodeRekap" style="width:100%"></select>
    <div class="div-block"></div>
    <select class="daerah select-2" name="daerah" id="cbDaerah" style="width:100%">
      <option value="">Pilih Semua</option>
      <option value="garut">Garut</option>
      <option value="sumedang">Sumedang</option>
    </select>
    <div class="div-block"></div>
    <!-- <p style="margin-bottom: 0px;">Rekap berdasarkan KSP</p> -->
    <!-- <select class="ksp select-2" name="ksp" style="width:100%"></select>
    <div class="div-block"></div> -->
    <!-- <button id="btnView" class="btn btn-block btn-primary disabled">Tampilkan Data</button> -->
    <button id="btnRekap" class="btn btn-block btn-success disabled">Rekap Data</button>
  </div>
</div>
<script>
  var tableKemantapan, tablePekerjaan, tablePengguna, tableKategori, tableRawan, tableJenisKerja, tablePenanganan, tablePenangananDet;
  var isShowTable = false;
  var selectDaerah = "";
  var isAdmin = "<?= $_SESSION['is_admin'] ?>";
  $(document).ready(function() {
    loadDropdown();
    // loadPenangananDetForm();
    loadPenangananForm();
    loadPekerjaanForm();
    loadJenisKerjaForm();
    loadPenggunaForm();
    loadKategoriForm();
    loadKoordinatForm();
    loadRawanForm();
  });

  function hitungBiaya(val){
    var harga = $('#fieldHargaPekerjaan').val();
    var total = parseFloat(val) * parseFloat(harga);
    $('#fieldBiayaPenanganan').val(total.toMoney());
  }

  function loadPenangananDetForm(hash){
    var aksiField = "";
    if(isAdmin == 2 || isAdmin == 1){
      $('.form-penanganan').show();
      aksiField = '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>';
    }

    $('#listPenangananDet').DataTable().clear().destroy();
    tablePenangananDet = $('#listPenangananDet').DataTable({
      "ajax": '<?= base_url("penanganan/listDetail/");?>'+hash,
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": aksiField
      }]
    });

    $('.btn-close-penangananDet').on('click', function(){
      resetForm();
      $('#penangananDetModal').modal('hide');
      $('#penangananModal').modal('show');
    });

    function resetForm(){
      $('.form-penanganan')[0].reset();
      $('#fieldJnsPekerjaan').val(null).trigger('change');
    }

    $('#btnSubmitPenangananDet').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();
      var hrg = $('#fieldHargaPekerjaan').val();

      var $form = $('.form-penanganan');
      if ($form.valid()){
        if(hrg > 0){
          $.post($form.attr('action'), $form.serialize(), function(data){
            blockHide();
            if(data.code === 200){
              Swal.fire({
                icon: 'success',
                title: 'Submit Data',
                text: 'Data berhasil tersimpan'
              })
              resetForm();
              tablePenangananDet.ajax.reload();
            }else{
              Swal.fire({
                icon: 'error',
                title: 'Submit Data',
                text: 'Gagal menyimpan data'
              })
            }
          }, 'json');
        }else{
          blockHide();
          Swal.fire({
            icon: 'error',
            title: 'Submit Data',
            text: 'Harga masih kosong'
          })
        }
      }else{
        blockHide();
      }
      return false;
    });

    $('.form-penanganan').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			jenis_id : {
  				required: true
  			},
  			volume : {
  				required: true
  			}
  		}
  	});

    $('#listPenangananDet tbody').on( 'click', '#btnEdit', function (e) {
      e.stopImmediatePropagation();
  		var data = tablePenangananDet.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("penanganan/getDetailItem/");?>' + data[5], function(data) {
        if(data.code === 200){
          $('input[name=id]').val(data.data[0].id);
          $('input[name=volume]').val(data.data[0].volume);
          $('input[name=harga]').val(data.data[0].harga);
          $('#viewHargaPekerjaan').val(data.data[0].harga_text);
          $('#fieldBiayaPenanganan').val(data.data[0].total.toMoney());

          var newOption = new Option(data.data[0].jenis_text, data.data[0].jenis_id, true, true);
          $('#fieldJnsPekerjaan').append(newOption).trigger('change');
        }
      }, 'json');
  	});

    $('#listPenangananDet tbody').on( 'click', '#btnDelete', function (e) {
      e.stopImmediatePropagation();

  		var data = tablePenangananDet.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("penanganan/deleteItem/");?>' + data[5], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    resetForm();
                    tablePenangananDet.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }

  function loadPenangananForm(){
    tablePenanganan = $('#listPenanganan').DataTable();

    $('.btn-close-penanganan').on('click', function(){
      resetForm();
      $('#penangananModal').modal('hide');
    });

    function resetForm(){
      $('#fieldPeriode').val(null).trigger('change');
      $('#fieldNoRuas').val(null).trigger('change');
      $('#fieldAwalKm').val(null).trigger('change');
      $('#fieldAkhirKm').val(null).trigger('change');

      $('#listPenanganan').DataTable().clear().destroy();
      tablePenanganan = $('#listPenanganan').DataTable();
    }

    $('#btnViewPenanganan').on('click', function(e){
      var periode = $('#fieldPeriode').val();
      var no_ruas = $('#fieldNoRuas').val();
      var awal = $('#fieldAwalKm').val();
      var akhir = $('#fieldAkhirKm').val();
      if(periode != "" && no_ruas != "" && awal != "" && akhir != ""){
        $('#listPenanganan').DataTable().clear().destroy();
        tablePenanganan = $('#listPenanganan').DataTable({
          "ajax": '<?= base_url("penanganan/index/");?>'+no_ruas+'/'+periode+'/'+awal+'/'+akhir,
          "ordering": false,
          "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-eye" ></i> detail</button>'
          }]
        });
      }else{
        Swal.fire({
          icon: 'error',
          title: 'View Data',
          text: 'Field salah atau tidak boleh kosong'
        })
      }
    });

    $('#btnViewPdf').on('click', function(e){
      $('#viewRekap').hide();
      $('#viewPenanganan').hide();
      $('#viewAllPenanganan').hide();

      var periode = $('#fieldPeriode').select2("val");
      var noruas = $('#fieldNoRuas').select2("val");
      var kmAwal = $('#fieldAwalKm').select2("val");
      var kmAkhir = $('#fieldAkhirKm').select2("val");
      if(periode !== null && noruas !== null && kmAwal !== null && kmAkhir !== null){
        $('#penangananModal').modal('hide');
        $('#viewPenangananModal').modal('show');
      }else if(periode !== null && noruas == null && kmAwal == null && kmAkhir == null){
        $('#viewAllPenanganan').show();
        $('.rekap4').empty();
        viewAllPenangananRekap(periode, noruas, kmAwal, kmAkhir, null);

        $('#penangananModal').modal('hide');
        $('#rekapModal').modal('show');
      }else if(periode == null && noruas == null && kmAwal == null && kmAkhir == null){
        Swal.fire({
          icon: 'error',
          title: 'View Data',
          text: 'Field periode tidak boleh kosong untuk menampilkan rekapitulasi'
        })
      }else{
        Swal.fire({
          icon: 'error',
          title: 'View Data',
          text: 'Semua field tidak boleh kosong untuk menampilkan laporan per jenis penanganan'
        })
      }
    });

    $('#btnReviewPdf').on('click', function(e){
      var periode = $('#fieldPeriode').select2("val");
      var noruas = $('#fieldNoRuas').select2("val");
      var kmAwal = $('#fieldAwalKm').select2("val");
      var kmAkhir = $('#fieldAkhirKm').select2("val");
      var id = $('#aSelect').select2("val");
      if(id !== null){
        $('#viewRekap').hide();
        $('#viewPenanganan').show();
        $('.rekap3').empty();

        viewPenangananRekap(periode, noruas, kmAwal, kmAkhir, id);
        $('#viewPenangananModal').modal('hide');
        $('#rekapModal').modal('show');
      }else{
        alert('jenis penanganan masih kosong');
      }
      $('.kategori').val(null).trigger('change');
    });

    $('#listPenanganan tbody').on( 'click', '#btnEdit', function () {
  		var data = tablePenanganan.row( $(this).parents('tr') ).data();
      $('#penangananModal').modal('hide');
      $('#viewNamePenanganan').text(data[1]);
      $('#viewPanjang').text(data[2]+" Km");
      $('#viewLuas').text(data[3]+" m2");
      $('#fieldKodeJalan').val(data[4]);

      loadPenangananDetForm(data[4]);
      loadDropdownJenisKerja(data[5]);
      $('#penangananDetModal').modal('show');
  	});
  }

  function loadJenisKerjaForm(){
    tableJenisKerja = $('#listJenisKerja').DataTable({
      "ajax": '<?= base_url("jenisKerja");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('.btn-close-jenisKerja').on('click', function(){
      resetForm();
      $('#jenisKerjaModal').modal('hide');
    });

    function resetForm(){
      $('.form-jenisKerja')[0].reset();
      $('.kategori').val(null).trigger('change');
    }

    $('#btnSubmitJenisKerja').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-jenisKerja');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
          blockHide();
          if(data.code === 200){
            Swal.fire({
              icon: 'success',
              title: 'Submit Data',
              text: 'Data berhasil tersimpan'
            })
            resetForm();
            tableJenisKerja.ajax.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Submit Data',
              text: 'Gagal menyimpan data'
            })
          }
        }, 'json');
      }else{
        $('#kategori_id-error').addClass('invalid-feedback');
        blockHide();
      }
      return false;
    });

    $('.form-jenisKerja').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			kategori_id : {
  				required: true
  			},
  			name : {
  				required: true
  			}
  		}
  	});

    $('#listJenisKerja tbody').on( 'click', '#btnEdit', function (e) {
      e.stopImmediatePropagation();
  		var data = tableJenisKerja.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("jenisKerja/getDetailItem/");?>' + data[2], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=name]').val(dataJson.data[0].name);

          var newOption = new Option(dataJson.data[0].penanganan_text, dataJson.data[0].penanganan_id, true, true);
          $('.kategori').append(newOption).trigger('change');
        }
      }, 'json');
  	});

    $('#listJenisKerja tbody').on( 'click', '#btnDelete', function (e) {
      e.stopImmediatePropagation();

  		var data = tableJenisKerja.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("jenisKerja/deleteItem/");?>' + data[2], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    resetForm();
                    tableJenisKerja.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }

  function loadPekerjaanForm(){
    tablePekerjaan = $('#listPekerjaan').DataTable({
      "ajax": '<?= base_url("pekerjaan");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('.btn-close-pekerjaan').on('click', function(){
      resetForm();
      $('#pekerjaanModal').modal('hide');
    });

    function resetForm(){
      $('.form-pekerjaan')[0].reset();

      $('.kategori').val(null).trigger('change');
      $('.satuan').val(null).trigger('change');
      $('.jns_pekerjaan').val(null).trigger('change');
    }

    $('#btnSubmitPekerjaan').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-pekerjaan');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
          blockHide();
          if(data.code === 200){
            Swal.fire({
              icon: 'success',
              title: 'Submit Data',
              text: 'Data berhasil tersimpan'
            })
            resetForm();
            tablePekerjaan.ajax.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Submit Data',
              text: 'Gagal menyimpan data'
            })
          }
        }, 'json');
      }else{
        blockHide();
      }
      return false;
    });

    $('.form-pekerjaan').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			jenis_id : {
  				required: true
  			},
  			harga : {
  				required: true
  			},
  			satuan_id : {
  				required: true
  			},
  			kategori_id : {
  				required: true
  			}
  		}
  	});

    $('#listPekerjaan tbody').on( 'click', '#btnEdit', function () {
  		var data = tablePekerjaan.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("pekerjaan/getDetailItem/");?>' + data[4], function(dataJson) {
        if(dataJson.code === 200){
          var satuanOps = new Option(dataJson.data[0].satuan_text, dataJson.data[0].satuan_id, false, false);
          $('.satuan').append(satuanOps).trigger('change');

          var kategoriOps = new Option(dataJson.data[0].penanganan_text, dataJson.data[0].penanganan_id, false, false);
          $('.kategori').append(kategoriOps).trigger('change');

          var jenisOps = new Option(dataJson.data[0].jenis_text, dataJson.data[0].jenis_id, false, false);
          $('.jns_pekerjaan').append(jenisOps).trigger('change');

          $('input[name=id_pekerjaan]').val(dataJson.data[0].id);
          $('input[name=harga]').val(dataJson.data[0].harga);

          loadDropdownJenisKerja(dataJson.data[0].penanganan_id);
        }
      }, 'json');
  	});

    $('#listPekerjaan tbody').on( 'click', '#btnDelete', function () {
  		var data = tablePekerjaan.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("pekerjaan/deleteItem/");?>' + data[4], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    resetForm();
                    tablePekerjaan.ajax.reload();
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

    $('.btn-close-pengguna').on('click', function(){
      resetForm();
      $('#penggunaModal').modal('hide');
    });

    function resetForm(){
      $('.form-pengguna').validate().settings.ignore = "input[type=hidden]";
      $('.form-pengguna')[0].reset();
      $('.is-active').val("1").trigger('change');
    }

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
                  resetForm();
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
      }else{
        blockHide();
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
      $.get('<?= base_url("pengguna/getDetailItem/");?>' + data[5], function(dataJson) {
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
                $.get('<?= base_url("pengguna/deleteItem/");?>' + data[5], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    resetForm();
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

    $('.btn-close-kategori').on('click', function(){
      $('.form-kategori')[0].reset();
      $('#kategoriModal').modal('hide');
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
      }else{
        blockHide();
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
  			},
  			jenis : {
  				required: true
  			}
  		}
  	});

    $('#listKategori tbody').on( 'click', '#btnEdit', function () {
  		var data = tableKategori.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("kategori/getDetailItem/");?>' + data[3], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=name]').val(dataJson.data[0].name);
          $('input[name=warna]').val(dataJson.data[0].warna);
          $('#fieldJenisKategori').val(dataJson.data[0].jenis).trigger('change');
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
                $.get('<?= base_url("kategori/deleteItem/");?>' + data[3], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    $('.form-kategori')[0].reset();
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
          blockHide();
          Swal.fire({
            icon: 'error',
            title: 'Submit Data',
            text: 'Anda belum mengupload file csv'
          })
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
      item["posisi"] = (dataSplit[3] === "CENTER") ? 1 : 0;
      if(item["posisi"] == 1){
        item["hash"] = $.md5(dataSplit[0]+dataSplit[2]);
      }else{
        item["hash"] = $.md5(dataSplit[0]+dataSplit[2]+dataSplit[3]);
      }
      item["lat_data"] = dataSplit[4];
      item["long_data"] = dataSplit[5];
      return item;
    }
  }

  function loadRawanForm(){
    tableRawan = $('#listRawan').DataTable({
      "ajax": '<?= base_url("rawan");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('.btn-close-rawan').on('click', function(){
      $('.form-rawan')[0].reset();
      $('#rawanModal').modal('hide');
    });

    $('#btnSubmitRawan').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-rawan');
      if ($form.valid()){
        $.post($form.attr('action'), $form.serialize(), function(data){
          blockHide();
          if(data.code === 200){
            Swal.fire({
              icon: 'success',
              title: 'Submit Data',
              text: 'Data berhasil tersimpan'
            })
            $('.form-rawan')[0].reset();
            tableRawan.ajax.reload();
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Submit Data',
              text: 'Gagal menyimpan data'
            })
          }
        }, 'json');
      }else{
        blockHide();
      }
      return false;
    });

    $('.form-rawan').validate({
  		ignore: 'input[type=hidden]',
  		rules: {
  			jns_bencana : {
  				required: true
  			},
  			location : {
  				required: true
  			},
  			latitude : {
  				required: true
  			},
  			longtitude : {
  				required: true
  			}
  		}
  	});

    $('#listRawan tbody').on( 'click', '#btnEdit', function () {
  		var data = tableRawan.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("rawan/getDetailItem/");?>' + data[3], function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=location]').val(dataJson.data[0].location);
          $('input[name=latitude]').val(dataJson.data[0].latitude);
          $('input[name=longtitude]').val(dataJson.data[0].longtitude);
          $('#fieldJnsBencana').val(dataJson.data[0].type);
        }
      }, 'json');
  	});

    $('#listRawan tbody').on( 'click', '#btnDelete', function () {
  		var data = tableRawan.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("rawan/deleteItem/");?>' + data[3], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    $('.form-rawan')[0].reset();
                    tableRawan.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
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

  $('#btnPdf').click(function(){
    var htmlTag = $("#rekapBody").html();
    var htmlTag = htmlTag.replace(/<style.*?<\/style>/g, '');
    var styleEmbed = "<style> .table-style{border-collapse:collapse;width:100%;font-size:8pt;} .table-style th{border:1px solid black;} .table-style td{border:1px solid black;} .table-header{text-transform:uppercase;text-align:center;} .table-body td{padding-left:5px;} .table-footer{text-transform:uppercase;font-weight:bold;} .table-footer td{padding-left:5px;} .column-sm{float:left;width:5%;} .header{text-align:center;margin-bottom:20px;}</style>";
    htmlTag = styleEmbed + htmlTag;
    $.post('<?= base_url("ruas/download");?>',{html:htmlTag}, function(data) {
      var win = window.open('<?php echo base_url("assets/file/rekap.pdf")?>', '_blank', 'location=yes', 'clearcache=yes');
      if (win) {
          win.focus();
      } else {
          //Browser has blocked it
          alert('Please allow popups for this website');
      }
    }, 'html');
  });

  $('#btnRekap').click(function(){
    var periode = $("#periodeRekap option:selected").val();
    var daerah = $("#cbDaerah").val();

    if(periode != undefined){
      $('#rekapModal').modal('show');
      $('#viewRekap').show();

      $('#viewPenanganan').hide();
      $('#viewAllPenanganan').hide();

      $('.rekap1').empty();
      $('.rekap2').empty();
      if(periode !== "" && daerah == ""){
        $('#txt_total').show();
        viewRekap2(periode);
      }else{
        $('#txt_total').hide();
        viewRekap1(periode, daerah, "");
      }
    }else{
      alert("Periode dan No ruas masih kosong");
    }
  });

  function viewRekap1(periode, daerah, ksp){
    var header = '<tr class="table-header"> <th rowspan="3">No</th> <th rowspan="3">Nama ruas jalan</th> <th rowspan="3">Kuantitas</th> <th rowspan="3">total</th> <th colspan="7">kondisi jalan</th> </tr> <tr class="table-header"> <th colspan="3">mantap</th> <th colspan="4">tidak mantap</th> </tr> <tr class="table-header"> <th>sangat baik</th> <th>baik</th> <th>sedang</th> <th>jelek</th> <th>parah</th> <th>sangat parah</th> <th>hancur</th> </tr>';
    $('.rekap1').append(header);
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
        var view_km_1 = parseFloat(data[i].total_km_1)/1000;
        var view_km_2 = parseFloat(data[i].total_km_2)/1000;
        var view_km_3 = parseFloat(data[i].total_km_3)/1000;
        var view_km_4 = parseFloat(data[i].total_km_4)/1000;
        var view_km_5 = parseFloat(data[i].total_km_5)/1000;
        var view_km_6 = parseFloat(data[i].total_km_6)/1000;
        var view_km_7 = parseFloat(data[i].total_km_7)/1000;

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
        $('.rekap1').append(content);

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
      $('.rekap1').append(content);

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
      $('.rekap1').append(content);

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

  function viewRekap2(periode){
    var header = '<tr class="table-header"> <th rowspan="3">no</th> <th rowspan="3">kabupaten / kota</th> <th rowspan="3">status</th> <th rowspan="3">panjang ruas jalan <br/>( KM )</th> <th colspan="14">kondisi jalan</th> </tr> <tr class="table-header"> <th colspan="6">Mantap</th> <th colspan="8">Tidak Mantap</th> </tr> <tr class="table-header"> <th>Sangat Baik <br/>( KM )</th> <th>%</th> <th>Baik <br/>( KM )</th> <th>%</th> <th>Sedang <br/>( KM )</th> <th>%</th> <th>jelek <br/>( KM )</th> <th>%</th> <th>parah <br/>( KM )</th> <th>%</th> <th>Sangat parah <br/>( KM )</th> <th>%</th> <th>hancur <br/>( KM )</th> <th>%</th> </tr>';
    $('.rekap2').append(header);

    $.post("<?php echo base_url('ruas/getDataRekapTotal')?>", {periode:periode}, function(data){
      var area = ["GARUT", "SUMEDANG"];
      var urut = 1;
      var total_all = 0;
      var total_all_1 = 0, persentase_all_1 = 0;
      var total_all_2 = 0, persentase_all_2 = 0;
      var total_all_3 = 0, persentase_all_3 = 0;
      var total_all_4 = 0, persentase_all_4 = 0;
      var total_all_5 = 0, persentase_all_5 = 0;
      var total_all_6 = 0, persentase_all_6 = 0;
      var total_all_7 = 0, persentase_all_7 = 0;
      for (var i = 0; i < area.length; i++) {
        for (var j = 0; j < data.length; j++) {
          if(area[i] === data[j].nama_kota){
            var total_km = parseFloat(data[j].total_all/1000);
            var total_km_1 = parseFloat(data[j].total_1)/1000;
            var total_km_2 = parseFloat(data[j].total_2)/1000;
            var total_km_3 = parseFloat(data[j].total_3)/1000;
            var total_km_4 = parseFloat(data[j].total_4)/1000;
            var total_km_5 = parseFloat(data[j].total_5)/1000;
            var total_km_6 = parseFloat(data[j].total_6)/1000;
            var total_km_7 = parseFloat(data[j].total_7)/1000;

            var persentase_1 = (total_km_1/total_km) * 100;
            var persentase_2 = (total_km_2/total_km) * 100;
            var persentase_3 = (total_km_3/total_km) * 100;
            var persentase_4 = (total_km_4/total_km) * 100;
            var persentase_5 = (total_km_5/total_km) * 100;
            var persentase_6 = (total_km_6/total_km) * 100;
            var persentase_7 = (total_km_7/total_km) * 100;

            var content = "<tr class=\"table-body\">";
            content += "<td>"+ urut +"</td>";
            content += "<td> KABUPATEN "+area[i]+"</td>";
            content += "<td>P</td>";
            content += "<td>"+total_km.toFixed(3)+"</td>";
            content += "<td>"+total_km_1.toFixed(3)+"</td>";
            content += "<td>"+persentase_1.toFixed(2)+"</td>";
            content += "<td>"+total_km_2.toFixed(3)+"</td>";
            content += "<td>"+persentase_2.toFixed(2)+"</td>";
            content += "<td>"+total_km_3.toFixed(3)+"</td>";
            content += "<td>"+persentase_3.toFixed(2)+"</td>";
            content += "<td>"+total_km_4.toFixed(3)+"</td>";
            content += "<td>"+persentase_4.toFixed(2)+"</td>";
            content += "<td>"+total_km_5.toFixed(3)+"</td>";
            content += "<td>"+persentase_5.toFixed(2)+"</td>";
            content += "<td>"+total_km_6.toFixed(3)+"</td>";
            content += "<td>"+persentase_6.toFixed(2)+"</td>";
            content += "<td>"+total_km_7.toFixed(3)+"</td>";
            content += "<td>"+persentase_7.toFixed(2)+"</td>";
            content += "</tr>";
            $('.rekap2').append(content);

            total_all = parseFloat(total_all) + total_km;
            total_all_1 = parseFloat(total_all_1) + total_km_1;
            total_all_2 = parseFloat(total_all_2) + total_km_2;
            total_all_3 = parseFloat(total_all_3) + total_km_3;
            total_all_4 = parseFloat(total_all_4) + total_km_4;
            total_all_5 = parseFloat(total_all_5) + total_km_5;
            total_all_6 = parseFloat(total_all_6) + total_km_6;
            total_all_7 = parseFloat(total_all_7) + total_km_7;
            persentase_all_1 = parseFloat(persentase_all_1) + persentase_1;
            persentase_all_2 = parseFloat(persentase_all_2) + persentase_2;
            persentase_all_3 = parseFloat(persentase_all_3) + persentase_3;
            persentase_all_4 = parseFloat(persentase_all_4) + persentase_4;
            persentase_all_5 = parseFloat(persentase_all_5) + persentase_5;
            persentase_all_6 = parseFloat(persentase_all_6) + persentase_6;
            persentase_all_7 = parseFloat(persentase_all_7) + persentase_7;
          }
        }
        urut++;
      }

      var content = "<tr class=\"table-footer\">";
      content += "<td colspan=\"2\" style=\"text-align: right;padding-right: 10px;\">Jumlah total</td>";
      content += "<td>P</td>";
      content += "<td>"+total_all.toFixed(3)+"</td>";
      content += "<td>"+total_all_1.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_1.toFixed(2)+"</td>";
      content += "<td>"+total_all_2.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_2.toFixed(2)+"</td>";
      content += "<td>"+total_all_3.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_3.toFixed(2)+"</td>";
      content += "<td>"+total_all_4.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_4.toFixed(2)+"</td>";
      content += "<td>"+total_all_5.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_5.toFixed(2)+"</td>";
      content += "<td>"+total_all_6.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_6.toFixed(2)+"</td>";
      content += "<td>"+total_all_7.toFixed(3)+"</td>";
      content += "<td>"+persentase_all_7.toFixed(2)+"</td>";
      content += "</tr>";
      $('.rekap2').append(content);

      var km_mantap = total_all_1+total_all_2+total_all_3;
      var km_tmantap = total_all_4+total_all_5+total_all_6+total_all_7;
      $('#km_mantap').text(km_mantap.toFixed(2)+" Km");
      $('#km_tmantap').text(km_tmantap.toFixed(2)+" Km");

      var persentase_mantap = persentase_all_1+persentase_all_2+persentase_all_3;
      var persentase_tmantap = persentase_all_4+persentase_all_5+persentase_all_6+persentase_all_7;
      $('#persentase_mantap').text(persentase_mantap.toFixed(2)+" %");
      $('#persentase_tmantap').text(persentase_tmantap.toFixed(2)+" %");
    },'json');
  }

  function viewPenangananRekap(periode, noruas, kmAwal, kmAkhir, jns){
    $.post("<?php echo base_url('penanganan/getDataRekap')?>", {periode:periode, noruas:noruas, kmAwal:kmAwal, kmAkhir:kmAkhir, jns:jns}, function(data){
      $('#txt_header').text(data.data.penanganan_nama.toUpperCase());
      $('#col_no_ruas').text(noruas);
      $('#col_panjang_penanganan').text(data.data.penanganan_km);
      $('#col_nm_ruas').text(data.data.nama_ruas);
      $('#col_lok_penanganan').text(data.data.penanganan_range);
      $('#col_panjang_jalan').text(data.data.panjang_km);
      $('#col_periode').text(data.data.nama_periode);

      var header = "<tr> <th>No.</th> <th>Jenis Pekerjaan</th> <th>Volume</th> <th>Satuan</th> <th>Harga Satuan</th> <th>Total</th></tr>";
      $('.rekap3').append(header);

      for (var i = 0; i < data.data.data_detail.length; i++) {
        var detail = data.data.data_detail[i];
        var content = "<tr class=\"table-body\">";
        content += "<td>"+ detail[0] +"</td>";
        content += "<td>"+ detail[1] +"</td>";
        content += "<td>"+ detail[2] +"</td>";
        content += "<td>"+ detail[3] +"</td>";
        content += "<td style=\"text-align:right;padding-right: 10px;\">"+ detail[4] +"</td>";
        content += "<td style=\"text-align:right;padding-right: 10px;\">"+ detail[5] +"</td>";
        content += "</tr>";
        $('.rekap3').append(content);
      }

      var content = "<tr class=\"table-body\">";
      content += "<td colspan=\"5\" style=\"text-align:right;padding-right: 10px;font-weight: bold;\">Jumlah</td>";
      content += "<td style=\"text-align:right;padding-right: 10px;\">"+ data.data.total +"</td>";
      content += "</tr>";
      $('.rekap3').append(content);
    },'json');
  }

  function viewAllPenangananRekap(periode, noruas, kmAwal, kmAkhir, jns){
    $.post("<?php echo base_url('penanganan/getDataRekap')?>", {periode:periode, noruas:noruas, kmAwal:kmAwal, kmAkhir:kmAkhir, jns:jns}, function(data){

      var header = "<tr> <th>No.</th> <th>Ruas Jalan</th> <th>Panjang Ruas Jalan (Km)</th> <th>Jenis Penanganan</th> <th>Panjang Penanganan Jalan (Km)</th> <th>Lokasi Penanganan (Km Awal – KM Akhir)</th> <th>Biaya Penanganan Jalan (Rp)</th> </tr>";
      $('.rekap4').append(header);

      var total_biaya = 0;
      for (var i = 0; i < data.data.length; i++) {
        var header = data.data[i];
        var detail = data.data[i].detail;
        total_biaya = total_biaya + header.total_biaya;
        for (var dt = 0; dt < detail.length; dt++) {
          if(dt == 0){
            var content = "<tr class=\"table-body\">";
              content += "<td>"+ header.no +"</td>";
              content += "<td>"+ header.nama_ruas +"</td>";
              content += "<td>"+ header.total_panjang +"</td>";
              content += "<td>"+ detail[dt].jenis_penanganan +"</td>";
              content += "<td>"+ detail[dt].panjang_penanganan_num +"</td>";
              content += "<td>"+ detail[dt].lokasi_penanganan +"</td>";
              content += "<td style=\"text-align: right;padding-right: 10px;\">"+ detail[dt].biaya_penanganan +"</td>";
              content += "</tr>";
            $('.rekap4').append(content);
          }else{
            var content = "<tr class=\"table-body\">";
              content += "<td>&nbsp;</td>";
              content += "<td>&nbsp;</td>";
              content += "<td>&nbsp;</td>";
              content += "<td>"+ detail[dt].jenis_penanganan +"</td>";
              content += "<td>"+ detail[dt].panjang_penanganan_num +"</td>";
              content += "<td>"+ detail[dt].lokasi_penanganan +"</td>";
              content += "<td style=\"text-align: right;padding-right: 10px;\">"+ detail[dt].biaya_penanganan +"</td>";
              content += "</tr>";
            $('.rekap4').append(content);
          }
        }

        var content = "<tr class=\"table-body\">";
          content += "<td>&nbsp;</td>";
          content += "<td>&nbsp;</td>";
          content += "<td>&nbsp;</td>";
          content += "<td>&nbsp;</td>";
          content += "<td>&nbsp;</td>";
          content += "<td style=\"font-weight: bold;\">TOTAL</td>";
          content += "<td style=\"text-align: right;padding-right: 10px;\">"+ addPeriod(total_biaya) +"</td>";
          content += "</tr>";
        $('.rekap4').append(content);

      }
    },'json');
  }

  function addPeriod(nStr){
      nStr += '';
      x = nStr.split('.');
      x1 = x[0];
      x2 = x.length > 1 ? '.' + x[1] : '';
      var rgx = /(\d+)(\d{3})/;
      while (rgx.test(x1)) {
          x1 = x1.replace(rgx, '$1' + '.' + '$2');
      }
      return x1 + x2;
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
  				"defaultContent": '<button id="btnDataView" class="btn btn-sm btn-primary btn-margin-bottom">LIHAT</button>'
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

  function loadDropdownJenisKerja(id){
    $("#fieldHargaPekerjaan").val(0);
    $("#viewHargaPekerjaan").val("");
    $("#viewInputHarga").val(0);
    hitungBiaya(0);

    $('.jns_pekerjaan').select2({
      placeholder: "Pilih Jenis Pekerjaan",
      allowClear: false,
      ajax: {
          url: "<?= base_url('jenisKerja/getCombo/') ?>"+id,
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
                  return { id: obj.id, text: obj.name };
              })
            };
          },
          cache: true
        }
    }).on('select2:select', function(e) {
      var id = e.params.data.id;
      $("#fieldHargaPekerjaan").val(0);
      $("#viewHargaPekerjaan").val("");
      $("#viewInputHarga").val(0);
      hitungBiaya(0);

      $.get('<?= base_url("pekerjaan/getDetailItemByJenis/");?>'+id, function(data) {
        $("#fieldHargaPekerjaan").val(data.data.harga);
        $("#viewHargaPekerjaan").val(data.data.harga_text);
    	}, 'json');
    });
  }

  function loadDropdown(){
    $('.kategori').select2({
      placeholder: "Pilih Jenis Penanganan",
      allowClear: false,
      minimumResultsForSearch: Infinity,
      ajax: {
          url: "<?= base_url('Kategori/getCombo/2') ?>",
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
                  return { id: obj.id, text: obj.name };
              })
            };
          },
          cache: true
        }
    });

    $('.satuan').select2({
      placeholder: "Pilih Satuan",
      allowClear: false,
      minimumResultsForSearch: Infinity,
      ajax: {
          url: "<?= base_url('pekerjaan/getCombo/satuan') ?>",
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
                  return { id: obj.id, text: obj.name };
              })
            };
          },
          cache: true
        }
    });

    $('.jns_pekerjaan').select2({
      placeholder: "Pilih Jenis Pekerjaan",
      allowClear: false
    });

    $('.kategori').on('select2:select', function (e) {
      var id = e.params.data.id;
      loadDropdownJenisKerja(id);
    });

    $('.is-active').select2({
      placeholder: "Pilih Active",
      allowClear: false,
      minimumResultsForSearch: Infinity
    });

    $('.jenis_kategori').select2({
      placeholder: "Pilih Jenis",
      allowClear: false,
      minimumResultsForSearch: Infinity
    });

    $('.daerah').select2({
      // placeholder: "Pilih Kabupaten/Kota",
      // allowClear: true,
      minimumResultsForSearch: Infinity
    }).on('select2:select', function(e) {
      var id = e.params.data.id;
      // loadKsp(id);
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

    $('.combokm').select2({
      placeholder: "Pilih awal KM",
      allowClear: true,
    });

    $('.comboakhirkm').select2({
      placeholder: "Pilih akhir KM",
      allowClear: true,
    });

    $('#fieldNoRuas').select2({
      placeholder: "Pilih Ruas",
      allowClear: true,
    });

    $('#fieldPeriode').select2({
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
      $('#txtbtnpdf_penanganan').text("Laporan Rekapitulasi");

      $('#fieldNoRuas').select2({
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
        var name = e.params.data.text;
        var noruas = e.params.data.id;
        $('#viewNameRuas').text(name);
        comboKm(id, noruas);

        $('#txtbtnpdf_penanganan').text("Laporan Per Jenis Penanganan");
      }).on('select2:clear', function(e) {
        $('#txtbtnpdf_penanganan').text("Laporan Rekapitulasi");
      });
    });

    function comboKm(periode_id, noruas){
      $('.combokm').select2({
        placeholder: "Pilih awal KM",
        allowClear: true,
        ajax: {
            url: "<?= base_url('penanganan/getComboKm/') ?>"+periode_id+"/"+noruas+"/0",
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
                    return { id: obj.id, text: obj.id };
                })
              };
            },
            cache: true
          }
      }).on('select2:clear', function(e) {
        $('#txtbtnpdf_penanganan').text("Laporan Rekapitulasi");
      });

      $('.comboakhirkm').select2({
        placeholder: "Pilih akhir KM",
        allowClear: true,
        ajax: {
            url: "<?= base_url('penanganan/getComboKm/') ?>"+periode_id+"/"+noruas+"/1",
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
                    return { id: obj.id, text: obj.id };
                })
              };
            },
            cache: true
          }
      }).on('select2:clear', function(e) {
        $('#txtbtnpdf_penanganan').text("Laporan Rekapitulasi");
      });
    }

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
      var periode = e.params.data.id;
      $('#btnRekap').removeClass('disabled');

      $('.ruas').select2({
        placeholder: "Pilih Ruas",
        allowClear: true,
        ajax: {
            url: "<?= base_url('ruas/getCombo/') ?>"+periode,
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
        showLine(periode, id);
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
