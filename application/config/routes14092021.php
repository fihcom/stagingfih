<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
//$route['default_controller'] = 'landing';
$route['default_controller'] = 'home';
$route['404_override'] = 'home/page_missing';
$route['translate_uri_dashes'] = FALSE;

//frontend
$route['login'] = "userregistration/login";
$route['loginuser'] = "userregistration/loginUser";
$route['logout'] = "home/logout";
$route['paypal/ipn'] = "paypal/ipn";
$route['newsletter'] = "userregistration/newsletter";
$route['analytics'] = "home/analytics";
$route['register'] = "userregistration/register";
$route['emailconfirm'] = "userregistration/emailconfirm";
$route['userauthfb'] = "userregistration/userauthfb";
$route['registeruser'] = "userregistration/registerUser";
$route['forgetpassword'] = "userregistration/forgetpassword";
$route['forgetpasswordaction'] = "userregistration/forgetpasswordaction";
$route['resetpassword'] = "userregistration/resetpassword";
$route['resetpasswordaction'] = "userregistration/resetpasswordaction";

$route['opensrs'] = "home/opensrs";
$route['agreement'] = "home/businessbrokerage";
$route['curated_contents_seller'] = "home/curatedContentSeller";
$route['getsellercuratedcontents'] = "home/getcuratedContentSeller";
$route['curated_contents_buyer'] = "home/curatedContentBuyer";
$route['getbuyercuratedcontents'] = "home/getcuratedContentBuyer";


$route['register/success'] = "userregistration/registerSuccess";
$route['register/userauthgoogle'] = "userregistration/userauthgoogle";
$route['marketplace'] = "home/marketPlace";
$route['marketplace/(:num)'] = "home/marketPlace/$1";
$route['contactus'] = "home/contactus";
$route['contactusfrm'] = "home/contactusfrmAction";
$route['fbdatadelete'] = "home/fbdatadelete";


$route['listing/(:num)'] = "home/listingDetails/$1";
$route['listing/uncover'] = "home/listingUncover";
$route['listing/uncover/(:num)'] = "home/listingUncoverProcess/$1";
$route['listing/askquestion'] = "home/listingAskQuestion";
$route['listing/load_more_faq'] = "home/load_more_faq";
$route['listing/submitoffers'] = "home/submitoffers";
$route['listing/submitbuyrequest'] = "home/submitbuyrequest";
$route['listing/addbuyrefimage'] = "home/buyRefImage";

$route['blog'] = "home/blog";
$route['getblog'] = "home/getblog";
$route['blog/category/(:any)'] = "home/blogCategory/$1";
$route['getblog/category'] = "home/getblogCategory";
$route['blog/(:any)'] = "home/blogDetails/$1";
$route['curated-content/(:any)'] = "home/curatedDetails/$1";
$route['ticket/create'] = "user/user/createTicket";
$route['ticket/createAction'] = "user/user/createTicketAction";

$route['how-it-works/(:any)'] = "home/howItWorks/$1";
$route['testimonials'] = "home/testimonials";
$route['gettestimonials'] = "home/testimonialsData";

$route['scheduledcalls'] = "user/user/scheduledcalls";
$route['scheduledcallsAction'] = "user/user/scheduledcallsAction";


//plaid
//$route['assetreports'] = "home/plaidcreateassetreport";
$route['getassetreports'] = "home/plaidgetassetrequest";

//user
$route['user'] = "user/user/dashboard";
$route['user/sell'] = "user/user/selldashboard";
$route['user/sell/moreinfo/(:num)'] = "user/user/sellmoreinfo/$1";
$route['user/sell/moreinfodatasubmit'] = "user/user/sellmoreinfoAction";
$route['user/sell-your-business'] = "user/user/sell_your_business";
$route['user/sell-your-business-action'] = "user/user/sell_your_business_action";
$route['user/sell-your-business/payment'] = "user/user/businessregpayment";
$route['user/sell-your-business/success'] = "paypal/success";
$route['user/sell-your-business/cancel'] = "paypal/cancel";
$route['user/sell-your-business/apply-promo'] = "user/user/applyPromo";


