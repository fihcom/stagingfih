<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'politician';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Survey Lists</li>
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
        <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>politician/surveyforms/add"><i class="fa fa-plus"></i> Add New Survey </a>
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body survey-form-list-body">
      <ul class="ul row center survey-form-list-top" style="list-style-type:none;;">
          <li class="col-md-7"><input type="text" class="form-control leftInput" value="" id="SearchListPoli" name="Search" placeholder="Search List"></li> 
          <li class="col-md-5">
            <span>Survey Status:</span>
            <select name="" id="searchStatusPoli" class="form-control form-control-sm">
              <option value="">All</option>
              <option value="1">Pending Approval</option>
              <option value="2">Published</option>
              <option value="3">Rejected</option>
              <option value="22">Expired</option>
            </select>
          </li>
        </ul>
      
        <div class="table-responsive">
          <table class="table table-bordered" id="surveyTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Survey Title</th>
              <th>Submission Date</th>
              <th>Expiry Date</th>
              <th>Billing #</th>
              <th>Amount Paid</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Survey Title</th>
              <th>Submission Date</th>
              <th>Expiry Date</th>
              <th>Billing #</th>
              <th>Amount Paid</th>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this voter review?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



