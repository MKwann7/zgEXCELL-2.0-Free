/* v3.1 */
function _tabs(n) {
    var html = '';
    for (var i = 1; i <= n; i++) {
        html += '\t';
    }
    return '\n' + html;
}

// source: https: //stackoverflow.com/questions/2255689/how-to-get-the-file-path-of-the-currently-executing-javascript-code
function _path() {
    var scripts = document.querySelectorAll('script[src]');
    var currentScript = scripts[scripts.length - 1].src;
    var currentScriptChunks = currentScript.split('/');
    var currentScriptFile = currentScriptChunks[currentScriptChunks.length - 1];
    return currentScript.replace(currentScriptFile, '');
}
var _snippets_path = _path();

var data_basic = {
    'snippets': [

		{
		    'thumbnail': 'preview/basic-01.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
                        '<div class="display">' +
			    		'<h1>Beautiful Content. Responsive.</h1>' +
                		'<p><i>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</i></p>' +
                        '</div>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-02.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-03.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
			    		'<h1>Heading 1 Text Goes Here.</h1>' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-04.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
			    		'<h2>Heading 2 Text Goes Here.</h2>' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-05.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
						'<img src="assets/minimalist-blocks/images/oleg-laptev-545268-unsplash-VD7ll2.jpg" alt="">' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-06.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column half">' +
						'<img src="assets/minimalist-blocks/images/jon-lalin-731093-unsplash-(1)-tdmMt1.jpg" alt="">' +
					'</div>' +
					'<div class="column half">' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-07.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column half">' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
					'<div class="column half">' +
						'<img src="assets/minimalist-blocks/images/adam-birkett-209727-unsplash-(2)-H2BMm1.jpg" alt="">' +
					'</div>' +
				'</div>'
		},
		{
		    'thumbnail': 'preview/basic-08.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column half">' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
					'<div class="column half">' +
						'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-09.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
                        '<div class="display">' +
			    		'<h1>Lorem Ipsum is simply dummy text of the printing industry</h1>' +
                        '</div>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-10.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
                        '<div class="display">' +
                        '<p>This is a special report</p>' +
			    		'<h1>Lorem Ipsum is simply dummy text of the printing industry</h1>' +
                        '</div>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-11.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
			    		'<h2 class="size-48">Lorem Ipsum is simply dummy text</h2>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-12.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
			    		'<div class="spacer height-80"></div>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-13.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column full">' +
			    		'<hr>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-14.png',
		    'category': '120',
		    'html':
				'<div class="row clearfix">' +
					'<div class="column half">' +
						'<div class="list">' +
							'<i class="icon ion-checkmark"></i>' +
							'<h3>List Item</h3>' +
							'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>' +
						'</div>' +
					'</div>' +
					'<div class="column half">' +
						'<div class="list">' +
							'<i class="icon ion-checkmark"></i>' +
							'<h3>List Item</h3>' +
							'<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>' +
						'</div>' +
					'</div>' +
				'</div>'
		},

		{
		    'thumbnail': 'preview/basic-15.png',
		    'category': '120',
		    'html':
			    '<div class="is-social">' +
                    '<a href="https://twitter.com/"><i class="icon ion-social-twitter" style="margin-right: 1em"></i></a>' +
				    '\n<a href="https://www.facebook.com/"><i class="icon ion-social-facebook" style="margin-right: 1em"></i></a>' +
				    '\n<a href="mailto:you@example.com"><i class="icon ion-android-drafts"></i></a>' +
                '</div>'
		},

		{
		    'thumbnail': 'preview/basic-16.png',
		    'category': '120',
		    'html':
                '<div class="is-rounded-button-medium" style="margin:1em 0">' +
               	    '<a href="https://twitter.com/" style="background-color: #00bfff;"><i class="icon ion-social-twitter"></i></a>' +
               	    '<a href="https://www.facebook.com/" style="background-color: #128BDB"><i class="icon ion-social-facebook"></i></a>' +
               	    '<a href="mailto:you@example.com" style="background-color: #DF311F"><i class="icon ion-ios-email-outline"></i></a>' +
		        '</div>&nbsp;'
		},

		/* Video */
		{
		'thumbnail': 'preview/element-video.png',
		'category': '120',
		'html':
				'<div class="embed-responsive embed-responsive-16by9">' +
            		'<iframe width="560" height="315" src="https://www.youtube.com/embed/P5yHEKqx86U?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>' +
            	'</div>'
        },

        /* Map */
		{
		'thumbnail': 'preview/element-map.png',
		'category': '120',
		'html':
			    '<div class="embed-responsive embed-responsive-16by9">' +
            		'<iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" class="mg1" src="https://maps.google.com/maps?q=Melbourne,+Victoria,+Australia&amp;hl=en&amp;sll=-7.981898,112.626504&amp;sspn=0.009084,0.016512&amp;oq=melbourne&amp;hnear=Melbourne+Victoria,+Australia&amp;t=m&amp;z=10&amp;output=embed"></iframe>' +
            	'</div>'
        },


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

};

if(!(window.Glide||parent.Glide)){
    for (let i = 0; i < data_basic.snippets.length; i++) {
        if (data_basic.snippets[i].glide) {
            data_basic.snippets.splice(i, 1);
            break;
        }
    }
}

