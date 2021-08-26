<?php
/** @var \App\Website\Website $this */

$objLoggedInUser = $this->app->getActiveLoggedInUser();

$strWelcomeName = emp($objLoggedInUser->preferred_name, $objLoggedInUser->first_name);

$cardTitle = "Card";
$hideThis = "";
$portalLogoTitle = $this->app->objCustomPlatform->getPortalName();

$portalLogo = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_logo_light")->value ?? "/website/logos/logo-light.png";

switch ($this->app->objCustomPlatform->getCompanyId())
{
    case 0:
        $cardTitle = "EZcard";
        break;
}

$userSuperAdminRole = false;

if (!userCan("manage-platforms"))
{
    $userSuperAdminRole = true;
    $hideThis = "display:none;";
}

?>

<?php require __DIR__ . "/mobile.nav.php"; ?>

<header class="siteHeader-wrapper">
    <div class="siteHeader">
        <div class="leftHeader">
            <div class="leftHeaderInner">
                <a href="/account" class="leftHeaderLogoLink">
                    <img id="ezcard-logo" src="<?php echo $portalLogo; ?>" alt="<?php echo $portalLogoTitle; ?> Logo" width="70" height="65"/>
                </a>
            </div>
        </div>
        <div class="rightHeader">
            <nav class="headerMenuDiv">
                <div class="headerMenuTd"<?php userCanHideElement("manage-my-ezcards"); ?>>
                    <ul class="menu">
                        <li>
                            <a class="menuDropdownLink"><span class="fas fa-id-card"></span> My <?php echo $cardTitle; ?>s</a>
                            <ul>
                                <li<?php userCanHideElement("view-my-card"); ?>><a href="/account/cards"><span class="fas fa-list-alt desktop-20px"></span> LIST My Cards</a></li>
                                <li<?php userCanHideElement("view-image-library"); ?>><a href="/account/cards/image-library"><span class="fas fa-images desktop-20px"></span> Image Library</a></li>
                                <li<?php userCanHideElement("view-image-library"); ?>><a href="/account/cards/widget-library"><span class="fas fa-th-large desktop-20px"></span> Widget Library</a></li>
                                <li<?php userCanHideElement("view-ezcard-help"); ?>><a style="opacity:.4;" href="/account/cards/help"><span class="fas fa-question-circle desktop-20px"></span> HELP</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <div class="headerMenuTd"<?php userCanHideElement("manage-system"); ?>>
                    <ul class="menu">
                        <li>
                            <a class="menuDropdownLink"><span class="fas fa-cogs"></span> System</a>
                            <ul>
                                <li>
                                    <a href="/account/admin/cards"><span class="fas fa-list-alt desktop-20px"></span> Cards</a>
                                    <ul>
                                        <li><a href="/account/admin/cards/widget-library">Widget Library</a></li>
                                        <li style="display: none;"><a href="/account/admin/cards/image-library">Card Image Library</a></li>
                                        <li style="display: none;"><a href="/account/admin/cards/card-groups">Card Groups</a></li>
                                        <li style="display: none;"><a href="/account/admin/cards/card-user-relationship-types">Card User Relationship Types</a></li>
                                        <li style="display: none;"><a href="/account/admin/cards/card-templates">Card Templates</a></li>
                                        <li style="display: none;"><a href="/account/admin/cards/card-types">Card Types</a></li>
                                    </ul>
                                </li>
                                <li style="<?php echo $hideThis; ?>"><a href="/account/admin/cards/old"><span class="fas fa-list-alt desktop-20px"></span> Cards Old</a></li>
                                <li>
                                    <a href="/account/admin/customers"><span class="fas fa-male"></span><span class="fas fa-female" style="position:relative;left:-3px;"></span>Customers</a>
                                    <ul>
                                        <li><a href="/account/admin/members">Members</a></li>
                                    </ul>
                                </li>
                                <li style="<?php echo $hideThis; ?>"><a href="/account/admin/customers/old"><span class="fas fa-list-alt desktop-20px"></span> Customers Old</a></li>
                                <li style="display:none;">
                                    <a href="/account/admin/contacts">Contacts</a>
                                    <ul style="display: none;">
                                        <li><a href="/account/admin/contacts/groups">Members</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="/account/admin/packages"><span class="fas fa-box-open desktop-20px"></span> Packages</a>
                                    <ul style="display: none;">
                                        <li ><a href="/account/admin/packages-old">Old Packages</a></li>
                                    </ul>
                                </li>
                                <li><a href="/account/admin/users"><span class="fas fa-users desktop-20px"></span> Users</a></li>
                                <li><a href="/account/admin/reports"><span class="fas fa-chart-pie desktop-20px"></span> Reports</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="headerMenuTd"<?php userCanHideElement("manage-platforms"); ?>>
                    <ul class="menu">
                        <li>
                            <a class="menuDropdownLink"><span class="fas fa-user-shield"></span> Admin</a>
                            <ul>
                                <li>
                                    <a href="/account/admin/platforms"><span class="fas fa-cloud desktop-20px"></span> Custom Platforms</a>
                                    <ul>
                                        <li><a href="/account/admin/stripe-accounts">Stripe Accounts</a></li>
                                    </ul>
                                </li>
                                <li><a href="/account/admin/products"><span class="fas fa-box-open desktop-20px"></span> Products</a></li>
                                <li><a href="/account/admin/tasks"><span class="fas fa-cog desktop-20px"></span> Tasks</a></li>
                                <li><a href="/account/admin/reports"><span class="fas fa-chart-pie desktop-20px"></span> Reports</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        </div>
        <div class="floatRightHeader">
            <label>Welcome, <?php echo $strWelcomeName; ?></label>
            <span class="floatRightHeaderAvatarLink excell-mobile-menu">
                <?php
                if (!empty($objLoggedInUser->main_thumb))
                {
                ?>
                    <img class="main-user-avatar" src="<?php echo $objLoggedInUser->main_thumb; ?>" />
                <?php
                }
                ?>
                <input type="hidden" id="logged-in-user-id" value="<?php echo $objLoggedInUser->user_id; ?>" />
            </span>
        </div>
    </div>
</header>