$route['user/profile'] = "user/user/userProfile";
$route['user/profileupdate'] = "user/user/userProfileUpdate";
$route['user/profileupdatepassword'] = "user/user/update_user_password";
$route['user/profilephotoupdate'] = "user/user/update_user_photo";
$route['user/verifyIdentityaction'] = "user/user/verifyIdentityaction";
$route['user/submit-user-fundproof'] = "user/user/submitUserFundProof";
$route['user/proofoffundaction'] = "user/user/proofoffundaction";
$route['user/proofoffundactiononline'] = "user/user/proofoffundactiononline";
$route['user/submit-user-identityproof'] = "user/user/submitUserIdentityProof";
$route['user/verificationtab'] = "user/user/verificationtab";
$route['user/reverifyfund'] = "user/user/reverifyfund";
$route['user/verifyfundprofile'] = "user/user/verifyfundprofile";
$route['user/seller_faq_reply'] = "user/user/seller_faq_reply";
$route['user/load_more_seller_reply'] = "user/user/load_more_seller_reply";
$route['user/buyerfaq'] = "user/user/buyer_faq";
$route['user/seller-cureted-content'] = "user/user/seller_cureted_content";
$route['user/seller-cureted-content/(:any)'] = "user/user/individual_seller_cureted_content/$1";
$route['user/load_more_seller_offer'] = "user/user/load_more_seller_offer";
$route['user/load_more_offer_request'] = "user/user/load_more_buyer_offer";
$route['user/sell/approveoffer/(:num)'] = "user/user/approveOffer/$1";
$route['user/sell/rejectoffer/(:num)'] = "user/user/rejectOffer/$1";



$route['user/load_more_user_notification'] = "user/user/loadmoreUserNotification";
$route['user/removenotification/(:num)'] = "user/user/removeUserNotification/$1";
$route['user/countnotification'] = "user/user/countUserNotification";
$route['user/sell/scheduleCall'] = "user/user/scheduleCall";
$route['user/buyer'] = "user/user/buyerdashboard";
$route['user/buyer/notification'] = "user/user/buyernotification";
$route['user/seller/getfreevaluation'] = "home/getfreevaluation";
$route['getfreevaluation'] = "home/getfreevaluation";

$route['user/value-your-business-action'] = "home/value_your_business_action";
$route['user/valuation/(:any)'] = "home/valuationAction/$1";
$route['user/support-ticket-data'] = "user/user/getSupportticketData";

$route['user/ticket/details/(:any)'] = "user/supportticket/supportTicketDetails/$1";
$route['user/support/closeticket/(:any)'] = "user/supportticket/supportTicketClose/$1";
$route['user/ticket/reply/(:any)'] = "user/supportticket/supportReply/$1";
$route['user/ticket/closeticket/(:any)'] = "user/supportticket/supportTicketClose/$1";
$route['user/submitbuywalletamountrequest'] = "user/user/submitbuywalletamountrequest";
$route['user/submitwalletwithdrawrequest'] = "user/user/submitwalletwithdrawrequest";

$route['user/wallet-list-data'] = "user/user/getWalletData";



$route['business-valuation-action'] = "home/valuationAction";
//$route['business-valuation'] = "home/businessvaluationAction";
/////////////////////////////plaid
$route['createlinktoken'] = "user/user/createlinktoken";
$route['getaccesstoken'] = "user/user/plaidgetaccesstoken";
$route['generaterequest'] = "home/plaidgeneraterequest";
$route['plaidwebhook'] = "home/plaidwebhook";
$route['chkfundapprove'] = "home/chkfundapprove";
$route['plaidwebhookfire'] = "home/plaidwebhookfire";
//administrator
$route['administrator/login'] = "administrator/adminlogin/login";
$route['administrator/logout'] = "home/logout";
$route['administrator/edit-profile'] = "administrator/administrator/edit_profile";
$route['administrator'] = "administrator/administrator/dashboard";
$route['administrator/dashboard'] = "administrator/administrator/dashboard";
$route['administrator/sell-request'] = "administrator/administrator/sellRequest";
$route['administrator/get-sell-request'] = "administrator/administrator/getSellRequest";
$route['administrator/valuation-request'] = "administrator/administrator/valuationRequest";
$route['administrator/get-valuation-request'] = "administrator/administrator/getValuationRequest";

