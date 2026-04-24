// Call the dataTables jQuery plugin
$(document).ready(function() {
  //$('#dataTable').DataTable();
    //var tokenData = $('#tokenhash').val();
   var adminsellbusinessTable = $('#adminsellbusinessTable').DataTable( {
      "processing": true,
      "serverSide": true,
      'searching': false,
      "ordering": true,
      "columnDefs": [{
        orderable: false,
        targets: "no-sort"
      }],
      "order": [[ 7, 'desc' ]],
      "ajax": {
        url: baseURL + "administrator/get-sell-request",
        type: 'POST',
        'data': function(data){
          // Append to data
          data.searchName = $('#searchNameSellReq').val(),
          data.searchByStatus = $('#sellStatusSellReq').val(),
          data.csrf_npb_name = $('.csrftoken').val()
       },
       complete: function(r){
        var res = JSON.parse(r.responseText)
        //console.log(res)
        $('.csrftoken').attr('value',res.token);
      }
      },
      

      'columns': [
        { data: 'sl_no' },
        { data: 'fname' },
        { data: 'mail' },
        { data: 'listing' },
        { data: 'website' },
        { data: 'coupon' },
        { data: 'amount' },
        { data: 'date' },
        { data: 'status' },
        { data: 'action' }
    ],
    
  } );
  var adminvaluationbusinessTable = $('#adminvaluationbusinessTable').DataTable( {
      "processing": true,
      "serverSide": true,
      'searching': false,
      "ordering": true,
      "columnDefs": [{
        orderable: false,
        targets: "no-sort"
      }],
      "order": [[ 6, 'desc' ]],
      "ajax": {
        url: baseURL + "administrator/get-valuation-request",
        type: 'POST',
        'data': function(data){
          // Append to data
          data.searchName = $('#searchNameValuationReq').val(),
          data.csrf_npb_name = $('.csrftoken').val()
       },
       complete: function(r){
        var res = JSON.parse(r.responseText);
        //console.log(res.token);
        $('.csrftoken').val(res.token);
      }
      },
      

      'columns': [
        { data: 'sl_no' },
        { data: 'fname' },
        { data: 'mail' },
        { data: 'phone' },
        { data: 'monetization' },
        { data: 'website' },
        { data: 'valuationdate' },
        { data: 'amount' },
        { data: 'multiple' },
        { data: 'action' }
    ],
    
  } );
  
  $('#searchNameSellReq').keyup(function(){
    adminsellbusinessTable.draw();
  });
  $('#searchNameValuationReq').keyup(function(){
    adminvaluationbusinessTable.draw();
  });

  $('#sellStatusSellReq').change(function(){
    adminsellbusinessTable.draw();
  });

  var dataTable111 = $('#adminapprodevsellTable').DataTable( {
      "processing": true,
      "serverSide": true,
      'searching': false,
      "ordering": true,
      "columnDefs": [{
        orderable: false,
        targets: "no-sort"
      }],
      "order": [[ 6, 'desc' ]],
      "ajax": {
        url: baseURL + "administrator/get-approved-sell",
        type: 'POST',
        'data': function(data){
          // Append to data
          data.searchName = $('#searchNameappSell').val(),
          data.searchByStatus = $('#sellStatusappSell').val(),
          data.csrf_npb_name = $('.csrftoken').val()
       },
       complete: function(r){
        var res = JSON.parse(r.responseText)
        //console.log(res.token)
        $('.csrftoken').attr('value',res.token);
      }
      },

      'columns': [
        { data: 'fname' },
        { data: 'email' },
        { data: 'phone' },
        { data: 'listing' },
        { data: 'website' },
        { data: 'showhome' },
        { data: 'date' },
        { data: 'status' },
        { data: 'action' }
    ]
  } );
  $('#searchNameappSell').keyup(function(){
    dataTable111.draw();
  });

  $('#sellStatusappSell').change(function(){
    dataTable111.draw();
  });

  var dataTableagent = $('#agentTable').DataTable( {
    "processing": true,
    "serverSide": true,
    'searching': false,
    "ajax": {
      url: baseURL + "administrator/get-agents",
      type: 'POST',
      'data': function(data){
        // Append to data
        data.searchName = $('#searchNameagent').val(),
        data.searchByStatus = $('#agentStatus').val()
     }

    },
    'columns': [
      { data: 'sl_no' },
      { data: 'agent_name' },
      { data: 'email' },
      { data: 'phone' },
      { data: 'status' },
      { data: 'action' },
  ]
} );
$('#searchNameagent').keyup(function(){
  dataTableagent.draw();
});

$('#agentStatus').change(function(){
  dataTableagent.draw();
});

var dataTablecoach = $('#coachTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ajax": {
    url: baseURL + "administrator/get-coachs",
    type: 'POST',
    'data': function(data){
      // Append to data
      data.searchName = $('#searchNamecoach').val(),
      data.searchByStatus = $('#coachStatus').val()
   }

  },
  'columns': [
    { data: 'sl_no' },
    { data: 'coach_name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'status' },
    { data: 'action' },
]
} );
$('#searchNamecoach').keyup(function(){
  dataTablecoach.draw();
});

$('#coachStatus').change(function(){
  dataTablecoach.draw();
});
//subscription
/*var usersubscriptionTable = $('#usersubscriptionTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ajax": {
    url: baseURL + "administrator/get-coachs",
    type: 'POST',
    'data': function(data){
      // Append to data
      data.searchName = $('#searchNamesubscriptions').val()
   }

  },
} );*/
var usersubscriptionTable = $('#usersubscriptionTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ajax": {
    url: baseURL + "administrator/get-subscriptions",
    type: 'POST',
    'data': function(data){
      // Append to data
      data.searchName = $('#searchNamesubscriptions').val(),
      data.searchUsertype = $('#subscriptionUserType').val()
   },
   complete: function(r){
     console.log(r)
   }
  },
  'columns': [
    { data: 'sl_no' },
    { data: 'subscription_code' },
    { data: 'payment_ref' },
    { data: 'name' },
    { data: 'role' },
    { data: 'package' },
    { data: 'amount' },
    { data: 'status' },
    { data: 'date' },
]
  
} );
$('#searchNamesubscriptions').keyup(function(){
  usersubscriptionTable.draw();
});
$('#subscriptionUserType').change(function(){
  usersubscriptionTable.draw();
});

