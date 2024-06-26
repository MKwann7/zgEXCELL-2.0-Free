﻿/*
    Insert HTML Symbols Plugin
*/

(function () {

    var html = '<div class="is-modal is-side' + (_cb.settings.sidePanel == 'right' ? '' : ' fromleft') + ' viewsymbols" style="width:280px;z-index:10004;">' +
                    '<button title="' + _cb.out('Close') + '" class="is-side-close" style="z-index:1;width:25px;height:25px;position:absolute;top:10px;right:13px;box-sizing:border-box;padding:0;line-height:25px;font-size: 12px;text-align:center;cursor:pointer;background:transparent"><svg class="is-icon-flex" style="width:25px;height:25px;"><use xlink:href="#ion-ios-close-empty"></use></svg></button>' +
                    
                    '' +
                    '<iframe src="about:blank" style="width:100%;height:100%;position:absolute;top:0;left:0;border: none;"></iframe>' +
                    '' +
                '</div>';

    _cb.addHtml(html);

    var button = '<button class="insertsymbol-button" title="Symbol" style="font-size:14px;vertical-align:bottom;">' +
                    '&#8486;' +
                '</button>';

    _cb.addButton('symbols', button, '.insertsymbol-button', function () {

        var modal = document.querySelector('.is-side.viewsymbols');
        _cb.showSidePanel(modal);
        var btnClose = modal.querySelector('.is-side-close');
        btnClose.addEventListener('click', function(e){
            _cb.hideSidePanel(modal);
        });

        // var scriptPath = _cb.getScriptPath();
        // modal.querySelector('iframe').src = scriptPath + 'plugins/symbols/symbols.html';

        iframe = modal.querySelector('iframe');
        doc = iframe.contentWindow.document;
        doc.open();
        doc.write(getSymbolHTML());
        doc.close();

    });

    function getSymbolHTML() {

        _cb.styleDark = false;
        if(document.body.getAttribute('class')) {
            if(document.body.getAttribute('class').indexOf('dark')!==-1) {
                _cb.styleDark = true;
            }
            if(document.body.getAttribute('class').indexOf('colored')!==-1) {
                _cb.styleColored = true;
            }
        }

        const html = `
        <!DOCTYPE HTML>
        <html>
        <head>
            <meta charset="utf-8">
            <title></title>
            <style>
                body {margin:0;overflow-x:hidden;overflow-y:auto;}
                .container {}
                .container > div {
                    text-align:center;font-size:16px;cursor:pointer;margin: 0;display:inline-block;float:left;width:25%;height:50px;line-height:50px;
                    border:${_cb.styleSeparatorColor} 1px solid;
                    color: ${_cb.styleButtonClassicColor};
                    box-sizing:border-box;
                }
                .container > div:hover {
                    background: ${_cb.styleButtonClassicBackground};
                }
                .clearfix:before, .clearfix:after {content: " ";display: table;}
                .clearfix:after {clear: both;}
                .clearfix {*zoom: 1;}
        
                .is-tabs  {
                    white-space:nowrap;
                    padding:20px 15px;padding-bottom:5px;padding-top: 10px;
                    box-sizing:border-box;
                    font-family: sans-serif;
                    font-size: 10px;
                    text-transform: uppercase;
                    letter-spacing: 2px;  
                    // background: #f9f9f9;
                    background: ${_cb.styleTabsBackground};
                }
                .is-tabs a {
                    display: inline-block;
                    float:left;
                    padding: 3px 0px 1px 1px;
                    // color: #4a4a4a;
                    color: ${_cb.styleTabItemColor};
                    border-bottom: transparent 1px solid;
                    
                    margin: 0 16px 10px 0;
                    text-decoration: none;
                    transition: box-shadow ease 0.3s;
                }
                .is-tabs a svg {
                    fill: ${_cb.styleTabItemColor};
                }
                .is-tabs a.active {
                    background: transparent;
                    box-shadow: none;
                    cursor:default;
                    // border-bottom: rgba(103, 103, 103, 0.72) 1px solid;
                    border-bottom: ${_cb.styleTabItemBorderBottomActive};
                }
                
                .tab-content {
                    position:fixed;width:100%;height:calc((100% - 84px));top:84px;left:0;overflow-x:hidden;overflow-y:auto;
                    display: none;
                    flex-flow: wrap;
                    align-content: start;
                }
                .tab-content > div {min-width:65px}
                
                .is-tabs-more {
                    box-sizing:border-box;width:180px;position:absolute;top:0;left:0;
                    // background:#fff;
                    background: ${_cb.styleTabsMoreBackground};
                    // border:#ccc 1px solid;
                    border: ${_cb.styleTabsMoreBorder};
                    display:none;z-index:1;
                    font-family: sans-serif;
                    font-size: 10px;
                    text-transform: uppercase;
                    letter-spacing: 2px;  
                    }
                .is-tabs-more > a {
                    display:block;
                    // color: #4a4a4a;
                    color: ${_cb.styleTabsMoreItemColor};
                    padding: 10px;
                    text-decoration: none;
                    text-align: center;
                }
                .is-tabs-more a.active {
                    background: transparent;
                    box-shadow: none;
                    cursor: default;
                }
                .is-tabs-more > a:hover, 
                .is-tabs-more > a.active {
                    // background: #f3f3f3;
                    background: ${_cb.styleTabsMoreBackgroundHover}; 
                }

                /* Scrollbar for panel */

                .dark * {
                    scrollbar-width: thin;
                    scrollbar-color: rgba(255, 255, 255, 0.3) auto;
                }
                .dark *::-webkit-scrollbar {
                    width: 12px;
                }
                .dark *::-webkit-scrollbar-track {
                    background: transparent;
                }
                .dark *::-webkit-scrollbar-thumb {
                    background-color:rgba(255, 255, 255, 0.3);
                } 
        
                .colored-dark * {
                    scrollbar-width: thin;
                    scrollbar-color: rgb(100, 100, 100) auto;
                }
                .colored-dark *::-webkit-scrollbar {
                    width: 12px;
                }
                .colored-dark *::-webkit-scrollbar-track {
                    background: transparent;
                }
                .colored-dark *::-webkit-scrollbar-thumb {
                    background-color:rgb(100, 100, 100);
                } 
        
                .colored * {
                    scrollbar-width: thin;
                    scrollbar-color: rgba(0, 0, 0, 0.4) auto;
                }
                .colored *::-webkit-scrollbar {
                    width: 12px;
                }
                .colored *::-webkit-scrollbar-track {
                    background: transparent;
                }
                .colored *::-webkit-scrollbar-thumb {
                    background-color: rgba(0, 0, 0, 0.4);
                } 
        
                .light * {
                    scrollbar-width: thin;
                    scrollbar-color: rgba(0, 0, 0, 0.4) auto;
                }
                .light *::-webkit-scrollbar {
                    width: 12px;
                }
                .light *::-webkit-scrollbar-track {
                    background: transparent;
                }
                .light *::-webkit-scrollbar-thumb {
                    background-color: rgba(0, 0, 0, 0.4);
                } 
            </style>
        </head>
        <body${_cb.styleDark?' class="dark"':''}${_cb.styleColored?' class="colored"':''}${_cb.styleColoredDark?' class="colored-dark"':''}${_cb.styleLight?' class="light"':''}>
        
        
        <svg width="0" height="0" style="position:absolute;display:none;">
            <defs>
                <symbol viewBox="0 0 512 512" id="ion-more"><path d="M113.7 304C86.2 304 64 282.6 64 256c0-26.5 22.2-48 49.7-48 27.6 0 49.8 21.5 49.8 48 0 26.6-22.2 48-49.8 48zM256 304c-27.5 0-49.8-21.4-49.8-48 0-26.5 22.3-48 49.8-48 27.5 0 49.7 21.5 49.7 48 0 26.6-22.2 48-49.7 48zM398.2 304c-27.5 0-49.8-21.4-49.8-48 0-26.5 22.2-48 49.8-48 27.5 0 49.8 21.5 49.8 48 0 26.6-22.2 48-49.8 48z"></path></symbol>
            </defs>
        </svg>
                                '
        <div class="is-tabs" style="position:fixed;top:0;left:0;right:0;height:84px;padding-top:48px;box-sizing:border-box;">
            <a href="" data-content="divArrow" class="active">Arrow</a>
            <a href="" data-content="divEmojiSmileys">Smileys</a>
            <a href="" data-content="divMiscSymbols">Misc</a>
            <a title="More" id="divMore" href=""><svg class="is-icon-flex" style="width:15px;height:15px;"><use xlink:href="#ion-more"></use></svg></a>
        </div>
        
        <div id="divTabsMore" style="top:80px;left:90px;" class="is-tabs-more" data-group="element">
            <a href="" data-content="divBlockElements">Block</a>
            <a href="" data-content="divBoxDrawings">Box</a>
            <a href="" data-content="divCurrencySymbols">Currency</a>
            <a href="" data-content="divDingbats">Dingbats</a>
            <!--
            <a href="" data-content="divEmoji">Emoji</a>
            <a href="" data-content="divEmojiSkinTones">Emoji Skin Tones</a>
            -->
            <a href="" data-content="divGeometricShapes">Geometric</a>
            <a href="" data-content="divLetterlikeSymbols">Letterlike</a>
            <a href="" data-content="divMathOperators">Math</a>
            <a href="" data-content="divGeneralPunctuation">Punctuation</a>
            <a href="" data-content="divLatinBasic">Latin Basic</a>
            <a href="" data-content="divLatinSupplement">Latin Supplement</a>
            <a href="" data-content="divLatinExtendedA">Latin Extended A</a>
            <a href="" data-content="divLatinExtendedB">Latin Extended B</a>
            <a href="" data-content="divModifierLetters">Modifier Letters</a>
            <a href="" data-content="divDiacriticalMarks">Diacritical Marks</a>
            <a href="" data-content="divGreekAndCoptic">Greek & Coptic</a>
            <a href="" data-content="divCyrillicBasic">Cyrillic Basic</a>
            <a href="" data-content="divCyrillicSupplement">Cyrillic Supplement</a>
        </div>
        
        <div id="divArrow" class="tab-content container clearfix" style="display:flex">
            
            <!-- Arrows: https://www.w3schools.com/charsets/ref_utf_arrows.asp -->
            <div title="LEFTWARDS ARROW">&larr;</div>
            <div title="UPWARDS ARROW">&uarr;</div>
            <div title="RIGHTWARDS ARROW">&rarr;</div>
            <div title="DOWNWARDS ARROW">&darr;</div>
            <div title="LEFT RIGHT ARROW">&harr;</div>
            <div title="UP DOWN ARROW">&#8597;</div>
            <div title="NORTH WEST ARROW">&#8598;</div>
            <div title="NORTH EAST ARROW">&#8599;</div>
            <div title="SOUTH EAST ARROW">&#8600;</div>
            <div title="SOUTH WEST ARROW">&#8601;</div>
            <div title="LEFTWARDS ARROW WITH STROKE">&#8602;</div>
            <div title="RIGHTWARDS ARROW WITH STROKE">&#8603;</div>
            <div title="LEFTWARDS WAVE ARROW">&#8604;</div>
            <div title="RIGHTWARDS WAVE ARROW">&#8605;</div>
            <div title="LEFTWARDS TWO HEADED ARROW">&#8606;</div>
            <div title="UPWARDS TWO HEADED ARROW">&#8607;</div>
            <div title="RIGHTWARDS TWO HEADED ARROW">&#8608;</div>
            <div title="DOWNWARDS TWO HEADED ARROW">&#8609;</div>
            <div title="LEFTWARDS ARROW WITH TAIL">&#8610;</div>
            <div title="RIGHTWARDS ARROW WITH TAIL">&#8611;</div>
            <div title="LEFTWARDS ARROW FROM BAR">&#8612;</div>
            <div title="UPWARDS ARROW FROM BAR">&#8613;</div>
            <div title="RIGHTWARDS ARROW FROM BAR">&#8614;</div>
            <div title="DOWNWARDS ARROW FROM BAR">&#8615;</div>
            <div title="UP DOWN ARROW WITH BASE">&#8616;</div>
            <div title="LEFTWARDS ARROW WITH HOOK">&#8617;</div>
            <div title="RIGHTWARDS ARROW WITH HOOK">&#8618;</div>
            <div title="LEFTWARDS ARROW WITH LOOP">&#8619;</div>
            <div title="RIGHTWARDS ARROW WITH LOOP">&#8620;</div>
            <div title="LEFT RIGHT WAVE ARROW">&#8621;</div>
            <div title="LEFT RIGHT ARROW WITH STROKE">&#8622;</div>
            <div title="DOWNWARDS ZIGZAG ARROW">&#8623;</div>
            <div title="UPWARDS ARROW WITH TIP LEFTWARDS">&#8624;</div>
            <div title="UPWARDS ARROW WITH TIP RIGHTWARDS">&#8625;</div>
            <div title="DOWNWARDS ARROW WITH TIP LEFTWARDS">&#8626;</div>
            <div title="DOWNWARDS ARROW WITH TIP RIGHTWARDS">&#8627;</div>
            <div title="RIGHTWARDS ARROW WITH CORNER DOWNWARDS">&#8628;</div>
            <div title="DOWNWARDS ARROW WITH CORNER LEFTWARDS">&crarr;</div>
            <div title="ANTICLOCKWISE TOP SEMICIRCLE ARROW">&#8630;</div>
            <div title="CLOCKWISE TOP SEMICIRCLE ARROW">&#8631;</div>
            <div title="NORTH WEST ARROW TO LONG BAR">&#8632;</div>
            <div title="LEFTWARDS ARROW TO BAR OVER RIGHTWARDS ARROW TO BAR">&#8633;</div>
            <div title="ANTICLOCKWISE OPEN CIRCLE ARROW">&#8634;</div>
            <div title="CLOCKWISE OPEN CIRCLE ARROW">&#8635;</div>
            <div title="LEFTWARDS HARPOON WITH BARB UPWARDS">&#8636;</div>
            <div title="LEFTWARDS HARPOON WITH BARB DOWNWARDS">&#8637;</div>
            <div title="UPWARDS HARPOON WITH BARB RIGHTWARDS">&#8638;</div>
            <div title="UPWARDS HARPOON WITH BARB LEFTWARDS">&#8639;</div>
            <div title="RIGHTWARDS HARPOON WITH BARB UPWARDS">&#8640;</div>
            <div title="RIGHTWARDS HARPOON WITH BARB DOWNWARDS">&#8641;</div>
            <div title="DOWNWARDS HARPOON WITH BARB RIGHTWARDS">&#8642;</div>
            <div title="DOWNWARDS HARPOON WITH BARB LEFTWARDS">&#8643;</div>
            <div title="RIGHTWARDS ARROW OVER LEFTWARDS ARROW">&#8644;</div>
            <div title="UPWARDS ARROW LEFTWARDS OF DOWNWARDS ARROW">&#8645;</div>
            <div title="LEFTWARDS ARROW OVER RIGHTWARDS ARROW">&#8646;</div>
            <div title="LEFTWARDS PAIRED ARROWS">&#8647;</div>
            <div title="UPWARDS PAIRED ARROWS">&#8648;</div>
            <div title="RIGHTWARDS PAIRED ARROWS">&#8649;</div>
            <div title="DOWNWARDS PAIRED ARROWS">&#8650;</div>
            <div title="LEFTWARDS HARPOON OVER RIGHTWARDS HARPOON">&#8651;</div>
            <div title="RIGHTWARDS HARPOON OVER LEFTWARDS HARPOON">&#8652;</div>
            <div title="LEFTWARDS DOUBLE ARROW WITH STROKE">&#8653;</div>
            <div title="LEFT RIGHT DOUBLE ARROW WITH STROKE">&#8654;</div>
            <div title="RIGHTWARDS DOUBLE ARROW WITH STROKE">&#8655;</div>
            <div title="LEFTWARDS DOUBLE ARROW">&lArr;</div>
            <div title="UPWARDS DOUBLE ARROW">&uArr;</div>
            <div title="RIGHTWARDS DOUBLE ARROW">&rArr;</div>
            <div title="DOWNWARDS DOUBLE ARROW">&dArr;</div>
            <div title="LEFT RIGHT DOUBLE ARROW">&hArr;</div>
            <div title="UP DOWN DOUBLE ARROW">&#8661;</div>
            <div title="NORTH WEST DOUBLE ARROW">&#8662;</div>
            <div title="NORTH EAST DOUBLE ARROW">&#8663;</div>
            <div title="SOUTH EAST DOUBLE ARROW">&#8664;</div>
            <div title="SOUTH WEST DOUBLE ARROW">&#8665;</div>
            <div title="LEFTWARDS TRIPLE ARROW">&#8666;</div>
            <div title="RIGHTWARDS TRIPLE ARROW">&#8667;</div>
            <div title="LEFTWARDS SQUIGGLE ARROW">&#8668;</div>
            <div title="RIGHTWARDS SQUIGGLE ARROW">&#8669;</div>
            <div title="UPWARDS ARROW WITH DOUBLE STROKE">&#8670;</div>
            <div title="DOWNWARDS ARROW WITH DOUBLE STROKE">&#8671;</div>
            <div title="LEFTWARDS DASHED ARROW">&#8672;</div>
            <div title="UPWARDS DASHED ARROW">&#8673;</div>
            <div title="RIGHTWARDS DASHED ARROW">&#8674;</div>
            <div title="DOWNWARDS DASHED ARROW">&#8675;</div>
            <div title="LEFTWARDS ARROW TO BAR">&#8676;</div>
            <div title="RIGHTWARDS ARROW TO BAR">&#8677;</div>
            <div title="LEFTWARDS WHITE ARROW">&#8678;</div>
            <div title="UPWARDS WHITE ARROW">&#8679;</div>
            <div title="RIGHTWARDS WHITE ARROW">&#8680;</div>
            <div title="DOWNWARDS WHITE ARROW">&#8681;</div>
            <div title="UPWARDS WHITE ARROW FROM BAR">&#8682;</div>
            <div title="UPWARDS WHITE ARROW ON PEDESTAL">&#8683;</div>
            <div title="UPWARDS WHITE ARROW ON PEDESTAL WITH HORIZONTAL BAR">&#8684;</div>
            <div title="UPWARDS WHITE ARROW ON PEDESTAL WITH VERTICAL BAR">&#8685;</div>
            <div title="UPWARDS WHITE DOUBLE ARROW">&#8686;</div>
            <div title="UPWARDS WHITE DOUBLE ARROW ON PEDESTAL">&#8687;</div>
            <div title="RIGHTWARDS WHITE ARROW FROM WALL">&#8688;</div>
            <div title="NORTH WEST ARROW TO CORNER">&#8689;</div>
            <div title="SOUTH EAST ARROW TO CORNER">&#8690;</div>
            <div title="UP DOWN WHITE ARROW">&#8691;</div>
            <div title="RIGHT ARROW WITH SMALL CIRCLE">&#8692;</div>
            <div title="DOWNWARDS ARROW LEFTWARDS OF UPWARDS ARROW">&#8693;</div>
            <div title="THREE RIGHTWARDS ARROWS">&#8694;</div>
            <div title="LEFTWARDS ARROW WITH VERTICAL STROKE">&#8695;</div>
            <div title="RIGHTWARDS ARROW WITH VERTICAL STROKE">&#8696;</div>
            <div title="LEFT RIGHT ARROW WITH VERTICAL STROKE">&#8697;</div>
            <div title="LEFTWARDS ARROW WITH DOUBLE VERTICAL STROKE">&#8698;</div>
            <div title="RIGHTWARDS ARROW WITH DOUBLE VERTICAL STROKE">&#8699;</div>
            <div title="LEFT RIGHT ARROW WITH DOUBLE VERTICAL STROKE">&#8700;</div>
            <div title="LEFTWARDS OPEN-HEADED ARROW">&#8701;</div>
            <div title="RIGHTWARDS OPEN-HEADED ARROW">&#8702;</div>
            <div title="LEFT RIGHT OPEN-HEADED ARROW">&#8703;</div>
        
        </div>
        
        <div id="divBlockElements" class="tab-content container clearfix">
        
            <!-- Block Elements https://www.w3schools.com/charsets/ref_utf_block.asp -->
            <div title="UPPER HALF BLOCK">&#9600;</div>
            <div title="LOWER ONE EIGHTH BLOCK">&#9601;</div>
            <div title="LOWER ONE QUARTER BLOCK">&#9602;</div>
            <div title="LOWER THREE EIGHTHS BLOCK">&#9603;</div>
            <div title="LOWER HALF BLOCK">&#9604;</div>
            <div title="LOWER FIVE EIGHTHS BLOCK">&#9605;</div>
            <div title="LOWER THREE QUARTERS BLOCK">&#9606;</div>
            <div title="LOWER SEVEN EIGHTHS BLOCK">&#9607;</div>
            <div title="FULL BLOCK">&#9608;</div>
            <div title="LEFT SEVEN EIGHTHS BLOCK">&#9609;</div>
            <div title="LEFT THREE QUARTERS BLOCK">&#9610;</div>
            <div title="LEFT FIVE EIGHTHS BLOCK">&#9611;</div>
            <div title="LEFT HALF BLOCK">&#9612;</div>
            <div title="LEFT THREE EIGHTHS BLOCK">&#9613;</div>
            <div title="LEFT ONE QUARTER BLOCK">&#9614;</div>
            <div title="LEFT ONE EIGHTH BLOCK">&#9615;</div>
            <div title="RIGHT HALF BLOCK">&#9616;</div>
            <div title="LIGHT SHADE">&#9617;</div>
            <div title="MEDIUM SHADE">&#9618;</div>
            <div title="DARK SHADE">&#9619;</div>
            <div title="UPPER ONE EIGHTH BLOCK">&#9620;</div>
            <div title="RIGHT ONE EIGHTH BLOCK">&#9621;</div>
            <div title="QUADRANT LOWER LEFT">&#9622;</div>
            <div title="QUADRANT LOWER RIGHT">&#9623;</div>
            <div title="QUADRANT UPPER LEFT">&#9624;</div>
            <div title="QUADRANT UPPER LEFT AND LOWER LEFT AND LOWER RIGHT">&#9625;</div>
            <div title="QUADRANT UPPER LEFT AND LOWER RIGHT">&#9626;</div>
            <div title="QUADRANT UPPER LEFT AND UPPER RIGHT AND LOWER LEFT">&#9627;</div>
            <div title="QUADRANT UPPER LEFT AND UPPER RIGHT AND LOWER RIGHT">&#9628;</div>
            <div title="QUADRANT UPPER RIGHT">&#9629;</div>
            <div title="QUADRANT UPPER RIGHT AND LOWER LEFT">&#9630;</div>
            <div title="QUADRANT UPPER RIGHT AND LOWER LEFT AND LOWER RIGHT">&#9631;</div>
            
        
        </div>
        
        <div id="divBoxDrawings" class="tab-content container clearfix">
            
            <!-- Box Drawings https://www.w3schools.com/charsets/ref_utf_box.asp -->
            <div title="BOX DRAWINGS LIGHT HORIZONTAL">&#9472;</div>
            <div title="BOX DRAWINGS HEAVY HORIZONTAL">&#9473;</div>
            <div title="BOX DRAWINGS LIGHT VERTICAL">&#9474;</div>
            <div title="BOX DRAWINGS HEAVY VERTICAL">&#9475;</div>
            <div title="BOX DRAWINGS LIGHT TRIPLE DASH HORIZONTAL">&#9476;</div>
            <div title="BOX DRAWINGS HEAVY TRIPLE DASH HORIZONTAL">&#9477;</div>
            <div title="BOX DRAWINGS LIGHT TRIPLE DASH VERTICAL">&#9478;</div>
            <div title="BOX DRAWINGS HEAVY TRIPLE DASH VERTICAL">&#9479;</div>
            <div title="BOX DRAWINGS LIGHT QUADRUPLE DASH HORIZONTAL">&#9480;</div>
            <div title="BOX DRAWINGS HEAVY QUADRUPLE DASH HORIZONTAL">&#9481;</div>
            <div title="BOX DRAWINGS LIGHT QUADRUPLE DASH VERTICAL">&#9482;</div>
            <div title="BOX DRAWINGS HEAVY QUADRUPLE DASH VERTICAL">&#9483;</div>
            <div title="BOX DRAWINGS LIGHT DOWN AND RIGHT">&#9484;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND RIGHT HEAVY">&#9485;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND RIGHT LIGHT">&#9486;</div>
            <div title="BOX DRAWINGS HEAVY DOWN AND RIGHT">&#9487;</div>
            <div title="BOX DRAWINGS LIGHT DOWN AND LEFT">&#9488;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND LEFT HEAVY">&#9489;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND LEFT LIGHT">&#9490;</div>
            <div title="BOX DRAWINGS HEAVY DOWN AND LEFT">&#9491;</div>
            <div title="BOX DRAWINGS LIGHT UP AND RIGHT">&#9492;</div>
            <div title="BOX DRAWINGS UP LIGHT AND RIGHT HEAVY">&#9493;</div>
            <div title="BOX DRAWINGS UP HEAVY AND RIGHT LIGHT">&#9494;</div>
            <div title="BOX DRAWINGS HEAVY UP AND RIGHT">&#9495;</div>
            <div title="BOX DRAWINGS LIGHT UP AND LEFT">&#9496;</div>
            <div title="BOX DRAWINGS UP LIGHT AND LEFT HEAVY">&#9497;</div>
            <div title="BOX DRAWINGS UP HEAVY AND LEFT LIGHT">&#9498;</div>
            <div title="BOX DRAWINGS HEAVY UP AND LEFT">&#9499;</div>
            <div title="BOX DRAWINGS LIGHT VERTICAL AND RIGHT">&#9500;</div>
            <div title="BOX DRAWINGS VERTICAL LIGHT AND RIGHT HEAVY">&#9501;</div>
            <div title="BOX DRAWINGS UP HEAVY AND RIGHT DOWN LIGHT">&#9502;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND RIGHT UP LIGHT">&#9503;</div>
            <div title="BOX DRAWINGS VERTICAL HEAVY AND RIGHT LIGHT">&#9504;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND RIGHT UP HEAVY">&#9505;</div>
            <div title="BOX DRAWINGS UP LIGHT AND RIGHT DOWN HEAVY">&#9506;</div>
            <div title="BOX DRAWINGS HEAVY VERTICAL AND RIGHT">&#9507;</div>
            <div title="BOX DRAWINGS LIGHT VERTICAL AND LEFT">&#9508;</div>
            <div title="BOX DRAWINGS VERTICAL LIGHT AND LEFT HEAVY">&#9509;</div>
            <div title="BOX DRAWINGS UP HEAVY AND LEFT DOWN LIGHT">&#9510;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND LEFT UP LIGHT">&#9511;</div>
            <div title="BOX DRAWINGS VERTICAL HEAVY AND LEFT LIGHT">&#9512;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND LEFT UP HEAVY">&#9513;</div>
            <div title="BOX DRAWINGS UP LIGHT AND LEFT DOWN HEAVY">&#9514;</div>
            <div title="BOX DRAWINGS HEAVY VERTICAL AND LEFT">&#9515;</div>
            <div title="BOX DRAWINGS LIGHT DOWN AND HORIZONTAL">&#9516;</div>
            <div title="BOX DRAWINGS LEFT HEAVY AND RIGHT DOWN LIGHT">&#9517;</div>
            <div title="BOX DRAWINGS RIGHT HEAVY AND LEFT DOWN LIGHT">&#9518;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND HORIZONTAL HEAVY">&#9519;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND HORIZONTAL LIGHT">&#9520;</div>
            <div title="BOX DRAWINGS RIGHT LIGHT AND LEFT DOWN HEAVY">&#9521;</div>
            <div title="BOX DRAWINGS LEFT LIGHT AND RIGHT DOWN HEAVY">&#9522;</div>
            <div title="BOX DRAWINGS HEAVY DOWN AND HORIZONTAL">&#9523;</div>
            <div title="BOX DRAWINGS LIGHT UP AND HORIZONTAL">&#9524;</div>
            <div title="BOX DRAWINGS LEFT HEAVY AND RIGHT UP LIGHT">&#9525;</div>
            <div title="BOX DRAWINGS RIGHT HEAVY AND LEFT UP LIGHT">&#9526;</div>
            <div title="BOX DRAWINGS UP LIGHT AND HORIZONTAL HEAVY">&#9527;</div>
            <div title="BOX DRAWINGS UP HEAVY AND HORIZONTAL LIGHT">&#9528;</div>
            <div title="BOX DRAWINGS RIGHT LIGHT AND LEFT UP HEAVY">&#9529;</div>
            <div title="BOX DRAWINGS LEFT LIGHT AND RIGHT UP HEAVY">&#9530;</div>
            <div title="BOX DRAWINGS HEAVY UP AND HORIZONTAL">&#9531;</div>
            <div title="BOX DRAWINGS LIGHT VERTICAL AND HORIZONTAL">&#9532;</div>
            <div title="BOX DRAWINGS LEFT HEAVY AND RIGHT VERTICAL LIGHT">&#9533;</div>
            <div title="BOX DRAWINGS RIGHT HEAVY AND LEFT VERTICAL LIGHT">&#9534;</div>
            <div title="BOX DRAWINGS VERTICAL LIGHT AND HORIZONTAL HEAVY">&#9535;</div>
            <div title="BOX DRAWINGS UP HEAVY AND DOWN HORIZONTAL LIGHT">&#9536;</div>
            <div title="BOX DRAWINGS DOWN HEAVY AND UP HORIZONTAL LIGHT">&#9537;</div>
            <div title="BOX DRAWINGS VERTICAL HEAVY AND HORIZONTAL LIGHT">&#9538;</div>
            <div title="BOX DRAWINGS LEFT UP HEAVY AND RIGHT DOWN LIGHT">&#9539;</div>
            <div title="BOX DRAWINGS RIGHT UP HEAVY AND LEFT DOWN LIGHT">&#9540;</div>
            <div title="BOX DRAWINGS LEFT DOWN HEAVY AND RIGHT UP LIGHT">&#9541;</div>
            <div title="BOX DRAWINGS RIGHT DOWN HEAVY AND LEFT UP LIGHT">&#9542;</div>
            <div title="BOX DRAWINGS DOWN LIGHT AND UP HORIZONTAL HEAVY">&#9543;</div>
            <div title="BOX DRAWINGS UP LIGHT AND DOWN HORIZONTAL HEAVY">&#9544;</div>
            <div title="BOX DRAWINGS RIGHT LIGHT AND LEFT VERTICAL HEAVY">&#9545;</div>
            <div title="BOX DRAWINGS LEFT LIGHT AND RIGHT VERTICAL HEAVY">&#9546;</div>
            <div title="BOX DRAWINGS HEAVY VERTICAL AND HORIZONTAL">&#9547;</div>
            <div title="BOX DRAWINGS LIGHT DOUBLE DASH HORIZONTAL">&#9548;</div>
            <div title="BOX DRAWINGS HEAVY DOUBLE DASH HORIZONTAL">&#9549;</div>
            <div title="BOX DRAWINGS LIGHT DOUBLE DASH VERTICAL">&#9550;</div>
            <div title="BOX DRAWINGS HEAVY DOUBLE DASH VERTICAL">&#9551;</div>
            <div title="BOX DRAWINGS DOUBLE HORIZONTAL">&#9552;</div>
            <div title="BOX DRAWINGS DOUBLE VERTICAL">&#9553;</div>
            <div title="BOX DRAWINGS DOWN SINGLE AND RIGHT DOUBLE">&#9554;</div>
            <div title="BOX DRAWINGS DOWN DOUBLE AND RIGHT SINGLE">&#9555;</div>
            <div title="BOX DRAWINGS DOUBLE DOWN AND RIGHT">&#9556;</div>
            <div title="BOX DRAWINGS DOWN SINGLE AND LEFT DOUBLE">&#9557;</div>
            <div title="BOX DRAWINGS DOWN DOUBLE AND LEFT SINGLE">&#9558;</div>
            <div title="BOX DRAWINGS DOUBLE DOWN AND LEFT">&#9559;</div>
            <div title="BOX DRAWINGS UP SINGLE AND RIGHT DOUBLE">&#9560;</div>
            <div title="BOX DRAWINGS UP DOUBLE AND RIGHT SINGLE">&#9561;</div>
            <div title="BOX DRAWINGS DOUBLE UP AND RIGHT">&#9562;</div>
            <div title="BOX DRAWINGS UP SINGLE AND LEFT DOUBLE">&#9563;</div>
            <div title="BOX DRAWINGS UP DOUBLE AND LEFT SINGLE">&#9564;</div>
            <div title="BOX DRAWINGS DOUBLE UP AND LEFT">&#9565;</div>
            <div title="BOX DRAWINGS VERTICAL SINGLE AND RIGHT DOUBLE">&#9566;</div>
            <div title="BOX DRAWINGS VERTICAL DOUBLE AND RIGHT SINGLE">&#9567;</div>
            <div title="BOX DRAWINGS DOUBLE VERTICAL AND RIGHT">&#9568;</div>
            <div title="BOX DRAWINGS VERTICAL SINGLE AND LEFT DOUBLE">&#9569;</div>
            <div title="BOX DRAWINGS VERTICAL DOUBLE AND LEFT SINGLE">&#9570;</div>
            <div title="BOX DRAWINGS DOUBLE VERTICAL AND LEFT">&#9571;</div>
            <div title="BOX DRAWINGS DOWN SINGLE AND HORIZONTAL DOUBLE">&#9572;</div>
            <div title="BOX DRAWINGS DOWN DOUBLE AND HORIZONTAL SINGLE">&#9573;</div>
            <div title="BOX DRAWINGS DOUBLE DOWN AND HORIZONTAL">&#9574;</div>
            <div title="BOX DRAWINGS UP SINGLE AND HORIZONTAL DOUBLE">&#9575;</div>
            <div title="BOX DRAWINGS UP DOUBLE AND HORIZONTAL SINGLE">&#9576;</div>
            <div title="BOX DRAWINGS DOUBLE UP AND HORIZONTAL">&#9577;</div>
            <div title="BOX DRAWINGS VERTICAL SINGLE AND HORIZONTAL DOUBLE">&#9578;</div>
            <div title="BOX DRAWINGS VERTICAL DOUBLE AND HORIZONTAL SINGLE">&#9579;</div>
            <div title="BOX DRAWINGS DOUBLE VERTICAL AND HORIZONTAL">&#9580;</div>
            <div title="BOX DRAWINGS LIGHT ARC DOWN AND RIGHT">&#9581;</div>
            <div title="BOX DRAWINGS LIGHT ARC DOWN AND LEFT">&#9582;</div>
            <div title="BOX DRAWINGS LIGHT ARC UP AND LEFT">&#9583;</div>
            <div title="BOX DRAWINGS LIGHT ARC UP AND RIGHT">&#9584;</div>
            <div title="BOX DRAWINGS LIGHT DIAGONAL UPPER RIGHT TO LOWER LEFT">&#9585;</div>
            <div title="BOX DRAWINGS LIGHT DIAGONAL UPPER LEFT TO LOWER RIGHT">&#9586;</div>
            <div title="BOX DRAWINGS LIGHT DIAGONAL CROSS">&#9587;</div>
            <div title="BOX DRAWINGS LIGHT LEFT">&#9588;</div>
            <div title="BOX DRAWINGS LIGHT UP">&#9589;</div>
            <div title="BOX DRAWINGS LIGHT RIGHT">&#9590;</div>
            <div title="BOX DRAWINGS LIGHT DOWN">&#9591;</div>
            <div title="BOX DRAWINGS HEAVY LEFT">&#9592;</div>
            <div title="BOX DRAWINGS HEAVY UP">&#9593;</div>
            <div title="BOX DRAWINGS HEAVY RIGHT">&#9594;</div>
            <div title="BOX DRAWINGS HEAVY DOWN">&#9595;</div>
            <div title="BOX DRAWINGS LIGHT LEFT AND HEAVY RIGHT">&#9596;</div>
            <div title="BOX DRAWINGS LIGHT UP AND HEAVY DOWN">&#9597;</div>
            <div title="BOX DRAWINGS HEAVY LEFT AND LIGHT RIGHT">&#9598;</div>
            <div title="BOX DRAWINGS HEAVY UP AND LIGHT DOWN">&#9599;</div>
            
        </div>
        
        <div id="divCurrencySymbols" class="tab-content container clearfix">
        
            <!-- Currency Symbols: https://www.w3schools.com/charsets/ref_utf_currency.asp -->
            <div title="EURO-CURRENCY SIGN">&#8352;</div>
            <div title="COLON SIGN">&#8353;</div>
            <div title="CRUZEIRO SIGN">&#8354;</div>
            <div title="FRENCH FRANC SIGN">&#8355;</div>
            <div title="LIRA SIGN">&#8356;</div>
            <div title="MILL SIGN">&#8357;</div>
            <div title="NAIRA SIGN">&#8358;</div>
            <div title="PESETA SIGN">&#8359;</div>
            <div title="RUPEE SIGN">&#8360;</div>
            <div title="WON SIGN">&#8361;</div>
            <div title="NEW SIGN">&#8362;</div>
            <div title="DONG SIGN">&#8363;</div>
            <div title="EURO SIGN">&euro;</div>
            <div title="KIP SIGN">&#8365;</div>
            <div title="TUGRIK SIGN">&#8366;</div>
            <div title="DRACHMA SIGN">&#8367;</div>
            <div title="GERMAN PENNY SYMBOL">&#8368;</div>
            <div title="PESO SIGN">&#8369;</div>
            <div title="GUARANI SIGN">&#8370;</div>
            <div title="AUSTRAL SIGN">&#8371;</div>
            <div title="HRYVNIA SIGN">&#8372;</div>
            <div title="CEDI SIGN">&#8373;</div>
            <div title="LIVRE TOURNOIS SIGN">&#8374;</div>
            <div title="SPESMILO  SIGN">&#8375;</div>
            <div title="TENGE SIGN">&#8376;</div>
            <div title="INDIAN RUPEE SIGN">&#8377;</div>
            <div title="TURKISH LIRA SIGN">&#8378;</div>
            <!--<div>&#8379;</div>
            <div>&#8380;</div>-->
            <div title="RUBLE SIGN">&#8381;</div>
            <!--<div>&#8382;</div>
            <div>&#8383;</div>-->
        
        </div>
        
        <div id="divDingbats" class="tab-content container clearfix">
        
            <!-- Dingbats https://www.w3schools.com/charsets/ref_utf_dingbats.asp -->
            <div title="UPPER BLADE SCISSORS">&#9985;</div>
            <div title="BLACK SCISSORS">&#9986;</div>
            <div title="LOWER BLADE SCISSORS">&#9987;</div>
            <div title="WHITE SCISSORS">&#9988;</div>
            <div title="WHITE HEAVY CHECK MARK">&#9989;</div>
            <div title="TELEPHONE LOCATION SIGN">&#9990;</div>
            <div title="TAPE DRIVE">&#9991;</div>
            <div title="AIRPLANE">&#9992;</div>
            <div title="ENVELOPE">&#9993;</div>
            <div title="RAISED FIST">&#9994;</div>
            <div title="RAISED HAND">&#9995;</div>
            <div title="VICTORY HAND">&#9996;</div>
            <div title="WRITING HAND">&#9997;</div>
            <div title="LOWER RIGHT PENCIL">&#9998;</div>
            <div title="PENCIL">&#9999;</div>
            <div title="UPPER RIGHT PENCIL">&#10000;</div>
            <div title="WHITE NIB">&#10001;</div>
            <div title="BLACK NIB">&#10002;</div>
            <div title="CHECK MARK">&#10003;</div>
            <div title="HEAVY CHECK MARK">&#10004;</div>
            <div title="MULTIPLICATION X">&#10005;</div>
            <div title="HEAVY MULTIPLICATION X">&#10006;</div>
            <div title="BALLOT X">&#10007;</div>
            <div title="HEAVY BALLOT X">&#10008;</div>
            <div title="OUTLINED GREEK CROSS">&#10009;</div>
            <div title="HEAVY GREEK CROSS">&#10010;</div>
            <div title="OPEN CENTRE CROSS">&#10011;</div>
            <div title="HEAVY OPEN CENTRE CROSS">&#10012;</div>
            <div title="LATIN CROSS">&#10013;</div>
            <div title="SHADOWED WHITE LATIN CROSS">&#10014;</div>
            <div title="OUTLINED LATIN CROSS">&#10015;</div>
            <div title="MALTESE CROSS">&#10016;</div>
            <div title="STAR OF DAVID">&#10017;</div>
            <div title="FOUR TEARDROP-SPOKED ASTERISK">&#10018;</div>
            <div title="FOUR BALLOON-SPOKED ASTERISK">&#10019;</div>
            <div title="HEAVY FOUR BALLOON-SPOKED ASTERISK">&#10020;</div>
            <div title="FOUR CLUB-SPOKED ASTERISK">&#10021;</div>
            <div title="BLACK FOUR POINTED STAR">&#10022;</div>
            <div title="WHITE FOUR POINTED STAR">&#10023;</div>
            <div title="SPARKLES">&#10024;</div>
            <div title="STRESS OUTLINED WHITE STAR">&#10025;</div>
            <div title="CIRCLED WHITE STAR">&#10026;</div>
            <div title="OPEN CENTRE BLACK STAR">&#10027;</div>
            <div title="BLACK CENTRE WHITE STAR">&#10028;</div>
            <div title="OUTLINED BLACK STAR">&#10029;</div>
            <div title="HEAVY OUTLINED BLACK STAR">&#10030;</div>
            <div title="PINWHEEL STAR">&#10031;</div>
            <div title="SHADOWED WHITE STAR">&#10032;</div>
            <div title="HEAVY ASTERISK">&#10033;</div>
            <div title="OPEN CENTRE ASTERISK">&#10034;</div>
            <div title="EIGHT SPOKED ASTERISK">&#10035;</div>
            <div title="EIGHT POINTED BLACK STAR">&#10036;</div>
            <div title="EIGHT POINTED PINWHEEL STAR">&#10037;</div>
            <div title="SIX POINTED BLACK STAR">&#10038;</div>
            <div title="EIGHT POINTED RECTILINEAR BLACK STAR">&#10039;</div>
            <div title="HEAVY EIGHT POINTED RECTILINEAR BLACK STAR">&#10040;</div>
            <div title="TWELVE POINTED BLACK STAR">&#10041;</div>
            <div title="SIXTEEN POINTED ASTERISK">&#10042;</div>
            <div title="TEARDROP-SPOKED ASTERISK">&#10043;</div>
            <div title="OPEN CENTRE TEARDROP-SPOKED ASTERISK">&#10044;</div>
            <div title="HEAVY TEARDROP-SPOKED ASTERISK">&#10045;</div>
            <div title="SIX PETALLED BLACK AND WHITE FLORETTE">&#10046;</div>
            <div title="BLACK FLORETTE">&#10047;</div>
            <div title="WHITE FLORETTE">&#10048;</div>
            <div title="EIGHT PETALLED OUTLINED BLACK FLORETTE">&#10049;</div>
            <div title="CIRCLED OPEN CENTRE EIGHT POINTED STAR">&#10050;</div>
            <div title="HEAVY TEARDROP-SPOKED PINWHEEL ASTERISK">&#10051;</div>
            <div title="SNOWFLAKE">&#10052;</div>
            <div title="TIGHT TRIFOLIATE SNOWFLAKE">&#10053;</div>
            <div title="HEAVY CHEVRON SNOWFLAKE">&#10054;</div>
            <div title="SPARKLE">&#10055;</div>
            <div title="HEAVY SPARKLE">&#10056;</div>
            <div title="BALLOON-SPOKED ASTERISK">&#10057;</div>
            <div title="EIGHT TEARDROP-SPOKED PROPELLER ASTERISK">&#10058;</div>
            <div title="HEAVY EIGHT TEARDROP-SPOKED PROPELLER ASTERISK">&#10059;</div>
            <div title="CROSS MARK">&#10060;</div>
            <div title="SHADOWED WHITE CIRCLE">&#10061;</div>
            <div title="NEGATIVE SQUARED CROSS MARK">&#10062;</div>
            <div title="LOWER RIGHT DROP-SHADOWED WHITE SQUARE">&#10063;</div>
            <div title="UPPER RIGHT DROP-SHADOWED WHITE SQUARE">&#10064;</div>
            <div title="LOWER RIGHT SHADOWED WHITE SQUARE">&#10065;</div>
            <div title="UPPER RIGHT SHADOWED WHITE SQUARE">&#10066;</div>
            <div title="BLACK QUESTION MARK ORNAMENT">&#10067;</div>
            <div title="WHITE QUESTION MARK ORNAMENT">&#10068;</div>
            <div title="WHITE EXCLAMATION MARK ORNAMENT">&#10069;</div>
            <div title="BLACK DIAMOND MINUS WHITE X">&#10070;</div>
            <div title="HEAVY EXCLAMATION MARK SYMBOL">&#10071;</div>
            <div title="LIGHT VERTICAL BAR">&#10072;</div>
            <div title="MEDIUM VERTICAL BAR">&#10073;</div>
            <div title="HEAVY VERTICAL BAR">&#10074;</div>
            <div title="HEAVY SINGLE TURNED COMMA QUOTATION MARK ORNAMENT">&#10075;</div>
            <div title="HEAVY SINGLE COMMA QUOTATION MARK ORNAMENT">&#10076;</div>
            <div title="HEAVY DOUBLE TURNED COMMA QUOTATION MARK ORNAMENT">&#10077;</div>
            <div title="HEAVY DOUBLE COMMA QUOTATION MARK ORNAMENT">&#10078;</div>
            <div title="HEAVY LOW SINGLE COMMA QUOTATION MARK ORNAMENT">&#10079;</div>
            <div title="HEAVY LOW DOUBLE COMMA QUOTATION MARK ORNAMENT">&#10080;</div>
            <div title="CURVED STEM PARAGRAPH SIGN ORNAMENT">&#10081;</div>
            <div title="HEAVY EXCLAMATION MARK ORNAMENT">&#10082;</div>
            <div title="HEAVY HEART EXCLAMATION MARK ORNAMENT">&#10083;</div>
            <div title="HEAVY BLACK HEART">&#10084;</div>
            <div title="ROTATED HEAVY BLACK HEART BULLET">&#10085;</div>
            <div title="FLORAL HEART">&#10086;</div>
            <div title="ROTATED FLORAL HEART BULLET">&#10087;</div>
            <div title="MEDIUM LEFT PARENTHESIS ORNAMENT">&#10088;</div>
            <div title="MEDIUM RIGHT PARENTHESIS ORNAMENT">&#10089;</div>
            <div title="MEDIUM FLATTENED LEFT PARENTHESIS ORNAMENT">&#10090;</div>
            <div title="MEDIUM FLATTENED RIGHT PARENTHESIS ORNAMENT">&#10091;</div>
            <div title="MEDIUM LEFT-POINTING ANGLE BRACKET ORNAMENT">&#10092;</div>
            <div title="MEDIUM RIGHT-POINTING ANGLE BRACKET ORNAMENT">&#10093;</div>
            <div title="HEAVY LEFT-POINTING ANGLE QUOTATION MARK ORNAMENT">&#10094;</div>
            <div title="HEAVY RIGHT-POINTING ANGLE QUOTATION MARK ORNAMENT">&#10095;</div>
            <div title="HEAVY LEFT-POINTING ANGLE BRACKET ORNAMENT">&#10096;</div>
            <div title="HEAVY RIGHT-POINTING ANGLE BRACKET ORNAMENT">&#10097;</div>
            <div title="LIGHT LEFT TORTOISE SHELL BRACKET ORNAMENT">&#10098;</div>
            <div title="LIGHT RIGHT TORTOISE SHELL BRACKET ORNAMENT">&#10099;</div>
            <div title="MEDIUM LEFT CURLY BRACKET ORNAMENT">&#10100;</div>
            <div title="MEDIUM RIGHT CURLY BRACKET ORNAMENT">&#10101;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT ONE">&#10102;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT TWO">&#10103;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT THREE">&#10104;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT FOUR">&#10105;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT FIVE">&#10106;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT SIX">&#10107;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT SEVEN">&#10108;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT EIGHT">&#10109;</div>
            <div title="DINGBAT NEGATIVE CIRCLED DIGIT NINE">&#10110;</div>
            <div title="DINGBAT NEGATIVE CIRCLED NUMBER TEN">&#10111;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT ONE">&#10112;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT TWO">&#10113;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT THREE">&#10114;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT FOUR">&#10115;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT FIVE">&#10116;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT SIX">&#10117;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT SEVEN">&#10118;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT EIGHT">&#10119;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT NINE">&#10120;</div>
            <div title="DINGBAT CIRCLED SANS-SERIF DIGIT TEN">&#10121;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT ONE">&#10122;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT TWO">&#10123;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT THREE">&#10124;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT FOUR">&#10125;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT FIVE">&#10126;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT SIX">&#10127;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT SEVEN">&#10128;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT EIGHT">&#10129;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT NINE">&#10130;</div>
            <div title="DINGBAT NEGATIVE CIRCLED SANS-SERIF DIGIT TEN">&#10131;</div>
            <div title="HEAVY WIDE-HEADED RIGHTWARDS ARROW">&#10132;</div>
            <div title="HEAVY PLUS SIGN">&#10133;</div>
            <div title="HEAVY MINUS SIGN">&#10134;</div>
            <div title="HEAVY DIVISION SIGN">&#10135;</div>
            <div title="HEAVY SOUTH EAST ARROW">&#10136;</div>
            <div title="HEAVY RIGHTWARDS ARROW">&#10137;</div>
            <div title="HEAVY NORTH EAST ARROW">&#10138;</div>
            <div title="DRAFTING POINT RIGHTWARDS ARROW">&#10139;</div>
            <div title="HEAVY ROUND-TIPPED RIGHTWARDS ARROW">&#10140;</div>
            <div title="TRIANGLE-HEADED RIGHTWARDS ARROW">&#10141;</div>
            <div title="HEAVY TRIANGLE-HEADED RIGHTWARDS ARROW">&#10142;</div>
            <div title="DASHED TRIANGLE-HEADED RIGHTWARDS ARROW">&#10143;</div>
            <div title="HEAVY DASHED TRIANGLE-HEADED RIGHTWARDS ARROW">&#10144;</div>
            <div title="BLACK RIGHTWARDS ARROW">&#10145;</div>
            <div title="THREE-D TOP-LIGHTED RIGHTWARDS ARROWHEAD">&#10146;</div>
            <div title="THREE-D BOTTOM-LIGHTED RIGHTWARDS ARROWHEAD">&#10147;</div>
            <div title="BLACK RIGHTWARDS ARROWHEAD">&#10148;</div>
            <div title="HEAVY BLACK CURVED DOWNWARDS AND RIGHTWARDS ARROW">&#10149;</div>
            <div title="HEAVY BLACK CURVED UPWARDS AND RIGHTWARDS ARROW">&#10150;</div>
            <div title="SQUAT BLACK RIGHTWARDS ARROW">&#10151;</div>
            <div title="HEAVY CONCAVE-POINTED BLACK RIGHTWARDS ARROW">&#10152;</div>
            <div title="RIGHT-SHADED WHITE RIGHTWARDS ARROW">&#10153;</div>
            <div title="LEFT-SHADED WHITE RIGHTWARDS ARROW">&#10154;</div>
            <div title="BACK-TILTED SHADOWED WHITE RIGHTWARDS ARROW">&#10155;</div>
            <div title="FRONT-TILTED SHADOWED WHITE RIGHTWARDS ARROW">&#10156;</div>
            <div title="HEAVY LOWER RIGHT-SHADOWED WHITE RIGHTWARDS ARROW">&#10157;</div>
            <div title="HEAVY UPPER RIGHT-SHADOWED WHITE RIGHTWARDS ARROW">&#10158;</div>
            <div title="NOTCHED LOWER RIGHT-SHADOWED WHITE RIGHTWARDS ARROW">&#10159;</div>
            <div title="CURLY LOOP">&#10160;</div>
            <div title="NOTCHED UPPER RIGHT-SHADOWED WHITE RIGHTWARDS ARROW">&#10161;</div>
            <div title="CIRCLED HEAVY WHITE RIGHTWARDS ARROW">&#10162;</div>
            <div title="WHITE-FEATHERED RIGHTWARDS ARROW">&#10163;</div>
            <div title="BLACK-FEATHERED SOUTH EAST ARROW">&#10164;</div>
            <div title="BLACK-FEATHERED RIGHTWARDS ARROW">&#10165;</div>
            <div title="BLACK-FEATHERED NORTH EAST ARROW">&#10166;</div>
            <div title="HEAVY BLACK-FEATHERED SOUTH EAST ARROW">&#10167;</div>
            <div title="HEAVY BLACK-FEATHERED RIGHTWARDS ARROW">&#10168;</div>
            <div title="HEAVY BLACK-FEATHERED NORTH EAST ARROW">&#10169;</div>
            <div title="TEARDROP-BARBED RIGHTWARDS ARROW">&#10170;</div>
            <div title="HEAVY TEARDROP-SHANKED RIGHTWARDS ARROW">&#10171;</div>
            <div title="WEDGE-TAILED RIGHTWARDS ARROW">&#10172;</div>
            <div title="HEAVY WEDGE-TAILED RIGHTWARDS ARROW">&#10173;</div>
            <div title="OPEN-OUTLINED RIGHTWARDS ARROW">&#10174;</div>
            <div title="DOUBLE CURLY LOOP">&#10175;</div>
        </div>
        
        <!--
        <div id="divEmoji" class="tab-content container clearfix">
        
        </div>
        <div id="divEmojiSkinTones" class="tab-content container clearfix">
        
        </div>
        -->
        
        <div id="divEmojiSmileys" class="tab-content container clearfix">
        
            <!-- Emoji Smileys https://www.w3schools.com/charsets/ref_emoji_smileys.asp -->
            <div title="GRINNING FACE">&#128512;</div>
            <div title="GRINNING FACE WITH SMILING EYES">&#128513;</div>
            <div title="FACE WITH TEARS OF JOY">&#128514;</div>
            <div title="SMILING FACE WITH OPEN MOUTH">&#128515;</div>
            <div title="SMILING FACE WITH OPEN MOUTH AND SMILING EYES">&#128516;</div>
            <div title="SMILING FACE WITH OPEN MOUTH AND COLD SWEAT">&#128517;</div>
            <div title="SMILING FACE WITH OPEN MOUTH AND TIGHTLY-CLOSED EYES">&#128518;</div>
            <div title="SMILING FACE WITH HALO">&#128519;</div>
            <div title="SMILING FACE WITH HORNS">&#128520;</div>
            <div title="WINKING FACE">&#128521;</div>
            <div title="SMILING FACE WITH SMILING EYES">&#128522;</div>
            <div title="FACE SAVOURING DELICIOUS FOOD">&#128523;</div>
            <div title="RELIEVED FACE">&#128524;</div>
            <div title="SMILING FACE WITH HEART-SHAPED EYES">&#128525;</div>
            <div title="SMILING FACE WITH SUNGLASSES">&#128526;</div>
            <div title="SMIRKING FACE">&#128527;</div>
            <div title="NEUTRAL FACE">&#128528;</div>
            <div title="EXPRESSIONLESS FACE">&#128529;</div>
            <div title="UNAMUSED FACE">&#128530;</div>
            <div title="FACE WITH COLD SWEAT">&#128531;</div>
            <div title="PENSIVE FACE">&#128532;</div>
            <div title="CONFUSED FACE">&#128533;</div>
            <div title="CONFOUNDED FACE">&#128534;</div>
            <div title="KISSING FACE">&#128535;</div>
            <div title="FACE THROWING A KISS">&#128536;</div>
            <div title="KISSING FACE WITH SMILING EYES">&#128537;</div>
            <div title="KISSING FACE WITH CLOSED EYES">&#128538;</div>
            <div title="FACE WITH STUCK-OUT TONGUE">&#128539;</div>
            <div title="FACE WITH STUCK-OUT TONGUE AND WINKING EYE">&#128540;</div>
            <div title="FACE WITH STUCK-OUT TONGUE AND TIGHTLY-CLOSED EYES">&#128541;</div>
            <div title="DISAPPOINTED FACE">&#128542;</div>
            <div title="WORRIED FACE">&#128543;</div>
            <div title="ANGRY FACE">&#128544;</div>
            <div title="POUTING FACE">&#128545;</div>
            <div title="CRYING FACE">&#128546;</div>
            <div title="PERSEVERING FACE">&#128547;</div>
            <div title="FACE WITH LOOK OF TRIUMPH">&#128548;</div>
            <div title="DISAPPOINTED BUT RELIEVED FACE">&#128549;</div>
            <div title="FROWNING FACE WITH OPEN MOUTH">&#128550;</div>
            <div title="ANGUISHED FACE">&#128551;</div>
            <div title="FEARFUL FACE">&#128552;</div>
            <div title="WEARY FACE">&#128553;</div>
            <div title="SLEEPY FACE">&#128554;</div>
            <div title="TIRED FACE">&#128555;</div>
            <div title="GRIMACING FACE">&#128556;</div>
            <div title="LOUDLY CRYING FACE">&#128557;</div>
            <div title="FACE WITH OPEN MOUTH">&#128558;</div>
            <div title="HUSHED FACE">&#128559;</div>
            <div title="FACE WITH OPEN MOUTH AND COLD SWEAT">&#128560;</div>
            <div title="FACE SCREAMING IN FEAR">&#128561;</div>
            <div title="ASTONISHED FACE">&#128562;</div>
            <div title="FLUSHED FACE">&#128563;</div>
            <div title="SLEEPING FACE">&#128564;</div>
            <div title="DIZZY FACE">&#128565;</div>
            <div title="FACE WITHOUT MOUTH">&#128566;</div>
            <div title="FACE WITH MEDICAL MASK">&#128567;</div>
            <div title="">&#128568;</div>
            <div title="">&#128569;</div>
            <div title="">&#128570;</div>
            <div title="">&#128571;</div>
            <div title="">&#128572;</div>
            <div title="">&#128573;</div>
            <div title="">&#128574;</div>
            <div title="">&#128575;</div>
            <div title="">&#128576;</div>
            <!--<div>&#128577;</div>
            <div>&#128578;</div>
            <div>&#128579;</div>
            <div>&#128580;</div>
            <div>&#129296;</div>
            <div>&#129297;</div>
            <div>&#129298;</div>
            <div>&#129299;</div>
            <div>&#129300;</div>
            <div>&#129301;</div>
            <div>&#129312;</div>
            <div>&#129313;</div>
            <div>&#129314;</div>
            <div>&#129315;</div>
            <div>&#129316;</div>
            <div>&#129317;</div>
            <div>&#129319;</div>
            <div>&#129320;</div>
            <div>&#129321;</div>
            <div>&#129322;</div>
            <div>&#129323;</div>
            <div>&#129324;</div>
            <div>&#129325;</div>
            <div>&#129326;</div>
            <div>&#129327;</div>
            <div>&#129488;</div>-->
        </div>
        
        <div id="divGeneralPunctuation" class="tab-content container clearfix">
        
            <!-- General Punctuation: https://www.w3schools.com/charsets/ref_utf_punctuation.asp -->
            <!--<div>&#8192;</div>
            <div>&#8193;</div>
            <div>&ensp;</div>
            <div>&emsp;</div>
            <div>&#8196;</div>
            <div>&#8197;</div>
            <div>&#8198;</div>
            <div>&#8199;</div>
            <div>&#8200;</div>
            <div>&thinsp;</div>
            <div>&#8202;</div>
            <div>&#8203;</div>
            <div>&zwnj;</div>
            <div>&zwj;</div>
            <div>&lrm;</div>
            <div>&rlm;</div>-->
            <div title="HYPHEN">&#8208;</div>
            <div title="NON-BREAKING HYPHEN">&#8209;</div>
            <div title="FIGURE DASH">&#8210;</div>
            <div title="EN DASH">&ndash;</div>
            <div title="EM DASH">&mdash;</div>
            <div title="HORIZONTAL BAR">&#8213;</div>
            <div title="DOUBLE VERTICAL LINE">&#8214;</div>
            <div title="DOUBLE LOW LINE">&#8215;</div>
            <div title="LEFT SINGLE QUOTATION MARK">&lsquo;</div>
            <div title="RIGHT SINGLE QUOTATION MARK">&rsquo;</div>
            <div title="SINGLE LOW-9 QUOTATION MARK">&sbquo;</div>
            <div title="SINGLE HIGH-REVERSED-9 QUOTATION MARK">&#8219;</div>
            <div title="LEFT DOUBLE QUOTATION MARK">&ldquo;</div>
            <div title="RIGHT DOUBLE QUOTATION MARK">&rdquo;</div>
            <div title="DOUBLE LOW-9 QUOTATION MARK">&bdquo;</div>
            <div title="DOUBLE HIGH-REVERSED-9 QUOTATION MARK">&#8223;</div>
            <div title="DAGGER">&dagger;</div>
            <div title="DOUBLE DAGGER">&Dagger;</div>
            <div title="BULLET">&bull;</div>
            <div title="TRIANGULAR BULLET">&#8227;</div>
            <div title="ONE DOT LEADER">&#8228;</div>
            <div title="TWO DOT LEADER">&#8229;</div>
            <div title="HORIZONTAL ELLIPSIS">&hellip;</div>
            <div title="HYPHENATION POINT">&#8231;</div>
            <!--<div>&#8232;</div>
            <div>&#8233;</div>
            <div>&#8234;</div>
            <div>&#8235;</div>
            <div>&#8236;</div>
            <div>&#8237;</div>
            <div>&#8238;</div>
            <div>&#8239;</div>-->
            <div title="PER MILLE SIGN">&permil;</div>
            <div title="PER TEN THOUSAND SIGN">&#8241;</div>
            <div title="PRIME">&prime;</div>
            <div title="DOUBLE PRIME">&Prime;</div>
            <div title="TRIPLE PRIME">&#8244;</div>
            <div title="REVERSED PRIME">&#8245;</div>
            <div title="REVERSED DOUBLE PRIME">&#8246;</div>
            <div title="REVERSED TRIPLE PRIME">&#8247;</div>
            <div title="CARET">&#8248;</div>
            <div title="SINGLE LEFT-POINTING ANGLE QUOTATION MARK">&lsaquo;</div>
            <div title="SINGLE RIGHT-POINTING ANGLE QUOTATION MARK">&rsaquo;</div>
            <div title="REFERENCE MARK">&#8251;</div>
            <div title="DOUBLE EXCLAMATION MARK">&#8252;</div>
            <div title="INTERROBANG">&#8253;</div>
            <div title="OVERLINE">&oline;</div>
            <div title="UNDERTIE">&#8255;</div>
            <div title="CHARACTER TIE">&#8256;</div>
            <div title="CARET INSERTION POINT">&#8257;</div>
            <div title="ASTERISM">&#8258;</div>
            <div title="HYPHEN BULLET">&#8259;</div>
            <div title="FRACTION SLASH">&frasl;</div>
            <div title="LEFT SQUARE BRACKET WITH QUILL">&#8261;</div>
            <div title="RIGHT SQUARE BRACKET WITH QUILL">&#8262;</div>
            <div title="DOUBLE QUESTION MARK">&#8263;</div>
            <div title="QUESTION EXCLAMATION MARK">&#8264;</div>
            <div title="EXCLAMATION QUESTION MARK">&#8265;</div>
            <div title="TIRONIAN SIGN ET">&#8266;</div>
            <div title="REVERSED PILCROW SIGN">&#8267;</div>
            <div title="BLACK LEFTWARDS BULLET">&#8268;</div>
            <div title="BLACK RIGHTWARDS BULLET">&#8269;</div>
            <div title="LOW ASTERISK">&#8270;</div>
            <div title="REVERSED SEMICOLON">&#8271;</div>
            <div title="CLOSE UP">&#8272;</div>
            <div title="TWO ASTERISKS ALIGNED VERTICALLY">&#8273;</div>
            <div title="COMMERCIAL MINUS SIGN">&#8274;</div>
            <div title="SWUNG DASH">&#8275;</div>
            <div title="INVERTED UNDERTIE">&#8276;</div>
            <div title="FLOWER PUNCTUATION MARK">&#8277;</div>
            <div title="THREE DOT PUNCTUATION">&#8278;</div>
            <div title="QUADRUPLE PRIME">&#8279;</div>
            <div title="FOUR DOT PUNCTUATION">&#8280;</div>
            <div title="FIVE DOT PUNCTUATION">&#8281;</div>
            <div title="TWO DOT PUNCTUATION">&#8282;</div>
            <div title="FOUR DOT MARK">&#8283;</div>
            <div title="DOTTED CROSS">&#8284;</div>
            <div title="TRICOLON">&#8285;</div>
            <div title="VERTICAL FOUR DOTS">&#8286;</div>
            <!--<div>&#8287;</div>
            <div>&#8288;</div>
            <div>&#8289;</div>
            <div>&#8290;</div>
            <div>&#8291;</div>
            <div>&#8292;</div>
            <div>&#8294;</div>
            <div>&#8295;</div>
            <div>&#8296;</div>
            <div>&#8297;</div>
            <div>&#8298;</div>
            <div>&#8299;</div>
            <div>&#8300;</div>
            <div>&#8301;</div>
            <div>&#8302;</div>
            <div>&#8303;</div>-->
        </div>
        
        <div id="divGeometricShapes" class="tab-content container clearfix">
            
            <!-- Geometric Shapes https://www.w3schools.com/charsets/ref_utf_geometric.asp -->
            <div title="BLACK SQUARE">&#9632;</div>
            <div title="WHITE SQUARE">&#9633;</div>
            <div title="WHITE SQUARE WITH ROUNDED CORNERS">&#9634;</div>
            <div title="WHITE SQUARE CONTAINING BLACK SMALL SQUARE">&#9635;</div>
            <div title="SQUARE WITH HORIZONTAL FILL">&#9636;</div>
            <div title="SQUARE WITH VERTICAL FILL">&#9637;</div>
            <div title="SQUARE WITH ORTHOGONAL CROSSHATCH FILL">&#9638;</div>
            <div title="SQUARE WITH UPPER LEFT TO LOWER RIGHT FILL">&#9639;</div>
            <div title="SQUARE WITH UPPER RIGHT TO LOWER LEFT FILL">&#9640;</div>
            <div title="SQUARE WITH DIAGONAL CROSSHATCH FILL">&#9641;</div>
            <div title="BLACK SMALL SQUARE">&#9642;</div>
            <div title="WHITE SMALL SQUARE">&#9643;</div>
            <div title="BLACK RECTANGLE">&#9644;</div>
            <div title="WHITE RECTANGLE">&#9645;</div>
            <div title="BLACK VERTICAL RECTANGLE">&#9646;</div>
            <div title="WHITE VERTICAL RECTANGLE">&#9647;</div>
            <div title="BLACK PARALLELOGRAM">&#9648;</div>
            <div title="WHITE PARALLELOGRAM">&#9649;</div>
            <div title="BLACK UP-POINTING TRIANGLE">&#9650;</div>
            <div title="WHITE UP-POINTING TRIANGLE">&#9651;</div>
            <div title="BLACK UP-POINTING SMALL TRIANGLE">&#9652;</div>
            <div title="WHITE UP-POINTING SMALL TRIANGLE">&#9653;</div>
            <div title="BLACK RIGHT-POINTING TRIANGLE">&#9654;</div>
            <div title="WHITE RIGHT-POINTING TRIANGLE">&#9655;</div>
            <div title="BLACK RIGHT-POINTING SMALL TRIANGLE">&#9656;</div>
            <div title="WHITE RIGHT-POINTING SMALL TRIANGLE">&#9657;</div>
            <div title="BLACK RIGHT-POINTING POINTER">&#9658;</div>
            <div title="WHITE RIGHT-POINTING POINTER">&#9659;</div>
            <div title="BLACK DOWN-POINTING TRIANGLE">&#9660;</div>
            <div title="WHITE DOWN-POINTING TRIANGLE">&#9661;</div>
            <div title="BLACK DOWN-POINTING SMALL TRIANGLE">&#9662;</div>
            <div title="WHITE DOWN-POINTING SMALL TRIANGLE">&#9663;</div>
            <div title="BLACK LEFT-POINTING TRIANGLE">&#9664;</div>
            <div title="WHITE LEFT-POINTING TRIANGLE">&#9665;</div>
            <div title="BLACK LEFT-POINTING SMALL TRIANGLE">&#9666;</div>
            <div title="WHITE LEFT-POINTING SMALL TRIANGLE">&#9667;</div>
            <div title="BLACK LEFT-POINTING POINTER">&#9668;</div>
            <div title="WHITE LEFT-POINTING POINTER">&#9669;</div>
            <div title="BLACK DIAMOND">&#9670;</div>
            <div title="WHITE DIAMOND">&#9671;</div>
            <div title="WHITE DIAMOND CONTAINING BLACK SMALL DIAMOND">&#9672;</div>
            <div title="FISHEYE">&#9673;</div>
            <div title="LOZENGE">&loz;</div>
            <div title="WHITE CIRCLE">&#9675;</div>
            <div title="DOTTED CIRCLE">&#9676;</div>
            <div title="CIRCLE WITH VERTICAL FILL">&#9677;</div>
            <div title="BULLSEYE">&#9678;</div>
            <div title="BLACK CIRCLE">&#9679;</div>
            <div title="CIRCLE WITH LEFT HALF BLACK">&#9680;</div>
            <div title="CIRCLE WITH RIGHT HALF BLACK">&#9681;</div>
            <div title="CIRCLE WITH LOWER HALF BLACK">&#9682;</div>
            <div title="CIRCLE WITH UPPER HALF BLACK">&#9683;</div>
            <div title="CIRCLE WITH UPPER RIGHT QUADRANT BLACK">&#9684;</div>
            <div title="CIRCLE WITH ALL BUT UPPER LEFT QUADRANT BLACK">&#9685;</div>
            <div title="LEFT HALF BLACK CIRCLE">&#9686;</div>
            <div title="RIGHT HALF BLACK CIRCLE">&#9687;</div>
            <div title="INVERSE BULLET">&#9688;</div>
            <div title="INVERSE WHITE CIRCLE">&#9689;</div>
            <div title="UPPER HALF INVERSE WHITE CIRCLE">&#9690;</div>
            <div title="LOWER HALF INVERSE WHITE CIRCLE">&#9691;</div>
            <div title="UPPER LEFT QUADRANT CIRCULAR ARC">&#9692;</div>
            <div title="UPPER RIGHT QUADRANT CIRCULAR ARC">&#9693;</div>
            <div title="LOWER RIGHT QUADRANT CIRCULAR ARC">&#9694;</div>
            <div title="LOWER LEFT QUADRANT CIRCULAR ARC">&#9695;</div>
            <div title="UPPER HALF CIRCLE">&#9696;</div>
            <div title="LOWER HALF CIRCLE">&#9697;</div>
            <div title="BLACK LOWER RIGHT TRIANGLE">&#9698;</div>
            <div title="BLACK LOWER LEFT TRIANGLE">&#9699;</div>
            <div title="BLACK UPPER LEFT TRIANGLE">&#9700;</div>
            <div title="BLACK UPPER RIGHT TRIANGLE">&#9701;</div>
            <div title="WHITE BULLET">&#9702;</div>
            <div title="SQUARE WITH LEFT HALF BLACK">&#9703;</div>
            <div title="SQUARE WITH RIGHT HALF BLACK">&#9704;</div>
            <div title="SQUARE WITH UPPER LEFT DIAGONAL HALF BLACK">&#9705;</div>
            <div title="SQUARE WITH LOWER RIGHT DIAGONAL HALF BLACK">&#9706;</div>
            <div title="WHITE SQUARE WITH VERTICAL BISECTING LINE">&#9707;</div>
            <div title="WHITE UP-POINTING TRIANGLE WITH DOT">&#9708;</div>
            <div title="UP-POINTING TRIANGLE WITH LEFT HALF BLACK">&#9709;</div>
            <div title="UP-POINTING TRIANGLE WITH RIGHT HALF BLACK">&#9710;</div>
            <div title="LARGE CIRCLE">&#9711;</div>
            <div title="WHITE SQUARE WITH UPPER LEFT QUADRANT">&#9712;</div>
            <div title="WHITE SQUARE WITH LOWER LEFT QUADRANT">&#9713;</div>
            <div title="WHITE SQUARE WITH LOWER RIGHT QUADRANT">&#9714;</div>
            <div title="WHITE SQUARE WITH UPPER RIGHT QUADRANT">&#9715;</div>
            <div title="WHITE CIRCLE WITH UPPER LEFT QUADRANT">&#9716;</div>
            <div title="WHITE CIRCLE WITH LOWER LEFT QUADRANT">&#9717;</div>
            <div title="WHITE CIRCLE WITH LOWER RIGHT QUADRANT">&#9718;</div>
            <div title="WHITE CIRCLE WITH UPPER RIGHT QUADRANT">&#9719;</div>
            <div title="UPPER LEFT TRIANGLE">&#9720;</div>
            <div title="UPPER RIGHT TRIANGLE">&#9721;</div>
            <div title="LOWER LEFT TRIANGLE">&#9722;</div>
            <div title="WHITE MEDIUM SQUARE">&#9723;</div>
            <div title="BLACK MEDIUM SQUARE">&#9724;</div>
            <div title="WHITE MEDIUM SMALL SQUARE">&#9725;</div>
            <div title="BLACK MEDIUM SMALL SQUARE">&#9726;</div>
            <div title="LOWER RIGHT TRIANGLE">&#9727;</div>
        </div>
        
        <div id="divLetterlikeSymbols" class="tab-content container clearfix">
        
            <!-- Letterlike Symbols: https://www.w3schools.com/charsets/ref_utf_letterlike.asp -->
            <div title="ACCOUNT OF">&#8448;</div>
            <div title="ADDRESSED TO THE SUBJECT">&#8449;</div>
            <div title="DOUBLE-STRUCK CAPITAL C">&#8450;</div>
            <div title="DEGREE CELSIUS">&#8451;</div>
            <div title="CENTRE LINE SYMBOL">&#8452;</div>
            <div title="CARE OF">&#8453;</div>
            <div title="CADA UNA">&#8454;</div>
            <div title="EULER CONSTANT">&#8455;</div>
            <div title="SCRUPLE">&#8456;</div>
            <div title="DEGREE FAHRENHEIT">&#8457;</div>
            <div title="SCRIPT SMALL G">&#8458;</div>
            <div title="SCRIPT CAPITAL H">&#8459;</div>
            <div title="BLACK-LETTER CAPITAL H">&#8460;</div>
            <div title="DOUBLE-STRUCK CAPITAL H">&#8461;</div>
            <div title="PLANCK CONSTANT">&#8462;</div>
            <div title="PLANCK CONSTANT OVER TWO PI">&#8463;</div>
            <div title="SCRIPT CAPITAL I">&#8464;</div>
            <div title="BLACK-LETTER CAPITAL I">&image;</div>
            <div title="SCRIPT CAPITAL L">&#8466;</div>
            <div title="SCRIPT SMALL L">&#8467;</div>
            <div title="L B BAR SYMBOL">&#8468;</div>
            <div title="DOUBLE-STRUCK CAPITAL N">&#8469;</div>
            <div title="NUMERO SIGN">&#8470;</div>
            <div title="SOUND RECORDING COPYRIGHT">&#8471;</div>
            <div title="SCRIPT CAPITAL P">&weierp;</div>
            <div title="DOUBLE-STRUCK CAPITAL P">&#8473;</div>
            <div title="DOUBLE-STRUCK CAPITAL Q">&#8474;</div>
            <div title="SCRIPT CAPITAL R">&#8475;</div>
            <div title="BLACK-LETTER CAPITAL R">&real;</div>
            <div title="DOUBLE-STRUCK CAPITAL R">&#8477;</div>
            <div title="PRESCRIPTION TAKE">&#8478;</div>
            <div title="RESPONSE">&#8479;</div>
            <div title="SERVICE MARK">&#8480;</div>
            <div title="TELEPHONE SIGN">&#8481;</div>
            <div title="TRADE MARK SIGN">&trade;</div>
            <div title="VERSICLE">&#8483;</div>
            <div title="DOUBLE-STRUCK CAPITAL Z">&#8484;</div>
            <div title="OUNCE SIGN">&#8485;</div>
            <div title="OHM SIGN">&ohm;</div>
            <div title="INVERTED OHM SIGN">&mho;</div>
            <div title="BLACK-LETTER CAPITAL Z">&#8488;</div>
            <div title="TURNED GREEK SMALL LETTER IOTA">&#8489;</div>
            <div title="KELVIN SIGN">&#8490;</div>
            <div title="ANGSTROM SIGN">&#8491;</div>
            <div title="SCRIPT CAPITAL B">&#8492;</div>
            <div title="BLACK-LETTER CAPITAL C">&#8493;</div>
            <div title="ESTIMATED SYMBOL">&#8494;</div>
            <div title="SCRIPT SMALL E">&#8495;</div>
            <div title="SCRIPT CAPITAL E">&#8496;</div>
            <div title="SCRIPT CAPITAL F">&#8497;</div>
            <div title="TURNED CAPITAL F">&#8498;</div>
            <div title="SCRIPT CAPITAL M">&#8499;</div>
            <div title="SCRIPT SMALL O">&#8500;</div>
            <div title="ALEF SYMBOL">&alefsym;</div>
            <div title="BET SYMBOL">&#8502;</div>
            <div title="GIMEL SYMBOL">&#8503;</div>
            <div title="DALET SYMBOL">&#8504;</div>
            <div title="INFORMATION SOURCE">&#8505;</div>
            <div title="ROTATED CAPITAL Q">&#8506;</div>
            <div title="FACSIMILE SIGN">&#8507;</div>
            <div title="DOUBLE-STRUCK SMALL PI">&#8508;</div>
            <div title="DOUBLE-STRUCK SMALL GAMMA">&#8509;</div>
            <div title="DOUBLE-STRUCK CAPITAL GAMMA">&#8510;</div>
            <div title="DOUBLE-STRUCK CAPITAL PI">&#8511;</div>
            <div title="DOUBLE-STRUCK N-ARY SUMMATION">&#8512;</div>
            <div title="TURNED SANS-SERIF CAPITAL G">&#8513;</div>
            <div title="TURNED SANS-SERIF CAPITAL L">&#8514;</div>
            <div title="REVERSED SANS-SERIF CAPITAL L">&#8515;</div>
            <div title="TURNED SANS-SERIF CAPITAL Y">&#8516;</div>
            <div title="DOUBLE-STRUCK ITALIC CAPITAL D">&#8517;</div>
            <div title="DOUBLE-STRUCK ITALIC SMALL D">&#8518;</div>
            <div title="DOUBLE-STRUCK ITALIC SMALL E">&#8519;</div>
            <div title="DOUBLE-STRUCK ITALIC SMALL I">&#8520;</div>
            <div title="DOUBLE-STRUCK ITALIC SMALL J">&#8521;</div>
            <div title="PROPERTY LINE">&#8522;</div>
            <div title="TURNED AMPERSAND">&#8523;</div>
            <div title="PER SIGN">&#8524;</div>
            <div title="AKTIESELSKAB">&#8525;</div>
            <div title="TURNED SMALL F">&#8526;</div>
            <div title="SYMBOL FOR SAMARITAN SOURCE">&#8527;</div>
            
        </div>
        
        <div id="divMathOperators" class="tab-content container clearfix">
        
            <!-- Math Operators https://www.w3schools.com/charsets/ref_utf_math.asp -->
            <div title="FOR ALL">&forall;</div>
            <div title="COMPLEMENT">&#8705;</div>
            <div title="PARTIAL DIFFERENTIAL">&part;</div>
            <div title="THERE EXISTS">&exist;</div>
            <div title="THERE DOES NOT EXIST">&#8708;</div>
            <div title="EMPTY SET">&empty;</div>
            <div title="INCREMENT">&#8710;</div>
            <div title="NABLA">&nabla;</div>
            <div title="ELEMENT OF">&isin;</div>
            <div title="NOT AN ELEMENT OF">&notin;</div>
            <div title="SMALL ELEMENT OF">&#8714;</div>
            <div title="CONTAINS AS MEMBER">&ni;</div>
            <div title="DOES NOT CONTAIN AS MEMBER">&#8716;</div>
            <div title="SMALL CONTAINS AS MEMBER">&#8717;</div>
            <div title="END OF PROOF">&#8718;</div>
            <div title="N-ARY PRODUCT">&prod;</div>
            <div title="N-ARY COPRODUCT">&#8720;</div>
            <div title="N-ARY SUMMATION">&sum;</div>
            <div title="MINUS SIGN">&minus;</div>
            <div title="MINUS-OR-PLUS SIGN">&#8723;</div>
            <div title="DOT PLUS">&#8724;</div>
            <div title="DIVISION SLASH">&#8725;</div>
            <div title="SET MINUS">&#8726;</div>
            <div title="ASTERISK OPERATOR">&lowast;</div>
            <div title="RING OPERATOR">&#8728;</div>
            <div title="BULLET OPERATOR">&#8729;</div>
            <div title="SQUARE ROOT">&radic;</div>
            <div title="CUBE ROOT">&#8731;</div>
            <div title="FOURTH ROOT">&#8732;</div>
            <div title="PROPORTIONAL TO">&prop;</div>
            <div title="INFINITY">&infin;</div>
            <div title="RIGHT ANGLE">&#8735;</div>
            <div title="ANGLE">&ang;</div>
            <div title="MEASURED ANGLE">&#8737;</div>
            <div title="SPHERICAL ANGLE">&#8738;</div>
            <div title="DIVIDES">&#8739;</div>
            <div title="DOES NOT DIVIDE">&#8740;</div>
            <div title="PARALLEL TO">&#8741;</div>
            <div title="NOT PARALLEL TO">&#8742;</div>
            <div title="LOGICAL AND">&and;</div>
            <div title="LOGICAL OR">&or;</div>
            <div title="INTERSECTION">&cap;</div>
            <div title="UNION">&cup;</div>
            <div title="INTEGRAL">&int;</div>
            <div title="DOUBLE INTEGRAL">&#8748;</div>
            <div title="TRIPLE INTEGRAL">&#8749;</div>
            <div title="CONTOUR INTEGRAL">&#8750;</div>
            <div title="SURFACE INTEGRAL">&#8751;</div>
            <div title="VOLUME INTEGRAL">&#8752;</div>
            <div title="CLOCKWISE INTEGRAL">&#8753;</div>
            <div title="CLOCKWISE CONTOUR INTEGRAL">&#8754;</div>
            <div title="ANTICLOCKWISE CONTOUR INTEGRAL">&#8755;</div>
            <div title="THEREFORE">&there4;</div>
            <div title="BECAUSE">&#8757;</div>
            <div title="RATIO">&#8758;</div>
            <div title="PROPORTION">&#8759;</div>
            <div title="DOT MINUS">&#8760;</div>
            <div title="EXCESS">&#8761;</div>
            <div title="GEOMETRIC PROPORTION">&#8762;</div>
            <div title="HOMOTHETIC">&#8763;</div>
            <div title="TILDE OPERATOR">&sim;</div>
            <div title="REVERSED TILDE">&#8765;</div>
            <div title="INVERTED LAZY S">&#8766;</div>
            <div title="SINE WAVE">&#8767;</div>
            <div title="WREATH PRODUCT">&#8768;</div>
            <div title="NOT TILDE">&#8769;</div>
            <div title="MINUS TILDE">&#8770;</div>
            <div title="ASYMPTOTICALLY EQUAL TO">&#8771;</div>
            <div title="NOT ASYMPTOTICALLY EQUAL TO">&#8772;</div>
            <div title="APPROXIMATELY EQUAL TO">&cong;</div>
            <div title="APPROXIMATELY BUT NOT ACTUALLY EQUAL TO">&#8774;</div>
            <div title="NEITHER APPROXIMATELY NOR ACTUALLY EQUAL TO">&#8775;</div>
            <div title="ALMOST EQUAL TO">&asymp;</div>
            <div title="NOT ALMOST EQUAL TO">&#8777;</div>
            <div title="ALMOST EQUAL OR EQUAL TO">&#8778;</div>
            <div title="TRIPLE TILDE">&#8779;</div>
            <div title="ALL EQUAL TO">&#8780;</div>
            <div title="EQUIVALENT TO">&#8781;</div>
            <div title="GEOMETRICALLY EQUIVALENT TO">&#8782;</div>
            <div title="DIFFERENCE BETWEEN">&#8783;</div>
            <div title="APPROACHES THE LIMIT">&#8784;</div>
            <div title="GEOMETRICALLY EQUAL TO">&#8785;</div>
            <div title="APPROXIMATELY EQUAL TO OR THE IMAGE OF">&#8786;</div>
            <div title="IMAGE OF OR APPROXIMATELY EQUAL TO">&#8787;</div>
            <div title="COLON EQUALS">&#8788;</div>
            <div title="EQUALS COLON">&#8789;</div>
            <div title="RING IN EQUAL TO">&#8790;</div>
            <div title="RING EQUAL TO">&#8791;</div>
            <div title="CORRESPONDS TO">&#8792;</div>
            <div title="ESTIMATES">&#8793;</div>
            <div title="EQUIANGULAR TO">&#8794;</div>
            <div title="STAR EQUALS">&#8795;</div>
            <div title="DELTA EQUAL TO">&#8796;</div>
            <div title="EQUAL TO BY DEFINITION">&#8797;</div>
            <div title="MEASURED BY">&#8798;</div>
            <div title="QUESTIONED EQUAL TO">&#8799;</div>
            <div title="NOT EQUAL TO">&ne;</div>
            <div title="IDENTICAL TO">&equiv;</div>
            <div title="NOT IDENTICAL TO">&#8802;</div>
            <div title="STRICTLY EQUIVALENT TO">&#8803;</div>
            <div title="LESS-THAN OR EQUAL TO">&le;</div>
            <div title="GREATER-THAN OR EQUAL TO">&ge;</div>
            <div title="LESS-THAN OVER EQUAL TO">&#8806;</div>
            <div title="GREATER-THAN OVER EQUAL TO">&#8807;</div>
            <div title="LESS-THAN BUT NOT EQUAL TO">&#8808;</div>
            <div title="GREATER-THAN BUT NOT EQUAL TO">&#8809;</div>
            <div title="MUCH LESS-THAN">&#8810;</div>
            <div title="MUCH GREATER-THAN">&#8811;</div>
            <div title="BETWEEN">&#8812;</div>
            <div title="NOT EQUIVALENT TO">&#8813;</div>
            <div title="NOT LESS-THAN">&#8814;</div>
            <div title="NOT GREATER-THAN">&#8815;</div>
            <div title="NEITHER LESS-THAN NOR EQUAL TO">&#8816;</div>
            <div title="NEITHER GREATER-THAN NOR EQUAL TO">&#8817;</div>
            <div title="LESS-THAN OR EQUIVALENT TO">&#8818;</div>
            <div title="GREATER-THAN OR EQUIVALENT TO">&#8819;</div>
            <div title="NEITHER LESS-THAN NOR EQUIVALENT TO">&#8820;</div>
            <div title="NEITHER GREATER-THAN NOR EQUIVALENT TO">&#8821;</div>
            <div title="LESS-THAN OR GREATER-THAN">&#8822;</div>
            <div title="GREATER-THAN OR LESS-THAN">&#8823;</div>
            <div title="NEITHER LESS-THAN NOR GREATER-THAN">&#8824;</div>
            <div title="NEITHER GREATER-THAN NOR LESS-THAN">&#8825;</div>
            <div title="PRECEDES">&#8826;</div>
            <div title="SUCCEEDS">&#8827;</div>
            <div title="PRECEDES OR EQUAL TO">&#8828;</div>
            <div title="SUCCEEDS OR EQUAL TO">&#8829;</div>
            <div title="PRECEDES OR EQUIVALENT TO">&#8830;</div>
            <div title="SUCCEEDS OR EQUIVALENT TO">&#8831;</div>
            <div title="DOES NOT PRECEDE">&#8832;</div>
            <div title="DOES NOT SUCCEED">&#8833;</div>
            <div title="SUBSET OF">&sub;</div>
            <div title="SUPERSET OF">&sup;</div>
            <div title="NOT A SUBSET OF">&nsub;</div>
            <div title="NOT A SUPERSET OF">&#8837;</div>
            <div title="SUBSET OF OR EQUAL TO">&sube;</div>
            <div title="SUPERSET OF OR EQUAL TO">&supe;</div>
            <div title="NEITHER A SUBSET OF NOR EQUAL TO">&#8840;</div>
            <div title="NEITHER A SUPERSET OF NOR EQUAL TO">&#8841;</div>
            <div title="SUBSET OF WITH NOT EQUAL TO">&#8842;</div>
            <div title="SUPERSET OF WITH NOT EQUAL TO">&#8843;</div>
            <div title="MULTISET">&#8844;</div>
            <div title="MULTISET MULTIPLICATION">&#8845;</div>
            <div title="MULTISET UNION">&#8846;</div>
            <div title="SQUARE IMAGE OF">&#8847;</div>
            <div title="SQUARE ORIGINAL OF">&#8848;</div>
            <div title="SQUARE IMAGE OF OR EQUAL TO">&#8849;</div>
            <div title="SQUARE ORIGINAL OF OR EQUAL TO">&#8850;</div>
            <div title="SQUARE CAP">&#8851;</div>
            <div title="SQUARE CUP">&#8852;</div>
            <div title="CIRCLED PLUS">&oplus;</div>
            <div title="CIRCLED MINUS">&#8854;</div>
            <div title="CIRCLED TIMES">&otimes;</div>
            <div title="CIRCLED DIVISION SLASH">&#8856;</div>
            <div title="CIRCLED DOT OPERATOR">&#8857;</div>
            <div title="CIRCLED RING OPERATOR">&#8858;</div>
            <div title="CIRCLED ASTERISK OPERATOR">&#8859;</div>
            <div title="CIRCLED EQUALS">&#8860;</div>
            <div title="CIRCLED DASH">&#8861;</div>
            <div title="SQUARED PLUS">&#8862;</div>
            <div title="SQUARED MINUS">&#8863;</div>
            <div title="SQUARED TIMES">&#8864;</div>
            <div title="SQUARED DOT OPERATOR">&#8865;</div>
            <div title="RIGHT TACK">&#8866;</div>
            <div title="LEFT TACK">&#8867;</div>
            <div title="DOWN TACK">&#8868;</div>
            <div title="UP TACK">&perp;</div>
            <div title="ASSERTION">&#8870;</div>
            <div title="MODELS">&#8871;</div>
            <div title="TRUE">&#8872;</div>
            <div title="FORCES">&#8873;</div>
            <div title="TRIPLE VERTICAL BAR RIGHT TURNSTILE">&#8874;</div>
            <div title="DOUBLE VERTICAL BAR DOUBLE RIGHT TURNSTILE">&#8875;</div>
            <div title="DOES NOT PROVE">&#8876;</div>
            <div title="NOT TRUE">&#8877;</div>
            <div title="DOES NOT FORCE">&#8878;</div>
            <div title="NEGATED DOUBLE VERTICAL BAR DOUBLE RIGHT TURNSTILE">&#8879;</div>
            <div title="PRECEDES UNDER RELATION">&#8880;</div>
            <div title="SUCCEEDS UNDER RELATION">&#8881;</div>
            <div title="NORMAL SUBGROUP OF">&#8882;</div>
            <div title="CONTAINS AS NORMAL SUBGROUP">&#8883;</div>
            <div title="NORMAL SUBGROUP OF OR EQUAL TO">&#8884;</div>
            <div title="CONTAINS AS NORMAL SUBGROUP OR EQUAL TO">&#8885;</div>
            <div title="ORIGINAL OF">&#8886;</div>
            <div title="IMAGE OF">&#8887;</div>
            <div title="MULTIMAP">&#8888;</div>
            <div title="HERMITIAN CONJUGATE MATRIX">&#8889;</div>
            <div title="INTERCALATE">&#8890;</div>
            <div title="XOR">&#8891;</div>
            <div title="NAND">&#8892;</div>
            <div title="NOR">&#8893;</div>
            <div title="RIGHT ANGLE WITH ARC">&#8894;</div>
            <div title="RIGHT TRIANGLE">&#8895;</div>
            <div title="N-ARY LOGICAL AND">&#8896;</div>
            <div title="N-ARY LOGICAL OR">&#8897;</div>
            <div title="N-ARY INTERSECTION">&#8898;</div>
            <div title="N-ARY UNION">&#8899;</div>
            <div title="DIAMOND OPERATOR">&#8900;</div>
            <div title="DOT OPERATOR">&sdot;</div>
            <div title="STAR OPERATOR">&#8902;</div>
            <div title="DIVISION TIMES">&#8903;</div>
            <div title="BOWTIE">&#8904;</div>
            <div title="LEFT NORMAL FACTOR SEMIDIRECT PRODUCT">&#8905;</div>
            <div title="RIGHT NORMAL FACTOR SEMIDIRECT PRODUCT">&#8906;</div>
            <div title="LEFT SEMIDIRECT PRODUCT">&#8907;</div>
            <div title="RIGHT SEMIDIRECT PRODUCT">&#8908;</div>
            <div title="REVERSED TILDE EQUALS">&#8909;</div>
            <div title="CURLY LOGICAL OR">&#8910;</div>
            <div title="CURLY LOGICAL AND">&#8911;</div>
            <div title="DOUBLE SUBSET">&#8912;</div>
            <div title="DOUBLE SUPERSET">&#8913;</div>
            <div title="DOUBLE INTERSECTION">&#8914;</div>
            <div title="DOUBLE UNION">&#8915;</div>
            <div title="PITCHFORK">&#8916;</div>
            <div title="EQUAL AND PARALLEL TO">&#8917;</div>
            <div title="LESS-THAN WITH DOT">&#8918;</div>
            <div title="GREATER-THAN WITH DOT">&#8919;</div>
            <div title="VERY MUCH LESS-THAN">&#8920;</div>
            <div title="VERY MUCH GREATER-THAN">&#8921;</div>
            <div title="LESS-THAN EQUAL TO OR GREATER-THAN">&#8922;</div>
            <div title="GREATER-THAN EQUAL TO OR LESS-THAN">&#8923;</div>
            <div title="EQUAL TO OR LESS-THAN">&#8924;</div>
            <div title="EQUAL TO OR GREATER-THAN">&#8925;</div>
            <div title="EQUAL TO OR PRECEDES">&#8926;</div>
            <div title="EQUAL TO OR SUCCEEDS">&#8927;</div>
            <div title="DOES NOT PRECEDE OR EQUAL">&#8928;</div>
            <div title="DOES NOT SUCCEED OR EQUAL">&#8929;</div>
            <div title="NOT SQUARE IMAGE OF OR EQUAL TO">&#8930;</div>
            <div title="NOT SQUARE ORIGINAL OF OR EQUAL TO">&#8931;</div>
            <div title="SQUARE IMAGE OF OR NOT EQUAL TO">&#8932;</div>
            <div title="SQUARE ORIGINAL OF OR NOT EQUAL TO">&#8933;</div>
            <div title="LESS-THAN BUT NOT EQUIVALENT TO">&#8934;</div>
            <div title="GREATER-THAN BUT NOT EQUIVALENT TO">&#8935;</div>
            <div title="PRECEDES BUT NOT EQUIVALENT TO">&#8936;</div>
            <div title="SUCCEEDS BUT NOT EQUIVALENT TO">&#8937;</div>
            <div title="NOT NORMAL SUBGROUP OF">&#8938;</div>
            <div title="DOES NOT CONTAIN AS NORMAL SUBGROUP">&#8939;</div>
            <div title="NOT NORMAL SUBGROUP OF OR EQUAL TO">&#8940;</div>
            <div title="DOES NOT CONTAIN AS NORMAL SUBGROUP OR EQUAL">&#8941;</div>
            <div title="VERTICAL ELLIPSIS">&#8942;</div>
            <div title="MIDLINE HORIZONTAL ELLIPSIS">&#8943;</div>
            <div title="UP RIGHT DIAGONAL ELLIPSIS">&#8944;</div>
            <div title="DOWN RIGHT DIAGONAL ELLIPSIS">&#8945;</div>
            <div title="ELEMENT OF WITH LONG HORIZONTAL STROKE">&#8946;</div>
            <div title="ELEMENT OF WITH VERTICAL BAR AT END OF HORIZONTAL STROKE">&#8947;</div>
            <div title="SMALL ELEMENT OF WITH VERTICAL BAR AT END OF HORIZONTAL STROKE">&#8948;</div>
            <div title="ELEMENT OF WITH DOT ABOVE">&#8949;</div>
            <div title="ELEMENT OF WITH OVERBAR">&#8950;</div>
            <div title="SMALL ELEMENT OF WITH OVERBAR">&#8951;</div>
            <div title="ELEMENT OF WITH UNDERBAR">&#8952;</div>
            <div title="ELEMENT OF WITH TWO HORIZONTAL STROKES">&#8953;</div>
            <div title="CONTAINS WITH LONG HORIZONTAL STROKE">&#8954;</div>
            <div title="CONTAINS WITH VERTICAL BAR AT END OF HORIZONTAL STROKE">&#8955;</div>
            <div title="SMALL CONTAINS WITH VERTICAL BAR AT END OF HORIZONTAL STROKE">&#8956;</div>
            <div title="CONTAINS WITH OVERBAR">&#8957;</div>
            <div title="SMALL CONTAINS WITH OVERBAR">&#8958;</div>
            <div title="Z NOTATION BAG MEMBERSHIP">&#8959;</div>
        </div>
        
        <div id="divMiscSymbols" class="tab-content container clearfix">
        
            <!-- Misc Symbols https://www.w3schools.com/charsets/ref_utf_symbols.asp -->
            <div title="BLACK SUN WITH RAYS">&#9728;</div>
            <div title="CLOUD">&#9729;</div>
            <div title="UMBRELLA">&#9730;</div>
            <div title="SNOWMAN">&#9731;</div>
            <div title="COMET">&#9732;</div>
            <div title="BLACK STAR">&#9733;</div>
            <div title="WHITE STAR">&#9734;</div>
            <div title="LIGHTNING">&#9735;</div>
            <div title="THUNDERSTORM">&#9736;</div>
            <div title="SUN">&#9737;</div>
            <div title="ASCENDING NODE">&#9738;</div>
            <div title="DESCENDING NODE">&#9739;</div>
            <div title="CONJUNCTION">&#9740;</div>
            <div title="OPPOSITION">&#9741;</div>
            <div title="BLACK TELEPHONE">&#9742;</div>
            <div title="WHITE TELEPHONE">&#9743;</div>
            <div title="BALLOT BOX">&#9744;</div>
            <div title="BALLOT BOX WITH CHECK">&#9745;</div>
            <div title="BALLOT BOX WITH X">&#9746;</div>
            <div title="SALTIRE">&#9747;</div>
            <div title="UMBRELLA WITH RAIN DROPS">&#9748;</div>
            <div title="HOT BEVERAGE">&#9749;</div>
            <div title="WHITE SHOGI PIECE">&#9750;</div>
            <div title="BLACK SHOGI PIECE">&#9751;</div>
            <div title="SHAMROCK">&#9752;</div>
            <div title="REVERSED ROTATED FLORAL HEART BULLET">&#9753;</div>
            <div title="BLACK LEFT POINTING INDEX">&#9754;</div>
            <div title="BLACK RIGHT POINTING INDEX">&#9755;</div>
            <div title="WHITE LEFT POINTING INDEX">&#9756;</div>
            <div title="WHITE UP POINTING INDEX">&#9757;</div>
            <div title="WHITE RIGHT POINTING INDEX">&#9758;</div>
            <div title="WHITE DOWN POINTING INDEX">&#9759;</div>
            <div title="SKULL AND CROSSBONES">&#9760;</div>
            <div title="CAUTION SIGN">&#9761;</div>
            <div title="RADIOACTIVE SIGN">&#9762;</div>
            <div title="BIOHAZARD SIGN">&#9763;</div>
            <div title="WHITE SUN WITH RAYS">&#9788;</div>
            <div title="FIRST QUARTER MOON">&#9789;</div>
            <div title="LAST QUARTER MOON">&#9790;</div>
            <div title="MERCURY">&#9791;</div>
            <div title="FEMALE SIGN">&#9792;</div>
            <div title="EARTH">&#9793;</div>
            <div title="MALE SIGN">&#9794;</div>
            <div title="JUPITER">&#9795;</div>
            <div title="SATURN">&#9796;</div>
            <div title="URANUS">&#9797;</div>
            <div title="NEPTUNE">&#9798;</div>
            <div title="PLUTO">&#9799;</div>
            <div title="ARIES">&#9800;</div>
            <div title="TAURUS">&#9801;</div>
            <div title="GEMINI">&#9802;</div>
            <div title="CANCER">&#9803;</div>
            <div title="LEO">&#9804;</div>
            <div title="VIRGO">&#9805;</div>
            <div title="LIBRA">&#9806;</div>
            <div title="SCORPIUS">&#9807;</div>
            <div title="SAGITTARIUS">&#9808;</div>
            <div title="CAPRICORN">&#9809;</div>
            <div title="AQUARIUS">&#9810;</div>
            <div title="PISCES">&#9811;</div>
            <div title="WHITE CHESS KING">&#9812;</div>
            <div title="WHITE CHESS QUEEN">&#9813;</div>
            <div title="WHITE CHESS ROOK">&#9814;</div>
            <div title="WHITE CHESS BISHOP">&#9815;</div>
            <div title="WHITE CHESS KNIGHT">&#9816;</div>
            <div title="WHITE CHESS PAWN">&#9817;</div>
            <div title="BLACK CHESS KING">&#9818;</div>
            <div title="BLACK CHESS QUEEN">&#9819;</div>
            <div title="BLACK CHESS ROOK">&#9820;</div>
            <div title="BLACK CHESS BISHOP">&#9821;</div>
            <div title="BLACK CHESS KNIGHT">&#9822;</div>
            <div title="BLACK CHESS PAWN">&#9823;</div>
            <div title="BLACK SPADE SUIT">&spades;</div>
            <div title="WHITE HEART SUIT">&#9825;</div>
            <div title="WHITE DIAMOND SUIT">&#9826;</div>
            <div title="BLACK CLUB SUIT">&clubs;</div>
            <div title="WHITE SPADE SUIT">&#9828;</div>
            <div title="BLACK HEART SUIT">&hearts;</div>
            <div title="BLACK DIAMOND SUIT">&diams;</div>
            <div title="WHITE CLUB SUIT">&#9831;</div>
            <div title="HOT SPRINGS">&#9832;</div>
            <div title="QUARTER NOTE">&#9833;</div>
            <div title="EIGHTH NOTE">&#9834;</div>
            <div title="BEAMED EIGHTH NOTES">&#9835;</div>
            <div title="BEAMED SIXTEENTH NOTES">&#9836;</div>
            <div title="MUSIC FLAT SIGN">&#9837;</div>
            <div title="MUSIC NATURAL SIGN">&#9838;</div>
            <div title="MUSIC SHARP SIGN">&#9839;</div>
            <div title="WEST SYRIAC CROSS">&#9840;</div>
            <div title="EAST SYRIAC CROSS">&#9841;</div>
            <div title="UNIVERSAL RECYCLING SYMBOL">&#9842;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-1 PLASTICS">&#9843;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-2 PLASTICS">&#9844;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-3 PLASTICS">&#9845;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-4 PLASTICS">&#9846;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-5 PLASTICS">&#9847;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-6 PLASTICS">&#9848;</div>
            <div title="RECYCLING SYMBOL FOR TYPE-7 PLASTICS">&#9849;</div>
            <div title="RECYCLING SYMBOL FOR GENERIC MATERIALS">&#9850;</div>
            <div title="BLACK UNIVERSAL RECYCLING SYMBOL">&#9851;</div>
            <div title="RECYCLED PAPER SYMBOL">&#9852;</div>
            <div title="PARTIALLY-RECYCLED PAPER SYMBOL">&#9853;</div>
            <div title="PERMANENT PAPER SIGN">&#9854;</div>
            <div title="WHEELCHAIR SYMBOL">&#9855;</div>
            <div title="DIE FACE-1">&#9856;</div>
            <div title="DIE FACE-2">&#9857;</div>
            <div title="DIE FACE-3">&#9858;</div>
            <div title="DIE FACE-4">&#9859;</div>
            <div title="DIE FACE-5">&#9860;</div>
            <div title="DIE FACE-6">&#9861;</div>
            <div title="WHITE CIRCLE WITH DOT RIGHT">&#9862;</div>
            <div title="WHITE CIRCLE WITH TWO DOTS">&#9863;</div>
            <div title="BLACK CIRCLE WITH WHITE DOT RIGHT">&#9864;</div>
            <div title="BLACK CIRCLE WITH TWO WHITE DOTS">&#9865;</div>
            <div title="MONOGRAM FOR YANG">&#9866;</div>
            <div title="MONOGRAM FOR YIN">&#9867;</div>
            <div title="DIGRAM FOR GREATER YANG">&#9868;</div>
            <div title="DIGRAM FOR LESSER YIN">&#9869;</div>
            <div title="DIGRAM FOR LESSER YANG">&#9870;</div>
            <div title="DIGRAM FOR GREATER YIN">&#9871;</div>
            <div title="WHITE FLAG">&#9872;</div>
            <div title="BLACK FLAG">&#9873;</div>
            <div title="HAMMER AND PICK">&#9874;</div>
            <div title="ANCHOR">&#9875;</div>
            <div title="CROSSED SWORDS">&#9876;</div>
            <div title="STAFF OF AESCULAPIUS">&#9877;</div>
            <div title="SCALES">&#9878;</div>
            <div title="ALEMBIC">&#9879;</div>
            <div title="FLOWER">&#9880;</div>
            <div title="GEAR">&#9881;</div>
            <div title="STAFF OF HERMES">&#9882;</div>
            <div title="ATOM SYMBOL">&#9883;</div>
            <div title="FLEUR-DE-LIS">&#9884;</div>
            <div title="OUTLINED WHITE STAR">&#9885;</div>
            <div title="THREE LINES CONVERGING RIGHT">&#9886;</div>
            <div title="THREE LINES CONVERGING LEFT">&#9887;</div>
            <div title="WARNING SIGN">&#9888;</div>
            <div title="HIGH VOLTAGE SIGN">&#9889;</div>
            <div title="DOUBLED FEMALE SIGN">&#9890;</div>
            <div title="DOUBLED MALE SIGN">&#9891;</div>
            <div title="INTERLOCKED FEMALE AND MALE SIGN">&#9892;</div>
            <div title="MALE AND FEMALE SIGN">&#9893;</div>
            <div title="MALE WITH STROKE SIGN">&#9894;</div>
            <div title="MALE WITH STROKE AND MALE AND FEMALE SIGN">&#9895;</div>
            <div title="VERTICAL MALE WITH STROKE SIGN">&#9896;</div>
            <div title="HORIZONTAL MALE WITH STROKE SIGN">&#9897;</div>
            <div title="MEDIUM WHITE CIRCLE">&#9898;</div>
            <div title="MEDIUM BLACK CIRCLE">&#9899;</div>
            <div title="MEDIUM SMALL WHITE CIRCLE">&#9900;</div>
            <div title="MARRIAGE SYMBOL">&#9901;</div>
            <div title="DIVORCE SYMBOL">&#9902;</div>
            <div title="UNMARRIED PARTNERSHIP SYMBOL">&#9903;</div>
        </div>
        
        <div id="divCyrillicBasic" class="tab-content container clearfix">
        
            <!-- Cyrillic: https://www.w3schools.com/charsets/ref_utf_cyrillic.asp -->
            <div title="CYRILLIC CAPITAL LETTER IE WITH GRAVE">&#1024;</div>
            <div title="CYRILLIC CAPITAL LETTER IO">&#1025;</div>
            <div title="CYRILLIC CAPITAL LETTER DJE">&#1026;</div>
            <div title="CYRILLIC CAPITAL LETTER GJE">&#1027;</div>
            <div title="CYRILLIC CAPITAL LETTER UKRAINIAN IE">&#1028;</div>
            <div title="CYRILLIC CAPITAL LETTER DZE">&#1029;</div>
            <div title="CYRILLIC CAPITAL LETTER BYELORUSSIAN-UKRAINIAN I">&#1030;</div>
            <div title="CYRILLIC CAPITAL LETTER YI">&#1031;</div>
            <div title="CYRILLIC CAPITAL LETTER JE">&#1032;</div>
            <div title="CYRILLIC CAPITAL LETTER LJE">&#1033;</div>
            <div title="CYRILLIC CAPITAL LETTER NJE">&#1034;</div>
            <div title="CYRILLIC CAPITAL LETTER TSHE">&#1035;</div>
            <div title="CYRILLIC CAPITAL LETTER KJE">&#1036;</div>
            <div title="CYRILLIC CAPITAL LETTER I WITH GRAVE">&#1037;</div>
            <div title="CYRILLIC CAPITAL LETTER SHORT U">&#1038;</div>
            <div title="CYRILLIC CAPITAL LETTER DZHE">&#1039;</div>
            <div title="CYRILLIC CAPITAL LETTER A">&#1040;</div>
            <div title="CYRILLIC CAPITAL LETTER BE">&#1041;</div>
            <div title="CYRILLIC CAPITAL LETTER VE">&#1042;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE">&#1043;</div>
            <div title="CYRILLIC CAPITAL LETTER DE">&#1044;</div>
            <div title="CYRILLIC CAPITAL LETTER IE">&#1045;</div>
            <div title="CYRILLIC CAPITAL LETTER ZHE">&#1046;</div>
            <div title="CYRILLIC CAPITAL LETTER ZE">&#1047;</div>
            <div title="CYRILLIC CAPITAL LETTER I">&#1048;</div>
            <div title="CYRILLIC CAPITAL LETTER SHORT I">&#1049;</div>
            <div title="CYRILLIC CAPITAL LETTER KA">&#1050;</div>
            <div title="CYRILLIC CAPITAL LETTER EL">&#1051;</div>
            <div title="CYRILLIC CAPITAL LETTER EM">&#1052;</div>
            <div title="CYRILLIC CAPITAL LETTER EN">&#1053;</div>
            <div title="CYRILLIC CAPITAL LETTER O">&#1054;</div>
            <div title="CYRILLIC CAPITAL LETTER PE">&#1055;</div>
            <div title="CYRILLIC CAPITAL LETTER ER">&#1056;</div>
            <div title="CYRILLIC CAPITAL LETTER ES">&#1057;</div>
            <div title="CYRILLIC CAPITAL LETTER TE">&#1058;</div>
            <div title="CYRILLIC CAPITAL LETTER U">&#1059;</div>
            <div title="CYRILLIC CAPITAL LETTER EF">&#1060;</div>
            <div title="CYRILLIC CAPITAL LETTER HA">&#1061;</div>
            <div title="CYRILLIC CAPITAL LETTER TSE">&#1062;</div>
            <div title="CYRILLIC CAPITAL LETTER CHE">&#1063;</div>
            <div title="CYRILLIC CAPITAL LETTER SHA">&#1064;</div>
            <div title="CYRILLIC CAPITAL LETTER SHCHA">&#1065;</div>
            <div title="CYRILLIC CAPITAL LETTER HARD SIGN">&#1066;</div>
            <div title="CYRILLIC CAPITAL LETTER YERU">&#1067;</div>
            <div title="CYRILLIC CAPITAL LETTER SOFT SIGN">&#1068;</div>
            <div title="CYRILLIC CAPITAL LETTER E">&#1069;</div>
            <div title="CYRILLIC CAPITAL LETTER YU">&#1070;</div>
            <div title="CYRILLIC CAPITAL LETTER YA">&#1071;</div>
            <div title="CYRILLIC SMALL LETTER A">&#1072;</div>
            <div title="CYRILLIC SMALL LETTER BE">&#1073;</div>
            <div title="CYRILLIC SMALL LETTER VE">&#1074;</div>
            <div title="CYRILLIC SMALL LETTER GHE">&#1075;</div>
            <div title="CYRILLIC SMALL LETTER DE">&#1076;</div>
            <div title="CYRILLIC SMALL LETTER IE">&#1077;</div>
            <div title="CYRILLIC SMALL LETTER ZHE">&#1078;</div>
            <div title="CYRILLIC SMALL LETTER ZE">&#1079;</div>
            <div title="CYRILLIC SMALL LETTER I">&#1080;</div>
            <div title="CYRILLIC SMALL LETTER SHORT I">&#1081;</div>
            <div title="CYRILLIC SMALL LETTER KA">&#1082;</div>
            <div title="CYRILLIC SMALL LETTER EL">&#1083;</div>
            <div title="CYRILLIC SMALL LETTER EM">&#1084;</div>
            <div title="CYRILLIC SMALL LETTER EN">&#1085;</div>
            <div title="CYRILLIC SMALL LETTER O">&#1086;</div>
            <div title="CYRILLIC SMALL LETTER PE">&#1087;</div>
            <div title="CYRILLIC SMALL LETTER ER">&#1088;</div>
            <div title="CYRILLIC SMALL LETTER ES">&#1089;</div>
            <div title="CYRILLIC SMALL LETTER TE">&#1090;</div>
            <div title="CYRILLIC SMALL LETTER U">&#1091;</div>
            <div title="CYRILLIC SMALL LETTER EF">&#1092;</div>
            <div title="CYRILLIC SMALL LETTER HA">&#1093;</div>
            <div title="CYRILLIC SMALL LETTER TSE">&#1094;</div>
            <div title="CYRILLIC SMALL LETTER CHE">&#1095;</div>
            <div title="CYRILLIC SMALL LETTER SHA">&#1096;</div>
            <div title="CYRILLIC SMALL LETTER SHCHA">&#1097;</div>
            <div title="CYRILLIC SMALL LETTER HARD SIGN">&#1098;</div>
            <div title="CYRILLIC SMALL LETTER YERU">&#1099;</div>
            <div title="CYRILLIC SMALL LETTER SOFT SIGN">&#1100;</div>
            <div title="CYRILLIC SMALL LETTER E">&#1101;</div>
            <div title="CYRILLIC SMALL LETTER YU">&#1102;</div>
            <div title="CYRILLIC SMALL LETTER YA">&#1103;</div>
            <div title="CYRILLIC SMALL LETTER IE WITH GRAVE">&#1104;</div>
            <div title="CYRILLIC SMALL LETTER IO">&#1105;</div>
            <div title="CYRILLIC SMALL LETTER DJE">&#1106;</div>
            <div title="CYRILLIC SMALL LETTER GJE">&#1107;</div>
            <div title="CYRILLIC SMALL LETTER UKRAINIAN IE">&#1108;</div>
            <div title="CYRILLIC SMALL LETTER DZE">&#1109;</div>
            <div title="CYRILLIC SMALL LETTER BYELORUSSIAN-UKRAINIAN I">&#1110;</div>
            <div title="CYRILLIC SMALL LETTER YI">&#1111;</div>
            <div title="CYRILLIC SMALL LETTER JE">&#1112;</div>
            <div title="CYRILLIC SMALL LETTER LJE">&#1113;</div>
            <div title="CYRILLIC SMALL LETTER NJE">&#1114;</div>
            <div title="CYRILLIC SMALL LETTER TSHE">&#1115;</div>
            <div title="CYRILLIC SMALL LETTER KJE">&#1116;</div>
            <div title="CYRILLIC SMALL LETTER I WITH GRAVE">&#1117;</div>
            <div title="CYRILLIC SMALL LETTER SHORT U">&#1118;</div>
            <div title="CYRILLIC SMALL LETTER DZHE">&#1119;</div>
            <div title="CYRILLIC CAPITAL LETTER OMEGA">&#1120;</div>
            <div title="CYRILLIC SMALL LETTER OMEGA">&#1121;</div>
            <div title="CYRILLIC CAPITAL LETTER YAT">&#1122;</div>
            <div title="CYRILLIC SMALL LETTER YAT">&#1123;</div>
            <div title="CYRILLIC CAPITAL LETTER IOTIFIED E">&#1124;</div>
            <div title="CYRILLIC SMALL LETTER IOTIFIED E">&#1125;</div>
            <div title="CYRILLIC CAPITAL LETTER LITTLE YUS">&#1126;</div>
            <div title="CYRILLIC SMALL LETTER LITTLE YUS">&#1127;</div>
            <div title="CYRILLIC CAPITAL LETTER IOTIFIED LITTLE YUS">&#1128;</div>
            <div title="CYRILLIC SMALL LETTER IOTIFIED LITTLE YUS">&#1129;</div>
            <div title="CYRILLIC CAPITAL LETTER BIG YUS">&#1130;</div>
            <div title="CYRILLIC SMALL LETTER BIG YUS">&#1131;</div>
            <div title="CYRILLIC CAPITAL LETTER IOTIFIED BIG YUS">&#1132;</div>
            <div title="CYRILLIC SMALL LETTER IOTIFIED BIG YUS">&#1133;</div>
            <div title="CYRILLIC CAPITAL LETTER KSI">&#1134;</div>
            <div title="CYRILLIC SMALL LETTER KSI">&#1135;</div>
            <div title="CYRILLIC CAPITAL LETTER PSI">&#1136;</div>
            <div title="CYRILLIC SMALL LETTER PSI">&#1137;</div>
            <div title="CYRILLIC CAPITAL LETTER FITA">&#1138;</div>
            <div title="CYRILLIC SMALL LETTER FITA">&#1139;</div>
            <div title="CYRILLIC CAPITAL LETTER IZHITSA">&#1140;</div>
            <div title="CYRILLIC SMALL LETTER IZHITSA">&#1141;</div>
            <div title="CYRILLIC CAPITAL LETTER IZHITSA WITH DOUBLE GRAVE ACCENT">&#1142;</div>
            <div title="CYRILLIC SMALL LETTER IZHITSA WITH DOUBLE GRAVE ACCENT">&#1143;</div>
            <div title="CYRILLIC CAPITAL LETTER UK">&#1144;</div>
            <div title="CYRILLIC SMALL LETTER UK">&#1145;</div>
            <div title="CYRILLIC CAPITAL LETTER ROUND OMEGA">&#1146;</div>
            <div title="CYRILLIC SMALL LETTER ROUND OMEGA">&#1147;</div>
            <div title="CYRILLIC CAPITAL LETTER OMEGA WITH TITLO">&#1148;</div>
            <div title="CYRILLIC SMALL LETTER OMEGA WITH TITLO">&#1149;</div>
            <div title="CYRILLIC CAPITAL LETTER OT">&#1150;</div>
            <div title="CYRILLIC SMALL LETTER OT">&#1151;</div>
            <div title="CYRILLIC CAPITAL LETTER KOPPA">&#1152;</div>
            <div title="CYRILLIC SMALL LETTER KOPPA">&#1153;</div>
            <div title="CYRILLIC THOUSANDS SIGN">&#1154;</div>
            <div title="COMBINING CYRILLIC TITLO (combined with о)">&#1155;</div>
            <div title="COMBINING CYRILLIC PALATALIZATION (combined with о)">&#1156;</div>
            <div title="COMBINING CYRILLIC DASIA PNEUMATA (combined with о)">&#1157;</div>
            <div title="COMBINING CYRILLIC PSILI PNEUMATA (combined with о)">&#1158;</div>
            <div title="COMBINING CYRILLIC POKRYTIE (combined with о)">&#1159;</div>
            <div title="COMBINING CYRILLIC HUNDRED THOUSANDS SIGN (combined with о)">&#1160;</div>
            <div title="COMBINING CYRILLIC MILLIONS SIGN (combined with о)">&#1161;</div>
            <div title="CYRILLIC CAPITAL LETTER SHORT I WITH TAIL">&#1162;</div>
            <div title="CYRILLIC SMALL LETTER SHORT I WITH TAIL">&#1163;</div>
            <div title="CYRILLIC CAPITAL LETTER SEMISOFT SIGN">&#1164;</div>
            <div title="CYRILLIC SMALL LETTER SEMISOFT SIGN">&#1165;</div>
            <div title="CYRILLIC CAPITAL LETTER ER WITH TICK">&#1166;</div>
            <div title="CYRILLIC SMALL LETTER ER WITH TICK">&#1167;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE WITH UPTURN">&#1168;</div>
            <div title="CYRILLIC SMALL LETTER GHE WITH UPTURN">&#1169;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE WITH STROKE">&#1170;</div>
            <div title="CYRILLIC SMALL LETTER GHE WITH STROKE">&#1171;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE WITH MIDDLE HOOK">&#1172;</div>
            <div title="CYRILLIC SMALL LETTER GHE WITH MIDDLE HOOK">&#1173;</div>
            <div title="CYRILLIC CAPITAL LETTER ZHE WITH DESCENDER">&#1174;</div>
            <div title="CYRILLIC SMALL LETTER ZHE WITH DESCENDER">&#1175;</div>
            <div title="CYRILLIC CAPITAL LETTER ZE WITH DESCENDER">&#1176;</div>
            <div title="CYRILLIC SMALL LETTER ZE WITH DESCENDER">&#1177;</div>
            <div title="CYRILLIC CAPITAL LETTER KA WITH DESCENDER">&#1178;</div>
            <div title="CYRILLIC SMALL LETTER KA WITH DESCENDER">&#1179;</div>
            <div title="CYRILLIC CAPITAL LETTER KA WITH VERTICAL STROKE">&#1180;</div>
            <div title="CYRILLIC SMALL LETTER KA WITH VERTICAL STROKE">&#1181;</div>
            <div title="CYRILLIC CAPITAL LETTER KA WITH STROKE">&#1182;</div>
            <div title="CYRILLIC SMALL LETTER KA WITH STROKE">&#1183;</div>
            <div title="CYRILLIC CAPITAL LETTER BASHKIR KA">&#1184;</div>
            <div title="CYRILLIC SMALL LETTER BASHKIR KA">&#1185;</div>
            <div title="CYRILLIC CAPITAL LETTER EN WITH DESCENDER">&#1186;</div>
            <div title="CYRILLIC SMALL LETTER EN WITH DESCENDER">&#1187;</div>
            <div title="CYRILLIC CAPITAL LIGATURE EN GHE">&#1188;</div>
            <div title="CYRILLIC SMALL LIGATURE EN GHE">&#1189;</div>
            <div title="CYRILLIC CAPITAL LETTER PE WITH MIDDLE HOOK">&#1190;</div>
            <div title="CYRILLIC SMALL LETTER PE WITH MIDDLE HOOK">&#1191;</div>
            <div title="CYRILLIC CAPITAL LETTER ABKHASIAN HA">&#1192;</div>
            <div title="CYRILLIC SMALL LETTER ABKHASIAN HA">&#1193;</div>
            <div title="CYRILLIC CAPITAL LETTER ES WITH DESCENDER">&#1194;</div>
            <div title="CYRILLIC SMALL LETTER ES WITH DESCENDER">&#1195;</div>
            <div title="CYRILLIC CAPITAL LETTER TE WITH DESCENDER">&#1196;</div>
            <div title="CYRILLIC SMALL LETTER TE WITH DESCENDER">&#1197;</div>
            <div title="CYRILLIC CAPITAL LETTER STRAIGHT U">&#1198;</div>
            <div title="CYRILLIC SMALL LETTER STRAIGHT U">&#1199;</div>
            <div title="CYRILLIC CAPITAL LETTER STRAIGHT U WITH STROKE">&#1200;</div>
            <div title="CYRILLIC SMALL LETTER STRAIGHT U WITH STROKE">&#1201;</div>
            <div title="CYRILLIC CAPITAL LETTER HA WITH DESCENDER">&#1202;</div>
            <div title="CYRILLIC SMALL LETTER HA WITH DESCENDER">&#1203;</div>
            <div title="CYRILLIC CAPITAL LIGATURE TE TSE">&#1204;</div>
            <div title="CYRILLIC SMALL LIGATURE TE TSE">&#1205;</div>
            <div title="CYRILLIC CAPITAL LETTER CHE WITH DESCENDER">&#1206;</div>
            <div title="CYRILLIC SMALL LETTER CHE WITH DESCENDER">&#1207;</div>
            <div title="CYRILLIC CAPITAL LETTER CHE WITH VERTICAL STROKE">&#1208;</div>
            <div title="CYRILLIC SMALL LETTER CHE WITH VERTICAL STROKE">&#1209;</div>
            <div title="CYRILLIC CAPITAL LETTER SHHA">&#1210;</div>
            <div title="CYRILLIC SMALL LETTER SHHA">&#1211;</div>
            <div title="CYRILLIC CAPITAL LETTER ABKHASIAN CHE">&#1212;</div>
            <div title="CYRILLIC SMALL LETTER ABKHASIAN CHE">&#1213;</div>
            <div title="CYRILLIC CAPITAL LETTER ABKHASIAN CHE WITH DESCENDER">&#1214;</div>
            <div title="CYRILLIC SMALL LETTER ABKHASIAN CHE WITH DESCENDER">&#1215;</div>
            <div title="CYRILLIC LETTER PALOCHKA">&#1216;</div>
            <div title="CYRILLIC CAPITAL LETTER ZHE WITH BREVE">&#1217;</div>
            <div title="CYRILLIC SMALL LETTER ZHE WITH BREVE">&#1218;</div>
            <div title="CYRILLIC CAPITAL LETTER KA WITH HOOK">&#1219;</div>
            <div title="CYRILLIC SMALL LETTER KA WITH HOOK">&#1220;</div>
            <div title="CYRILLIC CAPITAL LETTER EL WITH TAIL">&#1221;</div>
            <div title="CYRILLIC SMALL LETTER EL WITH TAIL">&#1222;</div>
            <div title="CYRILLIC CAPITAL LETTER EN WITH HOOK">&#1223;</div>
            <div title="CYRILLIC SMALL LETTER EN WITH HOOK">&#1224;</div>
            <div title="CYRILLIC CAPITAL LETTER EN WITH TAIL">&#1225;</div>
            <div title="CYRILLIC SMALL LETTER EN WITH TAIL">&#1226;</div>
            <div title="CYRILLIC CAPITAL LETTER KHAKASSIAN CHE">&#1227;</div>
            <div title="CYRILLIC SMALL LETTER KHAKASSIAN CHE">&#1228;</div>
            <div title="CYRILLIC CAPITAL LETTER EM WITH TAIL">&#1229;</div>
            <div title="CYRILLIC SMALL LETTER EM WITH TAIL">&#1230;</div>
            <div title="CYRILLIC SMALL LETTER PALOCHKA">&#1231;</div>
            <div title="CYRILLIC CAPITAL LETTER A WITH BREVE">&#1232;</div>
            <div title="CYRILLIC SMALL LETTER A WITH BREVE">&#1233;</div>
            <div title="CYRILLIC CAPITAL LETTER A WITH DIAERESIS">&#1234;</div>
            <div title="CYRILLIC SMALL LETTER A WITH DIAERESIS">&#1235;</div>
            <div title="CYRILLIC CAPITAL LIGATURE A IE">&#1236;</div>
            <div title="CYRILLIC SMALL LIGATURE A IE">&#1237;</div>
            <div title="CYRILLIC CAPITAL LETTER IE WITH BREVE">&#1238;</div>
            <div title="CYRILLIC SMALL LETTER IE WITH BREVE">&#1239;</div>
            <div title="CYRILLIC CAPITAL LETTER SCHWA">&#1240;</div>
            <div title="CYRILLIC SMALL LETTER SCHWA">&#1241;</div>
            <div title="CYRILLIC CAPITAL LETTER SCHWA WITH DIAERESIS">&#1242;</div>
            <div title="CYRILLIC SMALL LETTER SCHWA WITH DIAERESIS">&#1243;</div>
            <div title="CYRILLIC CAPITAL LETTER ZHE WITH DIAERESIS">&#1244;</div>
            <div title="CYRILLIC SMALL LETTER ZHE WITH DIAERESIS">&#1245;</div>
            <div title="CYRILLIC CAPITAL LETTER ZE WITH DIAERESIS">&#1246;</div>
            <div title="CYRILLIC SMALL LETTER ZE WITH DIAERESIS">&#1247;</div>
            <div title="CYRILLIC CAPITAL LETTER ABKHASIAN DZE">&#1248;</div>
            <div title="CYRILLIC SMALL LETTER ABKHASIAN DZE">&#1249;</div>
            <div title="CYRILLIC CAPITAL LETTER I WITH MACRON">&#1250;</div>
            <div title="CYRILLIC SMALL LETTER I WITH MACRON">&#1251;</div>
            <div title="CYRILLIC CAPITAL LETTER I WITH DIAERESIS">&#1252;</div>
            <div title="CYRILLIC SMALL LETTER I WITH DIAERESIS">&#1253;</div>
            <div title="CYRILLIC CAPITAL LETTER O WITH DIAERESIS">&#1254;</div>
            <div title="CYRILLIC SMALL LETTER O WITH DIAERESIS">&#1255;</div>
            <div title="CYRILLIC CAPITAL LETTER BARRED O">&#1256;</div>
            <div title="CYRILLIC SMALL LETTER BARRED O">&#1257;</div>
            <div title="CYRILLIC CAPITAL LETTER BARRED O WITH DIAERESIS">&#1258;</div>
            <div title="CYRILLIC SMALL LETTER BARRED O WITH DIAERESIS">&#1259;</div>
            <div title="CYRILLIC CAPITAL LETTER E WITH DIAERESIS">&#1260;</div>
            <div title="CYRILLIC SMALL LETTER E WITH DIAERESIS">&#1261;</div>
            <div title="CYRILLIC CAPITAL LETTER U WITH MACRON">&#1262;</div>
            <div title="CYRILLIC SMALL LETTER U WITH MACRON">&#1263;</div>
            <div title="CYRILLIC CAPITAL LETTER U WITH DIAERESIS">&#1264;</div>
            <div title="CYRILLIC SMALL LETTER U WITH DIAERESIS">&#1265;</div>
            <div title="CYRILLIC CAPITAL LETTER U WITH DOUBLE ACUTE">&#1266;</div>
            <div title="CYRILLIC SMALL LETTER U WITH DOUBLE ACUTE">&#1267;</div>
            <div title="CYRILLIC CAPITAL LETTER CHE WITH DIAERESIS">&#1268;</div>
            <div title="CYRILLIC SMALL LETTER CHE WITH DIAERESIS">&#1269;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE WITH DESCENDER">&#1270;</div>
            <div title="CYRILLIC SMALL LETTER GHE WITH DESCENDER">&#1271;</div>
            <div title="CYRILLIC CAPITAL LETTER YERU WITH DIAERESIS">&#1272;</div>
            <div title="CYRILLIC SMALL LETTER YERU WITH DIAERESIS">&#1273;</div>
            <div title="CYRILLIC CAPITAL LETTER GHE WITH STROKE AND HOOK">&#1274;</div>
            <div title="CYRILLIC SMALL LETTER GHE WITH STROKE AND HOOK">&#1275;</div>
            <div title="CYRILLIC CAPITAL LETTER HA WITH HOOK">&#1276;</div>
            <div title="CYRILLIC SMALL LETTER HA WITH HOOK">&#1277;</div>
            <div title="CYRILLIC CAPITAL LETTER HA WITH STROKE">&#1278;</div>
            <div title="CYRILLIC SMALL LETTER HA WITH STROKE">&#1279;</div>
            
        </div>
        
        <div id="divDiacriticalMarks" class="tab-content container clearfix">
        
            <!-- Diacritical Marks: https://www.w3schools.com/charsets/ref_utf_diacritical.asp -->
            <div title="GRAVE ACCENT">&#768;</div>
            <div title="ACUTE ACCENT">&#769;</div>
            <div title="CIRCUMFLEX ACCENT">&#770;</div>
            <div title="TILDE">&#771;</div>
            <div title="MACRON">&#772;</div>
            <div title="OVERLINE">&#773;</div>
            <div title="BREVE">&#774;</div>
            <div title="DOT ABOVE">&#775;</div>
            <div title="DIAERESIS">&#776;</div>
            <div title="HOOK ABOVE">&#777;</div>
            <div title="RING ABOVE">&#778;</div>
            <div title="DOUBLE ACUTE ACCENT">&#779;</div>
            <div title="CARON">&#780;</div>
            <div title="VERTICAL LINE ABOVE">&#781;</div>
            <div title="DOUBLE VERTICAL LINE ABOVE">&#782;</div>
            <div title="DOUBLE GRAVE ACCENT">&#783;</div>
            <div title="CANDRABINDU">&#784;</div>
            <div title="INVERTED BREVE">&#785;</div>
            <div title="TURNED COMMA ABOVE">&#786;</div>
            <div title="COMMA ABOVE">&#787;</div>
            <div title="REVERSED COMMA ABOVE">&#788;</div>
            <div title="COMMA ABOVE RIGHT">&#789;</div>
            <div title="GRAVE ACCENT BELOW">&#790;</div>
            <div title="ACUTE ACCENT BELOW>&#791;</div>
            <div title="LEFT TACK BELOW">&#792;</div>
            <div title="RIGHT TACK BELOW">&#793;</div>
            <div title="LEFT ANGLE ABOVE">&#794;</div>
            <div title="HORN">&#795;</div>
            <div title="LEFT HALF RING BELOW">&#796;</div>
            <div title="UP TACK BELOW">&#797;</div>
            <div title="DOWN TACK BELOW">&#798;</div>
            <div title="PLUS SIGN BELOW">&#799;</div>
            <div title="MINUS SIGN BELOW">&#800;</div>
            <div title="PALATALIZED HOOK BELOW">&#801;</div>
            <div title="RETROFLEX HOOK BELOW">&#802;</div>
            <div title="DOT BELOW">&#803;</div>
            <div title="DIAERESIS BELOW">&#804;</div>
            <div title="RING BELOW">&#805;</div>
            <div title="COMMA BELOW">&#806;</div>
            <div title="CEDILLA">&#807;</div>
            <div title="OGONEK">&#808;</div>
            <div title="VERTICAL LINE BELOW">&#809;</div>
            <div title="BRIDGE BELOW">&#810;</div>
            <div title="INVERTED DOUBLE ARCH BELOW">&#811;</div>
            <div title="CARON BELOW">&#812;</div>
            <div title="CIRCUMFLEX ACCENT BELOW">&#813;</div>
            <div title="BREVE BELOW">&#814;</div>
            <div title="INVERTED BREVE BELOW">&#815;</div>
            <div title="TILDE BELOW">&#816;</div>
            <div title="MACRON BELOW">&#817;</div>
            <div title="LOW LINE">&#818;</div>
            <div title="DOUBLE LOW LINE">&#819;</div>
            <div title="TILDE OVERLAY">&#820;</div>
            <div title="SHORT STROKE OVERLAY">&#821;</div>
            <div title="LONG STROKE OVERLAY">&#822;</div>
            <div title="SHORT SOLIDUS OVERLAY">&#823;</div>
            <div title="LONG SOLIDUS OVERLAY">&#824;</div>
            <div title="RIGHT HALF RING BELOW">&#825;</div>
            <div title="INVERTED BRIDGE BELOW">&#826;</div>
            <div title="SQUARE BELOW">&#827;</div>
            <div title="SEAGULL BELOW">&#828;</div>
            <div title="X ABOVE">&#829;</div>
            <div title="VERTICAL TILDE">&#830;</div>
            <div title="DOUBLE OVERLINE">&#831;</div>
            <div title="GRAVE TONE MARK">&#832;</div>
            <div title="ACUTE TONE MARK">&#833;</div>
            <div title="GREEK PERISPOMENI (combined with theta)">&#834;</div>
            <div title="GREEK KORONIS (combined with theta)">&#835;</div>
            <div title="GREEK DIALYTIKA TONOS (combined with theta)">&#836;</div>
            <div title="GREEK YPOGEGRAMMENI (combined with theta)">&#837;</div>
            <div title="BRIDGE ABOVE">&#838;</div>
            <div title="EQUALS SIGN BELOW">&#839;</div>
            <div title="DOUBLE VERTICAL LINE BELOW">&#840;</div>
            <div title="LEFT ANGLE BELOW">&#841;</div>
            <div title="NOT TILDE ABOVE">&#842;</div>
            <div title="HOMOTHETIC ABOVE">&#843;</div>
            <div title="ALMOST EQUAL TO ABOVE">&#844;</div>
            <div title="LEFT RIGHT ARROW BELOW">&#845;</div>
            <div title="UPWARDS ARROW BELOW">&#846;</div>
            <div title="GRAPHEME JOINER">&#847;</div>
            <div title="RIGHT ARROWHEAD ABOVE">&#848;</div>
            <div title="LEFT HALF RING ABOVE">&#849;</div>
            <div title="FERMATA">&#850;</div>
            <div title="X BELOW">&#851;</div>
            <div title="LEFT ARROWHEAD BELOW">&#852;</div>
            <div title="RIGHT ARROWHEAD BELOW">&#853;</div>
            <div title="RIGHT ARROWHEAD AND UP ARROWHEAD BELOW">&#854;</div>
            <div title="RIGHT HALF RING ABOVE">&#855;</div>
            <div title="DOT ABOVE RIGHT">&#856;</div>
            <div title="ASTERISK BELOW">&#857;</div>
            <div title="DOUBLE RING BELOW">&#858;</div>
            <div title="ZIGZAG ABOVE">&#859;</div>
            <div title="DOUBLE BREVE BELOW">&#860;</div>
            <div title="DOUBLE BREVE">&#861;</div>
            <div title="DOUBLE MACRON">&#862;</div>
            <div title="DOUBLE MACRON BELOW">&#863;</div>
            <div title="DOUBLE TILDE">&#864;</div>
            <div title="DOUBLE INVERTED BREVE">&#865;</div>
            <div title="DOUBLE RIGHTWARDS ARROW BELOW">&#866;</div>
            <div title="LATIN SMALL LETTER A">&#867;</div>
            <div title="LATIN SMALL LETTER E">&#868;</div>
            <div title="LATIN SMALL LETTER I">&#869;</div>
            <div title="LATIN SMALL LETTER O">&#870;</div>
            <div title="LATIN SMALL LETTER U">&#871;</div>
            <div title="LATIN SMALL LETTER C">&#872;</div>
            <div title="LATIN SMALL LETTER D">&#873;</div>
            <div title="LATIN SMALL LETTER H">&#874;</div>
            <div title="LATIN SMALL LETTER M">&#875;</div>
            <div title="LATIN SMALL LETTER R">&#876;</div>
            <div title="LATIN SMALL LETTER T">&#877;</div>
            <div title="LATIN SMALL LETTER V">&#878;</div>
            <div title="LATIN SMALL LETTER X">&#879;</div>
        </div>
        
        <div id="divGreekAndCoptic" class="tab-content container clearfix">
        
            <!-- Greek and Coptic: https://www.w3schools.com/charsets/ref_utf_greek.asp -->
        
            <div title="GREEK CAPITAL LETTER HETA">&#880;</div>
            <div title="GREEK SMALL LETTER HETA">&#881;</div>
            <div title="GREEK CAPITAL LETTER ARCHAIC SAMPI">&#882;</div>
            <div title="GREEK SMALL LETTER ARCHAIC SAMPI">&#883;</div>
            <div title="GREEK NUMERAL SIGN">&#884;</div>
            <div title="GREEK LOWER NUMERAL SIGN">&#885;</div>
            <div title="GREEK CAPITAL LETTER PAMPHYLIAN DIGAMMA">&#886;</div>
            <div title="GREEK SMALL LETTER PAMPHYLIAN DIGAMMA">&#887;</div>
            <div title="GREEK YPOGEGRAMMENI">&#890;</div>
            <div title="GREEK SMALL REVERSED LUNATE SIGMA SYMBOL">&#891;</div>
            <div title="GREEK SMALL DOTTED LUNATE SIGMA SYMBOL">&#892;</div>
            <div title="GREEK SMALL REVERSED DOTTED LUNATE SIGMA SYMBOL">&#893;</div>
            <div title="GREEK QUESTION MARK">&#894;</div>
            <div title="GREEK TONOS">&#900;</div>
            <div title="GREEK DIALYTIKA TONOS">&#901;</div>
            <div title="GREEK CAPITAL LETTER ALPHA WITH TONOS">&#902;</div>
            <div title="GREEK ANO TELEIA">&#903;</div>
            <div title="GREEK CAPITAL LETTER EPSILON WITH TONOS">&#904;</div>
            <div title="GREEK CAPITAL LETTER ETA WITH TONOS">&#905;</div>
            <div title="GREEK CAPITAL LETTER IOTA WITH TONOS">&#906;</div>
            <div title="GREEK CAPITAL LETTER OMICRON WITH TONOS">&#908;</div>
            <div title="GREEK CAPITAL LETTER UPSILON WITH TONOS">&#910;</div>
            <div title="GREEK CAPITAL LETTER OMEGA WITH TONOS">&#911;</div>
            <div title="GREEK SMALL LETTER IOTA WITH DIALYTIKA AND TONOS">&#912;</div>
            <div title="GREEK CAPITAL LETTER ALPHA">&Alpha;</div>
            <div title="GREEK CAPITAL LETTER BETA">&Beta;</div>
            <div title="GREEK CAPITAL LETTER GAMMA">&Gamma;</div>
            <div title="GREEK CAPITAL LETTER DELTA">&Delta;</div>
            <div title="GREEK CAPITAL LETTER EPSILON">&Epsilon;</div>
            <div title="GREEK CAPITAL LETTER ZETA">&Zeta;</div>
            <div title="GREEK CAPITAL LETTER ETA">&Eta;</div>
            <div title="GREEK CAPITAL LETTER THETA">&Theta;</div>
            <div title="GREEK CAPITAL LETTER IOTA">&Iota;</div>
            <div title="GREEK CAPITAL LETTER KAPPA">&Kappa;</div>
            <div title="GREEK CAPITAL LETTER LAMBDA">&Lambda;</div>
            <div title="GREEK CAPITAL LETTER MU">&Mu;</div>
            <div title="GREEK CAPITAL LETTER NU">&Nu;</div>
            <div title="GREEK CAPITAL LETTER XI">&Xi;</div>
            <div title="GREEK CAPITAL LETTER OMICRON">&Omicron;</div>
            <div title="GREEK CAPITAL LETTER PI">&Pi;</div>
            <div title="GREEK CAPITAL LETTER RHO">&Rho;</div>
            <div title="GREEK CAPITAL LETTER SIGMA">&Sigma;</div>
            <div title="GREEK CAPITAL LETTER TAU">&Tau;</div>
            <div title="GREEK CAPITAL LETTER UPSILON">&Upsilon;</div>
            <div title="GREEK CAPITAL LETTER PHI">&Phi;</div>
            <div title="GREEK CAPITAL LETTER CHI">&Chi;</div>
            <div title="GREEK CAPITAL LETTER PSI">&Psi;</div>
            <div title="GREEK CAPITAL LETTER OMEGA">&Omega;</div>
            <div title="GREEK CAPITAL LETTER IOTA WITH DIALYTIKA">&#938;</div>
            <div title="GREEK CAPITAL LETTER UPSILON WITH DIALYTIKA">&#939;</div>
            <div title="GREEK SMALL LETTER ALPHA WITH TONOS">&#940;</div>
            <div title="GREEK SMALL LETTER EPSILON WITH TONOS">&#941;</div>
            <div title="GREEK SMALL LETTER ETA WITH TONOS">&#942;</div>
            <div title="GREEK SMALL LETTER IOTA WITH TONOS">&#943;</div>
            <div title="GREEK SMALL LETTER UPSILON WITH DIALYTIKA AND TONOS">&#944;</div>
            <div title="GREEK SMALL LETTER ALPHA">&alpha;</div>
            <div title="GREEK SMALL LETTER BETA">&beta;</div>
            <div title="GREEK SMALL LETTER GAMMA">&gamma;</div>
            <div title="GREEK SMALL LETTER DELTA">&delta;</div>
            <div title="GREEK SMALL LETTER EPSILON">&epsilon;</div>
            <div title="GREEK SMALL LETTER ZETA">&zeta;</div>
            <div title="GREEK SMALL LETTER ETA">&eta;</div>
            <div title="GREEK SMALL LETTER THETA">&theta;</div>
            <div title="GREEK SMALL LETTER IOTA">&iota;</div>
            <div title="GREEK SMALL LETTER KAPPA">&kappa;</div>
            <div title="GREEK SMALL LETTER LAMBDA">&lambda;</div>
            <div title="GREEK SMALL LETTER MU">&mu;</div>
            <div title="GREEK SMALL LETTER NU">&nu;</div>
            <div title="GREEK SMALL LETTER XI">&xi;</div>
            <div title="GREEK SMALL LETTER OMIMCRON">&omicron;</div>
            <div title="GREEK SMALL LETTER PI">&pi;</div>
            <div title="GREEK SMALL LETTER RHO">&rho;</div>
            <div title="GREEK SMALL LETTER FINAL SIGMA">&sigmaf;</div>
            <div title="GREEK SMALL LETTER SIGMA">&sigma;</div>
            <div title="GREEK SMALL LETTER TAU">&tau;</div>
            <div title="GREEK SMALL LETTER UPSILON">&upsilon;</div>
            <div title="GREEK SMALL LETTER PHI">&phi;</div>
            <div title="GREEK SMALL LETTER CHI">&chi;</div>
            <div title="GREEK SMALL LETTER PSI">&psi;</div>
            <div title="GREEK SMALL LETTER OMEGA">&omega;</div>
            <div title="GREEK SMALL LETTER IOTA WITH DIALYTIKA">&#970;</div>
            <div title="GREEK SMALL LETTER UPSILON WITH DIALYTIKA">&#971;</div>
            <div title="GREEK SMALL LETTER OMICRON WITH TONOS">&#972;</div>
            <div title="GREEK SMALL LETTER UPSILON WITH TONOS">&#973;</div>
            <div title="GREEK SMALL LETTER OMEGA WITH TONOS">&#974;</div>
            <div title="GREEK CAPITAL KAI SYMBOL">&#975;</div>
            <div title="GREEK BETA SYMBOL">&#976;</div>
            <div title="GREEK THETA SYMBOL">&thetasym;</div>
            <div title="GREEK UPSILON WITH HOOK SYMBOL">&upsih;</div>
            <div title="GREEK UPSILON WITH ACUTE AND HOOK SYMBOL">&#979;</div>
            <div title="GREEK UPSILON WITH DIAERESIS AND HOOK SYMBOL">&#980;</div>
            <div title="GREEK PHI SYMBOL">&straightphi;</div>
            <div title="GREEK PI SYMBOL">&piv;</div>
            <div title="GREEK KAI SYMBOL">&#983;</div>
            <div title="GREEK LETTER ARCHAIC KOPPA">&#984;</div>
            <div title="GREEK SMALL LETTER ARCHAIC KOPPA">&#985;</div>
            <div title="GREEK LETTER STIGMA">&#986;</div>
            <div title="GREEK SMALL LETTER STIGMA">&#987;</div>
            <div title="GREEK LETTER DIGAMMA">&Gammad;</div>
            <div title="GREEK SMALL LETTER DIGAMMA">&gammad;</div>
            <div title="GREEK LETTER KOPPA">&#990;</div>
            <div title="GREEK SMALL LETTER KOPPA">&#991;</div>
            <div title="GREEK LETTER SAMPI">&#992;</div>
            <div title="GREEK SMALL LETTER SAMPI">&#993;</div>
            <div title="COPTIC CAPITAL LETTER SHEI">&#994;</div>
            <div title="COPTIC SMALL LETTER SHEI">&#995;</div>
            <div title="COPTIC CAPITAL LETTER FEI">&#996;</div>
            <div title="COPTIC SMALL LETTER FEI">&#997;</div>
            <div title="COPTIC CAPITAL LETTER KHEI">&#998;</div>
            <div title="COPTIC SMALL LETTER KHEI">&#999;</div>
            <div title="COPTIC CAPITAL LETTER HORI">&#1000;</div>
            <div title="COPTIC SMALL LETTER HORI">&#1001;</div>
            <div title="COPTIC CAPITAL LETTER GANGIA">&#1002;</div>
            <div title="COPTIC SMALL LETTER GANGIA">&#1003;</div>
            <div title="COPTIC CAPITAL LETTER SHIMA">&#1004;</div>
            <div title="COPTIC SMALL LETTER SHIMA">&#1005;</div>
            <div title="COPTIC CAPITAL LETTER DEI">&#1006;</div>
            <div title="COPTIC SMALL LETTER DEI">&#1007;</div>
            <div title="GREEK KAPPA SYMBOL">&varkappa;</div>
            <div title="GREEK RHO SYMBOL">&varrho;</div>
            <div title="GREEK LUNATE SIGMA SYMBOL">&#1010;</div>
            <div title="GREEK LETTER YOT">&#1011;</div>
            <div title="GREEK CAPITAL THETA SYMBOL">&#1012;</div>
            <div title="GREEK LUNATE EPSILON SYMBOL">&straightepsilon;</div>
            <div title="GREEK REVERSED LUNATE EPSILON SYMBOL">&backepsilon;</div>
            <div title="GREEK CAPITAL LETTER SHO">&#1015;</div>
            <div title="GREEK SMALL LETTER SHO">&#1016;</div>
            <div title="GREEK CAPITAL LUNATE SIGMA SYMBOL">&#1017;</div>
            <div title="GREEK CAPITAL LETTER SAN">&#1018;</div>
            <div title="GREEK SMALL LETTER SAN">&#1019;</div>
            <div title="GREEK RHO WITH STROKE SYMBOL">&#1020;</div>
            <div title="GREEK CAPITAL REVERSED LUNATE SIGMA SYMBOL">&#1021;</div>
            <div title="GREEK CAPITAL DOTTED LUNATE SIGMA SYMBOL">&#1022;</div>
            <div title="GREEK CAPITAL REVERSED DOTTED LUNATE SIGMA SYMBOL">&#1023;</div>
            
        </div>
        
        <div id="divLatinExtendedA" class="tab-content container clearfix">
        
            <!-- Latin Extended A: https://www.w3schools.com/charsets/ref_utf_latin_extended_a.asp -->
            <div title="LATIN CAPITAL LETTER A WITH MACRON">&Amacr;</div>
            <div title="LATIN SMALL LETTER A WITH MACRON">&amacr;</div>
            <div title="LATIN CAPITAL LETTER A WITH BREVE">&Abreve;</div>
            <div title="LATIN SMALL LETTER A WITH BREVE">&abreve;</div>
            <div title="LATIN CAPITAL LETTER A WITH OGONEK">&Aogon;</div>
            <div title="LATIN SMALL LETTER A WITH OGONEK">&aogon;</div>
            <div title="LATIN CAPITAL LETTER C WITH ACUTE">&Cacute;</div>
            <div title="LATIN SMALL LETTER C WITH ACUTE">&cacute;</div>
            <div title="LATIN CAPITAL LETTER C WITH CIRCUMFLEX">&Ccirc;</div>
            <div title="LATIN SMALL LETTER C WITH CIRCUMFLEX">&ccirc;</div>
            <div title="LATIN CAPITAL LETTER C WITH DOT ABOVE">&#266;</div>
            <div title="LATIN SMALL LETTER C WITH DOT ABOVE">&cdot;</div>
            <div title="LATIN CAPITAL LETTER C WITH CARON">&Ccaron;</div>
            <div title="LATIN SMALL LETTER C WITH CARON">&ccaron;</div>
            <div title="LATIN CAPITAL LETTER D WITH CARON">&Dcaron;</div>
            <div title="LATIN SMALL LETTER D WITH CARON">&dcaron;</div>
            <div title="LATIN CAPITAL LETTER D WITH STROKE">&Dstrok;</div>
            <div title="LATIN SMALL LETTER D WITH STROKE">&dstrok;</div>
            <div title="LATIN CAPITAL LETTER E WITH MACRON">&Emacr;</div>
            <div title="LATIN SMALL LETTER E WITH MACRON">&emacr;</div>
            <div title="LATIN CAPITAL LETTER E WITH BREVE">&#276;</div>
            <div title="LATIN SMALL LETTER E WITH BREVE">&#277;</div>
            <div title="LATIN CAPITAL LETTER E WITH DOT ABOVE">&Edot;</div>
            <div title="LATIN SMALL LETTER E WITH DOT ABOVE">&edot;</div>
            <div title="LATIN CAPITAL LETTER E WITH OGONEK">&Eogon;</div>
            <div title="LATIN SMALL LETTER E WITH OGONEK">&eogon;</div>
            <div title="LATIN CAPITAL LETTER E WITH CARON">&Ecaron;</div>
            <div title="LATIN SMALL LETTER E WITH CARON">&ecaron;</div>
            <div title="LATIN CAPITAL LETTER G WITH CIRCUMFLEX">&Gcirc;</div>
            <div title="LATIN SMALL LETTER G WITH CIRCUMFLEX">&gcirc;</div>
            <div title="LATIN CAPITAL LETTER G WITH BREVE">&Gbreve;</div>
            <div title="LATIN SMALL LETTER G WITH BREVE">&gbreve;</div>
            <div title="LATIN CAPITAL LETTER G WITH DOT ABOVE">&Gdot;</div>
            <div title="LATIN SMALL LETTER G WITH DOT ABOVE">&gdot;</div>
            <div title="LATIN CAPITAL LETTER G WITH CEDILLA">&Gcedil;</div>
            <div title="LATIN SMALL LETTER G WITH CEDILLA">&#291;</div>
            <div title="LATIN CAPITAL LETTER H WITH CIRCUMFLEX">&Hcirc;</div>
            <div title="LATIN SMALL LETTER H WITH CIRCUMFLEX">&hcirc;</div>
            <div title="LATIN CAPITAL LETTER H WITH STROKE">&Hstrok;</div>
            <div title="LATIN SMALL LETTER H WITH STROKE">&hstrok;</div>
            <div title="LATIN CAPITAL LETTER I WITH TILDE">&Itilde;</div>
            <div title="LATIN SMALL LETTER I WITH TILDE">&itilde;</div>
            <div title="LATIN CAPITAL LETTER I WITH MACRON">&Imacr;</div>
            <div title="LATIN SMALL LETTER I WITH MACRON">&imacr;</div>
            <div title="LATIN CAPITAL LETTER I WITH BREVE">&#300;</div>
            <div title="LATIN SMALL LETTER I WITH BREVE">&#301;</div>
            <div title="LATIN CAPITAL LETTER I WITH OGONEK">&Iogon;</div>
            <div title="LATIN SMALL LETTER I WITH OGONEK">&iogon;</div>
            <div title="LATIN CAPITAL LETTER I WITH DOT ABOVE">&Idot;</div>
            <div title="LATIN SMALL LETTER DOTLESS I">&inodot;</div>
            <div title="LATIN CAPITAL LIGATURE IJ">&#306;</div>
            <div title="LATIN SMALL LIGATURE IJ">&ijlig;</div>
            <div title="LATIN CAPITAL LETTER J WITH CIRCUMFLEX">&Jcirc;</div>
            <div title="LATIN SMALL LETTER J WITH CIRCUMFLEX">&jcirc;</div>
            <div title="LATIN CAPITAL LETTER K WITH CEDILLA">&Kcedil;</div>
            <div title="LATIN SMALL LETTER K WITH CEDILLA">&#311;</div>
            <div title="LATIN SMALL LETTER KRA">&kgreen;</div>
            <div title="LATIN CAPITAL LETTER L WITH ACUTE">&Lacute;</div>
            <div title="LATIN SMALL LETTER L WITH ACUTE">&lacute;</div>
            <div title="LATIN CAPITAL LETTER L WITH CEDILLA">&Lcedil;</div>
            <div title="LATIN SMALL LETTER L WITH CEDILLA">&lcedil;</div>
            <div title="LATIN CAPITAL LETTER L WITH CARON">&Lcaron;</div>
            <div title="LATIN SMALL LETTER L WITH CARON">&lcaron;</div>
            <div title="LATIN CAPITAL LETTER L WITH MIDDLE DOT">&#319;</div>
            <div title="LATIN SMALL LETTER L WITH MIDDLE DOT">&lmidot;</div>
            <div title="LATIN CAPITAL LETTER L WITH STROKE">&Lstrok;</div>
            <div title="LATIN SMALL LETTER L WITH STROKE">&lstrok;</div>
            <div title="LATIN CAPITAL LETTER N WITH ACUTE">&Nacute;</div>
            <div title="LATIN SMALL LETTER N WITH ACUTE">&nacute;</div>
            <div title="LATIN CAPITAL LETTER N WITH CEDILLA">&Ncedil;</div>
            <div title="LATIN SMALL LETTER N WITH CEDILLA">&ncedil;</div>
            <div title="LATIN CAPITAL LETTER N WITH CARON">&Ncaron;</div>
            <div title="LATIN SMALL LETTER N WITH CARON">&ncaron;</div>
            <div title="LATIN SMALL LETTER N PRECEDED BY APOSTROPHE">&napos;</div>
            <div title="LATIN CAPITAL LETTER ENG">&ENG;</div>
            <div title="LATIN SMALL LETTER ENG">&eng;</div>
            <div title="LATIN CAPITAL LETTER O WITH MACRON">&Omacr;</div>
            <div title="LATIN SMALL LETTER O WITH MACRON">&omacr;</div>
            <div title="LATIN CAPITAL LETTER O WITH BREVE">&#334;</div>
            <div title="LATIN SMALL LETTER O WITH BREVE">&#335;</div>
            <div title="LATIN CAPITAL LETTER O WITH DOUBLE ACUTE">&Odblac;</div>
            <div title="LATIN SMALL LETTER O WITH DOUBLE ACUTE">&odblac;</div>
            <div title="LATIN CAPITAL LIGATURE OE">&OElig;</div>
            <div title="LATIN SMALL LIGATURE OE">&oelig;</div>
            <div title="LATIN CAPITAL LETTER R WITH ACUTE">&Racute;</div>
            <div title="LATIN SMALL LETTER R WITH ACUTE">&racute;</div>
            <div title="LATIN CAPITAL LETTER R WITH CEDILLA">&Rcedil;</div>
            <div title="LATIN SMALL LETTER R WITH CEDILLA">&rcedil;</div>
            <div title="LATIN CAPITAL LETTER R WITH CARON">&Rcaron;</div>
            <div title="LATIN SMALL LETTER R WITH CARON">&rcaron;</div>
            <div title="LATIN CAPITAL LETTER S WITH ACUTE">&Sacute;</div>
            <div title="LATIN SMALL LETTER S WITH ACUTE">&sacute;</div>
            <div title="LATIN CAPITAL LETTER S WITH CIRCUMFLEX">&Scirc;</div>
            <div title="LATIN SMALL LETTER S WITH CIRCUMFLEX">&scirc;</div>
            <div title="LATIN CAPITAL LETTER S WITH CEDILLA">&Scedil;</div>
            <div title="LATIN SMALL LETTER S WITH CEDILLA">&scedil;</div>
            <div title="LATIN CAPITAL LETTER S WITH CARON">&Scaron;</div>
            <div title="LATIN SMALL LETTER S WITH CARON">&scaron;</div>
            <div title="LATIN CAPITAL LETTER T WITH CEDILLA">&Tcedil;</div>
            <div title="LATIN SMALL LETTER T WITH CEDILLA">&tcedil;</div>
            <div title="LATIN CAPITAL LETTER T WITH CARON">&Tcaron;</div>
            <div title="LATIN SMALL LETTER T WITH CARON">&tcaron;</div>
            <div title="LATIN CAPITAL LETTER T WITH STROKE">&Tstrok;</div>
            <div title="LATIN SMALL LETTER T WITH STROKE">&tstrok;</div>
            <div title="LATIN CAPITAL LETTER U WITH TILDE">&Utilde;</div>
            <div title="LATIN SMALL LETTER U WITH TILDE">&utilde;</div>
            <div title="LATIN CAPITAL LETTER U WITH MACRON">&Umacr;</div>
            <div title="LATIN SMALL LETTER U WITH MACRON">&umacr;</div>
            <div title="LATIN CAPITAL LETTER U WITH BREVE">&Ubreve;</div>
            <div title="LATIN SMALL LETTER U WITH BREVE">&ubreve;</div>
            <div title="LATIN CAPITAL LETTER U WITH RING ABOVE">&Uring;</div>
            <div title="LATIN SMALL LETTER U WITH RING ABOVE">&uring;</div>
            <div title="LATIN CAPITAL LETTER U WITH DOUBLE ACUTE">&Udblac;</div>
            <div title="LATIN SMALL LETTER U WITH DOUBLE ACUTE">&udblac;</div>
            <div title="LATIN CAPITAL LETTER U WITH OGONEK">&Uogon;</div>
            <div title="LATIN SMALL LETTER U WITH OGONEK">&uogon;</div>
            <div title="LATIN CAPITAL LETTER W WITH CIRCUMFLEX">&Wcirc;</div>
            <div title="LATIN SMALL LETTER W WITH CIRCUMFLEX">&wcirc;</div>
            <div title="LATIN CAPITAL LETTER Y WITH CIRCUMFLEX">&Ycirc;</div>
            <div title="LATIN SMALL LETTER Y WITH CIRCUMFLEX">&ycirc;</div>
            <div title="LATIN CAPITAL LETTER Y WITH DIAERESIS">&Yuml;</div>
            <div title="LATIN CAPITAL LETTER Z WITH ACUTE">&Zacute;</div>
            <div title="LATIN SMALL LETTER Z WITH ACUTE">&zacute;</div>
            <div title="LATIN CAPITAL LETTER Z WITH DOT ABOVE">&Zdot;</div>
            <div title="LATIN SMALL LETTER Z WITH DOT ABOVE">&zdot;</div>
            <div title="LATIN CAPITAL LETTER Z WITH CARON">&Zcaron;</div>
            <div title="LATIN SMALL LETTER Z WITH CARON">&zcaron;</div>
            <div title="LATIN SMALL LETTER LONG S">&#383;</div>
            
        </div>
        
        <div id="divLatinExtendedB" class="tab-content container clearfix">
        
            <!-- Latin Extended B: https://www.w3schools.com/charsets/ref_utf_latin_extended_b.asp -->
            <div title="LATIN SMALL LETTER B WITH STROKE">&#384;</div>
            <div title="LATIN CAPITAL LETTER B WITH HOOK">&#385;</div>
            <div title="LATIN CAPITAL LETTER B WITH TOPBAR">&#386;</div>
            <div title="LATIN SMALL LETTER B WITH TOPBAR">&#387;</div>
            <div title="LATIN CAPITAL LETTER TONE SIX">&#388;</div>
            <div title="LATIN SMALL LETTER TONE SIX">&#389;</div>
            <div title="LATIN CAPITAL LETTER OPEN O">&#390;</div>
            <div title="LATIN CAPITAL LETTER C WITH HOOK">&#391;</div>
            <div title="LATIN SMALL LETTER C WITH HOOK">&#392;</div>
            <div title="LATIN CAPITAL LETTER AFRICAN D">&#393;</div>
            <div title="LATIN CAPITAL LETTER D WITH HOOK">&#394;</div>
            <div title="LATIN CAPITAL LETTER D WITH TOPBAR">&#395;</div>
            <div title="LATIN SMALL LETTER D WITH TOPBAR">&#396;</div>
            <div title="LATIN SMALL LETTER TURNED DELTA">&#397;</div>
            <div title="LATIN CAPITAL LETTER REVERSED E">&#398;</div>
            <div title="LATIN CAPITAL LETTER SCHWA">&#399;</div>
            <div title="LATIN CAPITAL LETTER OPEN E">&#400;</div>
            <div title="LATIN CAPITAL LETTER F WITH HOOK">&#401;</div>
            <div title="LATIN SMALL LETTER F WITH HOOK">&fnof;</div>
            <div title="LATIN CAPITAL LETTER G WITH HOOK">&#403;</div>
            <div title="LATIN CAPITAL LETTER GAMMA">&#404;</div>
            <div title="LATIN SMALL LETTER HV">&#405;</div>
            <div title="LATIN CAPITAL LETTER IOTA">&#406;</div>
            <div title="LATIN CAPITAL LETTER I WITH STROKE">&#407;</div>
            <div title="LATIN CAPITAL LETTER K WITH HOOK">&#408;</div>
            <div title="LATIN SMALL LETTER K WITH HOOK">&#409;</div>
            <div title="LATIN SMALL LETTER L WITH BAR">&#410;</div>
            <div title="LATIN SMALL LETTER LAMBDA WITH STROKE">&#411;</div>
            <div title="LATIN CAPITAL LETTER TURNED M">&#412;</div>
            <div title="LATIN CAPITAL LETTER N WITH LEFT HOOK">&#413;</div>
            <div title="LATIN SMALL LETTER N WITH LONG RIGHT LEG">&#414;</div>
            <div title="LATIN CAPITAL LETTER O WITH MIDDLE TILDE">&#415;</div>
            <div title="LATIN CAPITAL LETTER O WITH HORN">&#416;</div>
            <div title="LATIN SMALL LETTER O WITH HORN">&#417;</div>
            <div title="LATIN CAPITAL LETTER OI">&#418;</div>
            <div title="LATIN SMALL LETTER OI">&#419;</div>
            <div title="LATIN CAPITAL LETTER P WITH HOOK">&#420;</div>
            <div title="LATIN SMALL LETTER P WITH HOOK">&#421;</div>
            <div title="LATIN LETTER YR">&#422;</div>
            <div title="LATIN CAPITAL LETTER TONE TWO">&#423;</div>
            <div title="LATIN SMALL LETTER TONE TWO">&#424;</div>
            <div title="LATIN CAPITAL LETTER ESH">&#425;</div>
            <div title="LATIN LETTER REVERSED ESH LOOP">&#426;</div>
            <div title="LATIN SMALL LETTER T WITH PALATAL HOOK">&#427;</div>
            <div title="LATIN CAPITAL LETTER T WITH HOOK">&#428;</div>
            <div title="LATIN SMALL LETTER T WITH HOOK">&#429;</div>
            <div title="LATIN CAPITAL LETTER T WITH RETROFLEX HOOK">&#430;</div>
            <div title="LATIN CAPITAL LETTER U WITH HORN">&#431;</div>
            <div title="LATIN SMALL LETTER U WITH HORN">&#432;</div>
            <div title="LATIN CAPITAL LETTER UPSILON">&#433;</div>
            <div title="LATIN CAPITAL LETTER V WITH HOOK">&#434;</div>
            <div title="LATIN CAPITAL LETTER Y WITH HOOK">&#435;</div>
            <div title="LATIN SMALL LETTER Y WITH HOOK">&#436;</div>
            <div title="LATIN CAPITAL LETTER Z WITH STROKE">&imped;</div>
            <div title="LATIN SMALL LETTER Z WITH STROKE">&#438;</div>
            <div title="LATIN CAPITAL LETTER EZH">&#439;</div>
            <div title="LATIN CAPITAL LETTER EZH REVERSED">&#440;</div>
            <div title="LATIN SMALL LETTER EZH REVERSED">&#441;</div>
            <div title="LATIN SMALL LETTER EZH WITH TAIL">&#442;</div>
            <div title="LATIN LETTER TWO WITH STROKE">&#443;</div>
            <div title="LATIN CAPITAL LETTER TONE FIVE">&#444;</div>
            <div title="LATIN SMALL LETTER TONE FIVE">&#445;</div>
            <div title="LATIN LETTER INVERTED GLOTTAL STOP WITH STROKE">&#446;</div>
            <div title="LATIN LETTER WYNN">&#447;</div>
            <div title="LATIN LETTER DENTAL CLICK">&#448;</div>
            <div title="LATIN LETTER LATERAL CLICK">&#449;</div>
            <div title="LATIN LETTER ALVEOLAR CLICK">&#450;</div>
            <div title="LATIN LETTER RETROFLEX CLICK">&#451;</div>
            <div title="LATIN CAPITAL LETTER DZ WITH CARON">&#452;</div>
            <div title="LATIN CAPITAL LETTER D WITH SMALL LETTER Z WITH CARON">&#453;</div>
            <div title="LATIN SMALL LETTER DZ WITH CARON">&#454;</div>
            <div title="LATIN CAPITAL LETTER LJ">&#455;</div>
            <div title="LATIN CAPITAL LETTER L WITH SMALL LETTER J">&#456;</div>
            <div title="LATIN SMALL LETTER LJ">&#457;</div>
            <div title="LATIN CAPITAL LETTER NJ">&#458;</div>
            <div title="LATIN CAPITAL LETTER N WITH SMALL LETTER J">&#459;</div>
            <div title="LATIN SMALL LETTER NJ">&#460;</div>
            <div title="LATIN CAPITAL LETTER A WITH CARON">&#461;</div>
            <div title="LATIN SMALL LETTER A WITH CARON">&#462;</div>
            <div title="LATIN CAPITAL LETTER I WITH CARON">&#463;</div>
            <div title="LATIN SMALL LETTER I WITH CARON">&#464;</div>
            <div title="LATIN CAPITAL LETTER O WITH CARON">&#465;</div>
            <div title="LATIN SMALL LETTER O WITH CARON">&#466;</div>
            <div title="LATIN CAPITAL LETTER U WITH CARON">&#467;</div>
            <div title="LATIN SMALL LETTER U WITH CARON">&#468;</div>
            <div title="LATIN CAPITAL LETTER U WITH DIAERESIS AND MACRON">&#469;</div>
            <div title="LATIN SMALL LETTER U WITH DIAERESIS AND MACRON">&#470;</div>
            <div title="LATIN CAPITAL LETTER U WITH DIAERESIS AND ACUTE">&#471;</div>
            <div title="LATIN SMALL LETTER U WITH DIAERESIS AND ACUTE">&#472;</div>
            <div title="LATIN CAPITAL LETTER U WITH DIAERESIS AND CARON">&#473;</div>
            <div title="LATIN SMALL LETTER U WITH DIAERESIS AND CARON">&#474;</div>
            <div title="LATIN CAPITAL LETTER U WITH DIAERESIS AND GRAVE">&#475;</div>
            <div title="LATIN SMALL LETTER U WITH DIAERESIS AND GRAVE">&#476;</div>
            <div title="LATIN SMALL LETTER TURNED E">&#477;</div>
            <div title="LATIN CAPITAL LETTER A WITH DIAERESIS AND MACRON">&#478;</div>
            <div title="LATIN SMALL LETTER A WITH DIAERESIS AND MACRON">&#479;</div>
            <div title="LATIN CAPITAL LETTER A WITH DOT ABOVE AND MACRON">&#480;</div>
            <div title="LATIN SMALL LETTER A WITH DOT ABOVE AND MACRON">&#481;</div>
            <div title="LATIN CAPITAL LETTER AE WITH MACRON">&#482;</div>
            <div title="LATIN SMALL LETTER AE WITH MACRON">&#483;</div>
            <div title="LATIN CAPITAL LETTER G WITH STROKE">&#484;</div>
            <div title="LATIN SMALL LETTER G WITH STROKE">&#485;</div>
            <div title="LATIN CAPITAL LETTER G WITH CARON">&#486;</div>
            <div title="LATIN SMALL LETTER G WITH CARON">&#487;</div>
            <div title="LATIN CAPITAL LETTER K WITH CARON">&#488;</div>
            <div title="LATIN SMALL LETTER K WITH CARON">&#489;</div>
            <div title="LATIN CAPITAL LETTER O WITH OGONEK">&#490;</div>
            <div title="LATIN SMALL LETTER O WITH OGONEK">&#491;</div>
            <div title="LATIN CAPITAL LETTER O WITH OGONEK AND MACRON">&#492;</div>
            <div title="LATIN SMALL LETTER O WITH OGONEK AND MACRON">&#493;</div>
            <div title="LATIN CAPITAL LETTER EZH WITH CARON">&#494;</div>
            <div title="LATIN SMALL LETTER EZH WITH CARON">&#495;</div>
            <div title="LATIN SMALL LETTER J WITH CARON">&#496;</div>
            <div title="LATIN CAPITAL LETTER DZ">&#497;</div>
            <div title="LATIN CAPITAL LETTER D WITH SMALL LETTER Z">&#498;</div>
            <div title="LATIN SMALL LETTER DZ">&#499;</div>
            <div title="LATIN CAPITAL LETTER G WITH ACUTE">&#500;</div>
            <div title="LATIN SMALL LETTER G WITH ACUTE">&gacute;</div>
            <div title="LATIN CAPITAL LETTER HWAIR">&#502;</div>
            <div title="LATIN CAPITAL LETTER WYNN">&#503;</div>
            <div title="LATIN CAPITAL LETTER N WITH GRAVE">&#504;</div>
            <div title="LATIN SMALL LETTER N WITH GRAVE">&#505;</div>
            <div title="LATIN CAPITAL LETTER A WITH RING ABOVE AND ACUTE">&#506;</div>
            <div title="LATIN SMALL LETTER A WITH RING ABOVE AND ACUTE">&#507;</div>
            <div title="LATIN CAPITAL LETTER AE WITH ACUTE">&#508;</div>
            <div title="LATIN SMALL LETTER AE WITH ACUTE">&#509;</div>
            <div title="LATIN CAPITAL LETTER O WITH STROKE AND ACUTE">&#510;</div>
            <div title="LATIN SMALL LETTER O WITH STROKE AND ACUTE">&#511;</div>
            <div title="LATIN CAPITAL LETTER A WITH DOUBLE GRAVE">&#512;</div>
            <div title="LATIN SMALL LETTER A WITH DOUBLE GRAVE">&#513;</div>
            <div title="LATIN CAPITAL LETTER A WITH INVERTED BREVE">&#514;</div>
            <div title="LATIN SMALL LETTER A WITH INVERTED BREVE">&#515;</div>
            <div title="LATIN CAPITAL LETTER E WITH DOUBLE GRAVE">&#516;</div>
            <div title="LATIN SMALL LETTER E WITH DOUBLE GRAVE">&#517;</div>
            <div title="LATIN CAPITAL LETTER E WITH INVERTED BREVE">&#518;</div>
            <div title="LATIN SMALL LETTER E WITH INVERTED BREVE">&#519;</div>
            <div title="LATIN CAPITAL LETTER I WITH DOUBLE GRAVE">&#520;</div>
            <div title="LATIN SMALL LETTER I WITH DOUBLE GRAVE">&#521;</div>
            <div title="LATIN CAPITAL LETTER I WITH INVERTED BREVE">&#522;</div>
            <div title="LATIN SMALL LETTER I WITH INVERTED BREVE">&#523;</div>
            <div title="LATIN CAPITAL LETTER O WITH DOUBLE GRAVE">&#524;</div>
            <div title="LATIN SMALL LETTER O WITH DOUBLE GRAVE">&#525;</div>
            <div title="LATIN CAPITAL LETTER O WITH INVERTED BREVE">&#526;</div>
            <div title="LATIN SMALL LETTER O WITH INVERTED BREVE">&#527;</div>
            <div title="LATIN CAPITAL LETTER R WITH DOUBLE GRAVE">&#528;</div>
            <div title="LATIN SMALL LETTER R WITH DOUBLE GRAVE">&#529;</div>
            <div title="LATIN CAPITAL LETTER R WITH INVERTED BREVE">&#530;</div>
            <div title="LATIN SMALL LETTER R WITH INVERTED BREVE">&#531;</div>
            <div title="LATIN CAPITAL LETTER U WITH DOUBLE GRAVE">&#532;</div>
            <div title="LATIN SMALL LETTER U WITH DOUBLE GRAVE">&#533;</div>
            <div title="LATIN CAPITAL LETTER U WITH INVERTED BREVE">&#534;</div>
            <div title="LATIN SMALL LETTER U WITH INVERTED BREVE">&#535;</div>
            <div title="LATIN CAPITAL LETTER S WITH COMMA BELOW">&#536;</div>
            <div title="LATIN SMALL LETTER S WITH COMMA BELOW">&#537;</div>
            <div title="LATIN CAPITAL LETTER T WITH COMMA BELOW">&#538;</div>
            <div title="LATIN SMALL LETTER T WITH COMMA BELOW">&#539;</div>
            <div title="LATIN CAPITAL LETTER YOGH">&#540;</div>
            <div title="LATIN SMALL LETTER YOGH">&#541;</div>
            <div title="LATIN CAPITAL LETTER H WITH CARON">&#542;</div>
            <div title="LATIN SMALL LETTER H WITH CARON">&#543;</div>
            <div title="LATIN CAPITAL LETTER N WITH LONG RIGHT LEG">&#544;</div>
            <div title="LATIN SMALL LETTER N WITH LONG RIGHT LEG">&#545;</div>
            <div title="LATIN CAPITAL LETTER OU">&#546;</div>
            <div title="LATIN SMALL LETTER OU">&#547;</div>
            <div title="LATIN CAPITAL LETTER Z WITH HOOK">&#548;</div>
            <div title="LATIN SMALL LETTER Z WITH HOOK">&#549;</div>
            <div title="LATIN CAPITAL LETTER A WITH DOT ABOVE">&#550;</div>
            <div title="LATIN SMALL LETTER A WITH DOT ABOVE">&#551;</div>
            <div title="LATIN CAPITAL LETTER E WITH CEDILLA">&#552;</div>
            <div title="LATIN SMALL LETTER E WITH CEDILLA">&#553;</div>
            <div title="LATIN CAPITAL LETTER O WITH DIAERESIS AND MACRON">&#554;</div>
            <div title="LATIN SMALL LETTER O WITH DIAERESIS AND MACRON">&#555;</div>
            <div title="LATIN CAPITAL LETTER O WITH TILDE AND MACRON">&#556;</div>
            <div title="LATIN SMALL LETTER O WITH TILDE AND MACRON">&#557;</div>
            <div title="LATIN CAPITAL LETTER O WITH DOT ABOVE">&#558;</div>
            <div title="LATIN SMALL LETTER O WITH DOT ABOVE">&#559;</div>
            <div title="LATIN CAPITAL LETTER O WITH DOT ABOVE AND MACRON">&#560;</div>
            <div title="LATIN SMALL LETTER O WITH DOT ABOVE AND MACRON">&#561;</div>
            <div title="LATIN CAPITAL LETTER Y WITH MACRON">&#562;</div>
            <div title="LATIN SMALL LETTER Y WITH MACRON">&#563;</div>
            <div title="LATIN SMALL LETTER L WITH CURL">&#564;</div>
            <div title="LATIN SMALL LETTER N WITH CURL">&#565;</div>
            <div title="LATIN SMALL LETTER T WITH CURL">&#566;</div>
            <div title="LATIN SMALL LETTER DOTLESS J">&jmath;</div>
            <div title="LATIN SMALL LETTER DB DIGRAPH">&#568;</div>
            <div title="LATIN SMALL LETTER QP DIGRAPH">&#569;</div>
            <div title="LATIN CAPITAL LETTER A WITH STROKE">&#570;</div>
            <div title="LATIN CAPITAL LETTER C WITH STROKE">&#571;</div>
            <div title="LATIN SMALL LETTER C WITH STROKE">&#572;</div>
            <div title="LATIN CAPITAL LETTER L WITH BAR">&#573;</div>
            <div title="LATIN CAPITAL LETTER T WITH DIAGONAL STROKE">&#574;</div>
            <div title="LATIN SMALL LETTER S WITH SWASH TAIL">&#575;</div>
            <div title="LATIN SMALL LETTER Z WITH SWASH TAIL">&#576;</div>
            <div title="LATIN CAPITAL LETTER GLOTTAL STOP">&#577;</div>
            <div title="LATIN SMALL LETTER GLOTTAL STOP">&#578;</div>
            <div title="LATIN CAPITAL LETTER B WITH STROKE">&#579;</div>
            <div title="LATIN CAPITAL LETTER U BAR">&#580;</div>
            <div title="LATIN CAPITAL LETTER TURNED V">&#581;</div>
            <div title="LATIN CAPITAL LETTER E WITH STROKE">&#582;</div>
            <div title="LATIN SMALL LETTER E WITH STROKE">&#583;</div>
            <div title="LATIN CAPITAL LETTER J WITH STROKE">&#584;</div>
            <div title="LATIN SMALL LETTER J WITH STROKE">&#585;</div>
            <div title="LATIN CAPITAL LETTER SMALL Q WITH HOOK TAIL">&#586;</div>
            <div title="LATIN SMALL LETTER Q WITH HOOK TAIL">&#587;</div>
            <div title="LATIN CAPITAL LETTER R WITH STROKE">&#588;</div>
            <div title="LATIN SMALL LETTER R WITH STROKE">&#589;</div>
            <div title="LATIN CAPITAL LETTER Y WITH STROKE">&#590;</div>
            <div title="LATIN SMALL LETTER Y WITH STROKE">&#591;</div>
        </div>
        
        <div id="divLatinBasic" class="tab-content container clearfix">
            
            <!-- Latin Basic: https://www.w3schools.com/charsets/ref_utf_basic_latin.asp -->
            <!--<div>&#32;</div>-->
            <div title="EXCLAMATION MARK">&#33;</div>
            <div title="QUOTATION MARK">&quot;</div>
            <div title="NUMBER SIGN">&#35;</div>
            <div title="DOLLAR SIGN">&#36;</div>
            <div title="PERCENT SIGN">&#37;</div>
            <div title="AMPERSAND">&amp;</div>
            <div title="APOSTROPHE">&#39;</div>
            <div title="LEFT PARENTHESIS">&#40;</div>
            <div title="RIGHT PARENTHESIS">&#41;</div>
            <div title="ASTERISK">&#42;</div>
            <div title="PLUS SIGN">&#43;</div>
            <div title="COMMA">&#44;</div>
            <div title="HYPHEN-MINUS">&#45;</div>
            <div title="FULL STOP">&#46;</div>
            <div title="SOLIDUS">&#47;</div>
            <div title="DIGIT ZERO">&#48;</div>
            <div title="DIGIT ONE">&#49;</div>
            <div title="DIGIT TWO">&#50;</div>
            <div title="DIGIT THREE">&#51;</div>
            <div title="DIGIT FOUR">&#52;</div>
            <div title="DIGIT FIVE">&#53;</div>
            <div title="DIGIT SIX">&#54;</div>
            <div title="DIGIT SEVEN">&#55;</div>
            <div title="DIGIT EIGHT">&#56;</div>
            <div title="DIGIT NINE">&#57;</div>
            <div title="COLON">&#58;</div>
            <div title="SEMICOLON">&#59;</div>
            <div title="LESS-THAN SIGN">&lt;</div>
            <div title="EQUALS SIGN">&#61;</div>
            <div title="GREATER-THAN SIGN">&gt;</div>
            <div title="QUESTION MARK">&#63;</div>
            <div title="COMMERCIAL AT">&#64;</div>
            <div title="LATIN CAPITAL LETTER A">&#65;</div>
            <div title="LATIN CAPITAL LETTER B">&#66;</div>
            <div title="LATIN CAPITAL LETTER C">&#67;</div>
            <div title="LATIN CAPITAL LETTER D">&#68;</div>
            <div title="LATIN CAPITAL LETTER E">&#69;</div>
            <div title="LATIN CAPITAL LETTER F">&#70;</div>
            <div title="LATIN CAPITAL LETTER G">&#71;</div>
            <div title="LATIN CAPITAL LETTER H">&#72;</div>
            <div title="LATIN CAPITAL LETTER I">&#73;</div>
            <div title="LATIN CAPITAL LETTER J">&#74;</div>
            <div title="LATIN CAPITAL LETTER K">&#75;</div>
            <div title="LATIN CAPITAL LETTER L">&#76;</div>
            <div title="LATIN CAPITAL LETTER M">&#77;</div>
            <div title="LATIN CAPITAL LETTER N">&#78;</div>
            <div title="LATIN CAPITAL LETTER O">&#79;</div>
            <div title="LATIN CAPITAL LETTER P">&#80;</div>
            <div title="LATIN CAPITAL LETTER Q">&#81;</div>
            <div title="LATIN CAPITAL LETTER R">&#82;</div>
            <div title="LATIN CAPITAL LETTER S">&#83;</div>
            <div title="LATIN CAPITAL LETTER T">&#84;</div>
            <div title="LATIN CAPITAL LETTER U">&#85;</div>
            <div title="LATIN CAPITAL LETTER V">&#86;</div>
            <div title="LATIN CAPITAL LETTER W">&#87;</div>
            <div title="LATIN CAPITAL LETTER X">&#88;</div>
            <div title="LATIN CAPITAL LETTER Y">&#89;</div>
            <div title="LATIN CAPITAL LETTER Z">&#90;</div>
            <div title="LEFT SQUARE BRACKET">&#91;</div>
            <div title="REVERSE SOLIDUS">&#92;</div>
            <div title="RIGHT SQUARE BRACKET">&#93;</div>
            <div title="CIRCUMFLEX ACCENT">&#94;</div>
            <div title="LOW LINE">&#95;</div>
            <div title="GRAVE ACCENT">&#96;</div>
            <div title="LATIN SMALL LETTER A">&#97;</div>
            <div title="LATIN SMALL LETTER B">&#98;</div>
            <div title="LATIN SMALL LETTER C">&#99;</div>
            <div title="LATIN SMALL LETTER D">&#100;</div>
            <div title="LATIN SMALL LETTER E">&#101;</div>
            <div title="LATIN SMALL LETTER F">&#102;</div>
            <div title="LATIN SMALL LETTER G">&#103;</div>
            <div title="LATIN SMALL LETTER H">&#104;</div>
            <div title="LATIN SMALL LETTER I">&#105;</div>
            <div title="LATIN SMALL LETTER J">&#106;</div>
            <div title="LATIN SMALL LETTER K">&#107;</div>
            <div title="LATIN SMALL LETTER L">&#108;</div>
            <div title="LATIN SMALL LETTER M">&#109;</div>
            <div title="LATIN SMALL LETTER N">&#110;</div>
            <div title="LATIN SMALL LETTER O">&#111;</div>
            <div title="LATIN SMALL LETTER P">&#112;</div>
            <div title="LATIN SMALL LETTER Q">&#113;</div>
            <div title="LATIN SMALL LETTER R">&#114;</div>
            <div title="LATIN SMALL LETTER S">&#115;</div>
            <div title="LATIN SMALL LETTER T">&#116;</div>
            <div title="LATIN SMALL LETTER U">&#117;</div>
            <div title="LATIN SMALL LETTER V">&#118;</div>
            <div title="LATIN SMALL LETTER W">&#119;</div>
            <div title="LATIN SMALL LETTER X">&#120;</div>
            <div title="LATIN SMALL LETTER Y">&#121;</div>
            <div title="LATIN SMALL LETTER Z">&#122;</div>
            <div title="LEFT CURLY BRACKET">&#123;</div>
            <div title="VERTICAL LINE">&#124;</div>
            <div title="RIGHT CURLY BRACKET">&#125;</div>
            <div title="TILDE">&#126;</div>
        </div>
        
        <div id="divLatinSupplement" class="tab-content container clearfix">
        
            <!-- Latin Supplement: https://www.w3schools.com/charsets/ref_utf_latin1_supplement.asp -->
            <div title="NO-BREAK SPACE">&nbsp;</div>
            <div title="INVERTED EXCLAMATION MARK">&iexcl;</div>
            <div title="CENT SIGN">&cent;</div>
            <div title="POUND SIGN">&pound;</div>
            <div title="CURRENCY SIGN">&curren;</div>
            <div title="YEN SIGN">&yen;</div>
            <div title="BROKEN BAR">&brvbar;</div>
            <div title="SECTION SIGN">&sect;</div>
            <div title="DIAERESIS">&uml;</div>
            <div title="COPYRIGHT SIGN">&copy;</div>
            <div title="FEMININE ORDINAL INDICATOR">&ordf;</div>
            <div title="LEFT-POINTING DOUBLE ANGLE QUOTATION MARK">&laquo;</div>
            <div title="NOT SIGN">&not;</div>
            <div title="SOFT HYPHEN">&shy;</div>
            <div title="REGISTERED SIGN">&reg;</div>
            <div title="MACRON">&macr;</div>
            <div title="DEGREE SIGN">&deg;</div>
            <div title="PLUS-MINUS SIGN">&plusmn;</div>
            <div title="SUPERSCRIPT TWO">&sup2;</div>
            <div title="SUPERSCRIPT THREE">&sup3;</div>
            <div title="ACUTE ACCENT">&acute;</div>
            <div title="MICRO SIGN">&micro;</div>
            <div title="PILCROW SIGN">&para;</div>
            <div title="MIDDLE DOT">&middot;</div>
            <div title="CEDILLA">&cedil;</div>
            <div title="SUPERSCRIPT ONE">&sup1;</div>
            <div title="MASCULINE ORDINAL INDICATOR">&ordm;</div>
            <div title="RIGHT-POINTING DOUBLE ANGLE QUOTATION MARK">&raquo;</div>
            <div title="VULGAR FRACTION ONE QUARTER">&frac14;</div>
            <div title="VULGAR FRACTION ONE HALF">&frac12;</div>
            <div title="VULGAR FRACTION THREE QUARTERS">&frac34;</div>
            <div title="INVERTED QUESTION MARK">&iquest;</div>
            <div title="LATIN CAPITAL LETTER A WITH GRAVE">&Agrave;</div>
            <div title="LATIN CAPITAL LETTER A WITH ACUTE">&Aacute;</div>
            <div title="LATIN CAPITAL LETTER A WITH CIRCUMFLEX">&Acirc;</div>
            <div title="LATIN CAPITAL LETTER A WITH TILDE">&Atilde;</div>
            <div title="LATIN CAPITAL LETTER A WITH DIAERESIS">&Auml;</div>
            <div title="LATIN CAPITAL LETTER A WITH RING ABOVE">&Aring;</div>
            <div title="LATIN CAPITAL LETTER AE">&AElig;</div>
            <div title="LATIN CAPITAL LETTER C WITH CEDILLA">&Ccedil;</div>
            <div title="LATIN CAPITAL LETTER E WITH GRAVE">&Egrave;</div>
            <div title="LATIN CAPITAL LETTER E WITH ACUTE">&Eacute;</div>
            <div title="LATIN CAPITAL LETTER E WITH CIRCUMFLEX">&Ecirc;</div>
            <div title="LATIN CAPITAL LETTER E WITH DIAERESIS">&Euml;</div>
            <div title="LATIN CAPITAL LETTER I WITH GRAVE">&Igrave;</div>
            <div title="LATIN CAPITAL LETTER I WITH ACUTE">&Iacute;</div>
            <div title="LATIN CAPITAL LETTER I WITH CIRCUMFLEX">&Icirc;</div>
            <div title="LATIN CAPITAL LETTER I WITH DIAERESIS">&Iuml;</div>
            <div title="LATIN CAPITAL LETTER ETH">&ETH;</div>
            <div title="LATIN CAPITAL LETTER N WITH TILDE">&Ntilde;</div>
            <div title="LATIN CAPITAL LETTER O WITH GRAVE">&Ograve;</div>
            <div title="LATIN CAPITAL LETTER O WITH ACUTE">&Oacute;</div>
            <div title="LATIN CAPITAL LETTER O WITH CIRCUMFLEX">&Ocirc;</div>
            <div title="LATIN CAPITAL LETTER O WITH TILDE">&Otilde;</div>
            <div title="LATIN CAPITAL LETTER O WITH DIAERESIS">&Ouml;</div>
            <div title="MULTIPLICATION SIGN">&times;</div>
            <div title="LATIN CAPITAL LETTER O WITH STROKE">&Oslash;</div>
            <div title="LATIN CAPITAL LETTER U WITH GRAVE">&Ugrave;</div>
            <div title="LATIN CAPITAL LETTER U WITH ACUTE">&Uacute;</div>
            <div title="LATIN CAPITAL LETTER U WITH CIRCUMFLEX">&Ucirc;</div>
            <div title="LATIN CAPITAL LETTER U WITH DIAERESIS">&Uuml;</div>
            <div title="LATIN CAPITAL LETTER Y WITH ACUTE">&Yacute;</div>
            <div title="LATIN CAPITAL LETTER THORN">&THORN;</div>
            <div title="LATIN SMALL LETTER SHARP S">&szlig;</div>
            <div title="LATIN SMALL LETTER A WITH GRAVE">&agrave;</div>
            <div title="LATIN SMALL LETTER A WITH ACUTE">&aacute;</div>
            <div title="LATIN SMALL LETTER A WITH CIRCUMFLEX">&acirc;</div>
            <div title="LATIN SMALL LETTER A WITH TILDE">&atilde;</div>
            <div title="LATIN SMALL LETTER A WITH DIAERESIS">&auml;</div>
            <div title="LATIN SMALL LETTER A WITH RING ABOVE">&aring;</div>
            <div title="LATIN SMALL LETTER AE">&aelig;</div>
            <div title="LATIN SMALL LETTER C WITH CEDILLA">&ccedil;</div>
            <div title="LATIN SMALL LETTER E WITH GRAVE">&egrave;</div>
            <div title="LATIN SMALL LETTER E WITH ACUTE">&eacute;</div>
            <div title="LATIN SMALL LETTER E WITH CIRCUMFLEX">&ecirc;</div>
            <div title="LATIN SMALL LETTER E WITH DIAERESIS">&euml;</div>
            <div title="LATIN SMALL LETTER I WITH GRAVE">&igrave;</div>
            <div title="LATIN SMALL LETTER I WITH ACUTE">&iacute;</div>
            <div title="LATIN SMALL LETTER I WITH CIRCUMFLEX">&icirc;</div>
            <div title="LATIN SMALL LETTER I WITH DIAERESIS">&iuml;</div>
            <div title="LATIN SMALL LETTER ETH">&eth;</div>
            <div title="LATIN SMALL LETTER N WITH TILDE">&ntilde;</div>
            <div title="LATIN SMALL LETTER O WITH GRAVE">&ograve;</div>
            <div title="LATIN SMALL LETTER O WITH ACUTE">&oacute;</div>
            <div title="LATIN SMALL LETTER O WITH CIRCUMFLEX">&ocirc;</div>
            <div title="LATIN SMALL LETTER O WITH TILDE">&otilde;</div>
            <div title="LATIN SMALL LETTER O WITH DIAERESIS">&ouml;</div>
            <div title="DIVISION SIGN">&divide;</div>
            <div title="LATIN SMALL LETTER O WITH STROKE">&oslash;</div>
            <div title="LATIN SMALL LETTER U WITH GRAVE">&ugrave;</div>
            <div title="LATIN SMALL LETTER U WITH ACUTE">&uacute;</div>
            <div title="LATIN SMALL LETTER U WITH CIRCUMFLEX">&ucirc;</div>
            <div title="LATIN SMALL LETTER U WITH DIAERESIS">&uuml;</div>
            <div title="LATIN SMALL LETTER Y WITH ACUTE">&yacute;</div>
            <div title="LATIN SMALL LETTER THORN">&thorn;</div>
            <div title="LATIN SMALL LETTER Y WITH DIAERESIS">&yuml;</div>
        </div>
        
        <div id="divModifierLetters" class="tab-content container clearfix">
        
            <!-- Modifier Letters: https://www.w3schools.com/charsets/ref_utf_modifiers.asp -->
            <div title="MODIFIER LETTER SMALL H">&#688;</div>
            <div title="MODIFIER LETTER SMALL H WITH HOOK">&#689;</div>
            <div title="MODIFIER LETTER SMALL J">&#690;</div>
            <div title="MODIFIER LETTER SMALL R">&#691;</div>
            <div title="MODIFIER LETTER SMALL TURNED R">&#692;</div>
            <div title="MODIFIER LETTER SMALL TURNED R WITH HOOK">&#693;</div>
            <div title="MODIFIER LETTER SMALL CAPITAL INVERTED R">&#694;</div>
            <div title="MODIFIER LETTER SMALL W">&#695;</div>
            <div title="MODIFIER LETTER SMALL Y">&#696;</div>
            <div title="MODIFIER LETTER PRIME">&#697;</div>
            <div title="MODIFIER LETTER DOUBLE PRIME">&#698;</div>
            <div title="MODIFIER LETTER TURNED COMMA">&#699;</div>
            <div title="MODIFIER LETTER APOSTROPHE">&#700;</div>
            <div title="MODIFIER LETTER REVERSED COMMA">&#701;</div>
            <div title="MODIFIER LETTER RIGHT HALF RING">&#702;</div>
            <div title="MODIFIER LETTER LEFT HALF RING">&#703;</div>
            <div title="MODIFIER LETTER GLOTTAL STOP">&#704;</div>
            <div title="MODIFIER LETTER REVERSED GLOTTAL STOP">&#705;</div>
            <div title="MODIFIER LETTER LEFT ARROWHEAD">&#706;</div>
            <div title="MODIFIER LETTER RIGHT ARROWHEAD">&#707;</div>
            <div title="MODIFIER LETTER UP ARROWHEAD">&#708;</div>
            <div title="MODIFIER LETTER DOWN ARROWHEAD">&#709;</div>
            <div title="MODIFIER LETTER CIRCUMFLEX ACCENT">&circ;</div>
            <div title="CARON">&#711;</div>
            <div title="MODIFIER LETTER VERTICAL LINE">&#712;</div>
            <div title="MODIFIER LETTER MACRON">&#713;</div>
            <div title="MODIFIER LETTER ACUTE ACCENT">&#714;</div>
            <div title="MODIFIER LETTER GRAVE ACCENT">&#715;</div>
            <div title="MODIFIER LETTER LOW VERTICAL LINE">&#716;</div>
            <div title="MODIFIER LETTER LOW MACRON">&#717;</div>
            <div title="MODIFIER LETTER LOW GRAVE ACCENT">&#718;</div>
            <div title="MODIFIER LETTER LOW ACUTE ACCENT">&#719;</div>
            <div title="MODIFIER LETTER TRIANGULAR COLON">&#720;</div>
            <div title="MODIFIER LETTER HALF TRIANGULAR COLON">&#721;</div>
            <div title="MODIFIER LETTER CENTRED RIGHT HALF RING">&#722;</div>
            <div title="MODIFIER LETTER CENTRED LEFT HALF RING">&#723;</div>
            <div title="MODIFIER LETTER UP TACK">&#724;</div>
            <div title="MODIFIER LETTER DOWN TACK">&#725;</div>
            <div title="MODIFIER LETTER PLUS SIGN">&#726;</div>
            <div title="MODIFIER LETTER MINUS SIGN">&#727;</div>
            <div title="BREVE">&#728;</div>
            <div title="DOT ABOVE">&#729;</div>
            <div title="RING ABOVE">&#730;</div>
            <div title="OGONEK">&#731;</div>
            <div title="SMALL TILDE">&tilde;</div>
            <div title="DOUBLE ACUTE ACCENT">&#733;</div>
            <div title="MODIFIER LETTER RHOTIC HOOK">&#734;</div>
            <div title="MODIFIER LETTER CROSS ACCENT">&#735;</div>
            <div title="MODIFIER LETTER SMALL GAMMA">&#736;</div>
            <div title="MODIFIER LETTER SMALL L">&#737;</div>
            <div title="MODIFIER LETTER SMALL S">&#738;</div>
            <div title="MODIFIER LETTER SMALL X">&#739;</div>
            <div title="MODIFIER LETTER SMALL REVERSED GLOTTAL STOP">&#740;</div>
            <div title="MODIFIER LETTER EXTRA-HIGH TONE BAR">&#741;</div>
            <div title="MODIFIER LETTER HIGH TONE BAR">&#742;</div>
            <div title="MODIFIER LETTER MID TONE BAR">&#743;</div>
            <div title="MODIFIER LETTER LOW TONE BAR">&#744;</div>
            <div title="MODIFIER LETTER EXTRA-LOW TONE BAR">&#745;</div>
            <div title="MODIFIER LETTER YIN DEPARTING TONE MARK">&#746;</div>
            <div title="MODIFIER LETTER YANG DEPARTING TONE MARK">&#747;</div>
            <div title="MODIFIER LETTER VOICING">&#748;</div>
            <div title="MODIFIER LETTER UNASPIRATED">&#749;</div>
            <div title="MODIFIER LETTER DOUBLE APOSTROPHE">&#750;</div>
            <div title="MODIFIER LETTER LOW DOWN ARROWHEAD">&#751;</div>
            <div title="MODIFIER LETTER LOW UP ARROWHEAD">&#752;</div>
            <div title="MODIFIER LETTER LOW LEFT ARROWHEAD">&#753;</div>
            <div title="MODIFIER LETTER LOW RIGHT ARROWHEAD">&#754;</div>
            <div title="MODIFIER LETTER LOW RING">&#755;</div>
            <div title="MODIFIER LETTER MIDDLE GRAVE ACCENT">&#756;</div>
            <div title="MODIFIER LETTER MIDDLE DOUBLE GRAVE ACCENT">&#757;</div>
            <div title="MODIFIER LETTER MIDDLE DOUBLE ACUTE ACCENT">&#758;</div>
            <div title="MODIFIER LETTER LOW TILDE">&#759;</div>
            <div title="MODIFIER LETTER RAISED COLON">&#760;</div>
            <div title="MODIFIER LETTER BEGIN HIGH TONE">&#761;</div>
            <div title="MODIFIER LETTER END HIGH TONE">&#762;</div>
            <div title="MODIFIER LETTER BEGIN LOW TONE">&#763;</div>
            <div title="MODIFIER LETTER END LOW TONE">&#764;</div>
            <div title="MODIFIER LETTER SHELF">&#765;</div>
            <div title="MODIFIER LETTER OPEN SHELF">&#766;</div>
            <div title="MODIFIER LETTER LOW LEFT ARROW">&#767;</div>
        </div>
            
        <div id="divCyrillicSupplement" class="tab-content container clearfix">
        
            <!-- Cyrillic Supplement: https://www.w3schools.com/charsets/ref_utf_cyrillic_supplement.asp -->
            <div title="CYRILLIC CAPITAL LETTER KOMI DE">&#1280;</div>
            <div title="CYRILLIC SMALL LETTER KOMI DE">&#1281;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI DJE">&#1282;</div>
            <div title="CYRILLIC SMALL LETTER KOMI DJE">&#1283;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI ZJE">&#1284;</div>
            <div title="CYRILLIC SMALL LETTER KOMI ZJE">&#1285;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI DZJE">&#1286;</div>
            <div title="CYRILLIC SMALL LETTER KOMI DZJE">&#1287;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI LJE">&#1288;</div>
            <div title="CYRILLIC SMALL LETTER KOMI LJE">&#1289;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI NJE">&#1290;</div>
            <div title="CYRILLIC SMALL LETTER KOMI NJE">&#1291;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI SJE">&#1292;</div>
            <div title="CYRILLIC SMALL LETTER KOMI SJE">&#1293;</div>
            <div title="CYRILLIC CAPITAL LETTER KOMI TJE">&#1294;</div>
            <div title="CYRILLIC SMALL LETTER KOMI TJE">&#1295;</div>
            <!--<div>&#1296;</div>
            <div>&#1297;</div>
            <div>&#1298;</div>
            <div>&#1299;</div>-->
            <div title="CYRILLIC CAPITAL LETTER LHA">&#1300;</div>
            <div title="CYRILLIC SMALL LETTER LHA">&#1301;</div>
            <div title="CYRILLIC CAPITAL LETTER RHA">&#1302;</div>
            <div title="CYRILLIC SMALL LETTER RHA">&#1303;</div>
            <div title="CYRILLIC CAPITAL LETTER YAE">&#1304;</div>
            <div title="CYRILLIC SMALL LETTER YAE">&#1305;</div>
            <div title="CYRILLIC CAPITAL LETTER QA">&#1306;</div>
            <div title="CYRILLIC SMALL LETTER QA">&#1307;</div>
            <div title="CYRILLIC CAPITAL LETTER WE">&#1308;</div>
            <div title="CYRILLIC SMALL LETTER WE">&#1309;</div>
            <div title="CYRILLIC CAPITAL LETTER ALEUT KA">&#1310;</div>
            <div title="CYRILLIC SMALL LETTER ALEUT KA">&#1311;</div>
            <div title="CYRILLIC CAPITAL LETTER EL WITH MIDDLE HOOK">&#1312;</div>
            <div title="CYRILLIC SMALL LETTER EL WITH MIDDLE HOOK">&#1313;</div>
            <div title="CYRILLIC CAPITAL LETTER EN WITH MIDDLE HOOK">&#1314;</div>
            <div title="CYRILLIC SMALL LETTER EN WITH MIDDLE HOOK">&#1315;</div>
            <div title="CYRILLIC CAPITAL LETTER PE WITH DESCENDER">&#1316;</div>
            <div title="CYRILLIC SMALL LETTER PE WITH DESCENDER">&#1317;</div>
            <div title="CYRILLIC CAPITAL LETTER SHHA WITH DESCENDER">&#1318;</div>
            <div title="CYRILLIC SMALL LETTER SHHA WITH DESCENDER">&#1319;</div>
            <!--<div>&#1320;</div>
            <div>&#1321;</div>
            <div>&#1322;</div>
            <div>&#1323;</div>
            <div>&#1324;</div>
            <div>&#1325;</div>
            <div>&#1326;</div>
            <div>&#1327;</div>-->
            
        </div>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>
            jQuery(document).ready(function () {
            
                jQuery('html').on('click touchstart', function (e) {
                    if (jQuery(e.target).parents('#divTabsMore').length > 0) return;
                    
                    jQuery('#divTabsMore').css('display', 'none');
                });
        
                jQuery('.is-tabs a').on('click', function () {
        
                    if (jQuery(this).hasClass('active')) return false;
                    if (jQuery(this).is('#divMore')) return false;
                    
                    jQuery('#divTabsMore').css('display', 'none');
        
                    jQuery('.is-tabs-more > a').removeClass('active');
                    jQuery('.is-tabs > a').removeClass('active');
                    jQuery(this).addClass('active');
        
                    var id = jQuery(this).attr('data-content');
        
                    jQuery('.tab-content ').css('display', 'none');
                    jQuery('#' + id).css('display', 'block');
        
                    return false;
                });
        
                jQuery('.is-tabs-more a').click(function () {
        
                    if (jQuery(this).hasClass('active')) return false;
        
                    
                    jQuery('.is-tabs > a').removeClass('active');
                    jQuery('.is-tabs-more > a').removeClass('active');
                    jQuery(this).addClass('active');
        
                    var id = jQuery(this).attr('data-content');
        
                    jQuery('.tab-content ').css('display', 'none');
                    jQuery('#' + id).css('display', 'flex');
        
                    jQuery('.is-tabs-more ').css('display', 'none');
        
                    return false;
                });
        
                jQuery('#divMore').on('click', function (e) {
                    jQuery('#divTabsMore').css('display', 'block');
                });
        
                jQuery('.container > div').click(function () {
                    var s = jQuery(this).text();
                    parent._cb.pasteHtmlAtCaret(s, true);
                });
            });
        
        </script>
        </body>
        </html>
        
        `
        return html;
    }
    
    // _cb.addButton2('symbols', button, '.insertsymbol-button', function () {


    // });

})();