<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('sendRestRequest'))
{
    function sendRestRequest($url, $userData)
    {
        $apiKey = API_KEY;
        // API auth credentials
        $apiUser = API_USER;
        $apiPass = API_PASS;
        // API URL
        
        //$url = 'http://192.168.2.253/qeip-llc/'.$url;
        ///$url = 'http://bestphpwebsites.com/qeip-llc/'.$url;
        //$url = 'http://www.bestphpwebsites.com/qeip-llc/'.$url;
        //$url = 'http://localhost/qeip-llc/'.$url;
        // $url = 'https://beta.fih.com/'.$url;
        $url = base_url().'/'.$url;
        // User account info
        //$userData = $this->input->post();

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }

        curl_close($ch);
        /*if (isset($error_msg)) {
            // TODO - Handle cURL error accordingly
            print '<pre>';
            echo $url;
            print_r($error_msg);
            die;
        }*/

        return json_decode($result,true);
    }
}

if(!function_exists('sendRestRequestip'))
{
    function sendRestRequestip($url, $userData)
    {
        $apiKey = API_KEY;
        // API auth credentials
        $apiUser = API_USER;
        $apiPass = API_PASS;
        // API URL
        echo 'Rest API URL: ';
        //echo $url = 'http://192.168.2.253/qeip-llc/'.$url;
        echo $url = 'http://bestphpwebsites.com/qeip-llc/'.$url;
        //echo $url = 'http://59.160.209.70/qeip-llc/'.$url;
        // User account info
        //$userData = $this->input->post();

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
}
//https://www.sitepoint.com/php-authorization-jwt-json-web-tokens/
//https://www.sitepoint.com/using-google-analytics-api-v3-php-fetching-data/
if(!function_exists('sendRestRequesturl'))
{
    function sendRestRequesturl($url, $userData)
    {
        $apiKey = API_KEY;
        // API auth credentials
        $apiUser = API_USER;
        $apiPass = API_PASS;
        // API URL
        echo 'Rest API URL: ';
        echo $url = base_url().$url;
        // User account info
        //$userData = $this->input->post();

        // Create a new cURL resource
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-API-KEY: " . $apiKey));
        curl_setopt($ch, CURLOPT_USERPWD, "$apiUser:$apiPass");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $userData);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }
}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 */
if(!function_exists('getHashedPassword'))
{
    function getHashedPassword($plainPassword)
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }
}
/**
 * This function used to generate the hashed password
 * @param {string} $plainPassword : This is plain text password
 * @param {string} $hashedPassword : This is hashed password
 */
if(!function_exists('verifyHashedPassword'))
{
    function verifyHashedPassword($plainPassword, $hashedPassword)
    {
        return password_verify($plainPassword, $hashedPassword) ? true : false;
    }
}
if(!function_exists('setBlogCatSlug')){
    function setBlogCatSlug($slug){
        $CI = &get_instance();
        $CI->db->select("COUNT(*) AS NumHits");
        $CI->db->from(TABLE_PREFIX."blog_categories");
        $CI->db->like('blogCatSlug', $slug, 'after');
        $CI->db->where('isDeleted', '0');
        // $getQuery = $CI->db->query("SELECT COUNT(*) AS NumHits FROM ".TABLE_PREFIX."categories WHERE cat_slug  LIKE '$slug%'");
        $getQuery = $CI->db->get();
        // echo $CI->db->last_query
        $row = $getQuery->row_array();
        $numHits = $row['NumHits'];
        // echo ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
        return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
    }
}