var leagueTable = $('#leagueTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  
  "ajax": {
    url: baseURL + "administrator/leaguemanagement/getleaguedata",
    type: 'POST',
    'data': function(data){
      data.csrf_instantscouting_name = $('.leaguecsrf').val()
   },complete(res){
     //console.log(res);
    $('.leaguecsrf').val(res.responseJSON.token)
   }

  },
  'columns': [
    { data: 'sl_no' },
    { data: 'name' },
    { data: 'link' },
    { data: 'status' },
    { data: 'action' },
]
} );

var blogTable = $('#dataTableblog').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  
  "ajax": {
    url: baseURL + "administrator/listblogsdata",
    type: 'POST',
    'data': function(data){
      data.csrf_instantscouting_name = $('.leaguecsrf').val()
   },complete(res){
     //console.log(res.responseJSON);
    $('.leaguecsrf').val(res.responseJSON.token)
   }

  },
  'columns': [
    { data: 'blogID' },
    { data: 'blogName' },
    { data: 'blogSlug' },
    { data: 'blogCats' },
    { data: 'modifiedOn' },
    { data: 'blogStatus' },
    
    { data: 'action' },
]
} );

var dataTable = $('#identityprooftable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ordering": true,
  "columnDefs": [{
      orderable: false,
      targets: "no-sort"
  }],
  "order": [[ 4, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/verifications/identity-proof-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    //console.log(res.token)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'fname' },
    { data: 'mail' },
    { data: 'phone' },
    { data: 'submission_date' },
    { data: 'identity_status' },
    { data: 'status' },
    { data: 'action' }
]
} );

