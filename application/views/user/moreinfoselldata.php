<main class="mainContainer">  
		<section class="section seller-dashboard">
			<div class="container">
				<div class="d-flex addinfo-form tab-head-sec flex-wrap mb30">
					<div>
						<h2 class="heading">Info for listing: #<?php echo $listingId;?></h2> 
                        <?php
                            $success = $this->session->flashdata('success');
                            if($success) { 
                                ?>
                            <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('success'); ?>
                            </div>
                                <?php 
                            } 
                            $error = $this->session->flashdata('error');
                            if($error) { 
                                ?>
                            <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <?php echo $this->session->flashdata('error'); ?>
                            </div>
                                <?php 
                            } 

                        ?>
                        <form action="<?php echo base_url(); ?>user/sell/moreinfodatasubmit" method="post" id="answerform">
                        <input type="hidden" name="answerStatus" id="answerStatus" value="0">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                        <input type="hidden" name="listingId" value="<?php echo $listingId;?>">
						<div class="row addinfo-form-row">
                        
                        <?php
                            if(is_array($sellQArtr) && count($sellQArtr)>0)
                            { 
                                $k=0;
                                foreach($sellQArtr as $v)
                                {
                                    //print '<pre>';
                                    //print_r($v);
                                    if(is_array($v['addedquestions']) && count($v['addedquestions'])>0)
                                    {
                                       
                                    ?>
                                    <div class="col-sm-12"><h3><?php echo $v['cat_name']?></h3></div>
                                        <?php
                                        foreach($v['addedquestions'] as $val)
                                        {
                                            ?>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for=""><strong>Q.</strong> <?php echo $val['Question']?>?</label>
                                                <strong>A.</strong> <?php
                                                if($sellQStatus == 1)
                                                {
                                                    
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
                                                }
                                                else
                                                {
                                                    if($val['Answer'] == 'text')
                                                    {
                                                        ?>
                                                        <textarea name="Answer<?php echo $k;?>" id="" cols="30" rows="10"><?php echo $val['AnswerGiven']?></textarea>
                                                        <?php
                                                    }elseif($val['Answer'] == 'checkbox')
                                                    {
                                                        if(is_array($val['AnswerOptions']) && count($val['AnswerOptions'])>0)
                                                        {
                                                            foreach($val['AnswerOptions'] as $ansop)
                                                            {
                                                                if($ansop!=''){
                                                                ?>
                                                                <div class="checkbox-wrap">
                                                                <input type="checkbox" name="Answer<?php echo $k;?>[]" id="" value="<?php echo $ansop;?>" <?php echo (in_array($ansop,$val['AnswerGiven']))?'checked="true"':'';?>> <?php echo $ansop;?>
                                                                </div>

                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    }elseif($val['Answer'] == 'radio')
                                                    {
                                                        if(is_array($val['AnswerOptions']) && count($val['AnswerOptions'])>0)
                                                        {
                                                            foreach($val['AnswerOptions'] as $ansop)
                                                            {
                                                                if($ansop !='')
                                                                {
                                                                ?>
                                                                <div class="checkbox-wrap">
                                                                <input type="radio" name="Answer<?php echo $k;?>" id="" value="<?php echo $ansop;?>" <?php echo ($ansop == $val['AnswerGiven'])?'checked="true"':'';?>> <?php echo $ansop;?>
                                                                </div>

                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        
                                                    }elseif($val['Answer'] == 'selectbox')
                                                    {
                                                        ?>
                                                        <select name="Answer<?php echo $k;?>" id="">
                                                            <option value="">Please Select</option>
                                                        <?php
                                                        if(is_array($val['AnswerOptions']) && count($val['AnswerOptions'])>0)
                                                        {
                                                            foreach($val['AnswerOptions'] as $ansop)
                                                            {
                                                                if($ansop !='')
                                                                {
                                                                ?>
                                                                <option value="<?php echo $ansop;?>" <?php echo ($ansop == $val['AnswerGiven'])?'selected':'';?>> <?php echo $ansop;?></option>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        </select>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <?php
                                            $k++;
                                        }
                                    }
                                }
                            }
                            if($sellQStatus != 1)
                            {
                        ?>
                        <div class="col-md-6">
                            <div class="form-btn form-group"> 
                            <input type="submit" value="Save as Draft" class="btn btn_lg" style="margin-right:10px">
                            <input type="button" value="Publish" class="btn btn_lg" onclick="javascript: publishanswer(this)">
                            </div>
                        </div>
                        <?php
                            }
                            ?>
                        
                        </div></form>
					</div>
					
				</div> 
			</div>
		</section>  
	</main> 
    <div class="modal fade" id="publishanswersModel" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="deleteModalLabel">Are you sure want to publish the answer?</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-footer">
        <input type="hidden" class="csrftoken" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <button type="button" class="btn btn-primary publishanswers">Publish</button>
        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div>
  </div>
</div>
	