if(!function_exists('setBlogSlug')){
    function setBlogSlug($slug){
        $CI = &get_instance();
        $CI->db->select("COUNT(*) AS NumHits");
        $CI->db->from(TABLE_PREFIX."blogs");
        $CI->db->like('blogSlug', $slug, 'after');
        // $getQuery = $CI->db->query("SELECT COUNT(*) AS NumHits FROM ".TABLE_PREFIX."categories WHERE cat_slug  LIKE '$slug%'");
        $getQuery = $CI->db->get();
        $row = $getQuery->row_array();
        $numHits = $row['NumHits'];
        // echo ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
        return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
    }
}
if(!function_exists('setMonetizationSlug')){
    function setMonetizationSlug($slug){
        $CI = &get_instance();
        $CI->db->select("COUNT(*) AS NumHits");
        $CI->db->from(TABLE_PREFIX."monetization");
        $CI->db->like('slug', $slug, 'after');
        $CI->db->where('Status', '1');
        // $getQuery = $CI->db->query("SELECT COUNT(*) AS NumHits FROM ".TABLE_PREFIX."categories WHERE cat_slug  LIKE '$slug%'");
        $getQuery = $CI->db->get();
        $row = $getQuery->row_array();
        $numHits = $row['NumHits'];
        // echo ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
        return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
    }
}
if(!function_exists('create_url_slug')){
    function create_url_slug($url){
        # Prep string with some basic normalization
        $url = str_replace(' ', '', $url);
        $url = strtolower($url);
        $url = strip_tags($url);
        $url = stripslashes($url);
        $url = html_entity_decode($url);

        # Remove quotes (can't, etc.)
        $url = str_replace('\'', '', $url);

        # Replace non-alpha numeric with hyphens
        $url = trim(preg_replace('/[^a-z0-9]+/', '-', $url), '-');

        return $url;
    }
}
if(!function_exists('setPageSlug')){
    function setPageSlug($slug){
        $CI = &get_instance();
        $CI->db->select("COUNT(*) AS NumHits");
        $CI->db->from(TABLE_PREFIX."cms_pages");
        $CI->db->like('pageSlug', $slug, 'after');
        $CI->db->where('isDeleted', '0');
        // $getQuery = $CI->db->query("SELECT COUNT(*) AS NumHits FROM ".TABLE_PREFIX."categories WHERE cat_slug  LIKE '$slug%'");
        $getQuery = $CI->db->get();
        $row = $getQuery->row_array();
        $numHits = $row['NumHits'];
        // echo ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
        return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
    }
}

if(!function_exists('sendEmail')){
    function sendEmail($to, $subject, $message, $attachment = ''){
        $CI = &get_instance();
        $CI->db->select("s.*", FALSE);
        $CI->db->from(TABLE_PREFIX.'site_settings s');
        $CI->db->where('id', 1);
        $Query = $CI->db->get();
		$Array = $Query->row_array();
        
        // $htmlMessage = '<body style="margin: 0 0 0 0; padding: 0 0 0 0; background-color: #eee;">
        //                     <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
        //                         <table style="width: 100%;" border:="0"; cellspacing="0";>
        //                             <thead style="padding: 0 0 0 0; margin: 0 0 0 0;">
        //                             <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                 <td style="padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                 <table style="width: 100%; background-color: #fff; padding: 0 0px 10px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
        //                                     <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                         <td style=" margin: 10px 0 0 0; padding: 0 0; text-align:left; display:block;">
        //                                             <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" max-width="120px" width="" height="37"></a>
        //                                         </td>
        //                                         <td style=" margin: 0 0; padding: 0 0; font: normal 15px arial; text-align:right;">
        //                                             <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">'.$Array['address'].'</div>
        //                                             <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">
        //                                             <a href="tel:'.$Array['helpline_no'].'" style="color:#000; text-decoration: none;">'.$Array['helpline_no'].'</a>
        //                                             </div>
        //                                             <div style="padding:0 0 0 0; margin: 0 0 3px 0;">
        //                                             <a href="mailto:'.$Array['helpline_email_address'].'" target="_blank" style=" color:#000; text-decoration: none;">'.$Array['helpline_email_address'].'</a>
        //                                             </div>
        //                                         </td>
        //                                     </tr>
        //                                 </table>
        //                                 </td>
        //                             </tr>
        //                             </thead>
        //                             <tbody style="padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                 <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                     <table style="width: 100%; padding: 0 0; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
        //                                     <tr colspan="2">
        //                                         <td>
        //                                         <div style="min-height: 200px; padding: 30px; background-color: #f4f4f4;">
        //                                             <div style="padding:0 0 0 0; margin: 0 0 0 0;">
        //                                                 '.$message.'
        //                                             </div>
        //                                         </div>
        //                                         </td>
        //                                     </tr>
        //                                     </table>
        //                                 </tr>
        //                             </tbody>
        //                             <tfoot>
        //                                 <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
        //                                     <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
        //                                         <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com. All Rights Reserved.</td>
        //                                         <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
        //                                             <a href="'.$Array['twitter_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/twitter_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
        //                                             </a>
        //                                             <a href="'.$Array['facebook_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/facebook_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
        //                                             </a>
        //                                             <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/instagram_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
        //                                             </a>
        //                                             <a href="'.$Array['youtube_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/youtube_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
        //                                             </a>
        //                                         </td>
        //                                     </tr>
        //                                 </table>
        //                             </tfoot>
        //                         </table>
        //                     </div>
        //                 </body>';
        $htmlMessage = '<body style="margin: 0 0 0 0; padding: 10px 0 0 0; background-color: #eee;">
        <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
          <table style="width:100%;max-width:600px;margin-top:40px;margin-right:auto;margin-bottom:40px;margin-left:auto;border-collapse:collapse;border:none" cellspacing="0" cellpadding="0" border="0">
            <tbody>
              <tr>
                 <td>
      
                  <div style="border:1px solid #37475A;background-color:#fff;border-radius:4px">
                    <table style="width:100%;border-collapse:collapse;background-color:#fff;border-radius:4px" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                         <tr>
                          <td style="background-color:#37475A;padding:24px 30px 24px 30px;border-top-left-radius:4px;border-top-right-radius:4px">
                            <a href="'.base_url().'" target="_blank"><img src="'.base_url().'uploads/logo_image/'.$Array['home_logo'].'" alt="FIH.com" max-width="120px" width="" height="37"></a>
                          </td>
                        </tr>
                         <tr>
                          <td style="padding:40px 32px 0 32px">
                            <div style="border-radius:4px;border:none!important;background-color:#f3f3f4;padding:24px!important;margin:0 0 24px 0!important">
                            '.$message.'
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>
               <tr>
                <td>
                  <table style="width:100%;border-collapse:collapse" cellspacing="0" cellpadding="0" border="0">
                    <tbody>
                       <tr>
                        <td>
                          <table style="width:100%;border-collapse:collapse;margin-top:24px" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                              <tr>
                                <td style="width:100%">
                                  <a href="'.base_url().'" target="_blank">
                                    <img src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" alt="FIH logo" max-width="120px" width="" height="37">
                                  </a>
                                </td>
                              </tr>
                              <tr>
                                <td style="vertical-align:bottom">
                                  <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                      <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                          <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' <a href="'.base_url().'" target="_blank">FIH.com</a>. All Rights Reserved.</td>
                                          <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
                                              <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/linkedin-6-24.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0;"></a>
                                          </td>
                                      </tr>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                       <tr>
                        <td style="border-top:1px solid #cdced2">
                          <p style="font-size:12px;color:#6c6f7a;margin-top:40px">No Creation of Agency/Fiduciary Relationship: Any information provided by, or discussion with, an employee of <a href="'.base_url().'" target="_blank">FIH.com</a> (or any subsidiary) regarding the <a href="'.base_url().'" target="_blank">FIH.com</a> marketplace should not be considered, nor is it intended to be, investment advice in any manner and is for informational purposes only. All information and conversations are not intended to, nor does it, create a fiduciary or other similar relationship with <a href="'.base_url().'" target="_blank">FIH.com</a> or any subsidiary.</p>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </body>';
        $client = getClient();
        
        $service = new Google_Service_Gmail($client);
        $from = EMAIL_FROM;
        $msg = createMessage($from,$to,$subject,$htmlMessage);
        
        sendMessage($service,'me',$msg);
    }
}

