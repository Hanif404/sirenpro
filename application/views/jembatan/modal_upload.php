<div class="modal fade" id="uploadJembatanModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadModalTitle" aria-hidden="true">
<form class="form-image-jembatan" method="post" enctype="multipart/form-data" action="<?= base_url('jembatan/setImage');?>">
  <input type="hidden" name="jembatan_id" />
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upload Gambar Jembatan</h5>
        <button type="button" class="close btn-close-upload-jembatan">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col-3">
            Tampak Samping Kiri
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_1">
            <input type="file" class="form-control" name="file_image_1" accept="image/*" onchange="loadFile(event, 1)">
          </div>
          <div class="col-3">
            Tampak Samping Kanan
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_2">
            <input type="file" class="form-control" name="file_image_2" accept="image/*" onchange="loadFile(event, 2)">
          </div>
          <div class="col-3">
            Tampak Depan Masuk
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_3">
            <input type="file" class="form-control" name="file_image_3" accept="image/*" onchange="loadFile(event, 3)">
          </div>
          <div class="col-3">
            Tampak Depan Keluar
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_4">
            <input type="file" class="form-control" name="file_image_4" accept="image/*" onchange="loadFile(event, 4)">
          </div>
        </div>
        <div class="row" style="margin-top:20px">
          <div class="col-3">
            Kondisi Lingkungan 1
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_5">
            <input type="file" class="form-control" name="file_image_5" accept="image/*" onchange="loadFile(event, 5)">
          </div>
          <div class="col-3">
            Kondisi Lingkungan 2
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_6">
            <input type="file" class="form-control" name="file_image_6" accept="image/*" onchange="loadFile(event, 6)">
          </div>
          <div class="col-3">
            Lintasan 1
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_7">
            <input type="file" class="form-control" name="file_image_7" accept="image/*" onchange="loadFile(event, 7)">
          </div>
          <div class="col-3">
            Lintasan 2
            <img src="<?php echo base_url('assets/image/no_image.png')?>" class="rounded img-thumbnail mx-auto d-block" alt="" id="file_8">
            <input type="file" class="form-control" name="file_image_8" accept="image/*" onchange="loadFile(event, 8)">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnImageJembatan" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script>
var loadFile = function(event, field) {
	var image = document.getElementById('file_'+field);
	image.src = URL.createObjectURL(event.target.files[0]);
};

var loadFormJembatanImage = function(){
  $('.form-image-jembatan')[0].reset();

  $.get('<?= base_url("jembatan/getData/");?>'+idJembatanImage, function(dataJson) {
    if(dataJson.code === 200){
      content = dataJson.data;
      if(content.length > 0){
        for (var j = 0; j < content.length; j++) {
          var image = document.getElementById('file_'+content[j].type);
          image.src = '<?= base_url(); ?>'+content[j].name;
        }
      }
    }
  },'json');
}

var resetFormJembatanImage = function(){
  $('.form-image-jembatan')[0].reset();
  $('input[name=jembatan_id]').val('');
  for (var j = 1; j <= 8; j++) {
    var image = document.getElementById('file_'+j);
    image.src = '<?= base_url('assets/image/no_image.png'); ?>';
  }
}

$('#btnImageJembatan').on('click', function(e){
  e.stopImmediatePropagation();
  blockShow();

  var $form = $('.form-image-jembatan');
  if ($form.valid()){
    var data_input = new FormData();

    //Form data
    var form_data = $form.serializeArray();
    $.each(form_data, function (key, input) {
        data_input.append(input.name, input.value);
    });

    //File data
    for (var j = 1; j <= 8; j++) {
      var file_data = $('input[name="file_image_'+j+'"]')[0].files;
      for (var i = 0; i < file_data.length; i++) {
          data_input.append("file_image_"+j, file_data[i]);
      }
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
              });
              resetFormJembatanImage();

              $('input[name=jembatan_id]').val(idJembatanImage);
              $.get('<?= base_url("jembatan/getData/");?>'+idJembatanImage, function(dataJson) {
                if(dataJson.code === 200){
                  content = dataJson.data;
                  if(content.length > 0){
                    for (var j = 0; j < content.length; j++) {
                      var image = document.getElementById('file_'+content[j].type);
                      image.src = '<?= base_url(); ?>'+content[j].name;
                    }
                  }
                }
              },'json');
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
</script>