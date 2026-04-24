<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo ADMIN_PATH;?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">List Fund Acquition</li>
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
          <i class="fa fa-table"></i> List Fund Acquition
          
        </div>
          
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="fundacquisition" width="100%" cellspacing="0">
            <thead>
            <tr>
            <th>ID</th>
                <th>Investor</th>
                <th>Full Name</th>
                <th>Street</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Added / Modified Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                </tbody>
              <tfoot>
                <tr>
                <th>ID</th>
                <th>Investor</th>
                <th>Full Name</th>
                <th>Street</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Added / Modified Date</th>
                <th>Action</th>
                </tr>
              </tfoot>
              
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
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this listing?</h4>
      </div>
      <div class="modal-footer">
        <form id="delform" action="" method="post">
      <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        
        <input type="submit" value="Delete" class="btn btn-primary">
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>
       