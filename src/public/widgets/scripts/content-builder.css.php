<?php

header('Content-Type:text/css');
?>

body {
    overflow-x: hidden !important;
}

svg {
    overflow: hidden;
    vertical-align: middle;
    pointer-events: none;
}

.is-icon-flex {
    width: 16px;
    height: 16px;
}

a:focus,
button:focus {
    outline: none;
}

.clearfix:before,
.clearfix:after {
    content: " ";
    display: table;
}

.clearfix:after {
    clear: both;
}

.clearfix {
    *zoom: 1;
    clear: none;
}

.transition1 {
    transition: all ease 0.1s;
}

.is-builder {
    transition: all ease 0.3s;
    transform-origin: top;
}
.is-builder > div > div:focus {
    outline: none;
}
.is-builder .is-subblock:focus {
    outline: none;
}
.is-builder > div {
    position: relative;
    transition: none;
    margin-left: 0;
    margin-right: 0;
    width: auto;
}
.is-builder[gridoutline] > div > div {
    outline: 1px solid rgba(132, 132, 132, 0.27);
    outline-offset: 1px;
}
.is-builder > div > div.cell-active {
    outline: 1px solid #00da89;
}
.is-builder .row-active {
    outline: 1px solid #00da89;
    z-index: 1;
}
.is-builder .row-active.row-outline {
    outline: 1px solid rgba(132, 132, 132, 0.2);
}
.is-builder .row-active:not(.row-outline) > div.cell-active {
    outline: none;
}
.is-builder table.default td {
    border: transparent 1px dashed;
}
.is-builder .cell-active .elm-active {
    background: rgba(200, 200, 201, 0.11);
}
.is-builder .cell-active table.elm-active {
    background-color: transparent;
}
.is-builder .cell-active table.default td {
    border: #cccccc 1px dashed;
}
.is-builder .cell-active hr {
    cursor: pointer;
}
.is-builder .cell-active[data-html] {
    background-color: rgba(200, 200, 201, 0.11);
}
.is-builder .cell-active .icon-active {
    background-color: rgba(200, 200, 201, 0.4);
}
.is-builder .elm-inspected {
    animation-name: elm-inspected-anim;
    animation-duration: 0.6s;
    outline: 1px solid #ffb84a !important;
}
.is-builder .elm-inspected .elm-active {
    background: none;
}
@keyframes elm-inspected-anim {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(0.97);
    }
    100% {
        transform: scale(1);
    }
}

@media (min-width: 640px) {
    .is-builder > div {
        display: flex;
    }
}
.sortable-drag {
    background: transparent;
    outline: none !important;
}
.sortable-drag * {
    opacity: 0;
}
.sortable-drag .is-row-tool {
    opacity: 0;
}

.sortable-ghost {
    background: rgba(204, 204, 204, 0.15);
    width: 100%;
    outline: none !important;
}
.sortable-ghost * {
    outline: none !important;
}
.sortable-ghost .is-row-tool {
    display: none !important;
}

#_cbhtml .snippet-item {
    cursor: move !important;
}
#_cbhtml .snippet-item.sortable-chosen {
    height: auto;
}
#_cbhtml .snippet-item.sortable-chosen * {
    visibility: visible;
}
#_cbhtml .snippet-item.sortable-chosen.sortable-drag * {
    visibility: hidden;
    transition: none !important;
}
#_cbhtml .snippet-item.sortable-drag {
    outline: none !important;
}

.is-builder .snippet-item.sortable-ghost {
    width: 100%;
    background: rgba(204, 204, 204, 0.15);
    height: 40px;
}
.is-builder .snippet-item.sortable-ghost * {
    visibility: hidden;
}

.moveable-control {
    border: none !important;
    width: 7px !important;
    height: 7px !important;
    margin-top: -3px !important;
    margin-left: -3px !important;
    background: #333 !important;
}
.moveable-control.moveable-origin {
    display: none !important;
}

.moveable-direction.moveable-s, .moveable-direction.moveable-n {
    display: none !important;
}
.moveable-direction.moveable-e, .moveable-direction.moveable-w {
    display: none !important;
}

.moveable-line {
    display: none !important;
}

