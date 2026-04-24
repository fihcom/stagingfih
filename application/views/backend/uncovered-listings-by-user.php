<?php 
  // pre($getSelectedUserDetails);
?>
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
      <?php if(!empty($getSelectedUserDetails)) { ?>
      <div class="card-header">
        <i class="fa fa-list"></i> Uncovered Lists of <?php echo $getSelectedUserDetails->fname.' '.$getSelectedUserDetails->lname; ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="adminUncoveredListingByUserTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>#</th>
                <th>Listing#</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if(!empty($result)) {
                foreach ($result as $rKey => $rVal) {
                  $aUrl = base_url().'administrator/download-nda/'.$rVal['userId'].'/'.$rVal['unlocked_business'];
                  if($rVal['signed_nda_if_any'] != ''){
                    $aUrl = base_url().'uploads/user_signed_nda_s/signed_nda_by_'.$rVal['userId'].'_for_listing_'.$rVal['unlocked_business'].'.pdf';
                  }
                  # code...
                  ?>
              <tr>
                <td><?php echo ($rKey + 1); ?></td>
                <td><a target="_blank" href="<?php echo base_url(); ?>administrator/sell-request/sell-request-process/<?php echo $rVal['mainlistingId']; ?>"><?php echo $rVal['unlocked_business']; ?></a></td>
                <td><?php echo date('jS F, Y', strtotime($rVal['date_unlocked'])); ?></td>
                <td><a target="_blank" href="<?php echo $aUrl; ?>" class="btn-sm btn-primary downloadPDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a></td>
              </tr>
                  <?php
                }
              } else {
                ?>
              <tr>
                <td colspan="4">No Lists Found</td>
              </tr>
                <?php
              }
              ?>
            </tbody>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Listing#</th>
                <th>Date</th>
                <th>Action</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
      <?php } ?>
      <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
  <!-- /tables-->
  </div>
  <!-- /container-fluid-->
</div>



