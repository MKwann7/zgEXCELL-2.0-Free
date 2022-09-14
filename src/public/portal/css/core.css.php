<?php

header('Content-Type:text/css');
header('Cache-Control: public, max_age=3600');

?>

.loggedInBody {
    overflow-y: hidden;
}
.loggedInBody .siteHeader {
    background: url(/media/images/header-static.png) no-repeat left 15px top / auto 100%, url(/media/images/header-grad.png) repeat-x left 15px  top / auto 100%;
    height:78px;
    font-family: 'Yanone Kaffeesatz', sans-serif;
    color: #fff;
}

a.leftHeaderLogoLink {
    text-decoration:none;
}

.siteHeader .menu dropit a {
    text-decoration:none;
    display:table;
    table-layout:fixed;
    height: inherit;
}

.siteHeader .leftHeaderRight,
.siteHeader .leftHeaderLeft {
    display:table-cell;
    vertical-align:middle;
}

.siteHeader .leftHeaderRight span {
    font-size: 18px;
    font-weight: normal;
    color: #fff;
    text-decoration:none;
}

.siteHeader .leftHeaderRight span span {
    font-size: 16px;
    text-transform:uppercase;
    font-weight: bold;
    color: #f4a820;
    display:block;
}

.siteHeader .leftHeaderInner {
    display: table-cell;
    vertical-align: middle;
    height: inherit;
    width: 117px;
}

.siteHeader .leftHeader {
    font-family: 'Yanone Kaffeesatz', sans-serif;
    display: table;
    height: inherit;
    position:absolute;
    left:0px;
    top:0px;
    height: 78px;
}

.siteHeader .rightHeader {
    font-family: ArialNarrow, sans-serif;
    display: block;
    height: inherit;
    position:relative;
    left:0px;
    top:0px;
    margin-left:155px;
}

.siteHeader .floatRightHeader {
    background: url(/media/images/AvatarPlaceHolder.png) no-repeat right top / auto 100%;
    font-family: ArialNarrow, sans-serif;
    display: block;
    height: inherit;
    position: absolute;
    top: 0px;
    right: 20px;
    color: #555;
    font-size: 16px;
    width: 52px;
}

.siteHeader .floatRightHeaderAvatarLink {
    width: 46px;
    height: 46px;
    border-radius: 25px;
    position: absolute;
    top: 17px;
    right: 4px;
    cursor:pointer;
}

.siteHeader .floatRightHeader label {
    position: absolute;
    top: 29px;
    right: 67px;
    color: #555;
    font-size: 16px;
    white-space: nowrap;
    text-align: right;
    max-width: inherit;
    font-weight: 300;
}

.siteHeader .leftHeaderLeft {
    padding-left: 11px;
}

.siteHeader .leftHeaderRight {
    padding-left: 3px;
    padding-bottom: 10px;
    line-height: 16px;
}
a.leftHeaderLogoLink {
    left: 50px;
    position:relative;
}

.breadcrumb-right-menu-list {
    padding: 0px;
    list-style-type: none;
    margin: 0px 10px;
    display: table;
    position: absolute;
    z-index: 110;
    height: 36px;
    top: 0px;
    right: 0px;
    bottom: 0px;
}
.breadcrumb-right-menu-list > li {
    height: 100%;
    display: table-cell;
    vertical-align: middle;
}
.breadcrumb-right-menu-list > li img {
    width:22px;
}

