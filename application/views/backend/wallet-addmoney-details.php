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
            <h2><i class="fa fa-file"></i>Listing Wallet Transaction Details</h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/wallet-addmoney-request
            ">Back to list</a>
          </div><!-- /.box-header -->
          <!-- form start -->
          <?php
          if($result['section'] == 'WALLET')
          {
            $frmUrl = 'administrator/wallet-addmoney/approve/';
            $rejectUrl = 'administrator/wallet-addmoney/reject/';
          }elseif($result['section'] == 'WALLETWITHDRAW')
          {
            $frmUrl = 'administrator/wallet-withdrawmoney/approve/';
            $rejectUrl = 'administrator/wallet-withdrawmoney/reject/';
          }
          ?>
          
                <br clear="all">
                <form id="fundapprovefrm" action="<?php echo base_url().$frmUrl?><?php echo $result['id'];?>" method="post">
            
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
                          <label>Transaction ref#</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['transaction_ref'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Buy Date</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['buyDate'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <?php
                          if($result['section'] == 'WALLET')
                          {
                            $type = 'Topup';
                          }elseif($result['section'] == 'WALLETWITHDRAW')
                          {
                            $type = 'Withdraw';
                          }
                          ?>
                          <label>Transaction Type</label>
                          <input type="text" class="form-control" name="" value="<?php echo $type;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Amount</label>
                          <input type="text" class="form-control" name="" value="<?php echo $result['wallet_amount'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Pament Mode</label>
                          <?php
                          if($result['payment_mode'] == 'WIRETRANSFER')
                          {
                            $paymentMode = 'Wire Transfer';
                          }elseif($result['payment_mode'] == 'WALLET')
                          {
                            $paymentMode = 'Wallet';
                          }
                          ?>
                          <input type="text" class="form-control" name="" value="<?php echo $paymentMode;?>" id="" placeholder="" disabled>
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
                          <input type="text" class="form-control" name="" value="<?php echo $offerStatus;?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <?php
                      if($result['section'] == 'WALLETWITHDRAW')
                      {
                        ?><div class="col-md-8">                       
                          <div class="form-group">
                          <label>Wire transfer instructions</label>
                          
                          <input type="text" class="form-control" name="" value="<?php echo $result['description'];?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                        <?php
                      }
                      ?>
                      
                    </div>
                </div>
                
                      <?php
                      if($result['status'] == 2){
                        ?>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Purchase Approval Date</label>
                          
                          <input type="text" class="form-control" name="" value="<?php echo date('jS F Y',strtotime($result['sold_date']));?>" id="" placeholder="" disabled>
                          </div>
                      </div>
                      <?php
                      }
                      ?>
                
            </div>
             

            <div class="box-footer">
            <?php
            if($editpermission){
              if($result['status'] == 1){
                ?>
              <input type="button" name="button" class="btn btn-primary pull-right" style="margin-left: 10px;" value="Approve" onclick="deleterecord(this)" datadeletehref="" />
              <?php
              }
              if($result['status'] == 1)
              {
                ?>
                <input type="button" name="button" class="btn btn-danger pull-right" value="Reject" onclick="rejectrecord(this)" datadeletehref="<?php echo base_url().$rejectUrl?><?php echo $result['id'];?>" />
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
<?php
if($result['section'] == 'WALLET')
{
  ?>
<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this wallet add money Request?</h4>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this wallet add money Request?</h4>
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
<?php
}elseif($result['section'] == 'WALLETWITHDRAW')
{
  ?>
  <div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this wallet withdraw money Request?</h4>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this wallet withdraw money Request?</h4>
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
  <?php
}
?>