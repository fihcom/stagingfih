<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">FAQ Details</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>FAQ Details</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/faqs">Back to list</a>
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
                <form id="fundapprovefrm" action="<?php echo base_url()?>administrator/faq/approve/<?php echo $result->id;?>" method="post">
            
            
            <div class="row">
                <?php
                //print '<pre>';
                //print_r($result);
                ?>
                <div class="col-md-12">  
                    <div class="row" id="offlinebanks">   
                      <div class="col-md-6">                       
                          <div class="form-group">
                          <label>Buyer Name</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result->buyername;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                            <label>Seller Name</label>
                            <input type="text" class="form-control" name="" value="<?php echo $result->sellername;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                            <label>Buyer Email</label>
                            <input type="text" class="form-control" name="" value="<?php echo $result->buyeremail;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                            <label>Seller Email</label>
                            <input type="text" class="form-control" name="" value="<?php echo $result->selleremail;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                            <label>Listing #</label>
                            <input type="text" class="form-control" name="" value="<?php echo $result->listing_id;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                    </div>
                </div>
                
                <div class="col-md-6">                                
                  <div class="form-group">
                  <label>Question</label>
                  <textarea name="question" id="" cols="30" rows="10" style="width:100%"><?php echo $result->question;?></textarea>
                  </div>
                </div>
                <div class="col-md-6">                                
                  <div class="form-group">
                  <label>Seller Reply</label>
                  <textarea name="reply" id="" cols="30" rows="10" style="width:100%"><?php echo $result->seller_reply;?></textarea>
                  </div>
                </div>
     

            </div>
             

            <div class="box-footer">

            <?php 
            if($deletepermission)
            {
              if($result->Status == 3){
              ?>
              <input type="button" name="button" class="btn btn-primary" value="Approve" onclick="deleterecord(this)" datadeletehref="" />
              <?php
              }elseif($result->Status == 2){
                ?>
                <input type="button" name="button" class="btn btn-danger" value="Remove" onclick="rejectrecord(this)" datadeletehref="<?php echo base_url()?>administrator/faq/reject/<?php echo $result->id;?>" />
                <?php
              }
            }
            
            ?>  
              
            </div>
            <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this FAQ?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="button" class="btn btn-primary approvebtn">Approve</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rejectModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to remove this FAQ?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="rejectform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-danger">Reject</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>