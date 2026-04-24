$(document).ready(function() {
    var sitepath = $('#sitepath').val();
    
    $('.replyfaq').click(function(){
        //e.preventDefault();
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $(this).parent().parent().validate({
            rules:{
                'sellerReply' : { required : true }
            },
            messages:{
                'sellerReply' : { required : "Reply is required." }
            },
            highlight: function(element) {
                $(element).removeClass("error");
            }
        });
        $(this).parent().parent().submit();
        if($(this).parent().parent().validate().valid()){
            $.ajax({
                url: $(this).parent().parent().attr('action'),
                data: $(this).parent().parent().serialize(),
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    $('.csrftoken').attr('value',data.dataval.token);
                    if(parseInt(data.errorCode) == 0)
                    {
                        var qid = data.dataval.ret.id;
                        $('#sellerreplytext'+qid).html(data.dataval.ret.seller_reply);
                        $('#sellerreply'+qid).slideDown();
                        $('#replysec'+qid).slideUp();
                    }
                    
                }             
            });

        }else{
            $(this).html('Reply');
            $(this).attr('disabled',false);
        }
    });

    $('.replyform').on('submit',function(e){
        e.preventDefault();
    });
    $('.loadmorereply').click(function(){
        var start = parseInt($('#replystart').val());
        var limit = parseInt($('#replylimit').val());
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $.ajax({
                url: 'user/load_more_seller_reply',
                data: {
                    start: start,
                    limit: limit,
                    csrf_npb_name: $('.csrftoken').val()
                },
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    console.log(data);
                    var newstart = start+limit;
                    $('.loadmorereply').html('Load More Reply');
                    $('.loadmorereply').attr('disabled',false);
                    
                    if(parseInt(newstart)>= parseInt(data.data.totalrecord.totalrecord))
                    {
                        $('.loadmorereply').hide();
                    }
                    
                    $.each(data.data.record, function( index, value ) {
                        var newreply = $('.seller_reply_skeleton').html();
                        if(value.user_profile_pic !='')
                        {
                            var img = ' src="'+sitepath+'uploads/profile_pictures/'+value.user_profile_pic+'"';
                        }else{
                            var img = ' src="'+sitepath+'assets/frontend/images/male.png"';
                        }
                        newreply = newreply.replace("userimage",img);
                        newreply = newreply.replace("[USERNAME]",value.fname);
                        newreply = newreply.replace("[LISTINGNO]",value.listing_id);
                        newreply = newreply.replace("[ALISTINGNO]",value.listing_id);
                        newreply = newreply.replace("[DATEFAQ]",value.faqDate);
                        newreply = newreply.replace("[QUESTION]",value.question);
                        newreply = newreply.replace("[SELLERREPLY]",value.seller_reply);
                        newreply = newreply.replace(/questionid/g,value.id);
                        if(parseInt(value.Status)>0)
                        {
                            newreply = newreply.replace("replyhide",'');
                            newreply = newreply.replace("replypane",'style="display:none"');
                        }else{
                            newreply = newreply.replace("replyhide",'style="display:none"');
                            newreply = newreply.replace("replypane",'');
                        }
                        $('#faqtab').append(newreply);
                    });
                    
                    $('#replystart').val(newstart);
                    $('.csrftoken').attr('value',data.token);
                    
                }             
            });
    });
    $('.loadmorebuyerfaq').click(function(){
        var start = parseInt($('#replystart').val());
        var limit = parseInt($('#replylimit').val());
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $.ajax({
                url: 'user/buyer_faq',
                data: {
                    page: start,
                    limit: limit,
                    csrf_npb_name: $('.csrftoken').val()
                },
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    //console.log(data);
                    
                    var newstart = start+limit;
                    $('.loadmorereply').html('Load More Reply');
                    $('.loadmorereply').attr('disabled',false);
                    
                    if(parseInt(newstart)>= parseInt(data.dataval.ret.totalrecord.totalrecord))
                    {
                        $('.loadmorebuyerfaq').hide();
                    }
                    
                    $.each(data.dataval.ret.record, function( index, value ) {
                        var newreply = $('.seller_reply_skeleton').html();
                        if(value.user_profile_pic !='')
                        {
                            var img = ' src="'+sitepath+'uploads/profile_pictures/'+value.user_profile_pic+'"';
                        }else{
                            var img = ' src="'+sitepath+'assets/frontend/images/male.png"';
                        }
                        newreply = newreply.replace("userimage",img);
                        newreply = newreply.replace("[USERNAME]",value.fname);
                        newreply = newreply.replace("[LISTINGNO]",value.listing_id);
                        newreply = newreply.replace("[ALISTINGNO]",value.listing_id);
                        newreply = newreply.replace("[DATEFAQ]",value.faqDate);
                        newreply = newreply.replace("[QUESTION]",value.question);
                        newreply = newreply.replace("[SELLERREPLY]",value.seller_reply);
                        newreply = newreply.replace(/questionid/g,value.id);
                        if(parseInt(value.Status)>0)
                        {
                            newreply = newreply.replace("replyhide",'');
                            newreply = newreply.replace("replypane",'style="display:none"');
                        }else{
                            newreply = newreply.replace("replyhide",'style="display:none"');
                            newreply = newreply.replace("replypane",'');
                        }
                        $('#faqtab').append(newreply);
                    });
                    
                    $('#replystart').val(newstart);
                    $('.csrftoken').attr('value',data.token);
                    
                }             
            });
    });
    $('.loadmoreoffer').click(function(){
        //alert('hjhh');
        var start = parseInt($('#offerstart').val());
        var limit = parseInt($('#offerlimit').val());
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $.ajax({
                url: sitepath+'user/load_more_offer_request',
                data: {
                    start: start,
                    limit: limit,
                    csrf_npb_name: $('.csrftoken').val()
                },
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    //console.log(data);
                    var newstart = start+limit;
                    $('.loadmoreoffer').html('Load More Offer');
                    $('.loadmoreoffer').attr('disabled',false);
                    
                    if(parseInt(newstart)>= parseInt(data.data.totalrecord.totalrecord))
                    {
                        $('.loadmoreoffer').hide();
                    }
                    
                    $.each(data.data.record, function( index, value ) {
                        var newreply = $('.seller_offer_skeleton').html();
                        if(value.user_profile_pic !='')
                        {
                            var img = ' src="'+sitepath+'uploads/profile_pictures/'+value.user_profile_pic+'"';
                        }else{
                            var img = ' src="'+sitepath+'assets/frontend/images/male.png"';
                        }
                        newreply = newreply.replace("userimage",img);
                        newreply = newreply.replace("[USERNAME]",value.fname);
                        newreply = newreply.replace(/listingnooffer/g,value.listing_id);
                        newreply = newreply.replace("[DATEFAQ]",value.offerDate);
                        newreply = newreply.replace("[PRICE]",data.data.currency.symbol+value.offer_price);
                        if(value.status == 1)
                        {
                            newreply = newreply.replace("[OFFERSTATUS]",'<span class="red">Pending</span>');
                            newreply = newreply.replace("approveofferhide",'');
                        }else if(value.status == 2)
                        {
                            newreply = newreply.replace("[OFFERSTATUS]",'<span class="green">Approved</span>');
                            newreply = newreply.replace("approveofferhide",'style="display:none"');
                        }
                        newreply = newreply.replace("[DATEOFFER]",value.offerDate);
                        newreply = newreply.replace("[SELLERREPLY]",value.offer_description);
                        newreply = newreply.replace(/offerid/g,value.id);
                        if(value.offer_description !='')
                        {
                            newreply = newreply.replace("descriptionofferhide",'');
                            //
                        }else{
                            newreply = newreply.replace("descriptionofferhide",'style="display:none"');
                            //
                        }
                        $('#offerdata').append(newreply);
                    });
                    
                    $('#offerstart').val(newstart);
                    $('.csrftoken').attr('value',data.token);
                    
                }             
            });
    });

    $('.loadmoreofferreqest').click(function(){
        var start = parseInt($('#offerstart').val());
        var limit = parseInt($('#offerlimit').val());
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $.ajax({
                url: sitepath+'user/load_more_offer_request',
                data: {
                    start: start,
                    limit: limit,
                    csrf_npb_name: $('.csrftoken').val()
                },
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    //console.log(data);
                    var newstart = start+limit;
                    $('.loadmoreofferreqest').html('Load More Offer');
                    $('.loadmoreofferreqest').attr('disabled',false);
                    
                    if(parseInt(newstart)>= parseInt(data.data.totalrecord.totalrecord))
                    {
                        //$('.loadmoreofferreqest').hide();
                    }
                    
                    $.each(data.data.record, function( index, value ) {
                        var newreply = $('.seller_offer_skeleton').html();
                        if(value.user_profile_pic !='')
                        {
                            var img = ' src="'+sitepath+'uploads/profile_pictures/'+value.user_profile_pic+'"';
                        }else{
                            var img = ' src="'+sitepath+'assets/frontend/images/male.png"';
                        }
                        newreply = newreply.replace("userimage",img);
                        newreply = newreply.replace("[USERNAME]",value.fname);
                        //newreply = newreply.replace("[LISTINGNO]",value.listing_id);
                        newreply = newreply.replace(/listingnooffer/g,value.listing_id);
                        newreply = newreply.replace("[DATEFAQ]",value.offerDate);
                        newreply = newreply.replace("[PRICE]",data.data.currency.symbol+value.offer_price);
                        if(value.status == 1)
                        {
                            newreply = newreply.replace("[OFFERSTATUS]",'<span class="red">Pending</span>');
                            newreply = newreply.replace("approveofferhide",'');
                        }else if(value.status == 2)
                        {
                            newreply = newreply.replace("[OFFERSTATUS]",'<span class="green">Approved</span>');
                            newreply = newreply.replace("approveofferhide",'style="display:none"');
                        }
                        newreply = newreply.replace("[DATEOFFER]",value.offerDate);
                        newreply = newreply.replace("[SELLERREPLY]",value.offer_description);
                        newreply = newreply.replace(/offerid/g,value.id);
                        if(value.offer_description !='')
                        {
                            newreply = newreply.replace("descriptionofferhide",'');
                            //
                        }else{
                            newreply = newreply.replace("descriptionofferhide",'style="display:none"');
                            //
                        }
                        $('#offerdata').append(newreply);
                    });
                    
                    $('#offerstart').val(newstart);
                    $('.csrftoken').attr('value',data.token);
                    
                }             
            });
    });

    $('.showallnotifications').click(function(){
        $(this).html('Loading...');
        
        var start = parseInt($('#loadmorestart').val());
        var limit = parseInt($('#loadmorelimit').val());
        $.ajax({
            url: sitepath+'user/load_more_user_notification',
            data: {
                page: start,
                limit: limit,
                csrf_npb_name: $('.csrftoken').val()
            },
            dataType: 'json', 
            type: 'post',
            success: function(data) {
                //\console.log(data);
                $('.csrftoken').attr('value',data.token);
                var newstart = start+limit;
                //console.log(data.data.totalrecord.totalrecord);
                //console.log(newstart);
                if(parseInt(newstart)>= parseInt(data.data.totalrecord.totalrecord))
                {
                    $('.showallnotifications').hide();
                }
                $('#loadmorestart').val(newstart);
                
                $.each(data.data.notification, function( index, value ) {
                    var notificationskeleton = $('#notificationskeleton').html();
                    notificationskeleton = notificationskeleton.replace("[NOTIFICATIONTEXT]",value.notification_text);
                    notificationskeleton = notificationskeleton.replace("[NOTIFICATIONDATE]",value.monthFormated);
                    notificationskeleton = notificationskeleton.replace(/NOTIFICATIONID/g,value.id);
                    $('#notificationul').append(notificationskeleton);
                });
                //console.log(data);
                $('.showallnotifications').html('Show More');
            }             
        });
    });
    $('.delnotification').click(function(){
        $('#deletenotificationModal').modal('hide');
        var formaction = $('#delformnotification').attr('action');
        //console.log(formaction);
        $.ajax({
            url: formaction,
            data: {
                csrf_npb_name: $('.csrftoken').val()
            },
            dataType: 'json', 
            type: 'post',
            success: function(data) {
                //console.log(data);
                $('.csrftoken').attr('value',data.token);
                if(data.status)
                {
                    $('#notification'+data.data.id).remove();
                }
            }             
        });
    });
    

    $('#submitbuyFrm').validate({
        rules:{
            wire_transfer_ref : { required : true},
            walletMoney : { required : true, number: true},
        },
        messages:{
            wire_transfer_ref : { required : "Wire Transfer Reference number is required" },
            walletMoney : { required : "Wire Transfer Amount is required", number: "Please enter numeric wallet amount." },
        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
      });

      $('#submitbuyFrm').submit(function(){
          if($('#submitbuyFrm').validate().valid())
          {
                $('#submitbuybtn').html('Loading...');
                $('#submitbuybtn').attr('disabled',true);
          }
        
    });

    $('.submitwallet').click(function(){
        $('.cancelwallet').trigger('click');
        $('#submitbuyFrm').submit();
    });
    $('.submitwalletwithdraw').click(function(){
        $('.cancelwalletwithdraw').trigger('click');
        $('#submitwithdrawFrm').submit();
    });
    $('.publishanswers').click(function(){
        $('#publishanswersModel').modal('hide');
        $('#answerStatus').val(1);
        $('#answerform').submit();
    });

});
function deletenotification(obj){
    //console.log(obj);
    var datadeletehref = $(obj).attr('datadeletehref');
    $('#deletenotificationModal').find('#delformnotification').attr('action', datadeletehref);
    $('#deletenotificationModal').modal('show');
}
function publishanswer(obj){
    $('#publishanswersModel').modal('show');
}
function approveoffer(obj){
    //var bsModal = $.fn.modal.noConflict();
    var dataHref = $(obj).data('href');
    $('#deleteModal').find('form#delform').attr('action', dataHref);
    $('#deleteModal').modal('show');
}
function replyfaq(qid){
    $('.replyfaq'+qid).html('Loading...');
    $('.replyfaq'+qid).attr('disabled',true);
    $('.replyfaq'+qid).parent().parent().validate({
            rules:{
                'sellerReply' : { required : true }
            },
            messages:{
                'sellerReply' : { required : "Reply is required." }
            },
            highlight: function(element) {
                $(element).removeClass("error");
            }
    });
    $('.replyfaq'+qid).parent().parent().submit();
    if($('.replyfaq'+qid).parent().parent().validate().valid()){
        $.ajax({
            url: $('.replyfaq'+qid).parent().parent().attr('action'),
            data: $('.replyfaq'+qid).parent().parent().serialize(),
            dataType: 'json', 
            type: 'post',
            success: function(data) {
                //console.log(data);
                $('.csrftoken').attr('value',data.dataval.token);
                if(parseInt(data.errorCode) == 0)
                {
                    console.log('i am here');
                    var qid = data.dataval.ret.record[0].id;
                    $('#sellerreplytext'+qid).html(data.dataval.ret.record[0].seller_reply);
                    $('#sellerreply'+qid).slideDown();
                    $('#replysec'+qid).slideUp();
                }
                
            }             
        });

    }else{
        $('.replyfaq'+qid).html('Reply');
        $('.replyfaq'+qid).attr('disabled',false);
    }
}
function clicktocopy(element){
    //var text = $(element).html().select();
    //document.execCommand("copy");
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).html()).select();
    document.execCommand("copy");
    $temp.remove();
}