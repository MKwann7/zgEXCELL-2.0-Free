<?php

$strEmailShareId = "emailCard_" . rand(1000,9999);

$cardTitle = "Card";

if ($this->app->objCustomPlatform->getCompanyId() === 0)
{
    $cardTitle = "EZcard";
}

?>
<div class="shareCard">
    <textarea style="margin-bottom:15px;" class="form-control" name="msg" id="msg" cols="32" rows="2" maxlength="64" placeholder="Sending a text message?  Enter an extra comment here."></textarea>
    <div class="shareCardButtons">
        <ul>

            <li style="background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <?php
                if($detect->isIphone()) { ?>
                    <a name="sms-link" id="sms-link" href="sms:&body=<?php echo getFullUrl(); ?>/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>%20Check%20out%20my%20<?php echo $cardTitle; ?>!">
                <?php } else { ?>
                    <a name="sms-link" id="sms-link" href="sms:?body=<?php echo getFullUrl(); ?>/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>%20Check%20out%20my%20<?php echo $cardTitle; ?>!">
                <?php } ?>

                        <div class="shareCardTitle" id="shareCardTitleSMS">Text</div>
                    </a>
            </li>

            <li class="wa_btn_outer" style="display:none; background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <?php
                if($detect->isIphone()) {
                    // TODO - Pull out of code -- add to database.
                    ?>
                <a href="whatsapp://send" data-text="Let's connect wtih <?php echo $cardTitle; ?>!" data-href="<?php echo getFullUrl(); ?>/<?php echo(!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>" class="wa_btn wa_btn_s" style="display:none;">
                    <?php } else { ?>
                    <a href="whatsapp://send" data-text="Let's connect with <?php echo $cardTitle; ?>!" data-href="<?php echo getFullUrl(); ?>/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>" class="wa_btn wa_btn_s" style="display:none;">
                        <?php } ?>

                        <div class="shareCardTitle" id="shareCardTitleSMS">WhatsApp</div>
                    </a>
            </li>

            <li id="shareCardTitleEmailLink" style="background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <div class="shareCardTitle" id="shareCardTitleEmail">Email</div>
            </li>

            <li style="background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <div class="shareCardTitle" id="shareCardTitleQRCode">QR Code</div>
            </li>

        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="shareCardContent" id="shareCardContentEmail">
        <p>Enter an email address and optional message below and click "Send"</p>
        <form id="<?php echo $strEmailShareId; ?>" name="emailCard" method="post" action="/cards/card-data/email-card-to-address">
            <input class="form-control" name="email" type="email" id="email" value=""><br>
            <textarea class="form-control" name="msg" id="msg" cols="32" rows="2" maxlength="64" placeholder="Optional message."></textarea><br>
            <input name="card_id" type="hidden" id="card_id" value="<?php echo $objCard->card_id; ?>">
            <input class="btn submitSendEmail" type="submit" name="submitSendEmail" id="submitSendEmail" value="Send" style="width:100%;background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
        </form>
    </div>
    <div class="shareCardContent" id="shareCardContentQRCode">
        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo getFullUrl(); ?>/<?php echo (!empty($objCard->card_vanity_url) ? $objCard->card_vanity_url : $objCard->card_num); ?>" title="Link to <?php echo $objCard->Owner->first_name; ?>'s Profile.com" />
    </div>
</div>
<script type="text/javascript">

    // Share Tab
    $('#shareCardTitleSMS').parent("li").click(function(){
        $('#shareCardContentEmail').hide(300);
        $('#shareCardContentQRCode').hide(300);
        var _msg = $("#msg").val();
        if ( _msg != '' ) {
            var _href = $("#sms-link").attr("href");
            $("#sms-link").attr("href", _href + "%0A" + _msg);
        }
    });

    $('#shareCardTitleEmailLink').click(function(e){
        <?php if ($detect->isMobile()) { ?>
        e.preventDefault();
        var intCardId = $("#cardId").val();
        if ( intCardId != '' ) {
            window.location.href = "mailto:?subject=Check%20out%20my%20<?php echo strtolower($cardTitle); ?>!&body=Hey!%0D%0A%0D%0A%20You're%20going%20love%20this: <?php echo App::$objCoreData["Website"]["FullUrl"]; ?>/<?php echo $objCard->card_num; ?>%0D%0A%0D%0A";
                    }
                    <?php } else { ?>
        $('#shareCardContentQRCode').hide(300);
        $('#shareCardContentEmail').toggle(300);
        <?php } ?>
    });

    $('#shareCardTitleQRCode').parent("li").click(function(){
        $('#shareCardContentEmail').hide(300);
        $('#shareCardContentQRCode').toggle(300);
    });

    app.Form("<?php echo $strEmailShareId; ?>" ,function() {
        modal.EngageFloatShield();
    },function() {
        modal.CloseFloatShield();
    },function() {
        console.log("tes");
        if ($("#<?php echo $strEmailShareId; ?> #email").val() == "")
        {
            console.log("fail");
            $("#<?php echo $strEmailShareId; ?> #email").addClass("error-validation").blur(function() {
                $(this).removeClass("error-validation");
            });
            return false;
        }
    });

</script>
<style>
    <?php echo $strEmailShareId; ?> .error-validation {
        border:2px solid #ff0000 !important;
        box-shadow: #ff0000 0 0 5px !important;
    }
</style>