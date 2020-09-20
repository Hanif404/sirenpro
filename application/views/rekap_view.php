<style>
  .table-style {
    border-collapse: collapse;
    width: 100%;
    font-size: 8pt;
  }

  .table-style th {
    border: 1px solid black;
  }
  .table-style td {
    border: 1px solid black;
  }

  .table-header{
    text-transform: uppercase;
    text-align: center;
  }

  .table-body td{
    padding-left: 5px;
  }

  .table-footer{
    text-transform: uppercase;
    font-weight: bold;
  }

  .table-footer td{
    padding-left: 5px;
  }
  .column-sm{
    float: left;
    width: 5%;
  }

  .header{
    text-align: center;
    margin-bottom: 20px;
  }
</style>
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
