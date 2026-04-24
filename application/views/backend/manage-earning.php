<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'politician';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Manage Earning</li>
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
        <a style="float:right;" class="btn btn-primary btn-sm addyear" href="javascript: void(0);"><i class="fa fa-plus"></i> Add New Calendar Year </a>
      </div>
        <?php 

          // pre($getBookingLists);
        ?>
      <div class="card-body">
      <div class="box box-primary addyearpane" style="display:none">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddEarning" action="<?php echo base_url(); ?>administrator/approved-sell/earnings/add" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" name="recordId" value="<?php echo $req_id;?>" />
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">                                
                    <div class="form-group">
                      <label for="firstName">Calendar Year<span style="color:red;">*</span></label>
                      <select name="calendarYear" id="" class="form-control">
                        <?php
                        for($i = date('Y');$i>=(date('Y')-10);$i--)
                        {
                          ?>
                          <option value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php
                        }
                        ?>
                        
                      </select>
                    </div>
                  </div>
                    <div class="col-md-6">                                
                      <div class="form-group">
                        <label for="firstName">Status</label>
                        <select name="earningStatus" id="" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                    </div>
                    <?php
                    $Months= ['0'=>'January','1'=>'February','2'=>'March','3'=>'April','4'=>'May','5'=>'June','6'=>'July','7'=>'August','8'=>'September','9'=>'October','10'=>'November','11'=>'December'];
                    foreach($Months as $k=>$v)
                    {
                      ?>
                      <div class="col-md-1"> </div>
                      <div class="col-md-1">                                
                        <div class="form-group">
                          <label for="firstName"><?php echo $v?></label>
                        </div>
                      </div>
                      <div class="col-md-5">                                
                        <div class="form-group">
                        <input type="text" class="form-control" id="avgRevenue" name="avgRevenue[]" placeholder="Average Revenue" value="">
                        </div>
                      </div>
                      <div class="col-md-5">                                
                        <div class="form-group">
                          <input type="text" class="form-control" id="avgProfit" name="avgProfit[]" placeholder="Average Profit" value="">
                        </div>
                      </div>
                      <?php
                    }

                    ?>
                </div>
              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="add">
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <input type="button" class="btn btn-default canceladdyear" value="Cancel" />
                <p><span style="color:red;">*</span> fields are mandatory.</p>
              </div>
            </form>
          </div>
      
        <div class="table-responsive">
          <table class="table table-bordered gallerydragtable" id="galleryTable" width="100%" cellspacing="0" data-count="<?php echo $countAllBookings;?>">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Calendar Year</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="vlist">
          <?php
          if(is_array($earnings) && count($earnings)>0){
            $i=1;
            foreach($earnings as $val){
              if($val['status'] == '1'){
                $DisStatus = 'Active';
              }elseif($val['status'] == '0'){
                $DisStatus = 'Inactive';
              }

              ?>
              <form action="<?php echo base_url(); ?>administrator/site-settings/common-list-assets/add" method="post">
              <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" name="id" value="<?php echo $val['id']; ?>" />
              <input type="hidden" name="action" value="edit" />
              <tr id="<?php echo $val['id'];?>">
              <td><?php echo $i;?></td>
              <td><?php echo $val['year'];?></td>
              
              
              <td>
                  <?php echo $DisStatus?>
              </td>
              <td><button type="button" onclick="editrecord(this)" data-id="<?php echo $i-1?>"  class="btn btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                  
              <?php echo '<a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="'.base_url().'administrator/site-settings/common-list-assets/delete/'.$val['id'].'" class="btn-sm btn-danger deletepolitician"><i class="fa fa-trash" aria-hidden="true"></i></a>';?></td>
            </tr>
            </form>
            <div class="modal fade" id="editModal<?php echo $i-1?>" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title" id="deleteModalLabel">Edit Calendar Year</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-footer">
                  <form action="" method="post" id="delform">
                  <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                  <button type="submit" class="btn btn-primary">Delete</button>
                  </form>
                  <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
              </div>
            </div>
          </div>
              <?php
              $i++;
            }
          }else{
            ?>
            <tr>
            <td colspan="5">No Asset Found.</td>
            </tr>
            <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Calendar Year</th>
              <th>Status</th>
              <th>Action</th>
              </tr>
            </tfoot>
            <?php
            
            ?>
            <tbody>
              
            </tbody>
          </table>
        </div>
      </div>
      <!-- <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div> -->
    </div>
  <!-- /tables-->
  </div>
  <!-- /container-fluid-->
</div>





<div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this calendar year?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
