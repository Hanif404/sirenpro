<form class="form-pekerjaan-jembatan" method="post" action="<?= base_url('pekerjaan/setItem');?>">
    <input type="hidden" name="id_pekerjaan" />
    <input type="hidden" name="type" value="2" />
    <div class="container">
    <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input2">Jenis Penanganan</label>
            <select class="form-control kategori-jembatan" name="kategori_id" style="width:100%"></select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input3">Satuan</label>
            <select class="form-control satuan" name="satuan_id" style="width:100%"></select>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input3">Jenis Pekerjaan</label>
            <select class="form-control jns_pekerjaan" name="jenis_id" style="width:100%"></select>
        </div>
        </div>
        <div class="col-lg-6">
        <div class="form-group">
            <label for="input2">Harga</label>
            <input type="text" class="form-control" placeholder="Harga"  name="harga" >
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
        <button id="btnSubmitPekerjaanJembatan" class="btn btn-primary">Submit</button>
        </div>
    </div>
    </div>
</form>
<div class="container" style="margin-top:20px">
    <div class="row">
    <div class="col-lg-12">
        <table id="listPekerjaanJembatan" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Jenis Penanganan</th>
                    <th>Jenis Pekerjaan</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
        </table>
    </div>
    </div>
</div>
<script>
    var tablePekerjaanJembatan;
    $(document).ready(function() {
        tablePekerjaanJembatan = $('#listPekerjaanJembatan').DataTable({
            "ajax": '<?= base_url("pekerjaan/index/2");?>',
            "columnDefs": [{
                "targets": -1,
                "data": null,
                "defaultContent": '<button id="btnEdit" class="btn btn-sm btn-primary btn-margin-bottom"><i class="fa fa-edit" ></i> Edit</button> <button id="btnDelete" class="btn btn-sm btn-danger btn-margin-bottom"><i class="far fa-trash-alt"></i> Delete</button>'
            }]
        });

        $('#btnSubmitPekerjaanJembatan').on('click', function(e){
            e.stopImmediatePropagation();
            blockShow();

            var $form = $('.form-pekerjaan-jembatan');
            if ($form.valid()){
                $.post($form.attr('action'), $form.serialize(), function(data){
                    blockHide();
                    if(data.code === 200){
                        Swal.fire({
                        icon: 'success',
                        title: 'Submit Data',
                        text: 'Data berhasil tersimpan'
                        })
                        resetPekerjaanForm();
                        tablePekerjaanJembatan.ajax.reload();
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

        $('#listPekerjaanJembatan tbody').on( 'click', '#btnEdit', function () {
            var data = tablePekerjaanJembatan.row( $(this).parents('tr') ).data();
            
            //get data
            $.get('<?= base_url("pekerjaan/getDetailItem/");?>' + data[4]+'/2', function(dataJson) {
                if(dataJson.code === 200){
                    $('.jns_pekerjaan').find('option').remove().end();
                    loadDropdownJenisKerja(dataJson.data[0].penanganan_id);

                    var satuanOps = new Option(dataJson.data[0].satuan_text, dataJson.data[0].satuan_id, false, false);
                    $('.satuan').append(satuanOps).trigger('change');

                    var kategoriOps = new Option(dataJson.data[0].penanganan_text, dataJson.data[0].penanganan_id, false, false);
                    $('.kategori-jembatan').append(kategoriOps).trigger('change');

                    var jenisOps = new Option(dataJson.data[0].jenis_text, dataJson.data[0].jenis_id, false, false);
                    $('.jns_pekerjaan').append(jenisOps).trigger('change');

                    $('input[name=id_pekerjaan]').val(dataJson.data[0].id);
                    $('input[name=harga]').val(dataJson.data[0].harga);
                }
            }, 'json');
        });

        $('#listPekerjaanJembatan tbody').on( 'click', '#btnDelete', function () {
            var data = tablePekerjaanJembatan.row( $(this).parents('tr') ).data();
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
                            resetPekerjaanForm();
                            tablePekerjaanJembatan.ajax.reload();
                        }
                        }, 'json');
                    },
                    Tidak: function () {

                    }
                }
            });
        });

        $('.btn-close-pekerjaan').on('click', function(){
            resetPekerjaanForm();
            $('#pekerjaanModal').modal('hide');
        });

        $('.form-pekerjaan-jembatan').validate({
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
    });

    function resetPekerjaanForm(){
        $('.form-pekerjaan-jembatan')[0].reset();

        $('input[name=id_pekerjaan]').val("");
        $('.kategori-jembatan').val(null).trigger('change');
        $('.satuan').val(null).trigger('change');
        $('.jns_pekerjaan').val(null).trigger('change');
    }
</script>