// if(!function_exists('sendEmail')){
//     function sendEmail($to, $subject, $message, $attachment = ''){
//         $CI = &get_instance();
// 		//$CI->load->library('email');
// 		$CI->load->library('phpmailer_lib');
//         // PHPMailer object
// 		$mail = $CI->phpmailer_lib->load();
		
//         $CI->db->select("s.*", FALSE);
//         $CI->db->from(TABLE_PREFIX.'site_settings s');
//         $CI->db->where('id', 1);
//         $Query = $CI->db->get();
// 		$Array = $Query->row_array();
		
// 		$mail->isSMTP();
//         $mail->Host     = SMTP_HOST;
//         $mail->SMTPDebug  = 0;  
//         $mail->SMTPAuth = true;
//         $mail->Username = SMTP_USER;
//         $mail->Password = SMTP_PASS;
//         $mail->SMTPSecure =  'tls';
//         $mail->Port     = SMTP_PORT;
//         $mail->CharSet = "utf-8";
        
//         $mail->setFrom(EMAIL_FROM, FROM_NAME);
        
//         // Add a recipient
//         $mail->addAddress($to);
        
//         // Add cc or bcc 
//         //$mail->addCC('cc@example.com');
//         //$mail->addBCC('bcc@example.com');
        
//         // Email subject
//         $mail->Subject = $subject;
        
//         // Set email format to HTML
//         $mail->isHTML(true);
        
