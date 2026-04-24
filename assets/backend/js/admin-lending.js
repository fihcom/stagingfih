(function($) {

    $('#AddEditAcquisitionLending').validate({
        rules:{
            Industry :  { required : true},
            BusinessAge :  { required : true},
            Revenue :  { required : true},
            NetProfit :  { required : true},
            FundingAmount :  { required : true},
            EBITDA :  { required : true},
            LoanType :  { required : true},
            LoanTerm :  { required : true},
            InterestYield :  { required : true},
            AcquirerContribution :  { required : true},
            BusinessListingURL :  { required : true},
        },
        messages:{
            Industry :  { required : "Industry is required." },  
            BusinessAge :  { required : "Business age is required." },
            Revenue :  { required : "Revenue is required." },
            NetProfit :  { required : "Net Profit is required." },
            FundingAmount :  { required : "Funding Amount is required." },
            EBITDA :  { required : "EBITDA is required." },
            LoanType :  { required : "Loan Type is required." },
            LoanTerm :  { required : "Loan Term is required." },
            InterestYield :  { required : "Interest Yield is required." },
            AcquirerContribution :  { required : "Acquirer Contribution is required." },
            BusinessListingURL :  { required : "Business Listing URL is required." },

        },
        highlight: function(element) {
            $(element).removeClass("error");
        }
      });
})(jQuery); 