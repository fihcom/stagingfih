<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Business listing offers</li>
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
          <div class="col-md-6"> </div>
          <div class="col-md-6">                                
             <div class="form-group form-inline float-right"><label for="searchName">Search: &nbsp;</label>
                <input type="text" class="form-control" value="" id="searchName" name="searchName"> &nbsp;<label for="offerStatus">Offer Status: &nbsp;</label>
                <select class="mdb-select colorful-select dropdown-primary form-control" searchable="Search here.." name="offerStatus" id="offerStatus">
                <option value="">All</option>
                <option value="1">Pending</option>
                <option value="2">Approved</option>
								</select>
              </div>
        </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered" id="listingofferTable" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th class="no-sort">Sl No.</th>
              <th>Buyer Name</th>
              <th>Buyer Email</th>
              <th>Offer Price</th>
              <th>Seller Name</th>
              <th>Seller Email</th>
              <th>Listing#</th>
              <th>Offer Date</th>
              <th class="no-sort">Offer Status</th>
              <th class="no-sort">Action</th>
            </tr>
          </thead>
          <tbody>
          
          </tbody>
          <tfoot>
          <tr>
              <th>Sl No.</th>
              <th>Buyer Name</th>
              <th>Buyer Email</th>
              <th>Offer Price</th>
              <th>Seller Name</th>
              <th>Seller Email</th>
              <th>Listing#</th>
              <th>Offer Date</th>
              <th>Offer Status</th>
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



