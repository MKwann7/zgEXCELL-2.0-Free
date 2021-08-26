<?php

$strViewSaveCardForAndroid = "viewSaveCardForAndroid_" . rand(1000,9999);
$strViewSaveCardForIphone = "viewSaveCardForIphone_" . rand(1000,9999);
$strEmailShareId = "emailCard_" . rand(1000,9999);

$intMainColor = $objCard->card_data->style->card->color->main ?? "000000";

$cardTitle = "Card";
$shareLabel = "Share";

if ($this->app->objCustomPlatform->getCompanyId() === 0)
{
    $cardTitle = "EZcard";
}
else
{

}

?>
<h3 style=" border-box;background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(0, 0, 0);font-family: AvenirLTStd;font-size: 24px;font-style: normal;font-variant: normal;font-weight: 400;letter-spacing: normal;line-height: 33.6px;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;orphans: 2;text-align: center;text-decoration: none;text-indent: 0px;text-transform: none;-webkit-text-stroke-width: 0px;white-space: normal;word-spacing: 0px;"><span style="font-family: Arial,Helvetica,sans-serif;">Share This <?php echo $cardTitle; ?> <i id="learnMoreAboutShareSave" style="position:relative;top:2px;" class="fa fa-question-circle"></i></span></h3>
<div id="learnMoreAboutShareSave_box" style="display:none;margin-bottom:25px;padding-left: 5px;">
    <p>Ready to connect with others?</p>
    <ol>
        <li><b style="font-weight:bold;">Infini-Track:</b> Lets <?php echo strtolower($cardTitle); ?> owner stay in touch with everyone the card is shared with, permission-based.</li>
        <li><b style="font-weight:bold;">Direct Text:</b> Sends to someone in your phone's Contact Manager, or directly by phone number.</li>
        <li><b style="font-weight:bold;">Email:</b> Sends by email, with a customizable message.</li>
        <?php if (empty($objCardPageRel->card_tab_rel_data->Properties->ShowQrCode) || (!empty($objCardPageRel->card_tab_rel_data->Properties->ShowQrCode) && $objCardPageRel->card_tab_rel_data->Properties->ShowQrCode == "True") ) { ?>
        <li><b style="font-weight:bold;">QR Code:</b> Scan QR Code and display <?php echo strtolower($cardTitle); ?>.</li>
        <?php } ?>
    </ol>
</div>
<div style="white-space: nowrap; text-align:center; margin-bottom:15px;">
    <?php if (!empty($objCard->card_keyword)) { ?>
        <a href="https://optin.mobiniti.com/<?php echo $objCard->card_num; ?>" style="margin-right:3px; margin-top:3px; display: inline-block;"><button class="btn btn-primary main-card-color-background" style="font-size:11px;width:65px;height:46px;"><?php echo strtoupper($shareLabel); ?></button></a>
    <?php } ?>
    <?php if($detect->isIphone()) { ?>
        <a name="sms-link" id="sms-link" href="sms:&body=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>%20Let's%20connect%20with%20<?php echo $cardTitle; ?>!" style="margin-right:3px; margin-top:3px; display: inline-block;"><button class="btn btn-secondary" style="font-size:11px;width:65px;height:46px;">DIRECT<br>TEXT</button></a>
    <?php } else { ?>
        <a name="sms-link" id="sms-link" href="sms:?body=<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>%20Let's%20connect%20with%20<?php echo $cardTitle; ?>!" style="margin-right:3px; margin-top:3px; display: inline-block;"><button class="btn btn-secondary" style="font-size:11px;width:65px;height:46px;">DIRECT<br>TEXT</button></a>
    <?php } ?>
    <?php if($detect->isMobile()) { ?>
        <a style="margin-top:3px; margin-right:3px; display: inline-block;" href="mailto:?cc=&subject=%20's%20Information&body=Let's%20connect%20with%20<?php echo $cardTitle; ?>!%20%20https%3A//ezcard.com/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>" ><button class="btn btn-secondary" style="font-size:13px;width:65px;height:46px;">EMAIL</button></a>
    <?php } else { ?>
        <a id="shareCardTitleEmailLink" style="margin-top:3px; margin-right:3px; display: inline-block;"><button class="btn btn-secondary" style="font-size:13px;width:65px;height:46px;">EMAIL</button></a>
    <?php } ?>
    <?php if (empty($objCardPageRel->card_tab_rel_data->Properties->ShowQrCode) || (!empty($objCardPageRel->card_tab_rel_data->Properties->ShowQrCode) && $objCardPageRel->card_tab_rel_data->Properties->ShowQrCode == "True") ) { ?>
    <a id="shareCardQrLink" style="margin-top:3px; display: inline-block;"><button class="btn btn-secondary" style="font-size:13px;width:65px;height:46px;">QR</button></a>
    <?php } ?>
