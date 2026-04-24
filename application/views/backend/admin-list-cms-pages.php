<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="<?php echo base_url();?>administrator">Dashboard</a>
      </li>
      <li class="breadcrumb-item active">CMS Pages</li>
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
        <i class="fa fa-table"></i> List CMS Pages
        <?php
        if($addpermission)
        {
          ?>
          <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>administrator/cms-pages/add"><i class="fa fa-plus"></i> Add New Page </a>
          <?php
        }
        ?>
        
      </div>
        <?php
          // pre($blogLists);
        ?>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
          <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Added / Modified Date</th>
              <th>Status</th>
              <th>Action</th>
          </tr>
          </thead>
            <tfoot>
              <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Added / Modified Date</th>
              <th>Status</th>
              <th>Action</th>
              </tr>
            </tfoot>
            <tbody>
              <?php
              //print_r($cat_lists);
              foreach($cmsList as $cList){
                ?>
              <tr id="blog-<?php echo base64_encode($cList['pageID']);?>">
                <td><?php echo $cList['pageID'];?></td>
                <td><?php echo $cList['pageTitle'];?></td>
                <td><?php echo $cList['pageSlug'];?></td>
                <td><?php echo ($cList['modifiedOn'] != "") ? date('Y-m-d H:i:s', strtotime($bList['modifiedOn'])) : date('Y-m-d H:i:s', strtotime($cList['addedOn']));?></td>
                      
                <td><?php echo ($cList['pageStatus'] == 1) ? "Active" : "Inactive";?></td>
                <td>
                <?php
                  if($editpermission)
                  {
                    ?>
                    <a class="btn btn-sm btn-info" href="<?php echo base_url().'administrator/cms-pages/edit/'.$cList['pageID']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                    <?php 
                  }if($deletepermission)
                  {
                    if($cList['pageSlug']!='home-page' && $cList['pageSlug']!='add-restaurant-owner')
                    {
                    ?>
                    <a class="btn btn-sm btn-danger deleteRow deleteCMS" href="javascript:void(0);" data-delete-href="<?php echo base_url().'administrator/cms-pages/delete/'.$cList['pageID']; ?>" data-type="cms" title="Delete"><i class="fa fa-trash"></i></a>
                    <?php 
                    }
                  }
                    ?>
                </td>
              </tr>
                <?php
              }
            ?>
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
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this page?</h4>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-primary" id="delete">Delete</a>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
     