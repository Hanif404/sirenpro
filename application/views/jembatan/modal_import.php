<div class="modal fade" id="importJembatanModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penangananModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Jembatan</h5>
                <button type="button" class="close btn-close-import-jembatan">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <form class="form-import-jembatan" method="post" action="<?= base_url('jembatan/setItem');?>">
                            <div class="container">
                                <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                    <label for="input2">File CSV</label>
                                    <input type="file" class="form-control"  name="jembatan_csv" accept=".csv">
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                <div class="col-lg-12">
                                    <button id="btnSubmitImportJembatan" class="btn btn-primary">Submit</button>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" style="margin-top:20px">
                    <div class="col-12">
                        <table id="listDataJembatan" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Ruas Jalan</th>
                                    <th>Thn Bangun</th>
                                    <th>Pengelola</th>
                                    <th>Tgl Inspeksi</th>
                                    <th>Kondisi</th>
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
<script>
var tableDataJembatan, idJembatanImage;
$(document).ready(function() {
    loadImportJembatanForm();

    tableDataJembatan = $('#listDataJembatan').DataTable({
      "ajax": '<?= base_url("jembatan");?>',
      "columnDefs": [{
        "targets": -1,
        "data": null,
        "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Upload</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
      }]
    });

    $('#listDataJembatan tbody').on( 'click', '#btnEdit', function(e) {
      e.stopImmediatePropagation();
      var data = tableDataJembatan.row( $(this).parents('tr') ).data();
      idJembatanImage = data[7];
      $('input[name=jembatan_id]').val(data[7]);
      loadFormJembatanImage();

      $('#uploadJembatanModal').modal('show');
    });

    $('#listDataJembatan tbody').on( 'click', '#btnDelete', function (e) {
      e.stopImmediatePropagation();

  		var data = tableDataJembatan.row( $(this).parents('tr') ).data();
      $.confirm({
          title: 'Confirm!',
          content: 'Yakin akan menghapus data ini?',
          buttons: {
              Ya: function () {
                $.get('<?= base_url("jembatan/deleteItem/");?>' + data[7], function(dataJson) {
                  if(dataJson.code === 200){
                    Swal.fire({
                      icon: 'success',
                      title: 'Submit Data',
                      text: 'Data berhasil tersimpan'
                    })
                    tableDataJembatan.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});

    $("#uploadJembatanModal").on('show.bs.modal', function (e) {
      $("#importJembatanModal").modal("hide");
    });

    $("#importJembatanModal").on('show.bs.modal', function (e) {
      resetFormJembatanImage();
      $("#uploadJembatanModal").modal("hide");
    });

    $('.btn-close-import-jembatan').on('click', function(e){
      e.stopImmediatePropagation();
      tableDataJembatan.ajax.reload();
      $('#importJembatanModal').modal('hide');
  });

  $('.btn-close-upload-jembatan').on('click', function(e){
      e.stopImmediatePropagation();
      $('#importJembatanModal').modal('show');
      tableDataJembatan.ajax.reload();
  });
});

function loadImportJembatanForm(){
    $('#btnSubmitImportJembatan').on('click', function(e){
      e.stopImmediatePropagation();
        blockShow();

        var filecsv = $("input[name=jembatan_csv]")[0].files[0];
        var ext = $("input[name=jembatan_csv]").val().split(".").pop().toLowerCase();
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
              var periodeTemp = [];
              
              for (i = 0; i < lines.length-1; ++i)
              {
                if(i > 0){
                  var dataSplit = lines[i].split(/,(?![^"]*"(?:(?:[^"]*"){2})*[^"]*$)/);
                  var lineData = createFieldData(dataSplit);
                  arr.push(lineData);
                }
              }
              var postdata = JSON.stringify(arr);
              var $form = $('.form-import-jembatan');
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

    function splitComponentsByComma(str){
        var ret = [];
        var arr = str.match(/(".*?"|[^",]+)(?=\s*,|\s*$)/g);
        for (let i in arr) {
          let element = arr[i];
          if ('"' === element[0]) {
              element = element.substr(1, element.length - 2);
          } else {
              element = arr[i].trim();
          }
          ret.push(element);
        }
        return ret;
    }

    function createFieldData(data){
      var latData = data[13].replaceAll("\"","");
      var longData = data[14].replaceAll("\"","");
      var d = new Date(data[20]);
      var month = parseInt(d.getMonth())+1;
      var date1 = d.getFullYear() +'-'+ month +'-'+ d.getDate();
      var main = {
        'no' : data[0],
        'nama' : data[1],
        'ruas_jalan' : data[2],
        'pengelola' : data[3],
        'lokasi' : data[4],
        'nama_kota' : data[5],
        'thn' : data[6],
        'panjang' : data[7] ,
        'lebar' : data[8],
        'ba' : data[9],
        'bb' : data[10],
        'pondasi' : data[11],
        'lantai' : data[12],
        'latitude' : latData.replace(",", "."),
        'longtitude' : longData.replace(",", "."),
        'nk_ba' : data[15],
        'nk_bb' : data[16],
        'nk_lnt' : data[17],
        'nk_das' : data[18],
        'nk_jbt' : data[19],
        'tgl_inspeksi' : date1
      };
      return main;
    }
  }

</script>