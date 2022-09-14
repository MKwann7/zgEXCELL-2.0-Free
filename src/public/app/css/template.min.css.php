<?php

header('Content-Type:text/css');

$portalLogoDark = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_logo_dark")->value ?? "/website/logos/logo-dark.svg";
$portalLogoLight = $this->app->objCustomPlatform->getCompanySettings()->FindEntityByValue("label","portal_logo_light")->value ?? "/website/logos/logo-light.svg";

?>
@import url('https://fonts.googleapis.com/css2?family=Saira&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Ramaraja&display=swap');

.theme_shade_dark .portalLogo {
    background: url(<?php echo $portalLogoDark; ?>) no-repeat center center / 100% auto;
}
.portalLogo {
    background: url(<?php echo $portalLogoLight; ?>) no-repeat center center / 100% auto;
}

.app-wrapper:not(.app-in-editor) {
    width: 100vw;
    height: 100vh;
    height: -webkit-fill-available;
    position: fixed;
    display: flex;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
    overflow-y: auto;
    justify-content: center;
    align-items: center;
}
.app-template-4 .app-wrapper:not(.app-in-editor) {
    width: 100vw;
    height: 100vh;
    height: -webkit-fill-available;
    position: fixed;
    display: block;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
    overflow-y: auto;
}
.theme_shade_light {
    background: #ccc;
}
.theme_shade_light.app-template-4 {
    background: #fff;
}
.app-wrapper-inner {
    display: flex;
    flex-direction: column;
    max-height: 100vh;
    max-height: -webkit-fill-available;
}
.app-card {
    /*width: 500px;*/
    display: block;
    /*height: 890px;*/
    position: relative;
}
.app-main-comp-header {
    display: flex;
    width: 100%;
    position: relative;
}
.app-template-2 .app-main-comp-header,
.app-template-3 .app-main-comp-header {
    height: 305px;
    background: #ccc;
}