//         $htmlMessage = '<body style="margin: 0 0 0 0; padding: 0 0 0 0; background-color: #eee;">
//                             <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
//                                 <table style="width: 100%;" border:="0"; cellspacing="0";>
//                                     <thead style="padding: 0 0 0 0; margin: 0 0 0 0;">
//                                     <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
//                                         <td style="padding: 0 0 0 0; margin: 0 0 0 0;">
//                                         <table style="width: 100%; background-color: #fff; padding: 0 0px 10px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
//                                             <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
//                                                 <td style=" margin: 10px 0 0 0; padding: 0 0; text-align:left; display:block;">
//                                                     <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" max-width="120px" width="" height="37"></a>
//                                                 </td>
//                                                 <td style=" margin: 0 0; padding: 0 0; font: normal 15px arial; text-align:right;">
//                                                     <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">'.$Array['address'].'</div>
//                                                     <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">
//                                                     <a href="tel:'.$Array['helpline_no'].'" style="color:#000; text-decoration: none;">'.$Array['helpline_no'].'</a>
//                                                     </div>
//                                                     <div style="padding:0 0 0 0; margin: 0 0 3px 0;">
//                                                     <a href="mailto:'.$Array['helpline_email_address'].'" target="_blank" style=" color:#000; text-decoration: none;">'.$Array['helpline_email_address'].'</a>
//                                                     </div>
//                                                 </td>
//                                             </tr>
//                                         </table>
//                                         </td>
//                                     </tr>
//                                     </thead>
//                                     <tbody style="padding: 0 0 0 0; margin: 0 0 0 0;">
//                                         <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
//                                             <table style="width: 100%; padding: 0 0; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
//                                             <tr colspan="2">
//                                                 <td>
//                                                 <div style="min-height: 200px; padding: 30px; background-color: #f4f4f4;">
//                                                     <div style="padding:0 0 0 0; margin: 0 0 0 0;">
//                                                         '.$message.'
//                                                     </div>
//                                                 </div>
//                                                 </td>
//                                             </tr>
//                                             </table>
//                                         </tr>
//                                     </tbody>
//                                     <tfoot>
//                                         <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
//                                             <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
//                                                 <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com. All Rights Reserved.</td>
//                                                 <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
//                                                     <a href="'.$Array['twitter_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/twitter_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
//                                                     </a>
//                                                     <a href="'.$Array['facebook_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/facebook_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
//                                                     </a>
//                                                     <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/instagram_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
//                                                     </a>
//                                                     <a href="'.$Array['youtube_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/youtube_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
//                                                     </a>    
//                                                 </td>
//                                             </tr>
//                                         </table>
//                                     </tfoot>
//                                 </table>
//                             </div>
//                         </body>';

//         /*$CI->email->from(EMAIL_FROM, FROM_NAME);
//         $CI->email->to($to);

//         $CI->email->subject($subject);
//         $CI->email->set_mailtype('html');

//         $CI->email->message($htmlMessage);
//         if($attachment != '')
//             $CI->email->attach($attachment);
//         $retStatus = $CI->email->send();
// 		$CI->email->clear();*/
// 		$mail->Body = $htmlMessage;
// 		// Send email
//         if(!$mail->send()){
//             echo 'Message could not be sent.';
//             echo 'Host->'.SMTP_HOST.'<br>';
//             echo 'User->'.SMTP_USER.'<br>';
//             echo 'Password->'.SMTP_PASS.'<br>';
//             echo 'Secure->tls<br>';
//             echo 'Port->'.SMTP_PORT.'<br>';
//             echo 'Mailer Error: ' . $mail->ErrorInfo;
//             die;
//         }else{
//             return true;
//         }
//         return $retStatus;
//     }
// }

