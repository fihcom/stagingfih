//var activebaseLabels = ["JAN 2020","FEB 2020","MAR 2020","APR 2020","MAY 2020","JUN 2020","JUL 2020","AUG 2020","SEP 2020","OCT 2020","NOV 2020","DEC 2020"];
//var activerevdata = [2000,2100,2110,3600,3662,3690,4500,2160,2690,4508,6211,4598];
//var activeprofitdata = [3520,3550,3700,3810,3950,4012,3580,3641,5200,4980,6571,7521];
//var trafficactivebaseLabels = ["JAN 2020","FEB 2020","MAR 2020","APR 2020","MAY 2020","JUN 2020","JUL 2020","AUG 2020","SEP 2020","OCT 2020","NOV 2020","DEC 2020"];
//var activepageviewdata = [2000,2100,2110,3600,3662,3690,4500,2160,2690,4508,6211,4598];
//var activevisitoredata = [3520,3550,3700,3810,3950,4012,3580,3641,5200,4980,6571,7521];
function numberWithCommas(x) {
    //return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    //return x.toString();
    return x.toLocaleString()
}
//console.log("second",activebaseLabels);
if(typeof activebaseLabels == 'undefined')
{
    var activebaseLabels = $('#activebaseLabels').val().split(',');
    var activerevdata = $('#activerevdata').val().split(',');
    var activeprofitdata = $('#activeprofitdata').val().split(',');
}
if(typeof trafficactivebaseLabels == 'undefined')
{
    var trafficactivebaseLabels = $('#trafficactivebaseLabels').val().split(',');
    var activepageviewdata = $('#activepageviewdata').val().split(',');
    var activevisitoredata = $('#activevisitoredata').val().split(',');
}
//console.log("third",$('#testhidden').val().split(','));
//var totalset = activebaseLabels.length;
var totalset = 12;
    var totalRevenue = 0;
    var totalProfit = 0;
    activerevdata.map(d=>{
        totalRevenue = totalRevenue + parseInt(d)
    });

    activeprofitdata.map(p=>{
        totalProfit = totalProfit + parseInt(p)
    });
    $('#totalRevenue').html(numberWithCommas(totalRevenue));
    $('#avgRevenue').html(numberWithCommas(parseInt(totalRevenue/totalset)));

    $('#totalProfit').html(numberWithCommas(totalProfit));
    $('#avgprofit').html(numberWithCommas(parseInt(totalProfit/totalset)));

    //var totalsettraffic = trafficactivebaseLabels.length;
    var totalsettraffic = 12;
    var totalVisitor = 0;
    var totalPageViews = 0;
    activevisitoredata.map(g=>{
        totalVisitor = totalVisitor + parseInt(g)
    });
    activepageviewdata.map(k=>{
        totalPageViews = totalPageViews + parseInt(k)
    });
    $('#totalVisitor').html(numberWithCommas(totalVisitor));
    $('#avgVisitor').html(numberWithCommas(parseInt(totalVisitor/totalsettraffic)));

    $('#totalPageview').html(numberWithCommas(totalPageViews));
    $('#avgPageview').html(numberWithCommas(parseInt(totalPageViews/totalsettraffic)));


    function clicktocopy(element){
        //var text = $(element).html().select();
        //document.execCommand("copy");
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).html()).select();
        document.execCommand("copy");
        $temp.remove();
    }
$(document).ready(function() {
    var sitepath = $('#sitepath').val();
    $('.loadmorefaq').click(function(){
        var start = parseInt($('#faqStart').val());
        var limit = parseInt($('#faqLimit').val());

        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $.ajax({
                url: 'load_more_faq',
                data: {
                    start: start,
                    limit: limit,
                    listing_id: $('#listingNo').val(),
                    csrf_npb_name: $('.csrftoken').val()
                },
                dataType: 'json', 
                type: 'post',
                success: function(data) {
                    //console.log(data);
                    var newstart = start+limit;
                    $('.loadmorefaq').html('Load More');
                    $('.loadmorefaq').attr('disabled',false);
                    
                    if(parseInt(newstart)>= parseInt(data.data.totalrecord.totalrecord))
                    {
                        $('.loadmorefaq').hide();
                    }
                    
                    $.each(data.data.record, function( index, value ) {
                        var newreply = $('.loadfaqskeleton').html();
                        
                        newreply = newreply.replace("[QUESTION]",value.question);
                        newreply = newreply.replace("[SELLERREPLY]",value.seller_reply);
                        $('#loadfaq').append(newreply);
                    });
                    
                    $('#faqStart').val(newstart);
                    $('.csrftoken').attr('value',data.token);
                    
                }             
        });
    });
    $('#submitOfferFrm').validate({
        rules:{
          offerPrice : { required : true, number: true },
          agreement : { required : true},
        },
        messages:{
            offerPrice : { required : "Offer Price is required", number : "Offer Price must be numeric." },
            agreement : { required : "Agreement is required" },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
      });
      $('#submitOfferFrm').submit(function(){
          if($('#submitOfferFrm').validate().valid())
          {
            $('#submitofferbtn').html('Loading...');
            $('#submitofferbtn').attr('disabled',true);
          }
          
      });
      $('#submitbuyFrm').validate({
        rules:{
            wire_transfer_ref : { required : true},
        },
        messages:{
            wire_transfer_ref : { required : "Wire Transfer Reference number is required" },

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
    $('#walletMoney').change(function(){
        if($(this).is(":checked")){
            $('.pricebreakup').slideDown('slow');

        }else{
            $('.pricebreakup').slideUp('slow');
        }
    });
    $('#confirmbuyrequest').click(function(){
        //$('#MarkPayment').css('display','none');
        $(this).html('Loading...');
        $(this).attr('disabled',true);
        $('#submitbuyrequestfrm').submit();
        //alert('here');
    });
});

var fileArr = [];
var i = 0;
var countfile = 0;
var uploadedfile = 0;
var sitepath = $('#sitepath').val();
var myDropzone = new Dropzone("div#myId", 
{ 
    url: "./addbuyrefimage",
    paramName: "file", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    addRemoveLinks: true,
    //maxFiles: 1,
    init: function() {
        var thisDropzone = this;
        
        this.on("success", function(file, responseText) {
            file.previewElement.id = responseText;
            fileArr.push(responseText.data);
            uploadedfile++;
            if(uploadedfile == countfile)
            {
                $('#submitbuybtn').attr('disabled',false);
            }
            //fileArr[file] = responseText;
            $('#imageContents').val(fileArr);
            //console.log(fileArr);
        });
        this.on('addedfile',function(file){
            countfile++;
            $('#submitbuybtn').attr('disabled',true);
        })
        this.on("removedfile", function(file, responseText) {
            //
            var deletedfile = file.previewElement.id;
            var i = 0
            while(i<fileArr.length)
            {
                if(fileArr[i] == deletedfile)
                {
                    fileArr.splice(i,1);
                }
                i++
            }
            $('#imageContents').val(fileArr);
            //console.log(fileArr);
        });
        this.on("error", function(file,responseText) {
            uploadedfile++;
            if(uploadedfile == countfile)
            {
                $('#submitbuybtn').attr('disabled',false);
            }
        });
    }
});