.dynamicButtons {
    background: #000000;
    background: -moz-linear-gradient(top, #000000 0%, #01B1ED 100%);
    background: -webkit-linear-gradient(top, #000000 0%,#01B1ED 100%);
    background: linear-gradient(to bottom, #000000 0%,#01B1ED 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#000000', endColorstr='#01B1ED',GradientType=0 );
    width: 100%;
    border: 1px solid #01B1ED;
    color: #fff !important;
    text-transform: uppercase;
    font-size: 15px;
    border-radius: 10px;
    height: 40px;
    display: block;
    line-height: 40px;
    cursor:pointer;
    text-decoration: none;
}

.addNewEntityButton,
.emailEntityButton,
.editEntityButton,
.deleteEntityButton {
    display:inline-block;
    width:15px;
    height:15px;
    position: relative;
}

.addNewEntityButton::before {
    display:block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAxdJREFUeNqcVL9vHEUYfTM7u3eXvcN3/nFxsM6XRAgJyyYyChISdBQgxWAEFDRuESkSqqQCKfwDNOmTIkqqSCQGCxASDVUEtowiEKGwZNnyjwCOfdi3vt2dGd7s3tkmFg0jfVrtvO+9efN9367ApXs4tiwmAt+7UAq8874nm0LAS1KzEsV6oZPob5jwANzMc232EP8Ssrb/RMH/tN5XvFgrFwoONl1ISQGrDZ60Y2xuRzfbneQzii0fF7I4PdRX/HJ0oDzuKQ8poXo5QKWgMni9tY92rKFoRGuN1b/21ij4FokLDpddJzWKzJ2pV8YFRbT0EFmBD19p4M4H41m8WPWxxz2HCc9Dc6jy7MlqadYZyIVoLSwG15qD5TEj+cokUAy+gnPmruRCMtyeYLgcwxo1BsKRShhcpxiZQowNV0sfSZKsoEBPSJEAcVg+Eq2n4A5zjiRxxThVPTElpHhdlQpquhYWgphVjUjNuCTt0WxyROjPSOP3zZh3YI5OEbANo6HCQBigXPTfU2GgXnadafaX8Orpflie6IzGFHm+FhwIXRirY/AkW+CqSqF4P8Gdn1ax5a7tiUkVKNnsGIuxehlXXmvgv9bM+RHMHN0wGt8urmL579gJDzl9D/9rifzi+WAKlWiz4ktxbmkrwu2fN7GTWETasrgSb5ztw8RgMaN9/dsf+GVHk8caGYO4k2Bb5wPItaU4ZPO+wNSjx3tYfNzGo21aNbnR8N3nDoRuPFjB3SViHolxAqQMYXtfxEPZ7qRzrSi2Rdd5N+6WpXfD7BkEvUSukpJ5x9wZDncjbnJ3FJqV1tof17ejW26jE6dAQr+peyZ50kFxbb7HjvEbOQxjfiD6lRtItNrJJ2tP2hsZ4JKdEEWDwzGCJ7pCPTzNBHcp9DHhWODy/bwHQrwUFv17u6ltZNPNA14YruDUM4UM/3WthY3dOP9t5G5ajPcJfZf3sCvU/QOchRSfw5PTbiihbbcpzpLMi+uuq833FLzKmO9R1VOjsUTwHaT6TQjzNt8n6WwoQ7TeouhD4nN8/8JV7Sj1HwEGAGXUUvW2OWvwAAAAAElFTkSuQmCC') no-repeat center center / 100%;
    position: absolute;
    content: " ";
    top: 0;
    left: -3px;
}

.editEntityButton::before {
    display:block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACYAAAAmCAYAAACoPemuAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAABmJLR0QA/wD/AP+gvaeTAAAAB3RJTUUH4gkUCx4h0U5y8AAAA6xJREFUWMPN2EtoXFUcx/FPbiKK1kqbWkurWVjFirHWB1WKSrFudGMUhSr42mjx0Soo+NiIK1EUFYtmo+BCUBEqFio+sNGSSkVahRjtFBu01UVaMal9QJ3Exf9MejOZSWbiTegPhuGeOffO9/7P//wfp0UTunATaMUSXIaVuBiLcAZGcRh/og878GO6Hil1Nf5fLQ3CwOlYhTtwPc5LY/WeUYEcwFZ8mECPwVSQk4IlqFMSyHrcgDnNWDmnIXyG17Ed5cngaoLlrLQIT+J+zJsmULUG0Y1XcbCe9SaA5aAux8tYrYElb1Ij2JJeur8W3Lg/zEGtSm/VWTBQtb7Dg9hZDTcGVmWpdwuG+ls4/TkmWn8H7sXPebisatJivFIw1F7ciRvxvtitea3ES2jPD2Y5a7WJNV9dINQQhp2Ia+vxXg24m/EossrKZbklXIP7CoQq4S58irewQuzIx2vAZViHayoDre1rEVH7RSwvCGqPcOrP0Yvz8RC+x6/4Gufi0tw9c3AaNrevVa742LWKW8I9eABfpesjeA7f4M1kuQN4VnL4nG7CVRUTZrjN9CN6XahS19guq4ZbLpZypOr++bilAtYhUk7hUBVVwfUIn3tbFADVWoOFmYhbHTMFVaUjeAcLRN6tlVGWojPDlaJKmDGo3M5fghdwwSTPm4sVbVj2P6BKYvc1CrVR8qFJlGFZJqL9yQJV0eJMxLCTCQrmZk1MrqgSPGcKCkYz/NOkpZpx9OlAwXAb9jc4+bcEtXWGoWBfhp8amHgMv+N4vQkFQpXRn4nEOtVy7sNreATXVYEUCUWUSrvaRFk7YPLi8Ci+TICPiTy3LQ9XEBTsRl/Fx3qmADsslnG7SCMb0vi2gqEkAxxsS2//Ee4W6aCWDjnhX73pe4OoDgYKhBrEx0Q5Dd+KZvT2OjcMG+/4vaKoewpnSX5XgD7BrjzYUbwhisUFNW7oEP3A/PSZl6zbKZriIrRf1GrHS12p7MgdljyPpxXf4E6lMp4R5b1SV+qSUrAsi7Z9yyxDET7enWOZ0FcO4gnRIc+WeoSvDuUHx8ByKaZfJOnZgOsRbdveKobxFsv9sBP3YLOJDUMR+hcfiD523NFARVMdQ7WL7nkdFhYE9YdIb90YqtcfNHJw14qr8bDo+6Z7TnZAxKmNYkVGmj64q2O9U3EFbhUdzlIRy+oVm2URmHfjC2zCD1KcmkpNxasE2YKzcYk4IL5I5MozRXo7JEqkXxJIH/7CaDOHw/8BwN0RTQ5fFN4AAAAldEVYdGRhdGU6Y3JlYXRlADIwMTgtMDktMjBUMTE6MzA6MzMtMDQ6MDD2YkMTAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE4LTA5LTIwVDExOjMwOjMzLTA0OjAwhz/7rwAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAAASUVORK5CYII=') no-repeat center center / 100%;
    position: absolute;
    content: " ";
    top: 0;
    left: -3px;
}

.emailEntityButton::before {
    display:block;
    width:34px;
    height:34px;
    background: url("/_ez/images/icons/reminder-icon.png") no-repeat center center / 100%;
    position: absolute;
    content: " ";
    top: -5px;
    left: -19px;
}

.swapEntityButton {
    background: #0000ff;
    color: #fff;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: 0px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.cloneEntityButton {
    background: #6100ff;
    color: #fff;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: 0px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.cloneEntityButton:before {
    font-family: "Font Awesome 5 Free" !important;
    content: "\f24d" !important;
    color: #fff;
    font-weight: 900;
}

.mailEntityButton {
    background: #0000ff;
    color: #fff;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: 0px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.fas.fa-envelope:before {
    margin-right: 5px;
    left:1px;
    position: relative;
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

.augmented-form-items {
    background:#ddd;padding: 0px 8px 0px;border-radius:5px;box-shadow:rgba(0,0,0,.2) 0 0 10px inset
}

.loginUserButton {
    background: #0000ff;
    color: #fff;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: -5px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.manageDataButton {
    background: #0000ff;
    color: #fff;
    padding: 5px;
    width: 23px;
    height: 22px;
    top: -5px;
    position: relative;
    border-radius: 20px;
    font-size: 11px;
}

.deleteEntityButton::before {
    display:inline-block;
    width:22px;
    height:22px;
    background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABUAAAAUCAYAAABiS3YzAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAqxJREFUeNqclFuLUlEUx885ozOlMQ7eLw++iJGX1wyCqZgIsnrwhoIEYZc3YSrqCxR9AZ/mRbzV5PQkBH2DHuzBSyWa0oNRUInXQcd0tLVlb9vqcYQ2LM45++z9O2v91/9shpkdLPN/g+V74HCg5zHEKBgMjlaRQqHQwj4UZIKTy+UbTqfzLNxvQAjxhlVAIVrvcrnO4fsJbw1DBR6P55pCoXiu0+kqxWLxN/pyOp0e22y28QnA0z6f75JarX5hNBor+Xz+G8qUQLlcLvfdarVuyWSy+xqNplIqlX7xgWkgJLKtUqmedjqd17FY7B3MDRGUaIrg62hhIBB4IBaLr1er1WepVOoDzB1BDLBmLA2EDJ+02+1kNBp9BXNdiD8kUzKQyONMJvPRbDZLQIq7dMZ4jWAJsIc/PCIZMtBpBsok4FE2m83PgWsYeMrtdm/D3DwQZXjMUGUzoNkkloEhvpbL5bbD4bgIjXzcarX2QcN9PuAMlFwp8BjAn0wm0xaUesdgMJyB6+1Go5GMx+NJoiFUeYz3TMeCF2ERMTHSaBCJRBLdbvczuOIWZPg+kUik8Lsh0XB+cCf8dqiKNSj5vEgksvb7/S8SieSC3W4343fcst96pnweH17WarW79Xr9ADLeAynESApoVJn2MeWORegc8AoAHqGmQMlIwx5onIHmbfLYbQY8hdJAr9e7A3/Kw2az+ZJqSh91mcduC+AJFEpgKeBVpVK5i4EHGDjAtlmwG8hThrPiJ37/D4pFF/r9/h04rVDJCQC+IUBkGz4fWyyWTVh/T6/XFwuFwg9iRY4+V6G7Nw4PD6Ng7CQN5LEbMnw3HA7v9Xq9t2C3m7QT6ENaIJVK16HTI1zKkAbOHX0s2YOqhWzZWq1G/qzpKcVSgcZ41cmPwTN7SPwVYAArcoAyG20N/QAAAABJRU5ErkJggg==') no-repeat center center / 100%;
    position: absolute;
    content: " ";
    top: 0;
    left: -4px;
}
.entityButtonFixInTitle {
    top: -5px !important;
    left: 4px !important;;
}


/* Example media queries */

.DialogTransparentShield {
    position: absolute;
    top:0px;
    left:0px;
    width: 100%;
    height: 100%;
}

.AvatarMenu {
    position: absolute;
    z-index: 1000;
    top: 68px;
    right: 15px;
    min-width: 150px;
    min-height: 100px;
}

.NotificationModal {
    position: absolute;
    z-index: 1000;
    top: 68px;
    right: 15px;
    min-width: 150px;
    min-height: 100px;
}

.AvatarMenuTriangle {
    position: absolute;
    top: 0px;
    right: 18px;
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
}

.AvatarMenuItem {
    list-style-type:none;
    margin-left:0px;
    padding: 10px 15px 10px 45px;
    cursor:pointer;
}

.AvatarMenuItem.EditIcon {
    background: url(/media/images/edit-icon-grey.svg) no-repeat left 10% center / auto 55%;
}
.AvatarMenuItem.CogIcon {
    font-family: "Font Awesome 5 Free" !important;
}
.AvatarMenuItem.CogIcon:before {
    content: "\f085";
}
.AvatarMenuItem.PowerIcon {
    background: url(/media/images/power-button-grey.svg) no-repeat left 10% center / auto 55%;
}

.main-user-avatar {
    border-radius: 50px;
    width: 45px;
}

header, footer, hgroup, nav, section {
    display: block;
    position: relative;
}
.loggedInBody .leftHeaderInner > a:not(.leftHeaderLogoLink) {
    display: block;
    margin-left: 39px;
    padding-top: 5px;
    text-decoration:none;
    background-color:transparent;
    text-align:center;
}
.loggedInBody .headerMenuDiv {
    padding: 19px 0px 19px 0;
    height: 40px;
    box-sizing: content-box;
}
.headerMenuTd {
    float: left;
    height: inherit;
}
.headerMenuTd ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
.headerMenuTd ul:before, .nav ul:after {
    content: "";
    display: table;
}
.headerMenuTd ul > li {
    float: left;
    position: relative;
}
.headerMenuTd > ul > li {
    height: inherit;
}
.headerMenuTd li > a {
    position: relative;
    top: 0px;
    height: 20px;
    padding: 10px 34px 10px 20px;
    display: block;
    color: #fff;
    text-decoration: none;
    box-sizing: content-box;
}
.headerMenuTd li:hover a {
    color:#fff !important;
}
.headerMenuTd > ul > li > ul  a {
    border: none;
}
.headerMenuTd a {
    display: block;
    padding: 10px 20px;
    line-height: 1.2em;
}
.headerMenuTd > ul > li > ul {
    position: absolute;
    background: linear-gradient(to bottom,#424a56 0%, #6c798c 10%, #424a56 100%);
    left: 0;
    top: 40px;
    z-index: 1;
    max-height: 0;
    /*overflow: hidden;*/
    transform: perspective(400px) rotate3d(1,0,0,-90deg);
    transform-origin: 50% 0;
    transition: 350ms;
    -webkit-transform: perspective(400px) rotate3d(1,0,0,-90deg);
    -webkit-transform-origin: 50% 0;
    -webkit-transition: 350ms;
    -moz-transform: perspective(400px) rotate3d(1,0,0,-90deg);
    -moz-transform-origin: 50% 0;
    -moz-transition: 350ms;
    -o-transition: 350ms;
    transition: 350ms;
}
.headerMenuTd > ul > li > ul > li > ul {
    position: absolute;
    background: linear-gradient(to bottom,#424a56 0%, #6c798c 10%, #424a56 100%);
    z-index: 2;
    max-height: 0;
    position: absolute;
    left: 100%;
    top: 0px;
    transform: perspective(400px) rotate3d(0,1,0,90deg);
    transform-origin: 0 0;
    transition: 350ms;
    -webkit-transform: perspective(400px) rotate3d(0,1,0,90deg);
    -webkit-transform-origin: 0 0;
    -webkit-transition: 350ms;
    -moz-transform: perspective(400px) rotate3d(0,1,0,90deg);
    -moz-transform-origin: 0 0;
    -moz-transition: 350ms;
    -o-transition: 350ms;
    transition: 350ms;
}
.headerMenuTd > ul {
    list-style: none;
    margin: 0;
    padding: 0;
}
.headerMenuTd > ul > li > ul > li.
.headerMenuTd > ul > li > ul > li > ul > li {
    padding: 0px;
    height: inherit;
}
.headerMenuTd > ul > li > ul > li a {
    padding: 8px 18px !important;
    height: inherit;
    white-space: nowrap;
}

.headerMenuTd a:hover {
    text-decoration:none;
}
.headerMenuTd li ul li {
    width:100%;
}
.headerMenuTd li ul a {
    border:none;
}
.headerMenuTd li ul a:hover {
    background:rgba(0,0,0,0.2);
}
.headerMenuTd > ul > li:hover > ul {
    max-height:1000px;
    transform:perspective(400px) rotate3d(0,0,0,0);
    -moz-transform:perspective(400px) rotate3d(0,0,0,0);
    -webkit-transform:perspective(400px) rotate3d(0,0,0,0);
}
.headerMenuTd > ul > li > ul > li:hover > ul {
    max-height:1000px;
    transform:perspective(400px) rotate3d(0,0,0,0);
    -moz-transform:perspective(400px) rotate3d(0,0,0,0);
    -webkit-transform:perspective(400px) rotate3d(0,0,0,0);
}
.headerMenuTd:hover > ul > li > a,
.headerMenuTd:hover > a {
    background: linear-gradient(to bottom,#555 0%, #000 100%);
    color: #fff;
}
.headerMenuTd:hover > ul > li > a:not(.noDropdownLink),
.headerMenuTd:hover > a:not(.noDropdownLink) {
    background: url(/media/images/down-arrow-white.png) no-repeat right 17px center, linear-gradient(to bottom,#555 0%, #000 100%);
}
.menu ul.dropit-submenu a:hover {
    background: linear-gradient(to bottom,#555 0%, #000 100%);
    color: #fff;
}
.headerMenuTd > a {
    color: #2A307D;
    font-weight: normal;
    font-size: larger;
    height: 20px;
    display: block;
    color:#2A307D;
    text-decoration:none;
}
.headerMenuTd:hover {
    background: #248fc1;
    color: #fff;
    text-decoration: none;
}
.dropdown-menu-icon {
    position:relative;
    top:-1px;
}
.menuDropdownLink {
    color: #2A307D;
}
.menuDropdownLink:not(.noDropdownLink) {
    color: #555 !important;
    font-weight: normal;
    font-size: larger;
    text-decoration: none;
    background: url(/media/images/down-arrow.png) no-repeat right 17px center;
    font-family: ArialNarrow;
}
.menuDropdownLink {
    cursor:pointer !important;
}
.header-button-float-right {
    position: absolute;
    border-radius: 5px;
    font-size: 14px !important;
    right: 14px;
    top: 18px;
    cursor: pointer;
}

.breadCrumbs {
    background-color: #000;
    height: 39px;
    display: flex;
    width: 100%;
    padding-left: 12px;
    box-sizing: border-box;
}

.breadCrumbPage {
    font-family: ArialNarrow;
    top: 1px;
    position: relative;
}

.breadCrumbsInner {
    color: #fff;
    font-size: 16px;
    align-items: center;
    vertical-align: middle;
    position:relative;
}

.breadCrumbsInner a.breadCrumbHomeImageLink {
    color: #fff;
    font-size: 16px;
    text-decoration:none;
}

.breadCrumbsInner a:not(.breadCrumbHomeImageLink) {
    color: #fff;
    font-size: 16px;
    text-decoration:underline;
}

.breadCrumbHomeImage {
    position: relative;
    background: url(/media/images/home-icon-01_white.png) no-repeat center center / 100%;
    width: 15px;
    height: 15px;
    display: block;
}

.BodyContentBox {
    width: calc(100% - 30px);
    margin: 15px 15px;
    padding: 0px 0px 15px;
    background: #efefef;
    position: relative;
    height: calc(100vh - 250px);
}

.no-columns .BodyContentBox {
    width: calc(100% - 30px);
    margin: 15px 15px;
    padding: 0px 0px 15px;
    background: #efefef;
    position: relative;
    height: calc(100vh - 150px);
}

.two-columns .BodyContentBox {
    width: calc(100% - 30px);
    margin: 15px;
    padding: 0px 0px 15px;
    background: #efefef;
    position: relative;
    height: calc(100vh - 150px);
}
.componentIcon {
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
}
.componentIconModules:before {
    content: "\f009";
}
.componentIconCards:before {
    content: "\f2c2";
}
.left-side-column .BodyNavigationBox {
    width: 250px;
    margin: 0px;
    background: #555;
    position: relative;
    min-height: calc(100vh - 117px);
    position: absolute;
}
.BodyContentBox .formwrapper {
    height:100%;
    overflow-x:hidden;
}
.BodyContentBox-inner {
    padding: 0px 15px;
    margin-top: -15px;
}
.MobileNavModule,
.NavigationModule {
    border-bottom:1px solid #777;
}

.MobileNavModule > a,
.NavigationModule > a,
.MobileNavModule > span,
.NavigationModule > span  {
    display: inline-block;
    padding: 8px 15px;
    text-align: left;
    font-size: 16px;
    color: #fff;
    width: 100%;
    cursor: pointer;
}

.MobileNavModule > a > span,
.NavigationModule > a > span {
    color: #fff;
}
.MobileNavModule ul,
.NavigationModule ul {
    display: none;
    background: linear-gradient(to bottom, rgba(0,0,0,.3) 0%, rgba(0,0,0,0) 85px);
}
.MobileNavModule ul li > a,
.MobileNavModule ul li > span,
.NavigationModule ul li > a,
.NavigationModule ul li > span {
    display: inline-block;
    padding: 5px 15px 5px 30px;
    text-align: left;
    font-size: 18px;
    color: #ccc;
    width: 100%;
    cursor: pointer;
}
.MobileNavModule ul li ul li > a,
.MobileNavModule ul li ul li > span,
.NavigationModule ul li ul li > a,
.NavigationModule ul li ul li > span {
    padding: 5px 15px 5px 45px;
    border-top:1px solid #666;
    border-bottom:1px solid #222;
}
.MobileNavModule ul li ul li:first-child > span,
.NavigationModule ul li ul li:first-child > span {
    border-top:1px solid #222;
}
.MobileNavModule ul li ul,
.NavigationModule ul li ul {
    background: linear-gradient(to bottom, rgba(0,0,0,.3) 0%, rgba(0,0,0,0) 85px), #444;
}

.MobileNavModule ul li > span:hover,
.NavigationModule ul li > span:hover {
    color: #fff;
}
.dashboard-tab {
    display:inline-block;
    padding:10px 15px;
    border-top:1px solid #ffffff;
    border-right: 1px solid #aaaaaa;
    border-left: 1px solid #ffffff;
    border-radius: 20px 20px 0 0 /90px 90px 0 0;
    background: linear-gradient(to bottom, rgba(255,255,255,.5) 0%, rgba(255,255,255,0) 100%);
    margin-left: -5px;
    z-index:5;
    position: relative;
    cursor:pointer;
}

.dashboard-tab.active {
    display:inline-block;
    padding:10px 15px;
    border-top:1px solid #ffffff;
    border-right: 1px solid #aaaaaa;
    border-left: 1px solid #ffffff;
    border-radius: 20px 20px 0 0 /90px 90px 0 0;
    background: linear-gradient(to bottom, rgba(255,255,255,.8) 50%, rgba(255,255,255,.5) 100%);
    margin-left: -5px;
    z-index:10;
    cursor:default;
}

.cgrid-outer {
    margin: 0px -25px;
    overflow-x: auto;
}

.inline-header-buttons {
    position: relative;
    top: -5px;
    padding: 2px 10px;
    margin-left: 15px;
}

.child-portal-body-inner {
    padding: 15px 25px 25px;
    box-sizing: border-box;
}

.child-portal-body-inner > h2 {
    margin-bottom:15px;
}

.cgrid {
    width:100%;
    border-collapse:collapse;
    margin:auto;
}

.cgrid thead tr {
    border-top:1px solid #ddd;
    background:linear-gradient(to bottom,rgba(245,245,250,1) 0%, rgba(233,233,238,1) 100%);
    border-bottom:1px solid #ccc;
}
.cgrid tbody tr {
    border-bottom:1px solid #ddd;
    cursor:pointer;
}
.cgrid tbody tr:hover {
    background:linear-gradient(to bottom,rgba(225,225,235,1) 0%, rgba(215,215,225,1) 100%) !important;
}
.cgrid tbody tr:nth-child(2n+1) {
    background:rgba(240,240,235,.5);
}
.cgrid th {
    text-align: center;
    padding: 2px 5px;
    cursor: pointer;
}
.cgrid th:first-child {
    border-left:0px none;
}

.cgrid th:last-child {
    border-right:0px none;
}
.cgrid th {
    border-right:1px solid #ddd;
}
.cgrid td {
    text-align: left;
    padding:10px 10px;
    border-right:1px solid #ddd;
    font-size: 12px;
}
.cgrid td:first-child {
    border-left:0px none;
}
.cgrid td:last-child {
    border-right:0px none;
}

/* General styles for all menus */
.cbp-spmenu {
    background: #000; /* Old browsers */
    background: -moz-linear-gradient(top,  #444 0%, #222 100%); /* FF3.6+ */
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#444), color-stop(100%,#222)); /* Chrome,Safari4+ */
    background: -webkit-linear-gradient(top,  #444 0%,#222 100%); /* Chrome10+,Safari5.1+ */
    background: -o-linear-gradient(top,  #444 0%,#222 100%); /* Opera 11.10+ */
    background: -ms-linear-gradient(top,  #444 0%,#222 100%); /* IE10+ */
    background: linear-gradient(to bottom,  #444 0%,#222 100%); /* W3C */
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#444', endColorstr='#222',GradientType=0 ); /* IE6-9 */
    position: fixed;
}

.cbp-spmenu h3 {
    color: #ffffff;
    font-size: 1.5em;
    padding: 17px;
    margin: 0;
    font-weight: 300;
    background: #444;
}

.cbp-spmenu a {
    display: block;
    color: #fff;
    font-size: 1.1em;
    font-weight: 300;
}

.cbp-spmenu a:hover {
    background: #222222;
}

.cbp-spmenu a:active {
    background: #afdefa;
    color: #47a3da;
}

/* Orientation-dependent styles for the content of the menu */

.cbp-spmenu-vertical {
    width: 75%;
    height: 100%;
    top: 0;
    z-index: 1000;
}
.cbp-spmenu-vertical a {
    border-bottom: 1px solid #000000;
    padding: 5px 10px;
    text-decoration:none;
    font-weight:normal;
}
.cbp-spmenu-vertical > a {
    border-bottom: 1px solid #000000;
    padding: 5px 10px;
    text-decoration:none;
    font-weight:normal;
    border-top: 1px solid #777777;
    background: #000000;
    color: #fff !important;
}
.cbp-spmenu-vertical a.submenuitem {
    border-top: 0px;
    padding: 10px 10px;
    text-decoration:none;
    font-size: 12px;
    font-weight:normal;
    color:#ffffff;
}

.cbp-spmenu-horizontal {
    width: 100%;
    height: 150px;
    left: 0;
    z-index: 1000;
    overflow: hidden;
}

.cbp-spmenu-horizontal h3 {
    height: 100%;
    width: 20%;
    float: left;
}

.cbp-spmenu-horizontal a {
    float: left;
    width: 20%;
    padding: 0.8em;
    border-left: 1px solid #258ecd;
}

/* Vertical menu that slides from the left or right */

.cbp-spmenu-left {
    left: -75%;
    z-index:25000;
}
#cbp-spmenu-s1-back {
    width: 100%;
    left: -100%;
    z-index:24000;
    background:rgba(0,0,0,.3);
    display:none;
    position:fixed;
}
.cbp-spmenu-s1-back-open {
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    display:block !important;
}
.cbp-spmenu-right {
    right: -240px;
}

.cbp-spmenu-left.cbp-spmenu-open {
    left: 0px;
    height: 100vh;
    height: -webkit-fill-available;
    overflow-y: auto;
}

.cbp-spmenu-right.cbp-spmenu-open {
    right: 0px;
}

/* Horizontal menu that slides from the top or bottom */

.cbp-spmenu-top {
    top: -150px;
}

.cbp-spmenu-bottom {
    bottom: -150px;
}

.cbp-spmenu-top.cbp-spmenu-open {
    top: 0px;
}

.cbp-spmenu-bottom.cbp-spmenu-open {
    bottom: 0px;
}

/* Push classes applied to the body */

.cbp-spmenu-push {
    overflow-x: hidden;
    position: relative;
    left: 0;
}

.cbp-spmenu-push-toright {
    left: 240px;
}

.cbp-spmenu-push-toleft {
    left: -240px;
}

/* Transitions */

.cbp-spmenu,
.cbp-spmenu-push {
    -webkit-transition: all 0.3s ease;
    -moz-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.width50:nth-of-type(odd) .card-tile-50 {
    width:calc( 100% - 7px );
    margin-right:7px;
    padding: 15px 25px;
    background: #fff;
}

.width50:nth-of-type(even) .card-tile-50 {
    width:calc( 100% - 8px );
    margin-left:8px;
    padding: 15px 25px;
    background: #fff;
}

/*/////////////////////////////////------------ NEW TABLE DISPLAY -------*/

.zgXL-tb-wrpr {
    position:relative;
    overflow: hidden;
    box-shadow: rgba(0,0,0,.3) 0px 0px 5px;
}
.zgXL-tb-wrpr .zgXL-stat,
.zgXL-tb-wrpr .zgXL-mm-stat {
    position: absolute;
    right: 0;
    top: 0;
    box-shadow: rgba(0,0,0,01) 0 0 18px;
}
.zgXL-tb-wrpr .zgXL-resp {
    /*overflow-x: scroll;*/
}
.zgXL-tb-wrpr table.zgXL-tb-resp {
    width:100%;
}
.zgXL-tb-wrpr .zgXL-li {
    padding: 10px 10px;
}
.zgXL-tb-wrpr .zgXL-li:nth-child(odd) {
    background: linear-gradient(to bottom, #ffffff 0%,#eeeeee 100%);
}
.zgXL-tb-wrpr .zgXL-li:nth-child(even) {
    background: linear-gradient(to bottom, #bcbcbc 0%,#efefef 100%);
}
.zgXL-tb-wrpr .zgXL-xY {
    empty-cells: show;
    outline: none;
    vertical-align: middle;
    white-space: nowrap;
    overflow: hidden;
}
.zgXL-tb-wrpr .zgXL-xY > div {
    display: table;
    width: calc(100% - 1px);
}
.zgXL-tb-wrpr .zgXL-xY > a > div > div,
.zgXL-tb-wrpr .zgXL-xY > div > div {
    padding: 10px 10px;
    display: table-cell;
    vertical-align: middle;
}
.zgXL-tb-wrpr .zgXL-xY.zgXL-xY-image img {
    margin-bottom:-3px;
}
.zgXL-tb-wrpr .zgXL-xY.zgXL-xY-auto-width {
    min-width:55px;
}
.zgXL-tb-wrpr .zgXL-xY:not(.nohidden) > div > div {
    white-space: nowrap;
    overflow: hidden;
    position: relative;
}
.zgXL-tb-wrpr .zgXL-xY:not(.nohidden) > div > div > div:not(.zgXL-xY-it-vis) {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    position: relative;
}
.zgXL-tb-wrpr .zgXL-li.zgXL-li-stat .zgXL-xY > div > div {
    border-right:1px solid #888888;
    border-left:1px solid #ffffff;
    box-sizing: content-box;
}
.zgXL-tb-wrpr .zgXL-xX {
    position: relative;
}
@media (min-width:750px) {
    body .zgXL-tb-wrpr .zgXL-xY-mobile-menu {
        display:none !important;
    }
}
@media (min-width:750px) {
    body .zgXL-tb-wrpr .zgXL-mm-stat {
        display:none !important;
    }
}
.zgXL-xY-mobile-menu-toggle {
    right: 38px;
    white-space: nowrap;
    display: block;
    box-shadow: rgba(0, 0, 0, 0.498039) 0px 0px 8px;
    background: rgb(255, 255, 255);
    height: inherit;
    margin:5px;
}
.zgXL-xY-mobile-menu-toggle table {
    height:inherit;
    border-left:5px solid #000000;
    background: linear-gradient(to bottom, #eeeeee 0%,#ffffff 100%);
}
.zgXL-xY-mobile-menu-toggle table td {
    vertical-align: middle;
    border-right:1px solid #888888;
    border-left:1px solid #ffffff;
    padding: 0px 5px;
}
.zgXL-xY-mobile-menu-toggle table td:first-child {
    border-left:0px none;
}
.zgXL-xY-mobile-menu-toggle table td:last-child {
    border-right:0px none;
}
.breadCrumbsInner {
    display:flex;
    flex-direction: row;
}
.breadCrumbsInner li:not(.homeBreadcrumb) {
    display:flex;
    font-family: ArialNarrow;
    padding-left: 20px;
}
.breadCrumbsInner li.homeBreadcrumb {
    display:flex;
    font-family: ArialNarrow;
}
.breadCrumbsInner li > a,
.breadCrumbsInner li > span {
    font-family: ArialNarrow;
    position: relative;
}
.breadCrumbsInner li:not(.homeBreadcrumb) > a::before,
.breadCrumbsInner li:not(.homeBreadcrumb) > span::before {
    position: absolute;
    content: "»";
    left: -14px;
    top:-1px;
}
.vueAppWrapper table th a { cursor: pointer; }
.vueAppWrapper .pointer { cursor: pointer; }
.vueAppWrapper .active {color:green !important;}
.vueAppWrapper .page-count-display > span > span {
    background: #ddd;
    padding:2px 5px;
    border-radius: 3px;
    display:inline-block;
}
.vueAppWrapper .prev-btn {
    margin-left:20px;
}
.vueAppWrapper .hide {
    display:none;
}
.vueAppWrapper .table-striped td:last-child {
    width:auto;
}
.vueAppWrapper .active.sortasc,
.vueAppWrapper .active.sortdesc {
    position:relative;
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
.vueAppWrapper .formwrapper-inner {
    padding:15px;
}
.vueAppWrapper .account-page-title {
    font-family: ArialNarrow;
    display: inline-block;
    top: 1px;
    position: relative;
    padding-left:10px;
}
.vueAppWrapper .entityDashboard .account-page-title {
    padding-left:0px;
}
.vueAppWrapper .account-page-subtitle {
    display: inline-block;
    position: relative;
}
.page-right-hand-tools span {
    top:1px;
    position: relative;
}
.page-right-hand-tools > span > span {
    background: #ddd;
    padding: 2px 5px;
    border-radius: 3px;
    display: inline-block;
}
.BodyContentBox .form-search-box {
    display: inline-block;
    top: 10px !important;
    position: relative;
    margin-left: 11px;
    max-width:500px;
}
.page-count-display-data {
    top: 4px;
    position: relative;
}
.BodyContentBoxOld .formwrapper-manage-entity {
    position: absolute;
    padding:5px 15px;
    right:-100%;
    width:100%;
    top:0px;
}
.vueAppWrapper .table-striped tbody tr {
    cursor:pointer !important;
}
.vueAppWrapper .table-striped tbody tr:nth-of-type(odd) {
    background-image: linear-gradient(to bottom, #ffffff 0%,#eeeeee 100%) !important;
}
.vueAppWrapper .table-striped tbody tr:nth-of-type(even) {
    background-image: linear-gradient(to bottom, #bcbcbc 0%,#efefef 100%) !important;
}
.vueAppWrapper .header-table td {
    border-top:0px;
    padding-top: 5px;
    padding-bottom: 0px;
    position: relative;
    padding-left: 0;
    padding-right: 0;
}
.vueAppWrapper .formwrapper-manage-entity {
    padding:5px 15px;
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
.breadCrumbs #editing-entity {
    display:none;
}
.breadCrumbs .breadCrumbsInner.edit-entity #editing-entity {
    display:inline;
}
.breadCrumbs .breadCrumbsInner.edit-entity #view-list {
    display:none;
}
.vueAppWrapper .editEntityButton:not(:last-child) {
    margin-right:5px;
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
.vueAppWrapper .table tbody tr td {
    vertical-align: middle;
}
.formwrapper-control {
    height: 100%;
}
.fformwrapper-header table tbody tr > td {
    position:relative;
    top:-4px;
}
.form-search-box .form-control {
    height: calc(2.25rem - 8px);
    width: calc(65% - 5px);
    display: inline-block;
}
.entityDashboard .entityTab:not(.showTab) {
    display:none;
}
.entityDashboard .entityTab.showTab {
    display:block;
}
.page-count-display .btn {
    padding: .15rem .75rem;
    top: 2px;
    position: relative;
}
[v-cloak] { display: none; }

.highlighed-field td {
    padding: 7px 10px 7px 10px !important;
    position: relative;
    left: -5px;
    border-radius: 5px;
}

.highlighed-field td:first-child {
    border-radius: 5px 0 0 5px;
}

.highlighed-field td:last-child {
    border-radius: 0 5px 5px 0;
}

.error-outline {
    border: 1px solid #ff0000;
    box-shadow:0 0 5px #ff0000;
}

.entityTab .width100.entityDetails {
    background: linear-gradient(to left, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
}

.processWorkflow .width100.entityDetails,
.entityDashboard .width100.entityDetails {
    padding-top: 15px;
}

.processWorkflow .card-tile-100,
.entityDashboard .card-tile-100 {
    width:100%;
    padding: 15px 25px;
    background: #fff;
}

.entityDashboard .width50:nth-of-type(odd) .card-tile-50 {
    width:calc( 100% - 7px );
    margin-right:7px;
    padding: 15px 25px;
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}

.entityDashboard .card-tile-50 {
    min-height: 250px;
}

.entityDashboard .width50:nth-of-type(even) .card-tile-50 {
    width:calc( 100% - 8px );
    margin-left:8px;
    padding: 15px 25px;
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}

.entityDashboard .width33:nth-of-type(n+1) .card-tile-33 {
    width:calc( 100% - 7px );
    margin-right:8px;
    padding: 15px 25px;
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}

.entityDashboard .width33:nth-of-type(n+2) .card-tile-33 {
    width:calc( 100% - 16px );
    margin-right:8px;
    margin-left:8px;
    padding: 15px 25px;
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}
.entityDashboard .width33:nth-of-type(n+3) .card-tile-33 {
    width:calc( 100% - 8px );
    margin-left:8px;
    padding: 15px 25px;
    background: #fff;
    box-shadow: #cccccc 0 0 5px;
}

.entityDashboard .entityDetailsInner {
    margin-top:15px;
}
.entityDashboard .entityDetailsInner table tr td:nth-of-type(odd),
body tr.sortable-item td:nth-of-type(odd) {
    padding-right:15px;
}
/*.entityDashboard .entityDetailsInner table tr td,*/
body > tr.sortable-item > td {
    white-space: nowrap;
}

#tabLibraryInstanceHtmlPreview p > img,
#tabLibraryInstanceHtmlPreview span > img {
    max-width: 100% !important;
}

.sortable-item-permanent {
    opacity: .6;
}

.sortable-item-library .tab-type-icon,
.sortable-item-permanent .tab-type-icon,
.sortable-item-clone .tab-type-icon {
    font-weight: 900;
    font-family: "Font Awesome 5 Free";
    -webkit-font-smoothing: antialiased;
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1;
}

.sortable-item-library .tab-type-icon:before {
    font-family: "Font Awesome 5 Free" !important;
    content: "\f02d" !important;
    color:#999;
}

.sortable-item-clone .tab-type-icon:before {
    font-family: "Font Awesome 5 Free" !important;
    content: "\f24d" !important;
    color:#6100ff;
}

.sortable-item-permanent .tab-type-icon:before {
    font-family: "Font Awesome 5 Free" !important;
    content: "\f023" !important;
    color:#cc0000;
}
.table.table-shadow {
    box-shadow: 0 0 5px rgba(0,0,0,.3);
}
.table.no-top-border td {
    border-top:0px;
}
.BodyContentBox #entityMainImage {
    box-shadow: rgba(0,0,0,.3) 0 0 10px;
}
.entityConnectionType {
    width: 150px;
}
.entityConnectionValue {
    max-width: 300px;
    overflow-x: hidden;
    text-overflow: ellipsis;
    display: block;
}
.margin-top-15 { margin-top:15px; }

body .sortable-item {
    background-image: linear-gradient(to bottom, #ffffff 0%,#eeeeee 100%) !important;
    padding: .75rem;
    vertical-align: top;
    display:table-row;
}
body .handle {
    width: 1em;
    height: 1em;
    background-repeat: no-repeat;
    background-size: contain;
    background-image: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHMAAABkCAMAAACCTv/3AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAZQTFRFAAAA5ubmSUUG+gAAAAJ0Uk5T/wDltzBKAAAAPklEQVR42uzYQQ0AAAgDseHfNC4IyVoD912WAACUm3uampqampqamq+aAAD+IVtTU1NTU1NT0z8EAFBsBRgAX+kR+Qam138AAAAASUVORK5CYII=);
    display:inline-block;
    top: .2em;
    position: relative;
}

body .fr-popup {
    z-index: 1100 !important;
}

.page-right-hand-tools {
    float:right;
}

#content-sub-menu {
    list-style-type: none;
    margin: 0;
    position: absolute;
    right: 12px;
    top: 14px;
    z-index: 50;
}
#content-sub-menu li:first-child {
    margin-left: 0px;
}
#content-sub-menu li {
    float: left;
    margin-left: 6px;
}
.button-02 {
    background: none repeat scroll 0 0 #777777;
    border-radius: 5px 5px 5px 5px;
    color: #FFFFFF !important;
    display: block;
    font-size: 11px;
    margin-bottom: 10px;
    padding: 3px 10px 5px;
    text-decoration: none;
}
.zgXL_db_list_search {
    padding: 5px 10px;
    border-radius: 7px;
    border: 1px solid #aaa;
    font-size: 16px;
}
.BodyContentBox > h2 {
    font-size:20px;
    margin-top: 6px;
    padding-left: 13px;
    margin-bottom: 12px;
}
.dynamic-list {
    padding-left: 0px;
}
.sortable, .unsortable {
    padding-left: 0px;
}

.fas span {
    font-family: ArialNarrow, arial, sans-serif;
    font-weight: normal;
}
.fas:before {
    margin-right: 5px;
}
.fa-save:before {
    position: relative;
    left: 9%;
}
.fas-large {
    display:inline-block;
}
.fas.fas-large:before {
    margin-right: 13px;
}
.ui-autocomplete {
    z-index:1001;
    max-height: calc(100vh - 30%);
    overflow-y: auto;
    overflow-x: hidden;
}
.entityListOuter {
    width:100%;
    overflow-x:auto;
}
.pass-validation {
    border:2px solid #00b90e;
    box-shadow: #00b90e 0 0 5px;
}
.error-validation {
    border:2px solid #ff0000;
    box-shadow: #ff0000 0 0 5px;
}
.error-text {
    color:#ff0000;
    position:absolute;
}
.disabledButton {
    opacity:.3;
}

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

.tabSelectionOuter {
    border-spacing: 10px;
}
.tabSelectionLabel {
    padding:15px;
    border-radius:5px;
    box-shadow:rgba(0,0,0,.3) 0 0 5px;
    border:1px solid #bbb;
    background:#fff;
    cursor: pointer;
}

.tabSelectionLabel h2 {
    font-size:18px;
    text-align: center;
}

.tabSelectionActionButton {
    text-align:center;
    padding: 20px 15px;
}
.tabSelectionActionButton i {
    font-size: 45px;
    width:50px;
    height:50px;
    display: inline-block;
}

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
.pendingStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#9851a0;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.disabledStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#aaaaaa;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.canceledStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#555555;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.activeStatus {
    transform: rotate(-90deg);
    margin: 0px -10px 0px -10px;
    background-color:#0083ff;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.pendingStatusInline {
    background-color:#9851a0;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.queuedStatusInline {
    background-color:#accff3;
    color:#ffffff !important;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.disabledStatusInline {
    background-color:#aaaaaa;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.canceledStatusInline {
    background-color:#555555;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}
.activeStatusInline {
    background-color:#0083ff;
    color:#ffffff;
    padding:5px 10px;
    border-radius: 3px;
    display: inline-block;
}

/** -------------- MOBILE MENU */

<?php

    $intCurrentHour = date('G');
    $blnIsDay = false;

    if ($intCurrentHour > 7 && $intCurrentHour < 20)
    {
        $blnIsDay = true;
    }

 ?>

.user-avatar-box {
<?php if ($blnIsDay === true) { ?>
    background: url(/media/images/mobile-menu-day.jpg) no-repeat center top calc(50% - -31px) / 100% auto !important;
<?php } else { ?>
    background: url(/media/images/mobile-menu-night.jpg)  no-repeat center top calc(50% - -24px) / 100% auto !important;
<?php } ?>
}
.excell-mobile-menu > * {
    pointer-events: none;
}
.user-avatar-image {
    border-radius: 130px;
    width: 100px;
    margin: 25px 0 25px 15px;
    box-shadow: rgba(0,0,0,.3) 0 0 10px;
    cursor:pointer;
}
.user-name-menu {
    line-height: 150px;
    left: -12px;
    position: relative;
}
.user-name-menu span {
    color: #000;
    font-size: 22px;
    font-weight: bold;
    cursor:pointer;
}
.user-sign-out-button {
    color: #fff !important;
    border-radius: 20px;
    border: 0px;
    border-bottom: 0px !important;
    padding: 10px !important;
    cursor: pointer;
    top: 13px;
    float: right;
    position: absolute;
    right: 21px;
    background: url(/media/images/power-button-grey.svg) no-repeat center top calc(50% + 0px) / auto 58%, #cc0000 !important;
    display: block !important;
    width: 35px;
    height: 35px;
}

/** -------------- MOBILE MENU */


div#arc-menu, img.dismiss {
    display: none;
}

div#arc-menu {
    background-color: rgba(255,255,255,0.8);
    z-index:10000;
    position:fixed;
    top:0;
    right:0;
    width: 100%;
}
div#arc-menu .mainLink {
    font-size:16px;
    list-style-type: none;
    text-align: right;
    position: absolute;
    right: 0;
    display: inline-block;
    white-space: nowrap;
    box-sizing: content-box;
}

div#arc-menu .mainLink a {
    box-sizing: content-box;
    color: black;
    text-decoration: none;
    display: inline-block;
    padding: 10px 200px 10px 20px;
    text-align: right;
    -webkit-transition: .3s;
    transition: .3s;
    border-radius: 10px;
}

div#arc-menu .mainLink a.no-transition {
    -webkit-transition: none;
    transition: none;
}

div#arc-menu .mainLink.current a {
    padding-left: 30px;
    background: #4f4f4f;
    background-size: 15px 18px;
    background-position: 10px;
    color:white;
}

div#arc-menu ul.drag .mainLink:not(.nohover) a:hover,
div#arc-menu ul.drag .mainLink a.hover,
div#arc-menu ul.drag .mainLink.img:not(.nohover) a:hover,
div#arc-menu ul.drag .mainLink.img a.hover {
    background-color: #000000;
    color: white;
    cursor: pointer;
}

div#arc-menu .navWrap {
    position: absolute;
    right: 0px;
}

div#arc-menu .mainLink.img a {
    background-color: black;
    height: 18px;
}

/* android fix to vertical center */
div#arc-menu .mainLink.img a img {
    display:block;
}

div#arc-menu .mainLink.audience a {
    background-color: lightgray;
}

div#arc-menu .mainLink.keySelected a {
    background-color: green;
    color:white;
}
div#arc-menu .mainLink.up,
div#arc-menu .mainLink.down {
    z-index: 100;
}

div#arc-menu .mainLink.up img,
div#arc-menu .mainLink.down img
{
    width: 20px;
    height: 15px;
}

div#arc-menu #bg-menu {
    position: absolute;
    right: 0px;
    z-index:101;
    pointer-events: none;
}

div#arc-menu #dismiss {
    position: absolute;
    right: 10px;
    z-index:102;
}
div#arc-menu #dismiss:hover {
    cursor: pointer;
}


