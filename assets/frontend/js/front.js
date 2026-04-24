$(function () {
    $('#regform').validate({
        rules:{
            fname : { required : true },
            mail : { required : true, email: true },
            phone : { required : true },
            password :  { required : true, pwcheck: true},
            conpassword :  { required : true, equalTo: '#password'},
            terms : { required : true },
        },
        messages:{
            fname : { required : "First Name is required" },
            mail : { required : "Email is required", email: "Please enter a valid email address." },
            phone : { required : "Phone is required",matches : "Please enter a valid phone number." },
            password :  { required : "Password is required", pwcheck: "Password must be minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character." },
            conpassword :  { required : "Confirm Password is required", equalTo: "Password and confirm password are not same." },
            terms : { required : "Please accept Terms and Conditions" },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#regform').on('submit',function(e){
        if($('#regform').validate().valid())
        {
            $('#signupnow').attr('value','Loading...');
            $('#signupnow').attr('disabled',true);
            return true;
        }else{
            $('#signupnow').attr('value','Register Now');
            $('#signupnow').attr('disabled',false);
            return false;
        }
    });

    $('#contact').validate({
        rules:{
            fname : { required : true },
            mail : { required : true, email: true },
            phone : { required : true },
            message :  { required : true},
            
        },
        messages:{
            fname : { required : "Name is required" },
            mail : { required : "Email is required", email: "Please enter a valid email address." },
            phone : { required : "Phone is required",matches : "Please enter a valid phone number." },
            message : { required : "Please add some message." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    var checkCaptch = false;
    var verifyCallback = function(response) {
    if (response == "") {
        checkCaptch = false;
    }
    else {
        checkCaptch = true;
    }
    };

    $('#contact').on('submit',function(event){
        //event.preventDefault();
        //alert(verifyCallback());
        /*if(!verifyCallback() && grecaptcha.getResponse()==""){
            $('#captcha_error').html('Please validate captcha.');
            $('#captcha_error').attr('style', 'display:block');
            var captrchaError = 'Y';
        }else{
            $('#captcha_error').attr('style', 'display:none');
            var captrchaError = 'N';
        }*/
        if($('#contact').validate().valid() && captrchaError == 'N'){
            return true;
        }
        return false;
    });





    $('#loginForm').validate({
        rules:{
            email : { required : true, email: true },
            password :  { required : true},
        },
        messages:{
            email : { required : "Email is required", email: "Please enter a valid email address." },
            password :  { required : "Password is required" },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#loginForm').on('submit',function(e){
        if($('#loginForm').validate().valid())
        {
            $('#loginNow').attr('value','Loading...');
            $('#loginNow').attr('disabled',true);
            return true;
        }else{
            $('#loginNow').attr('value','Login Now');
            $('#loginNow').attr('disabled',false);
            return false;
        }
    });
    $('#forgetpasswordForm').validate({
        rules:{
            email : { required : true, email: true },
        },
        messages:{
            email : { required : "Email is required", email: "Please enter a valid email address." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#forgetpasswordForm').on('submit',function(e){
        if($('#forgetpasswordForm').validate().valid())
        {
            $('#forgetpassbtn').attr('value','Loading...');
            $('#forgetpassbtn').attr('disabled',true);
            return true;
        }else{
            $('#forgetpassbtn').attr('value','Submit');
            $('#forgetpassbtn').attr('disabled',false);
            return false;
        }
    });
    $('#resetpasswordForm').validate({
        rules:{
            password :  { required : true, pwcheck: true},
            conpassword :  { required : true, equalTo: '#mainpass'},
        },
        messages:{
            password :  { required : "Password is required", pwcheck: "Password must be minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character." },
            conpassword :  { required : "Confirm Password is required", equalTo: "Password and confirm password are not same." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#resetpasswordForm').on('submit',function(e){
        if($('#resetpasswordForm').validate().valid())
        {
            $('#resetpassbtn').attr('value','Loading...');
            $('#resetpassbtn').attr('disabled',true);
            return true;
        }else{
            $('#resetpassbtn').attr('value','Submit');
            $('#resetpassbtn').attr('disabled',false);
            return false;
        }
    });

    $('#ticketCreateFrm').validate({
        rules:{
            subject :  { required : true},
            message :  { required : true},
        },
        messages:{
            subject :  { required : "Subject is required"},
            message :  { required : "Ticket Details is required"},
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#ticketCreateFrm').on('submit',function(e){
        if($('#ticketCreateFrm').validate().valid())
        {
            $('#createTicket').attr('value','Loading...');
            $('#createTicket').attr('disabled',true);
            return true;
        }else{
            $('#createTicket').attr('value','Submit');
            $('#createTicket').attr('disabled',false);
            return false;
        }
    });
    
    $('#supportticketreply').validate({
        rules:{
            userreply :  { required : true},
        },
        messages:{
            userreply :  { required : "Reply is required"},
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#supportticketreply').on('submit',function(e){
        if($('#supportticketreply').validate().valid())
        {
            $('#userreplyId').attr('value','Loading...');
            $('#userreplyId').attr('disabled',true);
            return true;
        }else{
            $('#userreplyId').attr('value','Reply');
            $('#userreplyId').attr('disabled',false);
            return false;
        }
    });
    $('#withdrawalAmount').keyup(function(){
        if(parseInt($(this).val())>999)
        {
            var netWithddrawal = parseInt($(this).val())-35;
            $('#grosswithdrawalamt').html($(this).val());
            $('#netwithdrawalamt').html(netWithddrawal);
            $('.withdrawbreakup').slideDown();
        }else{
            $('.withdrawbreakup').slideUp();
        }
    });

    $('#submitwithdrawFrm').validate({
        rules:{
            walletMoney :  { required : true, number:true, greaterThanThousand:true},
            witeTransferInstruction: {required : true}
        },
        messages:{
            walletMoney :  { required : "Withdraw amount is required.", number: "Withdraw amount should be numrric."},
            witeTransferInstruction : { required : "Wire transfer instructions amount is required." }
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    jQuery.validator.addMethod("greaterThanThousand", function(value, element) {
        return this.optional(element) || (parseFloat(value) > 999);
    }, "Minimum Withdrawal Amount id 1000.");

    $('#submitwithdrawFrm').on('submit',function(e){
        if($('#submitwithdrawFrm').validate().valid())
        {
            $('#submitwithdrawbtn').html('Loading...');
            $('#submitwithdrawbtn').attr('disabled',true);
            return true;
        }else{
            $('#submitwithdrawbtn').attr('value','Request to Withdraw');
            $('#submitwithdrawbtn').attr('disabled',false);
            return false;
        }
    });

    $.validator.addMethod("pwcheck",function(value, element) {  
        return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
    });

    $('#uncoverfrm').validate({
        rules:{
            terms : { required : true },
        },
        messages:{
            terms : { required : "Please accept Terms and Conditions" },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#uncoverfrm').on('submit',function(e){
        if($('#uncoverfrm').validate().valid())
        {
            $('.finaluncover').attr('value','Loading...');
            $('.finaluncover').attr('disabled',true);
            return true;
        }else{
            $('.finaluncover').attr('value','Submit');
            $('.finaluncover').attr('disabled',false);
            return false;
        }
    });

    $('#mc-embedded-subscribe-form').validate({
        rules:{
            'EMAIL' : { required : true, email: true },
        },
        messages:{
            'EMAIL' : { required : "Please enter your email address.", email : "Please enter your valid email address." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
	});
	$('#mc-embedded-subscribe-form').submit(function(e){
        //e.preventDefault();
		if($('#mc-embedded-subscribe-form').validate().valid())
		{
            /*$('.emailsubscribebtn').html('Loading...');
            $('.emailsubscribebtn').attr('disabled',true);
            $.ajax({
                url: $('#newsletterfrm').attr('action'),
                data: $('#newsletterfrm').serialize(),
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    console.log(data);
                } 
            });*/
            return true;
		}
        return false;
    });
    $('#redeemcodeForm').validate({
        rules:{
            'redeemCode' : { required : true },
        },
        messages:{
            'redeemCode' : { required : "Please enter promo code."},
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#redeemcodeForm').submit(function(e){
        //e.preventDefault();
		if($('#redeemcodeForm').validate().valid())
		{
            return true;

		}else{
            return false;
        }
    });

    $('.loadmoretestimonial').click(function(){
        //console.log($('#loadmoretestimonialfrm').serialize());
        $('.loadmoretestimonial').html('Loading...');
        $.ajax({
            url: $('#sitepath').val()+'gettestimonials',
            data: $('#loadmoretestimonialfrm').serialize(),
            dataType: 'json', 
            type: 'post',
            success: function(data) {
                console.log(data);
                var totalrecord = data.totalrecord.totalrecord;
                var page = data.page;
                var limit = data.limit;
                var newpage = parseInt(page)+parseInt(limit);
                $('#page').val(newpage);
                if(parseInt(newpage)+parseInt(limit)>=parseInt(totalrecord))
                {
                    $('.loadmoretestimonial').hide();
                }
                $.each(data.testimonial, function( index, value ) {
                    var lidata = $('#testimonialli').html();
                    console.log(value);
                    lidata = lidata.replace("[AUTHOR]",value.author);
                    lidata = lidata.replace("[DESIGNATION]",value.designation);
                    lidata = lidata.replace("[DESCRIPTION]",value.description);
                    lidata = lidata.replace("[DATE]",value.dateformated);
                    $('.testimonialul').append(lidata);
                });

                $('.csrftoken').val(data.token);
                $('.loadmoretestimonial').html('Load More Testimonials');
            }             
        });
    });

    $('#calllogreqform').validate({
        rules:{
            'callScheduleName' : { required : true },
            'callSchedulePhone' : { required : true },
            'callScheduleTime' : { required : true,minDate : true },
        },
        messages:{
            'callScheduleName' : { required : "Please enter name."},
            'callSchedulePhone' : { required : "Please enter phone."},
            'callScheduleTime' : { required : "Please enter call schedule time.", minDate: "Please add future date."},
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    jQuery.validator.addMethod("minDate", function (value, element) {
        var now = new Date();
        var myDate = new Date(value);
        return this.optional(element) || myDate >= now;
    
        // else alert('Das passt nicht!' + mD +  '   ' + nowdate);
    
    });
    $('#calllogreqform').submit(function(e){
        //e.preventDefault();
		if($('#calllogreqform').validate().valid())
		{
            return true;
		}
        return false;
    });

    




});
function closeticket(obj){
    var datadeletehref = $(obj).attr('datadeletehref');
    //alert(datadeletehref);
    $('#deleteModal').find('#delform').attr('action', datadeletehref);
    $('#deleteModal').modal('show');
  }