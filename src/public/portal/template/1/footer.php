<?php

use App\Utilities\Debug\QueryTracker;
use App\Website\Website;

/** @var Website $this */


if (env("APP_ENV") !== "production") { ?>
<footer>
    <div class="excell_debugbar">
        <div class="excell_debugbar-resize-handle"></div>
        <div class="excell_debugbar-body">
            <div class="excell_debugbar-tabbody">

            </div>
            <div class="excell_debugbar-tabbody-el excell_debugbar-tabbody-Queries" style="display:none;">
                    <div style="max-height:150px;overflow-y: auto;">
                        <table class="table table-striped entityList">
                            <?php foreach (App\Utilities\Database::getQueries() as $query) {
                                /** @var QueryTracker $query */ ?>
                                <tr><td><?php echo $query->getSeconds(); ?>s</td><td><?php echo $query->getQuery(); ?></td></tr>
                            <?php } ?>
                        </table>
                    </div>
            </div>
        </div>
        <div class="excell_debugbar-header">
            <div class="excell_debugbar-header-left">
                <a class="excell_debugbar-tab">
                    <span class="excell_debugbar-text" onclick="$('.excell_debugbar-tabbody-el').hide();$('.excell_debugbar-tabbody-Queries').show();">Queries</span>
                    <span class="excell_debugbar-badge" style="display: inline;"><?php echo count(App\Utilities\Database::getQueries()); ?></span>
                </a>
            </div>
        </div>
    </div>
</footer>
<?php } ?>

</dev>
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