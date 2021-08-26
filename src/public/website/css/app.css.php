@media (max-width:430px)
{
    .width50 {
        width:100%;
        float:none;
    }
    .width33 {
        width: 100%;
        float:none;
    }
    .width25 {
        width: 50%;
        float:left;
    }
}

.widthAuto {
    width:auto !important;
}

.loginMainfloat {
    margin: 50px auto;
    max-width: 600px;
    background: transparent;
    position: relative;
    z-index: 5;
}
.siteLoginFloat {
    padding: 25px 35px 35px;
    background: #eee;
}
.siteLoginBody {
    margin:50px auto;
    max-width:600px;
    background:transparent;
    position:relative;
    z-index:5;
}
.siteLoginBodyInner {
    position:relative;
    z-index:5;
}
.siteLoginBody:after {
    content:" ";
    position:absolute;
    top:45px;
    bottom:45px;
    left:15px;
    right:500px;
    border-radius:35px;
    box-shadow:rgba(0,0,0,.7) -35px 0px 25px;
    z-index:3;
    display:none;
}

.copyright-text {
    margin-top: 10px;
    font-size:10px;
    color:#555;
    display:block;
    text-align:center;
}

.siteLoginBody:before {
    content:" ";
    position:absolute;
    top:45px;
    bottom:45px;
    left:500px;
    right:15px;
    border-radius:35px;
    box-shadow:rgba(0,0,0,.7) 35px 0px 25px;
    z-index:3;
    display:none;
}
.siteLoginFloat {
    padding:25px 35px 35px;
    background:#eee;
}
.siteDatixLogin,
.siteCrmLogin,
.siteDynamicsLogin {
    background:#fff;
    border:1px solid #ddd;
    margin-bottom:10px;
    padding:10px 15px 15px !important;
    display:block;
    box-sizing:border-box;
}
.loggedOutBody .siteCrmLogin {
    box-shadow:rgba(0,0,0,.3) 0 0 5px;
}
.form-submit-buttons {
    width:100%;
    padding:10px;
    font-size:15px;
}
.fieldsetGrouping legend {
    font-size:15px;
    font-weight:bold;
    color:#000;
    top: -15px;
    position: relative;
    text-align: center;
}
.login-field-table {
    display:table;
    width: 100%;
}
.login-field-table .login-field-row {
    display:table-row;
}
.login-field-table .login-field-row > div {
    display: table-cell;
}
#frmLogin .login-field-table .login-field-row > div:first-child {
    vertical-align: top;
    width: 95px;
}
#frmPasswordResetRequest .login-field-table .login-field-row > div:first-child {
    vertical-align: top;
    width: 115px;
}
#frmPasswordReset .login-field-table .login-field-row > div:first-child {
    vertical-align: top;
    width: 145px;
}
#frmResetRequestToken .login-field-table .login-field-row > div:first-child {
    vertical-align: top;
    width: 145px;
}

.fieldsetGrouping label {
    display: block;
    float: left;
    position: relative;
    top: 3px;
}
.login-button-box {
    margin-top:15px;
}
.login-field-table .login-field-row > div {
    padding-top: 5px;
}
.login-field-table .login-field-row:nth-child(1) > div {
    padding-top: 0px;
}

.fieldsetGrouping input:not([type="checkbox"]) {
    width: 100%;
    float: right;
    padding: 5px;
    margin-bottom: 3px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-shadow: rgba(0,0,0,.3) 1px 1px 3px inset;
    box-sizing: border-box;
}
.fieldsetGrouping input[type="checkbox"] {
    top: 6px;
    position: relative;
}

<?php include(PublicDefault . "css/default.css"); ?>

.zgSubpage_thumb {
    padding-right: 10px;
}
#inputpicker-wrapped-list {
    box-shadow: rgba(0,0,0,0.2) 0px 4px 6px;
}

.inputPickerWrapper .divCell {
    font-size: 14px !important;
    padding: 8px;
}

.inputPickerWrapper .divHeader {
    box-shadow: rgba(0,0,0,0.2) 0px 2px 5px;
    background-color: #007bff;
}
.inputPickerWrapper .divHeader .divCell {
    font-weight: bold;
    color:#fff;
}
.inputPickerWrapper .divTBody .divCell {

}
.inputPickerWrapper .inputpicker-element .divCell {
    max-width:250px;
    overflow-x: hidden;
}
#auto-generated-services-top h3 a.sub-pages-title {
    font-family: ArialNarrow, arial, sans-serif;
    font-size:19px;
    color: #000000;
    font-style: normal;
    font-weight: normal;
    margin-bottom: -4px;
    text-decoration: none;
}

.sub-page-horizontal h3 a.sub-pages-title {
    text-align:center;
}
#auto-generated-services.sub-page-no-llp { padding:20px 0px 20px;width:100%; }
#auto-generated-services.sub-page-horizontal .divRow { display:inline-block !important; padding-bottom: 15px; }