$route['administrator/approved-sell'] = "administrator/administrator/approvedSell";
$route['administrator/listingshowhome'] = "administrator/administrator/listingshowhome";
$route['administrator/get-approved-sell'] = "administrator/administrator/getApprovedSell";

$route['administrator/sell-details'] = "administrator/administrator/getSellDetails";
$route['administrator/sell-request/reject/(:num)/(:num)'] = "administrator/administrator/rejectSell/$1/$2";
$route['administrator/sell-request/deleteapproved/(:num)/(:num)'] = "administrator/administrator/deleteapprovedSell/$1/$2";
$route['administrator/sell/add_sale'] = "administrator/administrator/addSale";
$route['administrator/sell/publishsell'] = "administrator/administrator/publishSale";
$route['administrator/sell-request/sell-details/(:num)'] = "administrator/administrator/getSellDetails/$1";
$route['administrator/sell-request/sell-request-process/(:num)'] = "administrator/administrator/processSellRequest/$1";
$route['administrator/sell-request/manage-earnings/(:num)'] = "administrator/administrator/manageEarnings/$1";
$route['administrator/sell-request/manage-earnings/(:num)'] = "administrator/administrator/manageEarnings/$1";
$route['administrator/sell-request/clear-analytics-data'] = "administrator/administrator/clearanalytics";
$route['administrator/approved-sell/manage-earnings/(:num)'] = "administrator/administrator/manageEarnings/$1";

$route['administrator/approved-sell/earnings/add'] = "administrator/administrator/earningAdd";
$route['administrator/approved-sell/question-answer/(:num)'] = "administrator/administrator/displayQuestions/$1";

$route['administrator/submit-user-pic']                     = "administrator/administrator/submitUserPic";
$route['administrator/update_user_details'] = "administrator/administrator/updateuserdetails";
$route['administrator/update_admin_password'] = "administrator/administrator/update_admin_password";
$route['administrator/site-settings'] = "administrator/sitesettings/siteSettingsDisplay";
$route['administrator/adminsitesettings/submit_sitesetting_form'] = "administrator/sitesettings/siteSettingsAction";

$route['administrator/site-settings/addhomepagelogo'] = "administrator/sitesettings/addhomePageLogo";
$route['administrator/site-settings/addinsidepagelogo'] = "administrator/sitesettings/addinsidePageLogo";

$route['administrator/site-settings/common-list-assets'] = "administrator/sitesettings/commonListAssets";
$route['administrator/site-settings/common-list-assets/add'] = "administrator/sitesettings/addCommonAssets";
$route['administrator/site-settings/common-list-assets/delete/(:num)'] = "administrator/sitesettings/deleteCommonAssets/$1";

$route['administrator/site-settings/commission-settings'] = "administrator/sitesettings/commissionSettings";
$route['administrator/site-settings/commission-settings/add'] = "administrator/sitesettings/addcommissionSettings";
$route['administrator/site-settings/commission-settings/delete/(:num)'] = "administrator/sitesettings/deletecommissionSettings/$1";



$route['administrator/site-settings/monetization'] = "administrator/sitesettings/monetization";
$route['administrator/site-settings/monetization/add'] = "administrator/sitesettings/addmonetization";
$route['administrator/site-settings/monetization/delete/(:num)'] = "administrator/sitesettings/deletemonetization/$1";

