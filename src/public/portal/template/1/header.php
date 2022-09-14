<?php
/** @var \App\Website\Website $this */

$objLoggedInUser = $this->app->GetActiveLoggedInUser();

$strWelcomeName = emp($objLoggedInUser->preferred_name, $objLoggedInUser->first_name);

$hideThis = "";
$portalLogoTitle = $this->app->objCustomPlatform->getPortalName();
$companyId = $this->app->objCustomPlatform->getCompanyId();

switch ($this->app->objCustomPlatform->getCompanyId())
{
    case 0:
        break;
    default:
        $hideThis = "display:none;";
        break;
}

?>
<navigation>
    <div class="bottomMenuBar showOnMobile">
        <ul>
            <li><a href="/account"><span class="fas fa-home"></span></a></li>
            <li><a href="/account/cards"><span class="fas fa-id-card"></span></a></li>
            <li><a href="/account/communication"><span class="fas fa-comments"></span></a></li>
            <li><a href="/account/modules"><span class="fas fa-th-large"></span></a></li>
            <li><img v-on:click="openMobileMenu()" class="main-user-avatar" src="<?php echo $objLoggedInUser->main_thumb; ?>" /></li>
        </ul>
    </div>
    <div class="site-logo hideOnMobile">
        <a href="/account" class="leftHeaderLogoLink">
            <span class="portalLogo"></span>
        </a>
    </div>
    <div class="nav-dashboard hideOnMobile">
        <div class="dropdown show">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-tachometer-alt fas-large desktop-35px" style="font-size: 24px;position: relative;top: 2px;"></span> <span>Dashboard</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>
    <div class="nav-wrapper hideOnMobile">
        <div class="nav-box">
            <div class="nav-box-card">
                <h5>MAIN</h5>
                <ul>
                    <li<?php userCanHideElement("view-my-queue"); ?>><a href="/account/tickets"><span class="fas fa-stopwatch desktop-20px"></span> <span>My Queue</span></a></li>
                    <li<?php userCanHideElement("view-my-card"); ?>><a href="/account/cards"><span class="fas fa-id-card desktop-20px"></span> <span>My Cards</span></a></li>
                    <li<?php userCanHideElement("view-my-apps"); ?>><a href="/account/modules"><span class="fas fa-th-large desktop-20px"></span> <span>My Modules</span></a></li>
                    <?php if ( $companyId === 4 ) { ?>
                        <li<?php userCanHideElement("view-my-apps"); ?>><a href="/account/marketplace-products"><span class="fas fa-cubes desktop-20px"></span> <span>My Products</span></a></li>
                    <?php } ?>
                    <li<?php userCanHideElement("view-my-communication"); ?>><a href="/account/communication"><span class="fas fa-envelope desktop-20px"></span> <span>Communication</span></a></li>
                    <li<?php userCanHideElement("view-my-contacts"); ?>><a href="/account/contacts"><span class="fas fa-address-book desktop-20px"></span> <span>My Contacts</span></a></li>
                    <li<?php userCanHideElement("view-marketplace"); ?>><a href="/account/marketplace"><span class="fas fa-shopping-basket desktop-20px"></span> <span>Marketplace</span></a></li>
                </ul>
            </div>
            <?php if (userCan("view-system")) { ?>
                <div class="nav-box-card">
                    <h5>ADMIN</h5>
                    <ul>
                        <li<?php userCanHideElement("view-admin-customers"); ?>><a href="/account/admin/customers"><span class="fas fa-users desktop-20px"></span> <span>Customers</span></a></li>
                        <li<?php userCanHideElement("view-admin-cards"); ?>><a href="/account/admin/cards"><span class="fas fa-list-alt desktop-20px"></span> <span>Cards</span></a></li>
                        <li<?php userCanHideElement("view-admin-apps"); ?>><a href="/account/admin/modules"><span class="fas fa-th-large desktop-20px"></span> <span>Modules</span></a></li>
                        <li<?php userCanHideElement("view-admin-notes"); ?>><a href="/account/admin/notes"><span class="fas fa-sticky-note desktop-20px"></span> <span>Notes</span></a></li>
                        <li<?php userCanHideElement("view-admin-tickets"); ?>><a href="/account/admin/tickets"><span class="fas fa-ticket-alt desktop-20px"></span> <span>Tickets</span></a></li>
                        <li<?php userCanHideElement("view-admin-packages"); ?>><a href="/account/admin/packages"><span class="fas fa-box-open desktop-20px"></span> <span>Packages</span></a></li>
                        <li<?php userCanHideElement("view-admin-packages"); ?>><a href="/account/admin/users"><span class="fas fa-user-shield desktop-20px"></span> <span>Users</span></a></li>
                        <li<?php userCanHideElement("view-admin-reports"); ?>><a href="/account/admin/reports"><span class="fas fa-chart-pie desktop-20px"></span> <span>Reports</span></a></li>
                    </ul>
                </div>
            <?php } ?>
            <?php if (userCan("manage-platforms")) { ?>
                <div class="nav-box-card">
                    <h5>SYSTEM</h5>
                    <ul>
                        <li<?php userCanHideElement("view-super-customers"); ?>><a href="/account/admin/users"><span class="fas fa-users desktop-20px"></span> <span>All Customers</span></a></li>
                        <li<?php userCanHideElement("view-super-users"); ?>><a href="/account/admin/users"><span class="fas fa-user-shield desktop-20px"></span> <span>All Users</span></a></li>
                        <li<?php userCanHideElement("view-super-cards"); ?>><a href="/account/admin/cards/all"><span class="fas fa-list-alt desktop-20px"></span> <span>All Cards</span></a></li>
                        <li<?php userCanHideElement("view-super-platforms"); ?>><a href="/account/admin/platforms"><span class="fas fa-cloud desktop-20px"></span> <span>Custom Platforms</span></a></li>
                        <li<?php userCanHideElement("view-super-reports"); ?>><a href="/account/admin/reports"><span class="fas fa-chart-pie desktop-20px"></span> <span>Reports</span></a></li>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</navigation>
<div class="portal-body">
    <header class="portal-header divTable">
        <div class="divRow">
            <div class="divCell">
                <?php echo $this->strPageBreadcrumb; ?>
            </div>
            <div class="site-logo divCell showOnMobile">
                <a href="/account" class="leftHeaderLogoLink">
                    <span class="portalLogo"></span>
                </a>
            </div>
            <div class="divCell right-float-menu-outer">
                <div class="right-float-menu">
                    <ul>
                        <li>English</li>
                        <li v-on:click="openSearch"><span class="fas fa-search pointer"></span></li>
                        <li v-on:click="openNotifications"><span class="far fa-bell pointer"></span></li>
                        <li v-on:click="openCart" ><span class="shoppingCartIcon pointer" style="position: relative;top: 3px;" /></li>
                    </ul>
                </div>
                <div class="desktop-account-access">
                    <ul v-on:click="accessProfile">
                        <li>{{ renderFullName(user) }}</li>
                        <li><img class="main-user-avatar" src="<?php echo $objLoggedInUser->main_thumb; ?>" /></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="portal-section">