if(!function_exists('sendEmail11')){ 
    function sendEmail11($to, $subject, $message, $attachment = ''){
        $CI = &get_instance();
		//$CI->load->library('email');
		$CI->load->library('phpmailer_lib');
        // PHPMailer object
		$mail = $CI->phpmailer_lib->load();
		
        $CI->db->select("s.*", FALSE);
        $CI->db->from(TABLE_PREFIX.'site_settings s');
        $CI->db->where('id', 1);
        $Query = $CI->db->get();
		$Array = $Query->row_array();
		
		$mail->isSMTP();
        $mail->Host     = SMTP_HOST;
        $mail->SMTPDebug  = 0;  
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure =  'tls';
        $mail->Port     = SMTP_PORT;
        $mail->CharSet = "utf-8";
        
        $mail->setFrom(EMAIL_FROM, FROM_NAME);
        
        // Add a recipient
        $mail->addAddress($to);
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        $htmlMessage = '<body style="margin: 0 0 0 0; padding: 0 0 0 0; background-color: #eee;">
                            <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
                                <table style="width: 100%;" border:="0"; cellspacing="0";>
                                    <thead style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                    <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <td style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px 10px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 10px 0 0 0; padding: 0 0; text-align:left; display:block;">
                                                    <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" max-width="120px" width="" height="37"></a>
                                                </td>
                                                <td style=" margin: 0 0; padding: 0 0; font: normal 15px arial; text-align:right;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">'.$Array['address'].'</div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">
                                                    <a href="tel:'.$Array['helpline_no'].'" style="color:#000; text-decoration: none;">'.$Array['helpline_no'].'</a>
                                                    </div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0;">
                                                    <a href="mailto:'.$Array['helpline_email_address'].'" target="_blank" style=" color:#000; text-decoration: none;">'.$Array['helpline_email_address'].'</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                            <table style="width: 100%; padding: 0 0; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr colspan="2">
                                                <td>
                                                <div style="min-height: 200px; padding: 30px; background-color: #f4f4f4;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 0 0;">
                                                        '.$message.'
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                            </table>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com. All Rights Reserved.</td>
                                                <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
                                                    <a href="'.$Array['twitter_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/twitter_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['facebook_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/facebook_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/instagram_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['youtube_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/youtube_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>    
                                                </td>
                                            </tr>
                                        </table>
                                    </tfoot>
                                </table>
                            </div>
                        </body>';

        /*$CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->to($to);

        $CI->email->subject($subject);
        $CI->email->set_mailtype('html');

        $CI->email->message($htmlMessage);
        if($attachment != '')
            $CI->email->attach($attachment);
        $retStatus = $CI->email->send();
		$CI->email->clear();*/
		$mail->Body = $htmlMessage;
		// Send email
        if(!$mail->send()){
            // echo 'Message could not be sent.';
            // echo 'Host->'.SMTP_HOST.'<br>';
            // echo 'User->'.SMTP_USER.'<br>';
            // echo 'Password->'.SMTP_PASS.'<br>';
            // echo 'Secure->tls<br>';
            // echo 'Port->'.SMTP_PORT.'<br>';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            // die;
        }else{
            return true;
        }
        return $retStatus;
    }
}
if(!function_exists('sendEmailtest')){ 
    function sendEmailtest($to, $subject, $message, $attachment = ''){
        $CI = &get_instance();
		//$CI->load->library('email');
		$CI->load->library('phpmailer_lib');
        // PHPMailer object
		$mail = $CI->phpmailer_lib->load();
		
        $CI->db->select("s.*", FALSE);
        $CI->db->from(TABLE_PREFIX.'site_settings s');
        $CI->db->where('id', 1);
        $Query = $CI->db->get();
		$Array = $Query->row_array();
		
		$mail->isSMTP();
        $mail->Host     = SMTP_HOST;
        $mail->SMTPDebug  = 1;  
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure =  'tls';
        $mail->Port     = SMTP_PORT;
        $mail->CharSet = "utf-8";
        
        $mail->setFrom(EMAIL_FROM, FROM_NAME);
        
        // Add a recipient
        $mail->addAddress($to);
        
        // Add cc or bcc 
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = $subject;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        $htmlMessage = '<body style="margin: 0 0 0 0; padding: 0 0 0 0; background-color: #eee;">
                            <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
                                <table style="width: 100%;" border:="0"; cellspacing="0";>
                                    <thead style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                    <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <td style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px 10px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 10px 0 0 0; padding: 0 0; text-align:left; display:block;">
                                                    <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" max-width="120px" width="" height="37"></a>
                                                </td>
                                                <td style=" margin: 0 0; padding: 0 0; font: normal 15px arial; text-align:right;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">'.$Array['address'].'</div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">
                                                    <a href="tel:'.$Array['helpline_no'].'" style="color:#000; text-decoration: none;">'.$Array['helpline_no'].'</a>
                                                    </div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0;">
                                                    <a href="mailto:'.$Array['helpline_email_address'].'" target="_blank" style=" color:#000; text-decoration: none;">'.$Array['helpline_email_address'].'</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                            <table style="width: 100%; padding: 0 0; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr colspan="2">
                                                <td>
                                                <div style="min-height: 200px; padding: 30px; background-color: #f4f4f4;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 0 0;">
                                                        '.$message.'
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                            </table>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com. All Rights Reserved.</td>
                                                <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
                                                    <a href="'.$Array['twitter_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/twitter_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['facebook_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/facebook_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/instagram_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['youtube_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/youtube_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>    
                                                </td>
                                            </tr>
                                        </table>
                                    </tfoot>
                                </table>
                            </div>
                        </body>';

        /*$CI->email->from(EMAIL_FROM, FROM_NAME);
        $CI->email->to($to);

        $CI->email->subject($subject);
        $CI->email->set_mailtype('html');

        $CI->email->message($htmlMessage);
        if($attachment != '')
            $CI->email->attach($attachment);
        $retStatus = $CI->email->send();
		$CI->email->clear();*/
		$mail->Body = $htmlMessage;
		// Send email
        if(!$mail->send()){
            // echo 'Message could not be sent.';
            // echo 'Host->'.SMTP_HOST.'<br>';
            // echo 'User->'.SMTP_USER.'<br>';
            // echo 'Password->'.SMTP_PASS.'<br>';
            // echo 'Secure->tls<br>';
            // echo 'Port->'.SMTP_PORT.'<br>';
            // echo 'Mailer Error: ' . $mail->ErrorInfo;
            // die;
        }else{
            return true;
        }
        return $retStatus;
    }
}