.app-main-comp-portal-header {
    display: flex;
    width: 100%;
    height: 100px;
    background: #ccc;
    position: relative;
}
.app-main-comp-portal-footer {
    display: flex;
    width: 100%;
    height: 250px;
    background: #ccc;
    position: relative;
}
.app-main-comp-footer-menu {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
}
.app-main-comp-footer-menu li {
    display: flex;
    width: 100%;
    height: 100%;
    align-items: center;
    justify-content: center;
    list-style-type: none;
    padding: 10px;
    font-size: 16px;
    cursor: pointer;
}
.app-main-comp-footer-menu li > span {
    width: 65px;
    text-align: center;
    margin-top: 5px;
}
.app-main-comp-footer-menu li span span {
    width: 65px;
    display: inline-block;
    font-size: 28px;
}
.app-main-comp-header-logo {
    width: 85px;
    height: 125px;
    position:absolute;
}
.theme_shade_light .app-main-comp-header-logo {
    background-color: #c4c4c4;
    box-shadow: rgba(0,0,0,.3) 0 0 8px;
}
.handed-left .app-main-comp-header-logo {
    right:30px;
}
.handed-right .app-main-comp-header-logo {
    left:30px;
}
.app-main-comp-header-logo-image {
    width: 70px;
    height: 83px;
    margin: 35px auto 0;
}
.app-main-comp-footer {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 75px;
}
.vue-app-body {
    overflow:hidden;
}
.app-template-2 .app-page-content {
    overflow-y: auto;
    height: 830px;
}
.management-hub .app-template-2 .app-page-content {
    overflow-y: auto;
    height: 747px;
}
.app-section {
    overflow-x: hidden;
    position: relative;
}
.app-template-2 .app-kabob-float,
.app-template-3 .app-kabob-float {
    position: absolute;
    top: 124px;
    height: 725px;
    width: 250px;
    background: #fff;
    border: 1px solid #ccc;
}
.app-kabob {
    position: absolute;
    top: 0;
    width: 80px;
    height: 80px;
    cursor: pointer;
}
.app-kabob-handle {
    height: 80px;
    width: 30px;
    background: #fff;
    padding: 9px 7px;
    box-shadow: rgba(0,0,0,.2) 0 0 5px;
}
.app-kabob .app-kabab-circle {
    background: #ff0000;
    border-radius: 50%;
    width: 15px;
    height: 15px;
    display: block;
    margin-bottom: 8px;
}
.app-kabob-float.active {
    box-shadow: rgba(0,0,0,.2) 0 0 5px;
}
.app-kabob-float.active .app-kabob {
    display: none;
}
.handed-left .app-kabob-float {
    left: -250px;
    transition: left 0.2s ease-in-out 0s;
    border-right: 0;
    border-radius: 0 5px 5px 0;
}
.handed-right .app-kabob-float {
    right: -250px;
    transition: right 0.2s ease-in-out 0s;
    border-left: 0;
    border-radius: 5px 0 0 5px;
}
.handed-left .app-kabob {
    right: -80px;
}
.handed-right .app-kabob {
    left: -80px;
}
.handed-left .app-kabob-handle {
    border-radius: 0 10px 10px 0;
    left: 0;
    position: absolute;
}
.handed-right .app-kabob-handle {
    border-radius: 10px 0 0 10px;
    right: 0;
    position: absolute;
}
.handed-left .app-kabob-float.active {
    left: 0;
}
.handed-right .app-kabob-float.active {
    right: 0;
}
.app-kabob-hide,
.app-modal-hide {
    background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAUCAYAAABiS3YzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAqxJREFUeNqclFuLUlEUx885ozOlMQ7eLw++iJGX1wyCqZgIsnrwhoIEYZc3YSrqCxR9AZ/mRbzV5PQkBH2DHuzBSyWa0oNRUInXQcd0tLVlb9vqcYQ2LM45++z9O2v91/9shpkdLPN/g+V74HCg5zHEKBgMjlaRQqHQwj4UZIKTy+UbTqfzLNxvQAjxhlVAIVrvcrnO4fsJbw1DBR6P55pCoXiu0+kqxWLxN/pyOp0e22y28QnA0z6f75JarX5hNBor+Xz+G8qUQLlcLvfdarVuyWSy+xqNplIqlX7xgWkgJLKtUqmedjqd17FY7B3MDRGUaIrg62hhIBB4IBaLr1er1WepVOoDzB1BDLBmLA2EDJ+02+1kNBp9BXNdiD8kUzKQyONMJvPRbDZLQIq7dMZ4jWAJsIc/PCIZMtBpBsok4FE2m83PgWsYeMrtdm/D3DwQZXjMUGUzoNkkloEhvpbL5bbD4bgIjXzcarX2QcN9PuAMlFwp8BjAn0wm0xaUesdgMJyB6+1Go5GMx+NJoiFUeYz3TMeCF2ERMTHSaBCJRBLdbvczuOIWZPg+kUik8Lsh0XB+cCf8dqiKNSj5vEgksvb7/S8SieSC3W4343fcst96pnweH17WarW79Xr9ADLeAynESApoVJn2MeWORegc8AoAHqGmQMlIwx5onIHmbfLYbQY8hdJAr9e7A3/Kw2az+ZJqSh91mcduC+AJFEpgKeBVpVK5i4EHGDjAtlmwG8hThrPiJ37/D4pFF/r9/h04rVDJCQC+IUBkGz4fWyyWTVh/T6/XFwuFwg9iRY4+V6G7Nw4PD6Ng7CQN5LEbMnw3HA7v9Xq9t2C3m7QT6ENaIJVK16HTI1zKkAbOHX0s2YOqhWzZWq1G/qzpKcVSgcZ41cmPwTN7SPwVYAArcoAyG20N/QAAAABJRU5ErkJggg==) no-repeat center center / 100%;
    height: 18px;
    width: 18px;
    position: absolute;
    top: 15px;
    cursor: pointer;
}
.app-kabob-footer {
    position: absolute;
    bottom: 0;
    width: 100%;
}
.app-kabob-footer div,
.app-kabob-footer table {
    width: 100%;
    text-align: center;
}
.handed-left .app-kabob-hide {
    right: 15px;
}
.handed-right .app-kabob-hide {
    left: 15px;
}
.handed-right .app-modal-hide {
    right: 15px;
}
.handed-left .app-modal-hide {
    left: 15px;
}
.app-kabob-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: #ff0000;
    display: block;
    margin: 25px auto;
}
.app-kabob-user-name {
    text-align: center;
    display: block;
    font-family: Saira;
    font-size: 20px;
    font-weight: 600;
    color: #ff0000;
}
.app-kabob-menu {
    display: flex;
    flex-direction: row;
    padding: 0 15px 0 15px;
    margin: 20px 0 0 0;
    flex-wrap: wrap;
}
.app-kabob-menu li {
    display: flex;
    padding: 10px;
    cursor: pointer;
    list-style-type: none;
    font-size: 18px;
    align-items: baseline;
}
.app-kabob-menu li > span {
    width: 89px;
    text-align: center;
}
.app-kabob-menu li span span {
    width: 65px;
    display: inline-block;
    font-size: 35px;
}
.app-main-comp-footer div {
    display: flex;
}
.app-main-comp-nav,
.app-main-comp-body {
    display: flex;
}
.app-template-4 .app-main-comp-nav-inner {
    display: flex;
    margin: auto;
}
.app-main-comp-nav-inner li {
    list-style-type: none;
}
.app-template-4 .app-main-comp-nav-inner > ul,
.app-template-4 .app-main-comp-nav-inner > span.toggle_menu {
    flex-direction: row;
}
.app-template-4 .app-main-comp-nav-inner ul {
    flex: 3;
}
.app-template-4 .app-main-comp-nav-inner li {
    padding: 10px 15px;
    cursor: pointer;
}
.displayDirectory {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.displayDirectory {
    display: flex;
    flex-direction: column;
    text-align: center;
}
.displayDirectoryInner {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}
.displayDirectoryItem {
    cursor: pointer !important;
    flex-direction: column;
    display: flex;
    flex: auto;
    margin: 10px;
    position: relative;
    max-width: 48%;
    -webkit-transition: -webkit-transform .1s ease-in-out;
    -moz-transition: -moz-transform .1s ease-in-out;
    -o-transition: -o-transform .1s ease-in-out;
    transition: transform .1s ease-in-out;
    align-items: center;
}
@media (max-width:950px) {
    .displayDirectoryItem {
        max-width: 100%;
    }
    .row {
        margin-right: 0;
        margin-left: 0;
    }
    .app-main-comp-body .column {
        float: left;
        padding-left: .75rem; /* beta3 */
        padding-right: .75rem; /* beta3 */
    }
}
.displayDirectoryItem:hover {
    -webkit-transform: scale(1.05);
    -moz-transform: scale(1.05);
    -o-transform: scale(1.05);
    transform: scale(1.05);
}
.displayDirectoryAvatar {

}
.app-template-4 .app-main-comp-nav-inner .nav-search {
    display: flex;
    justify-content: flex-end;
    flex: 1;
    align-content: center;
    align-items: center;
}
.handed-left .app-main-comp-body {
    flex-direction: row;
}
.handed-right .app-main-comp-body {
    flex-direction: row-reverse;
}
.app-template-2 .app-main-comp-nav,
.app-template-3 .app-main-comp-nav {
    display: flex;
    width: 25%;
    flex-direction: row;
    padding: 10px 0;
}
.app-template-2 .app-main-comp-pages,
.app-template-3 .app-main-comp-pages {
    display: flex;
    width: 75%;
    flex-direction: row;
    max-height: 510px;
    overflow-y: auto;
    padding: 10px 0;
}
.management-hub .app-main-comp-pages {
    max-height: 420px;
}
.handed-left .app-main-comp-pages {
    padding-right: 30px;
    direction: ltr;
}
.handed-right .app-main-comp-pages {
    padding-left: 30px;
    direction: rtl;
}
.handed-right .app-main-comp-pages * {
    direction: ltr;
}
.app-main-comp-nav ul,
.app-main-comp-pages ul {
    width:100%;
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
}
.app-template-2 .app-main-comp-nav ul li,
.app-template-3 .app-main-comp-nav ul li{
    display: flex;
    align-items: center;
    min-height: 98px;
    height: 98px;
    width: 100%;
    justify-content: center;
}
.management-hub .app-main-comp-nav ul li,
.management-hub .app-main-comp-pages ul li {
    display: flex;
    align-items: center;
    min-height: 80px;
    height: 80px;
    width: 100%;
    justify-content: center;
}

.app-main-comp-nav ul li span.app-main-comp-nav-item {
    padding: 10px;
    border-radius: 50%;
    width: 60px;
    text-align: center;
    cursor: pointer;
    height: 60px;
    font-size: 35px;
}
.app-main-comp-nav ul li span.app-main-comp-nav-item span {
    top: 2px;
    position: relative;
}
.theme_shade_light .app-main-comp-nav ul li span.app-main-comp-nav-item,
.theme_shade_light .app-main-comp-pages ul li span.app-main-comp-page-item,
.theme_shade_light .app-main-comp-footer {
    font-family: Saira;
}
.app-template-2 .app-main-comp-pages ul li span.app-main-comp-page-item {
    padding: 12px 25px;
    border-radius: 25px;
    width: 100%;
    font-size: 18px;
    cursor: pointer;
    font-weight: 600;
}
.app-modal-horz-list {
    margin:0;
    padding:0 10px;
    display: flex;
    flex-direction: row;
    justify-content: center;
}
.app-modal-horz-list li {
    display: flex;
    width: 88px;
    background: #99accd;
    color: #fff;
    padding: 8px;
    justify-content: center;
    margin: 0 5px;
    border-radius: 5px;
    cursor: pointer;
}
.app-modal-emphasisc {
    font-family: Saira;
    font-weight: 800;
    font-size: 25px;
    text-align: center;
    padding: 30px 15px 15px;
}
.app-modal-emphasisc-sub {
    text-align: center;
    margin-top: -23px;
    position: relative;
    padding-bottom: 30px;
}
.app-modal-body {
    padding-bottom: 35px;
}
.app-modal-float {
    position: fixed;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
    width: 100vw;
    height: 100vh;
    height: -webkit-fill-available;
    z-index:10000;
    overflow-y: auto;
    justify-content: center;
    align-items: center;
    opacity: 0;
    display: flex;
    pointer-events: none;
    transition: opacity .2s ease-in-out 0s;
    background: rgba(255,255,255,.4);
}
.app-modal-float.active {
    opacity: 1;
    pointer-events: all;
}
.app-modal {
    display: flex;
    flex-direction: column;
    max-height: 100vh;
    max-height: -webkit-fill-available;
    background: transparent;
    max-width:500px;
    min-width:500px;
}
.app-modal-box {
    width: calc(100% - 30px);
    min-height:150px;
    background:#fff;
    border-radius: 10px;
    box-shadow: rgba(0,0,0,.2) 0 0  10px;
    position: relative;
    opacity: 0;
    transition: opacity .2s ease-in-out, scale .2s ease-in-out;
    transform: scale(1.2);
    margin: auto;
}
.vue-float-shield {
    opacity: 1;
    pointer-events: all;
}
.vue-float-shield.hidden {
    transition: all .2s ease-in-out;
    transform: scale(.8);
    opacity: 0;
    pointer-events: none;
}
.floating-blocks {
    display: flex;
    flex-direction: row;
    height: 100%;
    align-items: baseline;
}
.floating-blocks-inner {
    display: flex;
    padding: 15px;
    background: rgba(90,90,90,.6);
    width: 70%;
    color: #fff;
    flex-direction: column;
    align-items: center;
    margin: auto auto 35% auto;
    border: 3px solid #fff;
}
.floating-blocks .floating-blocks-inner div {
    font-family: Saira;
}
.floating-blocks div div:first-child {
    font-family: Ramaraja;
    font-size: 35px;
    margin-bottom: -13px;
    color: #dae8ff;
}
.floating-blocks div div:last-child {
    text-transform: uppercase;
}
.app-modal-float.active .app-modal-box {
    opacity: 1;
    transform: scale(1);
}
body.theme_shade_light div.universal-float-shield {
    background: url(/website/images/LoadingIcon2.gif) no-repeat left 50% center / auto 35px,rgba(255,255,255,.4) ;
}
.zgpopup-dialog-box {
    border-radius: 0px;
    max-width: calc(100vw - 50px);
    min-width: 250px;
}
.zgpopup-dialog-box {
    transition: all 0.1s ease-in-out 0s;
    transform: scale(1.3);
    visibility: hidden;
    opacity: 0;
}
.activeModal .zgpopup-dialog-box {
    transform: scale(1) !important;
    visibility: visible !important;
    opacity: 1 !important;
    transition: all 0.2s ease-in-out 0s;
}
.theme_shade_light .zgpopup-dialog-box {
    background: #ffffff;
    background: linear-gradient(to bottom, #fff 0%, #eaeaea 100%);
    box-shadow: 0 0 10px #000000;
}
.app-page-title {
    font-family: Saira;
    font-size: 27px;
    padding: 4px 0;
    overflow: hidden;
}
.app-page-editor-text-transparent:focus,
.app-page-editor-text-transparent:focus-visible,
.app-page-editor-text-transparent:active,
.app-page-editor-text-transparent {
    white-space: nowrap;
    border:0 !important;
    outline: -webkit-focus-ring-color auto 0;
    box-shadow: transparent 0 0 0 !important;
    background: transparent !important;
}
body #divSnippetList {
    top: 112px !important;
    height: calc( 100% - 112px) !important;
}
.app-page-title:hover,
.app-page-title:active,
.app-page-title:focus-visible,
.app-page-title:focus {
    border:0 !important;
    outline: -webkit-focus-ring-color auto 0;
}
.back-to-entity-list:not(.app-in-editor) {
    border-width: 0 4px 4px 0 !important;
    display: inline-block;
    padding: 4px;
    border: solid #ff0000;
    transform: rotate(135deg);
    margin-left: 15px;
    margin-right: 3px;
    top: -2px;
    position: relative;
}
.app-modal-title {
    font-family: Saira;
    font-size: 40px;
    text-align: center;
    margin-top: 15px;
}
.app-modal-subtitle {
    font-family: Saira;
    font-size: 25px;
    text-align: center;
    padding-bottom: 15px;
}
.app-modal-qr {
    padding: 0 65px;
    text-align: center;
    margin-top: -10px;
}
.learnMoreAboutShareSave {
    position:relative;
    top:2px;
}
.pointer {
    cursor:pointer;
}

/** MODULES APP **/
.app-template-4 .app-main-comp-header,
.app-template-6 .app-main-comp-header {
    display:block;
}
.app-template-4 .app-main-comp-header-inner,
.app-template-6 .app-main-comp-header-inner {
    display:flex;
    margin:auto;
    width:100%;
    flex-direction: column;
    align-items: center;
}
.app-template-4 .app-main-comp-body-inner,
.app-template-6 .app-main-comp-body-inner {
    margin:auto;
    width:100%;
    display:block;
}
.app-template-4 .app-page-title {
    color: #000 !important;
    text-transform: uppercase;
}
.app-template-4 .app-main-comp-nav,
.app-template-4 .app-main-comp-page-title,
.app-template-4 .app-main-comp-body,
.app-template-6 .app-main-comp-nav,
.app-template-6 .app-main-comp-page-title,
.app-template-6 .app-main-comp-body {
    display: block;
}
.app-template-4 .floatRightHeader,
.app-template-4 .mainImageLeftHeader,
.app-template-6 .floatRightHeader,
.app-template-6 .mainImageLeftHeader {
    display:flex;
}
.app-template-4 .mainImageLeftHeader {
    left: 20px;
}
.app-template-4 .floatRightHeader,
.app-template-6 .floatRightHeader {
    display:flex;
    flex: 1 1 calc(100% - 230px);
    flex-direction: column;
}
.app-template-4 .app-main-comp-header-flex,
.app-template-6 .app-main-comp-header-flex {
    display:flex;
    flex: 1 1 auto;
    align-items: center;
    width: 100%;
}
.app-template-4 .mainImageHandler {
    width:auto;
    height:85px;
    background:#c02c34 !important;
}
.app-template-4 .topSocialMedia {
    display:flex;
    flex-direction: row;
    align-items:start;
    width:100%;
}
.app-template-4 .topSocialMedia li {
    padding:5px;
}
.app-template-4 .headerConnections {
    display:flex;
    flex-direction: row;
    align-items: center;
    width:100%;
}
.app-template-4 .headerConnections li {
    display:flex;
    flex: 1 1 auto;
    padding:10px 15px;
    color: #fff;
}
.app-template-4 .app-main-comp-page-item {
    cursor:pointer;
    color: #fff !important;
    font-weight:bold;
}
.app-template-4 .app-main-comp-nav-item {
    cursor:pointer;
}
.app-template-4 .app-main-comp-nav-item span {
    font-size:40px;
}
.app-template-4 .connectionsContainer {
    display: block;
    width:100%;
    text-align:center;
}
.app-template-4 .app-main-comp-body {
    padding-top:35px;
}
.app-template-4 .app-main-comp-nav {
    margin: auto;
    background: linear-gradient(to right, #ffc000 0%, #fe5d4b 100%);
}
.app-template-4 .app-main-comp-page-title h2 {
    margin:0;
}
.app-template-4 .app-main-comp-page-title > .container {
    height: inherit;
    align-items: center;
    justify-content: center;
    display: flex;
}
.app-template-4 .breadcrumb-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
}
.app-template-4 .app-main-comp-page-title {
    background-position: center;
    height:225px;
    position:relative;
}
.toggle_menu span:before {
    top: -6px;
}
.toggle_menu span:after {
    top: 6px;
}
.app-template-4 .toggle_menu span, .toggle_menu span:before, .toggle_menu span:after {
    background-color: #fff;
    content: "";
    display: block;
    height: 2px;
    left: 0;
    position: absolute;
    -webkit-transition: all 0.2s ease-in-out 0s;
    transition: all 0.2s ease-in-out 0s;
    width: 24px;
}
.app-template-4 .toggle_menu span {
    left: 18px;
    margin-top: -1px;
    top: 50%;
}

.app-template-4 .app-kabob {
    top:85px;
}
.app-template-4 .breadcrumb {
    background-color: transparent;
    display: flex;
    flex: 1 1 auto;
    align-items: center;
    border-radius: 0;
    color: inherit;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 2px;
    margin: 5px auto 0;
    padding: 0;
    text-transform: uppercase;
}
.app-template-4 .breadcrumb>li+li:before {
    color: #000;
    content: "/";
    padding: 0 16px 0 16px;
}
.app-template-4 .breadcrumb>li>a {
    color: #000;
}
.app-template-4 .breadcrumb>li {
    display: flex;
    padding: 0;
    cursor: pointer;
    color: #000;
}
.app-template-4 .app-main-comp-pages {
    display: block;
    padding: 10px 0;
    position: relative;
}
.app-template-4 .app-main-comp-pages .vue-app-body-component {
    width:inherit;
}

/** COMP WRAPPER **/

.management-hub .app-hub-comp-wrapper .vue-app-body-component {
    height: calc(100vh - 95px);
}
.app-template-2 .management-hub .app-hub-comp-wrapper .vue-app-body-component {
    height: 797px;
}

/** MODULES APP **/
.modules-wrapper {
    padding-left: 0;
}
.modules-item {
    list-style-type: none;
}
.modules-item > div.modules-item-box {
    text-align: left;
    list-style-type: none;
    width: 100%;
    height: 80px;
    font-size: 24px;
    padding-left: 25px;
    padding-right: 25px;
}
.modules-item > div.modules-item-box > span {
    background: #fff;
    padding: 9px 22px 6px;
    border-radius: 38px;
    box-shadow: rgba(0,0,0,.2) 0 0 7px;
    color: #ff0000;
    border-top: 1px solid #bbb;
    display: block;
    width: 100%;
    border-right: 1px solid #bbb;
    border-left: 1px solid #bbb;
    border-bottom: 10px solid #bbb;
}

.modules-item > div.modules-item-box > span > i {
    margin-right: 10px;
}
.modules-apps-wrapper {
    display:flex;
    padding:0 25px 25px 25px;
}
.modules-wrapper-app {
    width:50%;
    height:150px;
    display:flex;
    flex-direction: column;
}
.modules-wrapper-app span {
    width: 100%;
    height: 100%;
    display: block;
}

/** SCROLL BAR **/
.app-main-comp-body ::-webkit-scrollbar,
.app-page ::-webkit-scrollbar {
    width: 8px;
}
.app-main-comp-body ::-webkit-scrollbar-track,
.app-page ::-webkit-scrollbar-track {
    background: transparent;
}
.app-main-comp-body ::-webkit-scrollbar-thumb,
.app-page ::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius:5px;
}
.app-main-comp-body ::-webkit-scrollbar-thumb:hover,
.app-page ::-webkit-scrollbar-thumb:hover {
    background-color: #bbb;
}
.app-main-comp-float {
    display: block;
    opacity: 0;
    position: absolute;
    width: calc(100% * .75);
    height: 490px;
    background: rgba(255,255,255,.5);
    pointer-events: none;
    transition: opacity .2s linear;
}
.handed-left .app-main-comp-float {
    right: 0;
    left: 113px;
    padding: 15px 15px 4px 0;
}
.handed-right .app-main-comp-float {
    right: 113px;
    left: 0;
    padding: 15px 0 4px 15px;
}
.app-main-comp-float.active {
    opacity: 1;
    pointer-events: all;
}
.app-main-comp-float-modal {
    border-radius: 15px;
    box-shadow: rgba(0,0,0,.3) 0 0 10px;
    height: 100%;
    padding: 15px 14px;
    background: #fff;
    position: relative;
    transition: all .2s linear;
}
.app-main-comp-float.active .app-main-comp-float-modal {
    transform: rotate(0deg);
}
.handed-left .app-main-comp-float-modal {
    transform-origin: bottom left;
    transform: rotate(90deg);
}
.handed-right .app-main-comp-float-modal {
    transform-origin: bottom right;
    transform: rotate(-90deg);
}
.app-main-comp-float-modal-tri {
    width:0;
    height: 0;
    position: absolute;
    bottom: 23px;
    border-top: 15px solid transparent;
    border-bottom: 15px solid transparent;
}
.handed-left .app-main-comp-float-modal-tri {
    left: -15px;
    border-right: 15px solid #fff;
}
.handed-right .app-main-comp-float-modal-tri {
    right: -15px;
    border-left: 15px solid #fff;
}
.social-media-list {
    padding:0;
    margin: 0 0 0 21px;
    display: flex;
    flex-direction: column;
    overflow-y: auto;
    height: calc(100% - 50px);
    overflow-x: hidden;
}
.social-media-list li {
    list-style-type: none;
    display: flex;
    align-items: center;
}
.social-media-list li span:first-child {
    padding: 5px;
    font-size: 30px;
}
.social-media-list li span:last-child {
    padding:15px 15pc 15px 5px;
}
.social-media-icon {
    background: url(<?php echo $this->app->objCustomPlatform->getFullPortalDomainName(); ?>/_ez/images/social-media-icon.svg) no-repeat center center / 100% auto;
    width: 38px;
    height: 38px;
    display: block;
    top: 1px !important;
    left: 2px;
}


