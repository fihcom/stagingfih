<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo ADMIN_PATH;?>">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Blog Categories</li>
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
          <i class="fa fa-table"></i> List Blog Categories
          <?php
          if($addpermission)
          {
            ?>
            <a style="float:right;" class="btn btn-primary btn-sm" href="<?php echo base_url(); ?>administrator/add-blog-categories"><i class="fa fa-plus"></i> Add New Blog Category</a>
            <?php
          }
          ?>
        </div>
          
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Added / Modified Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
              <tfoot>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Added / Modified Date</th>
                <th>Status</th>
                <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                    <?php 
                    //print_r($cat_lists);
                    if(is_array($blog_cat_lists) && count($blog_cat_lists)>0)
                    {
                      
                    foreach($blog_cat_lists as $cList){
                        ?>
                        <tr id="category-<?php echo base64_encode($cList['blogCatID']);?>">
                        <td><?php echo $cList['blogCatID'];?></td>
                        <td><?php echo $cList['blogCatName'];?></td>
                        <td><?php echo $cList['blogCatSlug'];?></td>
                        <td><?php echo ($cList['modifiedOn'] != "") ? date('Y-m-d H:i:s', strtotime($cList['modifiedOn'])) : date('Y-m-d H:i:s', strtotime($cList['addedOn']));?></td>
                        
                        <td><?php echo ($cList['blogCatStatus'] == 1) ? "Active" : "Inactive";?></td>
                        <td>
                        <?php
                        if($editpermission)
                        {
                          ?>
                          <a class="btn btn-sm btn-info" href="<?php echo base_url().'administrator/edit-blog-category/'.$cList['blogCatID']; ?>" title="Edit"><i class="fa fa-pencil"></i></a>
                          <?php
                        }if($deletepermission)
                        {
                          ?>
                          <a class="btn btn-sm btn-danger deleteRow" href="javascript:void(0);" data-delete-href="<?php echo base_url().'administrator/delete-blog-category/'.$cList['blogCatID']; ?>" data-catid="<?php echo $cList['blogCatID']; ?>" title="Delete"><i class="fa fa-trash"></i></a>
                          <?php
                        }
                        ?>
                            
                            
                        </td>
                        </tr>
                        <?php
                    }
                  }else{
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">No record found.</td>
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
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to delete this category?</h4>
      </div>
      <div class="modal-footer">
        <a href="javascript:void(0);" class="btn btn-primary" id="delete">Delete</a>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
       