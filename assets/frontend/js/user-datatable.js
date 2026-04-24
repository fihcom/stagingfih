$(document).ready(function() {
    var baseURL = $('#sitepath').val();
    var dataticketTable = $('#usersupportticketTable').DataTable( {
        rowCallback : function( nRow, res, iDisplayIndex ) {
          if ( res['user_read'] == "N" )
          {
              $('td', nRow).css('background-color', '#DBA514');
          }
        },
        "processing": true,
        "serverSide": true,
        'searching': false,
        "ajax": {
          url: baseURL + "user/support-ticket-data",
          type: 'POST',
          'data': function(data){
            data.csrf_npb_name = $('.csrftoken').val(),
            data.searchName = $('#textSearch').val(),
            data.searchByStatus = $('#statusSearch').val()
         },
         complete: function(r){
          var res = JSON.parse(r.responseText)
          //console.log(res);
          $('.csrftoken').attr('value',res.token);
        }
        
        },
      
        'columns': [
          { data: 'ticket_id' },
          { data: 'user' },
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







      $('.createticket').click(function(){
        $('#ticketCreateFrm').slideDown();
        $(this).hide();
      });
      
      $('.schedulecallbtn').click(function(){
        $('#calllogreqform').slideDown();
        $(this).hide();
      });

      var datawalletTable = $('#walletTable').DataTable( {
        rowCallback : function( nRow, res, iDisplayIndex ) {
          if ( res['user_read'] == "N" )
          {
              $('td', nRow).css('background-color', '#DBA514');
          }
        },
        "processing": true,
        "serverSide": true,
        'searching': false,
        "ajax": {
          url: baseURL + "user/wallet-list-data",
          type: 'POST',
          'data': function(data){
            data.csrf_npb_name = $('.csrftoken').val(),
            data.searchName = $('#textSearch').val(),
            data.searchByStatus = $('#statusSearch').val()
         },
         complete: function(r){
          var res = JSON.parse(r.responseText)
          //console.log("res",res);
          $('.csrftoken').attr('value',res.token);
        }
        
        },
      
        'columns': [
          { data: 'transaction_ref' },
          { data: 'wallet_amount' },
          { data: 'type' },
          { data: 'date_added' },
          { data: 'buyStatus' }
      ]
      } );
      $('#textSearch').keyup(function(){
        datawalletTable.draw();
      });
      
      $('#statusSearch').change(function(){
        datawalletTable.draw();
      });

      var callscheduleTable = $('#usercallschedulkleTable').DataTable( {
        "processing": true,
        "serverSide": true,
        'searching': false,
        "ajax": {
          url: baseURL + "scheduledcallsAction",
          type: 'POST',
          'data': function(data){
            data.csrf_npb_name = $('.csrftoken').val(),
            data.searchName = $('#textSearchCall').val(),
            data.searchTimeSchedulecall = $('#textSearchTime').val(),
            data.searchByStatus = $('#statusSearchCall').val()
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
          { data: 'phone' },
          { data: 'scheduledtime' },
          
          { data: 'note' },
          { data: 'status' }
      ]
      } );
      $('#textSearchCall').keyup(function(){
        callscheduleTable.draw();
      });
      $('#textSearchTime').change(function(){
        callscheduleTable.draw();
      });
      
      $('#statusSearchCall').change(function(){
        callscheduleTable.draw();
      });


});