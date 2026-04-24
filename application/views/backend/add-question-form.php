<?php


  $title = 'Add Question form';
  $action = 'add';
  $userID = 0;
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <ol class="breadcrumb">
      
      <li class="breadcrumb-item active"><a href="<?php echo base_url(); ?>administrator"> Dashboard</a> / <?php echo $title?></li>
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
    <div class="box_general padding_bottom">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="header_box version_2">
              <h2><i class="fa fa-file"></i><?php echo $title?></h2>
              
            </div><!-- /.box-header -->
            <!-- form start -->
            <br clear="all">
            <?php $this->load->helper("form"); ?>
            <form role="form" id="AddSurvey" action="<?php echo base_url(); ?>administrator/site-settings/addquestionformaction" method="post" role="form" enctype="multipart/form-data">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
            
            <?php
                    if($surveyFormdata->survey_form_id > 0){
                      $questionArr = json_decode($surveyFormdata->question, true);
                      //print '<pre>';
                      //print_r($questionArr);
                    }
                    ?>
              <div class="box-body">
                <div class="row">
                  
                  <div class="col-md-12">
                  <div class="form-group" style="">
                    <div class="row" style="background-color: #f6f6f6; padding: 10px 10px 0 0">
                    
                      <div class="col-md-8">                                
                        <div class="form-group">
                          <label for="lastName">Question 1</label>
                          <input type="text" class="form-control" name="Question1" placeholder="Question 1" value="<?php echo $questionArr[0]['Question'];?>">
                        </div>
                      </div>
                      <div class="col-md-2"> 
                        <div class="form-group">
                          <label for="lastName">Section</label>
                            <select class="form-control" name="Category1" data-question="1">
                            <?php
                            if(count($questionCat)>0 && is_array($questionCat))
                            {
                              foreach($questionCat as $k=>$v)
                              {
                                ?>
                                <option value="<?php echo $v['id'];?>" <?php echo ($v['id'] == $questionArr[0]['Category'])?'selected':'';?>><?php echo $v['category_name'];?></option>
                                <?php
                              }
                            }
                            
                            ?>
                            
                            </Select>
                        </div>
                      </div>
                      <div class="col-md-2">                                
                        <div class="form-group">
                          <label for="lastName">Answer Type</label>
                          <select class="form-control ansdropdodn" name="Answer1" data-question="1">
                          <option value="text" <?php echo ($questionArr[0]['Answer'] == 'text')? 'selected' : '';?>>Text Option</option>
                          <option value="checkbox" <?php echo ($questionArr[0]['Answer'] == 'checkbox')? 'selected' : '';?>>Multiple Answer [Checknox]</option>
                          <option value="selectbox" <?php echo ($questionArr[0]['Answer'] == 'selectbox')? 'selected' : '';?>>Drop Down [Selectbox]</option>
                          <option value="radio" <?php echo ($questionArr[0]['Answer'] == 'radio')? 'selected' : '';?>>Multiple Options [Radio]</option>
                          
                          </Select>
                        </div>
                      </div>
                    <div class="col-md-12 answerpane1" style="<?php echo ($questionArr[0]['Answer'] == 'text' || $questionArr[0]['Answer'] == '')? 'display:none':'';?>">                                
                      <div class="form-group">
                        <label for="lastName">Answer Options</label>
                        <div class="row" id="answeroption1">
                        <?php 
                        if($questionArr[0]['Answer'] == 'text')
                        {
                          $displayOther = 'N';
                        }else{
                          $displayOther = 'Y';
                        }
                          ?>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="text" class="form-control defaultansoption1" name="Answer1Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[0]['AnswerOptions'][0];?>">  
                            </div>
                          </div>
                          <div class="col-md-3 ansoption1" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                            <div class="form-group">
                              <input type="text" class="form-control" name="Answer1Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[0]['AnswerOptions'][1];?>">  
                            </div>
                          </div>
                            <div class="col-md-3 ansoption1" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                              <div class="form-group">
                                <input type="text" class="form-control" name="Answer1Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[0]['AnswerOptions'][2];?>">  
                              </div>
                          </div> 
                          <div class="col-md-3 ansoption1" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                            <div class="form-group">
                              <input type="text" class="form-control" name="Answer1Options[]" placeholder="Answer Option" value="<?php echo $questionArr[0]['AnswerOptions'][3];?>">  
                            </div>
                          </div>

                          <?php
                          if(count($questionArr[0]['AnswerOptions'])>4)
                          {
                            $j=4;
                            while($questionArr[0]['AnswerOptions'][$j])
                            {
                              ?>
                              <div class="col-md-3" class="ansoption1" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                            <div class="form-group">
                              <input type="text" class="form-control" name="Answer1Options[]" placeholder="Answer Option" value="<?php echo $questionArr[0]['AnswerOptions'][$j];?>">  
                            </div>
                          </div>
                              <?php
                              $j++;
                            }
                          }
                        
                        ?>
                          
                        </div>
                        <div class="row">
                        <div class="col-md-12">
                          <?php
                          if($editpermission)
                          {
                            ?>
                          <button type="button" class="btn btn-sm btn-primary addmoreansweroption pull-right" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?> data-question="1" id="addmore1">Add More Option</button>
                          <?php
                          }
                          ?>
                        </div>
                        </div>
                      </div>


                    </div>
                    </div>

                    <div class="row"><div class="col-md-12">
                    <?php
                          if($editpermission)
                          {
                            ?>
                    <button type="button" style="margin-top:7px;  <?php echo (is_array($questionArr[1]) && count($questionArr[1])>0)?'display: none' : '';?>" class="btn btn-sm btn-warning addmorequestion pull-right" data-question="1">Add More Question</button>
                    <?php
                          }
                          ?>
                    </div>
                  </div>
                  </div>
                  </div>
                  <?php
                  for($i=1;$i<100;$i++)
                  {
                    
                  ?>
                  <div class="col-md-12">
                  <div class="form-group" id="secment<?php echo $i+1?>" style="<?php echo (is_array($questionArr[$i]) && count($questionArr[$i])>0)?'' : 'display: none';?>">
                    <div class="row" style="background-color: #f6f6f6;padding: 10px 10px 0 0;">
                    <div class="col-md-8">                                
                      <div class="form-group">
                        <label for="lastName">Question <?php echo $i+1?></label>
                        <input type="text" class="form-control" name="Question<?php echo $i+1;?>" placeholder="Question <?php echo $i+1?>" value="<?php echo $questionArr[$i]['Question'];?>">
                      </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="form-group">
                          <label for="lastName">Section</label>
                            <select class="form-control" name="Category<?php echo $i+1;?>" data-question="1">
                            <?php
                            if(count($questionCat)>0 && is_array($questionCat))
                            {
                              foreach($questionCat as $k=>$v)
                              {
                                ?>
                                <option value="<?php echo $v['id'];?>" <?php echo ($v['id'] == $questionArr[$i]['Category'])?'selected':'';?>><?php echo $v['category_name'];?></option>
                                <?php
                              }
                            }
                            
                            ?>
                            
                            </Select>
                        </div>
                      </div>
                    <div class="col-md-2">                                
                      <div class="form-group">
                        <label for="lastName">Answer Type</label>
                        <select class="form-control ansdropdodn" name="Answer<?php echo $i+1;?>" data-question="<?php echo $i+1;?>">
                        <option value="text" <?php echo ($questionArr[$i]['Answer'] == 'text')? 'selected' : '';?>>Text Option</option>
                        <option value="checkbox" <?php echo ($questionArr[$i]['Answer'] == 'checkbox')? 'selected' : '';?>>Multiple Answer [Checknox]</option>
                        <option value="selectbox" <?php echo ($questionArr[$i]['Answer'] == 'selectbox')? 'selected' : '';?>>Drop Down [Selectbox]</option>
                        <option value="radio" <?php echo ($questionArr[$i]['Answer'] == 'radio')? 'selected' : '';?>>Multiple Options [Radio]</option>
                        
                        </Select>
                      </div>
                    </div>
                    <div class="col-md-12 answerpane<?php echo $i+1;?>" style="<?php echo ($questionArr[$i]['Answer'] == 'text' || $questionArr[$i]['Answer'] == '')? 'display:none':'';?>">                                
                      <div class="form-group">
                        <label for="lastName">Answer Options</label>
                        <div class="row" id="answeroption<?php echo $i+1;?>">
                        <?php 
                        if($questionArr[$i]['Answer'] == 'star')
                        {
                          $displayOther = 'N';
                        }else{
                          $displayOther = 'Y';
                        }
                          ?>
                          <div class="col-md-3">
                          <div class="form-group">
                            <input type="text" class="form-control  defaultansoption<?php echo $i+1;?>" name="Answer<?php echo $i+1;?>Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[$i]['AnswerOptions'][0];?>">  
                            </div>
                          </div>
                          <div class="col-md-3 ansoption<?php echo $i+1;?>" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                          <div class="form-group">
                            <input type="text" class="form-control" name="Answer<?php echo $i+1;?>Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[$i]['AnswerOptions'][1];?>">  
                            </div>
                          </div>
                            <div class="col-md-3 ansoption<?php echo $i+1;?>" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                            <div class="form-group">
                            <input type="text" class="form-control" name="Answer<?php echo $i+1;?>Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[$i]['AnswerOptions'][2];?>">  
                            </div>
                          </div> 
                          <div class="col-md-3 ansoption<?php echo $i+1;?>" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                          <div class="form-group">
                            <input type="text" class="form-control" name="Answer<?php echo $i+1;?>Options[]" placeholder="Answer Option"  value="<?php echo $questionArr[$i]['AnswerOptions'][3];?>">  
                            </div>
                          </div>
                          <?php
                          if(count($questionArr[$i]['AnswerOptions'])>4)
                          {
                            $j=4;
                            while($questionArr[$i]['AnswerOptions'][$j])
                            {
                              ?>
                              <div class="col-md-3 ansoption<?php echo $i+1;?>" <?php echo ($displayOther == 'N')?'style="display: none"' : '';?>>
                            <div class="form-group">
                              <input type="text" class="form-control" name="Answer<?php echo $i+1;?>Options[]" placeholder="Answer Option" value="<?php echo $questionArr[$i]['AnswerOptions'][$j];?>">  
                            </div>
                          </div>
                              <?php
                              $j++;
                            }
                          }
                          ?>
                        </div>
                        <div class="row">
                        <div class="col-md-12">

                        <?php
                        if($editpermission)
                        {
                          ?>
                          <button type="button" class="btn btn-sm btn-primary addmoreansweroption  pull-right"<?php echo ($displayOther == 'N')?'style="display: none"' : '';?>  data-question="<?php echo $i+1;?>" id="addmore<?php echo $i+1;?>">Add More Option</button>
                          <?php
                        }
                        ?>
                        </div>
                        </div>

                      </div>
                    </div>
                    </div>
                    <div class="row"><div class="col-md-12">
                    <?php
                        if($editpermission)
                        {
                          ?>
                    <button type="button" style="margin-top:7px;  <?php echo (is_array($questionArr[$i+1]) && count($questionArr[$i+1])>0)?'display: none' : '';?>" class="btn btn-sm btn-warning addmorequestion pull-right" data-question="<?php echo $i+1;?>">Add More Question</button>
                    <?php
                        }
                        ?>
                    </div></div>
                    </div>
                  </div>

                  <?php
                  }
                  ?>

              </div><!-- /.box-body -->
              <div class="box-footer">
                <input type="hidden" name="action" value="<?php echo $action;?>">
                <?php
                        if($editpermission)
                        {
                          ?>
                <input type="submit" name="submit" class="btn btn-primary" value="Submit" />
                <?php
                        }
                        ?>
                
              </div>
            </form>
          </div>
        </div>
      </div>    
      </div>
    </div>
  </div>