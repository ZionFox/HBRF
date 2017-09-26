<?php

    /*
    $projectData is a key => value pair array which consist of the following:
        ("*" in key is a number from 1 to "ign_level_count" / "ign_stretch_count")
        (Starred keys are important ones that are used throughout the code)
            Key:                            Value:
    *   post_categories                 (string): fundraiser categories array provided from the posts' terms. These are pulled from the "post categories" interface in the admin panel
        _thumbnail_id                   (string): Serialised array of the thumbnail data
    *   _thumbnail_file                 (string): file name of the featured image file extracted from [_thumbnail_id][file]
        ign_days_left                   (int): days left until fundrasier closes
    *   ign_end_type                    (string): "open"/"closed"
        ign_fund_end                    (date): date of fundraiser close
    *   ign_fund_goal                   (float): goal amount
    *   ign_fund_raised                 (float): raised amount
        ign_option_project_url          (string): project url <invalid>
        ign_option_purchase_url         (string): purchase url <invalid>
        ign_option_ty_url               (string): ty url
        ign_product_details             (string): product details
    *   ign_percent_raised              (float): percentage raised
        ign_product_image2              (string): url of image location (NOT FEATURED IMAGE! use "_thumbnail_file" for featured image url)
        ign_product_level_*_desc        (string): description of level
        ign_product_level_*_limit       (string): availability limit of level
        ign_product_level_*_order       (int): layout ordering
        ign_product_level_*_price       (float): cost of level
        ign_product_level_*_short_desc  (string): shortened description of level
        ign_product_level_*_title       (string): title of level
        ign_product_level_count         (int): number of levels
        ign_product_price               (float): starting price
        ign_product_short_description   (string): short description of product
        ign_product_title               (string): main title <invalid>
        ign_product_video               (string): embedded video iframe
        ign_project_closed              (int): 0/null for open, 1 for closed
        ign_project_description         (string): description of project
    *   ign_project_id                  (int): id of project for ign_products
        ign_project_long_description    (string): description of project
        ign_project_project_success     (int): 0 for fail, 1 for success
    *   ign_project_title               (string): main title of project
    *   ign_project_type                (string): "level-based", not sure of other values
    *   ign_project_url                 (string): the project's permalink url
    *   ign_stretch-*_amount            (float): goal amount for stretch
        ign_stretch-*_text              (string): text/desc for stretch
        ign_stretch-*_title             (string): title for stretch
        ign_stretch_count               (int): number of stretch goals
    */




      /////////////////////////////////////
     //         Link Variables          //
    /////////////////////////////////////
    /*
        These variables are used throughout the HTML code, and offer links to various places.
        Some links are automatic, like the Featured Fundraiser, and the links to individual fundraisers.
            (The latter should not be edited, as they're pulled straight from the database)
    */
    //Header links
    $youtubeLink = "https://www.youtube.com/channel/UC595wqznMGuY2mi6DKx-qnQ";
    $twitterLink = "https://twitter.com/HoneyBadgerBite";
    $libsynLink = "http://honeybadgerradio.libsyn.com/";
    $facebookLink = "https://www.facebook.com/groups/honeybadgerradio/";
    $mindsLink = "https://www.minds.com/HoneyBadgerRadio";
    $maillistIFrameLink = "https://app.getresponse.com/site2/honeybadgercontacts?u=kH9s&webforms_id=10996505";
    $loginLink = "http://feedthebadger.com/dashboard";

    //Summary Links
    //$featuredLink = ""; //This is generated on the fly.
    $subsLink = "http://www.feedthebadger.com/product/subscribe/"; //For monthly subscriptions

    //PayPal Slider
    $paypalEmail = "xenospora@gmail.com";

    //Donation Links
    $bitcoinLink = "https://spectrocoin.com/en/integration/buttons/46453-30xgUTMPKq.html";
    $lootLink = "http://www.cafepress.com/honeybadgerbrigade";
    $patronLink = "https://www.patreon.com/bePatron?u=157653&redirect_uri=http%3A%2F%2Fwww.feedthebadger.com%2Fdev%2Fhbrf%2F";

    //Contact Link
    $contactLink = "mailto:badgerwrites@gmail.com";

    ////

    //Summary Blurb
    /* All is projected into a paragraph element, and can accept HTML elements that are fit to sit within paragraph elements.
       To force carriage returns, add '</br>' to where you want the carriage return. */
    $summaryBlurb = "The badgers need your help! Both one-time donations and subscriptions purchased through feedthebadger will help the badgers achieve their current objective!";

    /////////////////////////////////////

    // END OF LINKS - DO NOT EDIT PAST THIS LINE //

    $dbHost = "<host>";
    $dbUser = "<username>";
    $dbPass = "<password>";
    $dataBase = "<database>";

    $total = 0;
    $goalTotal = 0;
    $baseAmount = 5000; //50.00
    $minAmount = 500; //5.00
    $maxAmount = 25000; //250.00
    $cards = "";
    $currencyPre;
    $currencySuf;

    function getCurrencyCode($cvalue) { 
        global $currencyPre, $currencySuf;
		switch($cvalue) {		
			case 'USD':	$currencyPre = '$'; break;
			case 'CAD':	$currencyPre = '$'; break;
			case 'AUD':	$currencyPre = '$'; break;
			case 'CZK':	$currencyPre = 'Kč'; break;
			case 'DKK':	$currencyPre = 'Kr'; break;
			case 'EUR':	$currencyPre = '&euro;'; break;
			case 'HKD': $currencyPre = '$'; break;
			case 'HUF':	$currencyPre = 'Ft'; break;
			case 'ILS':	$currencyPre = '₪'; break;
			case 'JPY':	$currencyPre = '&yen;'; break;
			case 'MXN':	$currencyPre = '$'; break;
			case 'MYR':	$currencyPre = 'RM'; break;
			case 'NOK':	$currencyPre = 'kr'; break;
			case 'NZD':	$currencyPre = '$'; break;
			case 'PHP': $currencyPre = '₱'; break;
			case 'PLN':	$currencyPre = 'zł'; break;
			case 'GBP':	$currencyPre = '&pound;'; break;
			case 'SGD': $currencyPre = '$'; break;
			case 'SEK': $currencyPre = 'kr'; break;
			case 'CHF': $currencyPre = 'CHF'; break;
			case 'TWD': $currencyPre = 'NT$'; break;
			case 'THB': $currencyPre = '&#3647;'; break;
			case 'TRY': $currencyPre = '&#8356;'; break;
			case 'BRL': $currencyPre = 'R$'; break;
			default :	$currencyPre = '$';
		}
        $currencySuf = $cvalue;
    }

    if(isset($dbHost)) {
        $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dataBase);

        if($mysqli->connect_errno) {
            $result = "Error connecting to MySQL Database: " . $mysqli->connect_error;
            die();
        }
        else {
            //Get currency first
            $query = "SELECT option_value FROM wp_rrtxxk_options WHERE option_name = 'woocommerce_currency'";

            if(!($r = $mysqli->query($query))) die("Error with getting currency: " . $mysqli->error . "</br>");
            else {
                while($row = $r->fetch_row()) {
                    getCurrencyCode
            ($row[0]);
                }
                $r->close();
            }

            //Now get post ids and title's for each fundraiser (but only if the fundraiser is open)
            $query = "SELECT prod.id, pid.post_id FROM wp_rrtxxk_ign_products prod
                      INNER JOIN wp_rrtxxk_postmeta pid ON pid.meta_value = prod.id AND pid.meta_key = 'ign_project_id'
                      INNER JOIN wp_rrtxxk_postmeta end ON end.meta_key = 'ign_project_closed' AND pid.post_id = end.post_id
                      WHERE end.meta_value != '1'";

            if(!($r = $mysqli->query($query))) die("Error with getting post id's: " . $mysqli->error . "</br>");
            else {
                while($row = $r->fetch_row()) {
                    //Construct the array of product id's and post id's of all projects that want to be used
                    $postData[] = array($row[0], $row[1]);
                }
                $r->close();
                $cards = ""; //Blank out the cards if a post has been found.
            }

            //Now loop through each post and construct array where "meta_key" is the key, and "meta_value" is the value
            if(isset($postData)) {
                for($i = 0; $i < count($postData); ++$i) {
                    $constructData = array(); // Clear the variable for each project

                    // Pull all post meta data from the postmeta table, where meta_key are keys, and meta_value are values
                    $query = "SELECT * FROM wp_rrtxxk_postmeta WHERE wp_rrtxxk_postmeta.post_id = " . $postData[$i][1] . 
                                " AND (wp_rrtxxk_postmeta.meta_key LIKE 'ign_%' OR wp_rrtxxk_postmeta.meta_key = '_thumbnail_id')";
                    if(!($r = $mysqli->query($query))) die("Error with getting post data: " . $mysqli->error . "</br>");
                    else {
                        while($row = $r->fetch_row()) {
                            // Main kvp array constructor.
                            $constructData[$row[2]] = $row[3];
                        }
                        $r->close();
                    }

                    // We need the permalink, and this will grab it
                    $query = "SELECT post_name FROM wp_rrtxxk_posts WHERE id = " . $postData[$i][1];
                    if(!($r = $mysqli->query($query))) die("Error with getting post URL: " . $mysqli->error . "</br>");
                    else {
                        while($row = $r->fetch_row()) {
                            $constructData["ign_project_url"] = "/projects/" . $row[0] . "/";
                        }
                        $r->close();
                    }

                    // Sometimes the client doesn't provide a featured image, this accounts for that and displays nothing
                    if(array_key_exists("_thumbnail_id", $constructData)) {
                        // '_thumbnail_id' (for the featured image) is actually a postmeta post_id for the actual thumbnail data. It's value is a serialised array
                        $query = "SELECT meta_value FROM wp_rrtxxk_postmeta WHERE meta_key = '_wp_attachment_metadata' AND post_id = " . $constructData["_thumbnail_id"];
                        if(!($r = $mysqli->query($query))) die("Error with getting thumbnail image: " . $mysqli->error . "</br>");
                        else {
                            $row = $r->fetch_row();
                            $thumbData = unserialize($row[0]); //Since we can't get the element of the function, the return needs to be stored somewhere
                            $constructData["_thumbnail_file"] = $thumbData["file"]; //We just need the file name, so just grab that;
                            $r->close();
                        }
                    }

                    // Main title is not included as part of the postmeta, so get it independently.
                    $query = "SELECT wp_rrtxxk_ign_products.product_name FROM wp_rrtxxk_ign_products
                            WHERE wp_rrtxxk_ign_products.id = " . $constructData["ign_project_id"];
                    if(!($r = $mysqli->query($query))) die("Error with getting main title: " . $mysqli->error . "</br>");
                    else {
                        $row = $r->fetch_row();
                        $constructData["ign_project_title"] = $row[0];
                        $r->close();
                    }

                    // Get the categories of the post
                    $query = "SELECT slug FROM wp_rrtxxk_term_relationships INNER JOIN wp_rrtxxk_terms ON term_id = term_taxonomy_id WHERE object_id = " . $postData[$i][1];
                    if(!($r = $mysqli->query($query))) die("Error with getting categories: " . $mysqli->error . "</br>");
                    else {
                        while($row = $r->fetch_row()) {
                            if($row[0] != "fundrasier-types") $constructData["post_categories"][] = $row[0];
                            else $constructData["post_categories"][] = "";
                        }
                        $r->close();
                    }

                    $projectData[] = $constructData; //Add the whole constructed data as an element in the projectData array
                }
            }
            else die("Error: No products retrived. Unable to get post data.");
        }

        $mysqli->close();
    }

    //Useless code now since the client didn't want to do this anymore...
    /*$mon = (date('n') - 1) % 3; //month of quarter for the base fundraiser system. Zero based
    $mon = 1; //testing

    $baseDeduction = 0;
    if($mon > 0) {
        if(file_exists("fundsraised.txt")) {
            $contents = file_get_contents("fundsraised.txt", false, NULL, 0, 10); //get the first 10 bytes of the file. The amount to deduct should not be any more than this
            $baseDeduction = explode(PHP_EOL, $contents, 1); //explode on line feed, and return first element, which should be our number
            $baseDeduction = $baseDeduction[0]; //overwrite the entire array with just the first element
        }
        else die("Processing file does not exist in directory. Please contact a <a href='mailto:admin@feedthebadger.com'>system administrator</a> stating this error message.");
    }

    //Do the processing things for the end of the month. This should only be run by CRON
    if(isset($_GET['cron'])) {
        if($_GET['cron'] == '%U$I$$Vp6Ly8') { //password to avoid any random user from executing this code.

            $lines = file("fundsraised.txt", FILE_SKIP_EMPTY_LINES); //drop the entire file into an array based on line feed            
            $monthyear = date("Y-F"); //Year-Month
            $newLine = $monthyear . ":\t";

            foreach($projectData as $fr) {
                $tempGoal = $fr["ign_fund_goal"];

                if(in_array("base", $fr["post_categories"])) {
                    if($mon > 0)
                        $tempGoal = $fr["ign_stretch-" . $mon . "_amount"] - $fr["ign_fund_goal"]; //goal is stretchgoal - goal
                    $lines[0] = $fr["ign_fund_raised"]; //set the first line to be the current funds raised. Will either be 0 or greater
                }
                
                $types = implode(", ", $fr["post_categories"]);
                $newLine .= "[" . substr($types, 0, strlen($types) - 2) . //add type of fundraised
                    " | Raised: " . $fr["ign_fund_raised"] . //add amount raised
                    " | Goal: " .   $tempGoal . "]\t"; //add goal
            }

            $lines[] = substr($newLine, 0, strlen($newLine) - 1); //Append the line as an entire array element

            $handle = fopen('fundsraised.txt', 'w') or die("Error opening file for writing.");

            fwrite($handle, implode(PHP_EOL, $lines)); //write the entire imploded array to the file
            fclose($handle);

            echo "File updated.</br>New BaseDeduction: " . $lines[0] . "</br>New Month Log: " . $newLine;
            die(); //If the cron job executes, we don't need to load the entire page to the server, so just die
        }
    }*/

    $cardCount = count($projectData);

    foreach($projectData as $post) {
        $cardTotal = $post["ign_fund_raised"];
        $cardGoal = $post["ign_fund_goal"];

        //make stretch goals the new goal if the amount raised surpasses the old goal
        /*if($cardTotal > $cardGoal) {
            for($i = 1; $i < $post["ign_stretch_count"]; ++$i) {
                if($cardTotal > $post["ign_stretch-".$i."_amount"])
                    $cardGoal = $post["ign_stretch-" . $i . "_amount"];
            }
        }*/

        //main category checking. Fundrasier types are set as a category, so we just check if the category exists
        if(in_array("base", $post["post_categories"])) {
            /*$cardTotal -= $baseDeduction;
            if($mon > 0) {
                $cardGoal = $post["ign_stretch-" . $mon . "_amount"] - $post["ign_fund_goal"];
                $post["ign_project_title"] = $post["ign_stretch-" . $mon . "_title"];
            }*/
            $total += $cardTotal;
            $goalTotal += $cardGoal;
            $baseLink = $post["ign_project_url"];
        }
        elseif(in_array("project", $post["post_categories"])) {
            $total += $cardTotal;
            /*if($cardTotal > $cardGoal) {
                for($i = 1; $i < $post["ign_stretch_count"]; ++$i) {
                    if($cardTotal > $post["ign_stretch-".$i."_amount"])
                        $cardGoal = $post["ign_stretch-" . $i . "_amount"];
                }
            }*/
            $goalTotal += $cardGoal;
        }
        elseif(in_array("contingency", $post["post_categories"])) {
            $total += $cardTotal;
        }
        elseif(in_array("expense", $post["post_categories"])) {
            //$total += $cardTotal;
            $goalTotal += $cardGoal;
        }
        elseif(in_array("collaboration", $post["post_categories"])) {
            $total += ($cardTotal / 2);
        }


        //featured fundrasiers appear at the top in the main graphic, and are also considered an additional category
        //  client request: The featured fundrasier is overridden by other the last most featured fundrasier
        if(in_array("featured", $post["post_categories"])) {
            $featuredImg = 'http://feedthebadger.com/wp-content/uploads/' . $post["_thumbnail_file"];
            $featuredTitle = $post["ign_project_title"];
            $featuredBlurb = $post["ign_project_description"];
            $featuredLink = $post["ign_project_url"];
            //$cardCount--; //Card isn't being displayed, so decrement this counter
            //continue; //Client doesn't want featured projects displayed as a card
        }

        $percent = ($post["ign_percent_raised"] < 100) ? $post["ign_percent_raised"] : 100;

        $cards .= 
            '<div class="card">' .
                '<a href="' . $post["ign_project_url"] . '" target="_blank">' . 
                    '<div style="background-image: url(\'http://feedthebadger.com/wp-content/uploads/' . $post["_thumbnail_file"] . '\');" class="header_image"></div>' .
                '</a>' .
                '<a class="title" target="_blank" href="' . $post["ign_project_url"] . '"><h2>' . $post["ign_project_title"] . '</h2></a>' .
                '<h3>' . $currencyPre . number_format($cardTotal, 2) . '<span style="font-size: 8pt;">' . $currencySuf . '</span></h3>' .
                '<h3 style="float: right;">' . $currencyPre . number_format($cardGoal, 2) . '<span style="font-size: 8pt;">' . $currencySuf . '</span></h3>' .
                '<div class="prog_bar"><div class="progress" style="width: ' . $percent . '%;"></div></div>' .
                '<div class="description">' . $post["ign_project_description"] . '</div>' .
                '<a class="help" href="' . $post["ign_project_url"] . '" target="_blank" title="Contribute specifically to this fundrasier.">I WANT TO HELP!</a>' .
            '</div>';
    }

    //Add placeholder cards if there's less than three being displayed
    while($cardCount < 3) {
        $cards .= '<div class="card"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/placeholder.gif" alt="Coming Soon" /></div>';
        $cardCount++;
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta name="theme-color" content="#990000">
        <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
        <meta name="description" content="Honey Badger Radio Fundraisers">
        <meta name="keywords" content="HBR,Honey Badger Radio,Honey Badger,Honeybadger,youtube,fundrasier">
        <meta name="author" content="Zion Fox">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="stylesheet" href="http://feedthebadger.com/wp-content/themes/fivehundred/styles.css" type="text/css" />
        <link rel="stylesheet" href="http://feedthebadger.com/wp-content/themes/fivehundred/small.css" type="text/css" media="screen and (max-width: 1270px)" />
        <link rel="shortcut icon" href="images/favicon.png" />
        <!-- max width 1041px -->
        
        <title>HBR Fundraisers</title>
    </head>

    <body>
        <div id="cover" class="hidden"></div>
        <header>
            <div id="heading">
                <h1>HONEY BADGER RADIO</h1>
                <h2>FUNDRAISERS</h2>
            </div>
            <div class="media_tiles">
                <img class="follow" src="http://feedthebadger.com/wp-content/themes/fivehundred/images/follow.svg" alt="Follow Us!" />
                <a target="_blank" href="<?php echo $youtubeLink; ?>" title="Visit our YouTube channel!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/youtube.png" alt="YouTube" /></a>
                <a target="_blank" href="<?php echo $twitterLink; ?>" title="Visit our Twitter!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/twitter.png" alt="Twitter" /></a>
                <a target="_blank" href="<?php echo $libsynLink; ?>" title="Visit our Libsyn!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/libsyn.png" alt="Libsyn" /></a>
                <a target="_blank" href="<?php echo $facebookLink; ?>" title="Visit our Facebook Page!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/facebook.png" alt="Facebook" /></a>
                <a target="_blank" href="<?php echo $mindsLink; ?>" title="Visit our Minds page!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/minds.png" alt="Minds" /></a>
                <div style="display: inline-block; cursor: pointer;" onclick="toggleMailList();" title="Sign up to our Mailing List!"><img style="box-shadow: 0px 0px 0px rgba(0, 0, 0, 0);" src="http://feedthebadger.com/wp-content/themes/fivehundred/images/maillist.png" alt="Mailing List" /></div>
                <a id="login" href="<?php echo $loginLink; ?>" title="Log in to your account.">LOGIN</a>
            </div>
        </header>
        
        <main>
            <article>
                <a href="<?php echo $featuredLink; ?>" target="_blank">
                    <div class="feat_img" style="background-image: url(' <?php echo $featuredImg; ?> ');">
                        <div class="feat_title">
                            <h3 style="font-size: 0.8em;">Featured Project</h3>
                            <h2><?php echo $featuredTitle; ?></h2>
                        </div>
                        <div class="feat_blurb">
                            <p><?php echo $featuredBlurb; ?></p>
                        </div>
                    </div>
                </a>
                <div id="group">
                    <h2>Total Raised</h2>
                    <h3 class="total_now"><?php echo $currencyPre . number_format($total, 2) . '<span style="font-size: 8pt;">' . $currencySuf . '</span>'; ?></h3>
                    <h3 class="total_goal"><?php echo $currencyPre . number_format($goalTotal, 2) . '<span style="font-size: 8pt;">' . $currencySuf . '</span>'; ?></h3>
                    <div class="prog_bar">
                        <?php
                            $width = ($goalTotal > 0) ? (100 / $goalTotal) * $total : 0;
                            $width = ($width > 100) ? 100 - $left : $width;
                            $border = '4px;';
                        ?>
                        <div class="progress main" style="width: <?php echo $width; ?>%; border-radius: <?php echo $border; ?>;"></div>
                    </div>
                    <p><?php echo $summaryBlurb; ?></p>
                    <a class="once button" target="_blank" href="<?php echo $featuredLink; ?>" title="Featured Fundraiser.">I WANNA FEED THE BADGER!<img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/feed.svg" alt="" /></a>
                    <a class="month button" target="_blank" href="<?php echo $subsLink; ?>" title="Monthly subscription."><span>I WANNA FEED THE BADGER</span><span>MONTHLY!</span><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/monthly.svg" alt="" /></a>
                </div>
            </article>

            <article id="slider">
                <h2 class="tagline">Feed us anonymously through PayPal:</h2>
                <form id="amount"><?php echo $currencyPre; ?><input id="amountinput" name="amount" type="number" pattern="[0-9]*" value=<?php echo "\"" . number_format($baseAmount / 100, 2) . "\""; ?> min=<?php echo "\"" . number_format(($minAmount) / 100, 2, '.', '') . "\""; ?> max=<?php echo "\"" . number_format(($maxAmount) / 100, 2, '.', '') . "\""; ?>><span style="font-size: 8pt;"><?php echo $currencySuf; ?></span></form>
                <input id="sliderbar" class="bar" type="range" value=<?php echo "\"" . $baseAmount . "\""; ?> min=<?php echo "\"" . $minAmount . "\""; ?> max=<?php echo "\"" . $maxAmount . "\""; ?> step="500">
                <div class="back"></div>
                <div class="current" style=<?php echo "\"width: " . (($baseAmount - $minAmount) / ($maxAmount - $minAmount) * 75) . "%;\""; ?>></div>
                <div class="images">
                    <div class="img left"></div>
                    <div class="img right"></div>
                </div>
                <form id="pp" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                    <input type="hidden" name="cmd" value="_donations">
                    <input type="hidden" name="business" value="<?php echo $paypalEmail; ?>">
                    <input type="hidden" name="lc" value="GB">
                    <input type="hidden" name="item_name" value="FeedTheBadger">
                    <input id="contribute" type="hidden" name="amount" value="<?php echo number_format($baseAmount/100, 2); ?>">
                    <input type="hidden" name="currency_code" value="<?php echo $currencySuf; ?>">
                    <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
                    <button type="submit" name="submit" title="PayPal - The safer, easier way to pay online!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/paypal.svg" alt="PayPal" />PAL CHIPS!</button>
                </form>
            </article>

            <article id="donate">
                <h2 class="tagline">Other ways to help:</h2>
                <a class="bitcoin button" href="<?php echo $bitcoinLink; ?>" target="_blank" title="Support us using Bitcoin!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/bitcoin.svg" alt="Bitcoin" />GIVE US BITCOIN!</a>
                <a class="volunteer button" href="<?php echo $lootLink; ?>" target="_blank" title="Buy some Badger Merch!"><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/loot.svg" alt="" />GET SOME AWZM LOOT!</a>
                <a class="patron button" target="_blank" href="<?php echo $patronLink; ?>" title="Monthly Subscription through Patreon."><img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/patreon.svg" alt="Patreon" />PATRONIZE US!</a><!-- Should be "Patronise"!!! -->
            </article>

            <article id="sub">
                <h2 class="tagline" style="margin-top: -54px;">Or contribute to the following projects:</h2>
                <div id="cardwrapper">
                    <?php echo $cards; ?>
                </div>
                <span class="hint">Swipe to see more >></span>
            </article>

            <article id="info_overlay" class="hidden">
                <h2>More Information!</h2>
                <p>Some text about getting some info or whatnot. Lorem ipsum dolor sit amet.</p>
                <a class="details button" onclick="toggleInfo();" href="<?php echo $featuredLink; ?>" target="_blank" title="Get more details.">Details</a>
                <div class="dismiss button" onclick="toggleInfo();">Dismiss</div>
            </article>

            <article id="maillist_overlay" class="hidden">
                <iframe src="<?php echo $maillistIFrameLink; ?>"></iframe>
                <div class="dismiss button" onclick="toggleMailList();">Dismiss</div>
            </article>
        </main>

        <footer>
            <div id="feedback">Issues? Feedback? <a href="<?php echo $contactLink; ?>">Contact us!</a></div>
            <div id="copyright">Designed by <img src="http://feedthebadger.com/wp-content/themes/fivehundred/images/badgerlabs.png" alt="BadgerLabs" />&copy; <?php echo date('Y'); ?> - Honey Badger Radio Ltd.</div>
            <a id="developer" target="_blank" href="http://zionfox.net">
                <img src="http://zionfox.net/images/logo.svg" alt="Developer's Logo" />
                <span>Developed by Zion Fox</span>
            </a>
        </footer>
    <script src="http://feedthebadger.com/wp-content/themes/fivehundred/script.js" type="text/javascript"></script>
    </body>
</html>