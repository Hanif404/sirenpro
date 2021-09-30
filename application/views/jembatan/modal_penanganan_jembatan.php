<div class="modal fade" id="penangananJembatanModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penangananModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Program Penanganan Jembatan</h5>
        <button type="button" class="close btn-close-penanganan-jembatan">
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
              <div class="row">
                <div class="col-md-4">
                  <select class="form-control fieldJembatanPeriode" style="width:100%"></select>
                </div>
                <div class="col-md-8">
                  <select class="form-control" id="fieldJembatanRuas" style="width:100%"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <button id="btnViewPenangananJembatan" class="btn btn-primary" style="margin-top: 10px;">Tampilkan Data</button>
              <button id="btnViewDD2Pdf" class="btn btn-success" style="margin-top: 10px;">Laporan Jembatan</button>
            </div>
          </div>
        </div>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listPenangananJembatan" class="table table-striped table-bordered" style="width:100%">
                <thead>
                  <tr>
                    <th>Kondisi</th>
                    <th>Penanganan</th>
                    <th>Nama Jembatan</th>
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
var tablePenangananJembatan, idKategoriJbt, nmJbt, noJbt, ruasJbt, thnJbt, kotaJbt, lokasiJbt, pengelolaJbt, tglJbt, typeViewJembatan = 1;
$('.btn-close-penanganan-jembatan').on('click', function(){
    $('#penangananJembatanModal').modal('hide');
});

$('#btnViewPenangananJembatan').on('click', function(){
  var no_ruas = $('#fieldJembatanRuas').val();
  if(no_ruas != ""){
    $('#listPenangananJembatan').DataTable().clear().destroy();
    tablePenangananJembatan = $('#listPenangananJembatan').DataTable({
      "ajax": {
        "url":'<?= base_url("jembatan/penanganan");?>',
        "data": {
            "ruas_jalan": no_ruas
        },
        "type":'POST'
      },
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

$('#btnViewDD2Pdf').on('click', function(){
  $('#lapDD2Jembatan').modal('show');
});

$(document).ready(function() {
  loadDropdownJembatan();
  $('#listPenangananJembatan').DataTable();

  $('#listPenangananJembatan tbody').on( 'click', '#btnEdit', function () {
    var data = tablePenangananJembatan.row( $(this).parents('tr') ).data();
    idKategoriJbt = data[4];
    $('input[name=jembatan_id]').val(data[3]);
    loadTablePenangananJembatan(data[3]);
    
    $.get('<?= base_url("jembatan/getDataById/");?>' + data[3], function(dataJson) {
        if(dataJson.code === 200){
          var content = dataJson.data;
          $('#txtNoJbt').text(content[0].no);
          $('#txtNmJbt').text(content[0].nama);
          $('#txtRuasJbt').text(content[0].ruas_jalan);
          $('#txtTahunJbt').text(content[0].thn);
          $('#txtKotaJbt').text(content[0].nama_kota);
          $('#txtLokasiJbt').text(content[0].lokasi);
          $('#txtDateJbt').text(content[0].tgl_inspeksi);
          $('#txtPengelolaJbt').text(content[0].pengelola);
          dropdownJembatan();
        }
    }, 'json');
    $("#penangananJbtDetModal").modal("show");
  });

  $("#penangananJbtDetModal").on('show.bs.modal', function () {
    $("#penangananJembatanModal").modal("hide");
  });

  $("#penangananJbtDetModal").on('hide.bs.modal', function () {
    $("#penangananJembatanModal").modal("show");
  });

  //laporan DD2
  $("#lapDD2Jembatan").on('show.bs.modal', function () {
    typeViewJembatan = 2;
    $("#penangananJembatanModal").modal("hide");
  });

  $("#lapDD2Jembatan").on('hide.bs.modal', function () {
    typeViewJembatan = 1;
    $("#penangananJembatanModal").modal("show");
  });
});

function loadDropdownJembatan(){
  $('#fieldJembatanRuas').select2({
    placeholder: "Pilih Ruas Jalan",
    allowClear: true
  });
  
  $('#fieldJembatanPengelola').select2({
    placeholder: "Pilih Pengelola",
    allowClear: true
  });

  $('.fieldJembatanPeriode').select2({
    placeholder: "Pilih Periode",
    allowClear: true,
    minimumResultsForSearch: Infinity,
    ajax: {
        url: "<?= base_url('jembatan/getDataPeriode') ?>",
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

    if(typeViewJembatan === 1){
      $('#fieldJembatanRuas').select2({
        placeholder: "Pilih Ruas Jalan",
        allowClear: true,
        ajax: {
            url: "<?= base_url('jembatan/getDataRuas/') ?>"+id,
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
                    return { id: obj.ruas_jalan, text: obj.ruas_jalan };
                })
              };
            },
            cache: true
          }
      });
    }else if(typeViewJembatan === 2){
      $('#fieldJembatanPengelola').select2({
        placeholder: "Pilih Pengelola",
        allowClear: true,
        ajax: {
            url: "<?= base_url('jembatan/getDataPengelola/') ?>"+id,
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
                    return { id: obj.pengelola, text: obj.pengelola };
                })
              };
            },
            cache: true
          }
      });
    }
  });
  
  $('.fieldJbtYearPeriode').select2({
    placeholder: "Pilih Periode",
    allowClear: true,
    minimumResultsForSearch: Infinity,
    ajax: {
        url: "<?= base_url('jembatan/getDataPeriode2') ?>",
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
              return { id: obj.periode_year, text: obj.periode_year };
            })
          };
        },
        cache: true
      }
  }).on('select2:select', function(e) {
    var id = e.params.data.id;
    $('#fieldJembatanPengelola').select2({
      placeholder: "Pilih Pengelola",
      allowClear: true,
      ajax: {
        url: "<?= base_url('jembatan/getDataPengelola/') ?>"+id,
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
                return { id: obj.pengelola, text: obj.pengelola };
            })
          };
        },
        cache: true
      }
    });
  });
}
</script>