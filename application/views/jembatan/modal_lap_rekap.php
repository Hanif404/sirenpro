<div class="modal fade" id="lapRekapJbt" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="uploadModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 95%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rekapitulasi Biaya Jembatan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <div class="modal-body">
        <style>
              .tbl-th-jbt{
                  font-size:8pt
              }
        </style>
        <div id="LapRekapJbtView" style="display:none">
          <div class="header">
            <h3>REKAPITULASI BIAYA PROGRAM PENANGANAN</h3>
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
              <td>Tahun</td>
              <td>:</td>
              <td class="viewTitlePeriodeJbt"></td>
            </tr>
          </table>
          <table class="table-style" id="tableRekapJbt" style="font-size: 12pt;text-align: center;margin-top:20px" border="1">
            <tr>
              <th rowspan="2" class="tbl-th-jbt">NO</th>
              <th rowspan="2" class="tbl-th-jbt">KABUATEN</th>
              <th colspan="2" class="tbl-th-jbt">PEMELIHARA RUTIN</th>
              <th colspan="2" class="tbl-th-jbt">PEMELIHARA BERKALA</th>
              <th colspan="2" class="tbl-th-jbt">PERBAIKAN DAN ATAU PERKUATAN</th>
              <th colspan="2" class="tbl-th-jbt">PERKUATAN ATAU PENGGANTIAN</th>
              <th colspan="2" class="tbl-th-jbt">PENGGANTIAN ATAU PENANGANAN BESAR</th>
            </tr>
            <tr>
              <th class="tbl-th-jbt">Jumlah</br>Jembatan</th>
              <th class="tbl-th-jbt">Jumlah Anggaran</br>(Rp.)</th>
              <th class="tbl-th-jbt">Jumlah</br>Jembatan</th>
              <th class="tbl-th-jbt">Jumlah Anggaran</br>(Rp.)</th>
              <th class="tbl-th-jbt">Jumlah</br>Jembatan</th>
              <th class="tbl-th-jbt">Jumlah Anggaran</br>(Rp.)</th>
              <th class="tbl-th-jbt">Jumlah</br>Jembatan</th>
              <th class="tbl-th-jbt">Jumlah Anggaran</br>(Rp.)</th>
              <th class="tbl-th-jbt">Jumlah</br>Jembatan</th>
              <th class="tbl-th-jbt">Jumlah Anggaran</br>(Rp.)</th>
            </tr>
            <tr>
              <th class="tbl-th-jbt">1</th>
              <th class="tbl-th-jbt">2</th>
              <th class="tbl-th-jbt">3</th>
              <th class="tbl-th-jbt">4</th>
              <th class="tbl-th-jbt">5</th>
              <th class="tbl-th-jbt">6</th>
              <th class="tbl-th-jbt">7</th>
              <th class="tbl-th-jbt">8</th>
              <th class="tbl-th-jbt">9</th>
              <th class="tbl-th-jbt">10</th>
              <th class="tbl-th-jbt">11</th>
              <th class="tbl-th-jbt">12</th>
            </tr>
            <tr>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-left pl-1">Jumlah</th>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-right pr-1">4</th>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-right pr-1">6</th>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-right pr-1">8</th>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-right pr-1">10</th>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-right pr-1">12</th>
            </tr>
            <tr>
              <th class="tbl-th-jbt">&nbsp;</th>
              <th class="tbl-th-jbt text-left pl-1" colspan="10">Total</th>
              <th class="tbl-th-jbt text-right pr-1">-</th>
            </tr>
            <tbody id="bodyRekapJbt">
            </tbody>
          </table>
        </div>
      </div>
        
      <div class="modal-footer">
        <button type="button" id="btnPdfLapRekapJbt" class="btn btn-primary">Simpan PDF</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#btnRekapJembatan').on('click', function(){
            var filterPeriode = $('#periodeRekapJembatan').val();
            var filterPengelola = $('#cbDaerahJembatan').val();
            $('#LapRekapJbtView').show();

            $('.viewTitlePeriodeJbt').text(filterPeriode);
            $('#lapRekapJbt').modal('show');
        });

        $('#btnPdfLapRekapJbt').click(function(){
            var htmlTag = $("#LapRekapJbtView").html();
            
            htmlTag = htmlTag.replace(/<style.*?<\/style>/g, '');
            var styleEmbed = "<style>.tbl-th-jbt{font-size:8pt}.table-style{border-collapse:collapse;width:100%;font-size:8pt;} .table-style th{border:1px solid black;} .table-style td{border:1px solid black;} .table-header{text-transform:uppercase;text-align:center;} .table-body td{padding-left:5px;} .table-footer{text-transform:uppercase;font-weight:bold;} .table-footer td{padding-left:5px;} .column-sm{float:left;width:5%;} .header{text-align:center;margin-bottom:20px;}</style>";
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
    });
    
</script>