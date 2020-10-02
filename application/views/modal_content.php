<div class="modal fade" id="jenisKerjaModal" tabindex="-1" role="dialog" aria-labelledby="jenisKerjaModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Jenis Pekerjaan</h5>
        <button type="button" class="close btn-close-jenisKerja">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-jenisKerja" method="post" action="<?= base_url('jenisKerja/setItem');?>">
          <input type="hidden" name="id" />
          <div class="container">
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input1">Kategori</label>
                  <select class="form-control kategori" name="kategori_id" style="width:100%"></select>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Nama Pekerjaan</label>
                  <input type="text" class="form-control" placeholder="Nama Pekerjaan"  name="name" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitJenisKerja" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listJenisKerja" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Kategori</th>
    											<th>Nama Pekerjaan</th>
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

<div class="modal fade" id="rawanModal" tabindex="-1" role="dialog" aria-labelledby="rawanModalTitle" aria-hidden="true">
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

<div class="modal fade" id="pekerjaanModal" tabindex="-1" role="dialog" aria-labelledby="pekerjaanModalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document" style="max-width: 80%;" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Harga Satuan Pekerjaan</h5>
        <button type="button" class="close btn-close-pekerjaan">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="form-satuan-pekerjaan" method="post" action="<?= base_url('satuan/setItem');?>">
          <input type="hidden" name="id_pekerjaan" />
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="form-group">
                  <label for="input1">Jenis pekerjaan</label>
                  <input type="text" class="form-control" aria-describedby="" name="jenis_pekerjaan" placeholder="Jenis pekerjaan">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input2">Harga</label>
                  <input type="text" class="form-control" placeholder="Harga"  name="harga_pekerjaan" >
                </div>
              </div>
              <div class="col-lg-6">
                <div class="form-group">
                  <label for="input3">Satuan</label>
                  <input type="text" class="form-control" placeholder="Satuan"  name="satuan_pekerjaan" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitPekerjaan" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
        </form>
        <div class="container" style="margin-top:20px">
          <div class="row">
            <div class="col-lg-12">
              <table id="listPekerjaan" class="table table-striped table-bordered" style="width:100%">
    							<thead>
    									<tr>
    											<th>Jenis Pekerjaan</th>
    											<th>Harga</th>
    											<th>Satuan</th>
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

<div class="modal fade" id="penggunaModal" tabindex="-1" role="dialog" aria-labelledby="penggunaModalTitle" aria-hidden="true">
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
                <div class="form-group">
                  <label for="input3">Active</label>
                  <select class="is-active" name="is_active" style="width:100%">
                    <option value="1">Ya</option>
                    <option value="0">Tidak</option>
                  </select>
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

<div class="modal fade" id="kategoriModal" tabindex="-1" role="dialog" aria-labelledby="kategoriModalTitle" aria-hidden="true">
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
                <div class="form-group">
                  <label for="input3">Warna</label>
                  <input type="text" class="form-control" placeholder="Warna"  name="warna" >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12">
                <button id="btnSubmitKategori" class="btn btn-primary">Submit</button>
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

<div class="modal fade" id="koordinatModal" tabindex="-1" role="dialog" aria-labelledby="KoordinatModalTitle" aria-hidden="true">
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

<div class="modal fade" id="rekapModal" tabindex="-1" role="dialog" aria-labelledby="RekapModalTitle" aria-hidden="true">
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
