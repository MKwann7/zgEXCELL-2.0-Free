<?php
/**
 * Created by PhpStorm.
 * User: micah.zak
 * Date: 3/11/2019
 * Time: 1:13 PM
 */

use Entities\Cards\Classes\Cards;$objLoggedInUser = $this->app->GetActiveLoggedInUser();
header('Content-Type:text/css');

$objCardResult = (new Cards())->getFks()->getById($this->app->objHttpRequest->Data->Params['card_id']);

$objCard = $objCardResult->getData()->first();

?>
@font-face {
    font-family: HelveticaCondensedBold;
    src: local("HelveticaCondensedBold"), url("/_ez/fonts/helveticaneue-condensedbold.eot") format("eot");
    src: local("HelveticaCondensedBold"), url("/_ez/fonts/helveticaneue-condensedbold.woff") format("woff");
}

@font-face {
    font-family: AvenirLTStd;
    src: local("HelveticaCondensedLight"), url("/_ez/fonts/helveticaneue-light.eot") format("eot");
    src: local("HelveticaCondensedLight"), url("/_ez/fonts/helveticaneue-light.woff") format("woff");
}

@font-face {
    font-family: SymbolsRegular;
    src: local("SymbolsRegular"), url("/_ez/fonts/symbols-regular.eot") format("eot");
    src: local("SymbolsRegular"), url("/_ez/fonts/symbols-regular.woff") format("woff");
}

