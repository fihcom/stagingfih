<section class="section get-valuation-result"> 
<?php
//echo 'kaka->'.$clientId;
if($clientId == 0)
{
    ?>
    <div class="valiation-wrap">
        <div class="container">
            <h2 class="heading text-center">Do you want to save this valuation result?</h2>
            <div class="btn_center">
                <a href="<?php echo base_url();?>login" class="btn btn-lg blue-btn">Login</a>
                <a href="<?php echo base_url();?>register" class="btn btn-lg">Sign Up</a>
            </div>
        </div>
    </div>
    <?php
}
?>
    <div class="valiation-wrap">
        <div class="container">
            <div class="valuation-header d-flex align-items-center flex-wrap">
                <div class="valuation-header-left">
                    <h1 class="heading">This is your instant valuation for <?php echo $inputDetails['website'][0]?></h1>
                </div>
                <div class="valuation-header-right ml-auto d-flex align-items-center flex-wrap">
                    <div class="valuation-header-right-list">
                        <div class="gray-head">Valuation Date</div>
                        <div class="valuation-header-right-text"><?php echo date('jS M Y h:i A',strtotime($valuationdetails[4]['last_updated']));?></div>
                    </div>
                    <div class="valuation-header-right-list">
                        <div class="gray-head">Multiple</div>
                        <div class="valuation-header-right-text"><?php echo number_format($valuationdetails[1]['businessmultiple'],2,".",",");?>x</div>
                    </div>
                    <div class="valuation-header-right-list">
                        <div class="gray-head">Final Valuation</div>
                        <div class="valuation-header-right-text">$<?php echo number_format($valuationdetails[1]['businessValue'],2,".",",");?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="valiation-wrap">
        <div class="container">
            <div class="Recommended">
                <div class="middle-arrow">
                    <div class="info1">
                        <i class="fa fa-info" aria-hidden="true"></i>
                        <div class="hvr-text">
                            <div class="head">Lower Sale Price = Faster Sale</div>
                            <p>A lower sale price generally results in a faster sale due to buyers wanting to benefit from seeing a good deal.</p>
                        </div>
                    </div>
                    <div class="info2">
                        <i class="fa fa-info" aria-hidden="true"></i>
                        <div class="hvr-text">
                            <div class="head">Higher Sale Price = Slower Sale</div>
                            <p>A higher sale price can result in a slower sale, using the recommended listing price will ensure the best success in selling.</p> 
                        </div>
                    </div>
                </div>
                <ul class="ul d-flex justify-content-around">
                    <li>
                        <div class="box-arrow">
                            <div class="top-part">
                                <div class="subheading">Absolute Low <span><?php echo number_format($valuationdetails[1]['businessmultiplelower'],2,".",",");?>x</span></div>
                            </div>
                            <div class="bottom-part">
                                <div class="price">$<?php echo number_format($valuationdetails[1]['businessValuelower'],2,".",",");?></div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="box-arrow">
                            <div class="top-part">
                                <div class="subheading">Typical Low <span>11.6x</span></div>
                            </div>
                            <div class="bottom-part">
                                <div class="price">$21,986.00</div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="box-arrow green-arrow">
                            <div class="top-part">
                                <div class="subheading">Recommended <span><?php echo number_format($valuationdetails[1]['businessmultiple'],2,".",",");?>x</span></div>
                            </div>
                            <div class="bottom-part">
                                <div class="price">$<?php echo number_format($valuationdetails[1]['businessValue'],2,".",",");?></div>
                            </div>
                        </div>
                    </li>
                    <!--<li>
                        <div class="box-arrow">
                            <div class="top-part">
                                <div class="subheading">Typical High <span>15.8x</span></div>
                            </div>
                            <div class="bottom-part">
                                <div class="price">$29,746.00</div>
                            </div>
                        </div>
                    </li>-->
                    <li>
                        <div class="box-arrow">
                            <div class="top-part">
                                <div class="subheading">Absolute High <span><?php echo number_format($valuationdetails[1]['businessmultiplehigher'],2,".",",");?>x</span></div>
                            </div>
                            <div class="bottom-part">
                                <div class="price">$<?php echo number_format($valuationdetails[1]['businessValuehigher'],2,".",",");?></div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!--
    <div class="valiation-wrap">
        <div class="container">
            <div class="subheading black">What’s the Difference Between a Typical and Absolute Valuation?</div>
            <div class="para">
                <p>You’re probably asking yourself that right now as you look at your valuation. So let’s clear up that mystery.</p>
                <p>The Typical Valuation range we gave you is backed by real sales data. It is data from real businesses, just like yours, that sold on our marketplace. We know that on average this is the typical price points an investor is willing to pay for your business. And honestly… we recommend you go with the Typical Valuation the vast majority of the time if you want a smooth and profitable exit.</p>
                <p>However, we recognize that not every business and situation are created equally. That is why we introduced the Absolute Range.</p>
                <p>The Absolute Range goes both above and below our Typical Range and we are only sliding into it in two different scenarios - see Low / High below.</p>
            </div>
        </div>
    </div>
    <div class="valiation-wrap">
        <div class="container">
            <div class="row low-high pb-3 mb-3 border-bottom">
                <div class="col-sm-6 border-right">
                    <div class="low"><span><i class="fa fa-long-arrow-down" aria-hidden="true"></i>Low</span></div>
                    <div class="subheading black">You’re in a Rush. You Need to Sell Now</div>
                    <div class="para">
                        <p>Sometimes you need to make a sale happen FAST. We’re willing to work with you to make that happen. Going lower than our Typical Range will supercharge the buying interest in your business and get the deal done faster and the money in your pocket quicker, even if you leave a few bucks on the table.</p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="low"><span><i class="fa fa-long-arrow-up" aria-hidden="true"></i>High</span></div>
                    <div class="subheading black">You’ve Got Something Unique & Willing to Wait</div>
                    <div class="para">
                        <p>If you’re in no rush to sell and willing to wait for the right buyer, this can put more money in your pocket. Your business should be extremely high quality and ideally offer some kind of unique advantage as to why it deserves this higher valuation.</p>
                    </div>
                </div>
            </div>
            <div class="para">
                <p>If you decide to use the Absolute Range, we <strong>highly recommend</strong> that you go only slightly above or slightly below our Typical Range if you want to have the best possible experience selling your business on our marketplace.</p>
                <p><strong>Remember, valuations can be higher or lower once you go through our actual vetting process. If these numbers interest you, then let’s get started and list your business for sale on our marketplace.</strong></p>
            </div>
        </div> 
    </div>
    <div class="valiation-wrap">
        <div class="container">
            <div class="valiation-border-bottom">
                <div class="subheading black">Affiliate</div>
                <div class="para">
                    <p>Affiliate programs are one of the most attractive business models, and thus attracts one of the widest buyer pools around. Because a buyer does not need to manage customer service, logistics or anything traditionally associated with selling their own product, they can just focus on creating high quality content. This hands off nature also makes them very attractive to newbie buyers just as much as to veteran buyers who can see the high profit potential for these sites. Definitely expect a lot of interest when you list this on our marketplace, especially if you’ve really focused on producing expert content combined with good branding.</p>
                </div>
            </div>
            <div class="valiation-border-bottom">
                <div class="subheading black">Let’s Dive Into Our Tips For Your Business</div>
                <div class="small-head">Valuation</div>
                <div class="para">
                    <p><strong>$<?php echo number_format($valuationdetails[1]['businessValue'],2,".",",");?></strong> - Congratulations on building a successful online business! If you’re thinking about selling we make sales of this size day in, day out. We’re very confident that we can sell your business using our network of buyers who love to snap up businesses like yours. Whether this is your first sale or not, you get full use of our sales team who will help you negotiate the best possible exit for your business. Our years of experience in negotiating deals of this size will be your biggest asset when it comes to selling at the best price.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Business Age</div>
                <div class="para">
                    <p><strong>1 months (Needs More Track Record)</strong> - Most buyers are not interested in buying a business that’s only six months old. The business is just too new and has too little time to earn anything significant. They prefer to see at least a year long track record of profitability before doing due diligence. Focus on growing the business more and getting more historical data. You should have a solid 12 months of profitability before coming back to sell your business for a much higher valuation. Remember, valuations tend to use the AVERAGE net profit of your last 12 months. While you can sell a business on a 6 month average, your multiple is likely going to be lower due to lack of history. Even on a 6 month average though, your business hasn’t been around long enough to really reflect where the business is going just yet.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Hours Worked</div>
                <div class="para">
                    <p><strong>4.0 hrs/week (Hands-Off)</strong> - While your business may had taken a lot of effort to get it to where it is now, you don’t actively work on it too much throughout the week. This might be because you have really great systems in place, a team, or just the nature of your business once it’s up to a profitable level. Whatever the reason, this kind of business attracts a large pool of buyers.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Monthly Unique Visitors</div>
                <div class="para">
                    <p><strong>5 (Needs Improvement) </strong> - You've got yourself a traffic problem. If you have more than 20 pieces of content and your site is more than 6 months old, I'd suggest tweaking your content using keyword research to better rank for and attract visitors through organic search. If the site is still new and has less than 20 pieces of content, I'd suggest hanging out in forums and communities where your customers are at and getting know. Help them with their problems, questions, etc. and they'll naturally begin checking out your site.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Profit Margin</div>
                <div class="para">
                    <p><strong>9% (Needs Improvement) </strong> - Your profit margins are awfully low. You should take a look at A) Cutting non-essential expenditures B) Increasing your prices C) Adding higher-margin products or services to go along with current offers. Having low margins can really slow the growth of your company – especially if you have heavy cash-flow burdens.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Net Earnings per Hour</div>
                <div class="para">
                    <p><strong>$472.00 </strong>- You're making great money. At this point, you should be delegating as much as possible to either in-house teams you’ve built or agencies you’re using to help grow the business. You might still be a solopreneur at this level too, but you certainly don’t need to be and can afford to start hiring a quality team to run the business’s day to day operations.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Net Earnings per Unique Visitor</div>
                <div class="para">
                    <p><strong>$377.60 (Going Well) </strong> - Your website is doing really well in terms of $$ per visitor to the site. Paid traffic is definitely an option you should consider. Your main focus should be to do everything you can to continue to drive more relevant visitors to the site and you'll see an big increase in your earnings.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Net Earnings per Email Subscriber</div>
                <div class="para">
                    <p><strong>$34.33 (Going Well) </strong> - You're crushing it in terms of earnings per subscriber. If a fair amount of your earnings are coming from your email list, you might want to consider paying to acquire more subscribers. (A good rule of thumb is to keep your cost-per-subscriber at 3 months value or less) If you're not monetizing your email list, you should brush up on your email marketing skills and see if there's additional revenue opportunities there for you.</p>
                </div>
            </div>
            <div class="valiation-border-bottom"> 
                <div class="small-head">Monthly Net Profit</div>
                <div class="para">
                    <p><strong>$1,888 </strong> - Want to sell your business? We have hungry buyers looking for businesses just like this to purchase right now. Some buyers even leave tens of thousands of dollars on file with us every month just so they can “instantly” grab up businesses around this size before another buyer gets a chance to purchase it. Get in contact with us and we’ll be happy to walk you through how we can sell your business.</p>
                </div>
            </div>
        </div>
    </div> 
    <div class="ReadyToSellYourBusiness">
        <div class="container">
            <div class="d-flex align-items-center flex-wrap justify-content-center">
                <h2 class="heading d-block">Ready to Sell Your Business on Our Marketplace?</h2>
                <div class="btn_center">
                    <a href="#" class="btn btn-lg">Start the Process <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="valiation-wrap"> 
        <div class="container">
            <div class="valiation-border-bottom">
                <div class="Monetization">
                    <div class="heading">Monetization: <?php echo $valuationdetails[1]['name'];?></div>
                    <p><strong>Estimated Typical Valuation Range</strong></p>
                    <p><strong>Low: </strong> $<?php echo number_format($valuationdetails[1]['businessValuelower'],2,".",",");?></p>
                    <p><strong>High: </strong> $<?php echo number_format($valuationdetails[1]['businessValuehigher'],2,".",",");?></p>
                    <p><strong>Multiple Range: </strong> Low - <?php echo number_format($valuationdetails[1]['businessmultiplelower'],2,".",",");?>x / High - <?php echo number_format($valuationdetails[1]['businessmultiplehigher'],2,".",",");?>x</p>
                    <p><strong>Final Valuation: </strong> $<?php echo number_format($valuationdetails[1]['businessValue'],2,".",",");?></p>
                </div>
            </div> 
            <div class="valiation-border-bottom"> 
                <div class="valiation-row3">
                    <ul class="ul row">
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$<?php echo number_format($valuationdetails[1]['businessValue'],2,".",",");?></div>
                                <div class="gray-text">Valuation</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['businessage'];?> months</div>
                                <div class="gray-text">Business Age</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['hourworked'];?> hrs/week</div>
                                <div class="gray-text">Hours Worked</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['visitor'];?></div>
                                <div class="gray-text">Monthly Unique Visitors</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['profitratio'];?>%</div>
                                <div class="gray-text">Profit Margin</div>
                            </div>
                        </li>
                        <!--
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$472.00</div>
                                <div class="gray-text">Net Earnings per Hour</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$377.60</div>
                                <div class="gray-text">Net Earnings per Unique Visitor</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$34.33</div>
                                <div class="gray-text">Net Earnings per Email Subscriber</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$1,888</div>
                                <div class="gray-text">Monthly Net Profit</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$17,000</div>
                                <div class="gray-text">Average Monthly Expenses</div>
                            </div>
                        </li>
                        -->
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['follower'];?></div>
                                <div class="gray-text">Online Followers</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black">$<?php echo number_format($valuationdetails[1]['avgrevenue'],2,".",",");?></div>
                                <div class="gray-text">Monthly Average Revenue</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                            <?php
                            if($valuationdetails[1]['avgprofit']<0)
                            {
                                $avgProfit = abs($valuationdetails[1]['avgprofit']);
                                $negtv = '-';
                            }else{
                                $avgProfit = $valuationdetails[1]['avgprofit'];
                                $negtv = '';
                            }
                            ?>
                                <div class="price-black"><?php echo $negtv;?>$<?php echo number_format($avgProfit,2,".",",");?></div>
                                <div class="gray-text">Monthly Average Profit</div>
                            </div>
                        </li>
                        <li class="col-sm-4">
                            <div class="box">
                                <div class="price-black"><?php echo $valuationdetails[1]['revenue'];?></div>
                                <div class="gray-text">Number of Revenue Channels</div>
                            </div>
                        </li>
                    </ul> 
                </div>
            </div>
        </div>
    </div>
    
    <div class="valiation-wrap">
        <?php
        $soldlisting = [];
        if(is_array($soldlisting) && count($soldlisting)>0)
        {
        ?>
        <div class="container">
            <h2 class="heading text-center">Previously Sold Listings</h2>
            <div class="gray-text text-center mb-3">Similar to Your Business</div>
            <div class="SoldListings">
                <ul class="ul row">
                    <?php
                    foreach($soldlisting as $val)
                    {
                        ?>
                        <li class="col-sm-4">
                        <div class="box">
                            <div class="top-sec">
                                <div class="link heading"><a href="<?php echo base_url();?>listing/<?php echo $val['listing_id'];?>">#<?php echo $val['listing_id'];?></a></div>
                                <div class="sold">This listing has been sold</div>
                                <h2 class="subheading"><?php echo $val['industryname'];?></h2>
                            </div>
                            <div class="SoldListings-bottom">
                                <ul class="ul row">
                                    <li class="col-sm-6">
                                        <div class="listing">
                                            <div class="gray-head">Sale Price</div>
                                            <div class="black-head">$<?php echo number_format($val['price'],2,".",",");?></div>
                                        </div>
                                    </li>
                                    <li class="col-sm-6">
                                        <div class="listing">
                                            <div class="gray-head">Monthly Net</div>
                                            <div class="black-head">$<?php echo number_format($val['monthly_profit'],2,".",",");?></div>
                                        </div>
                                    </li>
                                    <li class="col-sm-6">
                                        <div class="listing">
                                            <div class="gray-head">Pricing Period</div>
                                            <div class="black-head"><?php echo $val['pricing_period'];?> Months</div>
                                        </div>
                                    </li>
                                    <li class="col-sm-6">
                                        <div class="listing">
                                            <div class="gray-head">Yield</div>
                                            <div class="black-head"><?php echo $val['multiple'];?>%</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                        <?php
                    }
                    ?>
                </ul>
                
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    <!--<div class="valiation-wrap">
        <div class="container">
            <div class="only-link">
                <div class="heading">Want to Learn More About Selling Your Business?</div>
                <ul class="list-item">
                    <li><a href="#">Learn How to Prepare Your Business for Sale <i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                    <li><a href="#">How We Sold a $1.7 Million Amazon FBA Deal <i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                    <li><a href="#">8 Successful Marketing Tactics We Use to Sell Your Online Business <i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                    <li><a href="#">6 Types of Online Business Buyers <i class="fa fa-arrow-right" aria-hidden="true"></i></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="ScheduleAFreeConsulation-sec">
        <div class="container">
            <div class="ScheduleAFreeConsulation">
                <h2 class="heading w">Want the Absolute Best Possible Valuation?</h2>
                <div class="para">Schedule a call with one of our Business Analysts for a free consultation that will go even more in-depth on what you can do to increase your business’s value.</div>
                <div class="btn_left">
                    <a href="#" class="btn btn-lg">Schedule a Free Consulation <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="valiation-wrap">
        <div class="container">
             <h2 class="heading">Does Your Business Qualify for the Empire Flippers Marketplace</h2>
             <div class="para">
                <p>We’re happy to help you sell your business, but keep in mind we almost never will list businesses that are:</p>
                <ul class="ul icon-list pb-3">
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Foreign language content sites</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Retail arbitrage</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> E-commerce products sourced from Aliexpress</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Shipping from home w/o 3PL</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Personality branded businesses</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Gambling, Sex, Drugs (not including marijuana) or Vaping</li>
                    <li><i class="fa fa-ban" aria-hidden="true"></i> Primarily Australian dropshipping/e-commerce</li>
                </ul>
                <p>Also, keep in mind that to list your business, it must make at least an average of $1,000 per month in net profit ($500/month for Adsense / Amazon Associates / Affiliate / Merch by Amazon businesses) and have a solid track record of at least 12 months of revenue/earnings (6 months for Adsense / Amazon Associates / Affiliate businesses). Learn more about our requirements <a href="#">here</a>.</p>
             </div>
        </div>
    </div>
    <div class="trstd">
        <div class="container">
            <div class="source-wrap">
                <div class="row">
                    <div class="col-sm-6 leftS">
                        <div class="awards">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/award1.png" alt="Inc. 5000 #161 2016">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/award2.png" alt="Inc. 5000 #174 2017">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/award3.png" alt="Inc. 5000 #583 2018">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/award4.png" alt="Inc. 5000 #726 2019">
                        </div>
                        <div class="images">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/da1.png" alt="IBBA Deal Maker Award">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/da2.png" alt="IBBA Top Deal Maker Award">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/da3.png" alt="IBBA Top Global Producer Award">
                            <img src="<?php echo base_url();?>assets/frontend/images/sample/da4.png" alt="IBBA Chairman's Circle Award">
                        </div>
                    </div>
                    <div class="col-sm-6 rightS">
                        <h2 class="heading">We’re The Trusted Go To Source.</h2>
                        <p>When it comes to selling your business, we’re the trusted go to source. We have sold a lot of e-commerce businesses, ones just like yours.</p>
                        <p>There is a reason we have been on the Inc. 5000 fastest growing companies in America list four years in a row, and that’s because we know how to get the job done.</p>
                        <p>We’ve attracted thousands of buyers to our platform who are hungry for a business like yours.</p>
                        <p>Let us take the stress of selling your online business out of the equation. Schedule a call with one of our Business Analysts today by clicking the button below:</p>
                        <a href="#" class="btn btn-lg w-100 mt-3"><i class="fa fa-phone" aria-hidden="true"></i> Schedule a Call</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="total-sold">
        <div class="left"><img src="<?php echo base_url();?>assets/frontend/images/sample/note.png" alt=""><span>Number of Businesses Sold: </span> 1,420</div>
        <div class="right"><img src="<?php echo base_url();?>assets/frontend/images/sample/cart.png" alt=""><span>Total Sold Amount: </span> $194,729,273</div>
    </div>-->
</section>