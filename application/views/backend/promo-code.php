<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url().'administrator';?>">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">Promo Code</li>
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
        <?php
            if($addpermission)
            {
              ?>
        <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url() ?>administrator/promo-code/add"><i class="fa fa-plus"></i> Add New Promo Code </a>
        <?php
            }
            ?>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="" width="100%" cellspacing="0" data-count="">
          <thead>
            <tr>
              <th>Sl No.</th>
              <th>Code</th>
              <th>Discount Type</th>
              <th>Amount</th>
              <th>Validity</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $i=1;
          if(is_array($result) && count($result)>0)
          {
            foreach($result as $val)
            {
            ?>
            <tr id="<?php echo $val['id']?>">
            <td><?php echo $i;?></td>
            <td><?php echo $val['promocode']?></td>
            <td><?php 
              if($val['discount_type'] == 'Percentage')
              {
                echo 'Percent';
              }elseif($val['discount_type'] == 'Amount')
              {
                echo 'Amount';
              }
            ?></td>
            <td><?php 
            if($val['discount_type'] == 'Percentage')
            {
              echo $val['discount'].'%';
            }elseif($val['discount_type'] == 'Amount')
            {
              echo $currency.$val['discount'];
            }
            ?></td>
            <td><?php 
            if($val['validity'] == 'LifeTime')
            {
              echo 'Life Time';
            }elseif($val['validity'] == 'DateRange')
            {
              echo date('dS M y', strtotime($val['date_from'])).' - '.date('dS M y', strtotime($val['date_to']));
            }
            ?></td>
            <td>
            <?php
            if($editpermission)
            {
              ?>
              <a href="<?php echo base_url()?>administrator/promo-code/edit/<?php echo $val['id'];?>" class="btn-sm btn-primary editrec"><i class="fa fa-pencil" aria-hidden="true"></i></a>
              <?php
            }
            ?>
            &nbsp;
            <?php
            if($deletepermission)
            {
              ?>
            <a href="javascript: void(0)" onclick="deleterecord(this)" datadeletehref="<?php echo base_url()?>administrator/promo-code/delete/<?php echo $val['id'];?>" class="btn-sm btn-danger deleterec"><i class="fa fa-trash" aria-hidden="true"></i></a>
            <?php
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
            <td colspan="7"style="text-align: center;">No record found.</td>
            </tr>
            
            <?php
          }
          ?>
          </tbody>
          <tfoot>
            <tr>
            <th>Sl No.</th>
              <th>Code</th>
              <th>Discount Type</th>
              <th>Amount</th>
              <th>Validity</th>
              <th>Action</th>
            </tr>
            </tfoot>
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


<div class="modal fade" id="deleteModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this promo code?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="delform">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="submit" class="btn btn-primary">Delete</button>
        </form>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>



