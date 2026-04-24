(function($) {
  "use strict"; // Start of use strict
  // Configure tooltips for collapsed side navigation
  var sitepath = $('#sitepath').val();
  $(document).on('click', '.deleteRow', function(){
    var dataHref = $(this).data('delete-href');
    var dataType = $(this).data('type');

    $('#deleteModal').find('a#delete').attr('href', dataHref);
    $('#deleteModal').modal('show');
  });
  // Toggle the side navigation
  $("#sidenavToggler").click(function(e) {
    e.preventDefault();
    $("body").toggleClass("sidenav-toggled");
    $(".navbar-sidenav .nav-link-collapse").addClass("collapsed");
    $(".navbar-sidenav .sidenav-second-level, .navbar-sidenav .sidenav-third-level").removeClass("show");
  });
  $('.addasset').click(function(){
    $('.addassetpane').slideDown('slow');
  });
  $('.addcommissionbtn').click(function(){
    $('.addcommissionpane').slideDown('slow');
  });


  $('.cancelvideoadd').click(function(){
    $('.addassetpane').slideUp('slow');
  });

  $('.cancelcommissionadd').click(function(){
    $('.addcommissionpane').slideUp('slow');
  });
  $('.addyear').click(function(){
    $('.addyearpane').slideDown('slow');
  });
  $('.canceladdyear').click(function(){
    $('.addyearpane').slideUp('slow');
  });

  $('#addmoreotherinfo').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="Title[]" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="value[]" placeholder="Value" value=""></div></div>';
    $('#lastotheroption').append(moreInfoHtml);
  });
  $('#addmorebuyerprofile').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="buyerTitle[]" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="buyervalue[]" placeholder="Value" value=""></div></div>';
    $('#lastbuyerprofile').append(moreInfoHtml);
    
  });
  $('#addmoreytvideo').click(function(){
    var moreInfoHtml = '<div class="form-group"><input type="text" class="form-control" name="youtube_url[]" placeholder="Youtube Video URL" value=""></div>';
    $('#youtubepane').append(moreInfoHtml);
  });
  $('#addmorethreat').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Threats[]" placeholder="Threats" value=""></div></div>';
    $('#threatsoptions').append(moreInfoHtml);
  });
  $('#addmoreweakness').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Weakness[]" placeholder="Weakness" value=""></div></div>';
    $('#weaknessoptions').append(moreInfoHtml);
  });
  $('#addmoreopertunities').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Opertunities[]" placeholder="Opertunities" value=""></div></div>';
    $('#opertunitiesoptions').append(moreInfoHtml);
  });
  $('#addmorestrength').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="strength[]" placeholder="Strength" value=""></div></div>';
    $('#strengthoptions').append(moreInfoHtml);
  });
  $('#addmoreskill').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="skill[]" placeholder="Work & Skills" value=""></div></div>';
    $('#worlskillpane').append(moreInfoHtml);
  });
  $('#addmoresocialmedia').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Extra Social Media</label><input type="text" class="form-control" name="extrasocialmedia[]" placeholder="Social media link" value=""></div></div>';
    $('#socialmedialinks').append(moreInfoHtml);
  });
  $('#addmoreseodata').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="seoTitle[]" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="seoValue[]" placeholder="Value" value=""></div></div>';
    $('#lastseodata').append(moreInfoHtml);
  });

  $('.editavg').click(function(){
    //alert($(this).data('id'));
    $('.alert-success').attr('style','display: none');
    var nfl = '#nfl_avg_'+$(this).data('id');
    var cfl = '#cfl_avg_'+$(this).data('id');
    var datapost = {
      csrf_instantscouting_name : $('.leaguecsrf').val(),
      nfl:  $(nfl).val(),
      cfl:  $(cfl).val(),
      id: $(this).data('id')
    }
    //console.log(datapost);
    $.ajax({
      url: sitepath+'administrator/updatenflcflavg',
      method: "post",
      data: datapost,
      dataType: "json",
      success: function(data){
        //console.log(data);
        $('.leaguecsrf').val(data.token)
        $('.alert-success').attr('style','display:');
      }
    });
  });
  $('#AddEarning').validate({
    rules:{
      calendarYear : { required : true },
    },
    messages:{
      calendarYear : { required : "Calendar year is required" },
    },
    highlight: function(element) {
        $(element).removeClass("error");
    }
  });
  $('#AddCommission').validate({
    rules:{
      //priceFrom : { required : true, number: true },
      //priceTo : { required : true, number: true },
      percentage : { required : true, number: true, min: 0.01 },
    },
    messages:{
      //priceFrom : { required : "Price From is required",number: "Price From should be numeric" },
      //priceTo : { required : "Price To is required",number: "Price To should be numeric" },
      percentage : { required : "Commission percentage is required",number: "Commission percentage should be numeric",min: "Commission percentage should be more than zero" },
    },
    highlight: function(element) {
        $(element).removeClass("error");
    }
  });
  $(".dragtablecmspages").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: sitepath+'administrator/cms-pages/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
  $(".dragtable").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: 'partners/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
  $(".dragtablecurated").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: 'curated-content/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
  $(".dragtabletestimonial").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: 'testimonials/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
  $(".dragtablevaluationquestion").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: 'valuation_questions/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
