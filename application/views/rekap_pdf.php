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
    font-weight: bold;
    text-transform: uppercase;
    text-align: center;
  }

  .table-body td{
    padding-left: 5px;
  }
</style>
<table class="tableRekap">
  <tr class="table-header">
    <th rowspan="3">No</th>
    <th rowspan="3">Nama ruas jalan</th>
    <th rowspan="3">Kuantitas</th>
    <th rowspan="3">total</th>
    <th colspan="7">kondisi jalan</th>
  </tr>
  <tr class="table-header">
    <td colspan="3">mantap</td>
    <td colspan="4">tidak mantap</td>
  </tr>
  <tr class="table-header">
    <td>sangat baik</td>
    <td>baik</td>
    <td>sedang</td>
    <td>jelek</td>
    <td>parah</td>
    <td>sangat parah</td>
    <td>hancur</td>
  </tr>
  <?php
    $urut = 1;
    $total_all = 0;
    $total_1 = 0;
    $total_2 = 0;
    $total_3 = 0;
    $total_4 = 0;
    $total_5 = 0;
    $total_6 = 0;
    $total_7 = 0;
  ?>
  <?php foreach($data as $value): ?>
    <tr class="table-body">
      <td><?php echo $urut;?></td>
      <td><?php echo $value['nama_ruas'];?></td>
      <td>M2<br/>KM</td>
      <td><?php echo number_format((float) $value['total_m2_all'], 3, '.', '');?><br/><?php echo number_format((float) $value['panjang'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_1'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_1'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_2'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_2'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_3'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_3'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_4'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_4'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_5'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_5'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_6'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_6'], 3, '.', '');?></td>
      <td><?php echo number_format((float) $value['total_m2_7'], 3, '.', '');?><br/><?php echo number_format((float) $value['total_km_7'], 3, '.', '');?></td>
    </tr>
    <?php
      $total_all = $total_all + (float) $value['panjang'];
      $total_1 = (float) $total_1 + (float) $value['total_km_1'];
      $total_2 = (float) $total_2 + (float) $value['total_km_2'];
      $total_3 = (float) $total_3 + (float) $value['total_km_3'];
      $total_4 = (float) $total_4 + (float) $value['total_km_4'];
      $total_5 = (float) $total_5 + (float) $value['total_km_5'];
      $total_6 = (float) $total_6 + (float) $value['total_km_6'];
      $total_7 = (float) $total_7 + (float) $value['total_km_7'];
      $urut++;
    ?>
  <?php endforeach;?>
  <tr class="table-body">
    <td></td>
    <td></td>
    <td></td>
    <td><?php echo number_format((float)$total_all, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_1, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_2, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_3, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_4, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_5, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_6, 3, '.', '');?></td>
    <td><?php echo number_format((float)$total_7, 3, '.', '');?></td>
  </tr>
</table>
