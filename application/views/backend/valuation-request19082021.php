<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Business Valuation Applications</li>
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
                <input type="text" class="form-control" value="" id="searchNameValuationReq" name="searchName"> &nbsp;<label for="offerStatus">
                
              </div>
        </div>
        </div>
      
        <div class="table-responsive">
          <table class="table table-bordered" id="adminvaluationbusinessTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="no-sort">Sl No.</th>
              <th>Client</th>
              <th>Email</th>
              <th>Phone</th>
              <th class="no-sort">Monetization</th>
              <th class="no-sort">Website</th>
              <th>Date</th>
              <th class="no-sort">Final Valuation</th>
              <th class="no-sort">Yield</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Client</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Monetization</th>
              <th>Website</th>
              <th>Date</th>
              <th>Final Valuation</th>
              <th>Yield</th>
              <th>Action</th>
              </tr>
            </tfoot>
            <?php
            
            ?>
            <tbody>
              
            </tbody>
          </table>
          <input type="hidden" class="form-control csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        </div>
      </div>
      <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
  <!-- /tables-->
  </div>
  <!-- /container-fluid-->
</div>






