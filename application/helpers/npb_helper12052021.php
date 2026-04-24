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
        $url = 'https://www.fih.com/'.$url;
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
        
        $mail->setFrom(EMAIL_FROM, FROM_NAME);
        //$mail->addReplyTo('info@example.com', 'CodexWorld');
        
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
                                                    <a href="'.base_url().'" target="_blank"><img  src="'.base_url().'uploads/logo_image/'.$Array['inside_logo'].'" width="" height="37"></a>
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
                                                <td style=" margin: 0 0; padding: 10px 0; font: normal 14px arial; width: 60%; display: inline-block;">Copyright <span>&#169;</span> '.date('Y').' FIH.com</td>
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
            //echo 'Message could not be sent.';
            //echo 'Host->'.SMTP_HOST.'<br>';
            //echo 'User->'.SMTP_USER.'<br>';
            //echo 'Password->'.SMTP_PASS.'<br>';
            //echo 'Secure->'.SMTP_SECURE.'<br>';
            //echo 'Port->'.SMTP_PORT.'<br>';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            //die;
        }else{
            return true;
        }
        return $retStatus;
    }
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