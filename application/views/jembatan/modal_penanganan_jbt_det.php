<div class="modal fade" id="penangananJbtDetModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penangananDetModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Program Penanganan Jembatan</h5>
        <button type="button" class="close btn-close-penangananJbtDet">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container" style="margin-bottom: 10px;">
          <div class="row">
            <div class="col-lg-12">
              <h6>Area Penanganan</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <table width="100%">
                <tr>
                  <td width="20%">No Jembatan</td>
                  <td>:</td>
                  <td id="txtNoJbt">-</td>
                  <td width="20%">Nama Jembatan</td>
                  <td>:</td>
                  <td id="txtNmJbt">-</td>
                </tr>
                <tr>
                  <td>Ruas Jalan</td>
                  <td>:</td>
                  <td id="txtRuasJbt">-</td>
                  <td>Tahun</td>
                  <td>:</td>
                  <td id="txtTahunJbt">-</td>
                </tr>
                <tr>
                  <td>Kabupaten</td>
                  <td>:</td>
                  <td id="txtKotaJbt">-</td>
                  <td>Lokasi</td>
                  <td>:</td>
                  <td id="txtlokasiJbt">-</td>
                </tr>
                <tr>
                  <td>SPJJ</td>
                  <td>:</td>
                  <td id="txtPengelolaJbt">-</td>
                  <td>Tgl. Inspeksi</td>
                  <td>:</td>
                  <td id="txtDateJbt">-</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <form class="form-penanganan-jbt" method="post" action="<?= base_url('jembatan/setPenanganan');?>" style="display:none;">
          <input type="hidden" name="id" />
          <input type="hidden" name="jembatan_id" />
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Jenis Pekerjaan</label>
                  <select class="form-control jns_pekerjaan_jbt" name="jenis_id" id="fieldJnsPekerjaanJbt" style="width:100%"></select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Harga</label>
                  <input type="hidden" id="fieldHargaPekerjaanJbt" name="harga" >
                  <input type="text" class="form-control" placeholder="Harga" id="viewHargaPekerjaanJbt" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Volume</label>
                  <input type="number" min="0" value="0" id="viewInputHargaJbt" class="form-control" placeholder="Volume" oninput="hitungBiayaJbt(this.value)" name="volume" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Total Biaya</label>
                  <input type="text" class="form-control" placeholder="Total Biaya" id="fieldBiayaPenangananJbt" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitPenangananJbtDet" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
                <table id="listPenangananJbtDet" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>Jenis Pekerjaan</th>
                            <th>Volume</th>
                            <th>Harga (Rp)</th>
                            <th>Total Biaya</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  var tablePenangananJembatanDet, aksiFieldJembatan = "";
  $('.btn-close-penangananJbtDet').on('click', function(){
      $('#penangananJbtDetModal').modal('hide');
  });

  $(document).ready(function() {
    if(isAdmin == 2 || isAdmin == 1){
      $('.form-penanganan-jbt').show();
      aksiFieldJembatan = '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>';
    }
    tablePenangananJembatanDet = $('#listPenangananJbtDet').DataTable();
  });

  $('#btnSubmitPenangananJbtDet').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();
      var hrg = $('#fieldHargaPekerjaanJbt').val();

      var $form = $('.form-penanganan-jbt');
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
              resetFormJbt();
              tablePenangananJembatanDet.ajax.reload();
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

  function resetFormJbt(){
    $('.form-penanganan-jbt')[0].reset();
    $('#fieldJnsPekerjaanJbt').val(null).trigger('change');
  }

  function loadTablePenangananJembatan(id){
    $('#listPenangananJbtDet').DataTable().clear().destroy();
    tablePenangananJembatanDet = $('#listPenangananJbtDet').DataTable({
      "ajax": {
        "url":'<?= base_url("jembatan/penangananDetail");?>',
        "data": {
            "jembatan_id": id
        },
        "type":'POST'
      },
      "ordering": false,
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": aksiFieldJembatan
      }]
    });

    $('#listPenangananJbtDet tbody').on( 'click', '#btnEdit', function (e) {
      e.stopImmediatePropagation();
  		var data = tablePenangananJembatanDet.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("jembatan/getPenangananDet/");?>' + data[4], function(data) {
        if(data.code === 200){
          $('input[name=id]').val(data.data[0].id);
          $('input[name=volume]').val(data.data[0].volume);
          $('input[name=harga]').val(data.data[0].harga);
          $('#viewHargaPekerjaanJbt').val(data.data[0].harga_text);
          $('#fieldBiayaPenangananJbt').val(data.data[0].total.toMoney());

          var newOption = new Option(data.data[0].jenis_text, data.data[0].jenis_id, true, true);
          $('#fieldJnsPekerjaanJbt').append(newOption).trigger('change');
        }
      }, 'json');
  	});

    $('#listPenangananJbtDet tbody').on( 'click', '#btnDelete', function (e) {
      e.stopImmediatePropagation();

  		var data = tablePenangananJembatanDet.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("jembatan/penangananDelete/");?>' + data[4], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    resetFormJbt();
                    tablePenangananJembatanDet.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }

  function dropdownJembatan(){
    $('.jns_pekerjaan_jbt').val(null).trigger('change');
    $('.jns_pekerjaan_jbt').select2({
      placeholder: "Pilih Jenis Pekerjaan",
      allowClear: false,
      ajax: {
          url: "<?= base_url('jenisKerja/getCombo/') ?>"+idKategoriJbt,
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
      $("#fieldHargaPekerjaanJbt").val(0);
      $("#viewHargaPekerjaanJbt").val("");
      $("#viewInputHargaJbt").val(0);
      hitungBiayaJbt(0);

      $.get('<?= base_url("pekerjaan/getDetailItemByJenis/");?>'+id, function(data) {
        $("#fieldHargaPekerjaanJbt").val(data.data.harga);
        $("#viewHargaPekerjaanJbt").val(data.data.harga_text);
    	}, 'json');
    });

  }

  function hitungBiayaJbt(val){
    var harga = $('#fieldHargaPekerjaanJbt').val();
    var total = parseFloat(val) * parseFloat(harga);
    $('#fieldBiayaPenangananJbt').val(total.toMoney());
  }
</script>