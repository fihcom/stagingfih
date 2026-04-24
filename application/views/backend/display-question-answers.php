<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo base_url();?>administrator">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Approved Sell</li>
        <li class="breadcrumb-item active">Question and Answers</li>
      </ol>
      <div class="box_general padding_bottom site-setting-area">
      <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="header_box version_2">
            <h2><i class="fa fa-file"></i>Additional Info for #<?php echo $listingId?></h2>
            <a style="float:right;" class="btn btn-primary btn-sm addasset" href="<?php echo base_url(); ?>administrator/approved-sell">Back to list</a>
          </div><!-- /.box-header -->
          <!-- form start -->
          <div class="row">
                        
                        <?php
                            if(is_array($sellQArtr) && count($sellQArtr)>0)
                            {
                                foreach($sellQArtr as $k=>$v)
                                {
                                    //print '<pre>';
                                    //print_r($v);
                                    if(is_array($v['addedquestions']) && count($v['addedquestions'])>0)
                                    {
                                    ?>
                                    <div class="col-md-12"><h5><?php echo $v['cat_name']?></h5></div>
                                    <?php
                                        foreach($v['addedquestions'] as $val)
                                        {
                                            ?>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for=""><strong>Q.</strong> <?php echo $val['Question']?>?</label>
                                            <br>
                                            <strong>A.</strong> <?php
                                            
                                                
                                                if($val['Answer'] == 'text')
                                                {
                                                    echo $val['AnswerGiven'];
                                                }elseif($val['Answer'] == 'checkbox')
                                                {
                                                    if(is_array($val['AnswerOptions']) && count($val['AnswerOptions'])>0)
                                                    {
                                                        echo join(', ',$val['AnswerGiven']);
                                                    }
                                                }elseif($val['Answer'] == 'radio')
                                                {
                                                    echo $val['AnswerGiven'];
                                                }elseif($val['Answer'] == 'selectbox')
                                                {
                                                    echo $val['AnswerGiven'];
                                                }
                                            ?>
                                        </div>
                                    </div>
                                    <?php
                                        }
                                    }
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