$route['administrator/site-settings/industries'] = "administrator/sitesettings/commonListIndustries";
$route['administrator/site-settings/industries/add'] = "administrator/sitesettings/addIndustries";
$route['administrator/site-settings/industries/delete/(:num)'] = "administrator/sitesettings/deleteIndustries/$1";
$route['administrator/listed-business'] = "administrator/business/listedBusiness";

$route['administrator/verifications/identity-proof'] = "administrator/verifications/listIdentityProof";
$route['administrator/verifications/identity-proof-data'] = "administrator/verifications/listIdentityProofData";
$route['administrator/verifications/verify-identity-proof/(:num)'] = "administrator/verifications/verifyIdentityProof/$1";
$route['administrator/verifications/approve-identity/(:num)'] = "administrator/verifications/approveIdentity/$1";
$route['administrator/verifications/save-approve-identity/(:num)'] = "administrator/verifications/saveapproveIdentity/$1";
$route['administrator/verifications/reject-identity/(:num)'] = "administrator/verifications/rejectIdentity/$1";
$route['administrator/verifications/reject-fund/(:num)'] = "administrator/verifications/rejectFund/$1";

$route['administrator/verifications/fund-proof'] = "administrator/verifications/listFundProof";
$route['administrator/verifications/fund-proof-data'] = "administrator/verifications/listFundProofData";
$route['administrator/verifications/verify-fund-proof/(:num)'] = "administrator/verifications/verifyFundProof/$1";
$route['administrator/verifications/approve-fund/(:num)'] = "administrator/verifications/approveFund/$1";

$route['administrator/users'] = "administrator/administrator/users";
$route['administrator/user-data'] = "administrator/administrator/usersData";
$route['administrator/users/delete/(:num)'] = "administrator/administrator/usersDelete/$1";
$route['administrator/users/edit/(:num)'] = "administrator/administrator/usersEdit/$1";
$route['administrator/users/updateuser'] = "administrator/administrator/usersUpdate";
$route['administrator/faqs'] = "administrator/administrator/pendingFaqs";
$route['administrator/pending-faq-data'] = "administrator/administrator/pendingFaqsData";
$route['administrator/listing-offers'] = "administrator/administrator/listingOffers";
$route['administrator/listing-offers-data'] = "administrator/administrator/listingOffersData";
$route['administrator/listing-offers/(:num)'] = "administrator/administrator/listingOffersDetails/$1";

$route['administrator/listing-buy-request'] = "administrator/administrator/listingBuy";
$route['administrator/listing-buy-request-data'] = "administrator/administrator/listingBuyData";
$route['administrator/listing-buy-request/(:num)'] = "administrator/administrator/listingBuyDetails/$1";
$route['administrator/buy-request/reject/(:num)'] = "administrator/administrator/listingBuyReject/$1";
$route['administrator/buy-request/approve/(:num)'] = "administrator/administrator/listingBuyApprove/$1";
$route['administrator/buy-request/updatetransfer/(:num)'] = "administrator/administrator/listingBuytransferStatus/$1";

$route['administrator/listing-commissions'] = "administrator/administrator/listingCommission";
$route['administrator/listing-commissions/approve/(:num)'] = "administrator/administrator/approvelistingCommission/$1";

$route['administrator/wallet-addmoney-request'] = "administrator/administrator/walletAddmoney";
$route['administrator/wallet-addmoney-data'] = "administrator/administrator/walletAddmoneyData";
$route['administrator/wallet-addmoney-request/(:num)'] = "administrator/administrator/walletAddmoneyDetails/$1";

$route['administrator/wallet-addmoney/reject/(:num)'] = "administrator/administrator/walletAddmoneyReject/$1";
$route['administrator/wallet-addmoney/approve/(:num)'] = "administrator/administrator/walletAddmoneyApprove/$1";

$route['administrator/wallet-withdrawmoney/reject/(:num)'] = "administrator/administrator/walletWithdrawmoneyReject/$1";
$route['administrator/wallet-withdrawmoney/approve/(:num)'] = "administrator/administrator/walletWithdrawmoneyApprove/$1";



