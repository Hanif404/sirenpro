<div class="modal fade" id="penangananModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penangananModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Program Penanganan</h5>
        <button type="button" class="close btn-close-penanganan">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container" style="margin-bottom: 10px;">
          <div class="row">
            <div class="col-lg-12">
              <h6>Area Penanganan</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="row">
                <div class="col-md-6">
                  <select class="form-control" id="fieldPeriode" style="width:100%"></select>
                </div>
                <div class="col-md-6">
                  <select class="form-control" id="fieldNoRuas" style="width:100%"></select>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="row">
                <div class="col-md-6">
                  <select class="form-control combokm" id="fieldAwalKm" style="width:100%"></select>
                </div>
                <div class="col-md-6">
                  <select class="form-control comboakhirkm" id="fieldAkhirKm" style="width:100%"></select>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <button id="btnViewPenanganan" class="btn btn-primary" style="margin-top: 10px;">Tampilkan Data</button>
              <button id="btnViewPdf" class="btn btn-success" style="margin-top: 10px;"><span id="txtbtnpdf_penanganan">Laporan Rekapitulasi</span></button>
            </div>
          </div>
        </div>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listPenanganan" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Kondisi</th>
    											<th>Penanganan</th>
                          <!-- <th>Panjang (KM)</th> -->
                          <th>Volume (M2)</th>
    											<th>&nbsp;</th>
    									</tr>
    							</thead>
    					</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="penangananDetModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penangananDetModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Program Penanganan</h5>
        <button type="button" class="close btn-close-penangananDet">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container" style="margin-bottom: 10px;">
          <div class="row">
            <div class="col-lg-12">
              <h6>Area Penanganan</h6>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <table width="60%">
                <tr>
                  <td>Nama Ruas</td>
                  <td>:</td>
                  <td id="viewNameRuas">-</td>
                  <td>Panjang</td>
                  <td>:</td>
                  <td id="viewPanjang">-</td>
                </tr>
                <tr>
                  <td>Penanganan Jalan</td>
                  <td>:</td>
                  <td id="viewNamePenanganan">-</td>
                  <td>Luas</td>
                  <td>:</td>
                  <td id="viewLuas">-</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <form class="form-penanganan" method="post" action="<?= base_url('penanganan/setItem');?>" style="display:none;">
          <input type="hidden" name="id" />
          <input type="hidden" id="fieldKodeJalan" name="hash" >
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Jenis Pekerjaan</label>
                  <select class="form-control jns_pekerjaan" name="jenis_id" id="fieldJnsPekerjaan" style="width:100%"></select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Harga</label>
                  <input type="hidden" id="fieldHargaPekerjaan" name="harga" >
                  <input type="text" class="form-control" placeholder="Harga" id="viewHargaPekerjaan" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Volume</label>
                  <input type="number" min="0" value="0" id="viewInputHarga" class="form-control" placeholder="Volume" oninput="hitungBiaya(this.value)" name="volume" />
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Total Biaya</label>
                  <input type="text" class="form-control" placeholder="Total Biaya" id="fieldBiayaPenanganan" disabled>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitPenangananDet" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listPenangananDet" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Jenis Pekerjaan</th>
    											<!-- <th>Panjang (KM)</th> -->
    											<th>Volume</th>
    											<th>Harga (Rp)</th>
    											<th>Total Biaya</th>
    											<th>&nbsp;</th>
    									</tr>
    							</thead>
    					</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- start jenis pekerjaan modal -->
<div class="modal fade" id="jenisKerjaModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="jenisKerjaModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Jenis Pekerjaan</h5>
        <button type="button" class="close btn-close-jenisKerja">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-jenis-jalan-tab" data-toggle="tab" href="#nav-jenis-jalan" role="tab" aria-controls="nav-jalan" aria-selected="true" onclick="clearFormJPekerjaan();">Jalan</a>
            <a class="nav-link" id="nav-jenis-jembatan-tab" data-toggle="tab" href="#nav-jenis-jembatan" role="tab" aria-controls="nav-jembatan" aria-selected="false" onclick="clearFormJPekerjaan();">Jembatan</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-jenis-jalan" role="tabpanel" aria-labelledby="nav-jenis-jalan-tab" style="padding-top:10px">
            <?php $this->load->view('jalan/jenis_kerja')?>
          </div>
          <div class="tab-pane fade" id="nav-jenis-jembatan" role="tabpanel" aria-labelledby="nav-jenis-jembatan-tab" style="padding-top:10px">
            <?php $this->load->view('jembatan/jenis_kerja')?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end jenis pekerjaan modal -->