$(".dragtablebanner").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      //console.log(debugStr);
      $.ajax({
        url: 'headerbanner/swap?pageId='+debugStr,
        method: "get",
        data: "pageId:"+debugStr,
        dataType: "json",
        success: function(data){
          //console.log(data);
        }
      });
      //console.log(debugStr);
      //$('#debugArea').html(debugStr);
      //https://isocra.com/2008/02/table-drag-and-drop-jquery-plugin/
  }
  });
  $(".change-user-pic").click(function(){
    $("#profile_pic_image").hide();
    $("#dropzone").show();
    $("#dropzone").trigger('click');
  });

  $(".change-pic-buyer").click(function(){
    $("#pic-buyer").hide();
    $("#buyer").show();
    $("#buyer").trigger('click');
  });
  
  $(".change-pic-seller").click(function(){
    $("#pic-seller").hide();
    $("#seller").show();
    $("#seller").trigger('click');
  });

  $(".change-pic-general").click(function(){
    $("#pic-general").hide();
    $("#general").show();
    $("#general").trigger('click');
  });
  // $("#browsebtn").click(function(e) {
  //   e.preventDefault();
  //   //alert("here");
  //   $("input[id='browseImage']").click();
  // });
  $('#userProfile').validate({
    rules:{
        'fname' : { required : true},
    },
    messages:{
        'fname' : { required : "Name is required." },
    },
    highlight: function(element) {
        $(element).removeClass("error");
    }
});
$('.approvebtn').click(function(){
  $('#fundapprovefrm').submit();
});
$('#addbank').click(function(){
  //offlinebanks.
  var banktab = '<div class="col-md-6"><div class="form-group"><input type="text" class="form-control" name="banks[]" value="" placeholder="Bank Name" id=""></div></div><div class="col-md-6"><div class="form-group"><input type="text" class="form-control" name="availableBal[]" placeholder="Available Balance" value="" id=""></div></div>';
  $('#offlinebanks').append(banktab);
});
$('#approvesaveidentity').click(function(){
  //alert('ddd');
  $('#saveapprovefrm').submit();
});
$('.approveadmin').click(function(){
  //alert('ddd');
  $('#proofoffundformadmin').submit();
});
const characters = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()";
function generateString(length) {
  let result = ' ';
  const charactersLength = characters.length;
  for ( let i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }

  return result.trim();
}
$('#generatepassword').click(function(){
  //alert('kk');
  var str = generateString(8);
  $('#passInput').val(str);
});
})(jQuery); // End of use strict
//tab====================
/*(function(){
	var d = document,
		tabs = d.querySelector('.tabs'),
		tab = d.querySelectorAll('li'),
		contents = d.querySelectorAll('.content');
	tabs.addEventListener('click', function(e) {
		if (e.target && e.target.nodeName === 'LI') {
		// change tabs
		for (var i = 0; i < tab.length; i++) {
			tab[i].classList.remove('active');
		}
		e.target.classList.toggle('active');


		// change content
		for (i = 0; i < contents.length; i++) {
			contents[i].classList.remove('active');
		}
		
		var tabId = '#' + e.target.dataset.tabId;
d.querySelector(tabId).classList.toggle('active'); 
		}  
	});
})();*/
//===============end tab
function updateshowinfront(obj){
  var userId = $(obj).attr('user');
  //alert(userId);
  if($(obj).prop("checked") == true){
    var show = 1;
  }
  else if($(obj).prop("checked") == false){
      var show = 0;
  }
  var datasent = {
    usreid: userId,
    showfront: show,
    csrf_instantscouting_name: $('.athletecsrf').val()
  }
  $.ajax({
    url: 'administrator/updateshowathleteinfront',
    method: "post",
    data: datasent,
    dataType: "json",
    success: function(data){
      console.log(data);
      console.log(datasent);
      //if(data.datasuccess){}
      $('.athletecsrf').val(data.token)
    }
  });
}
function deleterecord(obj){
  var datadeletehref = $(obj).attr('datadeletehref');
  //alert(datadeletehref);
  $('#deleteModal').find('#delform').attr('action', datadeletehref);
  $('#deleteModal').modal('show');
}
function approverecord(obj){
  //var datadeletehref = $(obj).attr('datadeletehref');
  //alert(datadeletehref);
  //$('#approveModal').find('#delform').attr('action', datadeletehref);
  $('#approveModal').modal('show');
}
function approvefund(obj){
  //var datadeletehref = $(obj).attr('datadeletehref');
  //alert(datadeletehref);
  //$('#deleteModal').find('#delform').attr('action', datadeletehref);
  $('#approvefundModal').modal('show');
}
function rejectrecord(obj){
  var datadeletehref = $(obj).attr('datadeletehref');
  $('#rejectModal').find('#rejectform').attr('action', datadeletehref);
  $('#rejectModal').modal('show');
}

