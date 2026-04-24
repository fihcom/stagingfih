<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Commissions</li>
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
        
      </div>
      <div class="card-body">
      <div class="row">
          <div class="col-md-12"> 
          <form role="form" id="editBlogCat" action="<?php echo base_url(); ?>administrator/listing-commissions" method="post" role="form"> 
          <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <div class="row">
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-12"><label for="searchName">Search:</label></div>
                  <div class="col-md-12"><input type="text" class="form-control" value="<?php echo $searchName?>" id="Search" name="searchName"></div>
                </div>
            </div>
            <div class="col-md-5">
              <div class="row">
              <?php
              if($dateFrom == '')
              {
                //$dateFrom = date('Y-m-').'01';
                $q = 'Select DATE_SUB( NOW() , INTERVAL 6 MONTH ) as fromDate';
                $query = $this->db->query($q);  
                $dateDetails = $query->row();
                $dateFrom = date('Y-m-d',strtotime($dateDetails->fromDate));
              }
              ?>
                <div class="col-md-12"><label for="searchName">Date:</label></div>
                <div class="col-md-6"><input type="date" class="form-control" value="<?php echo $dateFrom?>" id="" name="dateFrom"></div>
                <?php
              if($dateTo == '')
              {
                $dateTo = date('Y-m-d');
              }
              ?>
                <div class="col-md-6"><input type="date" class="form-control" value="<?php echo $dateTo?>" id="" name="dateTo"></div>
              </div>
            </div>
            <div class="col-md-3">
            <div class="row">
                <div class="col-md-12"><label for="searchName"><label for="offerStatus">Amount Transfer Status: &nbsp;</label></label></div>
                <div class="col-md-12">
                <select class="mdb-select colorful-select dropdown-primary form-control" searchable="Search here.." name="buyStatus" id="">
                <option value="">All</option>
                <option value="1" <?php echo ($buyStatus == '1')? 'selected':'';?>>Paid</option>
                <option value="0" <?php echo ($buyStatus == '0')? 'selected':'';?>>Unpaid</option>
								</select>
                </div>
              </div>
            </div>
            <div class="col-md-1">
              <div class="row">
                <div class="col-md-12">&nbsp;</div>
                <div class="col-md-12"><input style="margin-top: 20px;" type="submit" value="Search" class="btn btn-primary btn-sm"></div>
              </div>
            </div>

          </div> 
          </form>    
          <hr>                         
             
        </div>
        </div>

        
        <div class="table-responsive">
          <div class="row">
          <div class="col-md-5"> 
              <div class="card">
                <div class="card-header">
                <i class="fa fa-bar-chart"></i> Total Report for the period
                </div>
                <div class="card-body">
                
                  <div class="row">
                    <div class="col-md-12">
                    <h6>Sales Commission</h6><hr style="margin: 10px 0 10px 0 !important">
                    </div>
                    <div class="col-md-8">
                      Total Sales
                    </div>

                    <div class="col-md-4">
                      
                      <?php echo $currency.$totalSale;?>
                    </div>
                    <div class="col-md-8">
                      Total Commission Earned
                    </div>
                    <div class="col-md-4">
                      <?php echo $currency.$totalCommission;?>
                    </div>
                    <div class="col-md-8">
                      Total Amount to transfer
                    </div>
                    <div class="col-md-4">
                      <?php echo $currency.$totalAmounttoTransfer;?>
                    </div>
                    <div class="col-md-12" style="margin: 20px 0 0 0 !important">
                    <h6>Collection from Business application</h6><hr style="margin: 10px 0 10px 0 !important">
                    </div>
                    <div class="col-md-8">
                      Collection for the period <br>(Pending/Approved application)
                    </div>
                    <div class="col-md-4">
                      <?php echo $currency.$totalcollectionapplication;?>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          </div>
          
          <br>
          <table class="table table-bordered" id="" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th>Payment Ref #</th>
              <th>Seller Email</th>
              <th>Listing#</th>
              <th>Buy Date</th>
              <th>Sell Price</th>
              <th>Commission</th>
              <th>Transfer Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php
          if(is_array($result) && count($result)>0)
          {
            
            foreach($result as $val)
            {
              ?>
              <tr>
              <td><?php echo $val['transaction_ref'];?></td>
              <td><?php echo $val['selleremail'];?></td>
              <td><?php echo $val['listing_id'];?></td>
              <td><?php echo $val['buyDate'];?></td>
              <td><?php echo $currency.$val['price'];?></td>
              <td><?php echo $currency.$val['commissionAmount'];?></td>
              <td><?php echo $currency.$val['transferAmount'];?></td>
              <td>
              <?php
              if($val['buy_amt_stranfer_status'] == 1)
              {
                echo $val['amtTransferststus'];
              }elseif($val['buy_amt_stranfer_status'] == 0 && $editpermission){
                ?>
                <input type="button" onclick="deleterecord(this)" datadeletehref="<?php echo base_url()?>administrator/listing-commissions/approve/<?php echo $val['id'];?>" value="<?php echo $val['amtTransferststus'];?>" class="btn btn-primary btn-sm">
                <?php
              }elseif($val['buy_amt_stranfer_status'] == 0 && !$editpermission){
                echo $val['amtTransferststus'];
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
            <td colspan="8" style="text-align:center">No record found.</td>
            </tr>
            <?php
          }
          ?>
          </tbody>
          <tfoot>
          <tr>
              <th>Payment Ref #</th>
              <th>Seller Email</th>
              <th>Listing#</th>
              <th>Buy Date</th>
              <th>Sell Price</th>
              <th>Commission</th>
              <th>Transfer Amount</th>
              <th>Status</th>
            </tr>
            </tfoot>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to mark this payment as paid?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Yes</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



