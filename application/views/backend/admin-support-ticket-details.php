<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Ticket Details</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Ticket Details</h2>
            &nbsp;<a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/support-ticket">Back to list</a>
            <?php
            if($ticket[0]['status'] == 1 && $editpermission)
            {
              ?>
              <a style="float:right; margin-right:10px;" class="btn btn-warning btn-sm" href="javascript: void(0)" onclick="deleterecord(this)">Close Ticket</a>
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
                <form id="fundapprovefrm" action="<?php echo base_url()?>administrator/support/reply/<?php echo $ticket[0]['id'];?>" method="post">
            
            
            <div class="row">
                <?php
                //print '<pre>';
                //print_r($result);
                ?>
                <div class="col-md-12">  
                    <div class="row" id="offlinebanks">   
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>User Name</label><br>
                          <?php echo $ticket[0]['fname'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Ticket Status</label><br>
                          <?php echo ($ticket[0]['status'] == 1) ? 'Open' : 'Closed';?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Ticket#</label><br>
                          <?php echo $ticket[0]['ticket_no'];?>
                          </div>
                      </div>
                      <div class="col-md-12">                       
                          <div class="form-group">
                          <label>Subject</label><br>
                          <?php echo $ticket[0]['subject'];?>
                          </div>
                      </div>
                    </div>
                </div>
                <?php
                if(is_array($ticket) && count($ticket)>0)
                {
                  foreach($ticket as $val)
                  {
                    ?>
                    <div class="col-md-12">                                
                  <div class="form-group">
                  <label><?php echo $val['fname']?> says on <?php echo date('jS F Y h:i A',strtotime($val['date_added']))?></label><br>
                  <?php echo $val['message'];?>
                  </div>
                </div>
                    <?php
                  }
                }
                ?>
                
                <?php
            if($ticket[0]['status'] == 1 && $editpermission)
            {
              ?>
                <div class="col-md-12">                                
                  <div class="form-group">
                  <label>Reply Ticket</label>
                  <textarea name="adminreply" id="" cols="30" rows="2" style="width:100%"></textarea>
                  </div>
                </div>
                <?php
            }
            ?>
            </div>
             

            <div class="box-footer">
            <?php
            if($ticket[0]['status'] == 1 && $editpermission)
            {
              ?>
              <input type="submit" name="button" class="btn btn-primary" value="Reply" />
              <?php
            }
            ?>
            </div>
            <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            <input type="hidden" class="" name="ticketId" value="<?php echo $ticket[0]['ticket_no'];?>" />
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to close this ticket?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="<?php echo base_url()?>administrator/support/closeticket/<?php echo $ticket[0]['ticket_no'];?>" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary closeticket btn-sm">Close Ticket</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn btn-sm">Cancel</button>
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

