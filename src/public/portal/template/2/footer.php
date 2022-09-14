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

<div class="DialogTransparentShield" style="display:none;" onclick="app.DisableAvatarMenu()"></div>
<div class="AvatarMenu" style="display:none;">
    <div class="AvatarMenuTriangle"></div>
    <div class="AvatarMenuInner">
        <ul class="AvatarMenuItemBlock">
            <li class="AvatarMenuItem EditIcon" onclick="app.EditMyAccount()">Edit My Profile</li>
            <li class="AvatarMenuItem PowerIcon" onclick="app.Logout()">Sign Out</li>
        </ul>
    </div>
</div>
<?php
    if ($this->VueApp !== null) { echo $this->Modal->renderHtmlTagInstance(); }
?>
</script>