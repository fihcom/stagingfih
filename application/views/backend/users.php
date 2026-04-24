<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Users</li>
    </ol>
    <?php 
      $error = $this->session->flashdata('error');
      if($error) {
        ?>
    <div class="alert alert-danger alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('error'); ?>                    
    </div>
        <?php 
      } 

      $success = $this->session->flashdata('success');
      if($success) { 
        ?>
    <div class="alert alert-success alert-dismissable">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?php echo $this->session->flashdata('success'); ?>
    </div>
        <?php 
      } 
    ?>
  <!-- Example DataTables Card-->
    <div class="card mb-3">
      <div class="card-header">
        <i class="fa fa-list"></i> Lists
        <div class="export_area">
          <a href="<?php echo base_url();?>administrator/export-users" class="btn btn-success">Export User Data</a>
        </div>
      </div>
      <div class="card-body">
      
        <div class="table-responsive">
          <table class="table table-bordered" id="usertable" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th class="no-sort">Sl No.</th>
              <th>Client Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Register Date</th>
              <th class="no-sort">Identity</th>
              <th class="no-sort">Fund</th>
              <th class="no-sort">Status</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
            <tr>
              <th>Sl No.</th>
              <th>Client Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Register Date</th>
              <th>Identity</th>
              <th>Fund</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
  <!-- /tables-->
  </div>
  <!-- /container-fluid-->
</div>


<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this user?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



