<?php

$cardTitle = "Card";

if($app->objCustomPlatform->getCompanyId() === 0)
{
    $cardTitle = "EZcard";
}

$objLoggedInUser = $app->getActiveLoggedInUser();
$userRoleClass = $objLoggedInUser->Roles !== null ? ($objLoggedInUser->Roles->FindEntityByKey("user_class_type_id")->user_class_type_id ?? null) : null;

?>

<!DOCTYPE html>
<!--
//============================================================================
// EZ Digital Communications Platform
// Copyright <c> <?php echo date('Y'); ?> EZ Digital, LLC. All rights reserved.
//============================================================================
// -->
<head>
    <title><?php echo $objCard->card_name; ?></title>

    <meta charset="utf-8">
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="author" content="<?php echo $app->objCustomPlatform->getPublicName(); ?>" />
    <meta name="description" content="Digital Business Card" />
    <meta property="og:title" content="<?php echo $objCard->card_name; ?>" />
    <meta property="og:site_name" content="<?php echo $app->objCustomPlatform->getPublicName(); ?>" />
    <meta property="og:image" content="<?php echo $objCard->favicon; ?>" />
    <meta data-rh="true" property="thumbnail" content="<?php echo $objCard->banner; ?>" />
    <meta data-rh="true" property="og:image" content="<?php echo $objCard->banner; ?>" />
    <meta data-rh="true" property="og:image:height" content="400" />
    <meta data-rh="true" property="og:image:width" content="400" />
    <meta data-rh="true" property="twitter:image" content="<?php echo $objCard->banner; ?>" />
    <link rel="icon" type="image/png" href="<?php echo $objCard->favicon; ?>"/>
    <link rel="apple-touch-icon" href="<?php echo $objCard->favicon; ?>">

    <meta name="google-site-verification" content="" />
    <meta name="Copyright" content="Town Life EZ Marketing" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="<?php echo $objCard->favicon_ico; ?>" />
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $objCard->favicon_image; ?>" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="/_ez/templates/1/css/template.min.css?card_id=<?php echo $objCard->card_id; ?>&_A1<?php echo rand(100,999); ?>x" />

    <?php if (userIsEzDigital($userRoleClass)) { ?>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <?php } ?>
    <script src="https://use.fontawesome.com/94c95596ca.js"></script>
    <script src="/_ez/templates/1/js/template.min.js?card_id=<?php echo $objCard->card_id; ?>&_A1<?php echo rand(100,999); ?>x"></script>
    <script src="/_ez/app.js?_A1x" type="text/javascript"></script>
    <link href='https://fonts.googleapis.com/css?family=<?php echo $objCard->card_data->style->card->font->main->google_font_name ?? ""; ?>' rel='stylesheet' type='text/css'>
    <script type="text/javascript">
        if ('Notification' in window && navigator.serviceWorker) {
            // console.log("ServiceWorker available");
            // if (Notification.permission === "granted") {
            //     /* do our magic */
            //     console.log("granted");
            // } else if (Notification.permission === "blocked") {
            //     /* the user has previously denied push. Can't reprompt. */
            //     console.log("blocked");
            // } else {
            //     /* show a prompt to the user */
            //     console.log("show prompt for approval");
            //     Notification.requestPermission().then(function(permission) {
            //         console.log(permission);
            //         console.log("permission granted!");
            //     });
            // }
        }
    </script>

    <style type="text/css">
        .wrapper {
            box-shadow:rgba(0,0,0,.3) 0 0 10px;
        }
        .tabTitle {
            padding-top:<?php echo $intCardPageHeight; ?>px;
            padding-bottom:<?php echo $intCardPageHeight; ?>px;
        }
        .mainButtons a li {
            position:relative;
        }
        .tab-title-text {
            position: absolute;
            top: -40px;
            left: -3px;
            font-size: 13px;
            width: calc(100% + 6px);
            text-transform: uppercase;
            -webkit-border-radius: 5px 5px 0 0;
            -moz-border-radius: 5px 5px 0 0;
            border-radius: 5px 5px 0 0;
            height: 28px;
            display: flex;
            vertical-align: middle;
            text-align: center !important;
            justify-content: center;
            flex-direction: column;
        }
        .card-primary-color {
            background-image: -webkit-linear-gradient(270deg,rgba(<?php echo $intMainColorRed; ?>,<?php echo $intMainColorGreen; ?>,<?php $intMainColorBlue; ?>,1.00) 0%,rgba(<?php echo $intMainColorRedDark; ?>,<?php echo $intMainColorGreenDark; ?>,<?php echo $intMainColorBlueDark; ?>,1.00) 100%);
            background-image: -moz-linear-gradient(270deg,rgba(<?php echo $intMainColorRed; ?>,<?php echo $intMainColorGreen; ?>,<?php echo $intMainColorBlue; ?>,1.00) 0%,rgba(<?php echo $intMainColorRedDark; ?>,<?php echo $intMainColorGreenDark; ?>,<?php echo $intMainColorBlueDark; ?>,1.00) 100%);
            background-image: -o-linear-gradient(270deg,rgba(<?php echo $intMainColorRed; ?>,<?php echo $intMainColorGreen; ?>,<?php echo $intMainColorBlue; ?>,1.00) 0%,rgba(<?php echo $intMainColorRedDark; ?>,<?php echo $intMainColorGreenDark; ?>,<?php echo $intMainColorBlueDark; ?>,1.00) 100%);
            background-image: linear-gradient(180deg,rgba(<?php echo $intMainColorRed; ?>,<?php echo $intMainColorGreen; ?>,<?php echo $intMainColorBlue; ?>,1.00) 0%,rgba(<?php echo $intMainColorRedDark; ?>,<?php echo $intMainColorGreenDark; ?>,<?php echo $intMainColorBlueDark; ?>,1.00) 100%);
        }
        .social-media-button-outer {
            position: absolute;
            right:0;
            top:90px;
        }
        .social-media-button-outer ul {
            left: 34px;
            position: relative;
        }
        .social-media-button-outer li {
            margin-bottom:5px;
        }
        .social-media-button-outer li a {
            padding: 11px 12px 8px;
            border-radius: 0 3px 3px 0;
            text-align: center;
            display:block;
        }
        .social-media-button-outer li a i {
            color:white;
            width:10px;
            display: inline-block;
            position: relative;
            left: -1px;
        }
        @media (min-width:769px){
            .wrapper {
                max-width: <?php echo $intCardWidth; ?>px;
            }
        }
        @media (max-width:769px){

            .social-media-button-outer {
                position: relative;
                right:0;
                left:0;
                top:0;
                width:100%;
                display: table;
            }
            .social-media-button-outer ul {
                left: 0;
                display: table-row;
            }
            .social-media-button-outer li {
                margin-bottom:0;
                display: table-cell;
            }
            .social-media-button-outer li a {
                padding: 11px 12px 8px;
                border-radius: 0;
                display:inline-block;
                width:100%;
            }
        }
    </style>
