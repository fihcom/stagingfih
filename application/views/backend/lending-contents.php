<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active"><a href="#">Acquisition Lending</a></li>
        <li class="breadcrumb-item active"><a href="#">Page Contents</a></li>
      </ol>
		<div class="box_general padding_bottom">
			<div class="header_box version_2">
				<h2><i class="fa fa-user"></i>Page Contents</h2>
			</div>
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
            
			  <div class="row">
				  <div class="col-md-3">
					  <div class="form-group">
					    <label>Photo</label>
              
              <?php 
              
              if($contents->image != '') 
              { 
              ?>
              <div class="coverImage">
                <img id="profile_pic_image" style="width:220px; height:220px;" src="<?php echo base_url() ?>uploads/otherimages/<?php echo $contents->image ;?>" prev-data-src="<?php echo base_url() ?>uploads/profile_pictures/<?php echo $admin_details->user_profile_pic ;?>" alt="">
                <form style="display:none;" id="dropzone" action="<?php echo base_url() ?>administrator/lending-content/page-image" class="dropzone">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                </form>
                <button style="margin-top:10px;margin-left:30px;display:none;" class="btn btn-info btn-xs" onclick="remove_profile_picture()">Remove Image</button> 
                <button style="margin-top:10px;margin-left:30px;" class="btn btn-warning btn-xs change-user-pic">Change Image</button> 
              </div>  
              <?php 
              } 
              else 
              {
              ?>
              <div class="coverImage">
              <form action="<?php echo base_url() ?>administrator/lending-content/page-image" class="dropzone">
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              </form>
              </div> 
              <?php 
              }
              ?>
				    </div>
          </div>
          <div class="col-md-9">
          <div class="form-group">
                <form role="form" id="editAdmin" action="<?php echo base_url(); ?>administrator/lending-content/update-content" method="post" role="form">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
								<label>Contents </label>
								<textarea class="form-control" name="pageContent_block_one" id="pageContent" rows="6"><?php echo $contents->content_one;?></textarea>
							</div>

          </div>
          <div class="col-md-12">
          <div class="form-group">
								<label>Contents 1 </label>
								<textarea class="form-control" name="pageContent_block_two" id="pageContent1" rows="6"><?php echo $contents->content_two;?></textarea>
							</div>

          </div>
          <div class="col-md-12">
          <div class="form-group">
								<label>Contents 2</label>
								<textarea class="form-control" name="pageContent_block_three" id="pageContent2" rows="6"><?php echo $contents->content_three;?></textarea>
							</div>

          </div>
					<!-- /row-->
					
					
                    <!-- /row-->
                    <div class="box-footer" style="float:right;">
                        <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                    </div>
                </div>
                </form>
            </div>
		    </div>
        <!-- /box_general-->
        
	  </div>
	  <!-- /.container-fluid-->
       </div>
    