#_cbhtml,
.is-ui {
    font-family: sans-serif;
    font-size: 13px;
    letter-spacing: 1px;
    font-weight: 300px;
    /*
    .rte-align-options,
    .rte-formatting-options,
    .rte-list-options,
    .rte-more-options,
    .elementrte-more-options,
    .rte-textsetting-options,
    .rte-color-picker,
    .rte-icon-options,
    .rte-fontfamily-options,
    .rte-customtag-options,
    .rte-paragraph-options,
    .rte-zoom-options
    */
}
#_cbhtml *,
.is-ui * {
    font-family: sans-serif;
    line-height: inherit;
}
#_cbhtml p,
.is-ui p {
    font-size: 14px;
}
#_cbhtml .style-helper,
.is-ui .style-helper {
    display: none;
    background: #fff;
    color: #121212;
}
#_cbhtml .style-helper.on,
.is-ui .style-helper.on {
    background: whitesmoke;
}
#_cbhtml .style-helper.hover,
.is-ui .style-helper.hover {
    background: whitesmoke;
}
#_cbhtml .style-helper svg,
.is-ui .style-helper svg {
    fill: #000;
}
#_cbhtml .style-helper.modal-color,
.is-ui .style-helper.modal-color {
    background: #000;
}
#_cbhtml .style-helper.modal-background,
.is-ui .style-helper.modal-background {
    background: #fff;
}
#_cbhtml .style-helper.button-pickcolor-border,
.is-ui .style-helper.button-pickcolor-border {
    border: rgba(0, 0, 0, 0.09) 1px solid;
}
#_cbhtml .style-helper.button-pickcolor-background,
.is-ui .style-helper.button-pickcolor-background {
    background: rgba(255, 255, 255, 0.2);
}
#_cbhtml .style-helper.snippet-color,
.is-ui .style-helper.snippet-color {
    background: #000;
}
#_cbhtml .style-helper.snippet-background,
.is-ui .style-helper.snippet-background {
    background: #fff;
}
#_cbhtml .style-helper.snippet-tabs-background,
.is-ui .style-helper.snippet-tabs-background {
    background: whitesmoke;
}
#_cbhtml .style-helper.snippet-tab-item-background,
.is-ui .style-helper.snippet-tab-item-background {
    background: #fff;
}
#_cbhtml .style-helper.snippet-tab-item-background-active,
.is-ui .style-helper.snippet-tab-item-background-active {
    background: whitesmoke;
}
#_cbhtml .style-helper.snippet-tab-item-background-hover,
.is-ui .style-helper.snippet-tab-item-background-hover {
    background: #fff;
}
#_cbhtml .style-helper.snippet-tab-item-color,
.is-ui .style-helper.snippet-tab-item-color {
    background: #000;
}
#_cbhtml .style-helper.snippet-more-item-background,
.is-ui .style-helper.snippet-more-item-background {
    background: #fff;
}
#_cbhtml .style-helper.snippet-more-item-background-active,
.is-ui .style-helper.snippet-more-item-background-active {
    background: #f7f7f7;
}
#_cbhtml .style-helper.snippet-more-item-background-hover,
.is-ui .style-helper.snippet-more-item-background-hover {
    background: #f7f7f7;
}
#_cbhtml .style-helper.snippet-more-item-color,
.is-ui .style-helper.snippet-more-item-color {
    background: #000;
}
#_cbhtml .style-helper.tabs-background,
.is-ui .style-helper.tabs-background {
    background: #fafafa;
}
#_cbhtml .style-helper.tab-item-active-border-bottom,
.is-ui .style-helper.tab-item-active-border-bottom {
    border: #595959 1px solid;
}
#_cbhtml .style-helper.tab-item-color,
.is-ui .style-helper.tab-item-color {
    background: #4a4a4a;
}
#_cbhtml .style-helper.tabs-more-background,
.is-ui .style-helper.tabs-more-background {
    background: #fff;
}
#_cbhtml .style-helper.tabs-more-border,
.is-ui .style-helper.tabs-more-border {
    border: 1px solid #f2f2f2;
}
#_cbhtml .style-helper.tabs-more-item-color,
.is-ui .style-helper.tabs-more-item-color {
    background: #4a4a4a;
}
#_cbhtml .style-helper.tabs-more-item-background-hover,
.is-ui .style-helper.tabs-more-item-background-hover {
    background: whitesmoke;
}
#_cbhtml .style-helper.separator-color,
.is-ui .style-helper.separator-color {
    background: #f0f0f0;
}
#_cbhtml .style-helper-button-classic,
.is-ui .style-helper-button-classic {
    background: #f7f7f7;
    color: #000;
}
#_cbhtml .style-helper-button-classic.hover,
.is-ui .style-helper-button-classic.hover {
    background: #f9f9f9;
}
#_cbhtml .style-helper-button-classic svg,
.is-ui .style-helper-button-classic svg {
    fill: #000;
}
#_cbhtml .is-pop,
.is-ui .is-pop {
    display: none;
    z-index: 10003;
    position: absolute;
    top: 0;
    left: 0;
    background: #fff;
    border: 1px solid #f2f2f2;
    box-shadow: 4px 17px 20px 0px rgba(0, 0, 0, 0.08);
}
#_cbhtml .is-pop:hover,
.is-ui .is-pop:hover {
    z-index: 10003;
}
#_cbhtml .is-pop.arrow-top:after, #_cbhtml .is-pop.arrow-top:before,
.is-ui .is-pop.arrow-top:after,
.is-ui .is-pop.arrow-top:before {
    bottom: 100%;
    left: 25px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
    top: auto;
}
#_cbhtml .is-pop.arrow-top:after,
.is-ui .is-pop.arrow-top:after {
    border-color: transparent;
    border-bottom-color: #fff;
    border-width: 7px;
    margin-left: -7px;
}
#_cbhtml .is-pop.arrow-top:before,
.is-ui .is-pop.arrow-top:before {
    border-color: transparent;
    border-bottom-color: #e0e0e0;
    border-width: 8px;
    margin-left: -8px;
}
#_cbhtml .is-pop.arrow-top.right:after, #_cbhtml .is-pop.arrow-top.right:before,
.is-ui .is-pop.arrow-top.right:after,
.is-ui .is-pop.arrow-top.right:before {
    left: auto;
}
#_cbhtml .is-pop.arrow-top.right:after,
.is-ui .is-pop.arrow-top.right:after {
    right: 19px;
}
#_cbhtml .is-pop.arrow-top.right:before,
.is-ui .is-pop.arrow-top.right:before {
    right: 18px;
}
#_cbhtml .is-pop.arrow-top.left:after, #_cbhtml .is-pop.arrow-top.left:before,
.is-ui .is-pop.arrow-top.left:after,
.is-ui .is-pop.arrow-top.left:before {
    right: auto;
}
#_cbhtml .is-pop.arrow-top.left:after,
.is-ui .is-pop.arrow-top.left:after {
    left: 18px;
}
#_cbhtml .is-pop.arrow-top.left:before,
.is-ui .is-pop.arrow-top.left:before {
    left: 18px;
}
#_cbhtml .is-pop.arrow-top.center:after, #_cbhtml .is-pop.arrow-top.center:before,
.is-ui .is-pop.arrow-top.center:after,
.is-ui .is-pop.arrow-top.center:before {
    left: calc(50% + 3px);
}
#_cbhtml .is-pop.arrow-left:after, #_cbhtml .is-pop.arrow-left:before,
.is-ui .is-pop.arrow-left:after,
.is-ui .is-pop.arrow-left:before {
    right: 100%;
    top: 20px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
#_cbhtml .is-pop.arrow-left:after,
.is-ui .is-pop.arrow-left:after {
    border-color: transparent;
    border-right-color: #fff;
    border-width: 7px;
    margin-top: -7px;
}
#_cbhtml .is-pop.arrow-left:before,
.is-ui .is-pop.arrow-left:before {
    border-color: transparent;
    border-right-color: #e0e0e0;
    border-width: 8px;
    margin-top: -8px;
}
#_cbhtml .is-pop.arrow-left.bottom:after, #_cbhtml .is-pop.arrow-left.bottom:before,
.is-ui .is-pop.arrow-left.bottom:after,
.is-ui .is-pop.arrow-left.bottom:before {
    top: calc(100% - 28px);
}
#_cbhtml .is-pop.arrow-right:after, #_cbhtml .is-pop.arrow-right:before,
.is-ui .is-pop.arrow-right:after,
.is-ui .is-pop.arrow-right:before {
    left: 100%;
    top: 20px;
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
#_cbhtml .is-pop.arrow-right:after,
.is-ui .is-pop.arrow-right:after {
    border-color: transparent;
    border-left-color: #fff;
    border-width: 7px;
    margin-top: -7px;
}
#_cbhtml .is-pop.arrow-right:before,
.is-ui .is-pop.arrow-right:before {
    border-color: transparent;
    border-left-color: #e0e0e0;
    border-width: 8px;
    margin-top: -8px;
}
#_cbhtml .is-pop.arrow-bottom:after, #_cbhtml .is-pop.arrow-bottom:before,
.is-ui .is-pop.arrow-bottom:after,
.is-ui .is-pop.arrow-bottom:before {
    top: 100%;
    left: calc(100% - 28px);
    border: solid transparent;
    content: " ";
    height: 0;
    width: 0;
    position: absolute;
    pointer-events: none;
}
#_cbhtml .is-pop.arrow-bottom:after,
.is-ui .is-pop.arrow-bottom:after {
    border-color: transparent;
    border-top-color: #fff;
    border-width: 7px;
    margin-left: -7px;
}
#_cbhtml .is-pop.arrow-bottom:before,
.is-ui .is-pop.arrow-bottom:before {
    border-color: transparent;
    border-top-color: #e0e0e0;
    border-width: 8px;
    margin-left: -8px;
}
#_cbhtml .is-pop.arrow-bottom.center:after, #_cbhtml .is-pop.arrow-bottom.center:before,
.is-ui .is-pop.arrow-bottom.center:after,
.is-ui .is-pop.arrow-bottom.center:before {
    left: calc(50% + 3px);
}
#_cbhtml .is-pop-tabs,
.is-ui .is-pop-tabs {
    display: flex;
    width: 100%;
    margin-bottom: 5px;
}
#_cbhtml .is-pop-tabs > div,
.is-ui .is-pop-tabs > div {
    background: #f7f7f7;
    width: 50%;
    height: 30px;
    line-height: 30px;
    box-sizing: border-box;
    text-align: center;
    font-size: 9px;
    font-weight: 400;
    text-transform: uppercase;
    color: #121212;
}
#_cbhtml .is-pop-tabs > div.is-pop-tab-item,
.is-ui .is-pop-tabs > div.is-pop-tab-item {
    cursor: pointer;
}
#_cbhtml .is-pop-tabs > div.active,
.is-ui .is-pop-tabs > div.active {
    background: transparent;
    cursor: auto;
}
#_cbhtml .is-rte-tool,
#_cbhtml .is-elementrte-tool,
.is-ui .is-rte-tool,
.is-ui .is-elementrte-tool {
    top: 25px;
}
#_cbhtml .is-rte-tool > div:not(.is-draggable),
#_cbhtml .is-elementrte-tool > div:not(.is-draggable),
.is-ui .is-rte-tool > div:not(.is-draggable),
.is-ui .is-elementrte-tool > div:not(.is-draggable) {
    padding: 8px 10px 8px 10px;
}
#_cbhtml .is-rte-tool,
#_cbhtml .is-elementrte-tool,
#_cbhtml .is-rte-pop.rte-more-options,
#_cbhtml .is-rte-pop.elementrte-more-options,
.is-ui .is-rte-tool,
.is-ui .is-elementrte-tool,
.is-ui .is-rte-pop.rte-more-options,
.is-ui .is-rte-pop.elementrte-more-options {
    z-index: 10001;
    padding: 0;
    color: #000;
    background: #fff;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 5px 9px 0px;
}
#_cbhtml .is-rte-tool button,
#_cbhtml .is-elementrte-tool button,
#_cbhtml .is-rte-pop.rte-more-options button,
#_cbhtml .is-rte-pop.elementrte-more-options button,
.is-ui .is-rte-tool button,
.is-ui .is-elementrte-tool button,
.is-ui .is-rte-pop.rte-more-options button,
.is-ui .is-rte-pop.elementrte-more-options button {
    background-color: transparent;
    color: #121212;
    width: 45px;
    height: 40px;
    margin: 0;
    box-shadow: none;
}
#_cbhtml .is-rte-tool button.on,
#_cbhtml .is-elementrte-tool button.on,
#_cbhtml .is-rte-pop.rte-more-options button.on,
#_cbhtml .is-rte-pop.elementrte-more-options button.on,
.is-ui .is-rte-tool button.on,
.is-ui .is-elementrte-tool button.on,
.is-ui .is-rte-pop.rte-more-options button.on,
.is-ui .is-rte-pop.elementrte-more-options button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-tool button:hover,
#_cbhtml .is-elementrte-tool button:hover,
#_cbhtml .is-rte-pop.rte-more-options button:hover,
#_cbhtml .is-rte-pop.elementrte-more-options button:hover,
.is-ui .is-rte-tool button:hover,
.is-ui .is-elementrte-tool button:hover,
.is-ui .is-rte-pop.rte-more-options button:hover,
.is-ui .is-rte-pop.elementrte-more-options button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-tool button svg,
#_cbhtml .is-elementrte-tool button svg,
#_cbhtml .is-rte-pop.rte-more-options button svg,
#_cbhtml .is-rte-pop.elementrte-more-options button svg,
.is-ui .is-rte-tool button svg,
.is-ui .is-elementrte-tool button svg,
.is-ui .is-rte-pop.rte-more-options button svg,
.is-ui .is-rte-pop.elementrte-more-options button svg {
    fill: #000;
}
#_cbhtml .is-rte-tool .rte-separator,
#_cbhtml .is-elementrte-tool .rte-separator,
#_cbhtml .is-rte-pop.rte-more-options .rte-separator,
#_cbhtml .is-rte-pop.elementrte-more-options .rte-separator,
.is-ui .is-rte-tool .rte-separator,
.is-ui .is-elementrte-tool .rte-separator,
.is-ui .is-rte-pop.rte-more-options .rte-separator,
.is-ui .is-rte-pop.elementrte-more-options .rte-separator {
    height: 30px;
    width: 1px;
    background: #e3e3e3;
    margin: 7px 3px 0;
}
#_cbhtml[toolbarleft] .is-rte-tool,
#_cbhtml[toolbarleft] .is-elementrte-tool,
.is-ui[toolbarleft] .is-rte-tool,
.is-ui[toolbarleft] .is-elementrte-tool {
    left: 25px;
    box-shadow: rgba(0, 0, 0, 0.05) 6px 0px 9px 0px;
}
#_cbhtml[toolbarright] .is-rte-tool,
#_cbhtml[toolbarright] .is-elementrte-tool,
.is-ui[toolbarright] .is-rte-tool,
.is-ui[toolbarright] .is-elementrte-tool {
    right: 35px;
    left: auto;
    box-shadow: rgba(0, 0, 0, 0.05) -4px 0px 9px 0px;
}
#_cbhtml[toolbarleft] .is-rte-tool > div:not(.is-draggable),
#_cbhtml[toolbarleft] .is-elementrte-tool > div:not(.is-draggable), #_cbhtml[toolbarright] .is-rte-tool > div:not(.is-draggable),
#_cbhtml[toolbarright] .is-elementrte-tool > div:not(.is-draggable),
.is-ui[toolbarleft] .is-rte-tool > div:not(.is-draggable),
.is-ui[toolbarleft] .is-elementrte-tool > div:not(.is-draggable),
.is-ui[toolbarright] .is-rte-tool > div:not(.is-draggable),
.is-ui[toolbarright] .is-elementrte-tool > div:not(.is-draggable) {
    flex-direction: column;
    padding: 8px 9px 8px 9px;
}
#_cbhtml[toolbarleft] .is-rte-tool .rte-separator,
#_cbhtml[toolbarleft] .is-elementrte-tool .rte-separator,
#_cbhtml[toolbarleft] .rte-more-options .rte-separator,
#_cbhtml[toolbarleft] .elementrte-more-options .rte-separator, #_cbhtml[toolbarright] .is-rte-tool .rte-separator,
#_cbhtml[toolbarright] .is-elementrte-tool .rte-separator,
#_cbhtml[toolbarright] .rte-more-options .rte-separator,
#_cbhtml[toolbarright] .elementrte-more-options .rte-separator,
.is-ui[toolbarleft] .is-rte-tool .rte-separator,
.is-ui[toolbarleft] .is-elementrte-tool .rte-separator,
.is-ui[toolbarleft] .rte-more-options .rte-separator,
.is-ui[toolbarleft] .elementrte-more-options .rte-separator,
.is-ui[toolbarright] .is-rte-tool .rte-separator,
.is-ui[toolbarright] .is-elementrte-tool .rte-separator,
.is-ui[toolbarright] .rte-more-options .rte-separator,
.is-ui[toolbarright] .elementrte-more-options .rte-separator {
    height: 1px;
    width: 34px;
    margin: 3px 0 3px 7px;
}
#_cbhtml .is-rte-pop,
.is-ui .is-rte-pop {
    z-index: 10002;
    display: none;
    position: fixed;
    height: 0;
    border: none;
    color: #000;
    background: #fff;
    box-shadow: rgba(0, 0, 0, 0.07) 0px 7px 12px 0px;
    box-sizing: border-box;
    overflow: hidden;
}
#_cbhtml .is-rte-pop > div,
.is-ui .is-rte-pop > div {
    display: flex;
    padding: 1px 9px 9px 9px;
}
#_cbhtml .is-rte-pop button,
.is-ui .is-rte-pop button {
    width: 46px;
    height: 40px;
    margin: 0;
    background-color: transparent;
    box-shadow: none;
}
#_cbhtml .is-rte-pop button.on,
.is-ui .is-rte-pop button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop button:hover,
.is-ui .is-rte-pop button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop .is-label,
.is-ui .is-rte-pop .is-label {
    font-size: 9px;
    font-weight: bold;
    text-transform: uppercase;
    line-height: 2;
    padding: 8px 0 2px;
    text-align: center;
}
#_cbhtml .is-rte-pop .is-label.separator,
.is-ui .is-rte-pop .is-label.separator {
    margin-top: 5px;
    border-top: #f0f0f0 1px solid;
}
#_cbhtml .is-rte-pop.active,
.is-ui .is-rte-pop.active {
    animation-name: formatting-slide-out;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-slide-out {
    from {
        height: 0px;
    }
    to {
        height: 49px;
    }
}
#_cbhtml .is-rte-pop.deactive,
.is-ui .is-rte-pop.deactive {
    animation-name: formatting-slide-in;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-slide-in {
    from {
        height: 49px;
    }
    to {
        height: 0px;
    }
}
#_cbhtml .is-rte-pop.rte-paragraph-options.active,
.is-ui .is-rte-pop.rte-paragraph-options.active {
    animation-name: paragraph-slide-out;
}
@keyframes paragraph-slide-out {
    from {
        height: 0;
    }
    to {
        height: 286px;
    }
}
#_cbhtml .is-rte-pop.rte-paragraph-options.deactive,
.is-ui .is-rte-pop.rte-paragraph-options.deactive {
    animation-name: paragraph-slide-in;
}
@keyframes paragraph-slide-in {
    from {
        height: 286px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-paragraph-options div.on,
.is-ui .is-rte-pop.rte-paragraph-options div.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-paragraph-options > div,
.is-ui .is-rte-pop.rte-paragraph-options > div {
    width: 242px;
    padding: 1px 9px 9px;
    box-sizing: border-box;
    overflow-x: hidden;
    flex-direction: column;
}
#_cbhtml .is-rte-pop.rte-paragraph-options > div > div,
.is-ui .is-rte-pop.rte-paragraph-options > div > div {
    cursor: pointer;
    overflow: hidden;
    padding: 5px 0;
    box-sizing: border-box;
}
#_cbhtml .is-rte-pop.rte-paragraph-options > div > div:hover,
.is-ui .is-rte-pop.rte-paragraph-options > div > div:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-paragraph-options > div > div > *,
.is-ui .is-rte-pop.rte-paragraph-options > div > div > * {
    text-transform: none !important;
    margin: 0 !important;
    line-height: 1.45 !important;
    text-align: center;
}
#_cbhtml .is-rte-pop.rte-textsetting-options > div,
.is-ui .is-rte-pop.rte-textsetting-options > div {
    width: 224px;
    flex-direction: column;
    padding: 1px 12px 12px 12px;
    box-sizing: border-box;
}
#_cbhtml .is-rte-pop.rte-textsetting-options button,
.is-ui .is-rte-pop.rte-textsetting-options button {
    width: 40px;
    height: 30px;
    box-shadow: none;
    background: transparent;
}
#_cbhtml .is-rte-pop.rte-textsetting-options button.on,
.is-ui .is-rte-pop.rte-textsetting-options button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-textsetting-options button:hover,
.is-ui .is-rte-pop.rte-textsetting-options button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-textsetting-options.active,
.is-ui .is-rte-pop.rte-textsetting-options.active {
    animation-name: textsetting-slide-out;
}
@keyframes textsetting-slide-out {
    from {
        height: 0;
    }
    to {
        height: 288px;
    }
}
#_cbhtml .is-rte-pop.rte-textsetting-options.deactive,
.is-ui .is-rte-pop.rte-textsetting-options.deactive {
    animation-name: textsetting-slide-in;
}
@keyframes textsetting-slide-in {
    from {
        height: 288px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-formatting-options button,
.is-ui .is-rte-pop.rte-formatting-options button {
    box-shadow: none;
    background: transparent;
}
#_cbhtml .is-rte-pop.rte-formatting-options button.on,
.is-ui .is-rte-pop.rte-formatting-options button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-formatting-options button:hover,
.is-ui .is-rte-pop.rte-formatting-options button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-list-options button,
.is-ui .is-rte-pop.rte-list-options button {
    box-shadow: none;
    background: transparent;
}
#_cbhtml .is-rte-pop.rte-list-options button.on,
.is-ui .is-rte-pop.rte-list-options button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-list-options button:hover,
.is-ui .is-rte-pop.rte-list-options button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-align-options button,
.is-ui .is-rte-pop.rte-align-options button {
    box-shadow: none;
    background: transparent;
}
#_cbhtml .is-rte-pop.rte-align-options button.on,
.is-ui .is-rte-pop.rte-align-options button.on {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-align-options button:hover,
.is-ui .is-rte-pop.rte-align-options button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-color-picker,
.is-ui .is-rte-pop.rte-color-picker {
    flex-direction: column;
}
#_cbhtml .is-rte-pop.rte-color-picker > div,
.is-ui .is-rte-pop.rte-color-picker > div {
    padding: 0;
}
#_cbhtml .is-rte-pop.rte-color-picker button,
.is-ui .is-rte-pop.rte-color-picker button {
    background-color: transparent;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
}
#_cbhtml .is-rte-pop.rte-color-picker button:hover,
.is-ui .is-rte-pop.rte-color-picker button:hover {
    background: transparent;
}
#_cbhtml .is-rte-pop.rte-color-picker.active,
.is-ui .is-rte-pop.rte-color-picker.active {
    animation-name: colorpicker-slide-out;
}
@keyframes colorpicker-slide-out {
    from {
        height: 0;
    }
    to {
        height: 445px;
    }
}
#_cbhtml .is-rte-pop.rte-color-picker.deactive,
.is-ui .is-rte-pop.rte-color-picker.deactive {
    animation-name: colorpicker-slide-in;
}
@keyframes colorpicker-slide-in {
    from {
        height: 445px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-color-picker .is-pop-tabs,
.is-ui .is-rte-pop.rte-color-picker .is-pop-tabs {
    padding: 3px 12px 0;
    box-sizing: border-box;
}
#_cbhtml .is-rte-pop.rte-color-picker .rte-color-picker-area > div,
.is-ui .is-rte-pop.rte-color-picker .rte-color-picker-area > div {
    padding-top: 5px !important;
}
#_cbhtml .is-rte-pop.rte-icon-options,
.is-ui .is-rte-pop.rte-icon-options {
    width: 280px;
}
#_cbhtml .is-rte-pop.rte-icon-options iframe,
.is-ui .is-rte-pop.rte-icon-options iframe {
    margin: 1px 0 0;
    width: 100%;
    max-width: 300px;
    height: 100%;
    border: none;
}
#_cbhtml .is-rte-pop.rte-icon-options.active,
.is-ui .is-rte-pop.rte-icon-options.active {
    animation-name: icon-slide-out;
}
@keyframes icon-slide-out {
    from {
        height: 0;
    }
    to {
        height: 240px;
    }
}
#_cbhtml .is-rte-pop.rte-icon-options.deactive,
.is-ui .is-rte-pop.rte-icon-options.deactive {
    animation-name: icon-slide-in;
}
@keyframes icon-slide-in {
    from {
        height: 240px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-fontfamily-options iframe,
.is-ui .is-rte-pop.rte-fontfamily-options iframe {
    margin: 1px 0 0;
    width: 100%;
    max-width: 260px;
    height: 100%;
    border: none;
}
#_cbhtml .is-rte-pop.rte-fontfamily-options.active,
.is-ui .is-rte-pop.rte-fontfamily-options.active {
    animation-name: fontfamily-slide-out;
}
@keyframes fontfamily-slide-out {
    from {
        height: 0;
    }
    to {
        height: 263px;
    }
}
#_cbhtml .is-rte-pop.rte-fontfamily-options.deactive,
.is-ui .is-rte-pop.rte-fontfamily-options.deactive {
    animation-name: fontfamily-slide-in;
}
@keyframes fontfamily-slide-in {
    from {
        height: 263px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-customtag-options.active,
.is-ui .is-rte-pop.rte-customtag-options.active {
    animation-name: customtag-slide-out;
}
@keyframes customtag-slide-out {
    from {
        height: 0;
    }
    to {
        height: 125px;
    }
}
#_cbhtml .is-rte-pop.rte-customtag-options.deactive,
.is-ui .is-rte-pop.rte-customtag-options.deactive {
    animation-name: customtag-slide-in;
}
@keyframes customtag-slide-in {
    from {
        height: 125px;
    }
    to {
        height: 0;
    }
}
#_cbhtml .is-rte-pop.rte-customtag-options > div,
.is-ui .is-rte-pop.rte-customtag-options > div {
    width: 180px;
    padding: 1px 9px 9px;
    box-sizing: border-box;
    overflow-x: hidden;
    overflow-y: auto;
    flex-direction: column;
}
#_cbhtml .is-rte-pop.rte-customtag-options > div button,
.is-ui .is-rte-pop.rte-customtag-options > div button {
    font-size: 11px;
    width: 100%;
    box-shadow: none;
    background: transparent;
    flex: none;
}
#_cbhtml .is-rte-pop.rte-customtag-options > div button:hover,
.is-ui .is-rte-pop.rte-customtag-options > div button:hover {
    background: whitesmoke;
}
#_cbhtml .is-rte-pop.rte-zoom-options > div,
.is-ui .is-rte-pop.rte-zoom-options > div {
    width: 224px;
    flex-direction: column;
    padding: 1px 12px 12px 12px;
    box-sizing: border-box;
}
#_cbhtml .is-rte-pop.rte-zoom-options.active,
.is-ui .is-rte-pop.rte-zoom-options.active {
    animation-name: zoomsetting-slide-out;
}
@keyframes zoomsetting-slide-out {
    from {
        height: 0;
    }
    to {
        height: 78px;
    }
}
#_cbhtml .is-rte-pop.rte-zoom-options.deactive,
.is-ui .is-rte-pop.rte-zoom-options.deactive {
    animation-name: zoomsetting-slide-in;
}
@keyframes zoomsetting-slide-in {
    from {
        height: 78px;
    }
    to {
        height: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop,
.is-ui[toolbarleft] .is-rte-pop {
    height: auto;
    width: 0;
    flex-direction: column;
    box-shadow: rgba(0, 0, 0, 0.05) 5px 0px 9px 0px;
}
#_cbhtml[toolbarleft] .is-rte-pop > div,
.is-ui[toolbarleft] .is-rte-pop > div {
    flex-direction: column;
    padding: 9px 9px 9px 1px;
}
#_cbhtml[toolbarleft] .is-rte-pop.active,
.is-ui[toolbarleft] .is-rte-pop.active {
    animation-name: formatting-leftslide-out;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 55px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.deactive,
.is-ui[toolbarleft] .is-rte-pop.deactive {
    animation-name: formatting-leftslide-in;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-leftslide-in {
    from {
        width: 55px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-paragraph-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-paragraph-options.active {
    animation-name: paragraph-leftslide-out;
}
@keyframes paragraph-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 250px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-paragraph-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-paragraph-options.deactive {
    animation-name: paragraph-leftslide-in;
}
@keyframes paragraph-leftslide-in {
    from {
        width: 250px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-paragraph-options > div,
.is-ui[toolbarleft] .is-rte-pop.rte-paragraph-options > div {
    width: 245px;
    padding: 9px;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-textsetting-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-textsetting-options.active {
    animation-name: textsetting-leftslide-out;
}
@keyframes textsetting-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 213px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-textsetting-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-textsetting-options.deactive {
    animation-name: textsetting-leftslide-in;
}
@keyframes textsetting-leftslide-in {
    from {
        width: 213px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-fontfamily-options,
.is-ui[toolbarleft] .is-rte-pop.rte-fontfamily-options {
    height: 260px;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-fontfamily-options iframe,
.is-ui[toolbarleft] .is-rte-pop.rte-fontfamily-options iframe {
    margin: 9px 0 9px 0;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-fontfamily-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-fontfamily-options.active {
    animation-name: fontfamily-leftslide-out;
}
@keyframes fontfamily-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 260px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-fontfamily-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-fontfamily-options.deactive {
    animation-name: fontfamily-leftslide-in;
}
@keyframes fontfamily-leftslide-in {
    from {
        width: 260px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-customtag-options > div,
.is-ui[toolbarleft] .is-rte-pop.rte-customtag-options > div {
    width: 180px;
    height: 125px;
    padding: 9px 9px 9px;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-customtag-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-customtag-options.active {
    animation-name: customtag-leftslide-out;
}
@keyframes customtag-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 180px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-customtag-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-customtag-options.deactive {
    animation-name: customtag-leftslide-in;
}
@keyframes customtag-leftslide-in {
    from {
        width: 180px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-color-picker,
.is-ui[toolbarleft] .is-rte-pop.rte-color-picker {
    height: 452px;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-color-picker.active,
.is-ui[toolbarleft] .is-rte-pop.rte-color-picker.active {
    animation-name: colorpicker-leftslide-out;
}
@keyframes colorpicker-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 270px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-color-picker.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-color-picker.deactive {
    animation-name: colorpicker-leftslide-in;
}
@keyframes colorpicker-leftslide-in {
    from {
        width: 270px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-color-picker .is-pop-tabs,
.is-ui[toolbarleft] .is-rte-pop.rte-color-picker .is-pop-tabs {
    flex-direction: row;
    padding: 11px 12px 0;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-color-picker .rte-color-picker-area,
.is-ui[toolbarleft] .is-rte-pop.rte-color-picker .rte-color-picker-area {
    padding: 0;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-icon-options,
.is-ui[toolbarleft] .is-rte-pop.rte-icon-options {
    height: 320px;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-icon-options iframe,
.is-ui[toolbarleft] .is-rte-pop.rte-icon-options iframe {
    margin: 9px 0 9px 0;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-icon-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-icon-options.active {
    animation-name: icon-leftslide-out;
}
@keyframes icon-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 280px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-icon-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-icon-options.deactive {
    animation-name: icon-leftslide-in;
}
@keyframes icon-leftslide-in {
    from {
        width: 280px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-zoom-options > div,
.is-ui[toolbarleft] .is-rte-pop.rte-zoom-options > div {
    width: 224px;
    flex-direction: column;
    padding: 1px 12px 12px 12px;
    box-sizing: border-box;
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-zoom-options.active,
.is-ui[toolbarleft] .is-rte-pop.rte-zoom-options.active {
    animation-name: zoomsetting-leftslide-out;
}
@keyframes zoomsetting-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 225px;
    }
}
#_cbhtml[toolbarleft] .is-rte-pop.rte-zoom-options.deactive,
.is-ui[toolbarleft] .is-rte-pop.rte-zoom-options.deactive {
    animation-name: zoomsetting-leftslide-in;
}
@keyframes zoomsetting-leftslide-in {
    from {
        width: 225px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop,
.is-ui[toolbarright] .is-rte-pop {
    height: auto;
    width: 0;
    flex-direction: column;
    box-shadow: rgba(0, 0, 0, 0.05) -6px 1px 9px 0px;
}
#_cbhtml[toolbarright] .is-rte-pop > div,
.is-ui[toolbarright] .is-rte-pop > div {
    flex-direction: column;
    padding: 9px 2px 9px 9px;
}
#_cbhtml[toolbarright] .is-rte-pop.active,
.is-ui[toolbarright] .is-rte-pop.active {
    animation-name: formatting-rightslide-out;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 55px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.deactive,
.is-ui[toolbarright] .is-rte-pop.deactive {
    animation-name: formatting-rightslide-in;
    animation-duration: 0.1s;
    animation-fill-mode: forwards;
}
@keyframes formatting-rightslide-in {
    from {
        width: 55px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-paragraph-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-paragraph-options.active {
    animation-name: paragraph-rightslide-out;
}
@keyframes paragraph-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 250px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-paragraph-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-paragraph-options.deactive {
    animation-name: paragraph-rightslide-in;
}
@keyframes paragraph-rightslide-in {
    from {
        width: 250px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-paragraph-options > div,
.is-ui[toolbarright] .is-rte-pop.rte-paragraph-options > div {
    width: 245px;
    padding: 9px;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-textsetting-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-textsetting-options.active {
    animation-name: textsetting-rightslide-out;
}
@keyframes textsetting-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 225px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-textsetting-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-textsetting-options.deactive {
    animation-name: textsetting-rightslide-in;
}
@keyframes textsetting-rightslide-in {
    from {
        width: 225px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-fontfamily-options,
.is-ui[toolbarright] .is-rte-pop.rte-fontfamily-options {
    height: 260px;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-fontfamily-options iframe,
.is-ui[toolbarright] .is-rte-pop.rte-fontfamily-options iframe {
    margin: 9px 0 9px 0;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-fontfamily-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-fontfamily-options.active {
    animation-name: fontfamily-leftslide-out;
}
@keyframes fontfamily-leftslide-out {
    from {
        width: 0;
    }
    to {
        width: 260px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-fontfamily-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-fontfamily-options.deactive {
    animation-name: fontfamily-leftslide-in;
}
@keyframes fontfamily-leftslide-in {
    from {
        width: 260px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-customtag-options > div,
.is-ui[toolbarright] .is-rte-pop.rte-customtag-options > div {
    width: 180px;
    height: 125px;
    padding: 9px 9px 9px;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-customtag-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-customtag-options.active {
    animation-name: customtag-rightslide-out;
}
@keyframes customtag-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 180px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-customtag-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-customtag-options.deactive {
    animation-name: customtag-rightslide-in;
}
@keyframes customtag-rightslide-in {
    from {
        width: 180px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-icon-options,
.is-ui[toolbarright] .is-rte-pop.rte-icon-options {
    height: 320px;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-icon-options iframe,
.is-ui[toolbarright] .is-rte-pop.rte-icon-options iframe {
    margin: 9px 0 9px 0;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-icon-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-icon-options.active {
    animation-name: icon-rightslide-out;
}
@keyframes icon-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 280px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-icon-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-icon-options.deactive {
    animation-name: icon-rightslide-in;
}
@keyframes icon-rightslide-in {
    from {
        width: 280px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-color-picker,
.is-ui[toolbarright] .is-rte-pop.rte-color-picker {
    height: 452px;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-color-picker.active,
.is-ui[toolbarright] .is-rte-pop.rte-color-picker.active {
    animation-name: colorpicker-rightslide-out;
}
@keyframes colorpicker-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 270px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-color-picker.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-color-picker.deactive {
    animation-name: colorpicker-rightslide-in;
}
@keyframes colorpicker-rightslide-in {
    from {
        width: 270px;
    }
    to {
        width: 0;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-color-picker .is-pop-tabs,
.is-ui[toolbarright] .is-rte-pop.rte-color-picker .is-pop-tabs {
    flex-direction: row;
    padding: 11px 12px 0;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-color-picker .rte-color-picker-area,
.is-ui[toolbarright] .is-rte-pop.rte-color-picker .rte-color-picker-area {
    padding: 0;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-zoom-options > div,
.is-ui[toolbarright] .is-rte-pop.rte-zoom-options > div {
    width: 224px;
    flex-direction: column;
    padding: 1px 12px 12px 12px;
    box-sizing: border-box;
}
#_cbhtml[toolbarright] .is-rte-pop.rte-zoom-options.active,
.is-ui[toolbarright] .is-rte-pop.rte-zoom-options.active {
    animation-name: zoomsetting-rightslide-out;
}
@keyframes zoomsetting-rightslide-out {
    from {
        width: 0;
    }
    to {
        width: 225px;
    }
}
#_cbhtml[toolbarright] .is-rte-pop.rte-zoom-options.deactive,
.is-ui[toolbarright] .is-rte-pop.rte-zoom-options.deactive {
    animation-name: zoomsetting-rightslide-in;
}
@keyframes zoomsetting-rightslide-in {
    from {
        width: 225px;
    }
    to {
        width: 0;
    }
}
#_cbhtml .is-modal,
.is-ui .is-modal {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    display: none;
    z-index: 10004;
    background: rgba(255, 255, 255, 0.000001);
    justify-content: center;
    align-items: center;
    flex-direction: column;
    font-family: sans-serif;
}
#_cbhtml .is-modal.active,
.is-ui .is-modal.active {
    display: flex;
}
#_cbhtml .is-modal button,
.is-ui .is-modal button {
    color: #000;
    background: #fff;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
}
#_cbhtml .is-modal button:hover,
.is-ui .is-modal button:hover {
    background: #fff;
}
#_cbhtml .is-modal button.on,
.is-ui .is-modal button.on {
    background: #f2f2f2;
}
#_cbhtml .is-modal .is-modal-overlay,
.is-ui .is-modal .is-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.000001);
    z-index: -1;
    max-width: none !important;
    margin: 0 !important;
}
#_cbhtml .is-modal .is-modal-overlay.overlay-stay,
.is-ui .is-modal .is-modal-overlay.overlay-stay {
    background: rgba(255, 255, 255, 0.3);
}
#_cbhtml .is-modal.is-modal-content,
#_cbhtml .is-modal .is-modal-content,
.is-ui .is-modal.is-modal-content,
.is-ui .is-modal .is-modal-content {
    background: #fff;
    border: 1px solid #f2f2f2;
    box-shadow: 4px 17px 20px 0px rgba(0, 0, 0, 0.08);
}
#_cbhtml .is-modal .is-modal-content,
.is-ui .is-modal .is-modal-content {
    position: relative;
    width: 100%;
    padding: 20px 20px;
    box-sizing: border-box;
}
#_cbhtml .is-modal:not(.is-modal-content) > div:not(.is-modal-overlay),
.is-ui .is-modal:not(.is-modal-content) > div:not(.is-modal-overlay) {
    background: #fff;
    border: 1px solid #f2f2f2;
    box-shadow: 4px 17px 20px 0px rgba(0, 0, 0, 0.08);
    position: relative;
    width: 100%;
    padding: 20px 20px;
    box-sizing: border-box;
}
#_cbhtml .is-modal.is-modal-full > div:not(.is-modal-overlay),
.is-ui .is-modal.is-modal-full > div:not(.is-modal-overlay) {
    width: 100% !important;
    height: 100% !important;
    max-width: 100% !important;
    max-height: 100% !important;
}
#_cbhtml .is-modal div.is-draggable,
.is-ui .is-modal div.is-draggable {
    cursor: move;
    box-shadow: none;
    background: transparent;
    padding: 0;
    border: none;
}
#_cbhtml .is-modal div.is-modal-bar,
.is-ui .is-modal div.is-modal-bar {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    flex: none;
    background: transparent;
    border: none;
    box-sizing: border-box;
    text-align: center;
    font-family: sans-serif;
    font-size: 13px;
    letter-spacing: 1px;
    color: #545454;
    touch-action: none;
    user-select: none;
    z-index: 1;
    line-height: 35px;
    height: 35px;
}
#_cbhtml .is-modal div.is-modal-bar .is-modal-close,
.is-ui .is-modal div.is-modal-bar .is-modal-close {
    z-index: 1;
    width: 32px;
    height: 32px;
    position: absolute;
    top: 0px;
    right: 0px;
    box-sizing: border-box;
    padding: 0;
    line-height: 32px;
    font-size: 12px;
    color: #545454;
    text-align: center;
    cursor: pointer;
}
#_cbhtml .is-modal.previewcontent,
.is-ui .is-modal.previewcontent {
    background: #d1d1d1;
}
#_cbhtml .is-modal.previewcontent .size-control,
.is-ui .is-modal.previewcontent .size-control {
    cursor: pointer;
    background: #f7f7f7;
    border-left: #dedede 2px solid;
    border-right: #dedede 2px solid;
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}
#_cbhtml .is-modal.previewcontent .size-control-info,
.is-ui .is-modal.previewcontent .size-control-info {
    text-align: center;
    color: #000;
}
#_cbhtml .is-modal.previewcontent .size-control.hover,
.is-ui .is-modal.previewcontent .size-control.hover {
    background: #f0f0f0;
}
#_cbhtml .is-modal.is-confirm div.is-modal-content,
.is-ui .is-modal.is-confirm div.is-modal-content {
    max-width: 526px;
    text-align: center;
}
#_cbhtml .is-modal.viewconfig div.is-modal-content,
.is-ui .is-modal.viewconfig div.is-modal-content {
    max-width: 700px;
    padding: 5px 17px 17px 17px;
}
#_cbhtml .is-modal.viewhtml, #_cbhtml .is-modal.viewhtmlformatted, #_cbhtml .is-modal.viewhtmlnormal,
.is-ui .is-modal.viewhtml,
.is-ui .is-modal.viewhtmlformatted,
.is-ui .is-modal.viewhtmlnormal {
    z-index: 10005;
}
#_cbhtml .is-modal.viewhtml div.is-modal-content, #_cbhtml .is-modal.viewhtmlformatted div.is-modal-content, #_cbhtml .is-modal.viewhtmlnormal div.is-modal-content,
.is-ui .is-modal.viewhtml div.is-modal-content,
.is-ui .is-modal.viewhtmlformatted div.is-modal-content,
.is-ui .is-modal.viewhtmlnormal div.is-modal-content {
    width: 80%;
    max-width: 1200px;
    height: 80%;
    padding: 0;
    box-sizing: border-box;
    position: relative;
    overflow: hidden;
}
#_cbhtml .is-modal.viewhtmllarger,
.is-ui .is-modal.viewhtmllarger {
    z-index: 10005;
    align-items: flex-end;
}
#_cbhtml .is-modal.viewhtmllarger div.is-modal-content,
.is-ui .is-modal.viewhtmllarger div.is-modal-content {
    width: 100%;
    height: 100%;
    border: none;
    padding: 0;
}
#_cbhtml .is-modal.grideditor,
.is-ui .is-modal.grideditor {
    background: #fff;
    width: 96px;
    height: 450px;
    top: 50%;
    left: auto;
    right: 80px;
    margin-top: -220px;
    box-sizing: content-box;
    overflow: hidden;
}
#_cbhtml .is-modal.grideditor .is-modal-bar,
.is-ui .is-modal.grideditor .is-modal-bar {
    z-index: 1;
    height: 20px;
}
#_cbhtml .is-modal.grideditor .is-modal-bar .is-modal-close,
.is-ui .is-modal.grideditor .is-modal-bar .is-modal-close {
    width: 20px;
    height: 20px;
    line-height: 20px;
    font-size: 10px;
}
#_cbhtml .is-modal.grideditor.active,
.is-ui .is-modal.grideditor.active {
    display: flex;
}
#_cbhtml .is-modal.grideditor > div,
.is-ui .is-modal.grideditor > div {
    width: 100%;
    box-sizing: border-box;
    padding: 0;
    border: none;
}
#_cbhtml .is-modal.grideditor button,
.is-ui .is-modal.grideditor button {
    width: 48px;
    height: 40px;
    background-color: transparent !important;
    box-shadow: none !important;
}
#_cbhtml .is-modal.grideditor .is-separator,
.is-ui .is-modal.grideditor .is-separator {
    width: 100%;
    border-top: #f2f2f2 1px solid;
    display: flex;
}
#_cbhtml .is-modal.pickgradientcolor div.is-modal-content,
.is-ui .is-modal.pickgradientcolor div.is-modal-content {
    max-width: 201px;
    padding: 0;
}
#_cbhtml .is-modal.pickgradientcolor .is-modal-bar,
.is-ui .is-modal.pickgradientcolor .is-modal-bar {
    height: 10px;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings,
.is-ui .is-modal.pickgradientcolor .is-settings {
    margin-bottom: 15px;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings > div,
.is-ui .is-modal.pickgradientcolor .is-settings > div {
    display: flex;
    align-items: center;
    height: 50px;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings > div.is-label,
.is-ui .is-modal.pickgradientcolor .is-settings > div.is-label {
    height: auto;
    font-family: sans-serif;
    font-size: 13px;
    font-weight: 300;
    letter-spacing: 1px;
    margin: 10px 0 3px;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings button,
.is-ui .is-modal.pickgradientcolor .is-settings button {
    width: auto;
    height: 37px;
    font-size: 10px;
    line-height: 1;
    text-transform: uppercase;
    padding: 1px 20px;
    box-sizing: border-box;
    border: none;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings button.is-btn-color,
.is-ui .is-modal.pickgradientcolor .is-settings button.is-btn-color {
    width: 35px;
    height: 35px;
    padding: 0;
    background: rgba(255, 255, 255, 0.2);
    border: rgba(0, 0, 0, 0.09) 1px solid;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings button .is-elmgrad-remove,
.is-ui .is-modal.pickgradientcolor .is-settings button .is-elmgrad-remove {
    position: absolute;
    top: 0px;
    right: 0px;
    width: 20px;
    height: 20px;
    background: rgba(95, 94, 94, 0.26);
    color: #fff;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    cursor: pointer;
    display: none;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings button[data-elmgradient].active .is-elmgrad-remove,
.is-ui .is-modal.pickgradientcolor .is-settings button[data-elmgradient].active .is-elmgrad-remove {
    display: block;
}
#_cbhtml .is-modal.pickgradientcolor .is-settings label,
.is-ui .is-modal.pickgradientcolor .is-settings label {
    font-size: 14px;
    color: inherit;
}
#_cbhtml .is-modal.pickgradientcolor button.input-gradient-clear,
#_cbhtml .is-modal.pickgradientcolor button.input-gradient-clear:hover,
.is-ui .is-modal.pickgradientcolor button.input-gradient-clear,
.is-ui .is-modal.pickgradientcolor button.input-gradient-clear:hover {
    border: transparent 1px solid;
    background-color: transparent;
}
#_cbhtml .is-modal.edittable,
.is-ui .is-modal.edittable {
    z-index: 10002;
    position: fixed;
    overflow: hidden;
    width: 250px;
    height: 410px;
    top: 50%;
    left: auto;
    right: 30%;
    margin-top: -205px;
    box-sizing: content-box;
    flex-direction: row;
    align-items: flex-start;
}
#_cbhtml .is-modal.edittable .is-modal-bar,
.is-ui .is-modal.edittable .is-modal-bar {
    line-height: 30px;
    height: 30px;
    background-color: #fafafa;
}
#_cbhtml .is-modal.edittable .is-modal-bar .is-modal-close,
.is-ui .is-modal.edittable .is-modal-bar .is-modal-close {
    width: 20px;
    height: 20px;
    line-height: 20px;
    font-size: 10px;
}
#_cbhtml .is-modal.edittable.active,
.is-ui .is-modal.edittable.active {
    display: flex;
}
#_cbhtml .is-modal.edittable > div:not(.is-draggable),
.is-ui .is-modal.edittable > div:not(.is-draggable) {
    width: 100%;
    margin-top: 30px;
}
#_cbhtml .is-modal.edittable button,
.is-ui .is-modal.edittable button {
    height: 35px;
}
#_cbhtml .is-modal.edittable button.is-btn-color,
.is-ui .is-modal.edittable button.is-btn-color {
    width: 35px;
    height: 35px;
    padding: 0;
    background: rgba(255, 255, 255, 0.2);
    border: rgba(0, 0, 0, 0.09) 1px solid;
}
#_cbhtml .is-modal.columnsettings .is-modal-bar,
.is-ui .is-modal.columnsettings .is-modal-bar {
    background-color: #fafafa;
}
#_cbhtml .is-modal.columnsettings.active,
.is-ui .is-modal.columnsettings.active {
    display: flex;
}
#_cbhtml .is-modal.columnsettings > div:not(.is-draggable),
.is-ui .is-modal.columnsettings > div:not(.is-draggable) {
    width: 100%;
    margin-top: 30px;
}
#_cbhtml .is-modal.columnsettings button,
.is-ui .is-modal.columnsettings button {
    width: auto;
    height: 35px;
    font-size: 10px;
    line-height: 1;
    text-transform: uppercase;
    padding: 1px 20px;
    box-sizing: border-box;
    border: none;
}
#_cbhtml .is-modal.columnsettings button.is-btn-color,
.is-ui .is-modal.columnsettings button.is-btn-color {
    width: 35px;
    height: 35px;
    padding: 0;
    background: rgba(255, 255, 255, 0.2);
    border: rgba(0, 0, 0, 0.09) 1px solid;
}
#_cbhtml .is-modal.columnsettings button span,
.is-ui .is-modal.columnsettings button span {
    margin-left: 5px;
}
#_cbhtml .is-modal.columnsettings button svg,
.is-ui .is-modal.columnsettings button svg {
    width: 12px;
    height: 12px;
    flex: none;
}
#_cbhtml .is-modal.columnsettings button.input-cell-bgimage,
.is-ui .is-modal.columnsettings button.input-cell-bgimage {
    margin-right: 1px;
}
#_cbhtml .is-modal.columnsettings button.input-cell-bgimage svg,
.is-ui .is-modal.columnsettings button.input-cell-bgimage svg {
    width: 14px;
    height: 14px;
}
#_cbhtml .is-modal.columnsettings button.input-cell-bgimageadjust,
.is-ui .is-modal.columnsettings button.input-cell-bgimageadjust {
    width: 40px;
}
#_cbhtml .is-modal.columnsettings .cell-bgimage-preview,
.is-ui .is-modal.columnsettings .cell-bgimage-preview {
    max-width: 120px;
    max-height: 120px;
}
#_cbhtml .is-modal.columnsettings .cell-bgimage-preview img,
.is-ui .is-modal.columnsettings .cell-bgimage-preview img {
    max-width: 100%;
    max-height: 100%;
}
#_cbhtml .is-modal.columnsettings .div-content-padding,
#_cbhtml .is-modal.columnsettings .div-content-height,
.is-ui .is-modal.columnsettings .div-content-padding,
.is-ui .is-modal.columnsettings .div-content-height {
    display: flex;
}
#_cbhtml .is-modal.columnsettings .div-content-padding button,
#_cbhtml .is-modal.columnsettings .div-content-height button,
.is-ui .is-modal.columnsettings .div-content-padding button,
.is-ui .is-modal.columnsettings .div-content-height button {
    width: 40px;
    margin-right: 1px;
}
#_cbhtml .is-modal.columnsettings .div-content-padding button svg,
#_cbhtml .is-modal.columnsettings .div-content-height button svg,
.is-ui .is-modal.columnsettings .div-content-padding button svg,
.is-ui .is-modal.columnsettings .div-content-height button svg {
    flex: none;
}
#_cbhtml .is-modal.columnsettings .div-content-textcolor,
.is-ui .is-modal.columnsettings .div-content-textcolor {
    display: flex;
}
#_cbhtml .is-modal.columnsettings .div-content-textcolor button,
.is-ui .is-modal.columnsettings .div-content-textcolor button {
    width: 40px;
}
#_cbhtml .is-modal.columnsettings .div-content-textcolor button[data-command=dark],
.is-ui .is-modal.columnsettings .div-content-textcolor button[data-command=dark] {
    width: auto;
    background-color: #f7f7f7;
    color: #111;
}
#_cbhtml .is-modal.columnsettings .div-content-textcolor button[data-command=light],
.is-ui .is-modal.columnsettings .div-content-textcolor button[data-command=light] {
    width: auto;
    background-color: #333;
    color: #f7f7f7;
}
#_cbhtml .is-modal.columnsettings .div-content-position,
.is-ui .is-modal.columnsettings .div-content-position {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    width: 184px;
    padding: 0;
}
#_cbhtml .is-modal.columnsettings .div-content-position button,
.is-ui .is-modal.columnsettings .div-content-position button {
    width: 40px;
}
#_cbhtml .is-modal.columnsettings .div-content-position button svg,
.is-ui .is-modal.columnsettings .div-content-position button svg {
    flex: none;
}
#_cbhtml .is-modal.columnsettings .image-src,
.is-ui .is-modal.columnsettings .image-src {
    display: flex;
}
#_cbhtml .is-modal.columnsettings .image-src > button,
.is-ui .is-modal.columnsettings .image-src > button {
    background: transparent !important;
}
#_cbhtml .is-modal.columnsettings #divCellClick p,
.is-ui .is-modal.columnsettings #divCellClick p {
    font-size: 13px;
    line-height: 1.7;
}
#_cbhtml .is-modal.imagesource .is-modal-content,
.is-ui .is-modal.imagesource .is-modal-content {
    padding: 20px;
}
#_cbhtml .is-modal.imagesource .image-src,
.is-ui .is-modal.imagesource .image-src {
    display: flex;
}
#_cbhtml .is-modal.imagesource .image-src > button,
.is-ui .is-modal.imagesource .image-src > button {
    background: transparent !important;
}
#_cbhtml .is-modal.pickfontfamily .is-modal-bar,
.is-ui .is-modal.pickfontfamily .is-modal-bar {
    background: #fafafa;
}
#_cbhtml .is-modal.pickfontfamily div.is-modal-content,
.is-ui .is-modal.pickfontfamily div.is-modal-content {
    max-width: 303px;
    padding: 0;
}
#_cbhtml .is-modal.editstyles .is-modal-bar .is-modal-close,
.is-ui .is-modal.editstyles .is-modal-bar .is-modal-close {
    width: 20px;
    height: 20px;
    line-height: 20px;
    font-size: 10px;
}
#_cbhtml .is-modal.pickcolor div.is-modal-content,
.is-ui .is-modal.pickcolor div.is-modal-content {
    max-width: 271px;
    padding: 12px 12px;
}
#_cbhtml .is-modal.pickcolor .is-modal-bar,
.is-ui .is-modal.pickcolor .is-modal-bar {
    height: 11px;
}
#_cbhtml .is-modal.pickcolormore div.is-modal-content,
.is-ui .is-modal.pickcolormore div.is-modal-content {
    max-width: 340px;
}
#_cbhtml .is-modal.pickcolormore .is-modal-bar,
.is-ui .is-modal.pickcolormore .is-modal-bar {
    height: 11px;
}
#_cbhtml .is-modal.insertimage .is-drop-area,
.is-ui .is-modal.insertimage .is-drop-area {
    border: 2px dashed #b3b3b3;
    position: relative;
}
#_cbhtml .is-modal.insertimage .is-drop-area:hover,
.is-ui .is-modal.insertimage .is-drop-area:hover {
    background-color: #f7f7f7;
}
#_cbhtml .is-modal.insertimage .is-drop-area.image-dropping,
.is-ui .is-modal.insertimage .is-drop-area.image-dropping {
    background-color: #f7f7f7;
}
#_cbhtml .is-modal.insertimage .is-drop-area #fileInsertImage,
.is-ui .is-modal.insertimage .is-drop-area #fileInsertImage {
    position: absolute;
    margin: 0;
    padding: 0;
    width: 100%;
    height: 100%;
    outline: none;
    opacity: 0;
    cursor: pointer;
}
#_cbhtml .is-modal.insertimage .is-drop-area .drag-text p,
.is-ui .is-modal.insertimage .is-drop-area .drag-text p {
    font-size: 12px;
    text-align: center;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 60px 0;
}
#_cbhtml .is-modal.insertimage .is-preview-area,
.is-ui .is-modal.insertimage .is-preview-area {
    display: none;
    text-align: center;
}
#_cbhtml .is-modal.insertimage .is-preview-area div,
.is-ui .is-modal.insertimage .is-preview-area div {
    position: relative;
    display: inline-block;
    margin: 10px;
}
#_cbhtml .is-modal.insertimage .is-preview-area div i,
.is-ui .is-modal.insertimage .is-preview-area div i {
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    background: rgba(255, 255, 255, 0.8);
    color: #000;
    width: 28px;
    height: 28px;
    text-align: center;
    line-height: 28px;
    font-size: 27px;
    box-sizing: border-box;
    padding-left: 1px;
    cursor: pointer;
}
#_cbhtml .is-modal.insertimage .is-preview-area #imgInsertImagePreview,
.is-ui .is-modal.insertimage .is-preview-area #imgInsertImagePreview {
    max-height: 200px;
    max-width: 200px;
}
#_cbhtml .is-modal.insertimage .image-src,
.is-ui .is-modal.insertimage .image-src {
    display: flex;
}
#_cbhtml .is-modal.insertimage .image-src > button,
.is-ui .is-modal.insertimage .image-src > button {
    background: transparent !important;
}
#_cbhtml .is-modal.imageedit div.is-modal-content,
.is-ui .is-modal.imageedit div.is-modal-content {
    width: auto;
    padding-top: 7px;
}
#_cbhtml .is-modal.imageedit .imageedit-crop button,
.is-ui .is-modal.imageedit .imageedit-crop button {
    margin: 0 20px 0 0;
    border: #d1d1d1 1px solid;
    background-color: transparent !important;
}
#_cbhtml .is-modal.imagelink div.is-modal-content,
.is-ui .is-modal.imagelink div.is-modal-content {
    max-width: 526px;
}
#_cbhtml .is-modal.imagelink .image-src,
.is-ui .is-modal.imagelink .image-src {
    display: flex;
}
#_cbhtml .is-modal.imagelink .image-src > button,
.is-ui .is-modal.imagelink .image-src > button {
    background: transparent !important;
}
#_cbhtml .is-modal.imagelink .image-link,
.is-ui .is-modal.imagelink .image-link {
    display: flex;
}
#_cbhtml .is-modal.imagelink .image-link button,
.is-ui .is-modal.imagelink .image-link button {
    background: transparent !important;
}
#_cbhtml .is-modal.imagelink .form-upload-larger.please-wait svg,
.is-ui .is-modal.imagelink .form-upload-larger.please-wait svg {
    transform: scale(1, 1);
    opacity: 1;
    animation-name: please-wait-anim;
    animation-duration: 3s;
    animation-fill-mode: forwards;
    animation-iteration-count: infinite;
}
@keyframes please-wait-anim {
    0% {
        transform: scale(1, 1);
        opacity: 0;
    }
    25% {
        transform: scale(1.2, 1.2);
        opacity: 1;
    }
    50% {
        transform: scale(1, 1);
        opacity: 0;
    }
    75% {
        transform: scale(1.2, 1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1, 1);
        opacity: 0;
    }
}
#_cbhtml .is-modal.iframelink div.is-modal-content,
.is-ui .is-modal.iframelink div.is-modal-content {
    max-width: 550px;
}
#_cbhtml .is-modal.createlink div.is-modal-content,
.is-ui .is-modal.createlink div.is-modal-content {
    max-width: 526px;
}
#_cbhtml .is-modal.createlink .link-src,
.is-ui .is-modal.createlink .link-src {
    position: relative;
    height: 50px;
    display: flex;
    flex-direction: row;
}
#_cbhtml .is-modal.createlink .link-src .input-url,
.is-ui .is-modal.createlink .link-src .input-url {
    width: 100%;
}
#_cbhtml .is-modal.createlink .link-src button,
.is-ui .is-modal.createlink .link-src button {
    background: transparent !important;
}
#_cbhtml .is-modal.createlink .input-select,
.is-ui .is-modal.createlink .input-select {
    width: 60px;
    font-size: 20px;
    height: 50px;
    border-left: none;
    background: transparent;
}
#_cbhtml .is-modal.viewconfig .div-themes,
.is-ui .is-modal.viewconfig .div-themes {
    display: flex;
    flex-flow: wrap;
    width: 189px;
    border: rgba(255, 255, 255, 0.15) 1px solid;
    box-sizing: content-box;
}
#_cbhtml .is-modal.viewconfig button.input-setcolor,
.is-ui .is-modal.viewconfig button.input-setcolor {
    width: 27px;
    height: 25px;
    border: transparent 1px solid;
}
#_cbhtml .is-tool#divImageTool,
.is-ui .is-tool#divImageTool {
    background: rgba(0, 0, 0, 0.15);
    border: transparent 1px solid;
}
#_cbhtml .is-tool#divImageTool > div, #_cbhtml .is-tool#divImageTool > button,
.is-ui .is-tool#divImageTool > div,
.is-ui .is-tool#divImageTool > button {
    background: transparent;
}
#_cbhtml .is-tool#divImageTool svg,
.is-ui .is-tool#divImageTool svg {
    fill: #fff;
}
#_cbhtml .is-tool#divImageResizer,
.is-ui .is-tool#divImageResizer {
    background: rgba(0, 0, 0, 0);
    width: 1px;
    height: 1px;
    z-index: 10;
    touch-action: none;
}
#_cbhtml .is-tool.is-spacer-tool,
.is-ui .is-tool.is-spacer-tool {
    border: none;
    background: none;
}
#_cbhtml .is-tool.is-spacer-tool > button,
.is-ui .is-tool.is-spacer-tool > button {
    width: 30px;
    height: 30px;
    background: rgba(240, 240, 240, 0.9);
}
#_cbhtml .is-tool.is-spacer-tool > button svg,
.is-ui .is-tool.is-spacer-tool > button svg {
    fill: #121212;
}
#_cbhtml .is-tool.is-table-tool,
.is-ui .is-tool.is-table-tool {
    border: none;
    background: none;
}
#_cbhtml .is-tool.is-table-tool:hover,
.is-ui .is-tool.is-table-tool:hover {
    z-index: 10001 !important;
}
#_cbhtml .is-tool.is-table-tool > button,
.is-ui .is-tool.is-table-tool > button {
    width: 30px;
    height: 30px;
    background: rgba(240, 240, 240, 0.9);
}
#_cbhtml .is-tool.is-table-tool > button svg,
.is-ui .is-tool.is-table-tool > button svg {
    fill: #121212;
}
#_cbhtml .is-tool.is-code-tool, #_cbhtml .is-tool.is-module-tool,
.is-ui .is-tool.is-code-tool,
.is-ui .is-tool.is-module-tool {
    border: none;
    background: none;
}
#_cbhtml .is-tool.is-code-tool > button, #_cbhtml .is-tool.is-module-tool > button,
.is-ui .is-tool.is-code-tool > button,
.is-ui .is-tool.is-module-tool > button {
    width: 30px;
    height: 30px;
    background: rgba(240, 240, 240, 0.9);
}
#_cbhtml .is-tool.is-code-tool > button svg, #_cbhtml .is-tool.is-module-tool > button svg,
.is-ui .is-tool.is-code-tool > button svg,
.is-ui .is-tool.is-module-tool > button svg {
    fill: #121212;
}
#_cbhtml .is-tool#divLinkTool button,
.is-ui .is-tool#divLinkTool button {
    width: 30px;
    height: 30px;
    background: rgba(243, 243, 243, 0.9);
}
#_cbhtml .is-tool#divLinkTool button svg,
.is-ui .is-tool#divLinkTool button svg {
    fill: #121212;
}
#_cbhtml .dot,
.is-ui .dot {
    height: 7px;
    width: 7px;
    border-radius: 50%;
    display: inline-block;
    margin: 25px 2px 0;
    -webkit-animation: jump 1.5s linear infinite;
}
@-webkit-keyframes jump {
    0%, 100% {
        transform: translateY(0px);
    }
    20% {
        transform: translateY(-10px);
    }
    40% {
        transform: translateY(0px);
    }
}
#_cbhtml .dot:nth-of-type(2),
.is-ui .dot:nth-of-type(2) {
    -webkit-animation-delay: 0.2s;
}
#_cbhtml .dot:nth-of-type(3),
.is-ui .dot:nth-of-type(3) {
    -webkit-animation-delay: 0.4s;
}
#_cbhtml #divImageProgress,
.is-ui #divImageProgress {
    display: none;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 1;
    box-sizing: border-box;
    background: rgba(0, 0, 0, 0.15);
    transition: none;
}
#_cbhtml #divImageProgress > div,
.is-ui #divImageProgress > div {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
}
#_cbhtml #divImageProgress .dot,
.is-ui #divImageProgress .dot {
    background-color: #fff;
    margin: 10px 2px 0;
}
#_cbhtml .is-side,
.is-ui .is-side {
    display: block;
    position: fixed;
    top: 0;
    right: -367px;
    left: auto;
    width: 365px;
    height: 100%;
    border: none;
    box-shadow: rgba(0, 0, 0, 0.05) 0 0 16px 0px;
    box-sizing: border-box;
    background: #fff;
    transition: all ease 0.3s;
    font-family: sans-serif;
    font-size: 14px;
    letter-spacing: 1px;
    z-index: 10003;
}
#_cbhtml .is-side.active,
.is-ui .is-side.active {
    right: 0;
}
#_cbhtml .is-side.fromleft,
.is-ui .is-side.fromleft {
    left: -367px;
    right: auto;
    border: none;
    border-right: 1px solid #e0e0e0;
}
#_cbhtml .is-side.fromleft.active,
.is-ui .is-side.fromleft.active {
    left: 0;
}
#_cbhtml .is-side > div,
.is-ui .is-side > div {
    width: 100%;
    background: none;
    border: none;
    box-shadow: none;
    padding: 0;
}
#_cbhtml button,
#_cbhtml .is-btn,
.is-ui button,
.is-ui .is-btn {
    color: #121212;
    background: #f7f7f7;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
    width: auto;
    height: 45px;
    border: none;
    font-family: sans-serif;
    font-size: 12px;
    letter-spacing: 1px;
    font-weight: 300;
    opacity: 1;
    line-height: 1;
    display: inline-block;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    cursor: pointer;
    text-transform: none;
    text-align: center;
    position: relative;
    border-radius: 0;
    user-select: none;
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
    white-space: nowrap;
    display: flex;
    align-items: center;
    justify-content: center;
}
#_cbhtml button:hover,
#_cbhtml .is-btn:hover,
.is-ui button:hover,
.is-ui .is-btn:hover {
    background: #f9f9f9;
}
#_cbhtml button svg,
#_cbhtml .is-btn svg,
.is-ui button svg,
.is-ui .is-btn svg {
    fill: #000;
}
#_cbhtml button:focus,
#_cbhtml .is-btn:focus,
.is-ui button:focus,
.is-ui .is-btn:focus {
    outline: none;
}
#_cbhtml button.fullwidth,
#_cbhtml .is-btn.fullwidth,
.is-ui button.fullwidth,
.is-ui .is-btn.fullwidth {
    width: 100%;
}
#_cbhtml button.classic,
#_cbhtml .is-btn.classic,
.is-ui button.classic,
.is-ui .is-btn.classic {
    width: 100%;
    height: 50px;
    display: block;
    background: #f7f7f7;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
}
#_cbhtml button.classic:hover,
#_cbhtml .is-btn.classic:hover,
.is-ui button.classic:hover,
.is-ui .is-btn.classic:hover {
    background: #f9f9f9;
}
#_cbhtml button.classic-primary,
#_cbhtml .is-btn.classic-primary,
.is-ui button.classic-primary,
.is-ui .is-btn.classic-primary {
    display: inline-block;
    width: auto;
    height: 50px;
    padding-left: 30px;
    padding-right: 30px;
    min-width: 135px;
    background: #f7f7f7;
    border: transparent 1px solid;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
}
#_cbhtml button.classic-primary:hover,
#_cbhtml .is-btn.classic-primary:hover,
.is-ui button.classic-primary:hover,
.is-ui .is-btn.classic-primary:hover {
    background: #f9f9f9;
    border: transparent 1px solid;
}
#_cbhtml button.classic-secondary,
#_cbhtml .is-btn.classic-secondary,
.is-ui button.classic-secondary,
.is-ui .is-btn.classic-secondary {
    display: inline-block;
    width: auto;
    height: 50px;
    padding-left: 30px;
    padding-right: 30px;
    background: transparent;
    border: transparent 1px solid;
    box-shadow: 0px 3px 6px -6px rgba(0, 0, 0, 0.32);
}
#_cbhtml button.classic-secondary:hover,
#_cbhtml .is-btn.classic-secondary:hover,
.is-ui button.classic-secondary:hover,
.is-ui .is-btn.classic-secondary:hover {
    background: transparent;
    border: transparent 1px solid;
}
#_cbhtml textarea,
.is-ui textarea {
    font-family: courier;
    font-size: 15px;
    line-height: 2;
    letter-spacing: 1px;
    margin: 0;
    padding: 8px 16px;
    box-sizing: border-box;
    border: 1px solid rgba(0, 0, 0, 0.06);
    background-color: #fafafa;
    color: #121212;
}
#_cbhtml textarea:focus,
.is-ui textarea:focus {
    outline: none;
}
#_cbhtml select,
.is-ui select {
    font-size: 13px;
    letter-spacing: 1px;
    height: 35px;
    line-height: 1.7;
    color: #4a4a4a;
    border-radius: 5px;
    border: none;
    background-color: #f0f0f0;
    width: auto;
    display: inline-block;
    background-image: none;
    -webkit-appearance: menulist;
    -moz-appearance: menulist;
    appearance: menulist;
    padding: 0 5px;
}
#_cbhtml select option,
.is-ui select option {
    background: #fff;
}
#_cbhtml select:focus,
.is-ui select:focus {
    outline: none;
}
#_cbhtml input[type=text],
.is-ui input[type=text] {
    width: 100%;
    height: 50px;
    box-sizing: border-box;
    margin: 0;
    font-family: sans-serif;
    font-size: 15px;
    letter-spacing: 1px;
    padding: 0;
    padding-left: 8px;
    color: #121212;
    display: inline-block;
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    border-radius: 0;
    background-color: #fafafa;
}
#_cbhtml input[type=text]:focus,
.is-ui input[type=text]:focus {
    outline: none;
}
#_cbhtml input[type=text] [type=checkbox], #_cbhtml input[type=text] [type=radio],
.is-ui input[type=text] [type=checkbox],
.is-ui input[type=text] [type=radio] {
    position: relative;
    opacity: 1;
    margin-top: 0;
    margin-bottom: 0;
}
#_cbhtml label,
.is-ui label {
    font-size: 14px;
    letter-spacing: 1px;
    padding: 0;
}
#_cbhtml .is-rangeslider,
.is-ui .is-rangeslider {
    -webkit-appearance: none;
    width: 100%;
    height: 24px;
    background: #e3e3e3;
    outline: none;
    border: none !important;
    opacity: 1;
    -webkit-transition: 0.2s;
    transition: opacity 0.2s;
    margin: 2px !important;
}
#_cbhtml .is-rangeslider:hover,
.is-ui .is-rangeslider:hover {
    opacity: 1;
}
#_cbhtml .is-rangeslider::-webkit-slider-thumb,
.is-ui .is-rangeslider::-webkit-slider-thumb {
    -webkit-appearance: none;
    appearance: none;
    width: 25px !important;
    height: 24px !important;
    border-radius: 0 !important;
    background: #0e75de;
    cursor: pointer;
    margin: 0 !important;
}
#_cbhtml .is-rangeslider::-moz-range-thumb,
.is-ui .is-rangeslider::-moz-range-thumb {
    width: 25px !important;
    height: 24px !important;
    background: #0e75de;
    cursor: pointer;
    margin: 0 !important;
}
#_cbhtml .is-rangeslider::-webkit-slider-runnable-track,
.is-ui .is-rangeslider::-webkit-slider-runnable-track {
    height: auto !important;
    background: none !important;
    border: none !important;
}
#_cbhtml .rangeSlider, #_cbhtml .rangeSlider__fill,
.is-ui .rangeSlider,
.is-ui .rangeSlider__fill {
    display: block;
}
#_cbhtml .rangeSlider,
.is-ui .rangeSlider {
    position: relative;
    background-color: transparent;
    outline: 1px solid rgba(0, 0, 0, 0.06);
}
#_cbhtml .rangeSlider__horizontal,
.is-ui .rangeSlider__horizontal {
    height: 24px;
    width: 100%;
}
#_cbhtml .rangeSlider__vertical,
.is-ui .rangeSlider__vertical {
    height: 100%;
    width: 20px;
}
#_cbhtml .rangeSlider--disabled,
.is-ui .rangeSlider--disabled {
    filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=40);
    opacity: 0.4;
}
#_cbhtml .rangeSlider__fill,
.is-ui .rangeSlider__fill {
    background-color: transparent;
    position: absolute;
}
#_cbhtml .rangeSlider__fill__horizontal,
.is-ui .rangeSlider__fill__horizontal {
    height: 100%;
    top: 0;
    left: 0;
}
#_cbhtml .rangeSlider__fill__vertical,
.is-ui .rangeSlider__fill__vertical {
    width: 100%;
    bottom: 0;
    left: 0;
}
#_cbhtml .rangeSlider__handle,
.is-ui .rangeSlider__handle {
    cursor: pointer;
    display: inline-block;
    width: 25px;
    height: 24px;
    position: absolute;
    border: 1px solid transparent;
    background: rgba(15, 86, 222, 0.8) linear-gradient(rgba(255, 255, 255, 0), rgba(0, 0, 0, 0.04));
    z-index: 1;
}
#_cbhtml .rangeSlider__handle__horizontal,
.is-ui .rangeSlider__handle__horizontal {
    top: -1px;
}
#_cbhtml .rangeSlider__handle__vertical,
.is-ui .rangeSlider__handle__vertical {
    left: -10px;
    bottom: 0;
}
#_cbhtml .rangeSlider__handle:after,
.is-ui .rangeSlider__handle:after {
    content: "";
    display: block;
    width: 10px;
    height: 10px;
    margin: auto;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    border-radius: 50%;
}
#_cbhtml input[type=range]:focus + .rangeSlider .rangeSlider__handle,
.is-ui input[type=range]:focus + .rangeSlider .rangeSlider__handle {
    box-shadow: 0 0 8px rgba(142, 68, 173, 0.9);
}
#_cbhtml .rangeSlider__buffer,
.is-ui .rangeSlider__buffer {
    position: absolute;
    top: 3px;
    height: 14px;
    border-radius: 10px;
}
#_cbhtml .dot-1,
.is-ui .dot-1 {
    background: #f0f0f0;
    width: 7px;
    height: 8px;
}
#_cbhtml .dot-2,
.is-ui .dot-2 {
    background: #fff;
    width: 7px;
    height: 8px;
}
#_cbhtml .dot-3,
.is-ui .dot-3 {
    background: #f0f0f0;
    width: 7px;
    height: 7px;
}
#_cbhtml .dot-4,
.is-ui .dot-4 {
    background: #fff;
    width: 7px;
    height: 7px;
}
#_cbhtml .is-tabs,
.is-ui .is-tabs {
    white-space: nowrap;
    padding: 20px;
    padding-bottom: 5px;
    padding-top: 10px;
    box-sizing: border-box;
    font-family: sans-serif;
    font-size: 11px;
    line-height: 1.8 !important;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: #fafafa;
    display: flex;
    flex-flow: wrap;
}
#_cbhtml .is-tabs a,
.is-ui .is-tabs a {
    display: inline-block;
    padding: 3px 1px 0;
    color: #4a4a4a;
    border-bottom: transparent 1px solid;
    margin: 0 15px 13px 0;
    text-decoration: none;
    transition: box-shadow ease 0.3s;
}
#_cbhtml .is-tabs a.active,
.is-ui .is-tabs a.active {
    background: transparent;
    box-shadow: none;
    cursor: default;
    border-bottom: #595959 1px solid;
}
#_cbhtml .is-tab-content,
.is-ui .is-tab-content {
    display: none;
    padding: 20px;
    flex-direction: column;
}
#_cbhtml .is-tabs-more,
.is-ui .is-tabs-more {
    box-sizing: border-box;
    width: 150px;
    position: absolute;
    top: 0;
    left: 0;
    background: #fff;
    display: none;
    z-index: 1;
    font-family: sans-serif;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    border: 1px solid #f2f2f2;
    box-shadow: 3px 4px 9px 0px rgba(0, 0, 0, 0.06);
}
#_cbhtml .is-tabs-more > a,
.is-ui .is-tabs-more > a {
    display: block;
    color: #4a4a4a;
    padding: 10px;
    text-decoration: none;
    text-align: center;
}
#_cbhtml .is-tabs-more > a:hover, #_cbhtml .is-tabs-more > a.active,
.is-ui .is-tabs-more > a:hover,
.is-ui .is-tabs-more > a.active {
    background: whitesmoke;
}
#_cbhtml #divSnippetList,
.is-ui #divSnippetList {
    right: -230px;
    width: 230px;
    background: #fff;
    border-left: 1px solid #e8e8e8;
    box-shadow: rgba(0, 0, 0, 0.03) 0 0 10px 0px;
}
#_cbhtml #divSnippetList.active,
.is-ui #divSnippetList.active {
    right: 0;
}
#_cbhtml #divSnippetList.active #divSnippetScrollUp,
.is-ui #divSnippetList.active #divSnippetScrollUp {
    display: block;
}
#_cbhtml #divSnippetList.active #divSnippetScrollDown,
.is-ui #divSnippetList.active #divSnippetScrollDown {
    display: block;
}
#_cbhtml #divSnippetList #divSnippetHandle,
.is-ui #divSnippetList #divSnippetHandle {
    position: absolute;
    width: 40px;
    height: 40px;
    top: 170px;
    left: -40px;
    background: #fff;
    border: 1px solid #e8e8e8;
    border-right: none !important;
    line-height: 39px;
    text-align: center;
    box-shadow: rgba(0, 0, 0, 0.025) -4px 2px 5px 0px;
    cursor: pointer;
}
#_cbhtml #divSnippetList.fromleft,
.is-ui #divSnippetList.fromleft {
    left: -230px;
}
#_cbhtml #divSnippetList.fromleft.active,
.is-ui #divSnippetList.fromleft.active {
    left: 0;
}
#_cbhtml #divSnippetList.fromleft #divSnippetHandle,
.is-ui #divSnippetList.fromleft #divSnippetHandle {
    border-left: none;
    border-right: 1px solid #e8e8e8;
    left: auto;
    right: -41px;
    box-shadow: none !important;
}
#_cbhtml #divSnippetScrollUp,
#_cbhtml #divSnippetScrollDown,
.is-ui #divSnippetScrollUp,
.is-ui #divSnippetScrollDown {
    display: none;
    background: rgba(0, 0, 0, 0.12);
    width: 45px;
    height: 45px;
    line-height: 45px;
    color: #a9a9a9;
    position: fixed;
    z-index: 100000;
    text-align: center;
    font-size: 12px;
    cursor: pointer;
    font-family: sans-serif;
}
#_cbhtml .is-design-list,
.is-ui .is-design-list {
    height: 100%;
    margin: 0;
    padding: 0 0 20px !important;
    box-sizing: border-box;
    overflow-y: auto;
    overflow-x: hidden;
    text-align: center;
    border-top: transparent 40px solid !important;
}
#_cbhtml .is-design-list > div,
.is-ui .is-design-list > div {
    width: 170px;
    overflow: hidden;
    margin: 22px 22px 0;
    cursor: move;
    display: block;
    opacity: 1;
    outline: #ebebeb 1px solid !important;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
    position: relative;
}
#_cbhtml .is-design-list > div.hide,
.is-ui .is-design-list > div.hide {
    display: none;
    height: 0;
    opacity: 0;
    overflow: hidden;
    transition: height 350ms ease-in-out, opacity 750ms ease-in-out;
}
#_cbhtml .is-design-list > div img,
.is-ui .is-design-list > div img {
    box-shadow: none;
    display: block;
    transition: all 0.2s ease-in-out;
    box-sizing: border-box;
    width: 100%;
}
#_cbhtml .is-design-list > div .is-overlay,
.is-ui .is-design-list > div .is-overlay {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
}
#_cbhtml .is-design-list > div .is-overlay:after,
.is-ui .is-design-list > div .is-overlay:after {
    background: rgba(0, 0, 0, 0.02);
    position: absolute;
    content: "";
    display: block;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    transition: all 0.3s ease-in-out;
    opacity: 0;
}
#_cbhtml .is-design-list > div:hover .is-overlay:after,
.is-ui .is-design-list > div:hover .is-overlay:after {
    opacity: 0.9;
}
#_cbhtml .is-design-list .snippet-item.sortable-drag:hover,
.is-ui .is-design-list .snippet-item.sortable-drag:hover {
    background-color: rgba(0, 0, 0, 0.06);
}
#_cbhtml .is-selectbox,
.is-ui .is-selectbox {
    height: 40px;
    box-sizing: border-box;
    padding: 0 0 0 20px;
    color: #000;
    background: #f0f0f0;
    box-shadow: none;
    line-height: 40px !important;
    font-size: 14px;
    font-weight: 400;
    cursor: pointer;
}
#_cbhtml .is-selectbox:hover,
.is-ui .is-selectbox:hover {
    background: #f2f2f2;
}
#_cbhtml .is-selectbox svg,
.is-ui .is-selectbox svg {
    fill: #000;
}
#_cbhtml .is-selectbox-options,
.is-ui .is-selectbox-options {
    width: 100%;
    height: 350px;
    border: #e8e8e8 1px solid;
    overflow-y: auto;
    overflow-x: hidden;
    background-color: #fff;
    display: none;
}
#_cbhtml .is-selectbox-options > div,
.is-ui .is-selectbox-options > div {
    color: #000;
    height: 35px;
    padding: 0 0 0 20px;
    line-height: 35px !important;
    font-size: 13px;
    font-weight: 300;
    cursor: pointer;
}
#_cbhtml .is-selectbox-options > div:hover,
.is-ui .is-selectbox-options > div:hover {
    background: whitesmoke;
}
#_cbhtml .is-selectbox-options > div.selected,
.is-ui .is-selectbox-options > div.selected {
    background: whitesmoke;
}
#_cbhtml .elementstyles,
.is-ui .elementstyles {
    width: 300px;
    font-size: 13px;
    z-index: 10005;
}
#_cbhtml .elementstyles .elm-list,
.is-ui .elementstyles .elm-list {
    font-size: 12px;
    line-height: 1.3;
    padding-bottom: 15px;
    color: #0096f1;
    border-bottom: rgba(0, 0, 0, 0.06) 1px solid;
}
#_cbhtml .elementstyles .elm-list a,
.is-ui .elementstyles .elm-list a {
    font-size: 13px;
    color: #0096f1;
    text-decoration: none;
    padding: 0 3px;
}
#_cbhtml .elementstyles .elm-list a.active,
.is-ui .elementstyles .elm-list a.active {
    color: #0096f1;
    background: #f0f0f0;
}
#_cbhtml .elementstyles .is-settings,
.is-ui .elementstyles .is-settings {
    margin-top: 7px;
}
#_cbhtml .elementstyles .is-settings > div,
.is-ui .elementstyles .is-settings > div {
    display: flex;
    align-items: center;
    min-height: 35px;
}
#_cbhtml .elementstyles .is-settings > div.is-label,
.is-ui .elementstyles .is-settings > div.is-label {
    height: auto;
    font-family: sans-serif;
    font-size: 13px;
    font-weight: 300;
    letter-spacing: 1px;
    margin: 10px 0 3px;
}
#_cbhtml .elementstyles .is-settings button,
.is-ui .elementstyles .is-settings button {
    width: auto;
    height: 35px;
    font-size: 10px;
    line-height: 1;
    text-transform: uppercase;
    padding: 1px 20px;
    box-sizing: border-box;
    border: none;
}
#_cbhtml .elementstyles .is-settings button.is-btn-color,
.is-ui .elementstyles .is-settings button.is-btn-color {
    width: 35px;
    height: 35px;
    padding: 0;
    background: rgba(255, 255, 255, 0.2);
    border: rgba(0, 0, 0, 0.09) 1px solid;
}
#_cbhtml .elementstyles .is-settings label,
.is-ui .elementstyles .is-settings label {
    font-size: 13px;
    color: inherit;
}
#_cbhtml .elementstyles .is-settings input[type=text],
.is-ui .elementstyles .is-settings input[type=text] {
    border-radius: 0;
    height: 35px;
    font-size: 14px;
}
#_cbhtml .elementstyles .is-settings select,
.is-ui .elementstyles .is-settings select {
    border-radius: 0;
    height: 35px;
    margin: 0;
}
#_cbhtml .elementstyles #divElementMore,
.is-ui .elementstyles #divElementMore {
    top: 50px;
    left: 140px;
}
#_cbhtml .editstyles,
.is-ui .editstyles {
    display: none;
    position: fixed;
    overflow: hidden;
    width: 280px;
    height: 390px;
    margin: 0px;
    top: 100px;
    left: auto;
    right: 320px;
    z-index: 10005;
    box-sizing: content-box;
    flex-direction: column;
}
#_cbhtml .editstyles.active,
.is-ui .editstyles.active {
    display: flex;
}
#_cbhtml .editstyles > div:not(.is-draggable),
.is-ui .editstyles > div:not(.is-draggable) {
    width: 100%;
    background: transparent;
    border: none;
    box-shadow: none;
    padding: initial;
    box-sizing: border-box;
}
#_cbhtml .is-modal.editstyles div.is-draggable,
.is-ui .is-modal.editstyles div.is-draggable {
    position: absolute;
    top: 0;
    left: 0;
    background: none;
    cursor: move;
    height: 20px;
    width: 100%;
    z-index: 1;
}
#_cbhtml .color-swatch,
.is-ui .color-swatch {
    width: 100%;
    height: 315px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
}
#_cbhtml .color-swatch > *,
.is-ui .color-swatch > * {
    display: flex;
    height: 100%;
}
#_cbhtml .color-swatch > * > *,
.is-ui .color-swatch > * > * {
    width: 100%;
    height: 100%;
    border: transparent 1px solid;
    cursor: pointer;
    transition: all ease 0.3s;
}
#_cbhtml .color-gradient,
.is-ui .color-gradient {
    width: 100%;
    height: 157px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    position: relative;
}
#_cbhtml .color-gradient > *,
.is-ui .color-gradient > * {
    display: flex;
    height: 100%;
}
#_cbhtml .color-gradient > * > *,
.is-ui .color-gradient > * > * {
    width: 100%;
    height: 100%;
    border: transparent 1px solid;
    cursor: pointer;
    transition: all ease 0.3s;
}
#_cbhtml .pickcolor button,
.is-ui .pickcolor button {
    float: left;
    width: 45px;
    height: 45px;
    cursor: pointer;
}
#_cbhtml .pickcolor .color-default button,
.is-ui .pickcolor .color-default button {
    width: 35px;
    height: 35px;
    border: transparent 1px solid;
}
#_cbhtml .pickcolor button.clear,
.is-ui .pickcolor button.clear {
    font-size: 10px;
}
#_cbhtml .is-color-preview,
.is-ui .is-color-preview {
    border: rgba(0, 0, 0, 0.06) 1px solid;
}
#_cbhtml .is-locked-indicator,
.is-ui .is-locked-indicator {
    display: none;
    width: 28px;
    height: 28px;
    position: absolute;
    align-items: center;
    justify-content: center;
    background: rgba(243, 243, 243, 0.9);
    border-radius: 500px;
    pointer-events: none;
}

.is-tool {
    position: absolute;
    top: 0;
    left: 0;
    display: none;
    z-index: 10001;
    background: rgba(243, 243, 243, 0.9);
    box-sizing: border-box;
    padding: 0;
    outline: none;
}
.is-tool:hover {
    z-index: 10003;
}
.is-tool.active {
    display: flex;
}
.is-tool button {
    width: 100%;
    height: 25px;
    background-color: transparent;
    border: none;
    cursor: pointer;
    user-select: none;
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
    color: #000;
    display: inline-block;
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: sans-serif;
    letter-spacing: 1px;
    font-size: 12px;
    font-weight: 300;
    text-transform: uppercase;
    text-align: c enter;
    line-height: unset;
    position: relative;
    border-radius: 0;
    transition: all ease 0.3s;
}
.is-tool button:focus {
    outline: none;
}
.is-tool button svg {
    fill: #000;
}

#_cbhtml[gray] .is-tool.is-column-tool {
    background: rgba(243, 243, 243, 0.9);
    flex-direction: row;
    margin-top: -2px;
}
#_cbhtml[gray] .is-tool.is-column-tool button {
    width: 27px;
    height: 27px;
}
#_cbhtml[gray] .is-tool.is-column-tool .cell-add {
    background: transparent;
}
#_cbhtml[gray] .is-tool.is-column-tool .cell-more {
    background: transparent;
}
#_cbhtml[gray] .is-tool.is-column-tool .cell-remove {
    background: transparent;
}
#_cbhtml[gray] .is-tool.is-column-tool svg {
    width: 18px;
    height: 18px;
    fill: #000;
}
#_cbhtml[gray] .is-tool.is-column-tool .cell-more svg {
    width: 12px;
    height: 12px;
}
#_cbhtml .is-tool.is-column-tool {
    flex-direction: row;
    margin-top: 0px;
}
#_cbhtml .is-tool.is-column-tool button {
    width: 25px;
    height: 25px;
}
#_cbhtml .is-tool.is-column-tool .cell-add {
    background: #0fcc52;
}
#_cbhtml .is-tool.is-column-tool .cell-more {
    background: rgba(216, 200, 6, 0.9);
}
#_cbhtml .is-tool.is-column-tool .cell-remove {
    background: rgba(255, 85, 4, 0.9);
}
#_cbhtml .is-tool.is-column-tool svg {
    width: 23px;
    height: 23px;
    fill: #fff;
}
#_cbhtml .is-tool.is-column-tool .cell-more svg {
    width: 14px;
    height: 14px;
}
#_cbhtml .is-pop.columnmore {
    flex-direction: column;
}
#_cbhtml .is-pop.columnmore > div {
    max-width: 190px;
    margin: 10px 15px;
}
#_cbhtml .is-pop.columnmore button {
    width: 95px;
    height: 60px;
    text-align: center;
    font-size: 9px;
    font-weight: 400;
    text-transform: uppercase;
    margin-bottom: 5px;
    flex-direction: column;
    background-color: transparent;
    box-shadow: none;
}
#_cbhtml .is-pop.columnmore button span {
    display: inline-block;
    width: 95px;
    height: 24px;
}
#_cbhtml .is-pop.columnmore button:hover {
    background-color: transparent;
}
#_cbhtml .is-pop.columnmore div.is-separator {
    width: 100%;
    border-top: #f0f0f0 1px solid;
}
#_cbhtml .is-pop.columnmore button.cell-settings {
    width: 100px;
    height: 45px;
    margin-top: 10px;
    flex-direction: initial;
    justify-items: center;
    align-items: center;
    margin-bottom: 0px;
    margin-left: 7px;
}
#_cbhtml .is-pop.columnmore button.cell-settings svg {
    width: 14px;
    height: 14px;
}
#_cbhtml .is-pop.columnmore button.cell-settings span {
    width: auto;
    height: auto;
    margin-left: 5px;
    margin-top: 1px;
    line-height: 12px;
}
#_cbhtml .is-pop.columnmore button.cell-locking {
    width: 70px;
    height: 45px;
    margin-top: 10px;
    flex-direction: initial;
    justify-items: center;
    align-items: center;
    margin-bottom: 0px;
    margin-left: 10px;
}
#_cbhtml .is-pop.columnmore button.cell-locking svg {
    width: 14px;
    height: 14px;
    pointer-events: none;
    user-select: none;
}
#_cbhtml .is-pop.columnmore button.cell-locking span {
    width: auto;
    height: auto;
    margin-left: 5px;
    margin-top: 1px;
    line-height: 12px;
}
#_cbhtml .is-pop.columnmore button.cell-locking.on {
    background: rgba(0, 0, 0, 0.05) !important;
}
#_cbhtml .is-pop.rowmore {
    flex-direction: column;
}
#_cbhtml .is-pop.rowmore > div {
    width: 190px;
    margin: 10px 15px;
}
#_cbhtml .is-pop.rowmore button {
    width: 95px;
    height: 60px;
    text-align: center;
    font-size: 9px;
    font-weight: 400;
    text-transform: uppercase;
    margin-bottom: 5px;
    flex-direction: column;
    background-color: transparent;
    box-shadow: none;
}
#_cbhtml .is-pop.rowmore button span {
    display: inline-block;
    width: 95px;
    height: 24px;
}
#_cbhtml .is-pop.rowmore button:hover {
    background-color: transparent;
}
#_cbhtml .is-pop.elmmore {
    flex-direction: column;
}
#_cbhtml .is-pop.elmmore > div {
    width: 190px;
    margin: 10px 15px;
}
#_cbhtml .is-pop.elmmore button {
    width: 95px;
    height: 60px;
    text-align: center;
    font-size: 9px;
    font-weight: 400;
    text-transform: uppercase;
    margin-bottom: 5px;
    flex-direction: column;
    background-color: transparent;
    box-shadow: none;
}
#_cbhtml .is-pop.elmmore button span {
    display: inline-block;
    width: 95px;
    height: 24px;
}
#_cbhtml .is-pop.elmmore button:hover {
    background-color: transparent;
}
#_cbhtml .is-pop.quickadd {
    width: 340px;
    box-sizing: border-box;
    transition: none;
    flex-direction: row;
    flex-flow: wrap;
    justify-content: center;
    align-items: center;
}
#_cbhtml .is-pop.quickadd button {
    float: left;
    width: 100px;
    height: 60px;
    font-size: 9px;
    font-weight: 400;
    text-transform: uppercase;
    flex-direction: column;
    background-color: transparent;
    box-shadow: none;
}
#_cbhtml .is-pop.quickadd button.add-more {
    width: 100%;
    margin-top: 10px;
    flex-direction: initial;
    border-top: #f0f0f0 1px solid;
    background: transparent;
    padding: 20px 0 10px;
}
#_cbhtml .is-tool.is-element-tool {
    background: rgba(243, 243, 243, 0.9);
}
#_cbhtml .is-tool.is-element-tool button {
    width: 25px;
    height: 25px;
    background: transparent;
}
#_cbhtml .is-tool.is-element-tool svg {
    width: 14px;
    height: 14px;
    fill: #000;
}
#_cbhtml .is-tool.is-element-tool .elm-more svg {
    width: 11px;
    height: 11px;
}

.row-outline .is-row-tool,
.row-active .is-row-tool {
    display: flex;
}

.is-tool.is-row-tool {
    flex-direction: column;
    width: auto;
    left: auto;
    right: -40px;
}
.is-tool.is-row-tool button {
    width: 25px;
    height: 25px;
}
.is-tool.is-row-tool svg {
    fill: #fff;
}
.is-tool.is-row-tool .row-handle {
    line-height: 25px;
    background: #169af7;
}
.is-tool.is-row-tool .row-handle svg {
    width: 13px;
    height: 13px;
    margin-top: -2px;
}
.is-tool.is-row-tool .row-grideditor {
    background: rgba(216, 200, 6, 0.9);
}
.is-tool.is-row-tool .row-grideditor svg {
    width: 14px;
    height: 14px;
    margin-top: -1px;
}
.is-tool.is-row-tool .row-more {
    background: rgba(216, 200, 6, 0.9);
}
.is-tool.is-row-tool .row-more svg {
    width: 14px;
    height: 14px;
}
.is-tool.is-row-tool .row-remove {
    background: rgba(255, 85, 4, 0.9);
}
.is-tool.is-row-tool .row-remove svg {
    width: 23px;
    height: 23px;
}

.is-builder[gray] .is-tool.is-row-tool {
    background: rgba(243, 243, 243, 0.9);
}
.is-builder[gray] .is-tool.is-row-tool button {
    width: 27px;
    height: 27px;
}
.is-builder[gray] .is-tool.is-row-tool svg {
    fill: #000;
}
.is-builder[gray] .is-tool.is-row-tool .row-handle {
    line-height: 27px;
    background: transparent;
}
.is-builder[gray] .is-tool.is-row-tool .row-handle svg {
    width: 11px;
    height: 11px;
    margin-top: -3px;
}
.is-builder[gray] .is-tool.is-row-tool .row-grideditor {
    background: transparent;
}
.is-builder[gray] .is-tool.is-row-tool .row-grideditor svg {
    width: 13px;
    height: 13px;
}
.is-builder[gray] .is-tool.is-row-tool .row-more {
    background: transparent;
}
.is-builder[gray] .is-tool.is-row-tool .row-more svg {
    width: 12px;
    height: 12px;
}
.is-builder[gray] .is-tool.is-row-tool .row-remove {
    background: transparent;
}
.is-builder[gray] .is-tool.is-row-tool .row-remove svg {
    width: 19px;
    height: 19px;
}

.is-rowadd-tool {
    display: none;
    position: absolute;
    bottom: -1px;
    left: -20px;
    width: calc(100% + 40px);
    height: 1px;
    border: none;
    border-bottom: 1px solid #ffb784;
    z-index: 1;
    background: transparent;
    transition: none;
}
.is-rowadd-tool button {
    position: absolute;
    top: -9px;
    left: calc(50% - 10px);
    border: 1px solid #ff8e3e;
    border-radius: 500px;
    height: auto;
}

.row-outline .is-rowadd-tool,
.row-active .is-rowadd-tool {
    display: block;
}

.is-builder[gray] .is-rowadd-tool {
    border-bottom: 1px solid rgba(222, 222, 222, 0.32);
}
.is-builder[gray] .is-rowadd-tool button {
    border: 1px solid rgba(0, 0, 0, 0.13);
}

.row-add-initial {
    width: 100%;
    height: 70px;
    font-family: sans-serif;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    justify-content: center;
    align-items: center;
    color: #333;
    border: 1px dashed rgba(169, 169, 169, 0.8);
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all ease 0.3s;
    outline: none !important;
}
.row-add-initial:hover {
    background: rgba(248, 248, 248, 0.35);
}
.row-add-initial:focus {
    outline: none;
}
.row-add-initial span {
    text-transform: none;
    display: block;
    margin-top: 5px;
    font-size: 13px;
    opacity: 0.5;
}

.is-builder .row-active.row-add-initial {
    outline: none;
}

.is-tool.is-row-tool .row-grideditor {
    display: none;
}

.is-builder[minimal] .is-tool.is-row-tool .row-grideditor {
    display: block;
}
.is-builder[minimal] .is-tool.is-row-tool .row-more {
    display: none;
}
.is-builder[clean] .is-tool.is-row-tool {
    background: rgba(243, 243, 243, 0.9);
}
.is-builder[clean] .is-tool.is-row-tool .row-grideditor {
    display: block;
    background: transparent;
}
.is-builder[clean] .is-tool.is-row-tool .row-grideditor svg {
    fill: #000;
    width: 13px;
    height: 13px;
    margin-left: -1px;
}
.is-builder[clean] .is-tool.is-row-tool .row-more {
    display: none;
}
.is-builder[clean] .is-tool.is-row-tool .row-handle {
    display: none;
}
.is-builder[clean] .is-tool.is-row-tool .row-remove {
    display: none;
}
.is-builder[clean] .row-outline {
    outline: none;
}
.is-builder[clean] .cell-active {
    outline: none;
}
.is-builder[clean] .row-active {
    outline: 1px solid rgba(132, 132, 132, 0.2);
}
.is-builder[leftrowtool] .is-tool.is-row-tool {
    right: auto;
    left: -40px;
}
.is-builder.builder-active > div:not(.row-active) {
    border-right: 120px rgba(0, 0, 0, 0) solid;
    margin-right: -120px;
}
.is-builder[leftrowtool].builder-active > div:not(.row-active) {
    border-left: 120px rgba(0, 0, 0, 0) solid;
    margin-left: -120px;
}
.is-builder[rowoutline] .row-outline {
    outline: none;
}
.is-builder[rowoutline] .cell-active {
    outline: none;
}
.is-builder[rowoutline] .row-active {
    outline: 1px solid #00da89;
}
.is-builder[grayoutline] .row-outline {
    outline: none;
}
.is-builder[grayoutline] .cell-active {
    outline: 1px solid rgba(132, 132, 132, 0.1);
}
.is-builder[grayoutline] .row-active {
    outline: 1px solid rgba(132, 132, 132, 0.2);
}
.is-builder[rowoutline][grayoutline] .row-outline {
    outline: none;
}
.is-builder[rowoutline][grayoutline] .cell-active {
    outline: none;
}
.is-builder[rowoutline][grayoutline] .row-active {
    outline: 1px solid rgba(132, 132, 132, 0.2);
}
.is-builder[hideoutline] .row-outline {
    outline: none !important;
}
.is-builder[hideoutline] .cell-active {
    outline: none !important;
}
.is-builder[hideoutline] .row-active {
    outline: none !important;
}
.is-builder[hideoutline] .row-active.row-outline {
    outline: none !important;
}
.is-builder[grideditor] > div > div.cell-active {
    outline: 1px solid #00da89 !important;
}
.is-builder[grideditor] .row-active {
    outline: 1px solid #00da89 !important;
    z-index: 1;
}
.is-builder[grideditor] .row-active.row-outline {
    outline: 1px solid rgba(132, 132, 132, 0.2) !important;
}
.is-builder[hidesnippetaddtool] .row-outline .is-rowadd-tool,
.is-builder[hidesnippetaddtool] .row-active .is-rowadd-tool {
    display: none;
}
.is-builder[hideelementhighlight] .elm-active {
    background-color: transparent;
}

#_cbhtml[minimal] .is-tool.is-column-tool .cell-more {
    display: none;
}
#_cbhtml[clean] .is-tool.is-column-tool {
    display: none;
}
#_cbhtml[hidecolumntool] .is-tool.is-column-tool {
    display: none;
}
#_cbhtml[hideelementtool] .is-tool.is-element-tool {
    display: none !important;
}
#_cbhtml .is-element-tool .elm-settings {
    display: none;
}
#_cbhtml[emailmode] .is-element-tool .elm-add,
#_cbhtml[emailmode] .is-element-tool .elm-more,
#_cbhtml[emailmode] .is-element-tool .elm-remove {
    display: none !important;
}
#_cbhtml[emailmode] .is-element-tool .elm-settings {
    display: block;
}