</head>

<body style="font-family: <?php echo $objCard->card_data->style->card->font->main->font_name; ?>;">
<div class="wrapper">
    <div class="mainImage">
        <div class="social-media-button-outer" style="display:none;">
            <ul>
                <li class="facebook-link"><a class="card-primary-color"href="https://www.facebook.com/sharer/sharer.php?u=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li class="twitter-link"><a class="card-primary-color" href="https://twitter.com/intent/tweet?url=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li class="linkedin-link"><a class="card-primary-color" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>&title=&summary=&source=" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                <li class="pinterest-link"><a class="card-primary-color" href="https://pinterest.com/pin/create/button/?url=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>&media=&description=" target="_blank"><i class="fa fa-pinterest"></i></a></li>
            </ul>
        </div>
        <img src="<?php echo $objCard->banner; ?>?rand=<?php echo time(); ?>" alt=""/>
    </div>
    <div class="mainButtons">
        <ul>
            <?php
            foreach ( $objCard->Connections as $intConnectionIndex => $objCardConnection)
            {
                $strLinkSpecial = '';
                switch($objCardConnection->action)
                {
                    case "phone":
                        $strLinkSpecial    = 'tel:';
                        $strBootstrapClass = "fa fa-mobile";
                        break;
                    case "sms":
                        $strLinkSpecial    = 'sms:';
                        $strBootstrapClass = "fa fa-commenting-o";
                        break;
                    case "email":
                        $strLinkSpecial    = 'mailto:';
                        $strBootstrapClass = "fa fa-envelope";
                        break;
                    case "link":
                        // TODO- APPEND HTTP IF MISSING
                        if(strpos($objCardConnection->connection_value, "http") === false)
                        {
                            $strLinkSpecial    = 'http://';
                        }

                        switch(strtolower($objCardConnection->connection_type_id))
                        {
                            case "twitter":
                                $strBootstrapClass = "fa fa-twitter";
                                break;
                            case "facebook":
                                $strBootstrapClass = "fa fa-facebook";
                                break;
                            case "linkedin":
                                $strBootstrapClass = "fa fa-linkedin";
                                break;
                            default:
                                $strBootstrapClass = "fa fa-globe";
                                break;
                        }

                        break;
                    case "default":
                        $strLinkSpecial    = '';
                        $strBootstrapClass = "fa fa-columns";
                        break;
                }
                ?>
                <a href="<?php echo $strLinkSpecial; ?><?php echo $objCardConnection->connection_value; ?>">
                    <li class="card-primary-color">
                        <span class="tab-title-text card-primary-color" style="display:none;"><?php echo $objCardConnection->connection_type_id; ?></span>
                        <i class="<?php echo $strBootstrapClass; ?>" aria-hidden="true"></i>
                    </li>
                </a>
            <?php } ?>

        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="tabs">
        <ul>
            <?php
            foreach($objCard->Tabs as $currTabsIndex => $currCardPage)
            {
            if (

                ($currCardPage->rel_visibility == false || $currCardPage->visibility == false) ||
                ($currCardPage->card_tab_rel_type == "mirror" && ($currCardPage->rel_visibility == false || $currCardPage->library_tab == false ))
            )
            {
                continue;
            }
            ?>
            <li>
                <div class="tabTitle card-primary-color" id="tab<?php echo $currCardPage->card_tab_rel_id; ?>">
                    <?php if (empty($currCardPage->card_tab_rel_data->Properties->CustomTitle)) { ?>
                        <?php echo $currCardPage->title; ?>
                    <?php } else { ?>
                        <?php echo $currCardPage->card_tab_rel_data->Properties->CustomTitle; ?>
                    <?php } ?>
                </div>
                <div class="tabContent<?php if (!empty($objData->Data->Params["open_tab"]) && $objData->Data->Params["open_tab"] == $currCardPage->rel_sort_order) { ?> tab-open"<?php } ?>" id="content<?php echo $currCardPage->card_tab_rel_id; ?>"<?php if (!empty($objData->Data->Params["open_tab"]) && $objData->Data->Params["open_tab"] == $currCardPage->rel_sort_order) { ?> style="display:block;"<?php } ?>>
                <?php if (!empty($objData->Data->Params["open_tab"]) && $objData->Data->Params["open_tab"] == $currCardPage->rel_sort_order) { ?>
                    <?php
                    // TODO - Show Template File If Necessary
                    echo base64_decode($currCardPage->content);
                    ?>
                <?php } else { ?>
                    <div style="border: 8px solid #fff;"></div>
                <?php } ?>
    </div>
    </li>
    <?php
    }
    ?>
    </ul>
