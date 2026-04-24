<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Listing Buy Details</li>
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
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Listing Buy Details</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/listing-buy-request">Back to list</a>
          </div><!-- /.box-header -->
          <!-- form start -->
          
                <br clear="all">
                <form id="fundapprovefrm" action="<?php echo base_url()?>administrator/buy-request/approve/<?php echo $result['id'];?>" method="post">
            
            <div class="row">
                <div class="col-md-12">  
                    <div class="row" id="offlinebanks">   
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Buyer Name</label>
                          <br>
                          <?php echo $result['buyername'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Transaction ref#</label>
                          <br>
                          <?php echo $result['transaction_ref'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Buy Date</label>
                          <br>
                          <?php echo $result['buyDate'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Listing#</label>
                          <br>
                          <?php echo $result['listing_id'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Seller Name</label>
                          <br>
                          <?php echo $result['sellername'];?>
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
                            $offerStatus = 'Sold';
                          }elseif($result['status'] == 3)
                          {
                            $offerStatus = 'Rejected';
                          }
                          ?>
                          <br>
                          <?php echo $offerStatus;?>
                          </div>
                      </div>
                    </div>
                </div>
                
                
                <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Listing Price</label>
                          <br>
                          <?php echo $currency[0]['symbol'].$listing->price;?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Payment Mode</label>
                          <?php
                          if($result['payment_mode'] == 'WALLET')
                          {
                            $mode = 'Wallet';
                          }elseif($result['payment_mode'] == 'WIRETRANSFER')
                          {
                            $mode = 'Wire Transfer';
                          }elseif($result['payment_mode'] == 'BOTH')
                          {
                            $paymentDetails = $result['payment_details'];
                            $paymentDetailsArr = json_decode($paymentDetails,true);
                            $mode = 'Wire Transfer $'.$paymentDetailsArr['wiretransfer'].' + Wallet $'.$paymentDetailsArr['wallet'];
                          }
                          ?>
                          <br>
                          <?php echo $mode;?>
                          </div>
                      </div>
                      <?php
                      if($result['status'] == 2){
                        ?>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Purchase Approval Date</label>
                          <br>
                          <?php echo date('jS F Y',strtotime($result['sold_date']));?>
                          </div>
                      </div>
                      <?php
                      }
                      ?>
                <?php
                  $images = json_decode($result['images'],true);
                  if(is_array($images) && count($images)>0)
                  {
                  ?>
                <div class="col-md-12">                                
                  <div class="form-group">
                  <label>Uploaded Documents</label>
                    <ul>
                    <?php 
                    foreach($images as $val)
                    {
                      ?>
                      <li><a href="<?php echo base_url()?>uploads/buy_documents/<?php echo $val?>" target="_blank"><?php echo $val?></a></li>
                      <?php
                    }
                    ?>
                    </ul>
                  </div>
                </div>
                <?php
                  }
                  if($offers->id>0)
                  {
                  ?>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2><i class="fa fa-file"></i>Approved Offer</h2>
                    </div>
                  </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Offer price</label>
                          <br>
                          <?php echo $currency[0]['symbol'].$offers->offer_price;?>
                          </div>
                      </div>
                      <!--<div class="col-md-8">                       
                          <div class="form-group">
                          <label>Description</label>
                          <input type="text" class="form-control" name="" value="<?php //echo $offers->offer_description;?>" id="" placeholder="" disabled>
                          </div>
                      </div>-->
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Offer Date</label>
                          <br>
                          <?php echo date('jS F Y',strtotime($offers->offer_date));?>
                          </div>
                      </div>

                    <?php
                  }
                  ?>
                  <div class="col-md-12"> 
                    <div class="header_box version_2">
                      <h2><i class="fa fa-file"></i>Commission Details</h2>
                    </div>
                  </div>
                  <br clear="all">
                  <div class="col-md-4">                       
                      <div class="form-group">
                      <label>Total Commisstion</label>
                      <br>
                      <?php echo $currency[0]['symbol'].$commissionAmount;?>
                      </div>
                  </div>
                  <div class="col-md-4">                       
                      <div class="form-group">
                      <label>Net Proceeds</label>
                      <br>
                      <?php echo $currency[0]['symbol'].$transferAmount;?>
                      </div>
                  </div>
                  <div class="col-md-4">                       
                      <div class="form-group">
                      <label>Transfer Status</label>
                      <br>
                      <?php echo $amtTransferststus;?>
                      </div>
                  </div>
                  <?php
                  if($result['status'] == 2)
                  {
                  ?>
                  <div class="col-md-12"> 
                  <div class="header_box version_2">
                    <h2><i class="fa fa-file"></i>Transfer of Business</h2>
                  </div>
                  </div>
                      <div class="col-md-2">                       
                          <div class="form-group">
                          <label>Transfer Status</label>
                          
                          <select name="" id="TransferStatus" class="form-control">
                          <option value="1" <?php echo ($result['transfer_status'] == 1) ? 'selected': '';?>>Unpaid</option>
                          <option value="2" <?php echo ($result['transfer_status'] == 2) ? 'selected': '';?>>Funds Received</option>
                          <option value="3" <?php echo ($result['transfer_status'] == 3) ? 'selected': '';?>>Transfer Pending</option>
                          <option value="4" <?php echo ($result['transfer_status'] == 4) ? 'selected': '';?>>Completed</option>
                          </select>
                          </div>
                      </div>
                      <div class="col-md-2">                       
                          <div class="form-group">
                          <label>&nbsp;</label>
                          <input type="button" name="button" class="btn btn-info" value="Update Transfer Status" onclick="updatetransferstatus(this)" datadeletehref="<?php echo base_url()?>administrator/buy-request/updatetransfer/<?php echo $result['id'];?>" />
                          </div>
                      </div>
                    <?php
                  }
                  ?>
            </div>
             

            <div class="box-footer">
            <?php
            if($editpermission){
            if($result['status'] == 1 || $result['status'] == 3){
              ?>
            <input type="button" name="button" class="btn btn-primary pull-right btn-sm" style="margin-left: 10px;" value="Approve" onclick="deleterecord(this)" datadeletehref="" />
            <?php
            }
            if($result['status'] == 1 || $result['status'] == 2)
            {
              ?>
              <input type="button" name="button" class="btn btn-danger pull-right btn-sm" value="Reject" onclick="rejectrecord(this)" datadeletehref="<?php echo base_url()?>administrator/buy-request/reject/<?php echo $result['id'];?>" />
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
</div>
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this Buy Request?</h4>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this Buy Request?</h4>
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
<div class="modal fade" id="updatestatusModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to update the transfer status this Buy?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="updateform">
        <input type="hidden" name="transferStatus" id="buytransferstatus" value="">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-success">Update</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>