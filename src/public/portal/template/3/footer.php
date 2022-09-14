<?php

use App\Utilities\Debug\QueryTracker;
use App\Website\Website;

/** @var Website $this */

?>

</div>
</div>
<div class="DialogTransparentShield" style="display:none;" onclick="app.disableFloats()"></div>
<div class="AvatarMenu" style="display:none;">
    <div class="AvatarMenuTriangle"></div>
    <div class="AvatarMenuInner">
        <ul class="AvatarMenuItemBlock">
            <li class="AvatarMenuItem" onclick="app.EditMyAccount()"><span class="fas fa-pen"></span><span>My Profile</span></li>
            <li class="AvatarMenuItem" onclick="app.EditMySettings()"><span class="fas fa-cogs"></span><span>Settings</span></li>
            <li class="AvatarMenuItem" onclick="app.Logout()"><span class="fas fa-power-off"></span><span>Sign Out</span></li>
        </ul>
    </div>
</div>
<div class="NotificationModal" style="display:none;">
    <div class="AvatarMenuTriangle"></div>
    <div class="AvatarMenuInner">
        <div class="NotificationModalInner">
            <div class="NotificationModalTitle"><span class="fas fa-exclamation-triangle"></span> Alerts</div>
            <ul>
                <li>Item 1</li>
                <li>Item 2</li>
                <li>Item 3</li>
                <li>Item 4</li>
                <li>Item 5</li>
                <li>Item 6</li>
                <li>Item 7</li>
            </ul>
        </div>
    </div>
</div>
<?php
    if ($this->VueApp !== null) { echo $this->Modal->renderHtmlTagInstance(); }
?>
</script>