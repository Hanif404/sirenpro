<style>
  .tableRekap {
    border-collapse: collapse;
    width: 100%;
    font-size: 8pt;
  }

  .tableRekap, th, td {
    border: 1px solid black;
  }

  .table-header{
    text-transform: uppercase;
    text-align: center;
  }

  .table-body td{
    padding-left: 5px;
  }
</style>
<table class="tableRekap"></table>
<div class="container-fluid" style="text-align: right;font-size: 8pt;margin-top: 10px;">
  <div class="row d-flex justify-content-end">
    <div class="col-sm-2">Mantap</div>
    <div class="col-sm-2" id="km_mantap">00.00 Km</div>
    <div class="col-sm-2" id="persentase_mantap">00.00 %</div>
  </div>
  <div class="row d-flex justify-content-end">
    <div class="col-sm-2">Tidak Mantap</div>
    <div class="col-sm-2" id="km_tmantap">00.00 Km</div>
    <div class="col-sm-2" id="persentase_tmantap">00.00 %</div>
  </div>
</div>
