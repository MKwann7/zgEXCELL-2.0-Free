let other = [
    /* Slider */

    // Slider Module (Slick)
    {
        'thumbnail': 'preview/element-slider.png',
        'category': '120',
        'html':
            '<div class="row clearfix">' +
            '<div class="column full" data-noedit data-module="slider" data-module-desc="Slider" data-html="' +

            encodeURIComponent('<div id="{id}" class="slider-on-content" style="width:100%;height:500px;display:none">' +
                '<div class="is-boxes slider-image" style="background-image: url(\'assets/minimalist-blocks/images/slide1.jpg\');">' +
                '</div>' +
                '<div class="is-boxes slider-image" style="background-image: url(\'assets/minimalist-blocks/images/slide2.jpg\');">' +
                '</div>' +
                '<div class="is-boxes slider-image" style="background-image: url(\'assets/minimalist-blocks/images/slide3.jpg\');">' +
                '</div>' +
                '</div>' +
                '' +
                '<scr' + 'ipt>' +
                'var docReady = function (fn) {' +
                'var stateCheck = setInterval(function () {' +
                'if (document.readyState !== "complete") return;' +
                'clearInterval(stateCheck);' +
                'try { fn() } catch (e) { }' +
                '}, 1);' +
                '};' +
                'docReady(function () {' +
                'jQuery("#{id}").css("display","block");' +
                'jQuery("#{id}").slick({' +
                'dots: true,' +
                'arrows: true,' +
                'infinite: true,' +
                'speed: 500,' +
                'cssEase: "linear",' +
                'slidesToShow: 1,' +
                'autoplay: false,' +
                'autoplaySpeed: 3000,' +
                'fade: false,' +
                'adaptiveHeight: true,' +
                'responsive: [' +
                '{breakpoint: 480, settings: {arrows: false,slidesToShow: 1}}' +
                ']' +
                '});' +
                '});' +
                '</scr' + 'ipt>' +
                '') +

            '" data-settings="' +

            encodeURIComponent('[' +
                '{' +
                '"auto":false,' +
                '"arrow":true,' +
                '"dots":true,' +
                '"fade":false,' +
                '"height":"500",' +
                '"images":' +
                '[' +
                '{' +
                '"src": "assets/minimalist-blocks/images/slide1.jpg", ' +
                '"caption": "", "link": "", "width": "450", "align": "", "position": "bottom left"' +
                '},' +
                '{' +
                '"src": "assets/minimalist-blocks/images/slide2.jpg", ' +
                '"caption": "", "link": "", "width": "450", "align": "", "position": "bottom left"' +
                '},' +
                '{' +
                '"src": "assets/minimalist-blocks/images/slide3.jpg", ' +
                '"caption": "", "link": "", "width": "450", "align": "", "position": "bottom left"' +
                '}' +
                ']' +
                '}]') + '"' +

            '>' +

            '</div>' +
            '</div>'
    },

    // Slider Module (Glide) => Experimental
    {
        'thumbnail': 'preview/element-slider.png', 'glide': true,
        'category': '120',
        'html':
            '<div class="row clearfix">' +
            '<div class="column full" data-noedit data-module="slider-content" data-dialog-width="500px" data-module-desc="Slider" data-html="' +

            encodeURIComponent('' +
                '<svg width="0" height="0" style="position:absolute;display:none;">' +
                '<defs>' +
                '<symbol viewBox="0 0 512 512" id="ion-ios-arrow-left"><path d="M352 115.4L331.3 96 160 256l171.3 160 20.7-19.3L201.5 256z"></path></symbol>' +
                '<symbol viewBox="0 0 512 512" id="ion-ios-arrow-right"><path d="M160 115.4L180.7 96 352 256 180.7 416 160 396.7 310.5 256z"></path></symbol>' +
                '</defs>' +
                '</svg>' +
                '<div id="{id}" class="glide" style="display:none">' +
                '<div data-glide-el="track" class="glide__track">' +
                '<ul class="glide__slides">' +
                '<li class="glide__slide">' +
                '<div data-subblock><img data-image-embed data-noresize data-sync src="assets/minimalist-blocks/images/slide2.jpg" alt="" /></div>' +
                '<div class="is-slider-caption" style="left:4vw;bottom:4vw">Lorem Ipsum</div>' +
                '</li>' +
                '<li class="glide__slide">' +
                '<div data-subblock><img data-image-embed data-noresize data-sync src="assets/minimalist-blocks/images/slide3.jpg" alt="" /></div>' +
                '</li>' +
                '</ul>' +
                '</div>' +
                '' +
                '<div class="glide__arrows" data-glide-el="controls">' +
                '<button class="glide__arrow glide__arrow--left" data-glide-dir="<"><svg class="is-icon-flex"><use xlink:href="#ion-ios-arrow-left"></use></svg></button>' +
                '<button class="glide__arrow glide__arrow--right" data-glide-dir=">"><svg class="is-icon-flex"><use xlink:href="#ion-ios-arrow-right"></use></svg></button>' +
                '</div>' +
                '</div>' +
                '' +
                '<scr' + 'ipt>' +
                'var docReady = function (fn) {' +
                'var stateCheck = setInterval(function () {' +
                'if (document.readyState !== "complete") return;' +
                'clearInterval(stateCheck);' +
                'try { fn() } catch (e) { }' +
                '}, 1);' +
                '};' +
                'docReady(function () {' +
                'document.querySelector("#{id}").style.display="";' +
                'var _{id} = new Glide("#{id}", {' +
                'type: "carousel",' +
                'autoplay: false,' +
                'animationDuration: 1000,' +
                'gap: 0,' +
                'perView: 1,' +
                'hoverpause: true,' +
                'arrow: true,' +
                'dots: false,' +
                '}).mount();' +
                '_cleanClonedItems();' +
                '});' +
                'function _cleanClonedItems() {' +
                'var clones = document.querySelectorAll(".glide__slide--clone");' +
                'Array.prototype.forEach.call(clones, function(clone){' +
                'clone.removeAttribute("data-subblock");' +
                'clone.childNodes[0].removeAttribute("data-subblock");' +
                '});' +
                '}' +
                '' +
                '</scr' + 'ipt>' +
                '') +

            '" data-settings="' +

            encodeURIComponent('' +
                '{' +
                '"type": "carousel",' +
                '"autoplay":false,' +
                '"animationDuration":1000,' +
                '"gap":0,' +
                '"perView":1,' +
                '"hoverpause":true,' +
                '"arrow":true,' +
                '"dots":false' +
                '}') + '">' +

            '</div>' +
            '</div>'
    },

    /* Custom Code */
    {
        'thumbnail': 'preview/element-code.png',
        'category': '120',
        'html':
        '<div class="row clearfix">' +
        '<div class="column full" data-noedit data-html="' +

        encodeURIComponent('<h1 id="{id}">Lorem ipsum</h1>' +
            '<p>This is a code block. You can edit this block using the source dialog.</p>' +
            '<scr' + 'ipt>' +
            'var docReady = function (fn) {' +
            'var stateCheck = setInterval(function () {' +
            'if (document.readyState !== "complete") return;' +
            'clearInterval(stateCheck);' +
            'try{fn()}catch(e){}' +
            '}, 1);' +
            '};' +
            'docReady(function() {' +
            'document.querySelector(\'#{id}\').innerHTML =\'<b>Hello World..!</b>\';' +
            '});' +
            '</scr' + 'ipt>') +

        '">' +

        '</div>' +
        '</div>'
    }
]