<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Listings</li>
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
        
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body">
      <div class="row">
          <div class="col-md-6"> </div>
          <div class="col-md-6">                                
             <div class="form-group form-inline float-right"><label for="searchName">Search: &nbsp;</label>
                <input type="text" class="form-control" value="" id="searchNameappSell" name="searchName"> &nbsp;<label for="offerStatus">Sell Status: &nbsp;</label>
                <select class="mdb-select colorful-select dropdown-primary form-control" searchable="Search here.." name="sellStatus" id="sellStatusappSell">
                <option value="">All</option>
                <option value="1">Published</option>
                <option value="0">Inactive</option>
                <option value="2">Pending Approval</option>
                <option value="3">Pending Sell</option>
                <option value="4">Sold</option>
								</select>
              </div>
        </div>
        </div>
        <input type="hidden" id="siteurl" value="<?php echo base_url();?>">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="table-responsive">

          <table class="table table-bordered" id="adminapprodevsellTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Client</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Listing#</th>
              <th class="no-sort">Website</th>
              <th class="no-sort">Show at Home</th>
              <th>Date</th>
              <th class="no-sort">Status</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
            <tr>
              <th>Client</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Listing#</th>
              <th>Website</th>
              <th>Show at Home</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
              </tr>
            </tfoot>
            <?php
            
            ?>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this sell?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