/** -------------- CART */

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
#place_order_col_2 .cart-display-box {
    padding-right: 15px;
}
#place_order_col_2 .product-main-data-outer {
    white-space: nowrap;
    background-color: #fff;
    padding: 2px 5px 2px 9px;
    border-radius: 5px;
    box-shadow: rgba(0,0,0,.5) 0 0 5px;
    margin-top: -2px;
    text-align:center;
}
#place_order_col_2 .product-quantity {
    padding-right: 15px;
}
#place_order_col_2 .product-time-box div,
#place_order_col_2 .product-time-box div strong {
    font-size:10px !important;
    line-height: 11px;
}
#place_order_col_2 .product-main-details {
    width: calc( 100% - 70px );
}
#place_order_col_2 .product-main-title-h2 {
    font-size:12px;
    border-bottom: 1px solid #aaaaaa;
}
#place_order_col_2 .cart-display-outer tbody td {
    border-bottom:0px none !important;
}
#place_order_col_3 #place_order_submit.cc_order_submit {
    width:100%;
    padding:10px 15px;
    margin-top:5px;
    background: linear-gradient(to bottom, rgba(254,204,177,1) 0%,rgba(241,116,50,1) 50%,rgba(234,85,7,1) 51%,rgba(251,149,94,1) 100%); /* W3C */
    font-size:16px;
    color:#fff !important;
    font-weight:bold;
    border: 0px none;
    border-radius: 6px;
    box-shadow: rgba(0,0,0,.5) 0 0 4px;
    text-shadow: rgba(0,0,0,0.7) 1px 1px 2px;
}
#place_order_col_3 #place_order_submit.wps_order_submit {
    width: 100%;
    height: 33px;
    margin-top: 5px;
    background: url(/zgcore/dynamic/images/ecom/checkout-paypal.png) no-repeat left top / 100% auto;
    text-indent: -99999px;
    border: 0px none;
}
.item-product .product-subscribe .subscribe_submit {
    width: 113px;
    height: 26px;
    margin-top: -5px;
    background: url(/zgcore/dynamic/images/ecom/subscribe-paypal.png) no-repeat left top / 100% auto;
    text-indent: -99999px;
    border: 0px none;
}
#place_order_col_3 #place_order_submit.wps_order_submit:active {
    background: url(/zgcore/dynamic/images/ecom/checkout-paypal.png) no-repeat left top -33px / 100% auto;
}
#place_order_col_3 #place_order_submit.cc_order_submit:active {
    background: linear-gradient(to bottom, rgba(251,149,94,1) 0%,rgba(234,85,7,1) 49%,rgba(241,116,50,1) 50%,rgba(254,204,177,1) 100%); /* W3C */
}
#subscr_legal {
    position: relative;
    left: -4px;
    top: 3px;
}
#subscr_legal_box {
    font-size: 9px;
    padding: 0 0 10px 0;
    line-height: 11px;
    top: -8px;
}
#place_order_legal {
    position: absolute;
    left: 0px;
    top:6px;
}
#place_order_legal_box {
    font-size: 9px;
    padding: 9px 0 9px 24px;
    line-height: 11px;
}
#place_order_legal_table {
    margin-top:10px;
    position:relative;
}
#place_order_legal_table > div {
    position:relative;
}