</div>
<?php

$strPurchasePageUrl = "https://www.ezcard.com";

if ( empty($objCard->card_data->style->card) || empty($objCard->card_data->style->card->toggle) || ($objCard->card_data->style->card->toggle->footer == null || $objCard->card_data->style->card->toggle->footer == true ))
{
    if($app->objCustomPlatform->getCompanyId() === 0)
    { ?>
        <a href="<?php echo $strPurchasePageUrl; ?>" target="_blank" style="text-decoration: none;">
            <div class="footer">
                <div class="footerLeft">
                    EZcard <img src="/website/images/ezcard_logo-new-black.svg" style="vertical-align: middle;width: 37px;" alt=""/>
                </div>
                <div class="clearfix"></div>
            </div>
        </a>
    <?php   } else { ?>
        <div class="footer">
            <div class="footerLeft" style="font-size: 11px; padding-top: 3px;">
                Powered by <span style="font-size: 18px;">EZ Digital</span>
            </div>
            <div class="clearfix"></div>
        </div>
    <?php   } ?>
    <?php
} ?>
</div>
<?php

?>
<input id="x" type="hidden" value="<?php echo (isset($app->objAppSession["Core"]["Session"]["Authentication"]["username"]) ? $app->objAppSession["Core"]["Session"]["Authentication"]["username"] : ""); ?>" />
<input id="y" type="hidden" value="<?php echo (isset($app->objAppSession["Core"]["Session"]["Authentication"]["password"]) ? $app->objAppSession["Core"]["Session"]["Authentication"]["password"] : ""); ?>" />
<input id="ip_info" type="hidden" value="<?php echo (isset($app->objAppSession["Core"]["Session"]["IpInfo"]->guid) ? $app->objAppSession["Core"]["Session"]["IpInfo"]->guid : ""); ?>" />
<input id="card_id" type="hidden" value="<?php echo (isset($intCardId) ? $intCardId : "0"); ?>" />
<input id="card_num" type="hidden" value="<?php echo (isset($intCardNum) ? $intCardNum : "0"); ?>" />
<input id="user_id" type="hidden" value="<?php echo (isset($intUserId) ? $intUserId : "0"); ?>" />
<input id="browser_id" type="hidden" value="<?php echo (isset($app->objAppSession["Core"]["Session"]["Browser"]) ? $app->objAppSession["Core"]["Session"]["Browser"] : ""); ?>" />
<input id="cardIdLegacy" type="hidden" value="<?php echo (isset($app->objAppSession["Core"]["Session"]["card"]["ActiveCard"]) ? $app->objAppSession["Core"]["Session"]["Card"]["ActiveCard"] : "0"); ?>" />
<script type="text/javascript">

</script>
</body>
</html>

