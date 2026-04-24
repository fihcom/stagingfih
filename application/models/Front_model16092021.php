<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Front_model extends CI_Model
{
    function checkExistingUser($email)
    {
        $this->db->select('BaseTbl.userId', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.Status !=', 0);
        $this->db->where('BaseTbl.mail', $email);
        $this->db->limit(1);
        $query = $this->db->get();        
        $user = $query->row();
        if(!empty($user)){
            return $user;
        } else {
            return null;
        }
    }

    function add_user($editArray){
        $editArray['promo_code'] = $this->generatepromocode();
        $this->db->insert(TABLE_PREFIX.'users', $editArray);
        $insertId = $this->db->insert_id();
        $userdetailsArray['userId'] = $insertId;
        //$this->db->insert(TABLE_PREFIX.'user_details', $userdetailsArray);
        return $insertId;
    }

    function userLogin($email, $password)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.password, BaseTbl.fname AS name,BaseTbl.role, BaseTbl.mail, BaseTbl.phone, BaseTbl.authorize', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.mail', $email);
        $this->db->where('BaseTbl.Status', 1);
        $this->db->limit(1);
        $query = $this->db->get();        
        $user = $query->row();
        if(!empty($user)){
            if(verifyHashedPassword($password, $user->password)){
                return $user;
            } else {
                return array();
            }
        } else {
            return array();
        }/**/
        
    }

    function checkOAuthProvider($provider,$oauthid)
    {
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'users AS USRS');
        $this->db->where('USRS.oauth_uid', $oauthid);
        $this->db->where('USRS.oauth_provider', $provider);
        $this->db->limit(1);
        //$this->db->where('USRS.Status', 1);
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function userLoginoncookie($cookie)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.password, BaseTbl.fname AS name, BaseTbl.mail, BaseTbl.phone', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.remember_me', $cookie);
        $this->db->where('BaseTbl.Status', 1);
        $this->db->limit(1);
        $query = $this->db->get();        
        $user = $query->row();
        //die;
        if(!empty($user)){
            return $user;
        } else {
            return array();
        }
    }

    function userForgetPass($email)
    {
        $this->db->select('BaseTbl.userId, BaseTbl.mail,BaseTbl.fname AS name', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.mail', $email);
        $this->db->where('BaseTbl.oauth_provider','');
        $this->db->where('BaseTbl.Status', 1);
        $this->db->limit(1);
        $query = $this->db->get();        
        $user = $query->row();
        if(!empty($user)){
            $randomstring = substr(str_shuffle(RANDOM_CHAR), 0, 10);
            $this->db->set('activation_str', $randomstring);
            $this->db->where('userId', $user->userId);
            $this->db->update(TABLE_PREFIX.'users');
            $user->passwordResetCode = $randomstring;
            return $user;
        } else {
            return array();
        }
    }

    function getAdminDetails($adminID){
        $this->db->select('USRM.*');
        $this->db->from(TABLE_PREFIX.'users AS USRM');
        $this->db->where('USRM.userId', $adminID);
        $this->db->limit(1);
        $Query = $this->db->get();

        //echo $this->db->last_query();
        $Array = $Query->row_array();
        return $Array;
    }

    function emailconfirm($email,$random)
    {
        $this->db->select('BaseTbl.*', FALSE);
        $this->db->from(TABLE_PREFIX.'users as BaseTbl', FALSE);
        $this->db->where('BaseTbl.mail', $email);
        $this->db->where('BaseTbl.Status', 0);
        $this->db->where('BaseTbl.activation_str', $random);
        $this->db->limit(1);
        $query = $this->db->get();        
        $user = $query->row();
        if(!empty($user)){
            $userid = $user->userId;
            $this->db->where('userId', $userid);
            $editArray['activation_str'] = '';
            $editArray['Status'] = 1;
            $this->db->update(TABLE_PREFIX.'users', $editArray);
        }
        return $user;
    }

    function getSelectedCurreny($currencyId){
        $query = $this->db->query("select c.* from ".TABLE_PREFIX."currencies c where c.id=$currencyId");
        $currency = $query->row();
        return $currency;
    }
    function updateAdminDetails($editArray, $adminID,$detailsArr = array()){
        if(is_array($editArray) && count($editArray)>0)
        {
            $this->db->where('userId', $adminID);
            $this->db->update(TABLE_PREFIX.'users', $editArray);
        }
        return $this->db->affected_rows();
    }
    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        /*$string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );*/
        $string = array(
            'y' => 'year',
            'm' => 'month'
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(' ', $string) . ' old' : 'just now';
    }

    function getBusinessListing($listingId){
        $this->db->select('BaseTbl.*,ind.industry as industryname,br.userId as buyer,br.sellerId as seller', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_record as BaseTbl', FALSE);
        $this->db->join(TABLE_PREFIX.'industries as ind','ind.id = BaseTbl.industry','left');
        $this->db->join(TABLE_PREFIX.'buy_request as br','br.listing_id = BaseTbl.listing_id and br.status=2','left');
        //$this->db->where('BaseTbl.listing_id', $listingId);
        $this->db->where('(BaseTbl.listing_id ='. $listingId.' and BaseTbl.Status = 1) OR (BaseTbl.listing_id ='. $listingId.' and BaseTbl.Status = 4) OR (BaseTbl.listing_id ='. $listingId.' and BaseTbl.Status = 3)');
        //$this->db->or_where('BaseTbl.Status',4);
        $this->db->limit(1);
        $query = $this->db->get();        
        $listing = $query->row();
        
        $Monetization = json_decode($listing->monetization,true);
        $listing->website = json_decode($listing->website,true);
        $asset_list = json_decode($listing->asset_list,true);
        $assetlistarr = [];
        if(is_array($asset_list) && count($asset_list)>0)
        {
            foreach($asset_list as $val)
            {
                $assetlistarr[] = $val['value'];
            }
            
        }
        $listing->asset_list = $assetlistarr;
        $listing->other_info = json_decode($listing->other_info,true);
        $listing->skills = json_decode($listing->skills,true);
        $listing->buyer_profile = json_decode($listing->buyer_profile,true);
        $listing->Strength = json_decode($listing->Strength,true);
        $listing->Opertunities = json_decode($listing->Opertunities,true);
        $listing->Weakness = json_decode($listing->Weakness,true);
        $listing->Threats = json_decode($listing->Threats,true);
        $listing->youtube_url = json_decode($listing->youtube_url,true);
        $listing->extrasocialmedia = json_decode($listing->extrasocialmedia,true);
        $listing->earnings = json_decode($listing->earnings,true);
        $listing->traffic = json_decode($listing->traffic,true);
        $listing->business_age = $this->time_elapsed_string($listing->business_create_date,true);
        $listing->seo_data = json_decode($listing->seo_data,true);

        $this->db->select('BaseTbl.name', FALSE);
        $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
        $this->db->where_in('BaseTbl.slug', $Monetization);
        $this->db->where('BaseTbl.Status', 1);
        $query = $this->db->get();        
        $monetization = $query->result_array();
        $listing->monetization = $monetization;
        $datapost['page'] = 0;
        $datapost['limit'] = 10;
        $datapost['listing_id'] = $listingId;
        $datapost['Status'] = 2;
        $listing->faq = $this->get_faq_seller($datapost);
        $query = $this->db->query("select c.*,s.wire_bank_name,s.wire_bank_address,s.wire_swift_code,s.wire_credit_account_name,s.wire_aba_routing,s.wire_credit_account_no,s.wire_beneficiary_address,s.wire_additional_info from ".TABLE_PREFIX."currencies c join ".TABLE_PREFIX."site_settings s on s.currency=c.id where s.id>0");
        $listing->sitesettings = $query->row();

        
        return $listing;
    }
    function getRecomendedListing($options){
        $listingId = $options['listingId'];
        $industry = $options['industry'];
        $start = $options['start'];
        $limit = $options['limit'];
        $userId = $options['userId'];
        $this->db->select('BaseTbl.monetization,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.price,BaseTbl.listing_id,BaseTbl.traffic_per_month,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,c.name as countryname', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_record as BaseTbl', FALSE);
        $this->db->join(TABLE_PREFIX.'industries as ind','ind.id = BaseTbl.industry');
        $this->db->join(TABLE_PREFIX.'countries as c','c.id = BaseTbl.country','left');
        $this->db->where('BaseTbl.listing_id <>', $listingId);
        $this->db->where('BaseTbl.industry', $industry);
        $this->db->where('BaseTbl.Status', 1);
        $this->db->limit($limit,$start);
        $query = $this->db->get();        
        $listing = $query->result_array();
        if(is_array($listing) && count($listing)>0)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetization = $query->result_array();
                    $listing[$l]['monetization'] = $monetization;
                    $mArr = [];
                    if(is_array($monetization) && count($monetization)>0)
                    {
                        foreach($monetization as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                
                if($listing[$l]['business_image'] ==''){
                    $listing[$l]['business_image'] = 'banner.jpg';
                }
                $listingId = $vv['listing_id'];
                //$listing[$l]['userId'] = $userId;
                if($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                $l++;
            }
        }

        $q = "select count(BaseTbl.id) as totalList from ".TABLE_PREFIX."sell_record as BaseTbl where  (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3)";
        $query = $this->db->query($q);    
        $listingtotal = $query->row();
        
        return ['recomended'=>$listing,'totallist'=>$listingtotal];
    }

    function getUserUnlockedListing($options){
        $start = $options['start'];
        $limit = $options['limit'];
        $detaillisting = ($options['detaillisting'])?$options['detaillisting']:true;
        $Monitization = $options['Monitization'];
        $businessAge = $options['businessAge'];
        $priceMin = $options['min'];
        $priceMax = $options['max'];
        $searchText = $options['searchText'];
        $userId = $options['userId'];
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.traffic_per_month,BaseTbl.userId,BaseTbl.Status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,C.name as countryname,br.userId as buyer,br.sellerId as seller from 
        ".TABLE_PREFIX."investor_pass_history as h
        join ".TABLE_PREFIX."sell_record as BaseTbl on h.unlocked_business=BaseTbl.listing_id
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        left join ".TABLE_PREFIX."buy_request br ON br.listing_id=BaseTbl.listing_id and br.status=2
        where h.activity='UNCOVER' and h.userId=$userId and (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3) ".$partSql." group by BaseTbl.listing_id order by BaseTbl.date_added desc limit ".$start.",".$limit."";
        /*$q = "select SQL_CALC_FOUND_ROWS h.* from 
        ".TABLE_PREFIX."investor_pass_history as h
        where h.activity='UNCOVER' and h.userId='$userId'";*/
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        if(is_array($listing) && count($listing)>0 && $detaillisting == true)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();
                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                $listing[$l]['unlocked'] = true;
                if($listing[$l]['business_image'] ==''){
                    $listing[$l]['business_image'] = 'banner.jpg';
                }
                $l++;
            }
        }
        return array("totalrecord"=>$totalrecord,"listing"=>$listing);
    }
    function getMarketplaceListing($options){
        $start = $options['start'];
        $limit = $options['limit'];
        $detaillisting = ($options['detaillisting'])?$options['detaillisting']:true;
        $Monitization = $options['Monitization'];
        $businessAge = $options['businessAge'];
        $priceMin = $options['min'];
        $priceMax = $options['max'];
        $searchText = $options['searchText'];

        $ProfitFrom = $options['ProfitFrom'];
        $ProfitTo = $options['ProfitTo'];

        $RevenueFrom = $options['RevenueFrom'];
        $RevenueTo = $options['RevenueTo'];

        $MultipleFrom = $options['MultipleFrom'];
        $MultipleTo = $options['MultipleTo'];

        $trafficFrom = $options['TrafficFrom'];
        $trafficTo = $options['TrafficTo'];
        $show_home = $options['show_home'];

        $userId = $options['userId'];
        if($Monitization != '')
        {
            $partSql = " and BaseTbl.monetization like '%".$Monitization."%'";
        }
        if($businessAge != '')
        {
            $currentMonth = date('m');
            /*if($businessAge == '5less')
            {
                $currentYear = (date('Y')-5);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '10less')
            {
                $currentYear = (date('Y')-10);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '20less')
            {
                $currentYear = (date('Y')-20);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '40less')
            {
                $currentYear = (date('Y')-40);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '40more')
            {
                $currentYear = (date('Y')-40);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date < '".$dateRange."'";
            }*/
            if($businessAge == '6monthless')
            {
                $partSql .= " and BaseTbl.business_create_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)";
            }elseif($businessAge == '6-12months')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 6 MONTH)";
            }elseif($businessAge == '1-2yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 2 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }elseif($businessAge == '2-5yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 5 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 2 YEAR)";
            }elseif($businessAge == '5-10yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 10 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 5 YEAR)";
            }elseif($businessAge == '10more')
            {
                $partSql .= " and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 10 YEAR)";
            }
        }
        if($priceMin != '')
        {
            $partSql .= " and BaseTbl.price >='".$priceMin."'";
        }
        if($priceMax != '')
        {
            $partSql .= " and BaseTbl.price <='".$priceMax."'";
        }
        if($searchText != '')
        {
            $partSql .= " and (BaseTbl.listing_id like '%".$searchText."%' || BaseTbl.summery like '%".$searchText."%' || BaseTbl.reason_for_sale like '%".$searchText."%' || BaseTbl.support_seller_included like '%".$searchText."%' || BaseTbl.other_info like '%".$searchText."%' || BaseTbl.buyer_profile like '%".$searchText."%' || BaseTbl.skill_description like '%".$searchText."%' || BaseTbl.buyer_profile_description like '%".$searchText."%' || BaseTbl.other_info_description like '%".$searchText."%' || BaseTbl.Strength like '%".$searchText."%' || BaseTbl.Opertunities like '%".$searchText."%' || BaseTbl.Weakness like '%".$searchText."%' || BaseTbl.Threats like '%".$searchText."%' || BaseTbl.earnings like '%".$searchText."%' || ind.industry like '%".$searchText."%' || C.name like '%".$searchText."%')";
        }

        if($ProfitFrom !='')
        {
            $partSql .= " and BaseTbl.monthly_profit>=$ProfitFrom";
        }
        if($ProfitTo != '')
        {
            $partSql .= " and BaseTbl.monthly_profit<=$ProfitTo";
        }

        if($RevenueFrom != '')
        {
            $partSql .= " and BaseTbl.monthly_revenue>=$RevenueFrom";
        }
        if($RevenueTo != '')
        {
            $partSql .= " and BaseTbl.monthly_revenue<=$RevenueTo";
        }


        if($MultipleFrom != '')
        {
            $partSql .= " and BaseTbl.multiple>=$MultipleFrom";
        }
        if($MultipleTo != '')
        {
            $partSql .= " and BaseTbl.multiple <= $MultipleTo";
        }
        if($trafficFrom != '')
        {
            $partSql .= " and BaseTbl.traffic_per_month >= $trafficFrom";
        }
        if($trafficTo != '')
        {
            $partSql .= " and BaseTbl.traffic_per_month <=$trafficTo";
        }
        if($show_home == 'Y')
        {
            $partSql .= " and BaseTbl.show_home ='Y'";
        }

        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.userId,BaseTbl.Status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,BaseTbl.traffic_per_month,ind.industry as industryname,C.name as countryname,br.userId as buyer,br.sellerId as seller from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        left join ".TABLE_PREFIX."buy_request br ON br.listing_id=BaseTbl.listing_id and br.status=2
        where (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3) ".$partSql." group by BaseTbl.listing_id order by BaseTbl.date_added desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        if(is_array($listing) && count($listing)>0 && $detaillisting == true)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                if($listing[$l]['business_image'] == '')
                $listing[$l]['business_image'] = 'banner.jpg';
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $listing[$l]['traffic_per_month'] = $vv['traffic_per_month'];

                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();
                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                //$listing[$l]['monetizationStr'] = $monetizationRes;
                $listingId = $vv['listing_id'];
                //$listing[$l]['userId'] = $userId;
                if($userId == $vv['userId'])
                {
                    $listing[$l]['unlocked'] = true;
                }
                elseif($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                $l++;
            }
        }
        return array("totalrecord"=>$totalrecord,"listing"=>$listing,'qrty'=>$q);
    }

    function getMinMaxDetails(){
        //
        $q = "select max(BaseTbl.price) as maxPrice,min(BaseTbl.price) as minPrice,max(BaseTbl.monthly_revenue) as maxRevenue,min(BaseTbl.monthly_revenue) as minRevenue,max(BaseTbl.monthly_profit) as maxProfit,min(BaseTbl.monthly_profit) as minProfit,max(BaseTbl.multiple) as maxMultiple,min(BaseTbl.multiple) as minMultiple,min(BaseTbl.traffic_per_month) as minTraffic,max(BaseTbl.traffic_per_month) as maxTraffic from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        where  (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3) limit 0,1";
        $query = $this->db->query($q);    
        $manmin = $query->row();
        return $manmin;
    }
    function getRecentListing($options){
        $start = $options['start'];
        $limit = $options['limit'];
        $detaillisting = ($options['detaillisting'])?$options['detaillisting']:true;
        $Monitization = $options['Monitization'];
        $businessAge = $options['businessAge'];
        $priceMin = $options['min'];
        $priceMax = $options['max'];
        $searchText = $options['searchText'];
    
        $ProfitFrom = $options['ProfitFrom'];
        $ProfitTo = $options['ProfitTo'];
    
        $RevenueFrom = $options['RevenueFrom'];
        $RevenueTo = $options['RevenueTo'];
    
        $MultipleFrom = $options['MultipleFrom'];
        $MultipleTo = $options['MultipleTo'];
    
        $trafficFrom = $options['TrafficFrom'];
        $trafficTo = $options['TrafficTo'];
        $show_home = $options['show_home'];
    
        $userId = $options['userId'];
        if($Monitization != '')
        {
            $partSql = " and BaseTbl.monetization like '%".$Monitization."%'";
        }
        if($businessAge != '')
        {
            $currentMonth = date('m');
            /*if($businessAge == '5less')
            {
                $currentYear = (date('Y')-5);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '10less')
            {
                $currentYear = (date('Y')-10);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '20less')
            {
                $currentYear = (date('Y')-20);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '40less')
            {
                $currentYear = (date('Y')-40);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date > '".$dateRange."'";
            }elseif($businessAge == '40more')
            {
                $currentYear = (date('Y')-40);
                $dateRange = $currentYear.'-'.$currentMonth.'-01';
                $partSql .= " and BaseTbl.business_create_date < '".$dateRange."'";
            }*/
            if($businessAge == '6monthless')
            {
                $partSql .= " and BaseTbl.business_create_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)";
            }elseif($businessAge == '6-12months')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 12 MONTH) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 6 MONTH)";
            }elseif($businessAge == '1-2yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 2 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 1 YEAR)";
            }elseif($businessAge == '2-5yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 5 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 2 YEAR)";
            }elseif($businessAge == '5-10yrs')
            {
                $partSql .= " and BaseTbl.business_create_date >= DATE_SUB(NOW(), INTERVAL 10 YEAR) and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 5 YEAR)";
            }elseif($businessAge == '10more')
            {
                $partSql .= " and BaseTbl.business_create_date <= DATE_SUB(NOW(), INTERVAL 10 YEAR)";
            }
        }
        if($priceMin != '')
        {
            $partSql .= " and BaseTbl.price >='".$priceMin."'";
        }
        if($priceMax != '')
        {
            $partSql .= " and BaseTbl.price <='".$priceMax."'";
        }
        if($searchText != '')
        {
            $partSql .= " and (BaseTbl.listing_id like '%".$searchText."%' || BaseTbl.summery like '%".$searchText."%' || BaseTbl.reason_for_sale like '%".$searchText."%' || BaseTbl.support_seller_included like '%".$searchText."%' || BaseTbl.other_info like '%".$searchText."%' || BaseTbl.buyer_profile like '%".$searchText."%' || BaseTbl.skill_description like '%".$searchText."%' || BaseTbl.buyer_profile_description like '%".$searchText."%' || BaseTbl.other_info_description like '%".$searchText."%' || BaseTbl.Strength like '%".$searchText."%' || BaseTbl.Opertunities like '%".$searchText."%' || BaseTbl.Weakness like '%".$searchText."%' || BaseTbl.Threats like '%".$searchText."%' || BaseTbl.earnings like '%".$searchText."%' || ind.industry like '%".$searchText."%' || C.name like '%".$searchText."%')";
        }
    
        if($ProfitFrom !='')
        {
            $partSql .= " and BaseTbl.monthly_profit>=$ProfitFrom";
        }
        if($ProfitTo != '')
        {
            $partSql .= " and BaseTbl.monthly_profit<=$ProfitTo";
        }
    
        if($RevenueFrom != '')
        {
            $partSql .= " and BaseTbl.monthly_revenue>=$RevenueFrom";
        }
        if($RevenueTo != '')
        {
            $partSql .= " and BaseTbl.monthly_revenue<=$RevenueTo";
        }
    
    
        if($MultipleFrom != '')
        {
            $partSql .= " and BaseTbl.multiple>=$MultipleFrom";
        }
        if($MultipleTo != '')
        {
            $partSql .= " and BaseTbl.multiple <= $MultipleTo";
        }
        if($trafficFrom != '')
        {
            $partSql .= " and BaseTbl.traffic_per_month >= $trafficFrom";
        }
        if($trafficTo != '')
        {
            $partSql .= " and BaseTbl.traffic_per_month <=$trafficTo";
        }
        
    
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.userId,BaseTbl.Status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,BaseTbl.traffic_per_month,ind.industry as industryname,C.name as countryname,br.userId as buyer,br.sellerId as seller from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        left join ".TABLE_PREFIX."buy_request br ON br.listing_id=BaseTbl.listing_id and br.status=2
        where (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3) and BaseTbl.show_home ='Y'  group by BaseTbl.listing_id order by BaseTbl.date_added desc limit ".$start.",".$limit."";
        
        $query = $this->db->query($q);    
        $listing = $query->result_array();
        
        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        
        if(is_array($listing) && count($listing)>0 && $detaillisting == true)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                if($listing[$l]['business_image'] == '')
                $listing[$l]['business_image'] = 'banner.jpg';
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $listing[$l]['traffic_per_month'] = $vv['traffic_per_month'];
    
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();
                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                //$listing[$l]['monetizationStr'] = $monetizationRes;
                $listingId = $vv['listing_id'];
                //$listing[$l]['userId'] = $userId;
                if($userId == $vv['userId'])
                {
                    $listing[$l]['unlocked'] = true;
                }
                elseif($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                $l++;
            }
        }
        
        return array("totalrecord"=>$totalrecord,"listing"=>$listing);
        }
    
    function getSellerListing($options){
        $start = $options['start'];
        $limit = $options['limit'];
        $Monitization = $options['Monitization'];
        $priceRange = $options['priceRange'];
        $userId = $options['userId'];
        if($Monitization != '')
        {
            $partSql = " and BaseTbl.monetization like '%".$Monitization."%'";
        }
        if($priceRange != '')
        {
            $partSql .= " and BaseTbl.price <='".$priceRange."'";
        }
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.traffic_per_month,BaseTbl.userId,BaseTbl.Status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,C.name as countryname,br.userId as buyer,br.sellerId as seller from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        left join ".TABLE_PREFIX."buy_request br ON br.listing_id=BaseTbl.listing_id and br.status=2
        where  (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3) and BaseTbl.userId=".$userId." ".$partSql." group by BaseTbl.listing_id order by BaseTbl.date_added desc limit ".$start.",".$limit."";
        
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        if(is_array($listing) && count($listing)>0)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();
                
                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                $listingId = $vv['listing_id'];
                if($listing[$l]['business_image'] == '')
                $listing[$l]['business_image'] = 'banner.jpg';
                //$listing[$l]['userId'] = $userId;
                if($userId == $vv['userId'])
                {
                    $listing[$l]['unlocked'] = true;
                }
                elseif($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                $l++;
            }
        }
        return array("totalrecord"=>$totalrecord,"listing"=>$listing);
    }

    function getMarketplaceListingpermission($arr){
        $user = $arr['user'];
        $listingNo = $arr['listingId'];
        $buy_ref = $arr['buy_ref'];
        $this->db->select("no_unload_per_vip,unlock_profile_amt_more,helpline_email_address");
        $this->db->from(TABLE_PREFIX.'site_settings');
        $Query = $this->db->get();
        $Array = $Query->row_array();

        $isUnlocked = false;
        $isIdentityProofed = false;
        $isFundProofed = false;
        $isAvailFund = false;

        $this->db->select('userdetails.Investor_pass,userdetails.fund_approved_amount,userdetails.fund_source,userdetails.proof_fund_status,userdetails.identity_proof_status', FALSE);
        $this->db->from(TABLE_PREFIX.'users as user', FALSE);
        $this->db->join(TABLE_PREFIX.'user_details as userdetails','userdetails.userId = user.userId');
        $this->db->where_in('user.Status', 1);
        $this->db->where('user.userId', $user);
        $query = $this->db->get();        
        $investorPass = $query->row();

        if($investorPass->Investor_pass !='')
        {
            $this->db->select('invpass.*', FALSE);
            $this->db->from(TABLE_PREFIX.'investor_pass_history as invpass', FALSE);
            $this->db->where_in('invpass.activity', 'UNCOVER');
            $this->db->where('invpass.userId', $user);
            $this->db->where('invpass.investor_pass', $investorPass->Investor_pass);
            $query = $this->db->get();        
            $investorPassCount = $query->result_array();

            if(is_array($investorPassCount) && count($investorPassCount)>0)
            {
                foreach($investorPassCount as $val)
                {
                    if($val['unlocked_business'] == $listingNo)
                    {
                        $isUnlocked = true;
                        
                    }
                }
            }
            $kkk = $isUnlocked;
            
            if($isUnlocked == false)
            {
                
                $this->db->select('invpass.*', FALSE);
                $this->db->from(TABLE_PREFIX.'investor_pass_history as invpass', FALSE);
                $this->db->where_in('invpass.activity', 'UNCOVER');
                $this->db->where('invpass.userId', $user);
                $this->db->where('invpass.unlocked_business', $listingNo);
                $query = $this->db->get();        
                $isunlockedQry = $query->row();
                if($isunlockedQry->id >0)
                {
                    $isUnlocked = true;
                }
                //
                $this->db->select('sr.price,sr.userId', FALSE);
                $this->db->from(TABLE_PREFIX.'sell_record as sr', FALSE);
                $where = "(sr.Status=1 or sr.Status=3)"; 
                $this->db->where($where);
                $this->db->where('sr.listing_id', $listingNo);
                $query = $this->db->get();        
                $businessDetails = $query->row();

                if($businessDetails->userId == $user)
                {
                    $isUnlocked = true;
                }
                
                $AllowablePrice = $investorPass->fund_approved_amount*((100+$Array['unlock_profile_amt_more'])/100);
                $kak = $listingNo;
                $offer['listingId'] = $listingNo;
                $offer['user'] = $user;
                $offerDetails = $this->get_user_offer($offer);
                if($offerDetails->offer_price>0)
                {
                    $businessPrice = $offerDetails->offer_price;
                }else{
                    $businessPrice = $businessDetails->price;
                }

                if($AllowablePrice >= $businessPrice)
                {
                    $isAvailFund = true;
                }
                
            }else{
                $AllowablePrice = $investorPass->fund_approved_amount*((100+$Array['unlock_profile_amt_more'])/100);
                $kak = $listingNo;
                $offer['listingId'] = $listingNo;
                $offer['user'] = $user;
                $offerDetails = $this->get_user_offer($offer);
                if($offerDetails->offer_price>0)
                {
                    $businessPrice = $offerDetails->offer_price;
                }else{
                    $businessPrice = $businessDetails->price;
                }

                if($AllowablePrice >= $businessPrice)
                {
                    $isAvailFund = true;
                }
            }
            
            
        }
        if($investorPass->identity_proof_status == 1)
        {
            $isIdentityProofed = true;
        }

        if($investorPass->proof_fund_status == 1)
        {
            $isFundProofed = true;
        }

        if($isFundProofed == true)
        $totalUnlockremaining = $Array['no_unload_per_vip'] - count($investorPassCount);
        if($isUnlocked == true && $buy_ref == 'Y')
        {
            $sellerDetails = $this->userDetailswrtlistingno($listingNo);
            $sellerId = $sellerDetails->userId;
            $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
            $this->db->from(TABLE_PREFIX.'user_buy_ref as BaseTbl', FALSE);
            $this->db->where('BaseTbl.listing_id', $listingNo);
            $this->db->where('BaseTbl.sellerId', $sellerId);
            $this->db->where('BaseTbl.userId', $user);
            $this->db->where('BaseTbl.area', 'LISTING');
            $this->db->limit(1);
            $query = $this->db->get();        
            $userRefDetails = $query->row();
            if($userRefDetails->id>0)
            {
                $refNumber = $userRefDetails->transaction_ref;
            }else{

                $refNumber = $this->generaterefnumber();
                
                $arrinsert['listing_id'] = $listingNo;
                $arrinsert['transaction_ref'] = $refNumber;
                $arrinsert['userId'] = $user;
                $arrinsert['sellerId'] = $sellerId;
                $arrinsert['area'] = 'LISTING';
                $arrinsert['redeemed'] = 'N';
                $this->db->insert(TABLE_PREFIX.'user_buy_ref', $arrinsert);
            }

            $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
            $this->db->from(TABLE_PREFIX.'buy_request as BaseTbl', FALSE);
            $this->db->where('BaseTbl.listing_id', $listingNo);
            $this->db->where('BaseTbl.sellerId', $sellerId);
            $this->db->where('BaseTbl.userId', $user);
            $this->db->where('BaseTbl.section', 'LISTING');
            $this->db->where('BaseTbl.status', 1);
            $query = $this->db->get();        
            $userBuyDetails = $query->row();

            if($userBuyDetails->id >0)
            {
                $buyRequestSent = 'Y';
            }

        }
        return array("totalunloadremaining"=>$totalUnlockremaining,"listing"=>$investorPass,"offerdetails"=>$offerDetails,'extra'=>$kkk,'sitesettings'=>$Array,'isunlocked'=>$isUnlocked,'isidentityproofed'=>$isIdentityProofed,'isfundproofed'=>$isFundProofed,'isavailablefund'=>$isAvailFund,'maxlistingprice'=>$AllowablePrice,'refNumber'=>$refNumber,'buyRequestSent'=>$buyRequestSent);
    }
    function generaterefnumber(){
        $randomstring = substr(str_shuffle(RANDOM_CHAR), 0, 15);

        $this->db->select('BaseTbl.id', FALSE);
        $this->db->from(TABLE_PREFIX.'user_buy_ref as BaseTbl', FALSE);
        $this->db->where('BaseTbl.transaction_ref', $randomstring);
        $query = $this->db->get();        
        $randomstringDetails = $query->row();
        if($randomstringDetails->id>0)
        {
            $this->generaterefnumber();
        }else{
            return $randomstring;
        }
    }

    function uncoverlisting($arr){

        $this->db->select('BaseTbl.*', FALSE);
        $this->db->from(TABLE_PREFIX.'investor_pass_history as BaseTbl', FALSE);
        $this->db->where('BaseTbl.userId', $arr['userId']);
        $this->db->where('BaseTbl.investor_pass', $arr['investor_pass']);
        $this->db->where('BaseTbl.activity', $arr['activity']);
        $this->db->where('BaseTbl.unlocked_business', $arr['unlocked_business']);
        $this->db->limit(1);
        $query = $this->db->get();        
        $passHistory = $query->row();
        if($passHistory->id >0)
        {
            return $passHistory->id;
        }else{
            $this->db->insert(TABLE_PREFIX.'investor_pass_history', $arr);
            return $this->db->insert_id();
        }
        
    }

    function insertfaq($arr,$action='add'){
        if($action == 'add')
        {
            $this->db->insert(TABLE_PREFIX.'faq', $arr);
            return $this->db->insert_id();
        }elseif($action == 'edit')
        {
            $this->db->where('id', $arr['id']);
            $this->db->update(TABLE_PREFIX.'faq',$arr);
            return $arr['id'];
        }
        
    }

    function userDetailswrtlistingno($listingId)
    {
        $this->db->select('U.fname,U.mail,U.userId', FALSE);
        $this->db->from(TABLE_PREFIX.'sell_record as BaseTbl', FALSE);
        $this->db->join(TABLE_PREFIX.'users as U','U.userId=BaseTbl.userId');
        $this->db->where('BaseTbl.listing_id', $listingId);
        $this->db->limit(1);
        $query = $this->db->get();        
        $userDetails = $query->row();
        return $userDetails;
    }

    function get_faq_seller($datapost)
    {
        $start = $datapost['page'];
        $limit = $datapost['limit'];
        //$datapost['userId'] = 3;
        if($datapost['id'] > 0)
        {
            $partSql = " and f.id=".$datapost['id'];
        }
        if($datapost['Status'] > 0)
        {
            $partSql = " and f.Status=".$datapost['Status'];
        }
        if($datapost['listing_id'] > 0)
        {
            $listingSql = "f.listing_id=".$datapost['listing_id'];
        }else{
            $listingSql = "f.listing_id IN ( SELECT listing_id FROM ".TABLE_PREFIX."sell_record WHERE userId = ".$datapost['userId'].")";
        }
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.fname,u.user_profile_pic,u.mail,date_format(f.date_added,'%D %b, %Y') as faqDate from 
        ".TABLE_PREFIX."faq as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        where ".$listingSql." ".$partSql."  order by f.date_added desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return ['record'=>$userDetails,'totalrecord'=>$totalrecord];
    }
    function get_faq_buyer($datapost)
    {
        $start = $datapost['page'];
        $limit = $datapost['limit'];
        $userId = $datapost['userId'];
        //$datapost['userId'] = 3;
        if($datapost['id'] > 0)
        {
            $partSql = " and f.id=".$datapost['id'];
        }
        if($datapost['Status'] > 0)
        {
            $partSql = " and f.Status=".$datapost['Status'];
        }
        if($datapost['listing_id'] > 0)
        {
            $partSql = " and f.listing_id=".$datapost['listing_id'];
        }/*else{
            $listingSql = "f.listing_id IN ( SELECT listing_id FROM ".TABLE_PREFIX."sell_record WHERE userId = ".$datapost['userId'].")";
        }*/
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.fname,u.user_profile_pic,u.mail,date_format(f.date_added,'%D %b, %Y') as faqDate from 
        ".TABLE_PREFIX."faq as f
        join ".TABLE_PREFIX."sell_record as sr on sr.listing_id=f.listing_id
        join ".TABLE_PREFIX."users as u on u.userId=sr.userId
        where f.userId=".$userId." ".$partSql."  order by f.date_added desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return ['record'=>$userDetails,'totalrecord'=>$totalrecord];
    }

    function get_curated_contents_seller($datapost)
    {
        $start = $datapost['page'];
        $limit = $datapost['limit'];
        $area = $datapost['area'];
        if($area == '')
        $area = 'SELLER';
        if($area == 'SELLER')
            $restrictedTo = 'BUYER';
        elseif($area == 'BUYER')
            $restrictedTo = 'SELLER';
        $q = "select SQL_CALC_FOUND_ROWS f.*,date_format(f.date_added,'%D %b, %Y') as curatedDate from 
        ".TABLE_PREFIX."cutared_contents as f
        where f.status=1 and f.relay_to<>'$restrictedTo' order by f.sort limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        return ['record'=>$userDetails,'totalrecord'=>$totalrecord];
    }

    function setlistingoffer($arr){
        $this->db->insert(TABLE_PREFIX.'listing_offers', $arr);
        return $this->db->insert_id();
    }
    
    function setlistingbuyoffer($arr){
        $this->db->insert(TABLE_PREFIX.'buy_request', $arr);
        return $this->db->insert_id();
    }

    function insertnewsletter($arr)
    {
        $email = $arr['newsletteremail'];
        $this->db->select('U.*', FALSE);
        $this->db->from(TABLE_PREFIX.'newsletter as U', FALSE);
        $this->db->where('U.subscribed', 1);
        $this->db->where('U.email', $email);
        $this->db->limit(1);
        $query = $this->db->get();        
        $newsletterDetails = $query->row();
        if($newsletterDetails->id > 0)
        {
            return false;
        }else{
            $arrData['email'] = $email;
            $this->db->insert(TABLE_PREFIX.'newsletter', $arrData);
            return true;
        }
    }

    function getOfferDetails($arr)
    {
        $partSql = '';
        $sellerId = $arr['userId'];
        //$sellerId = 3;
        $start = $arr['page'];
        $limit = $arr['limit'];
        if($arr['id'] > 0)
        {
            $partSql = " and f.id=".$arr['id'];
        }
        $listingSql = "f.sellerId='$sellerId'";
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.userId as buyeruserId,u.fname,u.user_profile_pic,u.mail,date_format(f.offer_date,'%D %b, %Y') as offerDate from 
        ".TABLE_PREFIX."listing_offers as f
        join ".TABLE_PREFIX."users as u on u.userId=f.userId
        where ".$listingSql." ".$partSql." order by f.offer_date desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        $query = $this->db->query("select c.* from ".TABLE_PREFIX."currencies c join ".TABLE_PREFIX."site_settings s on s.currency=c.id where s.id>0");
        $currency = $query->row();
        return ['record'=>$userDetails,'totalrecord'=>$totalrecord,'currency'=>$currency];
    }

    function getbuyerOfferDetails($arr)
    {
        $partSql = '';
        $buyerId = $arr['userId'];
        //$sellerId = 3;
        $start = $arr['page'];
        $limit = $arr['limit'];
        if($arr['id'] > 0)
        {
            $partSql = " and f.id=".$arr['id'];
        }
        $listingSql = "f.userId='$buyerId'";
        $q = "select SQL_CALC_FOUND_ROWS f.*,u.userId as buyeruserId,u.fname,u.user_profile_pic,u.mail,date_format(f.offer_date,'%D %b, %Y') as offerDate from 
        ".TABLE_PREFIX."listing_offers as f
        join ".TABLE_PREFIX."users as u on u.userId=f.sellerId
        where ".$listingSql." ".$partSql." order by f.offer_date desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        $query = $this->db->query("select c.* from ".TABLE_PREFIX."currencies c join ".TABLE_PREFIX."site_settings s on s.currency=c.id where s.id>0");
        $currency = $query->row();
        return ['record'=>$userDetails,'totalrecord'=>$totalrecord,'currency'=>$currency];
    }


    function approveoffedr($arr)
    {
        $this->db->select('U.*', FALSE);
        $this->db->from(TABLE_PREFIX.'listing_offers as U', FALSE);
        $this->db->where('U.sellerId', $arr['clientId']);
        $this->db->where('U.id', $arr['offerId']);
        $this->db->limit(1);
        $query = $this->db->get();        
        $offerDetails = $query->row();
        $listingId = $offerDetails->listing_id;

        $this->db->set('status', 2);
        $this->db->where('sellerId', $arr['clientId']);
        $this->db->where('id', $arr['offerId']);
        $this->db->update(TABLE_PREFIX.'listing_offers');


        $this->db->set('status', 3);
        $this->db->where('listing_id', $listingId);
        $this->db->where('userId', $arr['clientId']);
        $this->db->update(TABLE_PREFIX.'sell_record');

    }
    function rejectoffedr($arr)
    {
        $this->db->select('U.*', FALSE);
        $this->db->from(TABLE_PREFIX.'listing_offers as U', FALSE);
        $this->db->where('U.sellerId', $arr['clientId']);
        $this->db->where('U.id', $arr['offerId']);
        $this->db->limit(1);
        $query = $this->db->get();        
        $offerDetails = $query->row();
        $listingId = $offerDetails->listing_id;

        $this->db->set('status', 3);
        $this->db->where('sellerId', $arr['clientId']);
        $this->db->where('id', $arr['offerId']);
        $this->db->update(TABLE_PREFIX.'listing_offers');
    }


    function get_user_offer($arr){
        $this->db->select('U.*', FALSE);
        $this->db->from(TABLE_PREFIX.'listing_offers as U', FALSE);
        $this->db->where('U.listing_id', $arr['listingId']);
        $this->db->where('U.userId', $arr['user']);
        $this->db->where('U.status', 2);
        $this->db->order_by('U.offer_date','desc');
        $this->db->limit(1);
        $query = $this->db->get();        
        $userDetails = $query->row();
        return $userDetails;
    }

    function updateuserpassword($arr){
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'users AS USRS');
        $this->db->where('USRS.mail', $arr['email']);
        $this->db->where('USRS.activation_str', $arr['random']);
        $this->db->where('USRS.Status', 1);
        $this->db->limit(1);
        //$this->db->where('USRS.Status', 1);
        $Query = $this->db->get();
        $Array = $Query->row();
        if($Array->userId>0)
        {
            $this->db->set('activation_str', '');
            $this->db->set('password', $arr['password']);
            $this->db->where('userId', $Array->userId);
            $this->db->update(TABLE_PREFIX.'users');
            return $Array;
        }else{
            return [];
        }
        
    }

    function usernotifications($arr){
        $receiver = $arr['userId'];
        $start = $arr['page'];
        $limit = $arr['limit'];
        $partSql = '';
        $q = "select SQL_CALC_FOUND_ROWS f.*,DATE_FORMAT(f.notification_date, '%D %b %Y') as monthFormated from 
        ".TABLE_PREFIX."notifications as f
        where f.receiver='$receiver' ".$partSql." and f.Status=1 order by f.notification_date desc limit ".$start.",".$limit."";
        $query = $this->db->query($q);    
        $userDetails = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        if(count($userDetails)>0)
        {
            $i=0;
            foreach($userDetails as $val)
            {
                $id = $val['notification_type_id'];
                /*if($val['notification_type'] == 'OFFERAPPROVE')
                {
                    $q1 = "select sr.listing_id from ".TABLE_PREFIX."sell_record as sr
                    join ".TABLE_PREFIX."listing_offers as lo on lo.listing_id=sr.listing_id where lo.id='$id'";
                    $query = $this->db->query($q1); 
                    $NotificationDetails = $query->row();
                    if($NotificationDetails->listing_id > 0)
                    {
                        $userDetails[$i]['details'] = 'listing/'.$NotificationDetails->listing_id;
                    }else{
                        $userDetails[$i]['details'] = '#';
                    }
                    
                }*/
                $id = $val['id'];
                $this->db->set('unread', 'N');
                $this->db->where('id', $id);
                $this->db->update(TABLE_PREFIX.'notifications');
                $i++;
            }
        }

        return ['notification'=>$userDetails,'totalrecord'=>$totalrecord];
    }

    function header(){
        $query = $this->db->query("select c.*,s.wire_transfer_details,s.home_logo,s.inside_logo from ".TABLE_PREFIX."currencies c join ".TABLE_PREFIX."site_settings s on s.currency=c.id where s.id>0");
        $listing->sitesettings = $query->row();
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'site_settings AS USRS');
        $this->db->where('USRS.id', 1);
        $this->db->limit(1);
        $Query = $this->db->get();
        $Array = $Query->row();
        $unreadNotificationDetails = $this->countnotification();
        return ['site_settings'=>$Array,'notifications'=>$unreadNotificationDetails];
    }
    function countnotification(){
        $userId = $this->session->userdata('user_id');
        $q = "select count(f.id) as totalnotifications from 
        ".TABLE_PREFIX."notifications as f
        where receiver='$userId' and f.unread='Y' and f.Status=1";
        $query = $this->db->query($q);    
        $unreadNotificationDetails = $query->result_array();
        return $unreadNotificationDetails[0];
    }
    function footer(){
        $footer = $this->header();
        $this->db->select('pageName,pageSlug');
        $this->db->from(TABLE_PREFIX.'cms_pages');
        $this->db->where('isDeleted', '0');
        $this->db->where('pageStatus', '1');
        $this->db->where('showInMenu', 'Y');
        $Query = $this->db->get();
        $footer['menu'] = $Query->result_array();
        return $footer;
    }

    function insertnotification($arr){
        $this->db->insert(TABLE_PREFIX.'notifications', $arr);
        $insertId = $this->db->insert_id();
        return $insertId;
    }

    function deleteusernotifications($arr){
        $this->db->set('Status', 0);
        $this->db->where('receiver', $arr['userId']);
        $this->db->where('id', $arr['id']);
        $this->db->update(TABLE_PREFIX.'notifications');
    }

    function getcuratedcontents($arr){
        $content_slug = $arr['content_slug'];

        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'cutared_contents AS USRS');
        $this->db->where('USRS.title_slug', $content_slug);
        $this->db->where('USRS.status', 1);
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    function getallcuratedcontents($arr){
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'cutared_contents AS USRS');
        $this->db->where('USRS.status', 1);
        $this->db->order_by('USRS.sort');
        $this->db->limit(3,0);
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function sellerfreecontents($arr){
        if($arr['area'] == 'SELLER')
        {
            $except = 'BUYER';
        }elseif($arr['area'] == 'BUYER')
        {
            $except = 'SELLER';
        }
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'free_content_download AS USRS');
        $this->db->where('USRS.reply_to<>', $except);
        $this->db->where('USRS.status', '1');
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }

    function getValuationQuestions($id=0){
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'valuation_questions AS USRS');
        $this->db->where('USRS.status', 1);
        if($id>0)
        {
            $this->db->where('USRS.id', $id);
        }
        $this->db->order_by('USRS.sort');
        $Query = $this->db->get();
        $Array = $Query->result_array();
        return $Array;
    }
    function getblogcategories(){
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'blog_categories AS USRS');
        $this->db->where('USRS.blogCatStatus', '1');
        $this->db->where('USRS.isDeleted', 0);

        $Query = $this->db->get();
        $Array = $Query->result_array();
        if(is_array($Array) && count($Array)>0)
        {
            foreach($Array as $k=>$v)
            {
                $this->db->select('count(blg.blogID) as totalblog');
                $this->db->from(TABLE_PREFIX.'blogs AS blg');
                $this->db->where('blg.blogStatus', '1');
                $this->db->where('blg.isDeleted', 0);
                $this->db->where('blg.blogCategory', $v['blogCatID']);
                $Query = $this->db->get();
                $ArrayCount = $Query->row();
                $Array[$k]['totalblog'] = $ArrayCount->totalblog;
            }
        }
        return $Array;
    }

    function getblogs($arr){
        $q = "select SQL_CALC_FOUND_ROWS USRS.*,DATE_FORMAT(USRS.addedOn, '%D %b %Y') as adddateformat from 
        ".TABLE_PREFIX."blogs AS USRS
        where USRS.blogStatus='1' and USRS.isDeleted=0 order by USRS.addedOn desc limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $Array = $query->result_array();

        if(is_array($Array) && count($Array) > 0)
        {
            foreach($Array as $k=>$v)
            {
                $Array[$k]['blogDescription'] = strip_tags($v['blogDescription']);
            }
        }

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        /*$this->db->select('USRS.*,DATE_FORMAT(USRS.addedOn, "%D %b %Y") as adddateformat');
        $this->db->from(TABLE_PREFIX.'blogs AS USRS');
        $this->db->where('USRS.blogStatus', '1');
        $this->db->where('USRS.isDeleted', 0);
        $this->db->order_by('USRS.addedOn', 'desc');
        $this->db->limit($arr['limit'],$arr['start']);
        $Query = $this->db->get();
        $Array = $Query->result_array();*/
        return ['blog'=>$Array,'totalrecord'=>$totalrecord];
    }
    function getcatblogs($arr){
        $q = "select SQL_CALC_FOUND_ROWS USRS.*,DATE_FORMAT(USRS.addedOn, '%D %b %Y') as adddateformat,bCAT.blogCatName from 
        ".TABLE_PREFIX."blogs AS USRS
        join ".TABLE_PREFIX."blog_categories AS bCAT ON bCAT.blogCatID=USRS.blogCategory
        where USRS.blogStatus='1' and USRS.isDeleted=0 and bCAT.blogCatSlug='".$arr['slug']."' order by USRS.addedOn desc limit ".$arr['start'].",".$arr['limit']."";
        $query = $this->db->query($q);    
        $Array = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();

        /*$this->db->select('USRS.*,DATE_FORMAT(USRS.addedOn, "%D %b %Y") as adddateformat');
        $this->db->from(TABLE_PREFIX.'blogs AS USRS');
        $this->db->where('USRS.blogStatus', '1');
        $this->db->where('USRS.isDeleted', 0);
        $this->db->order_by('USRS.addedOn', 'desc');
        $this->db->limit($arr['limit'],$arr['start']);
        $Query = $this->db->get();
        $Array = $Query->result_array();*/
        return ['blog'=>$Array,'totalrecord'=>$totalrecord];
    }

    function getblogsdetails($arr)
    {
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'blogs AS USRS');
        $this->db->where('USRS.blogStatus', '1');
        $this->db->where('USRS.isDeleted', 0);
        $this->db->where('USRS.blogSlug', $arr['slug']);
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    function getblogcurateddetails($arr)
    {
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'cutared_contents AS USRS');
        $this->db->where('USRS.status', '1');
        $this->db->where('USRS.title_slug', $arr['slug']);
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    

    function getmonitizationRange($monitizartion){
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'monetization AS USRS');
        $this->db->where('USRS.slug', $monitizartion);
        $this->db->where('USRS.area', 'VALUATION');
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    public function getvaluationinputs($arr)
    {
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'sell_business_temp AS USRS');
        $this->db->where('USRS.userId', $arr['clientId']);
        $this->db->where('USRS.listing_id', $arr['listing_id']);
        $this->db->where('USRS.Status', $arr['status']);
        $this->db->where('USRS.type', 'VALUATION');

        $Query = $this->db->get();
        $Array = $Query->row();
        $dataArr = json_decode($Array->data_json,true);
        return $dataArr;
    }

    public function updatevaluationlisting($listingId,$clientId,$arr)
    {
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'sell_business_temp AS USRS');
        $this->db->where('USRS.userId', $clientId);
        $this->db->where('USRS.listing_id', $listingId);
        $this->db->where('USRS.type', 'VALUATION');
        //$this->db->where('Status', 0);
        $Query = $this->db->get();
        $Array = $Query->row();
        if($Array->id > 0 && $Array->Status == 0)
        {
            $newlistingId = time();
            $valuation_json = json_encode($arr);
            $this->db->set('Status', 1);
            $this->db->set('listing_id', $newlistingId);
            $this->db->set('valuation_json', $valuation_json);
            $this->db->set('last_updated', date('Y-m-d H:i:s'));
            $this->db->where('listing_id', $listingId);
            $this->db->where('userId', $clientId);
            $this->db->where('type', 'VALUATION');
            $this->db->where('Status', 0);
            $this->db->update(TABLE_PREFIX.'sell_business_temp');
            $listingId = $newlistingId;
        }
        $this->db->select('USRS.*');
        $this->db->from(TABLE_PREFIX.'sell_business_temp AS USRS');
        $this->db->where('USRS.userId', $clientId);
        $this->db->where('USRS.listing_id', $listingId);
        $this->db->where('USRS.type', 'VALUATION');
        $this->db->where('Status', 1);
        $Query = $this->db->get();
        $Array = $Query->row();
        return $Array;
    }

    public function getsoldrecord($monatization){
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.pricing_period,BaseTbl.pricing_period,BaseTbl.userId,BaseTbl.Status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,C.name as countryname from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        where (BaseTbl.Status=1 OR BaseTbl.Status=4 OR BaseTbl.Status=3)  and BaseTbl.monetization like '%".$monatization."%' order by BaseTbl.date_added desc limit 0,20";
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        return $listing;
    }

    public function getUserWonListing($arr){
        
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.traffic_per_month,BaseTbl.userId,BaseTbl.Status,br.transfer_status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,C.name as countryname,br.status as salestatus,br.userId as buyer,br.sellerId as seller from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        join ".TABLE_PREFIX."buy_request as br ON br.listing_id=BaseTbl.listing_id
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        where BaseTbl.Status=4 and br.status=2 and br.userId=".$arr['userId']." order by BaseTbl.date_added desc";
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        if(is_array($listing) && count($listing)>0)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();
                
                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                $listingId = $vv['listing_id'];
                if($listing[$l]['business_image'] == '')
                $listing[$l]['business_image'] = 'banner.jpg';
                //$listing[$l]['userId'] = $userId;
                if($userId == $vv['userId'])
                {
                    $listing[$l]['unlocked'] = true;
                }
                elseif($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                $l++;
            }
        }
        return array("totalrecord"=>$totalrecord,"listing"=>$listing);
    }

    public function getSellerSoldListing($arr){
        
        $q = "select SQL_CALC_FOUND_ROWS BaseTbl.monetization,BaseTbl.traffic_per_month,BaseTbl.traffic_per_month,BaseTbl.userId,BaseTbl.Status,br.transfer_status,BaseTbl.business_create_date,BaseTbl.monthly_profit,BaseTbl.monthly_revenue,BaseTbl.price,BaseTbl.listing_id,BaseTbl.business_image,BaseTbl.multiple,ind.industry as industryname,C.name as countryname,br.status as salestatus,br.buy_amt_stranfer_status,br.userId as buyer,br.sellerId as seller,lo.offer_price from 
        ".TABLE_PREFIX."sell_record as BaseTbl
        join ".TABLE_PREFIX."industries as ind ON ind.id = BaseTbl.industry
        join ".TABLE_PREFIX."buy_request as br ON br.listing_id=BaseTbl.listing_id
        left join ".TABLE_PREFIX."countries C ON C.id=BaseTbl.country
        left join ".TABLE_PREFIX."listing_offers as lo on br.sellerId=lo.sellerId and br.userId=lo.userId and br.listing_id=lo.listing_id and lo.status=2
        where BaseTbl.Status=4 and br.status=2 and br.sellerId=".$arr['userId']." group by BaseTbl.listing_id order by BaseTbl.date_added desc";
        $query = $this->db->query($q);    
        $listing = $query->result_array();

        $query = $this->db->query("SELECT FOUND_ROWS() as totalrecord");
        $totalrecord = $query->row();
        
        if(is_array($listing) && count($listing)>0)
        {
            $l=0;
            foreach($listing as $kk=>$vv)
            {
                $listing[$l]['business_age'] = $this->time_elapsed_string($vv['business_create_date'],true);
                $Monetization = json_decode($vv['monetization'],true);
                if(is_array($Monetization) && count($Monetization)>0)
                {
                    $this->db->select('BaseTbl.name', FALSE);
                    $this->db->from(TABLE_PREFIX.'monetization as BaseTbl', FALSE);
                    $this->db->where_in('BaseTbl.slug', $Monetization);
                    $this->db->where('BaseTbl.Status', 1);
                    $query = $this->db->get();        
                    $monetizationRes = $query->result_array();

                    $mArr = [];
                    if(is_array($monetizationRes) && count($monetizationRes)>0)
                    {
                        foreach($monetizationRes as $v)
                        {
                            $mArr[] = $v['name'];
                        }
                    }
                    $listing[$l]['monetizationStr'] = join($mArr,', ');
                }else{
                    $listing[$l]['monetizationStr'] = '';
                }
                $listingId = $vv['listing_id'];
                if($listing[$l]['business_image'] == '')
                {
                    $listing[$l]['business_image'] = 'banner.jpg';
                }
                //$listing[$l]['userId'] = $userId;
                if($userId == $vv['userId'])
                {
                    $listing[$l]['unlocked'] = true;
                }
                elseif($userId > 0)
                {
                    $this->db->select('h.*', FALSE);
                    $this->db->from(TABLE_PREFIX.'investor_pass_history as h', FALSE);
                    $this->db->where('h.userId', $userId);
                    $this->db->where('h.activity', 'UNCOVER');
                    $this->db->where('h.unlocked_business', $listingId);
                    $this->db->limit(1);
                    $query = $this->db->get();        
                    $uncovered = $query->row();
                    if($uncovered->id >0)
                    {
                        $listing[$l]['unlocked'] = true;
                    }
                }
                /*$this->db->select("*");
                $this->db->from(TABLE_PREFIX.'listing_offers');
                $this->db->where('listing_id', $vv['listing_id']); 
                $this->db->where('sellerId', $vv['sellerId']); 
                $this->db->where('userId', $arr['userId']); 
                $this->db->where('status', 2);   
                $Query = $this->db->get();
                $offers = $Query->row();*/
                //$data['offers'] = $offers;
                if($vv['offer_price']>0)
                {
                    $datares['offersell'] = 'Offer';
                    $sellPrice = $vv['offer_price'];
                    //$listing[$l]['price'] = $sellPrice;
                }else{
                    $datares['offersell'] = 'Normal';
                    $sellPrice = $vv['price'];
                }
                if($vv['sold_date'])
                {
                    $solddate = $vv['sold_date'];
                }else{
                    $solddate = date('Y-m-d');
                }

                /*$this->db->select("*");
                $this->db->from(TABLE_PREFIX.'commission_history');
                $this->db->where('change_date <=', $solddate);   
                $this->db->order_by('change_date', 'desc'); 
                $Query = $this->db->get();
                $commission = $Query->row();*/

                $where = "((price_from<='$sellPrice' and price_to >='$sellPrice') OR (price_from='0.00' and price_to >='$sellPrice') OR (price_from<='$sellPrice' and price_to ='0.00')) and status=1";
				$this->db->select("*");
				$this->db->from(TABLE_PREFIX.'commission_history');
				$this->db->where($where);   
				$Query = $this->db->get();
				$commission = $Query->row();
                $commissionPercentage = $commission->percentage;
                $listing[$l]['buy_amt_stranfer_status'] = ($vv['buy_amt_stranfer_status'] == 1)?' <span style="color:green;">Paid</span>': ' <span style="color:red;">Unpaid</span>';
		        $listing[$l]['commissionAmount'] = number_format(($sellPrice/100)*$commissionPercentage,2).' ('.$commissionPercentage.'%)';
		        $listing[$l]['transferAmount'] = number_format($sellPrice-($sellPrice/100)*$commissionPercentage,2);

                $l++;
            }
        }
        return array("totalrecord"=>$totalrecord,"listing"=>$listing);
    }

    public function getwalletdetails($arr)
    {
        $user = $arr['userId'];
        $this->db->select('BaseTbl.id,BaseTbl.transaction_ref', FALSE);
        $this->db->from(TABLE_PREFIX.'user_buy_ref as BaseTbl', FALSE);
        $this->db->where('BaseTbl.userId', $user);
        $this->db->where('BaseTbl.area', 'WALLET');
        $this->db->where('BaseTbl.redeemed', 'N');
        $this->db->limit(1);
        $query = $this->db->get();        
        $userRefDetails = $query->row();
        if($userRefDetails->id>0)
        {
            $refNumber = $userRefDetails->transaction_ref;
        }else{

            $refNumber = $this->generaterefnumber();
            
            $arrinsert['listing_id'] = 0;
            $arrinsert['transaction_ref'] = $refNumber;
            $arrinsert['userId'] = $user;
            $arrinsert['sellerId'] = 0;
            $arrinsert['area'] = 'WALLET';
            $arrinsert['redeemed'] = 'N';
            $this->db->insert(TABLE_PREFIX.'user_buy_ref', $arrinsert);
        }

        $this->db->select('userdetails.Investor_pass,userdetails.fund_approved_amount,userdetails.proof_fund_status,userdetails.identity_proof_status', FALSE);
        $this->db->from(TABLE_PREFIX.'users as user', FALSE);
        $this->db->join(TABLE_PREFIX.'user_details as userdetails','userdetails.userId = user.userId');
        $this->db->where_in('user.Status', 1);
        $this->db->where('user.userId', $user);
        $query = $this->db->get();        
        $investorPass = $query->row();


        $query = $this->db->query("select c.*,s.wire_bank_name,s.wire_bank_address,s.wire_swift_code,s.wire_credit_account_name,s.wire_aba_routing,s.wire_credit_account_no,s.wire_beneficiary_address,s.wire_additional_info from ".TABLE_PREFIX."currencies c join ".TABLE_PREFIX."site_settings s on s.currency=c.id where s.id>0");
        $sitesettings = $query->row();   

        $totalwalletBalance = $this->getwalletBalance($user);
        return array("totalrecord"=>$totalrecord,"sitesettings"=>$sitesettings,'refnumbrer'=>$refNumber,'walletamt'=>$totalwalletBalance,'investorPass'=>$investorPass);
    }

    public function getwalletBalance($user)
    {
        $query = $this->db->query("select ifnull(sum(c.wallet_amount),0) as walletTotal from ".TABLE_PREFIX."buy_request c where c.userId=$user and c.status=2 and c.section='WALLET' and c.payment_mode='WIRETRANSFER'");
        $walletamount = $query->row();  

        $query = $this->db->query("select ifnull(sum(c.wallet_amount),0) as walletSpentTotal from ".TABLE_PREFIX."buy_request c where c.userId=$user and (c.status=1 OR c.status=2) and c.section='LISTING' and (c.payment_mode='WALLET' OR c.payment_mode='BOTH')");
        $walletspentamount = $query->row();

        $query = $this->db->query("select ifnull(sum(c.wallet_amount),0) as walletWithdrawalTotal from ".TABLE_PREFIX."buy_request c where c.userId=$user and (c.status=1 OR c.status=2) and c.section='WALLETWITHDRAW' and c.payment_mode='WIRETRANSFER'");
        $withdrawalamount = $query->row();
        return $totalwalletBalance = $walletamount->walletTotal - ($walletspentamount->walletSpentTotal+$withdrawalamount->walletWithdrawalTotal);
    }


    public function getpendingwithdrawal($arr){
        $query = $this->db->query("select ifnull(sum(c.wallet_amount),0) as walletSpentTotal from ".TABLE_PREFIX."buy_request c where c.userId=$user and (c.status=1 OR c.status=2) and c.section='LISTING' and (c.payment_mode='WALLET' OR c.payment_mode='BOTH')");
        $walletspentamount = $query->row();
    }

    public function setuserbuyref($arr){
        $this->db->set('redeemed', $arr['redeemed']);

        $this->db->where('userId', $arr['userId']);
        $this->db->where('sellerId', $arr['sellerId']);
        $this->db->where('listing_id', $arr['listing_id']);
        $this->db->where('transaction_ref', $arr['transaction_ref']);
        $this->db->where('area', $arr['area']);
        $this->db->update(TABLE_PREFIX.'user_buy_ref');
    }

    public function setuserwithdrawref($arr)
    {
        $this->db->set('redeemed', $arr['redeemed']);

        $this->db->where('userId', $arr['userId']);
        $this->db->where('sellerId', $arr['sellerId']);
        $this->db->where('listing_id', $arr['listing_id']);
        $this->db->where('transaction_ref', $arr['transaction_ref']);
        $this->db->where('area', $arr['area']);
        $this->db->update(TABLE_PREFIX.'user_buy_ref');
    }

    public function setinvestorpassref(){
        $ref = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 10));

        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'investor_pass_history');
        $this->db->where('investor_pass', $ref);   
        $Query = $this->db->get();
        $Array = $Query->row();
        if($Array->id >0)
        {
            $this->setinvestorpassref();
        }else{
            return $ref;
        }
    }

    public function generatepromocode(){
        $ref = strtoupper(substr(str_shuffle(RANDOM_CHAR), 0, 6));

        $this->db->select("*");
        $this->db->from(TABLE_PREFIX.'users');
        $this->db->where('promo_code', $ref);   
        $Query = $this->db->get();
        $Array = $Query->row();
        if($Array->id >0)
        {
            $this->generatepromocode();
        }else{
            return $ref;
        }
    }


}
