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
  $('.cancelvideoadd').click(function(){
    $('.addassetpane').slideUp('slow');
  });

  $('.addyear').click(function(){
    $('.addyearpane').slideDown('slow');
  });
  $('.canceladdyear').click(function(){
    $('.addyearpane').slideUp('slow');
  });

  $('#addmoreotherinfo').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="Title[]" id="" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="value[]" id="" placeholder="Value" value=""></div></div>';
    $('#lastotheroption').append(moreInfoHtml);
  });
  $('#addmorebuyerprofile').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="buyerTitle[]" id="" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="buyervalue[]" id="" placeholder="Value" value=""></div></div>';
    $('#lastbuyerprofile').append(moreInfoHtml);
    
  });
  $('#addmoreytvideo').click(function(){
    var moreInfoHtml = '<div class="form-group"><input type="text" class="form-control" name="youtube_url[]" id="youtube_url" placeholder="Youtube Video URL" value=""></div>';
    $('#youtubepane').append(moreInfoHtml);
  });
  $('#addmorethreat').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Threats[]" id="Threats" placeholder="Threats" value=""></div></div>';
    $('#threatsoptions').append(moreInfoHtml);
  });
  $('#addmoreweakness').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Weakness[]" id="Weakness" placeholder="Weakness" value=""></div></div>';
    $('#weaknessoptions').append(moreInfoHtml);
  });
  $('#addmoreopertunities').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="Opertunities[]" id="Opertunities" placeholder="Opertunities" value=""></div></div>';
    $('#opertunitiesoptions').append(moreInfoHtml);
  });
  $('#addmorestrength').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="strength[]" id="strength" placeholder="Strength" value=""></div></div>';
    $('#strengthoptions').append(moreInfoHtml);
  });
  $('#addmoreskill').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><input type="text" class="form-control" name="skill[]" id="" placeholder="Work & Skills" value=""></div></div>';
    $('#worlskillpane').append(moreInfoHtml);
  });
  $('#addmoresocialmedia').click(function(){
    var moreInfoHtml = '<div class="col-md-4"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Extra Social Media</label><input type="text" class="form-control" name="extrasocialmedia[]" id="" placeholder="Social media link" value=""></div></div>';
    $('#socialmedialinks').append(moreInfoHtml);
  });
  $('#addmoreseodata').click(function(){
    var moreInfoHtml = '<div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Title</label><input type="text" class="form-control" name="seoTitle[]" id="" placeholder="Title" value=""></div></div><div class="col-md-6"><div class="form-group labelWrap"><label style="margin: 7px 0 0 8px;">Value</label><input type="text" class="form-control" name="seoValue[]" id="" placeholder="Value" value=""></div></div>';
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
    console.log(datapost);
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
  $(".dragtableadvisory").tableDnD({
    onDragClass: "myDragClass",
    onDrop: function(table, row) {
      var rows = table.tBodies[0].rows;
      //console.log(rows);
      var debugStr = "";
      for (var i=0; i<rows.length; i++) {
          debugStr += rows[i].id+",";
      }
      console.log(debugStr);
      $.ajax({
        url: 'advisory-board/swap?pageId='+debugStr,
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
      console.log(debugStr);
      $.ajax({
        url: 'headerbanner/swap?pageId='+debugStr,
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
  $(".change-user-pic").click(function(){
    $("#profile_pic_image").hide();
    $("#dropzone").show();
    $("#dropzone").trigger('click');
  });
  $("#browsebtn").click(function(e) {
    e.preventDefault();
    //alert("here");
    $("input[id='browseImage']").click();
  });
})(jQuery); // End of use strict
//tab====================
(function(){
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
})();
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
function editrecord(obj){
  var dataId = $(obj).data('id');
  $('#editModal'+dataId).modal('show');
}
$('#siteSettings').validate({
  rules:{
    site_title : { required : true },
    currency : { required : true },
    paypal_email : { required : true, email: true },
    helpline_no : { required : true },
    helpline_email_address : { required : true, email: true },
  },
  messages:{
    site_title : { required : "Site Title is required" },
    currency : { required : "Currency is required" },
    paypal_email : { required : "PayPal email is required",email: "Please enter a valid Paypal email address." },
    helpline_no : { required : "Helpline No. is required" },
    helpline_email_address : { required : "Helpline Email Address.. is required",email: "Please enter a valid helpline email address." },
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
$("#browsebtn").click(function(e) {
  e.preventDefault();
  //alert("here");
  $("input[id='browseImage']").click();
});
$("#browseImage").change(function(){
  readURL(this);
});

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
}