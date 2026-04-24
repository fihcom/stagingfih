<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Commission Settings</li>
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
        <?php
        if($addpermission)
        {
          ?>
        <a style="float:right;" class="btn btn-sm btn-primary btn-sm addcommissionbtn" href="javascript: void(0);"><i class="fa fa-plus"></i> Add New Commission </a>
        <?php
        }
        ?>
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body">
      <div class="box box-primary addcommissionpane" style="display:none">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddCommission" action="<?php echo base_url(); ?>administrator/site-settings/commission-settings/add" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="action" value="add" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">                                
                    <div class="form-group">
                      <label for="firstName">Price From</label>
                      <input type="text" class="form-control" id="priceFrom" name="priceFrom" value="">
                    </div>
                  </div>
                  <div class="col-md-4">                                
                    <div class="form-group">
                      <label for="firstName">Price To</label>
                      <input type="text" class="form-control" id="priceTo" name="priceTo" value="">
                    </div>
                  </div>
                  <div class="col-md-4">                                
                    <div class="form-group">
                      <label for="firstName">Commission Percentage<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="percentage" name="percentage" value="">
                    </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="add">
                <input type="submit" name="submit" class="btn btn-sm btn-primary" value="Submit" />
                <input type="button" class="btn btn-default cancelcommissionadd" value="Cancel" />
                <p><span style="color:red;">*</span> fields are mandatory.</p>
              </div>
            </form>
          </div>
      
        <div class="table-responsive">
          <table class="table table-bordered gallerydragtable" id="galleryTable" width="100%" cellspacing="0" data-count="<?php echo $countAllBookings;?>">
          <thead>
            <tr>
                <th>Price From</th>
                <th>Price To</th>
                <th>Percentage</th>
                <th>Action</th>
            </tr>
          </thead>
          <tbody id="vlist">
          <?php
          if(is_array($commissions) && count($commissions)>0){
            $i=1;
            foreach($commissions as $val){
              ?>
              <form action="<?php echo base_url(); ?>administrator/site-settings/commission-settings/add" method="post">
              <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="id" value="<?php echo $val['id']; ?>" />
              <input type="hidden" name="action" value="edit" />
              <tr>
              <td>
              <?php
              if($val['price_from']>0){
                ?>
                <input type="text" style="width:200px" class="form-control" id="priceFrom" name="priceFrom" value="<?php echo ($val['price_from']>0)?$val['price_from']:'';?>">
                <?php
              }else{
                echo 'From zero';
              }
              ?>
              </td>
              <td>
              <?php
              if($val['price_to']>0){
                ?>
                <input type="text" style="width:200px" class="form-control" id="priceTo" name="priceTo" value="<?php echo ($val['price_to']>0)?$val['price_to']:'';?>">
                <?php
              }else{
                echo 'and more..';
              }
              ?>
              </td>
              <td><input type="text" style="width:200px" class="form-control" id="percentage" name="percentage" value="<?php echo $val['percentage'];?>"></td>
              <td>
              <?php
              if($editpermission)
              {
                ?>
              <button type="submit" class="btn btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></button>
              <?php
              }if($deletepermission)
              {
                ?>
              <?php echo '<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/site-settings/commission-settings/delete/'.$val['id'].'" class="btn-sm btn-danger deletepolitician"><i class="fa fa-trash" aria-hidden="true"></i></a>';?>
              <?php
              }
              ?>
              </td>
            </tr>
            </form>
              <?php
              $i++;
            }
          }else{
            ?>
            <tr>
            <td colspan="5">No Commission Found.</td>
            </tr>
            <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Price From</th>
                <th>Price To</th>
                <th>Percentage</th>
                <th>Action</th>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this commission settings?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-sm btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn btn-sm">Cancel</button>
      </div>
    </div>
  </div>
</div>