@media screen and (max-width: 55.1875em){

    .cbp-spmenu-horizontal {
        font-size: 75%;
        height: 110px;
    }

    .cbp-spmenu-top {
        top: -110px;
    }

    .cbp-spmenu-bottom {
        bottom: -110px;
    }

}

@media screen and (max-height: 26.375em) {

    .cbp-spmenu-vertical {
        font-size: 90%;
        width: 190px;
    }

    .cbp-spmenu-left,
    .cbp-spmenu-push-toleft {
        left: -190px;
    }

    .cbp-spmenu-right {
        right: -190px;
    }

    .cbp-spmenu-push-toright {
        left: 190px;
    }
}

@media (max-width:1200px) {
    .left-side-column .BodyNavigationBox {
        width: 175px;
    }
    .NavigationModule ul li > a, .NavigationModule ul li > span {
        font-size: 13px;
    }
    .NavigationModule > a, .NavigationModule > span {
        font-size: 13px;
    }
    .two-columns .BodyContentBox {
        width: 100%;
        margin: 15px 15px 15px 190px;
    }

    /*.entityDashboard .form-control {*/
    /*    width:115px !important;*/
    /*    padding-left: 7px;*/
    /*    padding-right: 7px;*/
    /*}*/
}

@media (max-width:1000px) {
    body.loggedInBody #datix-logo {
        width: 150px;
    }
    .siteHeader .rightHeader {
        margin-left: 365px;
    }
    body.loggedInBody .headerMenuDiv .menu {
        display:none;
    }
    .loggedInBody .siteHeader-wrapper {
        position:fixed;
        bottom: 0;
    }
    .loggedInBody .siteHeader {
        background: url(/media/images/header-static.png) no-repeat left -10px top / auto 100%, url(/media/images/header-grad.png) repeat-x left 15px  top / auto 100%;
    }
    body.loggedInBody .siteHeader .leftHeaderRight span {
        font-size: 15px;
    }
    body.loggedInBody .siteHeader .leftHeaderRight span span {
        font-size: 13px;
    }
    .loggedInBody .leftHeaderInner > a {
        display: inline-block;
        margin-left: -11px;
        padding-top: 2px;
        text-decoration: none;
        background-color: transparent;
        text-align: center;
        left: 33px;
    }
    .loggedOutBody #becker-sms-logo {
        width: 385px;
    }
    .loggedInBody #becker-sms-logo {
        width: 220px;
    }
    .siteHeader .leftHeader {
        /*width: 315px;*/
    }
    body.loggedInBody .siteHeader .leftHeaderLeft {
        padding-left:0px;
    }
    .form-search-box .form-control {
        height: calc(2.05rem - 8px);
    }
    .portal-body-outer {
        width: calc(100% - 35px);
        max-width: calc(100% - 35px);
    }
    .headerMenuTd:hover > ul > li > a, .headerMenuTd:hover > a {
        background-color:transparent;
    }
    .left-side-column .BodyNavigationBox {
        display:none;
    }
    .two-columns .BodyContentBox {
        width: calc(100% - 20px);
        margin: 10px 10px 10px 10px;
    }
    .entityDashboard .entityTab:not(.showTab) {
        /*display:block;*/
    }
    .dashboard-tab-display {
        display:block;
    }
    .entityDashboard .width100.entityDetails {
        padding-top: 15px;
    }
    /*.entityDashboard .form-control {*/
    /*    width:125px !important;*/
    /*    height: calc(2.25rem - 14px);*/
    /*    top: 3px;*/
    /*    position: relative;*/
    /*    padding-left: 7px;*/
    /*    padding-right: 7px;*/
    /*}*/
    .BodyContentBox .account-page-title {
        font-family: ArialNarrow;
        display: inline-block;
        top: 1px;
        position: relative;
        font-size: 1.25rem;
    }
    .entityButtonFixInTitle {
        top: -3px !important;
    }
    .BodyContentBox .account-page-title .back-to-entity-list {
        width: 18px;
        height: 18px;
    }
    .BodyContentBox .formwrapper-manage-entity {
        padding: 5px 10px;
    }
    .entityDashboard .width50 .card-tile-50,
    .entityDashboard .width100 .card-tile-100 {
        padding: 10px 15px !important;
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
        display:table;
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
    .dashboard-tab {
        display:table-cell !important;
        width: 20%;
        text-align: center;
        border-radius:0px !important;
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
    .BodyContentBox .account-page-title {
        padding-right: 15px;
    }
    .BodyContentBox .form-search-box {
        margin-left: 0px;
    }
    .BodyContentBox .form-search-box input {
        margin-left: 0px;
    }
}
@media (max-width:650px) {
    .loggedInBody .leftHeaderInner > a {
        left: 4px;
    }
}
@media (max-width:620px) {
    .siteLoginBody {
        margin: 50px 10px;
    }
    body.loggedInBody .leftHeaderRight {
        display:none;
    }
    body.loggedOutBody .leftHeaderInner > a {
        width: 225px;
    }
    .siteHeader .rightHeader {
        margin-left: 225px;
    }
    .portal-title-menu h1 a {
        font-size: 13px;
    }
    .portal-title-menu h1 {
        font-size: 13px;
        padding: 5px 15px 7px;
    }
    .global-back-arrow {
        width: 11px !important;
    }
    .login-field-table .login-field-row > div {
        display: block;
    }
    .login-field-table .login-field-row:nth-child(1) > div {
        padding-top: 5px;
    }
    .fieldsetGrouping label {
        top: 0px;
        float:none;
        font-size: 19px;
    }
    .loggedOutBody #becker-sms-logo {
        width: 325px;
    }
    #frmPasswordResetRequest .login-field-table .login-field-row > div:first-child {
        width:100%;
    }
    .siteLoginFloat * {
        font-size:18px;
    }
    .siteLoginFloat legend, .siteLoginFloat legend a {
        font-size:11px !important;
    }
    body.loggedInBody .siteHeader label {
        display:none;
    }
    .add-request-data-inner > table #add-request-quantity input[type="text"] {
        width: calc(100% - 5px);
    }
    .fformwrapper-header table td {
        display:block;
    }
    .fformwrapper-header table .account-page-title, .fformwrapper-header table .form-search-box {
        display:table-cell;
    }
    .zgpopup-dialog-body .table.no-top-border tr > td:first-child,
    .zgpopup-dialog-body .table.no-top-border tr > td:last-child {
        display:block;
        padding: .15rem;
    }
    .BodyContentBox .entityDetailsInner {
        overflow-x: auto;
        overflow-y: hidden;
    }
    .BodyContentBox .account-page-title {
        padding-left: 10px;
    }

    .BodyContentBox .form-search-box {
        /*width:100%;*/
    }
}
@media (max-width:525px) {
    body.loggedOutBody .siteLoginBody {
        margin: 15px 10px;
    }
    body.loggedOutBody .siteLoginFloat {
        padding: 25px 25px 35px;
    }
    body.loggedInBody .floatRightHeader {

    }
    body.loggedOutBody .siteHeader {
        height: 110px;
        background: transparent;
    }
    body.loggedOutBody #datix-logo {
        width: 150px;
    }
    body.loggedOutBody .centerHeaderInner a {
        padding-top: 17px;
    }
}