</div>

<div style="display:none;margin-bottom:15px;" class="emailCardDesktop" id="shareCardContentEmail">
    <p>Enter an email address and optional message below and click "Send"</p>
    <form id="<?php echo $strEmailShareId; ?>" name="emailCard" method="post" action="/cards/card-data/email-card-to-address">
        <input class="form-control" name="email" type="email" id="email" value=""><br>
        <textarea class="form-control" name="msg" id="msg" cols="32" rows="2" maxlength="64" placeholder="Optional message."></textarea><br>
        <input name="card_id" type="hidden" id="card_id" value="<?php echo $objCard->card_id; ?>">
        <input class="btn submitSendEmail" type="submit" name="submitSendEmail" id="submitSendEmail"value="Send" style="width:100%;background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
    </form>
</div>

<div style="display:none;" id="shareCardContentEmailSuccess">
    <h5 style="text-align: center;">SUCCESS!</h5>
    <p>We've emailed <span id="<?php echo $strEmailShareId; ?>_email"></span><br>a link to this <?php echo $cardTitle; ?>!</p>
</div>

<div id="shareCardQrLink_box" style="display:none;text-align:center;<?php if (!empty($objCard->card_keyword) && stripos($objCard->card_keyword,"ezhide") === false) { ?>margin-bottom: -20px;<?php } ?>">
    <img src="<?php echo getFullUrl(); ?>/api/v1/cards/generate-qr-code-for-card?id=<?php echo $objCard->card_num; ?>" alt="qr code" width="450" height="450" style="border:none;width:100%;height:auto;" />
</div>

<?php if (!empty($objCard->card_keyword) && stripos($objCard->card_keyword,"ezhide") === false) { ?>
<h5 style="background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(0, 0, 0);font-family: AvenirLTStd;font-size: 20px;font-style: normal;font-variant: normal;font-weight: 400;letter-spacing: normal;line-height: 24px;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 25px;orphans: 2;text-align: center;text-decoration: none;text-indent: 0px;text-transform: none;-webkit-text-stroke-width: 0px;white-space: normal;word-spacing: 0px;"><span style="background-color: transparent; background-image: none; background-origin: padding-box; background-position: 0% 0%; background-repeat: repeat; background-size: auto; box-sizing: border-box; color: rgb(0, 0, 0); font-size: 30px;"><span style="font-family: Arial, Helvetica, sans-serif;">Text <span style="border-box;background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(255, 0, 0);"><?php echo strtoupper($objCard->card_keyword ?? "[Keyword]"); ?>&nbsp;</span>to&nbsp;</span><strong style=" border-box;background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(0, 0, 0);font-weight: 700;"><span style="background-color: transparent; background-image: none; background-origin: padding-box; background-position: 0% 0%; background-repeat: repeat; background-size: auto; box-sizing: border-box; color: rgb(0, 127, 222); font-family: Arial, Helvetica, sans-serif;">64600</span></strong></span></h5>
<span style="display:block;margin:5px 15px 15px;text-align:center;font-size: 14px; font-family: Arial, Helvetica, sans-serif;">To Share with a Group or on Social Media.</span>
<?php } ?>

<h3 style="border-box;background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(0, 0, 0);font-family: AvenirLTStd;font-size: 24px;font-style: normal;font-variant: normal;font-weight: 400;letter-spacing: normal;line-height: 33.6px;margin-bottom: 0px;margin-left: 0px;margin-right: 0px;margin-top: 0px;orphans: 2;text-align: center;text-decoration: none;text-indent: 0px;text-transform: none;-webkit-text-stroke-width: 0px;white-space: normal;word-spacing: 0px;"><span style="font-family: Arial,Helvetica,sans-serif;">Save to Your Phone</span></h3>

<p style="border-box;background-color: transparent;background-image: none;background-origin: padding-box;background-position-x: 0%;background-position-y: 0%;background-repeat: repeat;background-size: auto;box-sizing: border-box;color: rgb(0, 0, 0);font-family: AvenirLTStd;font-size: 14px;font-style: normal;font-variant: normal;font-weight: 400;letter-spacing: normal;margin-bottom: 16px;margin-top: 0px;orphans: 2;text-align: center;text-decoration: none;text-indent: 0px;text-transform: none;-webkit-text-stroke-width: 0px;white-space: normal;word-spacing: 0px;">
    <a id="<?php echo $strViewSaveCardForAndroid; ?>" style="margin-right:3px; margin-top:3px; display: none;"><button class="btn btn-secondary" style="font-size:11px;width:85px;height:46px;">ANDROID</button></a>
    <a id="<?php echo $strViewSaveCardForIphone; ?>" style="margin-right:3px; margin-top:3px; display: none;"><button class="btn btn-secondary" style="font-size:11px;width:85px;height:46px;">IPHONE</button></a>
    <a href="/api/v1/cards/download-vcard?card_id=<?php echo $objCard->card_num; ?>" style="margin-top:3px; display: inline-block;"><button class="btn btn-secondary" style="font-size:11px;width:85px;height:46px;">CONTACTS</button></a></a></p>