.sub-page-vertical .zgSubpage_thumb {
    padding-right: 10px;
    width:160px;
}
.sub-page-vertical .zgSubpage_thumb_link {
    display:block;margin-right:10px;text-decoration:none;
}
.sub-page-horizontal .zgSubpage_thumb_link {
    display:block;text-decoration:none;
}
.sub-page-horizontal .zgSubpage_text {
    width:100%;
}
.sub-page-horizontal .zgSubpage_thumb, .sub-page-horizontal .zgSubpage_text {
    display: block !important;
}
.centeredContent {
    text-align:center;
}
.autoMargin  {
    margin:auto;
}


@media (min-width:1018.5px) {
    .sub-page-horizontal.sub-page-count-1 .divRow { width: 100%; }
    .sub-page-horizontal.sub-page-count-2 .divRow { width:calc(50% + 8px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-3 .divRow { width:calc(33.333333333333% + 4px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-4 .divRow { width:calc(25% + 2px ); padding-right: 15px; }
    .sub-page-horizontal.sub-page-count-5 .divRow { width:calc(20% + 2px ); padding-right: 15px; }

    .sub-page-horizontal.sub-page-count-2 .divRow:nth-child(even) { padding-right:0px !important; width: calc(50% - 15px ); }
    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(3n+0) { padding-right:0px !important; width: calc(33.333333333333% - 19px ); }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(4n+0) { padding-right:0px !important; width: calc(25% - 21px ); }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(5n+0) { padding-right:0px !important; width: calc(20% - 21px ); }

    .sub-page-horizontal.sub-page-count-2 .divRow:nth-child(even)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(3n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(4n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(5n+0)::after { clear:both;float:none;content: ""; }
}

@media (max-width:1017.5px) and (min-width:786px) {
    .sub-page-horizontal.sub-page-count-2 .divRow { width: 100%; }
    .sub-page-horizontal.sub-page-count-3 .divRow { width:calc(50% + 8px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-4 .divRow { width:calc(33.333333333333% + 4px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-5 .divRow { width:calc(25% + 4px ); padding-right: 25px; }

    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(even) { padding-right:0px !important; width: calc(50% - 15px ); }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(3n+0) { padding-right:0px !important; width: calc(33.333333333333% - 19px ); }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(4n+0) { padding-right:0px !important; width: calc(33.333333333333% - 19px ); }

    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(even)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(3n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(4n+0)::after { clear:both;float:none;content: ""; }
}
@media (max-width:785px) and (min-width:631px){
    .sub-page-horizontal.sub-page-count-1 .divRow { width: 100%; }
    .sub-page-horizontal.sub-page-count-2 .divRow { width:calc(50% + 8px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-3 .divRow { width:calc(33.333333333333% + 4px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-4 .divRow { width:calc(25% + 2px ); padding-right: 15px; }
    .sub-page-horizontal.sub-page-count-5 .divRow { width:calc(20% + 2px ); padding-right: 15px; }

    .sub-page-horizontal.sub-page-count-2 .divRow:nth-child(even) { padding-right:0px !important; width: calc(50% - 15px ); }
    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(3n+0) { padding-right:0px !important; width: calc(33.333333333333% - 19px ); }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(4n+0) { padding-right:0px !important; width: calc(25% - 21px ); }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(5n+0) { padding-right:0px !important; width: calc(25% - 21px ); }

    .sub-page-horizontal.sub-page-count-2 .divRow:nth-child(even)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(3n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(4n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(5n+0)::after { clear:both;float:none;content: ""; }
}
@media (max-width:630px) {
    .sub-page-horizontal.sub-page-count-2 .divRow { width: 100%; }
    .sub-page-horizontal.sub-page-count-3 .divRow { width:calc(50% + 8px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-4 .divRow { width:calc(33.333333333333% + 4px ); padding-right: 25px; }
    .sub-page-horizontal.sub-page-count-5 .divRow { width:calc(50% + 8px ); padding-right: 25px; }

    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(even) { padding-right:0px !important; width: calc(50% - 15px ); }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(3n+0) { padding-right:0px !important; width: calc(33.333333333333% - 19px ); }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(4n+0) { padding-right:0px !important; width: calc(25% - 19px ); }

    .sub-page-horizontal.sub-page-count-3 .divRow:nth-child(even)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-4 .divRow:nth-child(3n+0)::after { clear:both;float:none;content: ""; }
    .sub-page-horizontal.sub-page-count-5 .divRow:nth-child(4n+0)::after { clear:both;float:none;content: ""; }
}
@media (max-width:552.5px) {

    .sub-page-horizontal.sub-page-count-5 .divRow { width: 100%; }
}

@media (max-width:630px) {

}
@media (max-width:320px) {

}