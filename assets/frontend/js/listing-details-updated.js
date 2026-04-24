function createSignatureElement(){
    var offCanvas = document.createElement('canvas');
    var ctx = offCanvas.getContext("2d");
    offCanvas.width = 200;
    offCanvas.height= 100;
    var printText = typeof fullNameSign !== 'undefined' ? fullNameSign  : '';
    var ImageURL = getImageByTextOnCanvas(offCanvas, ctx, printText, "Arial", 80);

    return ImageURL;
}
function getImageByTextOnCanvas(canvas, ctx, text, fontface, yPosition) {

    // start with a large font size
    var fontsize = 300;

    // lower the font size until the text fits the canvas
    do {
        fontsize--;
        ctx.font = "italic bold "+fontsize+"px "+fontface;
        // ctx.font = "italic bold 40px Courier";
    } while (ctx.measureText(text).width > canvas.width)
    // ctx.font = "20px Pacifico, cursive";

    // draw the text
    ctx.fillText(text, 0, yPosition);

    var getImage = canvas.toDataURL("image/png");
    // document.getElementById('theCanvasImage').src = getImage;

    // alert("A fontsize of " + fontsize + "px fits this text on the canvas");
    return getImage;
}



$(document).ready(function() {
    $('#reqfinancingfrm').validate({
        rules:{
            Email : { required : true, email: true },
            Phone : { required : true},
        },
        messages:{
            Email : { required : "Email is required", email : "Please enter a valid email address." },
            Phone : { required : "Phone is required" },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#becomeceofrm').validate({
        rules:{
            Email : { required : true, email: true },
            Phone : { required : true},
            LinkedInProfile : { required : true},
        },
        messages:{
            Email : { required : "Email is required", email : "Please enter a valid email address." },
            Phone : { required : "Phone is required" },
            LinkedInProfile : { required : "LinkedIn Profile is required" },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#reqfinancingfrm').submit(function(e){
        e.preventDefault();
        //console.log($('#reqfinancingfrm').attr('action'));
        if($('#reqfinancingfrm').valid()) {
            $.ajax({
                url: $('#reqfinancingfrm').attr('action'),
                data: $('#reqfinancingfrm').serialize(),
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    //console.log(data);
                    //console.log(data.response.message.Phone);
                    if(data.response.status)
                    {
                        $('.successmessagefinancing').attr('style','display:block');
                        $('.errormessagefinancing').attr('style','display:none');
                        $('#successmessagefinancing').html(data.response.message);
                    }else{

                        $('.errormessagefinancing').attr('style','display:block');
                        $('.successmessagefinancing').attr('style','display:none');
                        $.each(data.response.message, function(key,value) {
                            if(value !=''){
                                $('#errormessagefinancing').append('<li>'+value+'</li>');
                            }
                        });
                    }
                    $('.csrftoken').val(data.token);
                }             
            });
        }
    });
      
    $('#becomeceofrm').submit(function(e){
        e.preventDefault();
        //console.log($('#reqfinancingfrm').attr('action'));
        if($('#becomeceofrm').valid()) {
            $.ajax({
                url: $('#becomeceofrm').attr('action'),
                data: $('#becomeceofrm').serialize(),
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    $('#SubmitLendingOffer').html('Loading...');
                    $('#SubmitLendingOffer').attr('disabled',true);
                    // if(data.response.status)
                    // {
                    //     $('.successmessageceo').attr('style','display:block');
                    //     $('#successmessageceo').html(data.response.message);
                    //     $('.errormessageceo').attr('style','display:none');
                    // }else{

                    //     $('.errormessageceo').attr('style','display:block');
                    //     $('.successmessageceo').attr('style','display:none');
                    //     $.each(data.response.message, function(key,value) {
                    //         if(value !=''){
                    //             $('#errormessageceo').append('<li>'+value+'</li>');
                    //         }
                    //     });
                    // }
                    // $('#SubmitLendingOffer').html('Submit Lending Offer');
                    // $('#SubmitLendingOffer').attr('disabled',false);
                    $('.csrftoken').val(data.token);
                }             
            });
        }
    });
    $('#lendingfrm').validate({
        rules:{
            money_lending : { required : true},
            yearly_interest : { required : true},
            loan_term : { required : true},
            name : { required : true},
            email : { required : true, email: true },
            phone : { required : true},
        },
        messages:{
            email : { required : "Email is required", email : "Please enter a valid email address." },
            phone : { required : "Phone is required" },
            name : { required : "Full name is required" },
            loan_term : { required : "Loan term is reqired" },
            yearly_interest : { required : "Yearly interest is reqired" },
            money_lending : { required : "Amount of money for lending is reqired" },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
    });
    $('#lendingfrm').submit(function(e){
        e.preventDefault();
        if($('#lendingfrm').valid()) {
            $.ajax({
                url: $('#lendingfrm').attr('action'),
                data: $('#lendingfrm').serialize(),
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    console.log(data);
                    if(data.response.status)
                    {
                        $('.successmessagelending').attr('style','display:block');
                        $('#successmessagelending').html(data.response.message);
                        $('.errormessagelending').attr('style','display:none');
                    }else{

                        $('.errormessagelending').attr('style','display:block');
                        $('.successmessagelending').attr('style','display:none');
                        $.each(data.response.message, function(key,value) {
                            if(value !=''){
                                $('#errormessagelending').append('<li>'+value+'</li>');
                            }
                        });
                    }
                    $('.csrftoken').val(data.token);
                }             
            });
        }
    });


    // NDA Sign Form Ajax Checking
    $('.finaluncover').click(function(){
        //alert('final');
        var onlineAction = $('#sitepath').val()+'user/checkSignatureUploaded';
        var csrfData = $('#uncoverCSRF');
        $.ajax({
            url: onlineAction,
            type: 'POST',
            data: csrfData.attr('name')+"="+csrfData.val(),
            dataType:'JSON',
            success: function(data) {
                // Regenerate CSRF Token
                $('#uncoverCSRF').attr('name', data.csrfName);
                $('#uncoverCSRF').val(data.csrfVal);
                if(data.ret == 1){
                    $('.nda_content_area').children('.panel-nda-alert').remove();
                    // $('#uncoverfrm').submit();
                } else {
                    var signatureEleData = createSignatureElement();
                    $('#uncoverfrm').find('input[name="hidden_image_sign"]').val(signatureEleData);
                    // $('.nda_content_area').append('<p class="panel-nda-alert alert alert-danger">Digital Signature is not uploaded, Please upload it in profile section.</p>');
                    // return false;
                }
                $('#uncoverfrm').submit();
            }             
        });
    });

    /*$(document).on('submit', '#uncoverfrm', function(e){
        e.preventDefault();
        // Just a random check to determine if Digital Signature is uploaded or not
        
    });*/
});