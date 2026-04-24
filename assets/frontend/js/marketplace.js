var sitepath = $('#sitepath').val();
function loadPagination(){
    //console.log($('#siteSettings').serialize());
    $.ajax({
        url: sitepath+'api/marketplace/mplisting',
        data: $('#siteSettings').serialize(),
        dataType: 'json', 
        type: 'post',
        headers: {
            "Authorization": "Basic " + btoa("admin:1234"),
            "X-API-KEY": 'CODEX@123'
        },
        beforeSend: function(){
           
        },
        success: function(data) {
            var totalRecord = data.data.totalrecord.totalrecord;
            //console.log(data);
            //console.log($('#pagelisting').val());
            if(parseInt(totalRecord) === 0 && parseInt($('#pagelisting').val()) === 0)
            {
                $('.dynamic-page').html('No record found.');
            }else if(parseInt(totalRecord) > 0 && parseInt($('#pagelisting').val())===0)
            {
                if((parseInt($('#limitlisting').val())+parseInt($('#pagelisting').val())) >= parseInt(totalRecord))
                {
                    totalRec = totalRecord;
                }else{
                    totalRec = $('#limitlisting').val();
                }
                $('.dynamic-page').html('1-'+totalRec+' of '+totalRecord+' results....');
            }else if(parseInt(totalRecord) > 0 && parseInt($('#pagelisting').val())>0)
            {
                //console.log('here');
                if((parseInt($('#limitlisting').val())+parseInt($('#pagelisting').val())) >= parseInt(totalRecord))
                {
                    totalRec = totalRecord;
                }else{
                    totalRec = $('#limitlisting').val();
                }
                $('.mpul').append('<div class="d-block search-result-txt" style="margin: 0 0 16px 0;">'+$('#pagelisting').val()+'-'+totalRec+' of '+totalRecord+' results....</div>');
                //$('.search-result-txt').html($('#pagelisting').val()+'-'+totalRec+' of '+totalRecord+' results....')
            }
            var newPage = parseInt($('#pagelisting').val())+parseInt($('#limitlisting').val());
            $('#loading').remove();
            //console.log(totalRecord);
            //console.log("page->",$('#pagelisting').val());
            //console.log("limit->",$('#limitlisting').attr('value'));
            //console.log(newPage);
            $('#pagelisting').val(newPage);
            if(newPage >= parseInt(totalRecord))
            {
                $('.loadmoremp').attr('style','display:none');
            }else{
                $('.loadmoremp').attr('style','display:block');
            }
            
            $.each(data.data.listing, function( index, value ) {

                var mpelement = $('#mpelement').html();
                //console.log('here');
                if(parseInt(value.Status) == 4 && parseInt(value.buyer) >0 )
                {
                    if(value.buyer == $('#loggedUser').val())
                    {
                        mpelement = mpelement.replace("[SOLD]",'<div class="sold2">Congrats <span>You won this listing!</span></div>');
                    }else if(value.seller == $('#loggedUser').val())
                    {
                        mpelement = mpelement.replace("[SOLD]",'<div class="sold2">Congrats <span>This listing as sold!</span></div>');
                    }else{
                        mpelement = mpelement.replace("[SOLD]",'<div class="sold">sold</div>');
                    }
                }else{
                    mpelement = mpelement.replace("[SOLD]",'');
                }
                if(value.unlocked === true){
                    mpelement = mpelement.replace("[lock]",'');
                    mpelement = mpelement.replace("[IMAGEURL]",'uploads/business_image/'+value.business_image);
                }else{
                    mpelement = mpelement.replace("[lock]",'class="lock"');
                    mpelement = mpelement.replace("[IMAGEURL]",'assets/frontend/images/sample/banner.jpg');
                }
                mpelement = mpelement.replace("[COUNTRYNAME]",'<i class="fa fa-map-marker" aria-hidden="true"></i>'+value.countryname);
                mpelement = mpelement.replace(/LISTINGID/g,value.listing_id);
                mpelement = mpelement.replace("[MULTIPLE]",value.multiple);
                mpelement = mpelement.replace("[PRICE]",value.price);
                mpelement = mpelement.replace("[INDUSTRY]",value.industryname);
                mpelement = mpelement.replace("[TRAFFIC]",value.traffic_per_month);
                if(value.monetizationStr === null)
                {
                    mpelement = mpelement.replace("[MONETIZATION]",' ');
                }else{
                    mpelement = mpelement.replace("[MONETIZATION]",value.monetizationStr.substring(0, 70)+' ...');
                }
                
                mpelement = mpelement.replace("[SITEAGE]",value.business_age);
                mpelement = mpelement.replace("[NETPROFIT]",value.monthly_profit);
                mpelement = mpelement.replace("[REVENUE]",value.monthly_revenue);
                //newreply = newreply.replace("[SELLERREPLY]",value.seller_reply);
                $('.mpul').append(mpelement);
            });
            $('.loadmoremp').html('Load More');

        }             
    });
}
$(function () {
    $('#mpMonitization').change(function(){
        $('.mpul').html('<li id="loading">Loading...</li>');
        $('#pagelisting').val(0);
        //$('#limitlisting').val(1);
        //var monitization = $(this).val();
        loadPagination();
    });
    $('#profitFrom').change(function(){
        var submit = false;
        if($(this).val() == 'less10'){
            $('#ProfitTo').val('');
            submit = true;
            $('#errprofitTo').hide;
            $('#errprofitFrom').hide();
        }else{
            if($('#ProfitTo').val() ==='')
            {
                var err ='Please select max range.';
                $('#errprofitTo').html(err);
                $('#errprofitTo').show();
                $('#errprofitFrom').hide();
            }else if($('#ProfitTo').val() !=='' && parseInt($(this).val())>=parseInt($('#ProfitTo').val()))
            {
                var err ='Price to should be greater than price from.'
                $('#errprofitTo').html(err);
                $('#errprofitTo').show();
                $('#errprofitFrom').hide();
            }else{
                $('#errprofitTo').hide()
                $('#errprofitFrom').hide()

                submit = true;
            }
        }
        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>');
            $('#pagelisting').val(0);
            loadPagination();
        }
    });
    $('#ProfitTo').change(function(){
        var submit = false;
        if($(this).val() == '100more'){
            $('#profitFrom').val('');
            submit = true;
            $('#errprofitTo').hide();
            $('#errprofitFrom').hide();
        }else{
            //console.log('here')
            //console.log($('#profitFrom').val())
            if($('#profitFrom').val() ==='')
            {
                var err ='Please select min range.';
                $('#errprofitFrom').html(err);
                $('#errprofitFrom').show();
                $('#errprofitTo').hide();
            }else if($('#profitFrom').val() !=='' && parseInt($(this).val())<=parseInt($('#profitFrom').val()))
            {
                var err ='Price from should be less than price from.'
                $('#errprofitFrom').html(err);
                $('#errprofitFrom').show();
                $('#errprofitTo').hide();
            }else{
                $('#errprofitTo').hide();
                $('#errprofitFrom').hide();
                submit = true;
            }
        }

        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });

    $('#RevenueFrom').change(function(){
        var submit = false;
        if($(this).val() == 'less10'){
            $('#RevenueTo').val('');
            submit = true;
            $('#errrevenueTo').hide()
            $('#errrevenueFrom').hide()
        }else{
            if($('#RevenueTo').val() =='')
            {
                var err ='Please select max range.'
                $('#errrevenueTo').html(err)
                $('#errrevenueTo').show()
                $('#errrevenueFrom').hide()
            }else if($('#RevenueTo').val() !='' && parseInt($(this).val())>=parseInt($('#RevenueTo').val()))
            {
                var err ='Revenue to should be greater than price from.'
                $('#errrevenueTo').html(err)
                $('#errrevenueTo').show()
                $('#errrevenueFrom').hide()
            }else{
                $('#errrevenueTo').hide()
                $('#errrevenueFrom').hide()

                submit = true;
            }
        }
        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });
    $('#RevenueTo').change(function(){
        var submit = false;
        if($(this).val() == '100more'){
            $('#RevenueFrom').val('');
            submit = true;
            $('#errrevenueTo').hide()
            $('#errrevenueFrom').hide()
        }else{
            //console.log('here')
            //console.log($('#profitFrom').val())
            if($('#RevenueFrom').val() =='')
            {
                var err ='Please select min range.'
                $('#errrevenueFrom').html(err)
                $('#errrevenueFrom').show()
                $('#errrevenueTo').hide()
            }else if($('#RevenueFrom').val() !='' && parseInt($(this).val())<=parseInt($('#RevenueFrom').val()))
            {
                var err ='Revenue from should be less than revenue from.'
                $('#errrevenueFrom').html(err)
                $('#errrevenueFrom').show()
                $('#errrevenueTo').hide()
            }else{
                $('#errrevenueTo').hide()
                $('#errrevenueFrom').hide()
                submit = true;
            }
        }

        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });

    $('#RevenueFrom').change(function(){
        var submit = false;
        if($(this).val() == 'less10'){
            $('#RevenueTo').val('');
            submit = true;
            $('#errrevenueTo').hide()
            $('#errrevenueFrom').hide()
        }else{
            if($('#RevenueTo').val() =='')
            {
                var err ='Please select max range.'
                $('#errrevenueTo').html(err)
                $('#errrevenueTo').show()
                $('#errrevenueFrom').hide()
            }else if($('#RevenueTo').val() !='' && parseInt($(this).val())>=parseInt($('#RevenueTo').val()))
            {
                var err ='Revenue to should be greater than price from.'
                $('#errrevenueTo').html(err)
                $('#errrevenueTo').show()
                $('#errrevenueFrom').hide()
            }else{
                $('#errrevenueTo').hide()
                $('#errrevenueFrom').hide()

                submit = true;
            }
        }
        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });
    $('#RevenueTo').change(function(){
        var submit = false;
        if($(this).val() == '100more'){
            $('#RevenueFrom').val('');
            submit = true;
            $('#errrevenueTo').hide()
            $('#errrevenueFrom').hide()
        }else{
            //console.log('here')
            //console.log($('#profitFrom').val())
            if($('#RevenueFrom').val() =='')
            {
                var err ='Please select min range.'
                $('#errrevenueFrom').html(err)
                $('#errrevenueFrom').show()
                $('#errrevenueTo').hide()
            }else if($('#RevenueFrom').val() !='' && parseInt($(this).val())<=parseInt($('#RevenueFrom').val()))
            {
                var err ='Revenue from should be less than revenue from.'
                $('#errrevenueFrom').html(err)
                $('#errrevenueFrom').show()
                $('#errrevenueTo').hide()
            }else{
                $('#errrevenueTo').hide()
                $('#errrevenueFrom').hide()
                submit = true;
            }
        }

        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });

    $('#MultipleFrom').change(function(){
        var submit = false;
        if($(this).val() == 'less10'){
            $('#MultipleTo').val('');
            submit = true;
            $('#errmultipleTo').hide()
            $('#errmultipleFrom').hide()
        }else{
            if($('#MultipleTo').val() =='')
            {
                var err ='Please select max range.'
                $('#errmultipleTo').html(err)
                $('#errmultipleTo').show()
                $('#errmultipleFrom').hide()
            }else if($('#MultipleTo').val() !='' && parseInt($(this).val())>=parseInt($('#MultipleTo').val()))
            {
                var err ='Multiple to should be greater than multiple from.'
                $('#errmultipleTo').html(err)
                $('#errmultipleTo').show()
                $('#errmultipleFrom').hide()
            }else{
                $('#errmultipleTo').hide()
                $('#errmultipleFrom').hide()

                submit = true;
            }
        }
        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });

    $('#MultipleTo').change(function(){
        var submit = false;
        if($(this).val() == '100more'){
            $('#MultipleFrom').val('');
            submit = true;
            $('#errmultipleTo').hide()
            $('#errmultipleFrom').hide()
        }else{
            //console.log('here')
            //console.log($('#profitFrom').val())
            if($('#MultipleFrom').val() =='')
            {
                var err ='Please select min range.'
                $('#errmultipleFrom').html(err)
                $('#errmultipleFrom').show()
                $('#errmultipleTo').hide()
            }else if($('#MultipleFrom').val() !='' && parseInt($(this).val())<=parseInt($('#MultipleFrom').val()))
            {
                var err ='Multiple from should be less than multiple to.'
                $('#errmultipleFrom').html(err)
                $('#errmultipleFrom').show()
                $('#errmultipleTo').hide()
            }else{
                $('#errmultipleTo').hide()
                $('#errmultipleFrom').hide()
                submit = true;
            }
        }

        if(submit){
            $('.mpul').html('<li id="loading">Loading...</li>')
            $('#pagelisting').val(0);
            loadPagination();
        }
    });



    $('#businessAge').change(function(){
        $('.mpul').html('<li id="loading">Loading...</li>')
        $('#pagelisting').val(0);
        //$('#limitlisting').val(1);
        //var monitization = $(this).val();
        loadPagination();
    });
    function delay(callback, ms) {
        var timer = 0;
        return function() {
          var context = this, args = arguments;
          clearTimeout(timer);
          timer = setTimeout(function () {
            callback.apply(context, args);
          }, ms || 0);
        };
    }
    $('#searchText').keyup(delay(function (e) {
        //console.log('Time elapsed!', this.value);
        $('.mpul').html('<li id="loading">Loading...</li>')
        $('#pagelisting').val(0);
        //$('#limitlisting').val(20);
        //var monitization = $(this).val();
        loadPagination();
      }, 500));
    
    $('.loadmoremp').click(function(){
        $(this).html('Loading...');
        loadPagination();
    });
    $('#advsrchlink').click(function(){
        $('.advsearch').slideToggle();
        //alert($('#advsrchlink').html());
        if($('#advsrchlink').html() == 'Advanced search')
        {
            $('#advsrchlink').html('Hide Advanced Search');
        }else{
            $('#advsrchlink').html('Advanced search');
        }
    });
})