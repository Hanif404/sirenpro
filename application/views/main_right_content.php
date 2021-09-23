<div class="sidemenu-profile">
  <div class="dropdown">
    <img src="<?= base_url();?>assets/image/no_profile.png" class="profile_photo rounded-circle shadow" width="50px" height="50px" id="profileMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
    <div class="card-profile dropdown-menu dropdown-menu-right" aria-labelledby="profileMenu">
      <img class="profile_photo" src="<?= base_url();?>assets/image/no_profile.png" style="width:100%;margin-top: -10px;">
      <div style="padding:10px">
        <h3 id="profile_name">user name</h3>
        <p class="title" id="profile_nip">NIP user</p>
        <div class="row">
          <div class="col-md-6">
            <!-- <a href="#" class="btn btn-block btn-primary">Edit Profile</a> -->
          </div>
          <div class="col-md-6">
            <a href="<?= base_url('auth/quit')?>" class="btn btn-block btn-light">Keluar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="sidemenu-legenda"></div>
<?php $this->load->view('modal_content');?>
<?php $this->load->view('modal_content_jembatan');?>