/* EZcard Reset */
html,body,body div,span,object,iframe,p,blockquote,pre,abbr,address,cite,code,del,dfn,em,img,ins,kbd,q,samp,small,strong,sub,sup,var,b,i,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,figure,footer,header,menu,nav,section,time,mark,audio,video,details,summary{margin:0;padding:0;border:0;font-size:100%;font-weight:400;vertical-align:baseline;background:transparent}article,aside,figure,footer,header,nav,section,details,summary{display:block}html{box-sizing:border-box}*,:before,:after{box-sizing:inherit}img,object,embed{max-width:100%}html{overflow-y:scroll}ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:'';content:none}a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent}del{text-decoration:line-through}abbr[title],dfn[title]{border-bottom:1px dotted #000;cursor:help}table{border-collapse:separate;border-spacing:0}th{font-weight:700;vertical-align:bottom}td{font-weight:400;vertical-align:top}hr{display:block;height:1px;border:0;border-top:1px solid #ccc;margin:1em 0;padding:0}input,select{vertical-align:middle}pre{white-space:pre;white-space:pre-wrap;word-wrap:break-word}input[type="radio"]{vertical-align:text-bottom}input[type="checkbox"]{vertical-align:bottom}.ie7 input[type="checkbox"]{vertical-align:baseline}.ie6 input{vertical-align:text-bottom}select,input,textarea{font:99% sans-serif}table{font-size:inherit;font:100%}small{font-size:85%}strong{font-weight:700}td,td img{vertical-align:top}sub,sup{font-size:75%;line-height:0;position:relative}sup{top:-.5em}sub{bottom:-.25em}pre,code,kbd,samp{font-family:monospace,sans-serif}.clickable,label,input[type=button],input[type=submit],input[type=file],button{cursor:pointer}button,input,select,textarea{margin:0}button,input[type=button]{width:auto;overflow:visible}.ie7 img{-ms-interpolation-mode:bicubic}.clearfix:after{content:" ";display:block;clear:both}

/* EZcard Template */
body{font-size:3vw;background-color:#fff}.heading1{font-size:7vw;color:<?php echo $objCard->card_data->style->card->color->main; ?>}.heading2{font-size:5vw}.heading3{color:<?php echo $objCard->card_data->style->card->color->main; ?>;font-weight:700}.spacer3vw{height:3vw}.mainButtons li{background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;width:21%;float:left;padding:2vw 0;text-align:center;color:#fff;font-size:12vw;border-radius:5vw;margin:0 2%}.mainButtons{margin:3vw 0}.tabs{margin:2vw 0 0}.tabTitle{background:#434dd8;background:-moz-linear-gradient(top,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);background:-webkit-linear-gradient(top,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);background:linear-gradient(to bottom,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#434dd8',endColorstr='<?php echo $objCard->card_data->style->card->color->main; ?>',GradientType=0);color:#fff;font-size:5vw;padding:3vw 2vw;text-align:center;cursor:pointer}.tabContent{padding:3vw 2vw;font-size:4vw;display:none}.saveCardButtons li{width:48%;border-radius:2vw;text-align:center;float:left;background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;margin:0 1%;padding:3%;color:#fff;cursor:pointer}.saveCardContent{margin:4vw 0 0;padding:0 8vw;display:none}.saveCardTitle{font-weight:700}ol{margin:5vw 8vw 0}.saveCardTitle img{border:1px solid <?php echo $objCard->card_data->style->card->color->main; ?>}.smallPrint{font-size:3vw;line-height:4vw}.saveCardTitle li{border-bottom:1px solid <?php echo $objCard->card_data->style->card->color->main; ?>;padding:0 0 5vw;margin:0 0 5vw}.saveCardTitle li:last-child{border-bottom:none}.phoneIcon{text-align:center;font-size:30vw}.shareCardButtons li{width:30%;border-radius:2vw;text-align:center;float:left;background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;margin:0 1%;padding:3%;color:#fff;cursor:pointer}.shareCardButtons.four-column-share li{width:23%!important;padding:3% 1%!important}.shareCardButtons a{color:#fff;text-decoration:none}.shareCardContent{margin:5vw;display:none}#email{width:100%}.submitSendEmail{background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;color:#fff;border:none;border-radius:2vw;padding:2vw 5vw}.footer{margin:0;background-color:gray;color:#fff;padding:0;font-size:3vw;border-top:1vw solid #fff}.footerLeft{font-family:HelveticaCondensedBold,Helvetica,"Arial Black";margin:2px 0 0;min-height:35px;float:left;width:100%;font-size:19px;text-align:center;vertical-align:middle}.footerRight{width:100%;margin:0 auto;float:left}.footerBottom{margin:2vw 0 0}.mainImage{width:100%;position:relative}.mainImage img{width:100%}#shareCardContentQRCode{width:300px;margin:0 auto}.tabContent p{margin:1vw 0}.inactiveCard{text-align:center;font-size:10vw;margin:5vw 0}.display-user-full-name{position:absolute;bottom:12px;width:100%;text-align:center;font-size:8vw;display:block;box-sizing:border-box}.wrapper{position:relative}.tabContent ul{padding-left:20px}.fa:before{top:-2px;position:relative;}

/* EZcard Responsive */
@media (min-width:769px){body{font-size:14px}.wrapper{margin:0 auto;}.heading1{font-size:18px;color:<?php echo $objCard->card_data->style->card->color->main; ?>}.heading2{font-size:14px}.heading3{color:<?php echo $objCard->card_data->style->card->color->main; ?>;font-weight:700;font-size:14px}.spacer3vw{height:6px}.paragraphText{font-size:14px}.mainButtons li{background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;width:21%;float:left;padding:4% 0;text-align:center;color:#fff;font-size:30px;border-radius:10px;margin:0 2%}.mainButtons{margin:6px 0}.tabs{margin:4px 0 0}.tabTitle{background:#434dd8;background:-moz-linear-gradient(top,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);background:-webkit-linear-gradient(top,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);background:linear-gradient(to bottom,#434dd8 0%,<?php echo $objCard->card_data->style->card->color->main; ?> 100%);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#434dd8',endColorstr='<?php echo $objCard->card_data->style->card->color->main; ?>',GradientType=0);color:#fff;font-size:19px;padding:15px 4px;text-align:center;cursor:pointer}.tabContent{padding:14px 12px;font-size:14px;display:none}.saveCardButtons li{width:48%;border-radius:4px;text-align:center;float:left;background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;margin:0 1%;padding:3%;color:#fff;cursor:pointer}.saveCardContent{margin:8px 0 0;padding:0 16px;display:none}.saveCardTitle{font-weight:700;font-size:18px}ol{margin:10px 16px 0}.saveCardTitle img{border:1px solid <?php echo $objCard->card_data->style->card->color->main; ?>}.smallPrint{font-size:8px;line-height:8px}.saveCardTitle li{border-bottom:1px solid <?php echo $objCard->card_data->style->card->color->main; ?>;padding:0 0 10px;margin:0 0 10px}.saveCardTitle li:last-child{border-bottom:none}.phoneIcon{text-align:center;font-size:60px}.shareCardButtons li{width:30%;border-radius:4px;text-align:center;float:left;background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;margin:0 1%;padding:3%;color:#fff;cursor:pointer;font-size:14px}.shareCardButtons.four-column-share li{width:23%!important;padding:3% 1%!important}.shareCardButtons a{color:#fff;text-decoration:none}.shareCardContent{margin:10px;display:none;font-size:14px}#email{width:100%}.submitSendEmail{background-color:<?php echo $objCard->card_data->style->card->color->main; ?>;color:#fff;border:none;border-radius:4px;padding:4px 10px}.footer{margin:8px 0 0;background-color:gray;color:#fff;text-align:center;padding:4px;font-size:6px;border-top:0}.footerTop{margin:0 0 4px}.footerImage{width:50%;margin:0 auto}.footerBottom{margin:4px 0 0}.mainImage{width:100%}.mainImage img{width:100%}#shareCardContentQRCode{width:300px;margin:0 auto}.inactiveCard{text-align:center;font-size:28px;margin:10px 0}.display-user-full-name{position:absolute;bottom:12px;width:100%;text-align:center;font-size:30px}}

<?php include(PUBLIC_DEFAULT . "css/default.css"); ?>

.admin-edit-bar {
    background:#000;
    color:#fff;
    padding:10px 0px;
}

.admin-edit-search-fix { top: 5px; position: relative; }
.admin-edit-search-input-fix { top: 2px; position: relative; margin-left: 4px; }

<?php
require APP_VENDORS . "froala/main/v2.9.3/min/froala_style.min.css";

$userRoleClass = $objLoggedInUser->Roles !== null ? ($objLoggedInUser->Roles->FindEntityByKey("user_class_type_id")->user_class_type_id ?? null) : null;

if (userIsCustomPlatform($userRoleClass)) {
    require APP_VENDORS . "jquery/ui/v1.12.1/min/jquery.ui.min.css";
}

?>
