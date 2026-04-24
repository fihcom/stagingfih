<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>administrator">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Partners</li>
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
        <!-- <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>deliveryman/testimonials/add"><i class="fa fa-plus"></i> Add New Testimonial </a> -->
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body">
      <div class="row">
      <div class="col-md-6"> </div>
                  

      </div>
      <?php
      if($addpermission)
      {
        ?>
        <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Add Partner</h2>
        </div>
        <?php $this->load->helper("form"); ?>
        <form role="form" id="partnerAdd" action="<?php echo base_url(); ?>administrator/partners-add" method="post" role="form" enctype="multipart/form-data">
        <input type="hidden" class="csrf_instantscouting_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <div class="row">
        <div class="col-md-2">                                
        <div class="form-group">
					<label for="cat_name">Partner Image</label><br clear="all">
					<input type="file" name="featured_image" id="browseImage" class="form-control" style="display:none" onchange="readURL(this);">
					<?php
					$imglink = 'assets/backend/img/image-placeholder-icon.png';
					?>
					<a href="javascript: void(0);" id="browsebtn"><img id="blah" src="<?php echo base_url().$imglink;?>" alt="your image" width="150" height="119" /><br><label id="partnerimage-error" class="error" for="site_title" style="display:none">Partner image is required</label></a>
					
					</div>
                </div>
                
                  
        </div>
        <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="cat_name">Partner URL</label><br clear="all">
                <input type="text" name="partner_url" id="" class="form-control">
                </div>
                </div>    
        </div>
        <div class="row">
                <div class="col-md-6 cat-name">                                
                  <div class="form-group">
                  <input type="hidden" name="action" value="add">
              <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                  </div>
                </div>
				</div>
                
        </form>
        <?php
      }
      ?>
        <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>List Partner</h2>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered <?php echo ($addpermission)?'dragtable':'';?>" id="" width="50%" cellspacing="0">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Partners Image</th>
              <th>Partners URL</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          if(is_array($partners['p']) && count($partners['p'])>0)
          {
              $i = 1;
              foreach($partners['p'] as $val)
              {

                  ?>
                  <tr id="<?php echo $val['id'];?>">
                  <td><?php echo $i;?></td>
                  <td><img src="<?php echo base_url().'uploads/partner-image/'.$val['partner_image'];?>" width="100"></td>
                  <td><a href="<?php echo $val['partner_url']?>"><?php echo mb_strimwidth($val['partner_url'], 0, 70, '...');?></a></td>
                  <td>
                  <?php
                  if($deletepermission)
                  {
                    ?>
                    <a class="btn btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" onclick="delpartner(this)" datadeletehref="<?php echo base_url().'administrator/partners/delete/'.$val['id'];?>" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>
                    <?php
                  }
                  ?>
                  </td>
                  </tr>
                  <?php
                  $i++;
              }
          }else{
              ?>
              <tr>
                  <td align="center" colspan="3">No record found</td>
              <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
            <th>Partners Image</th>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this partner?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrf_instantscouting_name" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div> 
