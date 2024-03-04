<?php

$portalLogoDark = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_logo_dark")->value ?? "/website/logos/logo-dark.svg";
$portalLogoLight = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_logo_light")->value ?? "/website/logos/logo-light.svg";
$portalThemeMainColor = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_theme_main_color")->value ?? "006666";
$portalThemeMainColorLight = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_theme_main_color_light")->value ?? "009c9c";

?>
#arc-menu { display:none !important; }
@import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');

/** -------------Navigation--------------- **/
navigation {
    position:fixed;
    left:0;
    top:0;
    height:100%;
    width: 250px;
    padding:12px;
    z-index:5;
    box-shadow: rgba(0,0,0,.3) 0 5px 10px;
    overflow-y:auto;
}
body {
    overflow:hidden;
}
.mont {
    font-family: 'Montserrat', sans-serif;
}
.fas span {
    font-family: 'Montserrat', sans-serif;
    font-weight: normal;
}
ul {
    margin:0; padding:0;
}
ul li {
    list-style-type:none;
}
.dashboard-tab-display .fas span {
    font-size: 12px;
    top: -2px;
    position: relative;
    margin-left: 5px;
}
.entityDetailsInner table {
    width:100%;
}
.entityDetailsInner:not(.sortableDetails):not(.entityListActionColumn) table > tr > td:last-child,
.entityDetailsInner:not(.sortableDetails):not(.entityListActionColumn) table > tbody > tr > td:last-child {
    max-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
}
.entityDetailsInner.entityListActionColumn table > tr > td:nth-last-child(2),
.entityDetailsInner.entityListActionColumn table > tbody > tr > td:nth-last-child(2) {
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.theme_shade_dark navigation {
    background-color: #0c1515;
}
.theme_shade_light navigation {
    background-color: #fff;
}
.portalLogo {
    width: 70px;
    height: 65px;
    display:inline-block;
}
.theme_shade_dark .portalLogo {
    background: url(<?php echo $portalLogoDark; ?>) no-repeat center center / 100% auto;
}
.theme_shade_light .portalLogo {
    background: url(<?php echo $portalLogoLight; ?>) no-repeat center center / 100% auto;
}
.site-logo {
    text-align: center;
}
.site-logo > a {
    display: inline-block;
}
.nav-box-card > h5 {
    font-family: 'Montserrat', sans-serif;
    font-size:12px;
    margin-top:35px;
    position: relative;
}
.nav-box-card > h5.pinnedMenuItemOuter .fa-caret-right:before {
    content: "\f0d7";
}
.nav-box-card > h5 .pin-item {
    position:absolute;
    top:1px;
    right:5px;
    visibility: hidden;
}
.nav-box-card > h5:hover .pin-item {
    font-family: "Font Awesome 5 Free";
    content: "\f08d";
    visibility: visible;
    color:#cacaca;
}
.nav-box-card > h5:hover .pin-item {
    font-family: "Font Awesome 5 Free";
    content: "\f08d";
    visibility: visible;
    color:#cacaca;
}
.nav-box-card > h5 .pin-item.pinnedMenuItem {
    font-family: "Font Awesome 5 Free";
    content: "\f08d";
    visibility: visible;
    color:#<?php echo $portalThemeMainColor; ?>;
}
.theme_shade_dark .nav-box-card > h5 {
    color:#fff;
}
.theme_shade_light .nav-box-card > h5 {
    color:#<?php echo $portalThemeMainColor; ?>;
}
.nav-box-card > ul {
    padding-left:15px;
}
.nav-box-card > ul > li > a > span {
    display:table-cell;
    vertical-align:middle;
}
.nav-box-card > ul > li > a > span:first-child {
    width: 40px;
    font-size: 24px;
}
.nav-box-card > ul > li > a > span:nth-child(2) {
    font-family: 'Montserrat', sans-serif;
    font-weight:500;
}
.nav-box-card > ul > li > a {
    display:table-row;
    width:100%;
    clear:both;
    vertical-align:middle;
    text-decoration:none !important;
}
.nav-box-card > ul > li {
    display:table;
    width:100%;
    height: 38px;
}
.theme_shade_dark .nav-box-card > ul > li > a > span {
    color: #fff;
}
.theme_shade_light .nav-box-card > ul > li > a > span {
    color: #000;
}
.nav-dashboard .btn-primary {
    width: 100%;
    font-size: 20px;
    text-align: left;
    padding: 4px 13px 8px 13px;
}
.nav-dashboard .dropdown-toggle::after {
    float: right;
    top: 14px;
    position: relative;
}
.theme_shade_dark .nav-dashboard .btn-primary:hover,
.theme_shade_dark .nav-dashboard .btn-primary:active,
.theme_shade_dark .nav-dashboard .btn-primary {
    border: 0 !important;
    box-shadow: transparent 0 0 0 !important;
}
.theme_shade_dark .nav-dashboard .btn-primary:hover,
.theme_shade_dark .nav-dashboard .btn-primary:active,
.theme_shade_dark .nav-dashboard .btn-primary {
    background-color: #<?php echo $portalThemeMainColor; ?>;
    border-color: #<?php echo $portalThemeMainColor; ?>;
}
.theme_shade_light .nav-dashboard .btn-primary:hover,
.theme_shade_light .nav-dashboard .btn-primary:active,
.theme_shade_light .nav-dashboard .btn-primary {
    background-color: #<?php echo $portalThemeMainColor; ?>;
    border-color: #<?php echo $portalThemeMainColor; ?>;
}

.width50px {width: 50px; float:left;}
.width100px {width: 100px;float:left;}
.width125px {width: 125px;float:left;}
.width150px {width: 150px;float:left;}
.width175px {width: 175px;float:left;}
.width250px {width: 250px;float:left;}
.widthAutoTo175px {width: calc(100% - 175px);float:left;}
.widthAutoTo250px {width: calc(100% - 250px);float:left;}

/**----------------Portal Body------------- **/


div.portal-section .BodyContentOuter {
    height:100%;
}
div.portal-section .BodyContentBox,
div.portal-section .BodyContentBox .formwrapper,
div.portal-section .BodyContentBox .formwrapper-outer,
div.portal-section .BodyContentOuter .formwrapper-outer .vue-app-body,
div.portal-section .BodyContentOuter .formwrapper-outer .vue-app-body .entityDashboard {
    height: inherit;
}

/**----------------Portal Header------------- **/

.labelBreadcrumb {
    display:none;
}
.breadCrumbsInner {
    margin: 2px 0 0 0;
    padding:0;
    display:block;
    white-space:nowrap;
}
.homeBreadcrumb {
    top: 3px;
    position: relative;
    margin-right: 5px;
}
.breadCrumbsInner li:not(.labelBreadcrumb) {
    list-style-type: none;
    display:inline-block;
    white-space:nowrap;
}
.breadCrumbsInner li > * {
    font-size:20px;
}
.breadCrumbsInner li > *:not(.fas) {
    font-family: 'Montserrat', sans-serif;
}
.theme_shade_dark .breadCrumbsInner li > * {
    color: #fff !important;
}
.theme_shade_light .breadCrumbsInner li > * {
    color: #000 !important;
}
.portal-body {
    position:relative;
    margin-left:250px;
    padding:15px 0 15px 0;
    z-index:3;
    height:100vh;
}
.portal-body .divCell {
    margin:0;
}
.theme_shade_dark .portal-body {
    background-color:#252525;
}
.theme_shade_light .portal-body {
    background-color:#dadada;
}
.portal-body .breadCrumbsInner a.breadCrumbHomeImageLink img {
    width:25px;
    height:22px;
}
header.portal-header {
    border-radius:5px;
    padding: 11px 19px;
    position:fixed;
    width: calc(100% - 300px);
    box-shadow: rgba(0,0,0,.3) 0 0 7px;
    margin-left: 25px;
}
.shoppingCartIcon {
    width: 23px;
    height: 19px;
    display:inline-block;
}

.theme_shade_dark .appCartWrapper .empty-cart-text .cart-icon-large,
.theme_shade_dark .shoppingCartIcon {
    background: url(<?php echo $this->app->objCustomPlatform->getFullPortalDomainName(); ?>/_ez/images/financials/cart-icon-white.svg) no-repeat center center / 100% auto;
}
.theme_shade_light .appCartWrapper .empty-cart-text .cart-icon-large,
.theme_shade_light .shoppingCartIcon {
    background: url(<?php echo $this->app->objCustomPlatform->getFullPortalDomainName(); ?>/_ez/images/financials/cart-icon-black.svg) no-repeat center center / 100% auto;
}

div.portal-section {
    margin-top: 63px;
    height: 100%;
    padding: 0 0 0 0;
}
.BodyContentOuter {
    /*padding: 0 25px;*/
}
.breadcrumb-right-menu-list {
    display:none;
}
.theme_shade_dark header.divTable {
    background-color: #0c1515;
}
.swiper-button-prev, .swiper-container-rtl .swiper-button-next {
    left: 0;
    right: auto;
}
.swiper-button-next, .swiper-container-rtl .swiper-button-prev {
    right: 0;
    left: auto;
}
.theme_shade_light header.divTable {
    background-color: #fff;
}
.portal-body .right-float-menu ul li,
.portal-body .desktop-account-access ul li {
    list-style-type:none;
    display:inline-block;
}
.portal-body .right-float-menu ul li {
    padding: 0 7px;
}
.portal-body .desktop-account-access ul li {
    padding: 0 3px;
}
.portal-body .right-float-menu ul,
.portal-body .desktop-account-access ul {
    display:block;
}
.main-user-avatar {
    width: 35px;
    border-radius: 50%;
}
.right-float-menu-outer {
    text-align: right;
}
.theme_shade_dark .right-float-menu-outer {
    color: #fff;
}
.theme_shade_light .right-float-menu-outer {
    color: #000;
}
.right-float-menu-outer > div {
    display: inline-block;
}
.right-float-menu-outer > div > ul {
    margin:0;
}
.right-float-menu-outer .fa-bell {
    font-size:23px;
    position: relative;
    top: 2px;
}

/** ------ Page Right Tabs ---- **/

.dashboard-tab {
    display:inline-block;
    padding:10px 15px;
    border-radius: 20px 20px 0 0 /90px 90px 0 0;
    margin-left: -5px;
    z-index:5;
    position: relative;
    cursor:pointer;
}

.dashboard-tab.active {
    display:inline-block;
    padding:10px 15px;
    border-radius: 20px 20px 0 0 /90px 90px 0 0;

    margin-left: -5px;
    z-index:10;
    cursor:default;
}
.theme_shade_light .dashboard-tab {
    background: linear-gradient(to bottom, rgba(255,255,255,.5) 0%, rgba(255,255,255,0) 100%);
    border-top:1px solid #ffffff;
    border-right: 1px solid #aaaaaa;
    border-left: 1px solid #ffffff;
}
.theme_shade_dark .dashboard-tab {
    background: linear-gradient(to bottom, rgba(255,255,255,.1) 50%, rgba(255,255,255,0) 100%);
    border-top:1px solid #777;
    border-right: 1px solid #444;
    border-left: 1px solid #555;
}
.theme_shade_light .dashboard-tab.active {
    background: linear-gradient(to bottom, rgba(255,255,255,.8) 50%, rgba(255,255,255,.5) 100%);
    border-top:1px solid #ffffff;
    border-right: 1px solid #aaaaaa;
    border-left: 1px solid #ffffff;
}
.theme_shade_dark .dashboard-tab.active {
    background: linear-gradient(to bottom, rgba(255,255,255,.3) 50%, rgba(255,255,255,.07) 100%);
    border-top:1px solid #bbb;
    border-right: 1px solid #888;
    border-left: 1px solid #aaa;
}
.entityTab:not(.showTab) {
    display:none;
}
.entityTab.showTab {
    display:block;
}

/** ------ Cart ---- **/

.cart-display-outer {
    width:100%;
}

.cart-display-outer .item-header {
    padding-bottom: 10px;
    border-bottom: 1px solid #cccccc;
    text-align: left;
    font-weight:normal;
}
.cart-display-outer .product-info-detail {
    padding-right: 20px;
}
.cart-display-outer tbody td {
    padding: 15px 0;
    border-bottom: 1px solid #cccccc;
}
.cart-display-outer tfoot td {
    padding-top: 15px;
}
.cart-display-outer tbody td table.cart-display-attr {
    margin-left:15px;
    margin-bottom:5px;
}
.cart-display-outer tbody td table.cart-display-attr td.cart-display-attr-value {
    padding-left: 10px;
}
.cart-display-outer tbody td table.cart-display-attr td {
    padding: 3px 0 3px 0px;
    border-bottom: 0px none;
}
.cart-display-outer tfoot td table.cart-display-attr td {
    padding-top: 3px;
}

.not-logged-in {
    text-align:center;
    padding-top: 55px;
}
.product-quantity-input {
    padding: 5px 4px;
    font-family: inherit;
    font-weight: 400;
    font-size: 12px;
    line-height: 14px;
    color: #333;
    background-color: #fff;
    border: 1px solid #ccc;
    -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    box-shadow: inset 0 1px 2px rgba(0,0,0,.1);
    -webkit-transition: border linear .2s;
    -moz-transition: border linear .2s;
    -ms-transition: border linear .2s;
    -o-transition: border linear .2s;
    transition: border linear .2s;
}
.cart-display-outer .product-price-info1, .cart-display-outer .product-price-info2, .cart-display-outer .product-price-info3 {
    float: right;
    clear: both;
}
.cart-display-outer .product-display-account-balance-box {
    border-bottom: 1px solid #ccc;
    border-top: 1px solid #ccc;
    margin: 15px 0;
    padding: 10px 0;
}
.cart-display-outer .product-price-title {
    color: #999;
    margin: 0 2px 0 15px;
    line-height: 18px;
}
.cart-display-outer .product-price-value {
    display: inline-block;
    min-width: 85px;
    text-align: right;
}
.cart-display-outer .currency, .cart-display-outer .value {
    font-weight: 700;
    font-size: 12px;
    color: #333;
}
.product-main-image-prime {
    float: left;
}
.product-main-details {
    float: left;
    padding-left: 15px;
    width: calc( 100% - 100px );
}
.product-main-image-prime {
    float: left;
}


.remove-single-product {
    background: #cc0000;
    color: #ffffff !important;
    padding: 1px 10px;
    border-radius: 5px;
    display: inline-block;
    margin-top: 5px;
}
.cart-display-outer .product-buy-only {
    padding: 10px 20px;
    font-size: 15px;
    border-radius: 5px;
    color: #fff;
    margin-top: 10px;
    display:block;
}
.product-operate  .product-remove {
    text-align:right;
}
.product-icon-img {
    box-shadow: rgba(0,0,0,.3) 1px 1px 5px;
}
.no-cart-text {
    border-top: 1px solid #cccccc;
    margin-top: 40px;
    padding-top: 15px;
    padding-bottom: 15px;
    border-bottom: 1px solid #cccccc;
}
.product-price-submit-wrapper {
    border-top: 1px solid #cccccc;
    margin-top: 15px;
}
.no-cart-text, .no-cart-text span {
    font-family: CustomFont02, Yanone Kaffeesatz !important;
    font-size: 21px !important;
    font-style: normal !important;
    text-align: center;
}
.empty-cart-text {
    border-top: 1px solid #cccccc;
    margin: 45px 0 65px;
    padding: 15px 0;
    border-bottom: 1px solid #cccccc;
    background: url(/_ez/images/financials/cart-icon-black.png) no-repeat left calc( 50% - 123px ) top 12px / auto 70%;
    text-indent: 62px;
    width: 100%;
}
.empty-cart-text, .empty-cart-text span {
    font-family: CustomFont02,Yanone Kaffeesatz !important;
    font-size: 27px !important;
    font-style: normal !important;
    text-align: center;
}
.empty-cart-action {
    margin: 15px 0;
    padding: 15px 0;
    text-align:center;
    line-height: 49px;
}
.empty-cart-action span {
    font-family: CustomFont02, Yanone Kaffeesatz !important;
    font-size: 29px !important;
    font-style: normal !important;
    text-align: center;
}
.no-cart-text span {
    text-decoration:underline;
}
.cart-display-box,
.cart-display-box > div {
    height: 100%;
}

/** ------ Content ---- **/

.account-page-title {
    font-family: 'Montserrat', sans-serif;
    display: inline-block;
    top: 3px;
    position: relative;
    margin-right: 11px;
    line-height: 1.0;
    margin-bottom: 0px;
}
.account-page-title .componentIcon {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
.entityTab h4 {
    font-family: 'Montserrat', sans-serif;
}
td.page-count-display button.btn {
    top: -2px;
    position: relative;
    padding: .2rem .55rem;
    line-height: 1.4;
}
.fformwrapper-header .form-search-box {
    display: inline-block;
    top: -1px;
    position: relative;
    max-width:500px;
}
.breadCrumbHomeImage {
    width: 25px;
    height: 22px;
    display:inline-block;
}
.theme_shade_dark .breadCrumbHomeImage {
    background: url(<?php echo $this->app->objCustomPlatform->getFullPortalDomainName(); ?>/media/images/home-icon-01_white.png) no-repeat center center / 100% auto;
}
.theme_shade_light .breadCrumbHomeImage {
    background: url(<?php echo $this->app->objCustomPlatform->getFullPortalDomainName(); ?>/media/images/home-icon-01_black.png) no-repeat center center / 100% auto;
}
.theme_shade_light .slim-btn,
.theme_shade_dark .vue-modal-wrapper div:not(#app-vue),
.theme_shade_dark .account-page-title,
.theme_shade_dark .card-tile-50 h4,
.theme_shade_dark .card-tile-100 h4,
.theme_shade_dark .card-tile-50 div *,
.theme_shade_dark .card-tile-100 div * {
    color: #fff;
}
.theme_shade_light .vue-modal-wrapper div *,
.theme_shade_light .account-page-title,
.theme_shade_light .card-tile-50 h4,
.theme_shade_light .card-tile-100 h4,
.theme_shade_light .card-tile-50 div *,
.theme_shade_light .card-tile-100 div * {
    color: #000;
}
.theme_shade_light .slim-btn,
.theme_shade_light .btn-primary,
.theme_shade_dark .btn-primary {
    color: #fff !important;
}
.theme_shade_dark .form-control {
    border: 1px solid #333;
    background:#000;
}
.theme_shade_light .form-control {
    background:#fff;
}
.theme_shade_light .augmented-form-items {
    background:#ddd;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset
}
.theme_shade_dark .augmented-form-items {
    background:#0e5858;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset
}
#vueApp-content > div > section > div > div > div > .fformwrapper-header table td:first-child h3.account-page-title {
    display:none;
}
.fformwrapper-header table td {
    padding:5px 0;
}
.back-to-entity-list {
    background: #cc0000 url(/website/images/mobile-back.png) center center / auto 75% no-repeat !important;
    text-indent: -99999px;
    padding: 5px 0px !important;
    width: 24px;
    height: 23px;
    display: inline-block;
    top: 2px;
    position: relative;
    border-radius: 5px;
}
.vueAppWrapper .table-striped tbody tr {
    cursor:pointer !important;
}
.theme_shade_light .table-striped tbody tr:nth-of-type(odd) {
    background-image: linear-gradient(to bottom, #ffffff 0%, #eeeeee 100%) !important;
}
.theme_shade_light .table-striped tbody tr:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #bcbcbc 0%, #efefef 100%) !important;
}
.theme_shade_dark .table-striped tbody tr:nth-of-type(odd) {
    background-image: linear-gradient(to bottom, #1f1f1f 0%, #1b1b1b 100%) !important;
}
.theme_shade_dark .table-striped tbody tr:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #0e0e0e 0%, #151515 100%) !important;
}
.theme_shade_light .table-striped tbody tr.demoCard:nth-of-type(odd) {
    background-image: linear-gradient(to bottom, #ffddff 0%, #efc3ef 100%) !important;
}
.theme_shade_light .table-striped tbody tr.demoCard:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #cb99cb 0%, #eab6ea 100%) !important;
}
.theme_shade_dark .table-striped tbody tr.demoCard:nth-of-type(odd) {
    background-image: linear-gradient(to bottom, #554155 0%, #453445 100%) !important;
}
.theme_shade_dark .table-striped tbody tr.demoCard:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #302430 0%, #4d3a4d 100%) !important;
}

.theme_shade_light .tableGridLayout .table-striped tbody tr:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #ffffff 0%, #eeeeee 100%) !important;
}

.vueAppWrapper .header-table td {
    border-top:0px;
    padding-top: 5px;
    padding-bottom: 0px;
    position: relative;
    padding-left: 0;
    padding-right: 0;
    vertical-align: middle;
}
.vueAppWrapper .table tbody tr td {
    vertical-align: middle;
}
.vueAppWrapper .table tbody tr td.statusColumn {
    text-align:center;
}
.vueAppWrapper .formwrapper-view-entity {
    padding:5px 15px;
    width:100%;
}
.vueAppWrapper .formwrapper-outer {
    position:relative;
    right: 0%;
    transition: .5s;
    height: 100%;
}
.vueAppWrapper .formwrapper-outer.edit-entity {
    transition: .5s;
    right: 100%;
}

body .activeStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color: #0083ff;
    color: #ffffff !important;
    padding: 5px 10px;
    border-radius: 3px;
    display: inline-block;
}

