<?php 
  $blogCatName = '';
  $blogCatParent = '';
  $blogCatStatus = '';

  $headingText = 'Add Acquisition Lending';
  $formID = 'AddCat';
  $blogCatID = '';

  $action = 'add';

  if(isset($lendingdata)) {
    $action = 'edit';
    $headingText = 'Edit Acquisition Lending';
    $formID = 'EditCat';

    $blogCatID = $blogCatDetails['blogCatID'];
  }
?>

<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="blog-categories">Acquisition Lending</a>
      </li>
      <li class="breadcrumb-item active"><?php echo $headingText;?></li>
    </ol>
    <div class="box_general padding_bottom">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
        <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i><?php echo $headingText;?></h2>
              <a class="btn btn-primary btn-sm btn-md pull-right" href="<?php echo base_url(); ?>administrator/acquisition-lending-list"><i class="fa fa-level-up"></i> Back to list</a>
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
            <form role="form" id="AddEditAcquisitionLending" action="<?php echo base_url(); ?>administrator/add-acquisition/alter" method="post" role="form">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 cat-name">                                
                    <div class="form-group">
                      <label for="blogCatName">Industry </label>
                      
                      <input type="text" name="Industry" id="Industry" class="form-control" value="<?php echo $lendingdata['industry'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Business Age</label>
                      <input type="text" name="BusinessAge" id="BusinessAge" class="form-control" value="<?php echo $lendingdata['business_age'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Revenue</label>
                      <input type="text" name="Revenue" id="Revenue" class="form-control" value="<?php echo $lendingdata['revenue'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Net Profit</label>
                      <input type="text" name="NetProfit" id="NetProfit" class="form-control" value="<?php echo $lendingdata['net_profit'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Funding Amount</label>
                      <input type="text" name="FundingAmount" id="FundingAmount" class="form-control" value="<?php echo $lendingdata['funding_amount'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">EBITDA (%)</label>
                      <input type="text" name="EBITDA" id="EBITDA" class="form-control" value="<?php echo $lendingdata['ebitda'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Loan Type</label>
                      <input type="text" name="LoanType" id="LoanType" class="form-control" value="<?php echo $lendingdata['loan_type'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Loan Term</label>
                      <input type="text" name="LoanTerm" id="LoanTerm" class="form-control" value="<?php echo $lendingdata['loan_term'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Interest Yield (%)</label>
                      <input type="text" name="InterestYield" id="InterestYield" class="form-control" value="<?php echo $lendingdata['interest_yield'];?>">
                    </div>
                  </div>
                  <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Acquirer Contribution</label>
                      <input type="text" name="AcquirerContribution" id="AcquirerContribution" class="form-control" value="<?php echo $lendingdata['acquirer_contribution'];?>">
                    </div>
                  </div>
                  <!-- <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Funding Opportunity</label>
                      <input type="text" name="FundingOpportunity" id="FundingOpportunity" class="form-control" value="<?php echo $lendingdata['funding_opportunity'];?>">
                    </div>
                  </div>   -->
                   <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Business Listing URL</label>
                      <input type="text" name="BusinessListingURL" id="BusinessListingURL" class="form-control" value="<?php echo $lendingdata['business_listing_url'];?>">
                    </div>
                  </div>  
                    <div class="col-md-6 package-name">                                
                    <div class="form-group">
                      <label for="package_name">Status</label>
                      <select name="status" id="" class="form-control">
                        <option value="1" <?php echo ($lendingdata['status'] == 1)?'selected':'';?>>Active</option>
                        <option value="2" <?php echo ($lendingdata['status'] == 2)?'selected':'';?>>Inactive</option>
                      </select>
                    </div>
                  </div> 

                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                <?php if($lendingdata['id'] != '') { ?>
                <input type="hidden" name="LendingId" value="<?php echo $lendingdata['id'];?>">
                <?php } ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <input type="button" onclick="location.href='<?php echo base_url(); ?>administrator/acquisition-lending-list'" class="btn btn-default" value="Cancel" />
                
              </div>
            </form>
          </div>
        </div>
      </div>    
    </div>
  </div>
</div>