<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Verify Fund Proof</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Verify Fund Proof</h2>
            <?php
            if($area == 'user')
            {
              ?>
              <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/users/edit/<?php echo $userId?>">Back to list</a>
              <?php
            }else{
              ?>
              <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/verifications/fund-proof">Back to list</a>
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
              ?>
                <br clear="all">
                <form id="fundapprovefrm" action="<?php echo base_url()?>administrator/verifications/approve-fund/<?php echo $userId; ?>" method="post">
                <input type="hidden" name="area" value="<?php echo $area?>">
            <div class="row">
                
                <?php
                $FundJsonstr = $result->proof_funds;
                $fundProofArr = json_decode($FundJsonstr,true);
                //print '<pre>';
                //print_r($fundProofArr);
                if($fundProofArr['mode'] == 'offline')
                  {

                  
                  if(is_array($fundProofArr['documentproof']) && count($fundProofArr['documentproof'])>0){
                ?>
                <div class="col-md-5">                                
                  <div class="form-group">
                      <label for="cat_name" class="admin-subhead">Documents Attached</label> 
                      <ul class="listnone">
                      <?php
                                  $i = 1;
                                  foreach($fundProofArr['documentproof'] as $v)
                                  {
                                    ?>
                                    <li><?php echo $v;?></li>
                                    <?php
                                  }
                                  ?>
                                    
                      </ul>
                  </div>
                </div>
               <?php
                  }
               
                  ?>     

            </div>
            
            <div class="row">
                
                <?php
                
                  if(is_array($fundProofArr['documents']) && count($fundProofArr['documents'])>0){
                ?>
                <div class="col-md-5">                                
                  <div class="form-group">
                      
                      <div class="header_box version_2">
                            <h2><i class="fa fa-file"></i><label for="cat_name">Documents</label></h2> 
                      </div>
                      <ul class="IdentityDocuments">
                      <?php
                                  $i = 1;
                                  foreach($fundProofArr['documents'] as $v)
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
                  }
                  ?>
                <div class="col-md-12">  
                <?php
                $offlineFund = $offlinefundsummery->fund_details;
                $offlineFundArr = json_decode($offlineFund,true);
                //print '<pre>';
                //print_r($offlineFundArr);
                ?> 
                    <div class="row" id="offlinebanks">   
                      <div class="col-md-6">                       
                          <div class="form-group">
                          <label>Bank</label>
                          <input type="text" class="form-control" name="banks[]" value="<?php echo $offlineFundArr[0]['bank']?>" id="" placeholder="Bank Name">
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                          <label>Available Balance</label>
                          <input type="text" class="form-control" name="availableBal[]" placeholder="Available Balance" value="<?php echo $offlineFundArr[0]['balance']?>" id="">
                          </div>
                      </div>
                      <?php 
                      for($i=1; $i<count($offlineFundArr); $i++)
                      {
                        ?>
                        <div class="col-md-6">                       
                          <div class="form-group">
                          <input type="text" class="form-control" name="banks[]" value="<?php echo $offlineFundArr[$i]['bank']?>" id="" placeholder="Bank Name">
                          </div>
                      </div>
                      <div class="col-md-6">                       
                          <div class="form-group">
                          <input type="text" class="form-control" name="availableBal[]" placeholder="Available Balance" value="<?php echo $offlineFundArr[$i]['balance']?>" id="">
                          </div>
                      </div>
                        <?php
                      }
                      ?>
                    </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                        <button type="button" class="btn btn-primary  btn-sm" id="addbank">Add more bank</button>
                  </div>
                </div>
                <div class="col-md-12">                                
                  <div class="form-group">
                  <label>Total Asset</label>
                  <input type="text" class="form-control" name="totalAsset" value="<?php echo $result->fund_approved_amount?>" id="">
                  </div>
                </div>

               <?php
                  
                }elseif($fundProofArr['mode'] == 'online'){
                  //print '<pre>';
                  //print_r($bankBal);
                  $totalAsset = 0;
                  if(is_array($bankBal) && count($bankBal)>0)
                  {
                    foreach($bankBal as $k=>$vBank)
                    {
                      $bankItems = $vBank['report']['items'];

                      if(is_array($bankItems) && count($bankItems)>0)
                      {
                        foreach($bankItems as $k=>$v)
                        {
                          $totalFortheBank = 0;
                          ?>
                          <div class="col-md-12">                                
                            <div class="form-group">
                            <h6><?php echo $v['institution_name'];?></h6>
                            </div>
                            </div>
                            <?php
                            if(is_array($v['accounts']) && count($v['accounts'])>0)
                            {

                              foreach($v['accounts'] as $bankAcct)
                              {
                                $AvailableBal = $bankAcct['balances']['available'];
                                if($bankAcct['balances']['available'])
                                {
                                  $totalFortheBank = $totalFortheBank+$bankAcct['balances']['available'];
                                  
                                ?>
                                <div class="col-md-3">                                
                                <div class="form-group">
                                <label><?php echo $bankAcct['name']; ?></label>
                                <input type="text" class="form-control" value="<?php echo $bankAcct['balances']['available']?>" id="website_url" readonly disabled>
                                </div>
                                </div>
                                <?php
                                }
                              }
                              $totalAsset = $totalAsset+$totalFortheBank;
                              ?>
                              <div class="col-md-6">                                
                                <div class="form-group">
                                <label>Total For the Bank</label>
                                <input type="text" class="form-control" value="<?php echo $totalFortheBank?>" id="">
                                </div>
                                </div>
                              <?php
                            }
                            ?>
                            
                          <?php
                          //print '<pre>';
                          //print_r($v);
                        }
                        
                      }
                      
                    }
                    ?>
                        <div class="col-md-12">                                
                                <div class="form-group">
                                <label>Total Asset</label>
                                <input type="text" class="form-control" name="totalAsset" value="<?php echo $result->fund_approved_amount?>" id="">
                                </div>
                                </div>
                        <?php
                  }
                }
                  ?>     

            </div>
            <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            </form> 

            <?php
            if($fundProofArr['mode'] == ''){
              ?>
                <form id="proofoffundformadmin" action="<?php echo base_url();?>administrator/proofoffundaction" method="post">
                <input type="hidden" name="user_id" value="<?php echo $userId?>">
                <input type="hidden" name="area" value="<?php echo $area?>">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
												<p>Upload your proof of funds, and once our team has verified your financials, we will issue you a VIP Code to easily unlock listings.</p>
												<h3 class="subheading">You can upload:</h3>
												<ul class="row ul">
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Bank Statement" <?php echo (in_array('Bank Statement',$dataval['proof']))?'checked':'';?>> Bank Statement</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Stock Portfolio" <?php echo (in_array('Stock Portfolio',$dataval['proof']))?'checked':'';?>> Stock Portfolio</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="CPA Letter" <?php echo (in_array('CPA Letter',$dataval['proof']))?'checked':'';?>> CPA Letter</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Home Equity Line of Credit" <?php echo (in_array('Home Equity Line of Credit',$dataval['proof']))?'checked':'';?>> Home Equity Line of Credit</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Corporation Documents" <?php echo (in_array('Corporation Documents',$dataval['proof']))?'checked':'';?>> Corporation Documents</li>
													<li class="col-md-3 col-sm-6"><input type="checkbox" name="proof[]" id="" value="Other Available Credit Status" <?php echo (in_array('Other Available Credit Status',$dataval['proof']))?'checked':'';?>> Other Available Credit Status</li>

                          
                          <li class="col-md-12">
                          <div class="row" id="offlinebanks">   
                          <div class="col-md-6">                       
                              <div class="form-group">
                              <label>Bank</label>
                              <input type="text" class="form-control" name="banks[]" value="<?php echo $offlineFundArr[0]['bank']?>" id="" placeholder="Bank Name">
                              </div>
                          </div>
                          <div class="col-md-6">                       
                              <div class="form-group">
                              <label>Available Balance</label>
                              <input type="text" class="form-control" name="availableBal[]" placeholder="Available Balance" value="<?php echo $offlineFundArr[0]['balance']?>" id="">
                              </div>
                          </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                                  <button type="button" class="btn btn-primary  btn-sm" id="addbank">Add more bank</button>
                            </div>
                          </div>
                      </li>
                      <li class="col-md-12">
                          <div class="form-group">
                              <label for="cat_name">Total Asset</label>
                              
                              <input type="text" class="form-control" name="totalAsset" value="">
                          </div>
													</li>
												</ul>
                        </form>
                  <ul class="row ul mt30">
													<li class="col-md-12">
														<div class="box">
															<div class="subhead">Files</div>
															<form id="profilefundproof" action="<?php echo base_url() ?>administrator/submit-user-fundproof" class="dropzone">
                                <input type="hidden" name="user_id" value="<?php echo $userId?>">
															</form>
														</div>
													</li>
                          
												</ul> 
                        
                  <?php
            }
            ?>

            <div class="box-footer">
            <?php
            if($editpermission)
            {
            if($fundProofArr['mode'] != ''){
              ?>
              <input type="button" name="button" class="btn btn-primary" value="Approve" onclick="deleterecord(this)" datadeletehref="" />
              <input type="button" name="button" class="btn btn-danger" value="Reject" onclick="rejectrecord(this)" datadeletehref="<?php echo base_url()?>administrator/verifications/reject-fund/<?php echo $userId; ?>" />
              <?php
            }else{
              ?>
              <input type="button" name="button" class="btn btn-primary" value="Approve" onclick="approvefund(this)" datadeletehref="" />
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this fund?</h4>
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
<div class="modal fade" id="approvefundModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to approve this fund?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
      
        <button type="button" class="btn btn-primary approveadmin">Approve</button>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="rejectModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to reject this fund proof?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="rejectform">
        <input type="hidden" name="area" value="<?php echo $area?>">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-danger">Reject</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>