body .buildStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color: #ff0000;
    color: #ffffff !important;
    padding: 5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .pendingStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#9851a0;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .disabledStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#aaaaaa;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .canceledStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#555555;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}

body .pendingStatusInline {
    background-color:#9851a0;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}

body .queuedStatusInline {
    background-color:#accff3;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .disabledStatusInline {
    background-color:#aaaaaa;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .canceledStatusInline {
    background-color:#555555;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
body .activeStatusInline {
    background-color:#0083ff;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.vueAppWrapper .active.sortasc, .vueAppWrapper .active.sortdesc {
    position: relative;
}
.vueAppWrapper table th a { cursor: pointer; }
.vueAppWrapper .pointer { cursor: pointer; }
.theme_shade_light .vueAppWrapper .active span,
.theme_shade_light .vueAppWrapper .active {
    color: #<?php echo $portalThemeMainColorLight; ?>;
}
.theme_shade_dark .vueAppWrapper .active span,
.theme_shade_dark .vueAppWrapper .active {
    color: #07d0d0 !important;
}
.vueAppWrapper .page-count-display > span > span {
    background: #ddd;
    padding:2px 5px;
    border-radius: 3px;
    display:inline-block;
}
.vueAppWrapper .page-count-display > span > span.active {
    background: #fff;
    color:#000;
}
.vueAppWrapper .active.sortasc:after {
    content: '\25B2';
    display: block;
    position:absolute;
    right: -20px;
    top: -2px;
}
.vueAppWrapper .active.sortdesc:after {
    content: '\25BC';
    display: block;
    position:absolute;
    right: -20px;
    top: 0px;
}

.theme_shade_dark .pop-up-dialog-main-title-text,
.theme_shade_dark .entityListOuter table th,
.theme_shade_dark .entityListOuter table td,
.theme_shade_dark .entityListOuter table td a,
.theme_shade_dark .entityListOuter table th a {
    color:#fff;
}

.theme_shade_light .pop-up-dialog-main-title-text,
.theme_shade_light .entityListOuter table th,
.theme_shade_light .entityListOuter table td,
.theme_shade_light .entityListOuter table td a,
.theme_shade_light .entityListOuter table th a {
    color:#000;
}

.entityListOuter table th,
.entityListOuter table td,
.entityListOuter table td a,
.entityListOuter table th a {
    white-space:nowrap;
}

.processWorkflow .card-tile-100,
.entityDashboard .card-tile-100 {
    width:100%;
}

.entityDashboard .card-tile-50,
.entityDashboard .card-tile-100 {
    border-radius: 10px;
    padding: 15px 25px;
}

.theme_shade_light .entityDashboard .card-tile-50,
.theme_shade_light .entityDashboard .card-tile-100 {
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}

.theme_shade_dark .entityDashboard .card-tile-50,
.theme_shade_dark .entityDashboard .card-tile-100 {
    background: #101010;
    box-shadow: #000000 0 0 5px;
}

.entityDashboard .width50:nth-of-type(odd) .card-tile-50 {
    width:calc( 100% - 7px );
    margin-right:7px;
}

.entityDashboard .card-tile-50 {
    min-height: 250px;
}

.entityDashboard .width50:nth-of-type(even) .card-tile-50 {
    width:calc( 100% - 8px );
    margin-left:8px;
}

.entityDashboard .width33:nth-of-type(n+1) .card-tile-33 {
    width:calc( 100% - 7px );
    margin-right:8px;
}

.entityDashboard .width33:nth-of-type(n+2) .card-tile-33 {
    width:calc( 100% - 16px );
    margin-right:8px;
    margin-left:8px;
}
.entityDashboard .width33:nth-of-type(n+3) .card-tile-33 {
    width:calc( 100% - 8px );
    margin-left:8px;
}

/** ------ User Profile Desktop Menu ---- **/

.DialogTransparentShield {
    position: absolute;
    top:0px;
    left:0px;
    width: 100%;
    height: 100%;
    z-index:1000;
}

.AvatarMenu,
.NotificationModal {
    position: absolute;
    z-index: 1000;
    top: 68px;
    min-height: 100px;
    z-index:1001;
}
.AvatarMenu {
    right: 25px;
    min-width: 150px;
}

.NotificationModal {
    right: 191px;
    min-width: 250px;
}
.AvatarMenuTriangle {
    position: absolute;
    top: 0px;
    right: 26px;
    width: 26px;
    height: 11px;
    background: url(/media/images/AvatarBubbleTriangle.png) no-repeat;
}
.AvatarMenuInner {
    margin-top:11px;
    background: #fff;
    box-shadow: rgba(0,0,0,.4) 0 0 5px;
    border-radius: 10px;
    width:100%;
    min-height:51px;
}
.AvatarMenuItemBlock {
    margin:0px;
    padding:0px;
    padding: 5px 0px;
    display:flex;
    flex-direction: column;
    justify-content: space-between;
}
.AvatarMenuItem {
    list-style-type:none;
    margin-left:0px;
    padding: 10px 15px 10px 15px;
    cursor:pointer;
    display:flex;
}
.AvatarMenuItem span:first-child {
    font-size: 22px;
    width: 40px;
    color: #aaa;
}
.AvatarMenuItem span:last-child {
    font-size: 17px;
}

.NotificationModalInner {
    padding: 15px;
}
.NotificationModalTitle {
    font-family: 'Montserrat', sans-serif;
}

/** ------ Modal ------ **/

body.theme_shade_light div.universal-float-shield {
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px,rgba(255,255,255,.4) ;
}

body.theme_shade_dark div.universal-float-shield {
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px,rgba(0,0,0,.4) ;
}
body div.universal-float-shield {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px,rgba(255,255,255,.4) ;
    z-index:11000;
    overflow-y: auto;
    justify-content: center;
    align-items: center;
    display:flex;
}
body div.closedModal.universal-float-shield {
    display:none !important;
}
.vue-float-shield-inner {
    display: flex;
    flex-direction: column;
    max-height: 100vh;
    max-height: -webkit-fill-available;
}
.theme_shade_light .zgpopup-dialog-box.dialog-theme-default {
    background: #ffffff;
    background: linear-gradient(to bottom, #fff 0%, #eaeaea 100%);
    box-shadow: 0 0 10px #000000;
}

.theme_shade_dark .zgpopup-dialog-box.dialog-theme-default {
    background: #142d2d;
    background: linear-gradient(to bottom, #142d2d 0%, #000 100%);
    box-shadow: 0 0 10px #fff;
}

.zgpopup-dialog-box {
    border-radius: 0px;
    max-width: calc(100vw - 50px);
    min-width: 250px;
}

.theme_shade_light .zgpopup-dialog-header {
    background: #fff;
    background: linear-gradient(to bottom, #fff 0%, #FAFAFA 100%);
}

.zgpopup-dialog-header {
    border-radius: 0 15px 0 0;
    border-radius: 0px 0px 0 0;
    margin-bottom: -7px;
    margin-top: -5px;
    padding: 15px 20px 7px;
}

.zgpopup-dialog-header {
    position:relative;
}

.general-dialog-close {
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAUCAYAAABiS3YzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAqxJREFUeNqclFuLUlEUx885ozOlMQ7eLw++iJGX1wyCqZgIsnrwhoIEYZc3YSrqCxR9AZ/mRbzV5PQkBH2DHuzBSyWa0oNRUInXQcd0tLVlb9vqcYQ2LM45++z9O2v91/9shpkdLPN/g+V74HCg5zHEKBgMjlaRQqHQwj4UZIKTy+UbTqfzLNxvQAjxhlVAIVrvcrnO4fsJbw1DBR6P55pCoXiu0+kqxWLxN/pyOp0e22y28QnA0z6f75JarX5hNBor+Xz+G8qUQLlcLvfdarVuyWSy+xqNplIqlX7xgWkgJLKtUqmedjqd17FY7B3MDRGUaIrg62hhIBB4IBaLr1er1WepVOoDzB1BDLBmLA2EDJ+02+1kNBp9BXNdiD8kUzKQyONMJvPRbDZLQIq7dMZ4jWAJsIc/PCIZMtBpBsok4FE2m83PgWsYeMrtdm/D3DwQZXjMUGUzoNkkloEhvpbL5bbD4bgIjXzcarX2QcN9PuAMlFwp8BjAn0wm0xaUesdgMJyB6+1Go5GMx+NJoiFUeYz3TMeCF2ERMTHSaBCJRBLdbvczuOIWZPg+kUik8Lsh0XB+cCf8dqiKNSj5vEgksvb7/S8SieSC3W4343fcst96pnweH17WarW79Xr9ADLeAynESApoVJn2MeWORegc8AoAHqGmQMlIwx5onIHmbfLYbQY8hdJAr9e7A3/Kw2az+ZJqSh91mcduC+AJFEpgKeBVpVK5i4EHGDjAtlmwG8hThrPiJ37/D4pFF/r9/h04rVDJCQC+IUBkGz4fWyyWTVh/T6/XFwuFwg9iRY4+V6G7Nw4PD6Ng7CQN5LEbMnw3HA7v9Xq9t2C3m7QT6ENaIJVK16HTI1zKkAbOHX0s2YOqhWzZWq1G/qzpKcVSgcZ41cmPwTN7SPwVYAArcoAyG20N/QAAAABJRU5ErkJggg==') no-repeat center center / 100%;
    height:18px;
    width:18px;
    position:absolute;
    right:8px;
    top:7px;
    cursor:pointer;
}

.pop-up-dialog-main-title-text {
    font-family: 'Montserrat', sans-serif;
}

.dialog-right-loading-anim:after {
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px, rgba(255,255,255,.4);
    content: " ";
    position: absolute;
    right: 35px;
    top: 45px;
    display: block;
    width: 25px;
    height: 25px;
    z-index:100;
}

.ajax-loading-anim:after {
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px, linear-gradient(to bottom, rgba(255,255,255,.4) 0%, rgba(234,234,234,.4) 100%);
    content: " ";
    position: absolute;
    display: block;
    width: 100%;
    height: 100%;
    top:0;
    left:0;
    right:0;
    bottom:0;
    z-index:100;
}

.ajax-loading-anim-inner {
    position:relative;
}

.ajax-loading-anim-inner:after {
    background-image: url(/website/images/LoadingIcon2.gif) !important;
    background-repeat: no-repeat;
    background-position-x: calc(100% - 15px);
    background-size: 35px !important;
    background-position-y: center;
    content: " ";
    position: absolute;
    display: block;
    width: 100%;
    height: 100%;
    top:0;
    left:0;
    right:0;
    bottom:0;
    z-index:100;
}
.ajax-loading-anim-inline {
    background-image: url(/website/images/LoadingIcon2.gif) !important;
    background-repeat: no-repeat;
    background-position-x: center;
    background-size: 35px !important;
    background-position-y: center;
    min-height: inherit;
}

.zgpopup-dialog-body {
    margin: 5px 20px 20px;
    position: relative;
    height: 100%;
    padding: 8px 0px;
}
.zgpopup-dialog-body-inner-append {
    padding-left: 26px;
    padding-bottom: 3px;
}
.zgpopup-dialog-body-inner-checked {
    margin: 15px 0 0 0;
    background: url(/media/images/CheckMarkIconGreen.png) no-repeat left 0px top 1px / 19px;
}
.zgpopup-dialog-body-inner-error {
    margin: 15px 0 0 0;
    background: url(/media/images/ErrorIconRed.png) no-repeat left 0px top 1px / 19px;
}
.pop-up-dialog-main-title {
    font-size:25px;
}

/** ------ The Switch ------ **/

/* The switch - the box around the slider */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}
.switch-small {
    position: relative;
    display: inline-block;
    width: 41px;
    height: 22px;
    margin-bottom:0px;
    top: 1px;
    position: relative;
    margin-right: 5px;
}


/* Hide default HTML checkbox */
.switch input,
.switch-small input {
    opacity: 0;
    width: 0;
    height: 0;
}

/* The slider */
.switch .slider,
.switch-small .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    -webkit-transition: .4s;
    transition: .4s;
}

.switch .slider::before,
.switch-small .slider::before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}
.switch-small .slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 2px;
    background-color: white;
    -webkit-transition: .4s;
    transition: .4s;
}

.switch input:checked + .slider,
.switch-small input:checked + .slider {
    background-color: #2196F3;
}

.switch input:focus + .slider,
.switch-small input:focus + .slider {
    box-shadow: 0 0 1px #2196F3;
}

.switch input:checked + .slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);
}