if(!function_exists('sendEmailnormalemail')){
    function sendEmailnormalemail($to, $subject, $message, $attachment = ''){
        $CI = &get_instance();
		//$CI->load->library('email');
		$CI->load->library('phpmailer_lib');
        // PHPMailer object
		$mail = $CI->phpmailer_lib->load();
		
        $CI->db->select("s.*", FALSE);
        $CI->db->from(TABLE_PREFIX.'site_settings s');
        $CI->db->where('id', 1);
        $Query = $CI->db->get();
		$Array = $Query->row_array();
		
        
        $htmlMessage = '<body style="margin: 0 0 0 0; padding: 0 0 0 0; background-color: #eee;">
                            <div style="width:600px; margin: 0 auto; padding:10px; background-color: #fff; font: normal 18px arial;">
                                <table style="width: 100%;" border:="0"; cellspacing="0";>
                                    <thead style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                    <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <td style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px 10px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 10px 0 0 0; padding: 0 0; text-align:left; display:block;">
                                                    <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" max-width="120px" width="" height="37"></a>
                                                </td>
                                                <td style=" margin: 0 0; padding: 0 0; font: normal 15px arial; text-align:right;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">'.$Array['address'].'</div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0; display:block;">
                                                    <a href="tel:'.$Array['helpline_no'].'" style="color:#000; text-decoration: none;">'.$Array['helpline_no'].'</a>
                                                    </div>
                                                    <div style="padding:0 0 0 0; margin: 0 0 3px 0;">
                                                    <a href="mailto:'.$Array['helpline_email_address'].'" target="_blank" style=" color:#000; text-decoration: none;">'.$Array['helpline_email_address'].'</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody style="padding: 0 0 0 0; margin: 0 0 0 0;">
                                        <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                            <table style="width: 100%; padding: 0 0; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr colspan="2">
                                                <td>
                                                <div style="min-height: 200px; padding: 30px; background-color: #f4f4f4;">
                                                    <div style="padding:0 0 0 0; margin: 0 0 0 0;">
                                                        '.$message.'
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                            </table>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <table style="width: 100%; background-color: #fff; padding: 0 0px; margin: 0 0 0 0;" border:="0"; cellspacing="0";>
                                            <tr style=" padding: 0 0 0 0; margin: 0 0 0 0;">
                                                <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com. All Rights Reserved.</td>
                                                <td style=" margin: 0 0; padding: 10px 0; font:normal 16px arial; width: 39%; display: inline-block; text-align: right;">
                                                    <a href="'.$Array['twitter_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/twitter_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['facebook_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/facebook_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['instagram_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/instagram_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>
                                                    <a href="'.$Array['youtube_link'].'" target="_blank" style="text-decoration: none;"><img src="'.base_url().'assets/frontend/images/youtube_icon.png" style=" width:30px; text-align: center; display: inline-block; padding:0; margin: 0 0; border-radius: 50%;">
                                                    </a>    
                                                </td>
                                            </tr>
                                        </table>
                                    </tfoot>
                                </table>
                            </div>
                        </body>';

        
		// Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <'.EMAIL_FROM.'>' . "\r\n";
        //echo $to.'<-->'.$subject.'<-->'.$headers;
        mail($to,$subject,$htmlMessage,$headers);
        return $retStatus;
    }
}

