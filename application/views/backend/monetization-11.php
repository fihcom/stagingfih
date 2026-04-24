<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Monetization</li>
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
        <a style="float:right;" class="btn btn-primary btn-sm addasset" href="javascript: void(0);"><i class="fa fa-plus"></i> Add New Monetization </a>
        <?php
        }
        ?>
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body">
      <?php
        if($addpermission)
        {
        ?>
      <div class="box box-primary addassetpane" style="display:none">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddAsset" action="<?php echo base_url(); ?>administrator/site-settings/monetization/add" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="action" value="add" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="firstName">Monetization<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="monetizationName" name="monetizationName" value="">
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="firstName">Low multiple<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="lowmultiple" name="lowmultiple" value="<?php echo $val['low_multiple'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="firstName">High multiple<span style="color:red;">*</span></label>
                      <input type="text" class="form-control" id="heighMuiltiple" name="heighMuiltiple" value="<?php echo $val['high_multiple'];?>">
                    </div>
                  </div>
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="firstName">Status</label>
                      <select name="assetStatus" id="" class="form-control">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                  </select>
                    </div>
                  </div>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="add">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <input type="button" class="btn btn-default cancelvideoadd" value="Cancel" />
                <p><span style="color:red;">*</span> fields are mandatory.</p>
              </div>
            </form>


          </div>
          <?php
        }
        ?>
        <div class="table-responsive">
          <table class="table table-bordered gallerydragtable" id="galleryTable" width="100%" cellspacing="0" data-count="<?php echo $countAllBookings;?>">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Monetization</th>
              <th>Low multiple</th>
              <th>High multiple</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="vlist">
          <?php
          if(is_array($assets) && count($assets)>0){
            $i=1;
            foreach($assets as $val){
              if($val['Status'] == '1'){
                $DisStatus = 'Active';
              }elseif($val['Status'] == '0'){
                $DisStatus = 'Inactive';
              }

              ?>
              <form action="<?php echo base_url(); ?>administrator/site-settings/monetization/add" method="post">
              <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="id" value="<?php echo $val['id']; ?>" />
              <input type="hidden" name="action" value="edit" />
              <tr id="<?php echo $val['id'];?>">
              <td><?php echo $i;?></td>
              <td><input type="text" class="form-control" id="monetizationName" name="monetizationName" value="<?php echo $val['name'];?>"></td>
              <td><input type="text" class="form-control" id="lowmultiple" name="lowmultiple" value="<?php echo $val['low_multiple'];?>"></td>
              <td><input type="text" class="form-control" id="heighMuiltiple" name="heighMuiltiple" value="<?php echo $val['high_multiple'];?>"></td>
              <td>
                  <select name="assetStatus" id="" class="form-control">
                    <option value="1" <?php echo ($val['Status'] == '1')? 'selected': ''; ?>>Active</option>
                    <option value="0" <?php echo ($val['Status'] == '0') ? 'selected' : '';?>>Inactive</option>
                  </select>
              </td>
              <td>
              <?php
              if($editpermission)
              {
                ?>
              <button type="submit" class="btn btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                  <?php
              }
              if($deletepermission)
              {
              ?>
              <?php echo '<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/site-settings/monetization/delete/'.$val['id'].'" class="btn btn-sm btn-danger deletepolitician"><i class="fa fa-trash" aria-hidden="true"></i></a>';?>
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
            <td colspan="5">No Asset Found.</td>
            </tr>
            <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Monetization</th>
              <th>Low multiple</th>
              <th>High multiple</th>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this asset?</h4>
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