<div id="<?php echo $strViewSaveCardForAndroid; ?>_box" style="display:none;">
    <h2 style="text-align:center;">Video for Android</h2>
    <div style="text-align:center;">Learn how to save to your phone.</div>
    <h2 id="#android" style="text-align: center;"><iframe src="//player.vimeo.com/video/311991935?title=0&amp;byline=0" width="250" height="600" allowfullscreen="allowfullscreen"></iframe> </h2>
    <p style="text-align: center;"><a href="<?php echo getFullUrl(); ?>/<?php echo $objCard->card_num; ?>"><img src="<?php echo getFullUrl(); ?>/uploads/tinyMCEUploads/Picture159.png" width="102" height="51"></a> </p>
</div>
<div id="<?php echo $strViewSaveCardForIphone; ?>_box" style="display:none;">
    <h2 style="text-align:center;">Video for iPhone</h2>
    <div style="text-align:center;">Learn how to save to your phone.</div>
<h2 id="#iphone" style="text-align: center;"> <iframe src="//player.vimeo.com/video/315579201?title=0&amp;byline=0" width="250" height="600" allowfullscreen="allowfullscreen"></iframe></h2>
<p><a href="<?php echo getFullUrl(); ?>/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>"><img style="display: block; margin-left: auto; margin-right: auto;" src="https://ezcard.com/uploads/tinyMCEUploads/Picture160.png" width="102" height="51"></a></p>
</div>

<style>
    .main-card-color {
        color: #<?php echo $intMainColor; ?>;
    }
    .main-card-color-background {
        background-color: #<?php echo $intMainColor; ?>;
        border-color: #<?php echo $intMainColor; ?>;
    }
    #learnMoreAboutShareSave_box p,
    #learnMoreAboutShareSave_box li {
        font-size:13px;
    }

    #learnMoreAboutShareSave_box li {
        margin-bottom:10px;
    }
</style>

<script type="text/javascript">

    $('#<?php echo $strViewSaveCardForAndroid; ?>').click(function(){
        //$('#<?php echo $strViewSaveCardForAndroid; ?>_box').toggle(300);
        //$('#shareCardQrLink_box').hide(300);
        //$('#<?php echo $strViewSaveCardForIphone; ?>_box').hide(300);
    });

    $('#<?php echo $strViewSaveCardForIphone; ?>').click(function(e){
        //$('#<?php echo $strViewSaveCardForAndroid; ?>_box').hide(300);
        //$('#shareCardQrLink_box').hide(300);
        //$('#<?php echo $strViewSaveCardForIphone; ?>_box').toggle(300);
    });

    $('#shareCardQrLink').click(function(e){
        $('#<?php echo $strViewSaveCardForAndroid; ?>_box').hide(300);
        $('#<?php echo $strViewSaveCardForIphone; ?>_box').hide(300);
        $('#shareCardQrLink_box').toggle(300);
    });

    $('#shareCardTitleEmailLink').click(function(e){
        $('#shareCardContentEmail').toggle(300);
    });

    $('#learnMoreAboutShareSave').click(function(e){
        $('#learnMoreAboutShareSave_box').toggle(300);
    });

    app.Form("<?php echo $strEmailShareId; ?>" ,function() {
        modal.EngageFloatShield();
    },function(objResult) {
        setTimeout(function() {
            modal.CloseFloatShield(function() {
                $('#shareCardContentEmail').toggle(300);
                $('#<?php echo $strEmailShareId; ?>_email').text($("#<?php echo $strEmailShareId; ?> #email").val());
                $('#shareCardContentEmailSuccess').toggle(300);
                setTimeout(function() {
                    $("#<?php echo $strEmailShareId; ?> #email").val('');
                    $("#<?php echo $strEmailShareId; ?> #msg").val('');
                    $('#shareCardContentEmailSuccess').toggle(300);
                },2000)
            }, 250);
        }, 1000);
    },function(objValidate) {

        if ($("#<?php echo $strEmailShareId; ?> #email").val() == "")
        {
            $("#<?php echo $strEmailShareId; ?> #email").addClass("error-validation").blur(function() {
                $(this).removeClass("error-validation");
            });
            return false;
        }

        return true;
    });
</script>