.is-tooltip {
    position: absolute;
    display: none;
    padding: 1px 8px;
    font-size: 11px;
    background: #333;
    border-radius: 0px;
    color: #fefefe;
    z-index: 100005;
}

/*!
 * Cropper.js v1.5.12
 * https://fengyuanchen.github.io/cropperjs
 *
 * Copyright 2015-present Chen Fengyuan
 * Released under the MIT license
 *
 * Date: 2021-06-12T08:00:11.623Z
 */
.cropper-container {
    direction: ltr;
    font-size: 0;
    line-height: 0;
    position: relative;
    -ms-touch-action: none;
    touch-action: none;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

.cropper-container img {
    image-orientation: 0deg;
    display: block;
    height: 100%;
    max-height: none !important;
    max-width: none !important;
    min-height: 0 !important;
    min-width: 0 !important;
    width: 100%;
}

.cropper-canvas, .cropper-crop-box, .cropper-drag-box, .cropper-modal, .cropper-wrap-box {
    bottom: 0;
    left: 0;
    position: absolute;
    right: 0;
    top: 0;
}

.cropper-canvas, .cropper-wrap-box {
    overflow: hidden;
}

.cropper-drag-box {
    background-color: #fff;
    opacity: 0;
}

.cropper-modal {
    background-color: #000;
    opacity: 0.5;
}

.cropper-view-box {
    display: block;
    height: 100%;
    outline: 1px solid #39f;
    outline-color: rgba(51, 153, 255, 0.75);
    overflow: hidden;
    width: 100%;
}

.cropper-dashed {
    border: 0 dashed #eee;
    display: block;
    opacity: 0.5;
    position: absolute;
}

.cropper-dashed.dashed-h {
    border-bottom-width: 1px;
    border-top-width: 1px;
    height: 33.33333%;
    left: 0;
    top: 33.33333%;
    width: 100%;
}

.cropper-dashed.dashed-v {
    border-left-width: 1px;
    border-right-width: 1px;
    height: 100%;
    left: 33.33333%;
    top: 0;
    width: 33.33333%;
}

.cropper-center {
    display: block;
    height: 0;
    left: 50%;
    opacity: 0.75;
    position: absolute;
    top: 50%;
    width: 0;
}

.cropper-center:after, .cropper-center:before {
    background-color: #eee;
    content: " ";
    display: block;
    position: absolute;
}

.cropper-center:before {
    height: 1px;
    left: -3px;
    top: 0;
    width: 7px;
}

.cropper-center:after {
    height: 7px;
    left: 0;
    top: -3px;
    width: 1px;
}

.cropper-face, .cropper-line, .cropper-point {
    display: block;
    height: 100%;
    opacity: 0.1;
    position: absolute;
    width: 100%;
}

.cropper-face {
    background-color: #fff;
    left: 0;
    top: 0;
}

.cropper-line {
    background-color: #39f;
}

.cropper-line.line-e {
    cursor: ew-resize;
    right: -3px;
    top: 0;
    width: 5px;
}

.cropper-line.line-n {
    cursor: ns-resize;
    height: 5px;
    left: 0;
    top: -3px;
}

.cropper-line.line-w {
    cursor: ew-resize;
    left: -3px;
    top: 0;
    width: 5px;
}

.cropper-line.line-s {
    bottom: -3px;
    cursor: ns-resize;
    height: 5px;
    left: 0;
}

.cropper-point {
    background-color: #39f;
    height: 5px;
    opacity: 0.75;
    width: 5px;
}

.cropper-point.point-e {
    cursor: ew-resize;
    margin-top: -3px;
    right: -3px;
    top: 50%;
}

.cropper-point.point-n {
    cursor: ns-resize;
    left: 50%;
    margin-left: -3px;
    top: -3px;
}

.cropper-point.point-w {
    cursor: ew-resize;
    left: -3px;
    margin-top: -3px;
    top: 50%;
}

.cropper-point.point-s {
    bottom: -3px;
    cursor: s-resize;
    left: 50%;
    margin-left: -3px;
}

.cropper-point.point-ne {
    cursor: nesw-resize;
    right: -3px;
    top: -3px;
}

.cropper-point.point-nw {
    cursor: nwse-resize;
    left: -3px;
    top: -3px;
}

.cropper-point.point-sw {
    bottom: -3px;
    cursor: nesw-resize;
    left: -3px;
}

.cropper-point.point-se {
    bottom: -3px;
    cursor: nwse-resize;
    height: 20px;
    opacity: 1;
    right: -3px;
    width: 20px;
}

@media (min-width: 768px) {
    .cropper-point.point-se {
        height: 15px;
        width: 15px;
    }
}
@media (min-width: 992px) {
    .cropper-point.point-se {
        height: 10px;
        width: 10px;
    }
}
@media (min-width: 1200px) {
    .cropper-point.point-se {
        height: 5px;
        opacity: 0.75;
        width: 5px;
    }
}
.cropper-point.point-se:before {
    background-color: #39f;
    bottom: -50%;
    content: " ";
    display: block;
    height: 200%;
    opacity: 0;
    position: absolute;
    right: -50%;
    width: 200%;
}

.cropper-invisible {
    opacity: 0;
}

.cropper-bg {
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAA3NCSVQICAjb4U/gAAAABlBMVEXMzMz////TjRV2AAAACXBIWXMAAArrAAAK6wGCiw1aAAAAHHRFWHRTb2Z0d2FyZQBBZG9iZSBGaXJld29ya3MgQ1M26LyyjAAAABFJREFUCJlj+M/AgBVhF/0PAH6/D/HkDxOGAAAAAElFTkSuQmCC");
}

.cropper-hide {
    display: block;
    height: 0;
    position: absolute;
    width: 0;
}

.cropper-hidden {
    display: none !important;
}

.cropper-move {
    cursor: move;
}

.cropper-crop {
    cursor: crosshair;
}

.cropper-disabled .cropper-drag-box, .cropper-disabled .cropper-face, .cropper-disabled .cropper-line, .cropper-disabled .cropper-point {
    cursor: not-allowed;
}

.is-ui .is-lightbox {
    display: none;
    z-index: 100000;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    box-sizing: border-box;
    background-color: black;
    opacity: 0;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transform: scale(0.7) translateZ(150px);
    transition: all 450ms ease-in-out;
}
.is-ui .is-lightbox.light {
    background-color: rgba(255, 255, 255, 0.97);
}
.is-ui .is-lightbox > div {
    width: 100%;
    height: 100%;
}
.is-ui .is-lightbox.lightbox-externalvideo {
    padding: 40px;
    /* & > div {
        margin:40px;
    } */
}
.is-ui .is-lightbox.lightbox-video > div.lightbox-content, .is-ui .is-lightbox.lightbox-image > div.lightbox-content {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px;
    box-sizing: border-box;
}
.is-ui .is-lightbox.active {
    opacity: 1;
    transform: scale(1) translateZ(150px);
}
.is-ui .is-lightbox iframe {
    opacity: 0;
    filter: blur(30px);
    transition: all 600ms ease-in-out;
}
.is-ui .is-lightbox.active iframe {
    filter: blur(0);
    opacity: 1;
}
.is-ui .is-lightbox video {
    outline: none;
    width: 100%;
    height: 100%;
}
.is-ui .is-lightbox img {
    max-width: 100%;
    max-height: 100%;
}
.is-ui .is-lightbox .cmd-lightbox-close {
    position: absolute !important;
    top: 3px !important;
    right: 3px !important;
    width: 50px !important;
    height: 50px !important;
    color: #fff !important;
    background: none;
    border: none;
    cursor: pointer;
    outline: none;
    box-shadow: none;
}
.is-ui .is-lightbox .cmd-lightbox-close svg {
    width: 30px;
    height: 30px;
    fill: #000 !important;
    position: absolute;
    top: 10px;
    right: 10px;
}
.is-ui .is-lightbox.light .cmd-lightbox-close {
    color: #000 !important;
}

.block-click[data-noedit] {
    cursor: pointer;
}
.block-click[data-noedit] > * {
    pointer-events: none;
    user-select: none;
}

.block-click[contenteditable=true] {
    cursor: unset;
}
.block-click[contenteditable=true] > * {
    pointer-events: unset;
    user-select: unset;
}

/* Prevent css framework overide (Materialize) */
.is-ui [type=checkbox]:not(:checked), .is-ui [type=checkbox]:checked {
    position: unset !important;
}

.is-ui input[type=range] {
    border: none;
}

.is-ui form {
    background: unset;
    margin: unset;
    padding: unset;
    border: unset;
}

.is-ui svg {
    max-width: unset;
}