$route['administrator/faq/edit/(:num)'] = "administrator/administrator/faqEdit/$1";
$route['administrator/faq/approve/(:num)'] = "administrator/administrator/faqApprove/$1";
$route['administrator/faq/reject/(:num)'] = "administrator/administrator/faqReject/$1";

$route['administrator/curated-content'] = "administrator/contentmanagement/curatedContent";
$route['administrator/curated-content/add'] = "administrator/contentmanagement/addcuratedContent";
$route['administrator/curated-content/alter'] = "administrator/contentmanagement/altercuratedContent";
$route['administrator/curated-content/addimage'] = "administrator/contentmanagement/addcuratedImage";
$route['administrator/curated-content/swap'] = "administrator/contentmanagement/swapcuratedContent";
$route['administrator/curated-content/edit/(:num)'] = "administrator/contentmanagement/editcuratedContent/$1";
$route['administrator/curated-content/delete/(:num)'] = "administrator/contentmanagement/deletecuratedContent/$1";


$route['administrator/free-downloaded-contents'] = "administrator/contentmanagement/downloadedContents";
$route['administrator/free-downloaded-contents/add'] = "administrator/contentmanagement/adddownloadedContents";
$route['administrator/free-downloaded-contents/alter'] = "administrator/contentmanagement/alterdownloadedContents";
$route['administrator/free-downloaded-contents/addimage'] = "administrator/contentmanagement/addcuratedImage";
$route['administrator/free-downloaded-contents/swap'] = "administrator/contentmanagement/swapdownloadedContents";
$route['administrator/free-downloaded-contents/edit/(:num)'] = "administrator/contentmanagement/editdownloadedContents/$1";
$route['administrator/free-downloaded-contents/delete/(:num)'] = "administrator/contentmanagement/deletedownloadedContents/$1";

$route['administrator/valuation_questions'] = "administrator/contentmanagement/valuationQuestions";
$route['administrator/valuation_questions/add'] = "administrator/contentmanagement/addvaluationQuestions";
$route['administrator/valuation_questions/alter'] = "administrator/contentmanagement/altervaluationQuestions";
$route['administrator/valuation_questions/swap'] = "administrator/contentmanagement/swapvaluationQuestions";
$route['administrator/valuation_questions/edit/(:num)'] = "administrator/contentmanagement/editvaluationQuestions/$1";
$route['administrator/valuation_questions/delete/(:num)'] = "administrator/contentmanagement/deletevaluationQuestions/$1";
$route['administrator/support-ticket'] = "administrator/supportticket/getSupportticket";
$route['administrator/support-ticket-data'] = "administrator/supportticket/getSupportticketData";
$route['administrator/support/reply/(:num)'] = "administrator/supportticket/supportReply/$1";

$route['administrator/submit-user-identityproof'] = "administrator/verifications/submitUserIdentityProof";
$route['administrator/submit-user-fundproof'] = "administrator/verifications/submitUserFundProof";
$route['administrator/proofoffundaction'] = "administrator/verifications/proofoffundaction";


/*===========Blog Category Management========================*/
$route['administrator/blog-categories'] 					  = "administrator/adminbloginfo/Blogcategories";
$route['administrator/add-blog-categories']					  = "administrator/adminbloginfo/addBlogCategory";
$route['administrator/admininfo/alter_blog_cat_form_details'] = "administrator/adminbloginfo/alterBlogCatDetails";
$route['administrator/edit-blog-category/(:any)'] 			  = "administrator/adminbloginfo/editBlogCategory/$1";
$route['administrator/delete-blog-category/(:any)'] 		  = "administrator/adminbloginfo/deleteCategory/$1";


/* ====== Blog Management ====== */
$route['administrator/blogs']	  		= "administrator/adminbloginfo/listBlogs";
$route['administrator/blogs/add']			= "administrator/adminbloginfo/addBlog";
$route['administrator/blogs/edit/(:any)']	= "administrator/adminbloginfo/editBlog/$1";
$route['administrator/blogs/delete/(:any)'] = "administrator/adminbloginfo/deleteBlog/$1";
$route['administrator/blogs/addimage'] = "administrator/adminbloginfo/addblogImage";

