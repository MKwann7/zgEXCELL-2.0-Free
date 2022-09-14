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
            <button class="btn btn-primary dropdown-toggle quick-actions" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fas fa-stopwatch fas-large desktop-30px" style="font-size: 24px;position: relative;top: 3px;"></span> <span class="quick-action-title">Quick Actions</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <a class="dropdown-item" href="#">Something else here</a>
            </div>
        </div>
    </div>
    <div class="nav-wrapper hideOnMobile">
        <div v-cloak class="nav-box">
            <div v-show="menuPin && menuPin.length > 0" class="nav-box-card nav-box-favorites">
                <h5>
                    <span class="fa fa-heart desktop-30px"></span>
                    FAVORITES
                </h5>
                <ul>
                    <li v-for="currItem in menuPin">
                        <a v-bind:href="currItem.url"><span v-bind:class="currItem.icon"></span> <span>{{ currItem.title }}</span></a>
                        <span class="pinnedMenuItem pin-item fa fa-thumbtack pointer" v-on:click="unPinMainMenu(currItem)"></span>
                    </li>
                </ul>
            </div>
            <div v-for="currMenu in menuItems" class="nav-box-card">
                <h5 v-on:click="toggleMainMenu(currMenu.name)" class="pointer" v-bind:class="{pinnedMenuItemOuter: menuDisplay === currMenu.name }">
                    <span v-bind:class="currMenu.icon"></span>
                    {{ currMenu.title }}
                    <span class="pin-item fa fa-caret-left"></span>
                </h5>
                <ul v-show="menuDisplay === currMenu.name">
                    <li v-for="currMenuLink in currMenu.items" v-bind:class="{pinnedMenuItemInner: includesMenuLink(currMenuLink) == true}">
                        <a v-bind:href="currMenuLink.url"><span v-bind:class="currMenuLink.icon"></span> <span>{{ currMenuLink.title }}</span></a>
                        <span v-bind:class="{pinnedMenuItem: includesMenuLink(currMenuLink) == true}" class="pin-item fa fa-thumbtack pointer" v-on:click="pinMainMenu(currMenuLink)"></span>
                    </li>
                </ul>
            </div>
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
                        <li v-on:click="openSearch" style="display: none;"><span class="fas fa-search pointer"></span></li>
                        <li v-on:click="openNotificationsModal"><span class="far fa-bell pointer"></span></li>
                        <li v-on:click="openCart"><span class="fa fa-shopping-cart pointer"></span><span v-show="cartQuantity > 0" class="cartQuantityCount">{{ cartQuantity }}</span></li>
                    </ul>
                </div>
                <div class="desktop-account-access">
                    <ul v-on:click="accessProfileModal">
                        <li>{{ renderFullName(user) }}</li>
                        <li class="pointer"><img class="main-user-avatar" src="<?php echo $objLoggedInUser->main_thumb; ?>" /></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <div class="portal-section">
