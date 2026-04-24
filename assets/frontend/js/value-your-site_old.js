$(function () {
    var sitepath = $('#sitepath').val();
    // step 1
    var step1 = false;
    var step2 = false;
    $('.monetization').click(function(){
        $('.box').removeClass('slected-monetization');
        if($(this).hasClass('slected-monetization'))
        {
            $(this).removeClass('slected-monetization');
            //monetizationArr = monetizationArr.filter(d => d!=$(this).data('tab'));
        }else{
            $(this).addClass('slected-monetization');
            $('#tabarea1').addClass('selected');
            //monetizationArr.push($(this).data('tab'));
            $('#monitizationValue').val($(this).data('tab'));
            step1 = true;
            $('.step1next').trigger('click');
        }
        if($('.slected-monetization').length>0){
            $('.step1next').attr('disabled',false)
        }else{
            $('.step1next').attr('disabled',true)
        }
    });
    $('.step1next').click(function(){
        var monetizationArr = new Array();
        var nextStep = false;
        $('.slected-monetization').each(function(index){
            //monetizationArr.push($(this).data('tab'));
            nextStep = true;
            $('#monitizationValue').val($(this).data('tab'));
        });
        //console.log(monetizationArr);
        if(nextStep == true)
        {
            step1 = true;
            $('#tabarea3').trigger('click');
        }
        
        
    });
    // step 1 end


    // step 3
    $('.step3next').click(function(){
        
        var avgRev = false;
        var avgPro = false;
        var avgRevError = "";
        var avgProError = "";
        if($('#monthavgrevenue').val() == '')
        {
            avgRev = false;
            avgRevError = "Please add average yearly revenue.";
        }else if(!$.isNumeric($('#monthavgrevenue').val()))
        {
            avgRev = false;
            avgRevError = "Average yearly revenue should be numeric.";
        }else{
            avgRev = true;
        }

        if($('#monthavgprofit').val() == '')
        {
            avgPro = false;
            avgProError = "Please add average yearly profit.";
        }else if(!$.isNumeric($('#monthavgprofit').val()))
        {
            avgPro = false;
            avgProError = "Average yearly profit should be numeric.";
        }else{
            avgPro = true;
        }
        if(avgRev == false)
        {
            $('#monthavgrevenuelbl').html(avgRevError);
            console.log(avgRevError);
            $('#monthavgrevenuelbl').attr('style',"display:");
        }else{
            $('#monthavgrevenuelbl').attr('style',"display:none");
        }
        if(avgPro == false)
        {
            $('#monthavgprofitlbl').html(avgProError);
            $('#monthavgprofitlbl').attr('style',"display:");
        }else{
            $('#monthavgprofitlbl').attr('style',"display:none");
        }
        //console.log(avgPro)
        if(avgPro == true && avgRev == true)
        {
            step2 = true;
            $('#tabarea3').addClass('selected');
            $('#tabarea4').trigger('click');
        }
        
    });
    $('#monthavgrevenue').keyup(function(){
        var avgRev = false;
        var avgRevError = "";
        if($('#monthavgrevenue').val() == '')
        {
            avgRev = false;
            avgRevError = "Please add average yearly revenue.";
        }else if(!$.isNumeric($('#monthavgrevenue').val()))
        {
            avgRev = false;
            avgRevError = "Average yearly revenue should be numeric.";
        }else{
            avgRev = true;
        }
        if(avgRev == false)
        {
            $('#monthavgrevenuelbl').html(avgRevError);
            $('#monthavgrevenuelbl').attr('style',"display:");
        }else{
            $('#monthavgrevenuelbl').attr('style',"display:none");
        }
    });

    $('#monthavgprofit').keyup(function(){
        var avgPro = false;
        var avgProError = "";
        if($('#monthavgprofit').val() == '')
        {
            avgPro = false;
            avgProError = "Please add average yearly profit.";
        }else if(!$.isNumeric($('#monthavgprofit').val()))
        {
            avgPro = false;
            avgProError = "Average yearly profit should be numeric.";
        }else{
            avgPro = true;
        }
        if(avgPro == false)
        {
            $('#monthavgprofitlbl').html(avgProError);
            $('#monthavgprofitlbl').attr('style',"display:");
        }else{
            $('#monthavgprofitlbl').attr('style',"display:none");
        }
    });

    $('.questioninput').keyup(function(){
        var avgPro = false;
        var avgProError = "";
        if($(this).val() == '')
        {
            avgPro = false;
            avgProError = "Please add a numeric value.";
        }else if(!$.isNumeric($(this).val()))
        {
            avgPro = false;
            avgProError = "Please add a numeric value.";
        }else{
            avgPro = true;
        }
        var Qid = $(this).data('id');
        if(avgPro == true)
        {
            $('#questionerror'+Qid).attr('style','display:none');
        }else{
            $('#questionerror'+Qid).attr('style','display:block');
        }
        
    });

    $('#incomeDetailsForm').on('submit',function(e){
        e.preventDefault();
    })

    // step 3 end
    // step 4
    $('.track').click(function(){
        if($(this).hasClass('yes-btn')){
            $('#trackingdetails').slideDown('slow');
            $('#trackingInfo').val('Y');
        }else{
            $('#trackingdetails').slideUp('slow');
            $('#trackingInfo').val('N');
        }
    });
    $('.trackingtool').click(function(){
        if($(this).hasClass('google-analitics')){
            $('#trackingtool').val('Google Analitics');
        }else if($(this).hasClass('clicky')){
            $('#trackingtool').val('Clicky');
        }

    });

    $('.step4next').click(function(){
            var submitReady = true;    
            $('.questioninput').each(function(index){
                var avgPro = false;
                var avgProError = "";
                
                if($(this).val() == '')
                {
                    avgPro = false;
                    submitReady = false;
                    avgProError = "Please add a numeric value.";
                }else if(!$.isNumeric($(this).val()))
                {
                    avgPro = false;
                    submitReady = false;
                    avgProError = "Please add a numeric value.";
                }else{
                    avgPro = true;
                }
                var Qid = $(this).data('id');
                if(avgPro == true)
                {
                    $('#questionerror'+Qid).attr('style','display:none');
                }else{
                    $('#questionerror'+Qid).attr('style','display:block');
                }
                
            });
            if(step1 == false)
            {
                $('#tabarea1').trigger('click');
                return false;
            }else if(step2 == false)
            {
                $('#tabarea3').trigger('click');
                return false;
            }
            else(submitReady == true)
            {
                $(".step4next").html('Loading...');
                $(".step4next").attr('disabled',true);
                $('#valueurbusinessform').submit();
                return true;
            }
            
    });

    $('#dateform11').on('submit',function(e){
        e.preventDefault();
    })

    $('#dateform11').validate({
        rules:{
            'trackingaddeddate' : { required : true, minDate: true }
        },
        messages:{
            'trackingaddeddate' : { required : "Business Created date is required.",minDate : "Google Analytics or Clicky added date cannot be in the future." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });

    // step 4 end
    //step 5
    
    $('#extraInfo').keyup(function(){
        var max = 1000;
        var len = $(this).val().length;
        if (len >= max) {
          $('#charNum').text(' you have reached the limit');
        } else {
          var char = max - len;
          $('#charNum').text(char + ' characters left');
        }
    });
    $('#extraInfoForm').on('submit',function(e){
        e.preventDefault();
    })
    
    //step 5 end
    
    
    $('.step3back').click(function(){
        alert('ddd');
        $('#tabarea1').trigger('click');
    });
    $('.step4back').click(function(){
        $('#tabarea3').trigger('click');
    });
});