/* ====== Comment Management ====== */
$route['administrator/cms-pages']        		= "administrator/admincms/listCMSPages";
$route['administrator/cms-pages/add'] 	 		= "administrator/admincms/addEditCMSPages";
$route['administrator/cms-pages/edit'] 	 = "administrator/admincms/alterCMSPages";
$route['administrator/cms-pages/edit/(:num)'] 	= "administrator/admincms/addEditCMSPages/$1";
$route['administrator/cms-pages/delete/(:num)'] = "administrator/admincms/deleteCMSPages/$1";

$route['administrator/partners']	  		= "administrator/admincms/partners";
$route['administrator/partners-add']	  		= "administrator/admincms/partnersadd";
$route['administrator/partners-get']	  		= "administrator/admincms/partnerslist";
$route['administrator/partners/delete/(:any)']	  		= "administrator/admincms/partnersdelete/$1";
$route['administrator/partners/swap']	  		= "administrator/admincms/swappartnerPages";

$route['administrator/support-tickets'] = "administrator/supportticket/supportTickets";
$route['administrator/support-tickets-data'] = "administrator/supportticket/supportTicketsData";
$route['administrator/ticket/details/(:any)'] = "administrator/supportticket/supportTicketDetails/$1";
$route['administrator/support/closeticket/(:any)'] = "administrator/supportticket/supportTicketClose/$1";
$route['administrator/testimonials'] = "administrator/admincms/testimonials";
$route['administrator/testimonial/add'] = "administrator/admincms/addtestimonialContent";
$route['administrator/testimonial/alter'] = "administrator/admincms/altertestimonialContent";
$route['administrator/testimonial/addimage'] = "administrator/admincms/addtestimonialImage";
$route['administrator/testimonials/swap'] = "administrator/admincms/swaptestimonialContent";
$route['administrator/testimonial/edit/(:num)'] = "administrator/admincms/edittestimonialContent/$1";
$route['administrator/testimonial/delete/(:num)'] = "administrator/admincms/deletetestimonialContent/$1";
$route['administrator/homecontents'] = "administrator/admincms/homecomponents";
$route['administrator/homecontents/alterhomecontents'] = "administrator/admincms/alterhomecomponents";
$route['administrator/homecontents/addimage'] = "administrator/admincms/addhomeImage";

$route['administrator/cms-pages']        		= "administrator/admincms/listCMSPages";
$route['administrator/cms-pages/add'] 	 		= "administrator/admincms/addEditCMSPages";
$route['administrator/cms-pages/edit/(:num)'] 	= "administrator/admincms/addEditCMSPages/$1";
$route['administrator/cms-pages/delete/(:num)'] = "administrator/admincms/deleteCMSPages/$1";
$route['administrator/cms-pages/swap'] = "administrator/admincms/swapCMSPages";

$route['administrator/financials'] = "administrator/financial/getreport";

$route['administrator/promo-code'] = "administrator/promocodemanagement/getpromoCode";
$route['administrator/promo-code/add'] = "administrator/promocodemanagement/addpromoCode";
$route['administrator/promo-code/edit/(:num)'] = "administrator/promocodemanagement/editpromoCode/$1";
$route['administrator/promo-code/delete/(:num)'] = "administrator/promocodemanagement/deletepromoCode/$1";
$route['administrator/promo-code/alter'] = "administrator/promocodemanagement/alterpromoCode";

$route['administrator/site-settings/questionadd']	= "administrator/sellquestions/addQuestionFields";
$route['administrator/site-settings/addquestionformaction']	= "administrator/sellquestions/addQuestionFormsAction";
$route['administrator/callschedule']	= "administrator/administrator/callschedules";
$route['administrator/callscheduleaction']	= "administrator/administrator/callschedulesaction";
$route['administrator/callschedule/view/(:num)']	= "administrator/administrator/editCall/$1";
$route['administrator/callschedule/editAction']	= "administrator/administrator/editCallAction";

