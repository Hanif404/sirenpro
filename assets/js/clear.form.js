function clearFormHPekerjaan(){
    $('.form-pekerjaan')[0].reset();
    $('.form-pekerjaan-jembatan')[0].reset();

    $('input[name=id_pekerjaan]').val("");
    $('.kategori').find('option').remove().end();
    $('.satuan').find('option').remove().end();
    $('.jns_pekerjaan').find('option').remove().end();
}

function clearFormJPekerjaan(){
    $('.form-jenisKerja')[0].reset();
    $('.form-jenisKerja-jembatan')[0].reset();
    
    $('.kategori').val(null).trigger('change');
}