var dataTable = $('#fundprooftable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ordering": true,
  "columnDefs": [{
      orderable: false,
      targets: "no-sort"
  }],
  "order": [[ 4, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/verifications/fund-proof-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    //console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'fname' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'submission_date' },
    { data: 'identity_status' },
    { data: 'status' },
    { data: 'action' }
]
} );
var dataTable = $('#usertable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ordering": true,
  "columnDefs": [{
      orderable: false,
      targets: "no-sort"
  }],
  "order": [[ 4, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/user-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('input[type=search]').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    //console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'fname' },
    { data: 'phone' },
    { data: 'email' },
    { data: 'reg_date' },
    { data: 'identity' },
    { data: 'fund' },
    { data: 'status' },
    { data: 'action' }
]
} );

var dataTable = $('#subadmintable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ordering": true,
  "columnDefs": [{
        orderable: false,
        targets: "no-sort"
  }],
  "order": [[ 3, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/sub-admin-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('input[type=search]').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'fname' },
    { data: 'email' },
    { data: 'reg_date' },
    { data: 'status' },
    { data: 'action' }
]
} );
var dataTable = $('#faqTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ordering": true,
      "columnDefs": [{
        orderable: false,
        targets: "no-sort"
      }],
      "order": [[ 6, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/pending-faq-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('.form-control-sm').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'listing_id' },
    { data: 'buyername' },
    { data: 'buyeremail' },
    { data: 'question' },
    { data: 'sellername' },
    { data: 'selleremail' },
    { data: 'faqDate' },
    { data: 'seller_reply' },
    { data: 'admin_status' },
    { data: 'action' }
]
} );

var dataofferTable = $('#listingofferTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  'searching': true,
  "ordering": true,
  "columnDefs": [{
      orderable: false,
      targets: "no-sort"
  }],
  "order": [[ 7, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/listing-offers-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchName').val(),
      data.searchByStatus = $('#offerStatus').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'buyername' },
    { data: 'buyeremail' },
    { data: 'offer_price' },
    { data: 'sellername' },
    { data: 'selleremail' },
    { data: 'listing_id' },
    { data: 'offerDate' },
    { data: 'offerStatus' },
    { data: 'action' }
]
} );

$('#searchName').keyup(function(){
  dataofferTable.draw();
});

$('#offerStatus').change(function(){
  dataofferTable.draw();
});

var databuyTable = $('#listingbuyTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "columnDefs": [{
        orderable: false,
        targets: "no-sort"
  }],
  "order": [[ 2, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/listing-buy-request-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#BuysearchName').val(),
      data.searchByStatus = $('#buyStatus').val(),
      data.searchBySellType = $('#sellType').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'transaction_ref' },
    { data: 'sellername' },
    { data: 'buyDate' },
    { data: 'offersell' },
    { data: 'buyStatus' },
    { data: 'price' },
    { data: 'commissionAmount' },
    { data: 'transferAmount' },
    
    
    { data: 'action' }
]
} );

$('#BuysearchName').keyup(function(){
  databuyTable.draw();
});

$('#buyStatus').change(function(){
  databuyTable.draw();
});
$('#sellType').change(function(){
  databuyTable.draw();
});

var dataaddmoneyTable = $('#listingwalletaddmoneyTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "columnDefs": [{
        orderable: false,
        targets: "no-sort"
  }],
  "order": [[ 6, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/wallet-addmoney-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#AddmoneysearchName').val(),
      data.searchByStatus = $('#AddmoneyStatus').val()
   },
   complete: function(r){
    var res = JSON.parse(r.responseText)
    //console.log(res)
    $('.csrftoken').attr('value',res.token);
  }
  },

  'columns': [
    { data: 'buyername' },
    { data: 'buyeremail' },
    { data: 'buyerphone' },
    { data: 'transaction_ref' },
    { data: 'amount' },
    { data: 'type' },
    { data: 'buyDate' },
    { data: 'action' }
]
} );

$('#AddmoneysearchName').keyup(function(){
  dataaddmoneyTable.draw();
});

