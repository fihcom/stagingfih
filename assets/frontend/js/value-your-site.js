$(function () {
    var sitepath = $('#sitepath').val();
    var step1 = false;
    var step2 = false;
    var step3 = false;

    // step 1
    $('.monetization').click(function(){
        $('.box').removeClass('slected-monetization');
        if($(this).hasClass('slected-monetization'))
        {
            $(this).removeClass('slected-monetization');
            //monetizationArr = monetizationArr.filter(d => d!=$(this).data('tab'));
        }else{
            $(this).addClass('slected-monetization');
            //$('#tabarea1').addClass('selected');
            //monetizationArr.push($(this).data('tab'));
            $('#monitizationValue').val($(this).data('tab'));
            //step1 = true;
            //$('.step1next').trigger('click');
        }
        
    });
    
    /*$('.box').click(function(){
        if($(this).hasClass('slected-monetization'))
        {
            $(this).removeClass('slected-monetization');
            //monetizationArr = monetizationArr.filter(d => d!=$(this).data('tab'));
        }else{
            $(this).addClass('slected-monetization');
            //monetizationArr.push($(this).data('tab'));
        }
        if($('.slected-monetization').length>0){
            $('.step1next').attr('disabled',false)
        }else{
            $('.step1next').attr('disabled',true)
        }
    });*/
    $('.step1next').click(function(){
        var monetizationArr = new Array();
        $('.slected-monetization').each(function(index){
            monetizationArr.push($(this).data('tab'));
        });
        //console.log(monetizationArr);
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
                $('#tabarea2').trigger('click');
            }             
        });
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
                            //console.log(data);
                            $('.csrftoken').attr('value',data.token);
                            //$('#sellbusinessdata').attr('value',data.sellbusiness);
                            $(".step2next").attr('disabled',false);
                            $(".step2next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                            step1 = true;
                            $('#tabarea2').addClass('selected');
                            $('#tabarea3').trigger('click');
                        }             
                    });
                }else{
                    step1 = false;
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
        //console.log(now);
        //console.log(myDate);
        return this.optional(element) || myDate < now;
    });
    jQuery.validator.addMethod('validUrl', function(value, element) {
        var url = $.validator.methods.url.bind(this);
        return url(value, element) || url('http://' + value, element);
      }, 'Please enter a valid URL');

    // step 2 end

    // step 3
    $('.step3next').click(function(){
        
        //$('#incomeDetailsForm').submit();
        //if($('#incomeDetailsForm').validate().valid())
        //{
            //var avgrevenue = $('#avgrevenue').val();
            //var avgprofit = $('#avgprofit').val();
            //var recurringrevenue = $('#recurringrevenue').val();
            var monetization  = $('#monitizationValue').val();
            if(monetization == '')
            {
                $('#monitizationerror').attr('style','display:block; margin-top: 10px;');
            }else{
                //console.log($('#sellurbusinessform').attr('action'));
                //console.log($('#sellurbusinessform').serialize()+'monetization='+monetization+'&step=3');
                $.ajax({
                    url: $('#sellurbusinessform').attr('action'),
                    data: $('#sellurbusinessform').serialize()+'&monetization='+monetization+'&step=3',
                    dataType: 'json', 
                    type: 'post',
                    beforeSend: function(){
                        $(".step3next").html('Loading...');
                        $(".step3next").attr('disabled',true);
                    },
                    success: function(data) {
                        console.log("Step 3",data);
                        $('.csrftoken').attr('value',data.token);
                        //$('#sellbusinessdata').attr('value',data.sellbusiness);
                        step2 = true;
                        $(".step3next").attr('disabled',false);
                        $(".step3next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                        $('#tabarea3').addClass('selected');
                        $('#tabarea4').trigger('click');
                    }             
                });
            }
            
        //}else{
            //step2 = false;
        //}
    });
    // step 5
    $('.step5next').click(function(){
        $('#incomeDetailsForm').submit();
        if($('#incomeDetailsForm').validate().valid())
        {
            var avgrevenue = $('#avgrevenue').val();
            var avgprofit = $('#avgprofit').val();
            var recurringrevenue = $('#recurringrevenue').val();
            //var monetization  = $('#monitizationValue').val();
            //console.log("step 5",$('#sellurbusinessform').attr('action'));
            //console.log("step 5A",$('#sellurbusinessform').serialize()+'&avgrevenue='+avgrevenue+'&avgprofit='+avgprofit+'&recurringrevenue='+recurringrevenue+'&step=5');
                $.ajax({
                    url: $('#sellurbusinessform').attr('action'),
                    data: $('#sellurbusinessform').serialize()+'&avgrevenue='+avgrevenue+'&avgprofit='+avgprofit+'&recurringrevenue='+recurringrevenue+'&step=5',
                    dataType: 'json', 
                    type: 'post',
                    beforeSend: function(){
                        $(".step5next").html('Loading...');
                        $(".step5next").attr('disabled',true);
                    },
                    success: function(data) {
                        //console.log("Step 55",data);
                        $('.csrftoken').attr('value',data.token);
                        //$('#sellbusinessdata').attr('value',data.sellbusiness);
                        step2 = true;
                        $(".step5next").attr('disabled',false);
                        $(".step5next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                        $('#tabarea4').addClass('selected');
                        $('#tabarea5').trigger('click');
                    }             
                });
            //}
            
        }
        //else{
            //step2 = false;
        //}
    });
    $('#incomeDetailsForm').on('submit',function(e){
        e.preventDefault();
    })
    $('#incomeDetailsForm').validate({
        rules:{
            'avgrevenue' : { required : true, number: true },
            'avgprofit' : { required : true, number: true },
            'recurringrevenue' : { required : true, number: true },
            'month6avgprofit' : { required : true, number: true },
            'month12avgrevenue' : { required : true, number: true },
            'month12avgprofit' : { required : true, number: true },
        },
        messages:{
            'avgrevenue' : { required : "Yearly average revenue is required.", number : "Yearly average revenue should be numeric." },
            'avgprofit' : { required : "Yearly average profit is required.", number : "Yearly average profit should be numeric." },
            'recurringrevenue' : { required : "Percentage of recurring revenue is required.", number : "Percentage of recurring revenue should be numeric." },
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
        
        $('#dateform11').submit();
        var proceed = $('#dateform11').validate().valid()
        if(proceed)
        {

            var uniquevisiors = $('#uniquevisiors').val();
            var onlinefollowers = $('#onlinefollowers').val();
            var revenuechannels = $('#revenuechannels').val();
            //console.log(uniquevisiors+'++'+onlinefollowers+'++'+);
            $.ajax({
                url: $('#sellurbusinessform').attr('action'),
                data: $('#sellurbusinessform').serialize()+'&uniquevisiors='+uniquevisiors+'&onlinefollowers='+onlinefollowers+'&revenuechannels='+revenuechannels+'&step=4',
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $(".step4next").html('Loading...');
                    $(".step4next").attr('disabled',true);
                },
                success: function(data) {
                    //console.log('last step',data);
                    $('.csrftoken').attr('value',data.token);
                    step3 = true;
                    $('#valueurbusinessform').submit();
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    //$(".step4next").attr('disabled',false);
                    //$(".step4next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    //$('#tabarea4').addClass('selected');
                    //$('#tabarea5').trigger('click');
                }             
            });

        }else{
            step3 = false;
        }
    });

    $('#dateform11').on('submit',function(e){
        e.preventDefault();
    })

    $('#dateform11').validate({
        rules:{
            'uniquevisiors' : { required : true, number: true },
            'onlinefollowers' : { required : true, number: true },
            'revenuechannels' : { required : true, number: true }

        },
        messages:{
            'uniquevisiors' : { required : "Number of Unique visitors is required.",number : "Number of Unique visitors nust be numeric." },
            'onlinefollowers' : { required : "Number of online followers is required.",number : "Number of online followers nust be numeric." },
            'revenuechannels' : { required : "Number of Revenue channels is required.",number : "Number of revenue channels nust be numeric." },
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

    /*$( "#startdate" ).datepicker({
        format: 'mm/dd/yyyy',
        startDate: '-3d'
    });*/
      
});
