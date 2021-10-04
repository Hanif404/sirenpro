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
            <h3 class="header-1">REKAPITULASI BIAYA PROGRAM PENANGANAN</h3>
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
            <tbody id="bodyLapRekapJembatan">
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

            $('#bodyLapRekapJembatan').empty();
            $.get('<?= base_url("jembatan/getRekapJbt/");?>' + filterPeriode,function(data) {
              var no = 1;
              var total_a = 0;
              var total_b = 0;
              var total_c = 0;
              var total_d = 0;
              var total_e = 0;
              if(data.length > 0){
                for (var i = 0; i < data.length; i++) {
                  var a = data[i].total_a ? data[i].total_a : 0;
                  var b = data[i].total_b ? data[i].total_b : 0;
                  var c = data[i].total_c ? data[i].total_c : 0;
                  var d = data[i].total_d ? data[i].total_d : 0;
                  var e = data[i].total_e ? data[i].total_e : 0;

                  var contentTable = "<tr class=\"table-body\">";
                  contentTable += "<td class=\"tbl-th-jbt\">"+ no +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt\">"+ data[i].pengelola +"</td>";

                  contentTable += "<td class=\"tbl-th-jbt\">"+ (data[i].jml_a ? data[i].jml_a : 0); +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt text-right\">"+ parseFloat(a).toMoney().replace("Rp. ", ""); +"</td>";

                  contentTable += "<td class=\"tbl-th-jbt\">"+ (data[i].jml_b ? data[i].jml_b : 0);  +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt text-right\">"+ parseFloat(b).toMoney().replace("Rp. ", ""); +"</td>";

                  contentTable += "<td class=\"tbl-th-jbt\">"+ (data[i].jml_c ? data[i].jml_c : 0); +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt text-right\">"+ parseFloat(c).toMoney().replace("Rp. ", ""); +"</td>";

                  contentTable += "<td class=\"tbl-th-jbt\">"+ (data[i].jml_d ? data[i].jml_d : 0); +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt text-right\">"+ parseFloat(d).toMoney().replace("Rp. ", ""); +"</td>";

                  contentTable += "<td class=\"tbl-th-jbt\">"+ (data[i].jml_e ? data[i].jml_e : 0); +"</td>";
                  contentTable += "<td class=\"tbl-th-jbt text-right\">"+ parseFloat(e).toMoney().replace("Rp. ", ""); +"</td>";

                  total_a = parseInt(total_a) + parseInt(a); 
                  total_b = parseInt(total_b) + parseInt(b); 
                  total_c = parseInt(total_c) + parseInt(c); 
                  total_d = parseInt(total_d) + parseInt(d); 
                  total_e = parseInt(total_e) + parseInt(e); 
                  no++;
                  contentTable += "</tr>";
                  $('#bodyLapRekapJembatan').append(contentTable);
                }
              }

              var contentFooter = "<tr class=\"table-footer\">";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-left\">Jumlah</th>";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+total_a.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+total_b.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+total_c.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+total_d.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+total_e.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "</tr>";

              var totalAll = parseInt(total_a) + parseInt(total_b) + parseInt(total_c) + parseInt(total_d) + parseInt(total_e);
              contentFooter += "<tr class=\"table-footer\">";
              contentFooter += "<th class=\"tbl-th-jbt\">&nbsp;</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-left\" colspan=\"10\">Total</th>";
              contentFooter += "<th class=\"tbl-th-jbt text-right\">"+totalAll.toMoney().replace("Rp. ", "");+"</th>";
              contentFooter += "</tr>";
              $('#bodyLapRekapJembatan').append(contentFooter);
            }, 'json');

            $('#lapRekapJbt').modal('show');
        });

        $('#btnPdfLapRekapJbt').click(function(){
            var htmlTag = $("#LapRekapJbtView").html();
            
            htmlTag = htmlTag.replace(/<style.*?<\/style>/g, '');
            var styleEmbed = "<style>.tbl-th-jbt{font-size:8pt} .table-style{border-collapse:collapse;width:100%;font-size:8pt;} .table-style th{border:1px solid black;} .table-style td{border:1px solid black;} .table-header{text-transform:uppercase;text-align:center;} .table-body .text-right {text-align: right!important; padding-right:3px} .table-footer{text-transform:uppercase;font-weight:bold;} .table-footer .text-right {text-align: right!important; padding-right:3px} .column-sm{float:left;width:5%;} .header{text-align:center;padding-bottom:10px} .header h3{margin-bottom: 5px !important;margin-top: 5px !important;} .header h4{margin-bottom: 0 !important;margin-top: 0 !important;}</style>";
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