.switch-small input:checked + .slider:before {
    -webkit-transform: translateX(17px);
    -ms-transform: translateX(17px);
    transform: translateX(17px);
}

/* Rounded sliders */
.switch .slider.round,
.switch-small .slider.round {
    border-radius: 34px;
}

.switch .slider.round:before,
.switch-small .slider.round:before {
    border-radius: 50%;
}

/** ------ Css Fixes ------ **/

.table .table {
    background-color: transparent !important;;
}
.table td, .table th {
    border-top: 0;
}

/** ------ Pretty Scroll ------ **/

.ss-wrapper {
    overflow: hidden;
    width: 100%;
    height: 100%;
    position: relative;
    z-index: 1;
    float: left;
}
.ss-content {
    height: 100%;
    width: calc(100% + 18px);
    padding: 0 0 0 0;
    position: relative;
    overflow-x: auto;
    overflow-y: scroll;
    box-sizing: border-box;
}
.ss-content.rtl {
    width: calc(100% + 18px);
    right: auto;
}
.ss-scroll {
    position: relative;
    background: rgba(0, 0, 0, 0.1);
    width: 9px;
    border-radius: 4px;
    top: 0;
    z-index: 2;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.25s linear;
}
.ss-hidden {
    display: none;
}
.ss-container:hover .ss-scroll,
.ss-container:active .ss-scroll {
    opacity: 1;
}
.ss-grabbed {
    -o-user-select: none;
    -ms-user-select: none;
    -moz-user-select: none;
    -webkit-user-select: none;
    user-select: none;
}