<!-- start rawan modal -->
<div class="modal fade" id="rawanModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="rawanModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rawan Bencana</h5>
        <button type="button" class="close btn-close-rawan">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-rawan" method="post" action="<?= base_url('rawan/setItem');?>">
          <input type="hidden" name="id" />
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="input2">Jenis Bencana</label>
                      <select class="form-control" name="jns_bencana" id="fieldJnsBencana">
                        <option value="1">Rawan Longsor</option>
                        <option value="2">Rawan Banjir</option>
                        <option value="3">Rawan Kecelakaan</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="input2">Lokasi</label>
                      <input type="text" class="form-control" placeholder="Lokasi"  name="location" >
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="input3">Latitude</label>
                      <input type="text" class="form-control" placeholder="Latitude"  name="latitude" >
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="input3">Longtitude</label>
                      <input type="text" class="form-control" placeholder="Longtitude"  name="longtitude" >
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitRawan" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listRawan" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Jenis</th>
    											<th>Titik</th>
    											<th>Lokasi</th>
    											<th>&nbsp;</th>
    									</tr>
    							</thead>
    					</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end rawan modal -->

<!-- start harga pekerjaan modal -->
<div class="modal fade" id="pekerjaanModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="pekerjaanModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Harga Satuan Pekerjaan</h5>
        <button type="button" class="close btn-close-pekerjaan">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <nav>
          <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-link active" id="nav-jalan-tab" data-toggle="tab" href="#nav-jalan" role="tab" aria-controls="nav-jalan" aria-selected="true" onclick="clearFormHPekerjaan();">Jalan</a>
            <a class="nav-link" id="nav-jembatan-tab" data-toggle="tab" href="#nav-jembatan" role="tab" aria-controls="nav-jembatan" aria-selected="false" onclick="clearFormHPekerjaan();">Jembatan</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-jalan" role="tabpanel" aria-labelledby="nav-jalan-tab" style="padding-top:10px">
            <?php $this->load->view('jalan/harga_kerja')?>
          </div>
          <div class="tab-pane fade" id="nav-jembatan" role="tabpanel" aria-labelledby="nav-jembatan-tab" style="padding-top:10px">
            <?php $this->load->view('jembatan/harga_kerja')?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end harga pekerjaan modal -->

<!-- start pengguna modal -->
<div class="modal fade" id="penggunaModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="penggunaModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Pengguna</h5>
        <button type="button" class="close btn-close-pengguna">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-pengguna" method="post" enctype="multipart/form-data" action="<?= base_url('pengguna/setItem/profile');?>">
          <input type="hidden" name="id" />
          <input type="hidden" name="file_profile_old" />
          <input type="hidden" name="password_old" />
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input1">NIP</label>
                  <input type="text" class="form-control" placeholder="NIP"  name="nip" >
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Nama</label>
                  <input type="text" class="form-control" placeholder="Nama"  name="nama" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Email</label>
                  <input type="email" class="form-control" placeholder="Email"  name="email" >
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input4">Password</label>
                  <input type="password" class="form-control" placeholder="Password"  name="password" >
                </div>
              </div>
            </div>
            <div class="row" style="margin-bottom: 10px;">
              <div class="col-lg-6">
                <label for="input5">File Image</label>
                <input type="file" class="form-control" name="file_image" >
              </div>
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="input3">Role</label>
                      <select class="is-active" name="is_admin" style="width:100%">
                        <option value="2">Operator</option>
                        <option value="3">Viewer</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="input3">Active</label>
                      <select class="is-active" name="is_active" style="width:100%">
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                      </select>
                    </div>
                  </div>
                </div>

              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitPengguna" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listPengguna" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>NIP</th>
    											<th>Nama</th>
    											<th>Email</th>
    											<th>Role</th>
    											<th>Active</th>
    											<th>&nbsp;</th>
    									</tr>
    							</thead>
    					</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end pengguna modal -->

<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="kategoriModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Kategori</h5>
        <button type="button" class="close btn-close-kategori">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-kategori" method="post" action="<?= base_url('kategori/setItem');?>">
          <input type="hidden" name="id" />
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Nama</label>
                  <input type="text" class="form-control" placeholder="Nama"  name="name" >
                </div>
              </div>
              <div class="col-lg-6">
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="input3">Warna</label>
                      <input type="text" class="form-control" placeholder="Warna"  name="warna" >
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label for="input3">Jenis</label>
                      <select class="jenis_kategori" id="fieldJenisKategori" name="jenis" style="width:100%">
                        <option value="1">Ruas Jalan</option>
                        <option value="2">Penanganan</option>
                        <option value="3">Jembatan</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitKategori" class="btn btn-primary">Submit</button>
                <button id="btnResetKategori" class="btn btn-default">Reset</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listKategori" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Nama</th>
    											<th>Warna</th>
    											<th>Jenis</th>
    											<th>&nbsp;</th>
    									</tr>
    							</thead>
    					</table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="koordinatModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="KoordinatModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Import Koordinat Jalan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-koordinat" method="post" action="<?= base_url('koordinat/setItem');?>">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="input2">File CSV</label>
                  <input type="file" class="form-control"  name="file_csv" accept=".csv">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitKoordinat" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="RekapModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 90%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Rekapitulasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="rekapBody">
        <?php $this->load->view('rekap_view');?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnPdf">PDF</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="viewPenangananModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="viewPenangananModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Jenis Penanganan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <select class="kategori" id="aSelect" style="width:100%"></select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btnReviewPdf">Tampilkan Data</button>
      </div>
    </div>
  </div>
</div>
