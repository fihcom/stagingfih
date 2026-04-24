<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Verify Identity Proof</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Verify Identity Proof</h2>
            <?php
            if($area == 'user')
            {
              ?>
              <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>users/edit/<?php echo $userId; ?>">Back to list</a>
              <?php
            }else{
              ?>
              <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/verifications/identity-proof">Back to list</a>
              <?php
            }
            ?>
            
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
              //print '<pre>';
              //print_r($result);
              ?>
                <br clear="all">
                <form action="<?php echo base_url()?>administrator/verifications/save-approve-identity/<?php echo $userId; ?>" method="post" id="saveapprovefrm">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                <input type="hidden" name="area" value="<?php echo $area;?>">
            <div class="row">
            
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Name</label>
                      <input type="text" class="form-control" value="<?php echo $result->fname ?>" id="site_title" name="site_title" readonly disabled>
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Date of Birth</label>
                      <input type="text" class="form-control" value="<?php echo $result->dob ?>" id="dob" name="dob">
                  </div>
                </div>
                <?php
                $IdentityJsonstr = $result->identity_proof_doc;
                $identityProofArr = json_decode($IdentityJsonstr,true);
                
                ?>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Identity Proof</label>
                      <input type="text" class="form-control" value="<?php echo $identityProofArr['identrity_proof'] ?>" id="identrity_proof" name="identrity_proof">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Identity Proof Number</label>
                      <input type="text" class="form-control" value="<?php echo $identityProofArr['identrity_proof_number'] ?>" id="identrity_proof_number" name="identrity_proof_number">
                  </div>
                </div>
                <div class="col-md-4">                                
                  <div class="form-group">
                      <label for="cat_name">Identity Proof Exp Date</label>
                      <input type="text" class="form-control" value="<?php echo $identityProofArr['identrity_proof_exp_date'] ?>" id="identrity_proof_exp_date" name="identrity_proof_exp_date">
                  </div>
                </div>
                </div>
            </form>
                <div class="row">
                <?php
                  if(is_array($identityProofArr['documents']) && count($identityProofArr['documents'])>0){
                ?>
                <div class="col-md-5">                                
                  <div class="form-group">
                      <!-- <label for="cat_name">Identity Documents</label> -->
                      <div class="header_box version_2">
                            <h2><i class="fa fa-file"></i><label for="cat_name">Identity Documents</label></h2> 
                      </div>
                      
                      <ul class="IdentityDocuments">
                      <?php
                                  $i = 1;
                                  foreach($identityProofArr['documents'] as $v)
                                  {
                                    ?>
                                    <li><a href="<?php echo base_url(); ?>uploads/proof_documents/<?php echo $v;?>" target="_blank"><?php echo $v;?></a></li>
                                    <?php
                                  }
                                  ?>
                                    
                      </ul>
                  </div>
                </div>
               <?php
                  }else{
                    ?>
                          <div class="col-md-12">
                              <form id="profilefundproof" action="<?php echo base_url() ?>administrator/submit-user-identityproof" class="dropzone">
                                  
                                  <input type="hidden" name="user_id" value="<?php echo $userId;?>">
															</form>
                          </div>
                    <?php
                  }
                  ?>     

            </div>
             

            <div class="box-footer">
              
              <?php
              if($editpermission)
              {
              if(is_array($identityProofArr))
              {
                ?>
                <input type="submit" name="button" class="btn btn-primary btn-sm" value="Approve" onclick="deleterecord(this)" datadeletehref="<?php echo base_url()?>administrator/verifications/approve-identity/<?php echo $userId; ?>" />
                <input type="submit" name="button" class="btn btn-danger btn-sm" value="Reject" onclick="rejectrecord(this)" datadeletehref="<?php echo base_url()?>administrator/verifications/reject-identity/<?php echo $userId; ?>" />
                <?php
              }else{
                ?>
                <input type="button" name="button" class="btn btn-primary btn-sm" value="Save & Approve" onclick="approverecord(this)" />
                <?php
              }
            }
              ?>
              
            </div>
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
        <input type="hidden" name="area" value="<?php echo $area;?>">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary btn-sm">Approve</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn btn-sm">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="approveModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this identity?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="button" class="btn btn-primary btn-sm" id="approvesaveidentity">Approve</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm">Cancel</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="rejectModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this identity?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="rejectform">
        <input type="hidden" name="area" value="<?php echo $area;?>">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-danger btn-sm">Reject</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn btn-sm">Cancel</button>
      </div>
    </div>
  </div>
</div>