/** ------ Buttons ------ **/

.addNewEntityButton,
.editEntityButton,
.filterEntityButton,
.emailEntityButton,
.deleteEntityButton {
    display:inline-block;
    width:20px;
    height:20px;
    position: relative;
}
.addNewEntityButton::before {
    display: block;
    width:22px;
    height:22px;
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAxdJREFUeNqcVL9vHEUYfTM7u3eXvcN3/nFxsM6XRAgJyyYyChISdBQgxWAEFDRuESkSqqQCKfwDNOmTIkqqSCQGCxASDVUEtowiEKGwZNnyjwCOfdi3vt2dGd7s3tkmFg0jfVrtvO+9efN9367ApXs4tiwmAt+7UAq8874nm0LAS1KzEsV6oZPob5jwANzMc232EP8Ssrb/RMH/tN5XvFgrFwoONl1ISQGrDZ60Y2xuRzfbneQzii0fF7I4PdRX/HJ0oDzuKQ8poXo5QKWgMni9tY92rKFoRGuN1b/21ij4FokLDpddJzWKzJ2pV8YFRbT0EFmBD19p4M4H41m8WPWxxz2HCc9Dc6jy7MlqadYZyIVoLSwG15qD5TEj+cokUAy+gnPmruRCMtyeYLgcwxo1BsKRShhcpxiZQowNV0sfSZKsoEBPSJEAcVg+Eq2n4A5zjiRxxThVPTElpHhdlQpquhYWgphVjUjNuCTt0WxyROjPSOP3zZh3YI5OEbANo6HCQBigXPTfU2GgXnadafaX8Orpflie6IzGFHm+FhwIXRirY/AkW+CqSqF4P8Gdn1ax5a7tiUkVKNnsGIuxehlXXmvgv9bM+RHMHN0wGt8urmL579gJDzl9D/9rifzi+WAKlWiz4ktxbmkrwu2fN7GTWETasrgSb5ztw8RgMaN9/dsf+GVHk8caGYO4k2Bb5wPItaU4ZPO+wNSjx3tYfNzGo21aNbnR8N3nDoRuPFjB3SViHolxAqQMYXtfxEPZ7qRzrSi2Rdd5N+6WpXfD7BkEvUSukpJ5x9wZDncjbnJ3FJqV1tof17ejW26jE6dAQr+peyZ50kFxbb7HjvEbOQxjfiD6lRtItNrJJ2tP2hsZ4JKdEEWDwzGCJ7pCPTzNBHcp9DHhWODy/bwHQrwUFv17u6ltZNPNA14YruDUM4UM/3WthY3dOP9t5G5ajPcJfZf3sCvU/QOchRSfw5PTbiihbbcpzpLMi+uuq833FLzKmO9R1VOjsUTwHaT6TQjzNt8n6WwoQ7TeouhD4nN8/8JV7Sj1HwEGAGXUUvW2OWvwAAAAAElFTkSuQmCC) no-repeat center center / 100%;
    content: " ";
}
.filterEntityButton::before {
    display:block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABkAAAAZCAYAAADE6YVjAAAACXBIWXMAAAsTAAALEwEAmpwYAAAF0WlUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPD94cGFja2V0IGJlZ2luPSLvu78iIGlkPSJXNU0wTXBDZWhpSHpyZVN6TlRjemtjOWQiPz4gPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iQWRvYmUgWE1QIENvcmUgNS42LWMxNDUgNzkuMTYzNDk5LCAyMDE4LzA4LzEzLTE2OjQwOjIyICAgICAgICAiPiA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOnhtcE1NPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdEV2dD0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlRXZlbnQjIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtbG5zOnBob3Rvc2hvcD0iaHR0cDovL25zLmFkb2JlLmNvbS9waG90b3Nob3AvMS4wLyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cykiIHhtcDpDcmVhdGVEYXRlPSIyMDIwLTA3LTE0VDAwOjA3OjQ1LTA1OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDIwLTA3LTE0VDAwOjA3OjQ1LTA1OjAwIiB4bXA6TW9kaWZ5RGF0ZT0iMjAyMC0wNy0xNFQwMDowNzo0NS0wNTowMCIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDpkZjU2MzAxNi1jY2EwLTE3NGMtYWE4MS05N2I3NzU5NGM0ZTAiIHhtcE1NOkRvY3VtZW50SUQ9ImFkb2JlOmRvY2lkOnBob3Rvc2hvcDpiZWY0Yjk1Ni1mOGQ3LTkzNGEtYTYzYi03MmI3ZWZjNDhkYmUiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo1NzE2YzJjNS05MzgwLTIwNDAtYjg3MS0wNDI0M2IxMGI0NDgiIGRjOmZvcm1hdD0iaW1hZ2UvcG5nIiBwaG90b3Nob3A6Q29sb3JNb2RlPSIzIj4gPHhtcE1NOkhpc3Rvcnk+IDxyZGY6U2VxPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0iY3JlYXRlZCIgc3RFdnQ6aW5zdGFuY2VJRD0ieG1wLmlpZDo1NzE2YzJjNS05MzgwLTIwNDAtYjg3MS0wNDI0M2IxMGI0NDgiIHN0RXZ0OndoZW49IjIwMjAtMDctMTRUMDA6MDc6NDUtMDU6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDQyAyMDE5IChXaW5kb3dzKSIvPiA8cmRmOmxpIHN0RXZ0OmFjdGlvbj0ic2F2ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6ZGY1NjMwMTYtY2NhMC0xNzRjLWFhODEtOTdiNzc1OTRjNGUwIiBzdEV2dDp3aGVuPSIyMDIwLTA3LTE0VDAwOjA3OjQ1LTA1OjAwIiBzdEV2dDpzb2Z0d2FyZUFnZW50PSJBZG9iZSBQaG90b3Nob3AgQ0MgMjAxOSAoV2luZG93cykiIHN0RXZ0OmNoYW5nZWQ9Ii8iLz4gPC9yZGY6U2VxPiA8L3htcE1NOkhpc3Rvcnk+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+GIsaBwAAAu9JREFUSMet1k1onFUUBuDn3swkk4RYG5Tiz0IUqm66UCouBFEUF3FjXHXThRvtwqLGbSkFW9SFghs3boyIUC1x0WALkkgpEhwitBWMtmAUbRK0STRNZjI/3+dipiGTzJ/guz3n3Pc733nPe29YOaIdcngRT+MR3IV+FLCA7zGFMyi2OiS0IXkDr+NenfE73sd73ZI8JBhXcTAtEWJnhjQh9CIjL3UYc9vjmR35j2JaYkguS39FWkk7s2QCaYZS+aDgOzyF2WYk9+GiVC5ZpXfkBQOjH0hW/+jIEffcY2PiqNLkafF2Q4KLeBjzO0nO1wct5ChfucChYZm793Xxu8rKVy4IuQbBnMeDcOuPj2F/bUqEfpJri9bHR3WDm+OjkmuLQn+tvo799XNF9OH4zsKeYUrTZ5V//bYtQfm3GaWps3qGm4aPoy9iFEO7wllCkY3TL7cl2fjildqGZJuGhzAaMdJyoHsp53+wOftx0/jmpc+UZy7p2dv2O0YiDrSWJjFL4cxr0rTSGEuqCp8fFTNNFqERByJayyclDlG5umrjq2MNocLXb6nM/SXuqeW1wb54S7atl4A4wOa5tyVrC7Um1m8onjspDjSoqaX/xXbGtuU9GUKFtLBSIymsSgtlIduVwosRS523DdlA7KnJ+44HhP5ekq5IliIud0UiFYfvB6X8J2xUhUxXJJcjJjumBWLuNpVfZvz94ZP+OXVYSKq1Ne6MybByRB/+bLqQ21HNSHJVuWffZOW64jefitltxtQca7gzYhMnOnWSFCrSQmrg+XdlHz8kLelmJiewuf3S+mnLJHcZFEkPgy99JC2tK3z5jnDzek2+rSX8804XhudayjkQAsmNRWm5KPfMq9JeVFrLtn7erktrHk9getd8sqQrVJd+ZDCnPDUhhJamuFa/Gee37XMDZvEY8s3spXp1SjU/QWG5VQf5ev3sDtPYhbl64lj9FbLVc7q0IF1eFgabvlbG6nVz/+VJ9L+9u/4Fcjr9jlRe1d0AAAAASUVORK5CYII=') no-repeat center center / 100%;
    content: " ";
}
.emailEntityButton::before {
    display:block;
    width:22px;
    height:22px;
    background: url("/_ez/images/icons/reminder-icon.png") no-repeat center center / 100%;
    content: " ";
}
.fa-save:before {
    position: relative;
    left: 9%;
}
.form-search-box {
    display:inline-block;
}
.editEntityButton::before {
    display:block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAYAAACoPemuAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAAB3RJTUUH4gkUCx4h0U5y8AAAA6xJREFUWMPN2EtoXFUcx/FPbiKK1kqbWkurWVjFirHWB1WKSrFudGMUhSr42mjx0Soo+NiIK1EUFYtmo+BCUBEqFio+sNGSSkVahRjtFBu01UVaMal9QJ3Exf9MejOZSWbiTegPhuGeOffO9/7P//wfp0UTunATaMUSXIaVuBiLcAZGcRh/og878GO6Hil1Nf5fLQ3CwOlYhTtwPc5LY/WeUYEcwFZ8mECPwVSQk4IlqFMSyHrcgDnNWDmnIXyG17Ed5cngaoLlrLQIT+J+zJsmULUG0Y1XcbCe9SaA5aAux8tYrYElb1Ij2JJeur8W3Lg/zEGtSm/VWTBQtb7Dg9hZDTcGVmWpdwuG+ls4/TkmWn8H7sXPebisatJivFIw1F7ciRvxvtitea3ES2jPD2Y5a7WJNV9dINQQhp2Ia+vxXg24m/EossrKZbklXIP7CoQq4S58irewQuzIx2vAZViHayoDre1rEVH7RSwvCGqPcOrP0Yvz8RC+x6/4Gufi0tw9c3AaNrevVa742LWKW8I9eABfpesjeA7f4M1kuQN4VnL4nG7CVRUTZrjN9CN6XahS19guq4ZbLpZypOr++bilAtYhUk7hUBVVwfUIn3tbFADVWoOFmYhbHTMFVaUjeAcLRN6tlVGWojPDlaJKmDGo3M5fghdwwSTPm4sVbVj2P6BKYvc1CrVR8qFJlGFZJqL9yQJV0eJMxLCTCQrmZk1MrqgSPGcKCkYz/NOkpZpx9OlAwXAb9jc4+bcEtXWGoWBfhp8amHgMv+N4vQkFQpXRn4nEOtVy7sNreATXVYEUCUWUSrvaRFk7YPLi8Ci+TICPiTy3LQ9XEBTsRl/Fx3qmADsslnG7SCMb0vi2gqEkAxxsS2//Ee4W6aCWDjnhX73pe4OoDgYKhBrEx0Q5Dd+KZvT2OjcMG+/4vaKoewpnSX5XgD7BrjzYUbwhisUFNW7oEP3A/PSZl6zbKZriIrRf1GrHS12p7MgdljyPpxXf4E6lMp4R5b1SV+qSUrAsi7Z9yyxDET7enWOZ0FcO4gnRIc+WeoSvDuUHx8ByKaZfJOnZgOsRbdveKobxFsv9sBP3YLOJDUMR+hcfiD523NFARVMdQ7WL7nkdFhYE9YdIb90YqtcfNHJw14qr8bDo+6Z7TnZAxKmNYkVGmj64q2O9U3EFbhUdzlIRy+oVm2URmHfjC2zCD1KcmkpNxasE2YKzcYk4IL5I5MozRXo7JEqkXxJIH/7CaDOHw/8BwN0RTQ5fFN4AAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDktMjBUMTE6MzA6MzMtMDQ6MDD2YkMTAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTA5LTIwVDExOjMwOjMzLTA0OjAwhz/7rwAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAASUVORK5CYII=') no-repeat center center / 100%;
    content: " ";
}
.deleteEntityButton::before {
    display:inline-block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAUCAYAAABiS3YzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAqxJREFUeNqclFuLUlEUx885ozOlMQ7eLw++iJGX1wyCqZgIsnrwhoIEYZc3YSrqCxR9AZ/mRbzV5PQkBH2DHuzBSyWa0oNRUInXQcd0tLVlb9vqcYQ2LM45++z9O2v91/9shpkdLPN/g+V74HCg5zHEKBgMjlaRQqHQwj4UZIKTy+UbTqfzLNxvQAjxhlVAIVrvcrnO4fsJbw1DBR6P55pCoXiu0+kqxWLxN/pyOp0e22y28QnA0z6f75JarX5hNBor+Xz+G8qUQLlcLvfdarVuyWSy+xqNplIqlX7xgWkgJLKtUqmedjqd17FY7B3MDRGUaIrg62hhIBB4IBaLr1er1WepVOoDzB1BDLBmLA2EDJ+02+1kNBp9BXNdiD8kUzKQyONMJvPRbDZLQIq7dMZ4jWAJsIc/PCIZMtBpBsok4FE2m83PgWsYeMrtdm/D3DwQZXjMUGUzoNkkloEhvpbL5bbD4bgIjXzcarX2QcN9PuAMlFwp8BjAn0wm0xaUesdgMJyB6+1Go5GMx+NJoiFUeYz3TMeCF2ERMTHSaBCJRBLdbvczuOIWZPg+kUik8Lsh0XB+cCf8dqiKNSj5vEgksvb7/S8SieSC3W4343fcst96pnweH17WarW79Xr9ADLeAynESApoVJn2MeWORegc8AoAHqGmQMlIwx5onIHmbfLYbQY8hdJAr9e7A3/Kw2az+ZJqSh91mcduC+AJFEpgKeBVpVK5i4EHGDjAtlmwG8hThrPiJ37/D4pFF/r9/h04rVDJCQC+IUBkGz4fWyyWTVh/T6/XFwuFwg9iRY4+V6G7Nw4PD6Ng7CQN5LEbMnw3HA7v9Xq9t2C3m7QT6ENaIJVK16HTI1zKkAbOHX0s2YOqhWzZWq1G/qzpKcVSgcZ41cmPwTN7SPwVYAArcoAyG20N/QAAAABJRU5ErkJggg==') no-repeat center center / 100%;
    content: " ";
}
.manageDataButton {
    background: #0000ff;
    color: #fff !important;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: -5px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.tabSelectionLabel h2 {
    font-size: 18px;
    text-align: center;
}
.tabSelectionLabel {
    padding: 15px;
    border-radius: 5px;
    box-shadow: rgb(0 0 0 / 30%) 0 0 5px;
    border: 1px solid #bbb;
    background: #fff;
    cursor: pointer;
}
.tabSelectionActionButton {
    text-align: center;
    padding: 20px 15px;
}
.tabSelectionActionButton i {
    font-size: 45px;
    width: 50px;
    height: 50px;
    display: inline-block;
}

