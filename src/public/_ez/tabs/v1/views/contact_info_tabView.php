<div class="heading1" style="color: black;">
<?php

echo $objCard->Owner->first_name . " " . $objCard->Owner->last_name; ?></div>
<div class="spacer3vw"><br></div>
<?php if (!empty($objCard->Owner->Business)) { ?>
<div class="heading1" style="color: black;"><?php echo $objCard->Owner->Business->business_name; ?></div>
<?php } ?>
<div class="paragraphText"><?php echo $strUserAddress; ?></div>
<div class="spacer3vw"><br></div>
<div class="heading3" style="color: black;">Mobile Phone: <?php echo formatAsPhoneIfApplicable($objCard->Owner->user_phone ?? ""); ?></div>
<div class="heading3" style="color: black;">Email: <?php echo $objCard->Owner->user_email ?? ""; ?></div>
<?php if (!empty($objCard->Connections)) { ?>
<div class="heading3" style="color: black;">Website: <?php  echo !empty($objCard->Connections) ? $objCard->Connections->FindEntityByValue("connection_type_id","Website")->connection_value : ""; ?></div>
<?php } ?>