function editrecord(obj){
  var dataId = $(obj).data('id');
  $('#editModal'+dataId).modal('show');
}
$('#siteSettings').validate({
  rules:{
    site_title : { required : true },
    currency : { required : true },
    paypalemail : { required : true, email: true },
    wire_transfer_details : { required : true },
    helpline_no : { required : true },
    helpline_email_address : { required : true, email: true },
  },
  messages:{
    site_title : { required : "Site Title is required" },
    currency : { required : "Currency is required" },
    wire_transfer_details : { required : "Wire transfer Details is required"},
    helpline_no : { required : "Helpline No. is required" },
    paypalemail : { required : "PayPal Email Address is required",email: "Please enter a valid PayPal email address." },
    helpline_email_address : { required : "Helpline Email Address.. is required",email: "Please enter a valid helpline email address." },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});

$('#homeContents').validate({
  rules:{
    site_title1 : { required : true },
    description1 : { required : true },
    site_title2 : { required : true },
    description2 : { required : true },
    site_title3 : { required : true },
    description3 : { required : true },
  },
  messages:{
    site_title1 : { required : "Title is required" },
    description1 : { required : "Description is required" },
    site_title2 : { required : "Title is required"},
    description2 : { required : "Description is required" },
    site_title3 : { required : "Title is required" },
    description3 : { required : "Description is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});

$('#curatedContentFrm').validate({
  rules:{
    title : { required : true },
    description : { required : true },
    imageContents : { required : true },
    author : { required : true },
  },
  messages:{
    title : { required : "Title is required" },
    description : { required : "Description is required" },
    imageContents : { required : "Image is required" },
    author : { required : "Author is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
$('#testimonialFrm').validate({
  rules:{
    desingation : { required : true },
    author : { required : true },
  },
  messages:{
    desingation : { required : "Designation is required" },
    author : { required : "Author is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
$('#freedownloadfrm').validate({
  rules:{
    title : { required : true },
    description : { required : true },
    imageContents : { required : true },
    downloadLink : { required : true },
  },
  messages:{
    title : { required : "Title is required" },
    description : { required : "Description is required" },
    imageContents : { required : "Image is required" },
    downloadLink : { required : "Download Link is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});

$('#valuationaddfrm').validate({
  rules:{
    question : { required : true },
    low_range : { required : true, number: true },
    high_range : { required : true, number: true },
    worth : { required : true, number: true },
  },
  messages:{
    question : { required : "Question is required" },
    low_range : { required : "Range From is required",number: "Range From must be numeric" },
    high_range : { required : "Range To is required",number: "Range To must be numeric" },
    worth : { required : "Worth is required",number: "Worth must be numeric" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});



$('#AddEditAdvisory').validate({
  rules:{
    AdvName : { required : true },
    AdvDescription : { required : true },
  },
  messages:{
    AdvName : { required : "Advisory Name is required" },
    AdvDescription : { required : "Description is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
$('#AddEditBlogCategory').validate({
  rules:{
    blogCatName : { required : true },
    blogStatus :  { required : true },
  },
  messages:{
    blogCatName : { required : "Blog Category Name is required" },
    blogStatus :  { required : "Status is required" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});

$('#promoCodeFrm').validate({
  rules:{
    codeTitle : { required : true },
    amount :  { required : true, number:true,amtcheck:true },
  },
  messages:{
    codeTitle : { required : "Code Title is required" },
    amount :  { required : "Amount is required", number: "Amount must be numeric.",amtcheck: "Discount Percentage should be max 100%" },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
$.validator.addMethod("amtcheck",function(value, element) {  
  if($('#discountType').val() == 'Percentage' && value>100)
  return false;
  else
  return true;
});
$('#subadminaddfrm').validate({
  rules:{
    fname : { required : true },
    email :  { required : true, email:true},
    password :  { required : true, pwcheck: true},
    conpassword :  { required : true, equalTo: '#password'},
  },
  messages:{
    fname : { required : "First name is required." },
    email :  { required : "Email is required.", email: "Please provide a valid email address." },
    password :  { required : "Password is required", pwcheck: "Password must be minimum eight characters, at least one uppercase letter, one lowercase letter, one number and one special character." },
    conpassword :  { required : "Confirm Password is required", equalTo: "Password and confirm password are not same." },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
$('#subadmineditfrm').validate({
  rules:{
    fname : { required : true },
    email :  { required : true, email:true},
  },
  messages:{
    fname : { required : "First name is required." },
    email :  { required : "Email is required.", email: "Please provide a valid email address." },
  },
  highlight: function(element) {
      $(element).removeClass("error");
  }
});
/*function passwordchecking(){
  if(parseInt($('#subadminId').val())>0 && ($('#password').val() !='' || $('#conpassword').val() !=''))
  {
    return true;
  }
  if(parseInt($('#subadminId').val())>0)
  {
    return false;
  }
  return true;
}*/
$.validator.addMethod("pwcheck",function(value, element) {  
  if(passwordchecking())
  {
    return /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/.test(value);
  }else{
    return true;
  }
  
});
/*
$('#user').change(function(){
  var chkStatus = $(this).prop('checked');
  $('#user_list').prop('checked',chkStatus);
  $('#user_edit').prop('checked',chkStatus);
  $('#user_delete').prop('checked',chkStatus);
}); 
*/
$('.permissionsettings').change(function(){
  var chkStatus = $(this).prop('checked');
  var section = $(this).attr('section');
  $('#'+section+'_list').prop('checked',chkStatus);
  $('#'+section+'_edit').prop('checked',chkStatus);
  $('#'+section+'_delete').prop('checked',chkStatus);
  $('#'+section+'_approve').prop('checked',chkStatus);
  $('#'+section+'_add').prop('checked',chkStatus);
});
/*$("input[name=changehome]").change(function(){
  alert('kkk');
});

$("input[name=changehome]").on('change.bootstrapSwitch', function(e) {
  alert('kkk');
});*/

$("#browsebtn").click(function(e) {
  e.preventDefault();
  //alert("here");
  $("input[id='browseImage']").click();
});
$("#browseImage").change(function(){
  readURL(this);
});
$('#validity').change(function(){
  //alert($(this).val())
  if($(this).val() == 'LifeTime')
  {
      $('.datefields').css('display','none');
  }else if($(this).val() == 'DateRange')
  {
      $('.datefields').css('display','block');
  }
});

$('#partnerAdd').submit(function(e){
  //e.preventDefault();
  if($('#browseImage').val() == '')
  {
    $('#partnerimage-error').css('display','block');
    return false;
  }else{
    $('#partnerimage-error').css('display','none');
    return true;
  }

});

$('.addmorequestion').click(function(){
  var qid = $(this).data('question');
  var nextq = parseInt(qid)+1;
  console.log(nextq);
  //$('#secment'+nextq).attr('style','display:block');
  $('#secment'+nextq).slideDown('slow');
  $(this).hide();
});

$('.addmoreansweroption').click(function(){
  var qid = $(this).data('question');
  //alert(qid);
  $('#answeroption'+qid).append('<div class="col-md-3 ansoption'+qid+'"><div class="form-group"><input type="text" class="form-control" id="Membershipprice" placeholder="Answer Option" name="Answer'+qid+'Options[]"  value=""></div></div>');
  //console.log('<div class="col-md-3"><div class="form-group"><input type="text" class="form-control" id="Membershipprice" name="Answer'+qid+'Options[]"  value=""></div></div>');
});

$('.ansdropdodn').change(function(){
  var ansop = $(this).val();
  var qid = $(this).data('question');
  if(ansop == 'text')
  {
    //$('#answeroption'+qid).html('<div class="col-md-3"><div class="form-group"><input type="text" class="form-control" id="Membershipprice" placeholder="Number of stars" name="Answer'+qid+'Options[]"  value=""></div></div>');
    //$('.ansoption'+qid).hide();
    $('.answerpane'+qid).hide();
    $('#addmore'+qid).hide();
    //$('.defaultansoption'+qid).attr('placeholder','Number of stars');
  }else{
    $('.answerpane'+qid).show();
    $('.ansoption'+qid).show();
    $('#addmore'+qid).show();
    $('.defaultansoption'+qid).attr('placeholder','Answer Option');
  }
});

$('.showallnotifications').click(function(){
  $(this).html('Loading...');
  
  var start = parseInt($('#loadmorestart').val());
  var limit = parseInt($('#loadmorelimit').val());
  $.ajax({
      url: $('#sitepath').val()+'administrator/load_more_user_notification',
      data: {
          page: start,
          limit: limit,
          csrf_npb_name: $('.csrftoken').val()
      },
      dataType: 'json', 
      type: 'post',
      success: function(data) {
          console.log(data);
          $('.csrftoken').attr('value',data.token);
          var newstart = start+limit;
          //console.log(data.data.totalrecord.totalrecord);
          //console.log(newstart);
          if(parseInt(newstart)>= parseInt(data.totalrecord.totalrecord))
          {
              $('.showallnotifications').hide();
          }
          $('#loadmorestart').val(newstart);
          
          $.each(data.notification, function( index, value ) {
              var notificationskeleton = $('#notificationskeleton').html();
              notificationskeleton = notificationskeleton.replace("[NOTIFICATIONTEXT]",value.notification_text);
              notificationskeleton = notificationskeleton.replace("[NOTIFICATIONDATE]",value.monthFormated);
              notificationskeleton = notificationskeleton.replace(/NOTIFICATIONID/g,value.id);
              notificationskeleton = notificationskeleton.replace(/adminlinknotification/g,value.admin_link);
              var boxclass = 'notification-box';
              if(value.unread == 'Y')
              {
                boxclass = 'notification-box-unread';
              }
              notificationskeleton = notificationskeleton.replace("NOTIFICATIONBOX",boxclass);
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
              $('#notification'+data.id).remove();
          }
      }             
  });
});
function toggleHome(listingId){
  //alert(listingId);
  //console.log(obj);
  var id = "showhome"+listingId
  var x = document.getElementById(id).checked;
  if(x)
  {
    var showhome = 'Y'
  }else{
    var showhome = 'N'
  }
  $.ajax({

      url: $('#siteurl').val()+'administrator/listingshowhome',
      data: {
          csrf_npb_name: $('.csrftoken').val(),
          showhome: showhome,
          listing_id:listingId
      },
      dataType: 'json', 
      type: 'post',
      success: function(data) {
          console.log(data);
          $('.csrftoken').attr('value',data.token);
          if(data.status)
          {
              $('#notification'+data.id).remove();
          }
      }             
  });
}

function deletenotification(obj){
  //console.log(obj);
  var datadeletehref = $(obj).attr('datadeletehref');
  $('#deletenotificationModal').find('#delformnotification').attr('action', datadeletehref);
  $('#deletenotificationModal').modal('show');
}

function readURL(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
          $('#blah').show();
          $('#blah').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
  }
}

function delpartner(obj){
  //console.log($(obj).attr('datadeletehref'));
  $('#deleteModal').find('#delform').attr('action', $(obj).attr('datadeletehref'));
  $('#deleteModal').modal('show');
}
function changeImage(){
  $("input[id='browseImage']").click();
  //console.log('k');
}
function updatetransferstatus(obj){

  $('#updatestatusModal').find('#buytransferstatus').attr('value', $('#TransferStatus').val());
  $('#updatestatusModal').find('#updateform').attr('action', $(obj).attr('datadeletehref'));
  $('#updatestatusModal').modal('show');
}