$('#AddmoneyStatus').change(function(){
  dataaddmoneyTable.draw();
});





var dataticketTable = $('#adminsupportticketTable').DataTable( {
  rowCallback : function( nRow, res, iDisplayIndex ) {
    if ( res['admin_read'] == "N" )
    {
        $('td', nRow).css('background-color', '#ccc');
    }
  },
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "columnDefs": [{
        orderable: false,
        targets: "no-sort"
  }],
  "order": [[ 5, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/support-ticket-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#textSearch').val(),
      data.searchByStatus = $('#statusSearch').val()
   },
   complete: function(r){
    //console.log(r.responseText);
    var res = JSON.parse(r.responseText)
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'ticket_id' },
    { data: 'user' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'subject' },
    { data: 'ticketDate' },
    { data: 'ticketStatus' },
    { data: 'action' }
]
} );
$('#textSearch').keyup(function(){
  dataticketTable.draw();
});

$('#statusSearch').change(function(){
  dataticketTable.draw();
});

var callscheduleTable = $('#callscheduleTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "columnDefs": [{
        orderable: false,
        targets: "no-sort"
  }],
  "order": [[ 3, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/callscheduleaction",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    //console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'scheduledtime' },
    { data: 'enqiry_type' },
    { data: 'note' },
    { data: 'status' },
    { data: 'action' }
]
} );
$('#searchNameSchedulecall').keyup(function(){
  callscheduleTable.draw();
});
$('#searchTimeSchedulecall').change(function(){
  callscheduleTable.draw();
});

$('#scheduleStatus').change(function(){
  callscheduleTable.draw();
});

var contactusTable = $('#contactusTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': true,
  "ajax": {
    url: baseURL + "administrator/contactusaction",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'message' },
    { data: 'contactDate' },
    { data: 'action' }
]
} );

///////////////
var contactusTable = $('#lendingTable').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "order": [[ 5, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/lending-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    //console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'industry' },
    { data: 'loantype' },
    { data: 'loan_term' },
    { data: 'acquirer_contribution' },
    { data: 'dateadded' },
    { data: 'status' },
    { data: 'action' }
]
} );

///////////////
var getfunded = $('#getfunded').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "order": [[ 7, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/getfunded-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'fund_seeker' },
    { data: 'amount' },
    { data: 'funding_timing' },
    { data: 'website' },
    { data: 'phone' },
    { data: 'email' },
    { data: 'dateadded' },
    { data: 'action' }
]
} );

///////////////
var fundacquisition = $('#fundacquisition').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "order": [[ 6, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/fundacquisition-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    //console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'investor' },
    { data: 'name' },
    { data: 'street' },
    { data: 'phone' },
    { data: 'email' },
    { data: 'dateadded' },
    { data: 'action' }
]
} );

///////////////
var requestaccess = $('#requestaccess').DataTable( {
  "processing": true,
  "serverSide": true,
  'searching': false,
  "ordering": true,
  "order": [[ 7, 'desc' ]],
  "ajax": {
    url: baseURL + "administrator/requestaccess-data",
    type: 'POST',
    'data': function(data){
      data.csrf_npb_name = $('.csrftoken').val(),
      data.searchName = $('#searchNameSchedulecall').val(),
      data.searchTimeSchedulecall = $('#searchTimeSchedulecall').val(),
      data.searchByStatus = $('#scheduleStatus').val()
   },
   complete: function(r){
    //console.log(r.responseText);
    if(r.responseText != null)
    {
      var res = JSON.parse(r.responseText)
    }
    
    $('.csrftoken').attr('value',res.token);
  }
  
  },

  'columns': [
    { data: 'sl_no' },
    { data: 'investor' },
    { data: 'available_money' },
    { data: 'hold_period' },
    { data: 'name' },
    { data: 'email' },
    { data: 'phone' },
    { data: 'dateadded' },
    { data: 'action' }
]
} );

  // Other Datatable

  $('#uncoverListingDTB').DataTable({
    'searching': false
  });

});
