<div class="modal fade" id="lapDD2Jembatan" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadModalTitle" aria-hidden="true">
<form class="form-image-jembatan" method="post" enctype="multipart/form-data" action="<?= base_url('jembatan/setImage');?>">
  <input type="hidden" name="jembatan_id" />
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 95%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Laporan Kondisi Jembatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-md-2">
                <select class="form-control fieldJbtYearPeriode" id="fieldJembatanPeriode" style="width:100%"></select>
              </div>
              <div class="col-md-2">
                <select class="form-control" id="fieldJembatanPengelola" style="width:100%"></select>
              </div>
              <div class="col-md-3">
                <select class="form-control" id="fieldJembatanLapType" style="width:100%">
                  <option value="1">Lap. Kondisi Jembatan</option>
                  <option value="2">Lap. Rencana Anggaran Biaya</option>
                </select>
              </div>
              <div class="col-md-2">
              <button type="button" id="viewLapDD2" class="btn btn-primary">Tampilkan data</button>
              </div>
            </div>
          </div>
        </div>

        <div id="LapDD2JembatanView" style="display:none; padding-top:50px">
          <div class="header">
            <h3>DATA KONDISI JEMBATAN (DD2)</h3>
            <h4>Data Dasar Prasarana Jembatan Provinsi</h4>
          </div>
          <table width="100%" border="0">
            <tr>
              <td width="5%">Provinsi</td>
              <td width="1%">:</td>
              <td>Jawa Barat</td>
            </tr>
            <tr>
              <td>Kabupaten</td>
              <td>:</td>
              <td class="viewTitlePengelolaJbt"></td>
            </tr>
            <tr>
              <td>Tahun</td>
              <td>:</td>
              <td class="viewTitlePeriodeJbt"></td>
            </tr>
          </table>
          <table class="table-style" id="tableDD2Jembatan" style="font-size: 12pt;text-align: center;margin-top:20px" border="1">
            <tr>
              <th rowspan="3">NO</th>
              <th rowspan="3">NO. JEMBATAN</th>
              <th rowspan="3">NAMA JEMBATAN</th>
              <th rowspan="3">NAMA RUAS</th>
              <th rowspan="3">LOKASI (KM)</th>
              <th colspan="2">DIMENSI JEMBATAN</th>
              <th colspan="9">TIPE / KONDISI</th>
            </tr>
            <tr>
              <th rowspan="2">P (M)</th>
              <th rowspan="2">L (M)</th>
              <th colspan="2">BANG. ATAS</th>
              <th colspan="2">BANG. BAWAH</th>
              <th colspan="2">PONDASI</th>
              <th colspan="2">LANTAI</th>
              <th>NILAI KONDISI JEMBATAN</th>
            </tr>
            <tr>
              <th>TIPE</th>
              <th>NK</th>
              <th>TIPE</th>
              <th>NK</th>
              <th>TIPE</th>
              <th>NK</th>
              <th>TIPE</th>
              <th>NK</th>
              <th>NK</th>
            </tr>
            <tbody id="bodyLapDD2Jembatan">
            </tbody>
          </table>
        </div>

        <div id="LapRencanaJembatanView" style="display:none; padding-top:50px">
          <div class="header">
            <h3>RENCANA ANGGARAN BIAYA PROGRAM PENANGANAN</h3>
            <h4>Data Dasar Prasarana Jembatan Provinsi</h4>
            <h3>UPTD IV - KABUPATEN SUMEDANG & GARUT</h3>
          </div>
          <table width="100%" border="0">
            <tr>
              <td width="5%">Provinsi</td>
              <td width="1%">:</td>
              <td>Jawa Barat</td>
            </tr>
            <tr>
              <td>Kabupaten</td>
              <td>:</td>
              <td class="viewTitlePengelolaJbt"></td>
            </tr>
            <tr>
              <td>Tahun</td>
              <td>:</td>
              <td class="viewTitlePeriodeJbt"></td>
            </tr>
          </table>
          <table class="table-style" id="tableRencanaJembatan" style="font-size: 12pt;text-align: center;margin-top:20px" border="1">
            <tr>
              <th>NO</th>
              <th>NO.</br>JEMBATAN</th>
              <th>NAMA JEMBATAN</th>
              <th>NAMA RUAS</th>
              <th>LOKASI (KM)</th>
              <th>NILAI KONDISI</br>JEMBATAN</br>NK</th>
              <th>RENCANA</br>PENANGANAN</th>
              <th>ANGGARAN</br>BIAYA</br>(Rp.)</th>
            </tr>
            <tbody id="bodyLapRencanaJembatan">
            </tbody>
          </table>
        </div>
      </div>
        
      <div class="modal-footer">
        <button type="button" id="btnPdfLapJbt" class="btn btn-primary">Simpan PDF</button>
      </div>
    </div>
  </div>
  </form>
