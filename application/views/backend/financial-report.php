<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Financial Reports</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Financial Report</h2>
            
          </div><!-- /.box-header -->
          <!-- form start -->
          
                <br clear="all">
                
            
            <div class="row">
                <div class="col-md-12">  
                    <div class="row" id="offlinebanks">   
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Buyer Name</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['buyername'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Offer Price</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['offer_price'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Offer Date</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['offerDate'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Listing#</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['listing_id'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Seller Name</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['sellername'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Status</label>
                          <?php
                          if($result['status'] == 1)
                          {
                            $offerStatus = 'Pending';
                          }elseif($result['status'] == 2)
                          {
                            $offerStatus = 'Approved';
                          }
                          ?>
                          <input type="text" class="form-control" name="" value="<?php echo $offerStatus;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                    </div>
                </div>
                
                <!--<div class="col-md-12">                                
                  <div class="form-group">
                  <label>Description</label>
                  <textarea name="question" id="" cols="30" rows="5" style="width:100%" disabled><?php echo $result['offer_description'];?></textarea>
                  </div>
                </div>-->
                
     

            </div>
             

            <div class="box-footer">
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this FAQ?</h4>
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