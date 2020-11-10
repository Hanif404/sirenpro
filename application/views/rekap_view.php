<style>
.table-style{border-collapse:collapse;width:100%;font-size:8pt;}
.table-style th{border:1px solid black;}
.table-style td{border:1px solid black;}
.table-header{text-transform:uppercase;text-align:center;}
.table-body td{padding-left:5px;}
.table-footer{text-transform:uppercase;font-weight:bold;}
.table-footer td{padding-left:5px;}
.column-sm{float:left;width:5%;}
.header{text-align:center;margin-bottom:20px;}
</style>
<div id="viewRekap" style="display:none">
  <div class="header">
    <h5>REKAPITULASI KONDISI JALAN <span id="txt_total" style="display: none;">PROVINSI</span></h5>
    <h6>PADA UPTD PENGELOLAAN JALAN DAN JEMBATAN WILAYAH PELAYANAN IV</h6>
  </div>
  <table class="table-style rekap1"></table>
  <table class="table-style rekap2"></table>
  <table width="100%">
    <tr>
      <td width="50%"></td>
      <td width="50%">
        <table width="100%" style="text-align: right;font-size: 8pt;margin-top: 10px;">
          <tr>
            <td width="15%">Mantap</td>
            <td width="5%" id="km_mantap">00.00 Km</td>
            <td width="5%" id="persentase_mantap">00.00 %</td>
          </tr>
          <tr>
            <td>Tidak Mantap</td>
            <td id="km_tmantap">00.00 Km</td>
            <td id="persentase_tmantap">00.00 %</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</div>
<div id="viewPenanganan" style="display:none">
  <div class="header">
    <h5>RENCANA ANGGARAN BIAYA</h5>
    <h6>PEKERJAAN <span id="txt_header"></span></h6>
  </div>
  <table width="100%" border="0">
    <tr>
      <td width="10%">No Ruas</td>
      <td width="1%">:</td>
      <td width="50%" id="col_no_ruas"></td>
      <td width="17%">Lokasi Penanganan</td>
      <td width="1%">:</td>
      <td width="50%" id="col_lok_penanganan"></td>
      <!-- <td width="17%">Panjang Penanganan Jalan</td> -->
      <!-- <td width="1%">:</td>
      <td width="50%" id="col_panjang_penanganan"></td> -->
    </tr>
    <tr>
      <td>Nama Ruas</td>
      <td>:</td>
      <td id="col_nm_ruas"></td>
      <td>Periode Survey</td>
      <td>:</td>
      <td id="col_periode"></td>
    </tr>
    <tr>
      <td>Panjang Jalan</td>
      <td>:</td>
      <td id="col_panjang_jalan"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <table class="table-style rekap3" style="font-size: 12pt;text-align: center;margin-top:20px"></table>
</div>
<div id="viewAllPenanganan" style="display:none">
  <div class="header">
    <h5>REKAPITULASI</h5>
    <h6>RENCANA ANGGARAN BIAYA</h6>
  </div>
  <table class="table-style rekap4" style="font-size: 10pt;text-align: center;margin-top:20px"></table>
</div>