</div>
<script>
  var filterTypeJbt, htmlTag;
  $('#viewLapDD2').on('click', function(){
    var filterPeriode = $('#fieldJembatanPeriode').val();
    var filterPengelola = $('#fieldJembatanPengelola').val();
    filterTypeJbt = $('#fieldJembatanLapType').val();
    $('#LapDD2JembatanView').hide();
    $('#LapRencanaJembatanView').hide();

    $('.viewTitlePengelolaJbt').text(filterPengelola);
    $('.viewTitlePeriodeJbt').text(filterPeriode);

    if(filterPeriode == null || filterPengelola == null){
      Swal.fire({
        icon: 'error',
        title: 'View Data',
        text: 'periode dan pengelola masih kosong'
      });
      return null;
    }
    
    if(filterTypeJbt == "1"){
      $('#bodyLapDD2Jembatan').empty();
      $.get('<?= base_url("jembatan/getDataNkJbt/");?>' + filterPeriode + '/' + filterPengelola,function(data) {
        var no = 1;
        if(data.length > 0){
          for (var i = 0; i < data.length; i++) {
            var contentTable = "<tr class=\"table-body\">";
            contentTable += "<td>"+ no +"</td>";
            contentTable += "<td>"+ data[i].no +"</td>";
            contentTable += "<td>"+ data[i].nama +"</td>";
            contentTable += "<td>"+ data[i].ruas_jalan +"</td>";
            contentTable += "<td>"+ data[i].lokasi +"</td>";
            contentTable += "<td>"+ data[i].panjang +"</td>";
            contentTable += "<td>"+ data[i].lebar +"</td>";
            contentTable += "<td>"+ data[i].ba +"</td>";
            contentTable += "<td>"+ data[i].nk_ba +"</td>";
            contentTable += "<td>"+ data[i].bb +"</td>";
            contentTable += "<td>"+ data[i].nk_bb +"</td>";
            contentTable += "<td>"+ data[i].pondasi +"</td>";
            contentTable += "<td>"+ data[i].nk_das +"</td>";
            contentTable += "<td>"+ data[i].lantai +"</td>";
            contentTable += "<td>"+ data[i].nk_lnt +"</td>";
            contentTable += "<td> NK"+ data[i].nk_jbt +"</td>";
            no++;
            contentTable += "</tr>";
            $('#bodyLapDD2Jembatan').append(contentTable);
          }
        }
      }, 'json');

      $('#LapDD2JembatanView').show();
    }else if(filterTypeJbt == "2"){
      $('#bodyLapRencanaJembatan').empty();
      $.get('<?= base_url("jembatan/getDataRencanaJbt/");?>' + filterPeriode + '/' + filterPengelola,function(data) {
        var no = 1, total = 0;
        if(data.length > 0){
          for (var i = 0; i < data.length; i++) {
            var contentTable = "<tr class=\"table-body\">";
            contentTable += "<td>"+ no +"</td>";
            contentTable += "<td>"+ data[i].no +"</td>";
            contentTable += "<td>"+ data[i].nama +"</td>";
            contentTable += "<td>"+ data[i].ruas_jalan +"</td>";
            contentTable += "<td>"+ data[i].lokasi +"</td>";
            contentTable += "<td> NK"+ data[i].nk_jbt +"</td>";
            contentTable += "<td align=\"left\">"+ data[i].name +"</td>";
            contentTable += "<td align=\"right\" style=\"padding-right:5px\">"+ parseFloat(data[i].jumlah).toMoney().replace("Rp. ", ""); +"</td>";
            no++;
            total = total + parseFloat(data[i].jumlah);
            contentTable += "</tr>";
            $('#bodyLapRencanaJembatan').append(contentTable);
          }

          var footerTable = "<tr class=\"table-body\">";
          footerTable += "<td colspan=\"6\">&nbsp;</td>";
          footerTable += "<td align=\"left\"><b>JUMLAH</b></td>";
          footerTable += "<td align=\"right\" style=\"padding-right:5px\">"+ parseFloat(total).toMoney().replace("Rp. ", ""); +"</td>";
          $('#bodyLapRencanaJembatan').append(footerTable);
          }
      }, 'json');
      $('#LapRencanaJembatanView').show();
    }
  });

  $('#btnPdfLapJbt').click(function(){
    if(filterTypeJbt == "1"){
      htmlTag = $("#LapDD2JembatanView").html();
    }else if(filterTypeJbt == "2"){
      htmlTag = $("#LapRencanaJembatanView").html();
    }
    
    htmlTag = htmlTag.replace(/<style.*?<\/style>/g, '');
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
</script>