$route['administrator/load_more_user_notification'] = "administrator/administrator/loadmoreUserNotification";
$route['administrator/removenotification/(:num)'] = "administrator/administrator/removeUserNotification/$1";
$route['administrator/contactus'] = "administrator/administrator/contactUs";
//$route['administrator/contactusaction'] = "administrator/administrator/contactUsAction";
//$route['administrator/contactus/details/(:num)'] = "administrator/administrator/contactUsdetails/$1";
$route['administrator/email-notification-management'] = "administrator/administrator/emailnotificationmanagement";

$route['administrator/sub-admin'] = "administrator/subadmin/subadminlist";
$route['administrator/sub-admin-data'] = "administrator/subadmin/subadmindata";
$route['administrator/sub-admin/add'] = "administrator/subadmin/addsubadmin";
$route['administrator/sub-admin/edit/(:num)'] = "administrator/subadmin/editsubadmin/$1";
$route['administrator/sub-admin/alter'] = "administrator/subadmin/altersubadmin";

$route['administrator/sub-admin/delete/(:num)'] = "administrator/subadmin/deletesubadmin/$1";
$route['administrator/exportanalyticsdata/(:num)'] = "administrator/administrator/exportanalyticsdata/$1";
//api
$route['api/authentication/registration'] = 'api/authentication/registration';
$route['api/authentication/saveprofilephoto'] = 'api/authentication/saveprofilephoto';
$route['api/authentication/login'] = 'api/authentication/login';
$route['api/authentication/checksocialuserexists'] = 'api/authentication/checksocialuserexists';
$route['api/authentication/forgetpassword'] = 'api/authentication/forgetPassword';
$route['api/authentication/resetpassword'] = 'api/authentication/resetPassword';

$route['api/data/monetization'] = 'api/user/monetization';
$route['api/data/selltemprecord'] = 'api/user/selltemprecord';
$route['api/data/valuationtemprecord'] = 'api/user/valuationtemprecord';
$route['api/data/update-sell-your-business'] = 'api/user/updatesellyourbusiness';
$route['api/data/sellrequestfinal'] = 'api/user/sellrequestfinal';
$route['api/data/getprofile'] = 'api/user/getProfile';
$route['api/data/updateprofile'] = 'api/user/updateProfile';
$route['api/data/updatepassword'] = 'api/user/updateuserpasswprd';
$route['api/data/updateuserpicture'] = 'api/user/updateprofilepicture';
$route['api/data/updateuserfundproof'] = 'api/user/updateFundProof';
$route['api/data/proofoffund'] = 'api/user/updateFundProofFinal';
$route['api/data/updateuserindefyproof'] = 'api/user/updateIndentityProof';
$route['api/data/reverifyproofoffund'] = 'api/user/reverifyproofoffund';


$route['api/data/update-value-your-business'] = 'api/user/updatevalueyourbusiness';

$route['api/user/registernewsletter'] = 'api/user/registernewsletter';