/** SCROLL BAR **/
.digital-app ::-webkit-scrollbar {
    width: 8px;
}
.digital-app ::-webkit-scrollbar-track {
    background: transparent;
}
.digital-app ::-webkit-scrollbar-thumb {
    background-color: #ccc;
    border-radius:5px;
}
.digital-app ::-webkit-scrollbar-thumb:hover {
    background-color: #bbb;
}
.digital-app navigation::-webkit-scrollbar {
    width: 5px;
}
.digital-app navigation::-webkit-scrollbar-thumb {
    background-color: #eee;
    border-radius:5px;
}
.digital-app navigation::-webkit-scrollbar-thumb:hover {
    background-color: #ddd;
}

/*** CSS THAT NEEDS WORK **/

.vue-modal-wrapper,
.vue-modal-wrapper > div,
.vue-modal-wrapper > div > div,
.vue-app-body,
.vue-app-body > div,
.vue-app-body > div > div {
    height:100%;
}

.vue-app-body-component {
    height:100%;
}

.app-page-content img {
    max-width:100%;
}

@media (max-width:600px) {
    .app-card {
        width: 100%;
        display: flex;
        flex-direction: column;
        max-height: 100vh;
        max-height: -webkit-fill-available;
        height: 100%;
        position: relative;
    }
    .app-wrapper-inner {
        width:100%;
        height:100%;
    }
    .app-main-comp-header {
        width: 100%;
        height: calc(100vw * .565);
    }
    .app-kabob-float {
        top: calc(((100vw * .626) / 2) - 25px);
        width: 190px;
        height: calc(var(--vh) - ((100vw * .626) / 2) - 17px);
    }
    .management-hub .app-kabob-float {
        height: calc(var(--vhw1) - ((100vw * .626) / 2) - 17px);
    }
    .app-kabob-avatar {
        width: 115px;
        height: 115px;
        margin: 25px auto 15px;
    }
    .app-main-comp-nav {
        width: 28%;
    }
    .app-template-4 .app-main-comp-nav {
        width: 100%;
    }
    .app-main-comp-pages {
        width: 72%;
        max-height: calc(var(--vh) - (100vw * .565) - 70px);
    }
    .app-template-4 .app-main-comp-pages {
        width:100%;
        max-height: inherit;
    }
    .management-hub .app-main-comp-pages {
        max-height: calc(var(--vh) - (100vw * .565) - 160px);
    }
    .app-main-comp-footer {
        height: 70px;
    }
    .app-main-comp-nav {
        padding: 5px 0;
    }
    .app-main-comp-pages {
        padding: 5px 0;
    }
    .app-template-2 .app-main-comp-nav ul li,
    .app-template-2 .app-main-comp-pages ul li,
    .app-template-3 .app-main-comp-nav ul li,
    .app-template-3 .app-main-comp-pages ul li {
        display: flex;
        align-items: center;
        min-height: calc((var(--vh) - (100vw * .565) - 80px) / 5);
        height: calc((var(--vh) - (100vw * .565) - 80px) / 5);
        width: 100%;
        justify-content: center;
    }
    .management-hub .app-main-comp-nav ul li,
    .management-hub .app-main-comp-pages ul li {
        min-height: calc((var(--vhw1) - (100vw * .565) - 80px) / 5);
        height: calc((var(--vhw1) - (100vw * .565) - 80px) / 5);
    }
    .app-main-comp-nav ul li span.app-main-comp-nav-item {
        padding: 10px;
        width: 50px;
        height: 50px;
    }
    .app-main-comp-nav ul li span.app-main-comp-nav-item span {
        font-size: 27px;
        width: 32px;
        position: relative;
        top: 6%;
    }
    .app-template-2 .app-main-comp-pages ul li span.app-main-comp-page-item {
        padding: 1.5vh 15px;
        border-radius: 25px;
        font-size: 3.7vw;
    }
    .app-page-title {
        font-size: 6vw;
    }
    .app-kabob .app-kabab-circle {
        width: 10px;
        height: 10px;
        margin-bottom: 6px;
    }
    .app-kabob {
        width: 71px;
        height: 56px;
    }
    .app-kabob-handle {
        height: 56px;
        width: 21px;
        padding: 7px 5px;
    }
    .handed-left .app-kabob {
        right: -71px;
    }
    .handed-right .app-kabob {
        left: -71px;
    }
    .handed-left .app-kabob-float {
        left: -190px;
    }
    .handed-right .app-kabob-float {
        right: -190px;
    }
    .handed-left .app-main-comp-pages {
        padding-right: 15px;
    }
    .handed-right .app-main-comp-pages {
        padding-left: 15px;
    }
    .app-modal-title {
        font-size: 32px;
    }
    .social-media-icon {
        width: 32px;
        height: 32px;
        top: -1px !important;
        left: 0px;
    }
    .app-main-comp-float {
        height: calc(var(--vh) - (100vw * .626) - 44px);
        width: calc(100vw * .75);
        left: auto;
    }
    .management-hub .app-main-comp-float {
        height: calc(var(--vhw1) - (100vw * .626) - 44px);
        width: calc(100vw * .75);
        left: auto;
    }
    .app-main-comp-float-modal-tri {
        bottom: 15px;
    }
    .app-modal-float,
    .app-modal {
        max-height: var(--vh);
    }
    .management-hub .app-modal-float {
        margin-top:48px;
    }
    .management-hub .app-modal-float,
    .management-hub .app-modal {
        max-height: var(--vhw1);
    }
    .app-modal-box {
        width: calc(100vw - 30px);
        display:table;
    }
    .app-modal {
        min-width:auto;
    }
    .floating-blocks div div:first-child {
        font-size: 7.5vw;
    }
    .floating-blocks div div:last-child {
        font-size: 4vw;
    }
    .app-kabob-menu {
        margin: 10px 0 0 0;
        height: calc(var(--vh) - (100vw * .626) - 175px);
    }
    .management-hub .app-kabob-menu {
        height: calc(var(--vhw1) - (100vw * .626) - 175px);
    }
    .app-kabob-menu li {
        padding: 0 10px;
    }
    .app-kabob-menu li > span {
        width: 59px;
        text-align: center;
        font-size:12px;
    }
    .app-kabob-menu li span span {
        width: 50px;
        font-size: 30px;
    }
    .app-template-2 .app-page-content {
        overflow-y: auto;
        height: calc(100% - 45px);
    }
    .management-hub .app-template-2 .app-page-content {
        overflow-y: auto;
        height: calc(-webkit-fill-available - 125x);
    }
}

/* Safari 10.1+ */
@media not all and (min-resolution:.001dpcm) { @media {

    .app-page-content {
        padding-bottom:75px;
    }
}}