function getClient()
{
    
    include_once APPPATH.'libraries/vendor/autoload.php';
    //echo $path = '../';
    
    $client = new Google_Client();
    
    $client->setApplicationName('Gmail API PHP Quickstart');
    $client->setScopes('https://www.googleapis.com/auth/gmail.send');
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    
    // Load previously authorized token from a file, if it exists.
    // The file token.json stores the user's access and refresh tokens, and is
    // created automatically when the authorization flow completes for the first
    // time.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }
    
    // If there is no previous token or it's expired.
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    
    return $client;
}
function createMessage($sender, $to, $subject, $messageText) {
    $message = new Google_Service_Gmail_Message();
    
    $rawMessageString = "From: <{$sender}>\r\n";
    $rawMessageString .= "To: <{$to}>\r\n";
    $rawMessageString .= 'Subject: =?utf-8?B?' . base64_encode($subject) . "?=\r\n";
    $rawMessageString .= "MIME-Version: 1.0\r\n";
    $rawMessageString .= "Content-Type: text/html; charset=utf-8\r\n";
    //$rawMessageString .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    $rawMessageString .= 'Content-Transfer-Encoding: 8bit' . "\r\n\r\n";
    $rawMessageString .= "{$messageText}\r\n";
    //echo $messageText;
    $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
    $message->setRaw($rawMessage);
    return $message;
}
function sendMessage($service, $userId, $message) {
    try {
    $message = $service->users_messages->send($userId, $message);
    //print 'Message with ID: ' . $message->getId() . ' sent.';
    return $message;
    } catch (Exception $e) {
    //print 'An error occurred: ' . $e->getMessage();
    }
    return null;
}

if(!function_exists('setCuratedSlug')){
    function setCuratedSlug($slug){
        $CI = &get_instance();
        $CI->db->select("COUNT(*) AS NumHits");
        $CI->db->from(TABLE_PREFIX."cutared_contents");
        $CI->db->like('title_slug', $slug, 'after');
        $CI->db->where('status', 1);
        // $getQuery = $CI->db->query("SELECT COUNT(*) AS NumHits FROM ".TABLE_PREFIX."categories WHERE cat_slug  LIKE '$slug%'");
        $getQuery = $CI->db->get();
        $row = $getQuery->row_array();
        $numHits = $row['NumHits'];
        // echo ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
        return ($numHits > 0) ? ($slug . '-' . $numHits) : $slug;
    }
}

if(!function_exists('create_url_slug')){
    function create_url_slug($url){
        # Prep string with some basic normalization
        $url = strtolower($url);
        $url = strip_tags($url);
        $url = stripslashes($url);
        $url = html_entity_decode($url);

        # Remove quotes (can't, etc.)
        $url = str_replace('\'', '', $url);

        # Replace non-alpha numeric with hyphens
        $url = trim(preg_replace('/[^a-z0-9]+/', '-', $url));
        $url = trim(preg_replace(' ', '-', $url));
        return $url;
    }
}