$route['api/data/userverification'] = 'api/user/userVerification';
$route['api/marketplace/listing'] = 'api/marketplace/listing';
$route['api/marketplace/listinguseraskaquestion'] = 'api/marketplace/listingaskquestion';
$route['api/marketplace/mplisting'] = 'api/marketplace/mpListing';
$route['api/marketplace/mprecentlisting'] = 'api/marketplace/mpRecentListing';
$route['api/marketplace/sellerlisting'] = 'api/marketplace/mpSellerListing';
$route['api/marketplace/buyerunlockedlisting'] = 'api/marketplace/mpBuyerUnlockedListing';
$route['api/marketplace/listinguserpermission'] = 'api/marketplace/listingUserPermission';
$route['api/marketplace/uncoverlisting'] = 'api/marketplace/uncoverListing';
$route['api/marketplace/buyerwonlisting'] = 'api/marketplace/buyerWonListing';
$route['api/marketplace/soldlisting'] = 'api/marketplace/sellerSoldListing';
$route['api/user/buyerfaq'] = 'api/user/buyerfaq';
$route['api/user/sellerfaq'] = 'api/user/sellerfaq';
$route['api/user/sellerfaqreply'] = 'api/user/sellerfaqReply';
$route['api/marketplace/sellerfaq'] = 'api/marketplace/sellerfaq';
$route['api/user/sellercuratedcontents'] = 'api/user/sellercuratedcontents';
$route['api/marketplace/submitoffers'] = 'api/marketplace/submitoffers';
$route['api/user/sellergetoffers'] = 'api/user/sellergetoffers';
$route['api/user/buyersofferrequested'] = 'api/user/buyergetoffers';
$route['api/user/approveoffer'] = "api/user/approveOffer";
$route['api/user/rejectoffer'] = "api/user/rejectOffer";
$route['api/marketplace/listinguseroffers'] = "api/marketplace/userOffers";
$route['api/data/uploadbuyrefpicture'] = "api/marketplace/uploadBuyDoc";
$route['api/marketplace/submitbuy'] = 'api/marketplace/submitbuy';
$route['api/marketplace/submitbuywallet'] = 'api/marketplace/submitbuywallet';
$route['api/marketplace/submitwithdrawwallet'] = 'api/marketplace/submitwithdrawwallet';
$route['api/marketplace/selectmaxminrange'] = 'api/marketplace/selectmaxminrange';
$route['api/user/getnotifications'] = 'api/user/getnotifications';
$route['api/user/delnotifications'] = 'api/user/deletenotifications';
$route['api/data/individual_curated_content'] = 'api/user/individual_curated_content';
$route['api/data/get_curated_contents'] = 'api/user/curated_contents';
$route['api/user/sellerfreecontents'] = 'api/user/sellerfreecontents';
$route['api/user/buyerfreecontents'] = 'api/user/buyerfreecontents';
$route['api/user/buyerswalletdetails'] = 'api/user/buyerswalletdetails';
$route['api/user/sellpendingapplications'] = 'api/user/sellPendingApplications';
$route['api/user/callschedule'] = 'api/user/callschedule';
//$route['api/data/getcallloghistory'] = 'api/user/callLogHistory';
$route['api/data/blogcategories'] = 'api/user/blogCategories';
$route['api/data/blogs'] = 'api/user/blogs';
$route['api/data/blogcatpost'] = 'api/user/blogcatpost';
$route['api/data/blogdetails'] = 'api/user/blogsDetails';
$route['api/data/blogcurateddetails'] = 'api/user/blogcuratedDetails';
$route['api/data/testimonials'] = 'api/user/testimonials';
$route['api/data/valuationinputs'] = 'api/user/valuationInputs';
$route['api/data/valuationbusinesscalculation'] = 'api/user/valuationBusiness';
$route['api/data/getpreviouslusold'] = 'api/user/previouslysoldbusiness';
$route['api/user/valuationlist'] = 'api/user/valuationList';
$route['api/data/partners'] = 'api/user/partners';
$route['api/user/createticketaction'] = 'api/user/createTicketAction';
$route['api/user/getsupportticketaction'] = 'api/user/supportTicketAction';
$route['api/user/supportticketdetails'] = 'api/user/supportTicketDetails';
$route['api/user/supportticketreply'] = 'api/user/supportTicketReply';
$route['api/user/supportticketclose'] = 'api/user/supportTicketClose';
$route['api/data/homecontents'] = 'api/user/homecontents';
$route['api/data/applypromo'] = 'api/user/applyPromo';
$route['api/user/walletTransactionList'] = 'api/user/walletTransactionList';
$route['api/data/contactus'] = 'api/user/contactUs';
$route['(:any)'] = "home/cmsLinks/$1";


