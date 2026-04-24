$(function () {
    var sitepath = $('#sitepath').val();
    // step 1
    
    $('.box').click(function(){
        if($(this).hasClass('slected-monetization'))
        {
            $(this).removeClass('slected-monetization');
            //monetizationArr = monetizationArr.filter(d => d!=$(this).data('tab'));
        }else{
            $(this).addClass('slected-monetization');
            //monetizationArr.push($(this).data('tab'));
        }
        /*if($('.slected-monetization').length>0){
            $('.step1next').attr('disabled',false)
        }else{
            $('.step1next').attr('disabled',true)
        }*/
    });
    $('.step1next').click(function(){
        var monetizationArr = new Array();
        $('.slected-monetization').each(function(index){
            monetizationArr.push($(this).data('tab'));
        });
        console.log($('.slected-monetization').length);
        if($('.slected-monetization').length>0){
            //$('.step1next').attr('disabled',false)
            $.ajax({
                url: $('#sellurbusinessform').attr('action'),
                data: $('#sellurbusinessform').serialize()+'&monetization='+monetizationArr+'&step=1',
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $(".step1next").html('Loading...');
                    $(".step1next").attr('disabled',true);
                },
                success: function(data) {
                    //console.log(data);
                    $('.csrftoken').attr('value',data.token);
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    $(".step1next").attr('disabled',false);
                    $(".step1next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    $('#tabarea1').addClass('selected');
                    $('#tabarea3').trigger('click');
                }             
            });
            $('.monetizationerr').attr('style','display:none');
        }else{
            //$('.step1next').attr('disabled',true)
            $('.monetizationerr').attr('style','display:block');
        }

        //console.log(monetizationArr);
        
    });
    // step 1 end



    // step 2
    $('.addwebsite').click(function(){
        $('#websiteform').submit();
        if($('#websiteform').validate().valid())
        {
            var numberIncr = 0;
            $('.websitetext').each(function(index){
                //websiteArr.push($(this).val());
                numberIncr++;
            });
            var texthtml = '<input class="websitetext" type="text" placeholder="Enter Your Business URL" name="website'+numberIncr+'">';
            $('#websiteform').append(texthtml);
            //numberIncr++;
        }
        

    });

    $('.step2next').click(function(){
        $('#websiteform').submit();
        
        if($('#websiteform').validate().valid())
        {
            $('#dateform').submit();
            if($('#dateform').validate().valid())
            {
                $('#hoursform').submit();
                if($('#hoursform').validate().valid())
                {
                    var websiteArr = new Array();
                    $('.websitetext').each(function(index){
                        //console.log( index + ": " + $(this).val());
                        websiteArr.push($(this).val());
                    });
                    var businessstartdate = $('#startdate').val();
                    var workingHour = $('#workinghour').val();
                    $.ajax({
                        url: $('#sellurbusinessform').attr('action'),
                        data: $('#sellurbusinessform').serialize()+'&website='+websiteArr+'&businessstartdate='+businessstartdate+'&workinghour='+workingHour+'&step=2',
                        dataType: 'json', 
                        type: 'post',
                        beforeSend: function(){
                            $(".step2next").html('Loading...');
                            $(".step2next").attr('disabled',true);
                        },
                        success: function(data) {
                            console.log(data);
                            $('.csrftoken').attr('value',data.token);
                            //$('#sellbusinessdata').attr('value',data.sellbusiness);
                            $(".step2next").attr('disabled',false);
                            $(".step2next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                            $('#tabarea2').addClass('selected');
                            $('#tabarea1').trigger('click');
                        }             
                    });
                }
                
            }
            
        }
    });
    $('#websiteform').on('submit',function(e){
        $('input.websitetext').each(function() {

            $(this).rules("add", { required: true, validUrl: true  });
        }); 
        e.preventDefault();
        
        
    })
    $('#websiteform').validate({
        rules:{
            'website' : { required : true, validUrl: true }
        },
        messages:{
            'website' : { required : "At least one site URL is required." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });


    jQuery.validator.addMethod('validUrl', function(value, element) {
        var url = $.validator.methods.url.bind(this);
        return url(value, element) || url('http://' + value, element);
      }, 'Please enter a valid URL');

    $('#dateform').validate({
        rules:{
            'startdate' : { required : true, futuredocexp: true }
        },
        messages:{
            'startdate' : { required : "Business Created date is required.",futuredocexp : "Business Created date cannot be in the future." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#hoursform').validate({
        rules:{
            'workinghour' : { required : true, number: true }
        },
        messages:{
            'workinghour' : { required : "Working hour is required.",number : "Working hour should be numeric." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#dateform').on('submit',function(e){
        e.preventDefault();
    })
    $('#hoursform').on('submit',function(e){
        e.preventDefault();
    })
    jQuery.validator.addMethod("futuredocexp", function (value, element) {
        var now = new Date();
        var myDate = new Date(value);
        return this.optional(element) || myDate < now;
    });

    // step 2 end

    // step 3
    $('.step3next').click(function(){
        $('#incomeDetailsForm').submit();
        if($('#incomeDetailsForm').validate().valid())
        {
            var month3avgrevenue = $('#month3avgrevenue').val();
            var month3avgprofit = $('#month3avgprofit').val();
            var month6avgrevenue = $('#month6avgrevenue').val();
            var month6avgprofit = $('#month6avgprofit').val();
            var month12avgrevenue = $('#month12avgrevenue').val();
            var month12avgprofit = $('#month12avgprofit').val();
            $.ajax({
                url: $('#sellurbusinessform').attr('action'),
                data: $('#sellurbusinessform').serialize()+'&month3avgrevenue='+month3avgrevenue+'&month3avgprofit='+month3avgprofit+'&month6avgrevenue='+month6avgrevenue+'&month6avgprofit='+month6avgprofit+'&month12avgrevenue='+month12avgrevenue+'&month12avgprofit='+month12avgprofit+'&step=3',
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $(".step3next").html('Loading...');
                    $(".step3next").attr('disabled',true);
                },
                success: function(data) {
                    console.log(data);
                    $('.csrftoken').attr('value',data.token);
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    $(".step3next").attr('disabled',false);
                    $(".step3next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    $('#tabarea3').addClass('selected');
                    $('#tabarea4').trigger('click');
                }             
            });
        }
    });
    $('#incomeDetailsForm').on('submit',function(e){
        e.preventDefault();
    })
    $('#incomeDetailsForm').validate({
        rules:{
            'month3avgrevenue' : { required : true, number: true },
            'month3avgprofit' : { required : true, number: true },
            'month6avgrevenue' : { required : true, number: true },
            'month6avgprofit' : { required : true, number: true },
            'month12avgrevenue' : { required : true, number: true },
            'month12avgprofit' : { required : true, number: true },
        },
        messages:{
            'month3avgrevenue' : { required : "3 months average revenue is required.", number : "3 months average revenue should be numeric." },
            'month3avgprofit' : { required : "3 months average profit is required.", number : "3 months average profit should be numeric." },
            'month6avgrevenue' : { required : "6 months average revenue is required.", number : "6 months average revenue should be numeric." },
            'month6avgprofit' : { required : "6 months average profit is required.", number : "6 months average profit should be numeric." },
            'month12avgrevenue' : { required : "12 months average revenue is required.", number : "12 months average revenue should be numeric." },
            'month12avgprofit' : { required : "12 months average profit is required.", number : "12 months average profit should be numeric." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
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
        if($('#trackingInfo').val() == 'Y')
        {
            $('#dateform11').submit();
            var proceed = $('#dateform11').validate().valid()
        }else{
            var proceed = true;
        }
        if(proceed)
        {
            var trackingInfo = $('#trackingInfo').val();
            var trackingtool = $('#trackingtool').val();
            var monthlyvisitor = $('#monthlyvisitor').val();
            var trackingaddeddate = $('#trackingaddeddate').val();
            $.ajax({
                url: $('#sellurbusinessform').attr('action'),
                data: $('#sellurbusinessform').serialize()+'&trackingInfo='+trackingInfo+'&trackingtool='+trackingtool+'&monthlyvisitor='+monthlyvisitor+'&trackingaddeddate='+trackingaddeddate+'&step=4',
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $(".step4next").html('Loading...');
                    $(".step4next").attr('disabled',true);
                },
                success: function(data) {
                    //console.log(data);
                    $('.csrftoken').attr('value',data.token);
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    $(".step4next").attr('disabled',false);
                    $(".step4next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    $('#tabarea4').addClass('selected');
                    $('#tabarea5').trigger('click');
                }             
            });

        }
    });

    $('#dateform11').on('submit',function(e){
        e.preventDefault();
    })

    $('#dateform11').validate({
        rules:{
            'trackingaddeddate' : { required : true, futuredocexp: true }
        },
        messages:{
            'trackingaddeddate' : { required : "Business Created date is required.",futuredocexp : "Google Analytics or Clicky added date cannot be in the future." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });

    // step 4 end
    //step 5
    $('.step5next').click(function(){
        $('#extraInfoForm').submit();
        if($('#extraInfoForm').validate().valid())
        {
            var websiteArr = new Array();
            $('.websitetext').each(function(index){
                //console.log( index + ": " + $(this).val());
                websiteArr.push($(this).val());
            });
            var extraInfo = $('#extraInfo').val();
            $.ajax({
                url: $('#sellurbusinessform').attr('action'),
                data: $('#sellurbusinessform').serialize()+'&extraInfo='+extraInfo+'&step=5',
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $(".step5next").html('Loading...');
                    $(".step5next").attr('disabled',true);
                },
                success: function(data) {
                    $('.csrftoken').attr('value',data.token);
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    $(".step5next").attr('disabled',false);
                    $(".step5next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    $('#tabarea5').addClass('selected');
                    $('#tabarea6').trigger('click');
                }             
            });
        }
    });
    $('#extraInfo').keyup(function(){
        var max = 2000;
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
    $('#extraInfoForm').validate({
        rules:{
            'extraInfo' : { required : true,rangelength: [1, 1000] }
        },
        messages:{
            'extraInfo' : { required : "Brief description of your business is required.", rangelength: "You are only allowed to describe your business with 1000 characters." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    //step 5 end

    $('.step2back').click(function(){
        $('#tabarea1').trigger('click');
    });
    $('.step3back').click(function(){
        $('#tabarea2').trigger('click');
    });
    $('.step4back').click(function(){
        $('#tabarea3').trigger('click');
    });
    $('.step5back').click(function(){
        $('#tabarea4').trigger('click');
    });
    //alert($('#sellbusinessdata').val())
});