if(!function_exists('checkAuthorization'))
{
    function checkAuthorization($type,$section){
        $CI = &get_instance();
        if($CI->session->userdata('authorize') == 'ALL')
        {
            return true;
        }else{
            $subarray = $CI->session->userdata('authorize');
            // print '<pre>';
            // print_r($subarray);
            // die;
            if(array_key_exists($type,$subarray))
            {
                $IndividualArr = $subarray[$type];
                if($section == 'LIST')
                {
                    return true;
                }else
                {
                    if(is_array($subarray))
                    {
                        if(in_array($section,$IndividualArr))
                        {
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }
            }else{
                return false;
            }
            
        }
    }
}
/*
* HELPER FUNCTIONS
* Author: Peter
* We use these functions to obfuscate js code before we print
* it to HTML output
*/
if(!function_exists('inline_code')) {
    function inline_code($type, $handle, $source, $obfuscator = false) {
        /*ignore the verification failure*/
    $stream_opts = [
        "ssl" => [
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ]
      ];
      if ($type == 'script') {
            include_once APPPATH . '/libraries/JavaScriptPacker.php';
            $script = file_get_contents(trim($source),false, stream_context_create($stream_opts));
              if ($obfuscator) {
                  $packer = new JavaScriptPacker($script, 'Normal', true, false);
                  $packed = $packer->pack();
                  echo "<script id='$handle'>";
                  echo $packed;
                  echo "</script>";
              } else {
                  echo "<script id='$handle'>";
                  echo $script;
                  echo "</script>";
              }
          } else if ($type == 'style') {
            $style = file_get_contents(trim($source),false, stream_context_create($stream_opts));
              $style = str_replace('url(../images','url('.base_url()."assets/frontend/images",$style);
              // $style = str_replace('url("../','url("'.$this->urlTEMPLATE,$style);
              $style = str_replace("url('../fonts","url('".base_url()."assets/frontend/fonts",$style);
              $style = str_replace('url("../fonts','url("'.base_url().'assets/frontend/fonts',$style);
              $style = str_replace("url(../fonts","url(".base_url()."assets/frontend/fonts",$style);
              $style = str_replace("\n", "", $style);
              $style = str_replace("  ", " ", $style);
              $style = str_replace("  ", " ", $style);
              $style = str_replace(" {", "{", $style);
              $style = str_replace("{ ", "{", $style);
              $style = str_replace(" }", "}", $style);
              $style = str_replace("} ", "}", $style);
              $style = str_replace(", ", ",", $style);
              $style = str_replace("; ", ";", $style);
              $style = str_replace(": ", ":", $style);
              echo "<style>";
              echo $style;
              echo "</style>";
          }

    }
}

function pre($param) {
    echo '<pre>';
    print_r($param);
    echo '</pre>';
}

/**
 * Create PDF
 */
if(!function_exists('createNDApdf')){
    function createNDApdf($pdfContent, $listingID, $userId, $hiddenSign){
        $CI = &get_instance();
        $CI->load->model('admin_model');
        $CI->load->model('admin_cms_model');
        $CI->load->library('M_pdf');
        $getUserData = $CI->admin_model->getUserDetails($userId);
		$getUncoveredListDetails = $CI->admin_model->getUncoveredListByID($listingID);
		$getDigiSign = $CI->admin_model->getUserDigiSign($userId);
		$decryptJson = json_decode($getUncoveredListDetails['dJson'], true);

        $getNDAContent = $CI->admin_cms_model->getCMSPageDetailsbyslug('nda-content');

        $genHTML = stripslashes($getNDAContent['pageContent']);
        $genHTML .= '<table style="overflow: wrap;border-collapse: separate;max-width:600px; border-spacing: 20px;">
                        <tr>
                            <td colspan="2" style="padding:0 0 26px 0; font-size:20px;line-height:24px;"><strong>FIH/Seller Representative</strong></td>
                            <td style="padding:0 0 26px 0; font-size:20px;line-height:24px; text-align:left;"><strong>Buyer</strong></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">By:</td>
                            <td><span style="border-bottom:2px solid #000; padding:0 0 0 10px;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/signature.png" style="height:40px; object-fit: contain;" /></span></td>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">By:</td>
                            <td><strong style="font-size:18px;line-height:24px; text-transform: uppercase;">'.(!empty($hiddenSign) ? '<img src="'.$hiddenSign.'" style="" />' : (!empty($getDigiSign) && $getDigiSign->documents != '' ? '<img src="'.base_url().'/uploads/user_digital_signature/'.$getDigiSign->documents.'" style="" />' : '____________________')).'</strong></td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 22px 0; display:flex; font-size:18px;line-height:24px;">Printed Name:</td>
                            <td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/neil_image.png" style="height:20px; object-fit: contain;"></span></td>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Printed Name:</td>
                            <td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.$getUserData->fname.' '.$getUserData->lname.'</strong></td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 22px 0;font-size:18px;line-height:24px;">Title:</td>
                            <td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/ceo.png" style="height:20px; object-fit: contain;"></span></td>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Title:</td>
                            <td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">Potential Buyer For '.$decryptJson['website'][0].'</strong></td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Address:</td>
                            <td><span style="border-bottom:2px solid #000;"><img src="'.base_url().'/assets/backend/img/nda_pdf_imgs/address.png" style="height:20px; object-fit: contain;"></span></td>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Address:</td>
                            <td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.$getUserData->mail.'</strong></td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Dated:</td>
                            <td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.date('d/m/Y', strtotime($getUncoveredListDetails['date_unlocked'])).'</strong></td>
                            <td style="padding:0 0 22px 0; font-size:18px;line-height:24px;">Dated:</td>
                            <td><strong style="font-size:12px;line-height:24px; text-transform: uppercase; border-bottom:2px solid #000;">'.date('d/m/Y', strtotime($getUncoveredListDetails['date_unlocked'])).'</strong></td>
                        </tr>
                    </table>';
                    // '.(!empty($getDigiSign) && $getDigiSign->documents != '' ? '<img src="'.base_url().'/uploads/user_digital_signature/'.$getDigiSign->documents.'" style="height:40px; object-fit: contain;" />' : '____________________').' height:40px; object-fit: contain;
        
                    // $CI->m_pdf->pdf->shrink_tables_to_fit = 1;
        $CI->m_pdf->pdf->WriteHTML($genHTML);

        $targetFolder = './uploads/user_signed_nda_s/';
        $pdfFullName = 'signed_nda_by_'.$userId.'_for_listing_'.$listingID.'.pdf';
        $PDFFile = $targetFolder . $pdfFullName;

        $CI->m_pdf->pdf->Output($PDFFile, 'F');
        return $pdfFullName;
    }
}