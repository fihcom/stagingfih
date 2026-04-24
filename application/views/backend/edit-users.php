<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>administrator">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Edit User</li>
    </ol>
    <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i>Edit User</h2>
              <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/users">Back to list</a>
            </div><!-- /.box-header -->
            <!-- form start -->
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
            <br clear="all">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="userProfile" action="<?php echo base_url(); ?>administrator/users/updateuser" method="post" role="form" enctype="multipart/form-data">
              <input type="hidden" name="requestId" value="<?php echo $result->user_id ?>"> 
              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="row">
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">First Name</label>
                    <input type="text" class="form-control" value="<?php echo $result->fname ?>" id="fname" name="fname" />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Last Name</label>
                    <input type="text" class="form-control" value="<?php echo $result->lname ?>" id="lname" name="lname" />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Phone</label>
                    <input type="text" class="form-control" value="<?php echo $result->phone ?>" id="phone" name="phone" />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Email</label>
                    <input type="text" class="form-control" value="<?php echo $result->mail ?>" id="" disabled readonly />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Date of Birth</label>
                    <input type="text" class="form-control" value="<?php echo ($result->dob != '0000-00-00') ? date('jS M Y',strtotime($result->dob)) : ''; ?>" disabled readonly />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Investor Pass</label>
                    <input type="text" class="form-control" value="<?php echo $result->Investor_pass;?>" disabled readonly />
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Status</label>
                    <select name="Status" id="" class="form-control">
                      <option value="1" <?php echo ($result->Status == 1)?'selected':'';?>>Active</option>
                      <option value="2" <?php echo ($result->Status == 2)?'selected':'';?>>Inactive</option>
                      <option value="0" <?php echo ($result->Status == 0)?'selected':'';?>>Pending Activate</option>
                      <option value="3" <?php echo ($result->Status == 3)?'selected':'';?>>Deleted</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Password</label>
                    <input type="text" name="userPassword" class="form-control" value="" id="passInput" />
                    <a href="javascript:void(0);" id="generatepassword">Generate Password</a>
                  </div>
                </div>
                <div class="col-md-3">                                
                  <div class="form-group">
                    <label for="cat_name">Confirm Password</label>
                    <input type="password" name="userPasswordconfirm" class="form-control" value="" id="passInput" />
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Update" />
                <a class="btn btn-primary btn-sm pull-right" style="margin-left:5px;" href="<?php echo base_url();?>administrator/verifications/verify-identity-proof/<?php echo $result->user_id?>?area=user" name="">Identity Proof</a>
                <a class="btn btn-primary btn-sm  pull-right" href="<?php echo base_url();?>administrator/verifications/verify-fund-proof/<?php echo $result->user_id?>?area=user">Fund Proof</a>
                <?php if ($getUncoverCount > 0) : ?>
                  <a class="btn btn-primary btn-sm pull-right" style="margin-right:5px;" href="<?php echo base_url();?>administrator/uncovered-listings-by-user/<?php echo $result->user_id?>">Uncovered Listings</a>
                <?php endif; ?>
              </div>
            </form>
          </div>
        </div>
      </div>    
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this identity?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Approve</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>