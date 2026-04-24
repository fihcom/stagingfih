$(function () {
    var accessTokensarr = new Array();
    //var sitepath = $('#sitepath').val();
    $('#userProfile').validate({
        rules:{
            'fname' : { required : true},
            'phone' : { required : true},
        },
        messages:{
            'fname' : { required : "Name is required." },
            'phone' : { required : "Phone is required.", pwcheck: true },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });

    $('#userProfileupdatePassword').validate({
        rules:{
            'old_pass' : { required : true},
            'new_pass' : { required : true, pwcheck:true},
            'confirm_pass' : { required : true, equalTo: '#new_pass'},
        },
        messages:{
            'old_pass' : { required : "Old password is required." }, 
            'new_pass' : { required : "New Password required.", pwcheck: "Password must be minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character." },
            'confirm_pass' : { required : "Confirm password is required.", equalTo: "Password and confirm password are not same." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#verifyIdentitystep1').validate({
        rules:{
            //'username' : { required : '#online:checked'},
            //'dob' : { required : '#online:checked', minDate: '#online:checked' },
            'usernameoffline' : { required : '#offline:checked'},
            'doboffline' : { required : '#offline:checked', dobCheck: '#offline:checked' },
            'IdentrityProofNumber' : { required : '#offline:checked'}
        },
        messages:{
            //'username' : { required : "Name is required." },
            //'dob' : { required : "Date of birth is required.",minDate : "Date of birth cannot be in the future." },
            'usernameoffline' : { required : "Name is required." },
            'doboffline' : { required : "Date of birth is required.",dobCheck : "Date of birth cannot be in the future." },
            'IdentrityProofNumber' : { required : "Identity Proof Number is required." },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $.validator.addMethod("pwcheck",function(value, element) {  
        return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
    });
    jQuery.validator.addMethod("dobCheck", function (value, element) {
        var now = new Date();
        var myDate = new Date(value);
        return this.optional(element) || myDate < now;
    });
    $('input[type=radio][name=verificationTypeFund]').change(function() {
        if($(this).attr('value') == 'online')
        {
            
            if($('#accesstokens').val() !='')
            {
                var obj = JSON.parse($('#accesstokens').val());
                if(jQuery.isEmptyObject(obj))
                {
                    $('#proofoffundsubmitbtn').attr('disabled',true);
                }else{
                    $('#proofoffundsubmitbtn').attr('disabled',false);
                }
            }else{
                $('#proofoffundsubmitbtn').attr('disabled',true);
            }
            
        }else{
            $('#proofoffundsubmitbtn').attr('disabled',false);
        }
    });
    /*$('#verifyidentityunlockbtn').click(function(){
        const client = new Persona.Client({
            templateId: 'tmpl_K4emuwpwxj4pyKMo5BFpgnnZ',
            environment: 'sandbox',
            onLoad: (_error) => client.open(),
            onComplete: inquiryId => {
                // Inquiry completed. Optionally tell your server about it.
                //console.log(`Sending finished inquiry ${inquiryId} to backend`);
                //fetch(`/server-handler?inquiry-id=${inquiryId}`);
                $('#personainquiryId').val(inquiryId);

                $('#verifyIdentitystep1').submit();
            }
        });
    });*/
    $('#verifyidentityunlockbtn').click(function(){
        $('#verifyidentityunlockbtn').attr('disabled',true);
        $('#verifyidentityunlockbtn').html('Loading...');
        const client = new Persona.Client({
            templateId: 'tmpl_DhApX6bWebdQd85887WP7iHX',
            environment: 'production',
            onLoad: (_error) => client.open(),
            onComplete: inquiryId => {
                // Inquiry completed. Optionally tell your server about it.
                //console.log(`Sending finished inquiry ${inquiryId} to backend`);
                //fetch(`/server-handler?inquiry-id=${inquiryId}`);
                $('#personainquiryId').val(inquiryId);

                $('#verifyIdentitystep1').submit();
            },
            onExit: ()=> {
                $('#verifyidentityunlockbtn').attr('disabled',false);
                $('#verifyidentityunlockbtn').html('Verify Your Identity  <i class="fa fa-angle-right" aria-hidden="true"></i>');
            },
        });
    });
    /*$('#verifyidentitybtn').click(function(){
        //$('#verifyIdentitystep1').submit();
        $("#verifyIdentitystep1").valid();
        if($('#verifyIdentitystep1').validate().valid())
        {
            $('#verifyidentitybtn').attr('disabled',true);
            $('#verifyidentitybtn').html('Loading...');
            if($('#online').is(':checked'))
            {
                const client = new Persona.Client({
                    templateId: 'tmpl_K4emuwpwxj4pyKMo5BFpgnnZ',
                    environment: 'sandbox',
                    onLoad: (_error) => client.open(),
                    onComplete: inquiryId => {
                    // Inquiry completed. Optionally tell your server about it.
                    //console.log(`Sending finished inquiry ${inquiryId} to backend`);
                    //fetch(`/server-handler?inquiry-id=${inquiryId}`);
                    $('#personainquiryId').val(inquiryId);
                    $('#verifyIdentitystep1').submit();
                    }
                });
            }else if($('#offline').is(':checked'))
            {
                $('#verifyIdentitystep1').submit();
            }
            
        }
    });*/
    $('#verifyidentitybtn').click(function(){
        //$('#verifyIdentitystep1').submit();
        $("#verifyIdentitystep1").valid();
        if($('#verifyIdentitystep1').validate().valid())
        {
            $('#verifyidentitybtn').attr('disabled',true);
            $('#verifyidentitybtn1').attr('disabled',true);
            $('#verifyidentitybtn').html('Loading...');
            $('#verifyidentitybtn1').html('Loading...');
            
            if($('#online').is(':checked'))
            {
                const client = new Persona.Client({
                    templateId: 'tmpl_DhApX6bWebdQd85887WP7iHX',
                    environment: 'production',
                    onLoad: (_error) => client.open(),
                    onComplete: inquiryId => {
                    // Inquiry completed. Optionally tell your server about it.
                    //console.log(`Sending finished inquiry ${inquiryId} to backend`);
                    //fetch(`/server-handler?inquiry-id=${inquiryId}`);
                    $('#personainquiryId').val(inquiryId);
                    $('#verifyIdentitystep1').submit();
                    }
                });
            }else if($('#offline').is(':checked'))
            {
                $('#verifyIdentitystep1').submit();
            }
            
        }
    });
    $('#verifyidentitybtn1').click(function(){
        //$('#verifyIdentitystep1').submit();
        //console.log('mama');
        $('#online').prop('checked', true);
        $("#verifyIdentitystep1").valid();
        if($('#verifyIdentitystep1').validate().valid())
        {
            $('#verifyidentitybtn').attr('disabled',true);
            $('#verifyidentitybtn1').attr('disabled',true);
            $('#verifyidentitybtn').html('Loading...');
            $('#verifyidentitybtn1').html('Loading...');
            
            //console.log('hehe');
            if($('#online').is(':checked'))
            {
                const client = new Persona.Client({
                    templateId: 'tmpl_DhApX6bWebdQd85887WP7iHX',
                    environment: 'production',
                    onLoad: (_error) => client.open(),
                    onComplete: inquiryId => {
                    // Inquiry completed. Optionally tell your server about it.
                    //console.log(`Sending finished inquiry ${inquiryId} to backend`);
                    //fetch(`/server-handler?inquiry-id=${inquiryId}`);
                    $('#personainquiryId').val(inquiryId);
                    $('#verifyIdentitystep1').submit();
                    },
                    onExit: ()=> {
                        $('#verifyidentitybtn').attr('disabled',false);
                        $('#verifyidentitybtn1').attr('disabled',false);
                        $('#verifyidentitybtn').html('Verify Identity');
                        $('#verifyidentitybtn1').html('Verify Identity Instantly');
                    },
                });
            }else if($('#offline').is(':checked'))
            {
                $('#verifyIdentitystep1').submit();
            }
            
        }
    });
    $('#verifybankbtn').click(function(){
        var sitepath = $('#sitepath').val();
        $('#proofoffundsubmitbtn').attr('disabled',true);
        result = $.post({
            url: $('#sitepath').val()+'createlinktoken',
            type: 'POST'
        },function(result){
            
            const linkHandler = Plaid.create({
            token: result.link_token,
            onSuccess: (public_token, metadata) => {
                var livar = '<li>'+metadata.institution.name+'</li>';
                $('.h3addedbanks').show();
                $('.addedbank').append(livar);
                $.post(sitepath+'getaccesstoken', {
                public_token: public_token,
                },function(data){
                    accessTokensarr.push(data.access_token);
                    //console.log(accessTokensarr);
                    $('#accesstokens').val(accessTokensarr);
                    $('#proofoffundsubmitbtn').attr('disabled',false);
                    $('#proofoffundsubmitbtnmp').attr('disabled',false);
                });
            },
            onExit: (err, metadata) => {
                // Optionally capture when your user exited the Link flow.
                // Storing this information can be helpful for support.
                //console.log(metadata);
                if($('#accesstokens').val() !='')
                {
                    $('#proofoffundsubmitbtn').attr('disabled',false);
                }else{
                    $('#proofoffundsubmitbtn').attr('disabled',true);
                }

            },
            onEvent: (eventName, metadata) => {
                // Optionally capture Link flow events, streamed through
                // this callback as your users connect an Item to Plaid.
                if($('#accesstokens').val() !='')
                {
                    $('#proofoffundsubmitbtn').attr('disabled',false);
                }else{
                    $('#proofoffundsubmitbtn').attr('disabled',true);
                }
            },
            });
            linkHandler.open();
        });
        

        
    });
    $('#reverifyfund').click(function(){
        var dataHref = $(this).data('delete-href');
        $('#deleteModal').find('a#delete').attr('href', dataHref);
        $('#deleteModal').modal('show');
    });
    async function getlinktoken(){
        try {
            result = await $.ajax({
                url: $('#sitepath').val()+'createlinktoken',
                type: 'POST'
            });
            console.log(result);
            return result;
        } catch (error) {
            console.error(error);
        }
    }
    $('#verifyIdentitystep1').submit(function(e){
        //e.preventDefault();
    });
    $('.manualuploadfund').click(function(e){
        //e.preventDefault();
        if ($("input[name='terms']").is(":checked"))
        {
        // it is checked
        $('.tcagree').css('display','none');
        $('#proofoffundform').submit();
        }else{
            //alert('not checked');
            $('.tcagree').css('display','block');
            $('.fancybox-close-small').click();
        }
        
    })
    $('#proofoffundsubmitbtnmp').click(function(e){

        if ($("input[name='terms']").is(":checked"))
        {
        $('.tcagree').css('display','none');
        $('#proofoffundform').submit();
        }else{
            $('.tcagree').css('display','block');
        }
    });
    $('#proofoffundsubmitbtn').click(function(){
        $('#proofoffundform').attr('action');
        $.ajax({
            url: $('#proofoffundform').attr('action'),
            data: $('#proofoffundform').serialize(),
            dataType: 'json', 
            type: 'post',
            beforeSend: function(){
                $("#proofoffundsubmitbtn").html('Loading...');
                $("#proofoffundsubmitbtn").attr('disabled',true);
                $('.varify-bank-popup').addClass("popup-dblock"); 
            },
            success: function(data) {
                var myVar = setInterval(function(){
                    var ajaxURL = $('#sitepath').val()+'chkfundapprove';
                    console.log(ajaxURL);
                    $.post(ajaxURL,$('#proofoffundform').serialize(),function(res){
                        console.log(res);
                        if(res.proof_fund_status == '1'){
                            clearInterval(myVar);
                            if(res.unlockpermission)
                            {
                                $('.csrftoken').attr('value',res.token);
                                $('#uncoverfrm').submit();
                            }else{
                                window.location.reload();
                            }
                            
                        }
                    });
                },5000);
                //console.log(data);
                /*$('.csrftoken').attr('value',data.token);
                //$('#sellbusinessdata').attr('value',data.sellbusiness);
                $(".step1next").attr('disabled',false);
                $(".step1next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                $('#tabarea1').addClass('selected');
                $('#tabarea3').trigger('click');*/
            }             
        });
        //console.log();
        //$('#proofoffundform').submit()
    });
    $('#proofoffundsubmitbtnprofile').click(function(){
        var verificationType = $('input[name="verificationTypeFund"]:checked').val();
        if(verificationType == 'offline')
        {
            $('#proofoffundform').submit()
        }else if(verificationType == 'online')
        {
            var onlineAction = $('#sitepath').val()+'user/proofoffundactiononline';
            $.ajax({
                url: onlineAction,
                data: $('#proofoffundform').serialize(),
                dataType: 'json', 
                type: 'post',
                beforeSend: function(){
                    $("#proofoffundsubmitbtn").html('Loading...');
                    $("#proofoffundsubmitbtn").attr('disabled',true);
                    $('.varify-bank-popup').addClass("popup-dblock"); 
                },
                success: function(data) {
                    var myVar = setInterval(function(){
                        var ajaxURL = $('#sitepath').val()+'chkfundapprove';
                        console.log(ajaxURL);
                        $.post(ajaxURL,$('#proofoffundform').serialize(),function(res){
                            console.log(res);
                            if(res.proof_fund_status == '1'){
                                clearInterval(myVar);
                                if(res.unlockpermission)
                                {
                                    $('.csrftoken').attr('value',res.token);
                                    $('#uncoverfrm').submit();
                                }else{
                                    window.location.reload();
                                }
                                
                            }
                        });
                    },5000);
                    //console.log(data);
                    /*$('.csrftoken').attr('value',data.token);
                    //$('#sellbusinessdata').attr('value',data.sellbusiness);
                    $(".step1next").attr('disabled',false);
                    $(".step1next").html('Next <i class="fa mr-0 fa-long-arrow-right" aria-hidden="true"></i>');
                    $('#tabarea1').addClass('selected');
                    $('#tabarea3').trigger('click');*/
                }             
            });
        }
    });
    $('#proofoffundsubmitbtnoffline').click(function(){
        $('#proofoffundformoffline').submit()
    });

    $('.finaluncover').click(function(){
        //alert('final');
        $('#uncoverfrm').submit();
    });

    $('#upload_digital_signature').on('change', function(){
        if($(this).val().length > 0) {
            $("#uploadDigitalSignBtn").attr('disabled', false);
        } else {
            $("#uploadDigitalSignBtn").attr('disabled', true);
        }
    });

    $(document).on('submit', '#verifyDigitalSignature', function(e){
        var currentEle = $(this);
        var formData = new FormData($(this)[0]);
        console.log(formData);
        $.ajax({
            url: currentEle.attr('action'),
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            type: 'post',
            beforeSend: function(){
                $("#uploadDigitalSignBtn").html('Uploading...');
                $("#uploadDigitalSignBtn").attr('disabled', true);
            },
            success: function(data) {
                if(data.status == true){
                    $("#uploadDigitalSignBtn").html('Upload');
                    $("#uploadDigitalSignBtn").attr('disabled', true);
                    $('#digiSignMsg').html('Signature has been uploaded.');
                }
            }             
        });
        e.preventDefault();
    });

    
  
}); 


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profileimg').show();
            $('#profileimg').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(function(){
    $('.popupBtn').on("click", function () {
        $('.varify-bank-popup').addClass("popup-dblock"); 
    }); 
}); 