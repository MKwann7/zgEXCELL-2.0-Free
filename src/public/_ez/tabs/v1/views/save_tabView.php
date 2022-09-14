<?php
/**
 * Created by PhpStorm.
 * User: micah
 * Date: 4/6/2019
 * Time: 10:07 AM
 */

?>

<div class="saveCard">
    <div class="saveCardButtons">
        <ul>
            <li class="pointer" style="background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <div class="saveCardTitle" id="saveCardTitleHomeScreen">To Your<br />Home Screen</div>
            </li>
            <li class="pointer" style="background-color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                <div class="saveCardTitle" id="saveCardTitleContacts">To Your<br />Contacts</div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="saveCardContent" id="saveCardContentHomeScreen">
        <ul>
            <li>
                <div class="saveCardTitle">To save this card to your home screen:

                    <?php if ($detect->isIphone()) {

                        //-----------------
                        //- iPhone section
                        //----------------- ?>

                        <ol>
                            <li>
                                Tap on the "Share" icon at the bottom of your screen.<br><br>
                                <img src="/_ez/tempaltes/1/images/addToHomeScreen001.jpg" alt=""/> <br>
                                <div class="smallPrint">(If you don't see the "Share" button scroll up or down a little, untill it appears.)</div>
                            </li>
                            <li>
                                Choose "Add to Home Screen<br><br>
                                <img src="/_ez/tempaltes/1/images/addToHomeScreen002.jpg" alt=""/>
                            </li>
                        </ol>

                    <?php } else if ($detect->isMobile()) {

                        //-------------------------
                        //- Detected mobile device
                        //------------------------- ?>

                        <ol>
                            <li>Press the menu key or “Settings” button...</li>
                            <li>on the list of options, press “More”...</li>
                            <li>select <strong>“Add shortcut to home screen”</strong></li>
                        </ol>

                    <?php } else {

                        //-----------------------------
                        //- Detected non-mobile device
                        //-----------------------------  ?>

                        This function is for mobile devices only.

                    <?php } ?>

                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <?php
    //---------------------------------------------- ?>

    <div class="saveCardContent" id="saveCardContentContacts">
        <ul>
            <li>
                <div class="saveCardTitle">To save this card to your contacts:

                    <?php if($detect->isIphone()) {
                        //------------------
                        //- Detected iPhone
                        //------------------ ?>

                        <ol>
                            <li>
                                Tap on the phone icon below.
                                <a href="/api/v1/cards/download-vcard?card_id=<?php echo $objCard->card_id; ?>"
                                   style="color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>">
                                    <div class="phoneIcon"><i class="fa fa-mobile-phone"></i></div>
                                </a>
                            </li>
                            <li>
                                <b>iPhone</b>: Go to Contacts and Open.<br><br>
                                <b>Android</b>: After download, tap "Open," and select which contact list you want it in.
                            </li>
                        </ol>

                    <?php } else {
                        //-----------------------------
                        //- Detected non-iPhone device
                        //----------------------------- ?>

                        <ol>
                            <li>
                                Tap on the phone icon below.
                                <a href="/api/v1/cards/download-vcard?card_id=<?php echo $objCard->card_id; ?>"
                                   style="color: #<?php echo $objCard->card_data->style->card->color->main ?? "FF0000"; ?>" target="_blank">
                                    <div class="phoneIcon"><i class="fa fa-mobile-phone"></i></div>
                                </a>
                            </li>
                            <li>
                                <b style="font-weight:bold;">iPhone</b>: Go to Contacts and Open.<br><br>
                                <b style="font-weight:bold;">Android</b>: After download, tap "Open," and select which Contact List you want it in.
                            </li>
                        </ol>

                    <?php } ?>

                </div>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>

<script type="text/javascript">
    // Save Tab
    $('#saveCardTitleHomeScreen').click(function(){
        $('#saveCardContentHomeScreen').toggle(300);
        $('#saveCardContentContacts').hide(300);
    });
    $('#saveCardTitleContacts').click(function(e){
        $('#saveCardContentHomeScreen').hide(300);
        $('#saveCardContentContacts').toggle(300);
    });
</script>