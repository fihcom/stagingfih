<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Business listing buy Requests</li>
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
      <div class="card-body">
      <div class="row">
          <div class="col-md-2"> </div>
          <div class="col-md-10">                                
             <div class="form-group form-inline float-right"><label for="searchName">Search: &nbsp;</label>
                <input type="text" class="form-control" value="" id="BuysearchName" name="searchName"> &nbsp;<label for="offerStatus">Buy Request Status: &nbsp;</label>
                <select class="mdb-select colorful-select dropdown-primary form-control" searchable="Search here.." name="offerStatus" id="buyStatus">
                <option value="">All</option>
                <option value="1">Pending</option>
                <option value="2">Sold</option>
                <option value="3">Rejected</option>
								</select> &nbsp;<label for="offerStatus">Sell Type: &nbsp;</label>
                <select class="mdb-select colorful-select dropdown-primary form-control" searchable="Search here.." name="sellType" id="sellType">
                <option value="">All</option>
                <option value="1">Offer Sell</option>
                <option value="2">Normal Sell</option>
								</select>
              </div>
        </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="listingbuyTable" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th>Payment Ref #</th>
              <th>Seller Email</th>
              <th>Buy Date</th>
              <th class="no-sort">Sell Type</th>
              <th class="no-sort">Buy Status</th>
              <th>Sell Price</th>
              <th class="no-sort">Commission</th>
              <th class="no-sort">Net Proceeds</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
          <tr>
              <th>Payment Ref #</th>
              <th>Seller Email</th>
              <th>Buy Date</th>
              <th>Sell Type</th>
              <th>Buy Status</th>
              <th>Sell Price</th>
              <th>Commission</th>
              <th>Net Proceeds</th>
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



