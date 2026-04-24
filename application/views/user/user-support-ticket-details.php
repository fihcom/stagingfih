<main class="mainContainer">   
		<section class="section my-account">
			<div class="container"> 
				<h2 class="heading text-center font-weight-bold">Ticket Details: #<?php echo $ticket[0]['ticket_no'];?></h2>  					
				<div class="d-block w-100">
					<div class="my-account-wrap mt30">
            <div class="btn_group text-right ticket_btnGroup">
              <a class="btn btn-primary btn-sm blue-btn addasset" href="<?php echo base_url(); ?>ticket/create">Back to list</a>
              <?php
                if($ticket[0]['status'] == 1)
                {
              ?>
                <a class="btn btn-warning btn-sm" href="javascript: void(0)" onclick="closeticket(this)">Close Ticket</a>
                  <?php
                }
              ?>
            </div>
  <?php 
              $error = $this->session->flashdata('error');
              if($error) {
                //print '<pre>';
                //print_r($error);
                ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $error['userreply']; ?>                    
                </div>
                <?php 
              } 

              $closesuccess = $this->session->flashdata('closesuccess');
              if($closesuccess) { 
                ?>
                <div class="alert alert-success alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $this->session->flashdata('closesuccess'); ?>
                </div>
                <?php 
              } 
              ?> 
                <form id="supportticketreply" action="<?php echo base_url()?>user/ticket/reply/<?php echo $ticket[0]['id'];?>" method="post">
            
            
            <div class="row">
                <?php
                //print '<pre>';
                //print_r($result);
                ?>
                <div class="col-md-12">
                    <table id="offlinebanks" class="table-design mt10 mb20">  
                      <thead>
                        <tr>
                          <th>User Name</th>
                          <th>Ticket Status</th>
                          <th>Ticket#</th>
                          <th>Subject</th>
                        </tr> 
                      </thead>
                      <tbody>
                        <tr>
                          <td><?php echo $ticket[0]['fname'];?></td>
                          <td><?php echo ($ticket[0]['status'] == 1) ? 'Open' : 'Closed';?></td>
                          <td><?php echo $ticket[0]['ticket_no'];?></td>
                          <td><?php echo $ticket[0]['subject'];?></td>
                        </tr>
                      </tbody>  
                    </table>  
                    <!-- <div class="row" id="offlinebanks">   
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label class="d-block">User Name</label>
                          <?php //echo $ticket[0]['fname'];?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Ticket Status</label><br>
                          <?php //echo ($ticket[0]['status'] == 1) ? 'Open' : 'Closed';?>
                          </div>
                      </div>
                      <div class="col-md-4">                       
                          <div class="form-group">
                          <label>Ticket#</label><br>
                          <?php //echo $ticket[0]['ticket_no'];?>
                          </div>
                      </div>
                      <div class="col-md-12">                       
                          <div class="form-group">
                          <label>Subject</label><br>
                          <?php //echo $ticket[0]['subject'];?>
                          </div>
                      </div>
                    </div> -->
                </div>
                <?php
                if(is_array($ticket) && count($ticket)>0)
                {
                  foreach($ticket as $val)
                  {
                    ?>
                  <div class="col-md-12 UserAdmin-reply">                                
                  <div class="UserAdmin-reply-box">
                    <label><?php echo $val['fname']?> says on <?php echo date('jS F Y h:i A',strtotime($val['date_added']))?></label>
                    <div class="UserAdmin-reply-para">
                      <i class="fa fa-commenting" aria-hidden="true"></i>
                      <?php echo $val['message'];?>
                    </div>
                  </div>
                </div>
                    <?php
                  }
                }
                ?>
                <?php 
              $error = $this->session->flashdata('error');
              if($error) {
                //print '<pre>';
                //print_r($error);
                ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <?php echo $error['userreply']; ?>                    
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
                <?php
            if($ticket[0]['status'] == 1)
            {
              ?>
                <div class="col-md-12">                                
                  <div class="form-group">
                  <label class="subhead mt10 mb-0">Reply Ticket</label>
                  <textarea name="userreply" id="" cols="30" rows="2" style="width:100%"></textarea>
                  </div>
                </div>
                <?php
            }
            ?>
			<?php
            if($ticket[0]['status'] == 1)
            {
              ?>
              <div class="col-sm-12"> <div class="btn_wr"><input type="submit" id="userreplyId" name="button" class="btn btn-primary" value="Reply" /></div></div>
              <?php
            }
            ?>
					</div> 
				</div>  
			</div>
			        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
              <input type="hidden" class="" name="ticketId" value="<?php echo $ticket[0]['ticket_no'];?>" />
            </form>
		</section>  
	</main> 
	<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to close this ticket?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form id="supportticketreply" action="<?php echo base_url()?>user/ticket/closeticket/<?php echo $ticket[0]['ticket_no'];?>" method="post">
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="votecsrf" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Close Ticket</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>