.highlighed-field td {
    padding: 7px 10px 7px 10px !important;
    position: relative;
    left: -5px;
    border-radius: 5px;
}
.highlighed-field td,
.highlighed-field td strong {
    color: #fff !important;
}

.highlighed-field td:first-child {
    border-radius: 5px 0 0 5px;
}

.highlighed-field td:last-child {
    border-radius: 0 5px 5px 0;
}


/** ------ Table Layouts ------ **/

.card-list-outer {
    display:table;
}
.card-list-outer tbody {
    display:table-row-group;
}
.card-list-outer tbody tr {
    display:table-row;
}
.card-list-outer tbody tr td {
    display:table-cell;
}
.card-list-outer .entity-banner {
    width: 75px;
    height: 75px;
    display: inline-block;
}
.tableGridLayout .card-list-outer {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.tableGridLayout .card-list-outer thead {
    display:none;
}
.tableGridLayout .card-list-outer tbody {
    display:flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.tableGridLayout .card-list-outer tbody tr {
    cursor: pointer !important;
    flex-direction: column;
    display: flex;
    flex: auto;
    margin: 10px;
    box-shadow: rgba(0,0,0,.4) 0 0 7px;
    position: relative;
}
.tableGridLayout .card-list-outer tbody tr td {
    display:flex;
    justify-content: center;
    padding: 6px 15px;
}
.tableGridLayout .card-list-outer .entity-banner {
    width: 200px;
    height: 200px;
    box-shadow: rgba(0,0,0,.4) 0 0 5px;
}
.tableGridLayout .statusColumn span {
    transform: inherit;
    width: 100%;
}
.tableGridLayout .editEntityButton {
    position: absolute;
    left: 10px;
    top: 10px;
}
.tableGridLayout .deleteEntityButton {
    position: absolute;
    right: 10px;
    top: 10px;
}


/** ------ Utilities ------ **/

[v-cloak] { display: none; }

.divTable {
    display:table;
    width:100%;
}
.divHeader {
    width:100%;
    display: table-header-group;
    vertical-align: middle;
    border-color: inherit;
}
.divTBody {
    width:100%;
    display: table-row-group;
    vertical-align: middle;
    border-color: inherit;
}
.divRow {
    display:table-row;
    width:100%;
    clear:both;
    vertical-align:top;
}
.divCell {
    display:table-cell;
    width:auto;
    vertical-align:top;
}

.width100 {
    width: 100%;
}
.width75 {
    width: 75%;
    float:left;
}
.width50 {
    width: 50%;
    float:left;
}
.width33 {
    width: 33%;
    float:left;
}
.width25 {
    width: 25%;
    float:left;
}
.width20 {
    width: 20%;
    float:left;
}

.width50px {width: 50px; float:left;}
.width100px {width: 100px;float:left;}
.width125px {width: 125px;float:left;}
.width150px {width: 150px;float:left;}
.width175px {width: 175px;float:left;}
.width250px {width: 250px;float:left;}
.width300px {width: 300px;float:left;}
.widthAutoTo175px {width: calc(100% - 175px);float:left;}
.widthAutoTo250px {width: calc(100% - 250px);float:left;}

body .handle {
    width: 1em;
    height: 1em;
    background-repeat: no-repeat;
    background-size: contain;
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHMAAABkCAMAAACCTv/3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRFAAAA5ubmSUUG+gAAAAJ0Uk5T/wDltzBKAAAAPklEQVR42uzYQQ0AAAgDseHfNC4IyVoD912WAACUm3uampqampqamq+aAAD+IVtTU1NTU1NT0z8EAFBsBRgAX+kR+Qam138AAAAASUVORK5CYII=);
    display: inline-block;
    top: .2em;
    position: relative;
}

.swapConnection .selected-connection {
    position: absolute;
    top: calc(50% - 15px);
    left: 6px;
    padding: 3px 30px 3px 8px;
    background: #eee;
    border: 1px solid #ccc;
}

.processWorkflow .width100.entityDetails, .entityDashboard .width100.entityDetails {
    padding-top: 15px;
}

.theme_shade_light .entityTab .width100.entityDetails {
    background: linear-gradient(to left, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
}
.theme_shade_dark .entityTab .width100.entityDetails {
    background: linear-gradient(to left, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
}

.pointer {
    cursor:pointer;
}

/** SCROLL BAR **/
.vueAppWrapper ::-webkit-scrollbar {
    width: 8px;
}
.vueAppWrapper ::-webkit-scrollbar-track {
    background: transparent;
}
.vueAppWrapper ::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius:5px;
}
.vueAppWrapper ::-webkit-scrollbar-thumb:hover {
    background-color: #bbb;
}
.vueAppWrapper navigation::-webkit-scrollbar {
    width: 5px;
}
.vueAppWrapper navigation::-webkit-scrollbar-thumb {
    background-color: #eee;
    border-radius:5px;
}
.vueAppWrapper navigation::-webkit-scrollbar-thumb:hover {
    background-color: #ddd;
}

/** VALIDATIONS **/
.pass-validation {
    border:2px solid #00b90e;
    box-shadow: #00b90e 0 0 5px;
}
.error-validation {
    border:2px solid #ff0000;
    box-shadow: #ff0000 0 0 5px;
}
.error-text {
    font-size: 12px;
    color: #cc0000 !important;
}
body .slickDraggingItem {
    background:#fff;
    box-shadow: rgba(0,0,0,.5) 0 0 5px;
    position:absolute !important;
    z-index: 1000;
    display:table-row;
}

body .slickDraggingWrapper {
    transform: rotate(3deg) !important;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

body .slickDraggingItem td, body .slickDraggingItem th {
    padding: .75rem;
}

body .slickDraggingItem td.text-right {
    position: absolute;
    right: 0;
    top: 0;
}

@media (max-width:1300px) {
    navigation {
        width: 85px;
    }
    .portal-body {
        margin-left: 85px;
    }
    #dropdownMenuButton > span:nth-child(2),
    .nav-dashboard .dropdown-toggle::after,
    .nav-box-card > ul > li > a > span:nth-child(2) {
        display:none;
    }
    .nav-box-card > ul {
        padding-left: 0;
    }
    #dropdownMenuButton > span:first-child,
    .nav-box-card > h5,
    .nav-box-card > ul > li > a > span:first-child {
        text-align: center;
    }
    .portalLogo {
        width: 55px;
    }
    header.portal-header {
        width: calc(100% - 135px);
        z-index: 15;
    }
    .dashboard-tab span:last-child {
        display:none;
    }
    .account-page-title {
        font-size: 1.3rem;
    }
    .account-page-title #back-to-entity-list {
        position: relative;
        top: 4px;
    }
}

@media (min-width:750px) {
    .desktop-hide { display:none; }
    .desktop-200px { width:200px; }
    .desktop-175px { width:175px; }
    .desktop-150px { width:150px; }
    .desktop-125px { width:125px; }
    .desktop-120px { width:120px; }
    .desktop-115px { width:115px; }
    .desktop-100px { width:100px; }
    .desktop-90px { width:90px; }
    .desktop-80px { width:80px; }
    .desktop-70px { width:70px; }
    .desktop-50px { width:50px; }
    .desktop-40px { width:40px; }
    .desktop-35px { width:35px; }
    .desktop-30px { width:30px; }
    .desktop-25px { width:25px; }
    .desktop-20px { width:20px; }
    .desktop-15px { width:15px; }
    .desktop-10px { width:10px; }

    .desktop-padding-right-35px { padding-right:35px; }
    .desktop-padding-right-30px { padding-right:30px; }
    .desktop-padding-right-25px { padding-right:25px; }
    .desktop-padding-right-20px { padding-right:20px; }
    .desktop-padding-right-15px { padding-right:15px; }
    .desktop-padding-right-10px { padding-right:10px; }

    .desktop-padding-left-35px { padding-left:35px; }
    .desktop-padding-left-30px { padding-left:30px; }
    .desktop-padding-left-25px { padding-left:25px; }
    .desktop-padding-left-20px { padding-left:20px; }
    .desktop-padding-left-15px { padding-left:15px; }
    .desktop-padding-left-10px { padding-left:10px; }
}

@media (max-width:750px) {

    navigation {
        width: 100%;
        bottom: 0;
        height: 65px;
        top: auto;
    }
    .portal-body {
        margin-left: 0;
        padding: 0;
    }
    header.portal-header {
        width: 100%;
        border-radius: 0;
        z-index: 15;
        display:flex !important;
    }
    header.portal-header .divRow {
        width: 100% !important;
        display:flex !important;
    }
    header.portal-header .divCell {
        display:flex !important;
    }
    div.portal-section {
        margin-top: 63px;
        height: 100%;
        padding: 0 0 0 0;
    }
    .width50 .card-tile-50 {
        width: 100% !important;
        margin-left: 0px !important;
        margin-bottom:10px !important;
    }
    .width100 .card-tile-100 {
        width: 100% !important;
        margin-left: 0px !important;
        margin-bottom:10px !important;
    }
    .entityDashboard .width50:last-child .card-tile-50 {
        margin-bottom:0px !important;
    }
    .dashboard-tab-display.mobile-to-table {
        margin-top:10px;
    }
    .mobile-text-center {
        text-align: center;
    }
    .mobile-to-block {
        display:block;
        width:100%;
    }
    .mobile-to-table {
        display:flex;
        flex-direction: row;
        justify-content: space-between;
        width:100%;
    }
    .mobile-hide { display:none; }
    .mobile-to-100 { width:100% !important; max-width: 100% !important; }
    .mobile-to-75 { width:75% !important; max-width: 100% !important; }
    .mobile-to-85 { width:85% !important; max-width: 100% !important; }
    .mobile-to-90 { width:90% !important; max-width: 100% !important; }
    .mobile-to-95 { width:95% !important; max-width: 100% !important; }
    .mobile-to-heightAuto { height:auto; }
    .mobile-margin-top-15 { margin-top:15px; }
    .mobile-padding-bottom-15 { padding-bottom:15px; }

    .mobile-vertical-margins-15 {
        margin-top:15px !important;
        margin-bottom:15px !important;
    }
    .mobile-center {
        margin-left:auto !important;
        margin-right:auto !important;
    }
    .dashboard-tab.active {
        margin-left: 0;
    }
    .dashboard-tab {
        display:flex;
        width: 100%;
        text-align: center;
        border-radius:0px !important;
        justify-content: center;
        margin: 0;
    }
    .dashboard-tab:first-child {
        border-left: 0px;
    }
    .dashboard-tab:last-child {
        border-right: 0px;
    }
    .fas span {
        display: none;
    }
    .account-page-title {
        font-size: 1.1rem;
    }
    .back-to-entity-list {
        top:5px;
    }
}

@media (min-width:751px) {
    body .showOnMobile {
        display:none !important;
    }
}
@media (max-width:750px) {
    .width50 {
        width: 100%;
        float: none;
        clear: both;
    }
    .right-float-menu-outer .desktop-account-access {
        display:none;
    }
    .breadCrumbHomeImage {
        width: 19px;
        height: 19px;
        top: -2px;
        position: relative;
    }
    header.portal-header {
        padding: 11px 10px 11px 15px;
    }
    .right-float-menu > ul > li:first-child {
        display:none;
    }
    .portalLogo {
        width: 45px;
        height: 45px;
        margin-bottom: -13px;
        margin-top: -6px;
    }
    .portal-header .divRow .divCell:first-child {
        width: calc(50% - 25px);
    }
    .portal-header .divRow .divCell:last-child {
        width: calc(50% - 25px);
        justify-content: flex-end;
    }
    header.portal-header {
        margin-left: 0 !important;
    }
    .BodyContentOuter {
        padding: 0 0;
    }
    .right-float-menu-outer {
        white-space:nowrap;
        top: 4px;
        position: relative;
    }
    body .hideOnMobile {
        display:none !important;
    }
    .breadCrumbsInner li > * {
        font-size: 16px;
    }
    .homeBreadcrumb {
        top: 0;
    }
    .breadCrumbs {
        top: 3px;
        position: relative;
    }
    .bottomMenuBar ul {
        display:flex;
        flex-direction: row;
        justify-content: space-around;
    }
    .bottomMenuBar ul li {
        display:flex;
    }
    .bottomMenuBar ul li span {
        font-size: 33px;
        top: 4px;
        position: relative;

    }
    .theme_shade_light .bottomMenuBar ul li span {
        color: #000;
    }
    .theme_shade_dark .bottomMenuBar ul li span {
        color: #fff;
    }
    navigation {
        overflow-y: hidden;
    }
    .main-user-avatar {
        width: 43px;
    }
    .tableGridLayout .card-list-outer .entity-banner {
        width: 150px;
        height: 150px;
        box-shadow: rgba(0,0,0,.4) 0 0 5px;
    }
    .entity-list-header-wrapper > tbody > tr > td:first-child,
    .entity-list-header-wrapper > tbody > tr > td:last-child {
        display:flex;
    }
    .fformwrapper-header .form-search-box,
    .entity-list-header-wrapper > tbody > tr > td table {
        display:flex;
        width:100%;
        max-width:100%;
    }
    .entity-list-header-wrapper > tbody > tr > td table tr {
        display:flex;
        width: 100%;
        justify-content: center;
    }
    .entity-list-header-wrapper > tbody > tr > td table tr td {
        display:flex;
        width: 100%;
    }
    .entity-list-header-wrapper > tbody > tr > td table tr td * {
        width: 100% !important;
    }
    .entity-list-header-wrapper > tbody > tr > td:last-child {
        display:flex;
        width: 100%;
        justify-content: center;
    }
    .NotificationModal {
        right: 39px;
        min-width: 280px;
        top: 54px;
    }

    .dashboardWidgetsBox ul > li > div > div.showcaseTitle {
        font-size: 15px !important;
        margin-left: 115px !important;
        padding-bottom: 35px !important;
    }
    .dashboardWidgetsBox ul > li > div > div.showcaseTitle > span.showcaseTitleValue {
        font-size: 25px !important;
        line-height: 25px !important;
    }
    .dashboardWidgetsBox ul > li > div > span.showcaseIcon {
        width: 85px !important;
        height: 85px !important;
        line-height: 85px !important;
        font-size: 45px !important;
    }
    .dashboardWidgetsBox div.showcaseBody table tr > td {
        color: #fff !important;
        font-size: 11px !important;
    }
    .dashboardWidgetsBox div.showcaseBody table tr > td:first-child {
        width: 115px !important;
    }
}
@media (max-width:550px) {
    .dashboardWidgetsBox ul > li > div > div.showcaseTitle {
        font-size: 10px !important;
        margin-left: 80px !important;
        padding-bottom: 15px !important;
    }
    .dashboardWidgetsBox ul > li > div > div.showcaseTitle > span.showcaseTitleValue {
        font-size: 20px !important;
        line-height: 20px !important;
    }
    .dashboardWidgetsBox ul > li > div > span.showcaseIcon {
        width: 55px !important;
        height: 65px !important;
        line-height: 65px !important;
        font-size: 30px !important;
        left: 11px !important;
    }
    .dashboardWidgetsBox div.showcaseBody table tr > td {
        color: #fff !important;
        font-size: 11px !important;
    }
    .dashboardWidgetsBox div.showcaseBody table tr > td:first-child {
        width: 80px !important;
    }
    .fformwrapper-header .header-table > tbody > tr > td {
        display:block;
        width:100%;
    }
    .fformwrapper-header .header-table > tbody > tr > td:last-child {
        margin-top: 15px;
    }
    .fformwrapper-header .header-table > tbody > tr > td:last-child > .page-count-display-data {
        float:left;
    }
    .fformwrapper-header .header-table > tbody > tr > td > .form-search-box {
        display:block;
    }
    .fformwrapper-header .header-table > tbody > tr > td > .form-search-box > table,
    .fformwrapper-header .header-table > tbody > tr > td > .form-search-box > table > tr > td:first-child,
    .fformwrapper-header .header-table > tbody > tr > td > .form-search-box > table > tr > td:first-child input {
        width:100%;
    }
    .entityListOuter .entityList > thead > th,
    .entityListOuter .entityList > thead > th a {
        font-size: 12px !important;
    }
}
@media (max-width:1300px) {
    .tableGridLayout .card-list-outer tbody tr td:nth-child(5) {
        font-size:2.5vw !important;
    }
    .tableGridLayout .card-list-outer tbody tr td:nth-child(4) {
        font-size:1.8vw !important;
    }
}
@media (max-width:750px) {
    .tableGridLayout .card-list-outer tbody tr td:nth-child(5) {
        font-size:3.25vw !important;
    }
    .tableGridLayout .card-list-outer tbody tr td:nth-child(4) {
        font-size:2.25vw !important;
    }
}
@media (max-width:550px) {
    .tableGridLayout .card-list-outer tbody tr td:nth-child(5) {
        font-size:5vw !important;
    }
    .tableGridLayout .card-list-outer tbody tr td:nth-child(4) {
        font-size:3vw !important;
    }
    .tableGridLayout .card-list-outer tbody tr {
        margin: 5px;
        width: 40vw;
    }
}

/**---- Custom Icons */

.tab-type-icon-1, .tab-type-icon-2, .tab-type-icon-3, .tab-type-icon-4 {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
.tab-type-icon-1::before {
    content: "\f15c";
}
.tab-type-icon-2::before {
    content: "\f013";
}
.tab-type-icon-3::before {
    content: "\f15c";
}
.tab-type-icon-4::before {
    content: "\f009";
}

/**---- Custom Themes */


.theme_shade_light .card-tile-price {
    color: #<?php echo $portalThemeMainColor; ?> !important;
}
.theme_shade_dark .card-tile-price {
    color: #fff !important;
}