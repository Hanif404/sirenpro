<form class="form-jenisKerja-jembatan" method="post" action="<?= base_url('jenisKerja/setItem');?>">
    <input type="hidden" name="id" />
    <input type="hidden" name="type" value="2" />
    <div class="container">
    <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input1">Kategori</label>
            <select class="form-control kategori-jembatan" name="kategori_id" style="width:100%"></select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input2">Nama Pekerjaan</label>
            <input type="text" class="form-control" placeholder="Nama Pekerjaan"  name="name" >
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <button id="btnSubmitJenisKerjaJembatan" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </div>
</form>
<div class="container" style="margin-top:20px">
    <div class="row">
    <div class="col-lg-12">
        <table id="listJenisKerjaJembatan" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Nama Pekerjaan</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>
    </div>
</div>
<script>
var tableJenisKerjaJembatan;
$(document).ready(function() {
  loadJenisKerjaJembatanForm();
});

function loadJenisKerjaJembatanForm(){
    tableJenisKerjaJembatan = $('#listJenisKerjaJembatan').DataTable({
      "ajax": '<?= base_url("jenisKerja/index/2");?>',
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
      $('.form-jenisKerja-jembatan')[0].reset();
      $('.kategori').val(null).trigger('change');
    }

    $('#btnSubmitJenisKerjaJembatan').on('click', function(e){
      e.stopImmediatePropagation();
      blockShow();

      var $form = $('.form-jenisKerja-jembatan');
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
            tableJenisKerjaJembatan.ajax.reload();
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

    $('.form-jenisKerja-jembatan').validate({
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

    $('#listJenisKerjaJembatan tbody').on( 'click', '#btnEdit', function (e) {
      e.stopImmediatePropagation();
  		var data = tableJenisKerjaJembatan.row( $(this).parents('tr') ).data();

      //get data
      $.get('<?= base_url("jenisKerja/getDetailItem/");?>' + data[2]+'/2', function(dataJson) {
        if(dataJson.code === 200){
          $('input[name=id]').val(dataJson.data[0].id);
          $('input[name=name]').val(dataJson.data[0].name);

          var newOption = new Option(dataJson.data[0].penanganan_text, dataJson.data[0].penanganan_id, true, true);
          $('.kategori').append(newOption).trigger('change');
        }
      }, 'json');
  	});

    $('#listJenisKerjaJembatan tbody').on( 'click', '#btnDelete', function (e) {
      e.stopImmediatePropagation();

  		var data = tableJenisKerjaJembatan.row( $(this).parents('tr') ).data();
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
                    tableJenisKerjaJembatan.ajax.reload();
                  }
                }, 'json');
              },
              Tidak: function () {

              }
          }
      });
  	});
  }
</script>