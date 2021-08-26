/** @preserve
 jSignature v2 "${buildDate}" "${commitID}"
 Copyright (c) 2012 Willow Systems Corp http://willow-systems.com
 Copyright (c) 2010 Brinley Ang http://www.unbolt.net
 MIT License <http://www.opensource.org/licenses/mit-license.php>

 */
;(function() {

    var apinamespace = 'jSignature'

    /**
     Allows one to delay certain eventual action by setting up a timer for it and allowing one to delay it
     by "kick"ing it. Sorta like "kick the can down the road"

     @public
     @class
     @param
     @returns {Type}
     */
    var KickTimerClass = function(time, callback) {
        var timer
        this.kick = function() {
            clearTimeout(timer)
            timer = setTimeout(
                callback
                , time
            )
        }
        this.clear = function() {
            clearTimeout(timer)
        }
        return this
    }

    var PubSubClass = function(context){
        'use strict'
        /*  @preserve
        -----------------------------------------------------------------------------------------------
        JavaScript PubSub library
        2012 (c) Willow Systems Corp (www.willow-systems.com)
        based on Peter Higgins (dante@dojotoolkit.org)
        Loosely based on Dojo publish/subscribe API, limited in scope. Rewritten blindly.
        Original is (c) Dojo Foundation 2004-2010. Released under either AFL or new BSD, see:
        http://dojofoundation.org/license for more information.
        -----------------------------------------------------------------------------------------------
        */
        this.topics = {}
        // here we choose what will be "this" for the called events.
        // if context is defined, it's context. Else, 'this' is this instance of PubSub
        this.context = context ? context : this
        /**
         * Allows caller to emit an event and pass arguments to event listeners.
         * @public
         * @function
         * @param topic {String} Name of the channel on which to voice this event
         * @param **arguments Any number of arguments you want to pass to the listeners of this event.
         */
        this.publish = function(topic, arg1, arg2, etc) {
            'use strict'
            if (this.topics[topic]) {
                var currentTopic = this.topics[topic]
                    , args = Array.prototype.slice.call(arguments, 1)
                    , toremove = []
                    , fn
                    , i, l
                    , pair

                for (i = 0, l = currentTopic.length; i < l; i++) {
                    pair = currentTopic[i] // this is a [function, once_flag] array
                    fn = pair[0]
                    if (pair[1] /* 'run once' flag set */){
                        pair[0] = function(){}
                        toremove.push(i)
                    }
                    fn.apply(this.context, args)
                }
                for (i = 0, l = toremove.length; i < l; i++) {
                    currentTopic.splice(toremove[i], 1)
                }
            }
        }
        /**
         * Allows listener code to subscribe to channel and be called when data is available
         * @public
         * @function
         * @param topic {String} Name of the channel on which to voice this event
         * @param callback {Function} Executable (function pointer) that will be ran when event is voiced on this channel.
         * @param once {Boolean} (optional. False by default) Flag indicating if the function is to be triggered only once.
         * @returns {Object} A token object that cen be used for unsubscribing.
         */
        this.subscribe = function(topic, callback, once) {
            'use strict'
            if (!this.topics[topic]) {
                this.topics[topic] = [[callback, once]];
            } else {
                this.topics[topic].push([callback,once]);
            }
            return {
                "topic": topic,
                "callback": callback
            };
        };
        /**
         * Allows listener code to unsubscribe from a channel
         * @public
         * @function
         * @param token {Object} A token object that was returned by `subscribe` method
         */
        this.unsubscribe = function(token) {
            if (this.topics[token.topic]) {
                var currentTopic = this.topics[token.topic]

                for (var i = 0, l = currentTopic.length; i < l; i++) {
                    if (currentTopic[i][0] === token.callback) {
                        currentTopic.splice(i, 1)
                    }
                }
            }
        }
    }

/// Returns front, back and "decor" colors derived from element (as jQuery obj)
    function getColors($e){
        var tmp
            , undef
            , frontcolor = $e.css('color')
            , backcolor
            , e = $e[0]

        var toOfDOM = false
        while(e && !backcolor && !toOfDOM){
            try{
                tmp = $(e).css('background-color')
            } catch (ex) {
                tmp = 'transparent'
            }
            if (tmp !== 'transparent' && tmp !== 'rgba(0, 0, 0, 0)'){
                backcolor = tmp
            }
            toOfDOM = e.body
            e = e.parentNode
        }

        var rgbaregex = /rgb[a]*\((\d+),\s*(\d+),\s*(\d+)/ // modern browsers
            , hexregex = /#([AaBbCcDdEeFf\d]{2})([AaBbCcDdEeFf\d]{2})([AaBbCcDdEeFf\d]{2})/ // IE 8 and less.
            , frontcolorcomponents

        // Decomposing Front color into R, G, B ints
        tmp = undef
        tmp = frontcolor.match(rgbaregex)
        if (tmp){
            frontcolorcomponents = {'r':parseInt(tmp[1],10),'g':parseInt(tmp[2],10),'b':parseInt(tmp[3],10)}
        } else {
            tmp = frontcolor.match(hexregex)
            if (tmp) {
                frontcolorcomponents = {'r':parseInt(tmp[1],16),'g':parseInt(tmp[2],16),'b':parseInt(tmp[3],16)}
            }
        }
//		if(!frontcolorcomponents){
//			frontcolorcomponents = {'r':255,'g':255,'b':255}
//		}

        var backcolorcomponents
        // Decomposing back color into R, G, B ints
        if(!backcolor){
            // HIghly unlikely since this means that no background styling was applied to any element from here to top of dom.
            // we'll pick up back color from front color
            if(frontcolorcomponents){
                if (Math.max.apply(null, [frontcolorcomponents.r, frontcolorcomponents.g, frontcolorcomponents.b]) > 127){
                    backcolorcomponents = {'r':0,'g':0,'b':0}
                } else {
                    backcolorcomponents = {'r':255,'g':255,'b':255}
                }
            } else {
                // arg!!! front color is in format we don't understand (hsl, named colors)
                // Let's just go with white background.
                backcolorcomponents = {'r':255,'g':255,'b':255}
            }
        } else {
            tmp = undef
            tmp = backcolor.match(rgbaregex)
            if (tmp){
                backcolorcomponents = {'r':parseInt(tmp[1],10),'g':parseInt(tmp[2],10),'b':parseInt(tmp[3],10)}
            } else {
                tmp = backcolor.match(hexregex)
                if (tmp) {
                    backcolorcomponents = {'r':parseInt(tmp[1],16),'g':parseInt(tmp[2],16),'b':parseInt(tmp[3],16)}
                }
            }
//			if(!backcolorcomponents){
//				backcolorcomponents = {'r':0,'g':0,'b':0}
//			}
        }

        // Deriving Decor color
        // THis is LAZY!!!! Better way would be to use HSL and adjust luminocity. However, that could be an overkill.

        var toRGBfn = function(o){return 'rgb(' + [o.r, o.g, o.b].join(', ') + ')'}
            , decorcolorcomponents
            , frontcolorbrightness
            , adjusted

        if (frontcolorcomponents && backcolorcomponents){
            var backcolorbrightness = Math.max.apply(null, [frontcolorcomponents.r, frontcolorcomponents.g, frontcolorcomponents.b])

            frontcolorbrightness = Math.max.apply(null, [backcolorcomponents.r, backcolorcomponents.g, backcolorcomponents.b])
            adjusted = Math.round(frontcolorbrightness + (-1 * (frontcolorbrightness - backcolorbrightness) * 0.75)) // "dimming" the difference between pen and back.
            decorcolorcomponents = {'r':adjusted,'g':adjusted,'b':adjusted} // always shade of gray
        } else if (frontcolorcomponents) {
            frontcolorbrightness = Math.max.apply(null, [frontcolorcomponents.r, frontcolorcomponents.g, frontcolorcomponents.b])
            var polarity = +1
            if (frontcolorbrightness > 127){
                polarity = -1
            }
            // shifting by 25% (64 points on RGB scale)
            adjusted = Math.round(frontcolorbrightness + (polarity * 96)) // "dimming" the pen's color by 75% to get decor color.
            decorcolorcomponents = {'r':adjusted,'g':adjusted,'b':adjusted} // always shade of gray
        } else {
            decorcolorcomponents = {'r':191,'g':191,'b':191} // always shade of gray
        }

        return {
            'color': frontcolor
            , 'background-color': backcolorcomponents? toRGBfn(backcolorcomponents) : backcolor
            , 'decor-color': toRGBfn(decorcolorcomponents)
        }
    }

    function Vector(x,y){
        this.x = x
        this.y = y
        this.reverse = function(){
            return new this.constructor(
                this.x * -1
                , this.y * -1
            )
        }
        this._length = null
        this.getLength = function(){
            if (!this._length){
                this._length = Math.sqrt( Math.pow(this.x, 2) + Math.pow(this.y, 2) )
            }
            return this._length
        }

        var polarity = function (e){
            return Math.round(e / Math.abs(e))
        }
        this.resizeTo = function(length){
            // proportionally changes x,y such that the hypotenuse (vector length) is = new length
            if (this.x === 0 && this.y === 0){
                this._length = 0
            } else if (this.x === 0){
                this._length = length
                this.y = length * polarity(this.y)
            } else if(this.y === 0){
                this._length = length
                this.x = length * polarity(this.x)
            } else {
                var proportion = Math.abs(this.y / this.x)
                    , x = Math.sqrt(Math.pow(length, 2) / (1 + Math.pow(proportion, 2)))
                    , y = proportion * x
                this._length = length
                this.x = x * polarity(this.x)
                this.y = y * polarity(this.y)
            }
            return this
        }

        /**
         * Calculates the angle between 'this' vector and another.
         * @public
         * @function
         * @returns {Number} The angle between the two vectors as measured in PI.
         */
        this.angleTo = function(vectorB) {
            var divisor = this.getLength() * vectorB.getLength()
            if (divisor === 0) {
                return 0
            } else {
                // JavaScript floating point math is screwed up.
                // because of it, the core of the formula can, on occasion, have values
                // over 1.0 and below -1.0.
                return Math.acos(
                    Math.min(
                        Math.max(
                            ( this.x * vectorB.x + this.y * vectorB.y ) / divisor
                            , -1.0
                        )
                        , 1.0
                    )
                ) / Math.PI
            }
        }
    }

    function Point(x,y){
        this.x = x
        this.y = y

        this.getVectorToCoordinates = function (x, y) {
            return new Vector(x - this.x, y - this.y)
        }
        this.getVectorFromCoordinates = function (x, y) {
            return this.getVectorToCoordinates(x, y).reverse()
        }
        this.getVectorToPoint = function (point) {
            return new Vector(point.x - this.x, point.y - this.y)
        }
        this.getVectorFromPoint = function (point) {
            return this.getVectorToPoint(point).reverse()
        }
    }

    /*
     * About data structure:
     * We don't store / deal with "pictures" this signature capture code captures "vectors"
     *
     * We don't store bitmaps. We store "strokes" as arrays of arrays. (Actually, arrays of objects containing arrays of coordinates.
     *
     * Stroke = mousedown + mousemoved * n (+ mouseup but we don't record that as that was the "end / lack of movement" indicator)
     *
     * Vectors = not classical vectors where numbers indicated shift relative last position. Our vectors are actually coordinates against top left of canvas.
     * 			we could calc the classical vectors, but keeping the the actual coordinates allows us (through Math.max / min)
     * 			to calc the size of resulting drawing very quickly. If we want classical vectors later, we can always get them in backend code.
     *
     * So, the data structure:
     *
     * var data = [
     * 	{ // stroke starts
     * 		x : [101, 98, 57, 43] // x points
     * 		, y : [1, 23, 65, 87] // y points
     * 	} // stroke ends
     * 	, { // stroke starts
     * 		x : [55, 56, 57, 58] // x points
     * 		, y : [101, 97, 54, 4] // y points
     * 	} // stroke ends
     * 	, { // stroke consisting of just a dot
     * 		x : [53] // x points
     * 		, y : [151] // y points
     * 	} // stroke ends
     * ]
     *
     * we don't care or store stroke width (it's canvas-size-relative), color, shadow values. These can be added / changed on whim post-capture.
     *
     */
    function DataEngine(storageObject, context, startStrokeFn, addToStrokeFn, endStrokeFn){
        this.data = storageObject // we expect this to be an instance of Array
        this.context = context

        if (storageObject.length){
            // we have data to render
            var numofstrokes = storageObject.length
                , stroke
                , numofpoints

            for (var i = 0; i < numofstrokes; i++){
                stroke = storageObject[i]
                numofpoints = stroke.x.length
                startStrokeFn.call(context, stroke)
                for(var j = 1; j < numofpoints; j++){
                    addToStrokeFn.call(context, stroke, j)
                }
                endStrokeFn.call(context, stroke)
            }
        }

        this.changed = function(){}

        this.startStrokeFn = startStrokeFn
        this.addToStrokeFn = addToStrokeFn
        this.endStrokeFn = endStrokeFn

        this.inStroke = false

        this._lastPoint = null
        this._stroke = null
        this.startStroke = function(point){
            if(point && typeof(point.x) == "number" && typeof(point.y) == "number"){
                this._stroke = {'x':[point.x], 'y':[point.y]}
                this.data.push(this._stroke)
                this._lastPoint = point
                this.inStroke = true
                // 'this' does not work same inside setTimeout(
                var stroke = this._stroke
                    , fn = this.startStrokeFn
                    , context = this.context
                setTimeout(
                    // some IE's don't support passing args per setTimeout API. Have to create closure every time instead.
                    function() {fn.call(context, stroke)}
                    , 3
                )
                return point
            } else {
                return null
            }
        }
        // that "5" at the very end of this if is important to explain.
        // we do NOT render links between two captured points (in the middle of the stroke) if the distance is shorter than that number.
        // not only do we NOT render it, we also do NOT capture (add) these intermediate points to storage.
        // when clustering of these is too tight, it produces noise on the line, which, because of smoothing, makes lines too curvy.
        // maybe, later, we can expose this as a configurable setting of some sort.
        this.addToStroke = function(point){
            if (this.inStroke &&
                typeof(point.x) === "number" &&
                typeof(point.y) === "number" &&
                // calculates absolute shift in diagonal pixels away from original point
                (Math.abs(point.x - this._lastPoint.x) + Math.abs(point.y - this._lastPoint.y)) > 4
            ){
                var positionInStroke = this._stroke.x.length
                this._stroke.x.push(point.x)
                this._stroke.y.push(point.y)
                this._lastPoint = point

                var stroke = this._stroke
                    , fn = this.addToStrokeFn
                    , context = this.context
                setTimeout(
                    // some IE's don't support passing args per setTimeout API. Have to create closure every time instead.
                    function() {fn.call(context, stroke, positionInStroke)}
                    , 3
                )
                return point
            } else {
                return null
            }
        }
        this.endStroke = function(){
            var c = this.inStroke
            this.inStroke = false
            this._lastPoint = null
            if (c){
                var stroke = this._stroke
                    , fn = this.endStrokeFn // 'this' does not work same inside setTimeout(
                    , context = this.context
                    , changedfn = this.changed
                setTimeout(
                    // some IE's don't support passing args per setTimeout API. Have to create closure every time instead.
                    function(){
                        fn.call(context, stroke)
                        changedfn.call(context)
                    }
                    , 3
                )
                return true
            } else {
                return null
            }
        }
    }

    var basicDot = function(ctx, x, y, size){
        var fillStyle = ctx.fillStyle
        ctx.fillStyle = ctx.strokeStyle
        ctx.fillRect(x + size / -2 , y + size / -2, size, size)
        ctx.fillStyle = fillStyle
    }
        , basicLine = function(ctx, startx, starty, endx, endy){
        ctx.beginPath()
        ctx.moveTo(startx, starty)
        ctx.lineTo(endx, endy)
        ctx.stroke()
    }
        , basicCurve = function(ctx, startx, starty, endx, endy, cp1x, cp1y, cp2x, cp2y){
        ctx.beginPath()
        ctx.moveTo(startx, starty)
        ctx.bezierCurveTo(cp1x, cp1y, cp2x, cp2y, endx, endy)
        ctx.stroke()
    }
        , strokeStartCallback = function(stroke) {
        // this = jSignatureClass instance
        basicDot(this.canvasContext, stroke.x[0], stroke.y[0], this.settings.lineWidth)
    }
        , strokeAddCallback = function(stroke, positionInStroke){
        // this = jSignatureClass instance

        // Because we are funky this way, here we draw TWO curves.
        // 1. POSSIBLY "this line" - spanning from point right before us, to this latest point.
        // 2. POSSIBLY "prior curve" - spanning from "latest point" to the one before it.

        // Why you ask?
        // long lines (ones with many pixels between them) do not look good when they are part of a large curvy stroke.
        // You know, the jaggedy crocodile spine instead of a pretty, smooth curve. Yuck!
        // We want to approximate pretty curves in-place of those ugly lines.
        // To approximate a very nice curve we need to know the direction of line before and after.
        // Hence, on long lines we actually wait for another point beyond it to come back from
        // mousemoved before we draw this curve.

        // So for "prior curve" to be calc'ed we need 4 points
        // 	A, B, C, D (we are on D now, A is 3 points in the past.)
        // and 3 lines:
        //  pre-line (from points A to B),
        //  this line (from points B to C), (we call it "this" because if it was not yet, it's the only one we can draw for sure.)
        //  post-line (from points C to D) (even through D point is 'current' we don't know how we can draw it yet)
        //
        // Well, actually, we don't need to *know* the point A, just the vector A->B
        var Cpoint = new Point(stroke.x[positionInStroke-1], stroke.y[positionInStroke-1])
            , Dpoint = new Point(stroke.x[positionInStroke], stroke.y[positionInStroke])
            , CDvector = Cpoint.getVectorToPoint(Dpoint)

        // Again, we have a chance here to draw TWO things:
        //  BC Curve (only if it's long, because if it was short, it was drawn by previous callback) and
        //  CD Line (only if it's short)

        // So, let's start with BC curve.
        // if there is only 2 points in stroke array, we don't have "history" long enough to have point B, let alone point A.
        // Falling through to drawing line CD is proper, as that's the only line we have points for.
        if(positionInStroke > 1) {
            // we are here when there are at least 3 points in stroke array.
            var Bpoint = new Point(stroke.x[positionInStroke-2], stroke.y[positionInStroke-2])
                , BCvector = Bpoint.getVectorToPoint(Cpoint)
                , ABvector
            if(BCvector.getLength() > this.lineCurveThreshold){
                // Yey! Pretty curves, here we come!
                if(positionInStroke > 2) {
                    // we are here when at least 4 points in stroke array.
                    ABvector = (new Point(stroke.x[positionInStroke-3], stroke.y[positionInStroke-3])).getVectorToPoint(Bpoint)
                } else {
                    ABvector = new Vector(0,0)
                }

                var minlenfraction = 0.05
                    , maxlen = BCvector.getLength() * 0.35
                    , ABCangle = BCvector.angleTo(ABvector.reverse())
                    , BCDangle = CDvector.angleTo(BCvector.reverse())
                    , BCP1vector = new Vector(ABvector.x + BCvector.x, ABvector.y + BCvector.y).resizeTo(
                    Math.max(minlenfraction, ABCangle) * maxlen
                )
                    , CCP2vector = (new Vector(BCvector.x + CDvector.x, BCvector.y + CDvector.y)).reverse().resizeTo(
                    Math.max(minlenfraction, BCDangle) * maxlen
                )

                basicCurve(
                    this.canvasContext
                    , Bpoint.x
                    , Bpoint.y
                    , Cpoint.x
                    , Cpoint.y
                    , Bpoint.x + BCP1vector.x
                    , Bpoint.y + BCP1vector.y
                    , Cpoint.x + CCP2vector.x
                    , Cpoint.y + CCP2vector.y
                )
            }
        }
        if(CDvector.getLength() <= this.lineCurveThreshold){
            basicLine(
                this.canvasContext
                , Cpoint.x
                , Cpoint.y
                , Dpoint.x
                , Dpoint.y
            )
        }
    }
        , strokeEndCallback = function(stroke){
        // this = jSignatureClass instance

        // Here we tidy up things left unfinished in last strokeAddCallback run.

        // What's POTENTIALLY left unfinished there is the curve between the last points
        // in the stroke, if the len of that line is more than lineCurveThreshold
        // If the last line was shorter than lineCurveThreshold, it was drawn there, and there
        // is nothing for us here to do.
        // We can also be called when there is only one point in the stroke (meaning, the
        // stroke was just a dot), in which case, again, there is nothing for us to do.

        // So for "this curve" to be calc'ed we need 3 points
        // 	A, B, C
        // and 2 lines:
        //  pre-line (from points A to B),
        //  this line (from points B to C)
        // Well, actually, we don't need to *know* the point A, just the vector A->B
        // so, we really need points B, C and AB vector.
        var positionInStroke = stroke.x.length - 1

        if (positionInStroke > 0){
            // there are at least 2 points in the stroke.we are in business.
            var Cpoint = new Point(stroke.x[positionInStroke], stroke.y[positionInStroke])
                , Bpoint = new Point(stroke.x[positionInStroke-1], stroke.y[positionInStroke-1])
                , BCvector = Bpoint.getVectorToPoint(Cpoint)
                , ABvector
            if (BCvector.getLength() > this.lineCurveThreshold){
                // yep. This one was left undrawn in prior callback. Have to draw it now.
                if (positionInStroke > 1){
                    // we have at least 3 elems in stroke
                    ABvector = (new Point(stroke.x[positionInStroke-2], stroke.y[positionInStroke-2])).getVectorToPoint(Bpoint)
                    var BCP1vector = new Vector(ABvector.x + BCvector.x, ABvector.y + BCvector.y).resizeTo(BCvector.getLength() / 2)
                    basicCurve(
                        this.canvasContext
                        , Bpoint.x
                        , Bpoint.y
                        , Cpoint.x
                        , Cpoint.y
                        , Bpoint.x + BCP1vector.x
                        , Bpoint.y + BCP1vector.y
                        , Cpoint.x
                        , Cpoint.y
                    )
                } else {
                    // Since there is no AB leg, there is no curve to draw. This line is still "long" but no curve.
                    basicLine(
                        this.canvasContext
                        , Bpoint.x
                        , Bpoint.y
                        , Cpoint.x
                        , Cpoint.y
                    )
                }
            }
        }
    }


    /*
    var getDataStats = function(){
        var strokecnt = strokes.length
            , stroke
            , pointid
            , pointcnt
            , x, y
            , maxX = Number.NEGATIVE_INFINITY
            , maxY = Number.NEGATIVE_INFINITY
            , minX = Number.POSITIVE_INFINITY
            , minY = Number.POSITIVE_INFINITY
        for(strokeid = 0; strokeid < strokecnt; strokeid++){
            stroke = strokes[strokeid]
            pointcnt = stroke.length
            for(pointid = 0; pointid < pointcnt; pointid++){
                x = stroke.x[pointid]
                y = stroke.y[pointid]
                if (x > maxX){
                    maxX = x
                } else if (x < minX) {
                    minX = x
                }
                if (y > maxY){
                    maxY = y
                } else if (y < minY) {
                    minY = y
                }
            }
        }
        return {'maxX': maxX, 'minX': minX, 'maxY': maxY, 'minY': minY}
    }
    */

    function conditionallyLinkCanvasResizeToWindowResize(jSignatureInstance, settingsWidth, apinamespace, globalEvents){
        'use strict'
        if ( settingsWidth === 'ratio' || settingsWidth.split('')[settingsWidth.length - 1] === '%' ) {

            this.eventTokens[apinamespace + '.parentresized'] = globalEvents.subscribe(
                apinamespace + '.parentresized'
                , (function(eventTokens, $parent, originalParentWidth, sizeRatio){
                    'use strict'

                    return function(){
                        'use strict'

                        var w = $parent.width()
                        if (w !== originalParentWidth) {

                            // UNsubscribing this particular instance of signature pad only.
                            // there is a separate `eventTokens` per each instance of signature pad
                            for (var key in eventTokens){
                                if (eventTokens.hasOwnProperty(key)) {
                                    globalEvents.unsubscribe(eventTokens[key])
                                    delete eventTokens[key]
                                }
                            }

                            var settings = jSignatureInstance.settings
                            jSignatureInstance.$parent.children().remove()
                            for (var key in jSignatureInstance){
                                if (jSignatureInstance.hasOwnProperty(key)) {
                                    delete jSignatureInstance[key]
                                }
                            }

                            // scale data to new signature pad size
                            settings.data = (function(data, scale){
                                var newData = []
                                var o, i, l, j, m, stroke
                                for ( i = 0, l = data.length; i < l; i++) {
                                    stroke = data[i]

                                    o = {'x':[],'y':[]}

                                    for ( j = 0, m = stroke.x.length; j < m; j++) {
                                        o.x.push(stroke.x[j] * scale)
                                        o.y.push(stroke.y[j] * scale)
                                    }

                                    newData.push(o)
                                }
                                return newData
                            })(
                                settings.data
                                , w * 1.0 / originalParentWidth
                            )

                            $parent[apinamespace](settings)
                        }
                    }
                })(
                    this.eventTokens
                    , this.$parent
                    , this.$parent.width()
                    , this.canvas.width * 1.0 / this.canvas.height
                )
            )
        }
    }


    function jSignatureClass(parent, options, instanceExtensions) {

        var $parent = this.$parent = $(parent)
            , eventTokens = this.eventTokens = {}
            , events = this.events = new PubSubClass(this)
            , globalEvents = $.fn[apinamespace]('globalEvents')
            , settings = {
            'width' : 'ratio'
            ,'height' : 'ratio'
            ,'sizeRatio': 4 // only used when height = 'ratio'
            ,'color' : '#000'
            ,'background-color': '#fff'
            ,'decor-color': '#eee'
            ,'lineWidth' : 0
            ,'minFatFingerCompensation' : -10
            ,'showUndoButton': false
            ,'data': []
        }

        $.extend(settings, getColors($parent))
        if (options) {
            $.extend(settings, options)
        }
        this.settings = settings

        for (var extensionName in instanceExtensions){
            if (instanceExtensions.hasOwnProperty(extensionName)) {
                instanceExtensions[extensionName].call(this, extensionName)
            }
        }

        this.events.publish(apinamespace+'.initializing')

        // these, when enabled, will hover above the sig area. Hence we append them to DOM before canvas.
        this.$controlbarUpper = (function(){
            return $('<div class="jsig-control-bar-upper"></div>').appendTo($parent)
        })();

        this.isCanvasEmulator = false // will be flipped by initializer when needed.
        var canvas = this.canvas = this.initializeCanvas(settings)
            , $canvas = $(canvas)

        this.$controlbarLower = (function(){
            return $('<div class="jsig-control-bar-lower"></div>').appendTo($parent)
        })();

        this.canvasContext = canvas.getContext("2d")

        // Most of our exposed API will be looking for this:
        $canvas.data(apinamespace + '.this', this)

        settings.lineWidth = (function(defaultLineWidth, canvasWidth){
            if (!defaultLineWidth){
                return Math.max(
                    Math.round(canvasWidth / 400) /*+1 pixel for every extra 300px of width.*/
                    , 2 /* minimum line width */
                )
            } else {
                return defaultLineWidth
            }
        })(settings.lineWidth, canvas.width);

        this.lineCurveThreshold = settings.lineWidth * 3

        // Add custom class if defined
        if(settings.cssclass && $.trim(settings.cssclass) != "") {
            $canvas.addClass(settings.cssclass)
        }

        // used for shifting the drawing point up on touch devices, so one can see the drawing above the finger.
        this.fatFingerCompensation = 0

        var movementHandlers = (function(jSignatureInstance) {

                //================================
                // mouse down, move, up handlers:

                // shifts - adjustment values in viewport pixels drived from position of canvas on the page
                var shiftX
                    , shiftY
                    , setStartValues = function(){
                    var tos = $(jSignatureInstance.canvas).offset()
                    shiftX = tos.left * -1
                    shiftY = tos.top * -1
                }
                    , getPointFromEvent = function(e) {
                    var firstEvent = (e.changedTouches && e.changedTouches.length > 0 ? e.changedTouches[0] : e)
                    // All devices i tried report correct coordinates in pageX,Y
                    // Android Chrome 2.3.x, 3.1, 3.2., Opera Mobile,  safari iOS 4.x,
                    // Windows: Chrome, FF, IE9, Safari
                    // None of that scroll shift calc vs screenXY other sigs do is needed.
                    // ... oh, yeah, the "fatFinger.." is for tablets so that people see what they draw.
                    return new Point(
                        Math.round(firstEvent.pageX + shiftX)
                        , Math.round(firstEvent.pageY + shiftY) + jSignatureInstance.fatFingerCompensation
                    )
                }
                    , timer = new KickTimerClass(
                    750
                    , function() { jSignatureInstance.dataEngine.endStroke() }
                )

                this.drawEndHandler = function(e) {
                    try { e.preventDefault() } catch (ex) {}
                    timer.clear()
                    jSignatureInstance.dataEngine.endStroke()
                }
                this.drawStartHandler = function(e) {
                    e.preventDefault()
                    // for performance we cache the offsets
                    // we recalc these only at the beginning the stroke
                    setStartValues()
                    jSignatureInstance.dataEngine.startStroke( getPointFromEvent(e) )
                    timer.kick()
                }
                this.drawMoveHandler = function(e) {
                    e.preventDefault()
                    if (!jSignatureInstance.dataEngine.inStroke){
                        return
                    }
                    jSignatureInstance.dataEngine.addToStroke( getPointFromEvent(e) )
                    timer.kick()
                }

                return this

            }).call( {}, this )

            //
            //================================

        ;(function(drawEndHandler, drawStartHandler, drawMoveHandler) {
            var canvas = this.canvas
                , $canvas = $(canvas)
                , undef
            if (this.isCanvasEmulator){
                $canvas.bind('mousemove.'+apinamespace, drawMoveHandler)
                $canvas.bind('mouseup.'+apinamespace, drawEndHandler)
                $canvas.bind('mousedown.'+apinamespace, drawStartHandler)
            } else {
                canvas.ontouchstart = function(e) {
                    canvas.onmousedown = undef
                    canvas.onmouseup = undef
                    canvas.onmousemove = undef

                    this.fatFingerCompensation = (
                        settings.minFatFingerCompensation &&
                        settings.lineWidth * -3 > settings.minFatFingerCompensation
                    ) ? settings.lineWidth * -3 : settings.minFatFingerCompensation

                    drawStartHandler(e)

                    canvas.ontouchend = drawEndHandler
                    canvas.ontouchstart = drawStartHandler
                    canvas.ontouchmove = drawMoveHandler
                }
                canvas.onmousedown = function(e) {
                    canvas.ontouchstart = undef
                    canvas.ontouchend = undef
                    canvas.ontouchmove = undef

                    drawStartHandler(e)

                    canvas.onmousedown = drawStartHandler
                    canvas.onmouseup = drawEndHandler
                    canvas.onmousemove = drawMoveHandler
                }
            }
        }).call(
            this
            , movementHandlers.drawEndHandler
            , movementHandlers.drawStartHandler
            , movementHandlers.drawMoveHandler
        )

        //=========================================
        // various event handlers

        // on mouseout + mouseup canvas did not know that mouseUP fired. Continued to draw despite mouse UP.
        // it is bettr than
        // $canvas.bind('mouseout', drawEndHandler)
        // because we don't want to break the stroke where user accidentally gets ouside and wants to get back in quickly.
        eventTokens[apinamespace + '.windowmouseup'] = globalEvents.subscribe(
            apinamespace + '.windowmouseup'
            , movementHandlers.drawEndHandler
        )

        this.events.publish(apinamespace+'.attachingEventHandlers')

        // If we have proportional width, we sign up to events broadcasting "window resized" and checking if
        // parent's width changed. If so, we (1) extract settings + data from current signature pad,
        // (2) remove signature pad from parent, and (3) reinit new signature pad at new size with same settings, (rescaled) data.
        conditionallyLinkCanvasResizeToWindowResize.call(
            this
            , this
            , settings.width.toString(10)
            , apinamespace, globalEvents
        )

        // end of event handlers.
        // ===============================

        this.resetCanvas(settings.data)

        // resetCanvas renders the data on the screen and fires ONE "change" event
        // if there is data. If you have controls that rely on "change" firing
        // attach them to something that runs before this.resetCanvas, like
        // apinamespace+'.attachingEventHandlers' that fires a bit higher.
        this.events.publish(apinamespace+'.initialized')

        return this
    } // end of initBase

//=========================================================================
// jSignatureClass's methods and supporting fn's

    jSignatureClass.prototype.resetCanvas = function(data){
        var canvas = this.canvas
            , settings = this.settings
            , ctx = this.canvasContext
            , isCanvasEmulator = this.isCanvasEmulator

            , cw = canvas.width
            , ch = canvas.height

        // preparing colors, drawing area

        ctx.clearRect(0, 0, cw + 30, ch + 30)

        ctx.shadowColor = ctx.fillStyle = settings['background-color']
        if (isCanvasEmulator){
            // FLashCanvas fills with Black by default, covering up the parent div's background
            // hence we refill
            ctx.fillRect(0,0,cw + 30, ch + 30)
        }

        ctx.lineWidth = Math.ceil(parseInt(settings.lineWidth, 10))
        ctx.lineCap = ctx.lineJoin = "round"

        // signature line
        ctx.strokeStyle = settings['decor-color']
        ctx.shadowOffsetX = 0
        ctx.shadowOffsetY = 0
        var lineoffset = Math.round( ch / 5 )
        basicLine(ctx, lineoffset * 1.5, ch - lineoffset, cw - (lineoffset * 1.5), ch - lineoffset)
        ctx.strokeStyle = settings.color

        if (!isCanvasEmulator){
            ctx.shadowColor = ctx.strokeStyle
            ctx.shadowOffsetX = ctx.lineWidth * 0.5
            ctx.shadowOffsetY = ctx.lineWidth * -0.6
            ctx.shadowBlur = 0
        }

        // setting up new dataEngine

        if (!data) { data = [] }

        var dataEngine = this.dataEngine = new DataEngine(
            data
            , this
            , strokeStartCallback
            , strokeAddCallback
            , strokeEndCallback
        )

        settings.data = data  // onwindowresize handler uses it, i think.
        $(canvas).data(apinamespace+'.data', data)
            .data(apinamespace+'.settings', settings)

        // we fire "change" event on every change in data.
        // setting this up:
        dataEngine.changed = (function(target, events, apinamespace) {
            'use strict'
            return function() {
                events.publish(apinamespace+'.change')
                target.trigger('change')
            }
        })(this.$parent, this.events, apinamespace)
        // let's trigger change on all data reloads
        dataEngine.changed()

        // import filters will be passing this back as indication of "we rendered"
        return true
    }

    function initializeCanvasEmulator(canvas){
        if (canvas.getContext){
            return false
        } else {
            // for cases when jSignature, FlashCanvas is inserted
            // from one window into another (child iframe)
            // 'window' and 'FlashCanvas' may be stuck behind
            // in that other parent window.
            // we need to find it
            var window = canvas.ownerDocument.parentWindow
            var FC = window.FlashCanvas ?
                canvas.ownerDocument.parentWindow.FlashCanvas :
                (
                    typeof FlashCanvas === "undefined" ?
                        undefined :
                        FlashCanvas
                )

            if (FC) {
                canvas = FC.initElement(canvas)

                var zoom = 1
                // FlashCanvas uses flash which has this annoying habit of NOT scaling with page zoom.
                // It matches pixel-to-pixel to screen instead.
                // Since we are targeting ONLY IE 7, 8 with FlashCanvas, we will test the zoom only the IE8, IE7 way
                if (window && window.screen && window.screen.deviceXDPI && window.screen.logicalXDPI){
                    zoom = window.screen.deviceXDPI * 1.0 / window.screen.logicalXDPI
                }
                if (zoom !== 1){
                    try {
                        // We effectively abuse the brokenness of FlashCanvas and force the flash rendering surface to
                        // occupy larger pixel dimensions than the wrapping, scaled up DIV and Canvas elems.
                        $(canvas).children('object').get(0).resize(Math.ceil(canvas.width * zoom), Math.ceil(canvas.height * zoom))
                        // And by applying "scale" transformation we can talk "browser pixels" to FlashCanvas
                        // and have it translate the "browser pixels" to "screen pixels"
                        canvas.getContext('2d').scale(zoom, zoom)
                        // Note to self: don't reuse Canvas element. Repeated "scale" are cumulative.
                    } catch (ex) {}
                }
                return true
            } else {
                throw new Error("Canvas element does not support 2d context. jSignature cannot proceed.")
            }
        }

    }

    jSignatureClass.prototype.initializeCanvas = function(settings) {
        // ===========
        // Init + Sizing code

        var canvas = document.createElement('canvas')
            , $canvas = $(canvas)

        // We cannot work with circular dependency
        if (settings.width === settings.height && settings.height === 'ratio') {
            settings.width = '100%'
        }

        $canvas.css(
            'margin'
            , 0
        ).css(
            'padding'
            , 0
        ).css(
            'border'
            , 'none'
        ).css(
            'height'
            , settings.height === 'ratio' || !settings.height ? 1 : settings.height.toString(10)
        ).css(
            'width'
            , settings.width === 'ratio' || !settings.width ? 1 : settings.width.toString(10)
        )

        $canvas.appendTo(this.$parent)

        // we could not do this until canvas is rendered (appended to DOM)
        if (settings.height === 'ratio') {
            $canvas.css(
                'height'
                , Math.round( $canvas.width() / settings.sizeRatio )
            )
        } else if (settings.width === 'ratio') {
            $canvas.css(
                'width'
                , Math.round( $canvas.height() * settings.sizeRatio )
            )
        }

        $canvas.addClass(apinamespace)

        // canvas's drawing area resolution is independent from canvas's size.
        // pixels are just scaled up or down when internal resolution does not
        // match external size. So...

        canvas.width = $canvas.width()
        canvas.height = $canvas.height()

        // Special case Sizing code

        this.isCanvasEmulator = initializeCanvasEmulator(canvas)

        // End of Sizing Code
        // ===========

        // normally select preventer would be short, but
        // Canvas emulator on IE does NOT provide value for Event. Hence this convoluted line.
        canvas.onselectstart = function(e){if(e && e.preventDefault){e.preventDefault()}; if(e && e.stopPropagation){e.stopPropagation()}; return false;}

        return canvas
    }


    var GlobalJSignatureObjectInitializer = function(window){

        var globalEvents = new PubSubClass()

            // common "window resized" event listener.
            // jSignature instances will subscribe to this chanel.
            // to resize themselves when needed.
        ;(function(globalEvents, apinamespace, $, window){
            'use strict'

            var resizetimer
                , runner = function(){
                globalEvents.publish(
                    apinamespace + '.parentresized'
                )
            }

            // jSignature knows how to resize its content when its parent is resized
            // window resize is the only way we can catch resize events though...
            $(window).bind('resize.'+apinamespace, function(){
                if (resizetimer) {
                    clearTimeout(resizetimer)
                }
                resizetimer = setTimeout(
                    runner
                    , 500
                )
            })
            // when mouse exists canvas element and "up"s outside, we cannot catch it with
            // callbacks attached to canvas. This catches it outside.
                .bind('mouseup.'+apinamespace, function(e){
                    globalEvents.publish(
                        apinamespace + '.windowmouseup'
                    )
                })

        })(globalEvents, apinamespace, $, window)

        var jSignatureInstanceExtensions = {
            /*
            'exampleExtension':function(extensionName){
                // we are called very early in instance's life.
                // right after the settings are resolved and
                // jSignatureInstance.events is created
                // and right before first ("jSignature.initializing") event is called.
                // You don't really need to manupilate
                // jSignatureInstance directly, just attach
                // a bunch of events to jSignatureInstance.events
                // (look at the source of jSignatureClass to see when these fire)
                // and your special pieces of code will attach by themselves.

                // this function runs every time a new instance is set up.
                // this means every var you create will live only for one instance
                // unless you attach it to something outside, like "window."
                // and pick it up later from there.

                // when globalEvents' events fire, 'this' is globalEvents object
                // when jSignatureInstance's events fire, 'this' is jSignatureInstance

                // Here,
                // this = is new jSignatureClass's instance.

                // The way you COULD approch setting this up is:
                // if you have multistep set up, attach event to "jSignature.initializing"
                // that attaches other events to be fired further lower the init stream.
                // Or, if you know for sure you rely on only one jSignatureInstance's event,
                // just attach to it directly

                this.events.subscribe(
                    // name of the event
                    apinamespace + '.initializing'
                    // event handlers, can pass args too, but in majority of cases,
                    // 'this' which is jSignatureClass object instance pointer is enough to get by.
                    , function(){
                        if (this.settings.hasOwnProperty('non-existent setting category?')) {
                            console.log(extensionName + ' is here')
                        }
                    }
                )
            }
            */
        }

        var exportplugins = {
            'default':function(data){return this.toDataURL()}
            , 'native':function(data){return data}
            , 'image':function(data){
                /*this = canvas elem */
                var imagestring = this.toDataURL()

                if (typeof imagestring === 'string' &&
                    imagestring.length > 4 &&
                    imagestring.slice(0,5) === 'data:' &&
                    imagestring.indexOf(',') !== -1){

                    var splitterpos = imagestring.indexOf(',')

                    return [
                        imagestring.slice(5, splitterpos)
                        , imagestring.substr(splitterpos + 1)
                    ]
                }
                return []
            }
        }

        // will be part of "importplugins"
        function _renderImageOnCanvas( data, formattype, rerendercallable ) {
            'use strict'
            // #1. Do NOT rely on this. No worky on IE
            //   (url max len + lack of base64 decoder + possibly other issues)
            // #2. This does NOT affect what is captured as "signature" as far as vector data is
            // concerned. This is treated same as "signature line" - i.e. completely ignored
            // the only time you see imported image data exported is if you export as image.

            // we do NOT call rerendercallable here (unlike in other import plugins)
            // because importing image does absolutely nothing to the underlying vector data storage
            // This could be a way to "import" old signatures stored as images
            // This could also be a way to import extra decor into signature area.

            var img = new Image()
                // this = Canvas DOM elem. Not jQuery object. Not Canvas's parent div.
                , c = this

            img.onload = function() {
                var ctx = c.getContext("2d").drawImage(
                    img, 0, 0
                    , ( img.width < c.width) ? img.width : c.width
                    , ( img.height < c.height) ? img.height : c.height
                )
            }

            img.src = 'data:' + formattype + ',' + data
        }

        var importplugins = {
            'native':function(data, formattype, rerendercallable){
                // we expect data as Array of objects of arrays here - whatever 'default' EXPORT plugin spits out.
                // returning Truthy to indicate we are good, all updated.
                rerendercallable( data )
            }
            , 'image': _renderImageOnCanvas
            , 'image/png;base64': _renderImageOnCanvas
            , 'image/jpeg;base64': _renderImageOnCanvas
            , 'image/jpg;base64': _renderImageOnCanvas
        }

        function _clearDrawingArea( data ) {
            this.find('canvas.'+apinamespace)
                .add(this.filter('canvas.'+apinamespace))
                .data(apinamespace+'.this').resetCanvas( data )
            return this
        }

        function _setDrawingData( data, formattype ) {
            var undef

            if (formattype === undef && typeof data === 'string' && data.substr(0,5) === 'data:') {
                formattype = data.slice(5).split(',')[0]
                // 5 chars of "data:" + mimetype len + 1 "," char = all skipped.
                data = data.slice(6 + formattype.length)
                if (formattype === data) return
            }

            var $canvas = this.find('canvas.'+apinamespace).add(this.filter('canvas.'+apinamespace))

            if (!importplugins.hasOwnProperty(formattype)){
                throw new Error(apinamespace + " is unable to find import plugin with for format '"+ String(formattype) +"'")
            } else if ($canvas.length !== 0){
                importplugins[formattype].call(
                    $canvas[0]
                    , data
                    , formattype
                    , (function(jSignatureInstance){
                        return function(){ return jSignatureInstance.resetCanvas.apply(jSignatureInstance, arguments) }
                    })($canvas.data(apinamespace+'.this'))
                )
            }

            return this
        }

        var elementIsOrphan = function(e){
            var topOfDOM = false
            e = e.parentNode
            while (e && !topOfDOM){
                topOfDOM = e.body
                e = e.parentNode
            }
            return !topOfDOM
        }

        //These are exposed as methods under $obj.jSignature('methodname', *args)
        var plugins = {'export':exportplugins, 'import':importplugins, 'instance': jSignatureInstanceExtensions}
            , methods = {
            'init' : function( options ) {
                return this.each( function() {
                    if (!elementIsOrphan(this)) {
                        new jSignatureClass(this, options, jSignatureInstanceExtensions)
                    }
                })
            }
            , 'getJsonSettings' : function() {
                return this.find('canvas.'+apinamespace)
                    .add(this.filter('canvas.'+apinamespace))
                    .data(apinamespace+'.this').settings
            }
            // around since v1
            , 'clear' : _clearDrawingArea
            // was mistakenly introduced instead of 'clear' in v2
            , 'reset' : _clearDrawingArea
            , 'addPlugin' : function(pluginType, pluginName, callable){
                if (plugins.hasOwnProperty(pluginType)){
                    plugins[pluginType][pluginName] = callable
                }
                return this
            }
            , 'listPlugins' : function(pluginType){
                var answer = []
                if (plugins.hasOwnProperty(pluginType)){
                    var o = plugins[pluginType]
                    for (var k in o){
                        if (o.hasOwnProperty(k)){
                            answer.push(k)
                        }
                    }
                }
                return answer
            }
            , 'getData' : function( formattype ) {
                var undef, $canvas=this.find('canvas.'+apinamespace).add(this.filter('canvas.'+apinamespace))
                if (formattype === undef) formattype = 'default'
                if ($canvas.length !== 0 && exportplugins.hasOwnProperty(formattype)){
                    return exportplugins[formattype].call(
                        $canvas.get(0) // canvas dom elem
                        , $canvas.data(apinamespace+'.data') // raw signature data as array of objects of arrays
                    )
                }
            }
            // around since v1. Took only one arg - data-url-formatted string with (likely png of) signature image
            , 'importData' : _setDrawingData
            // was mistakenly introduced instead of 'importData' in v2
            , 'setData' : _setDrawingData
            // this is one and same instance for all jSignature.
            , 'globalEvents' : function(){return globalEvents}
            // there will be a separate one for each jSignature instance.
            , 'events' : function() {
                return this.find('canvas.'+apinamespace)
                    .add(this.filter('canvas.'+apinamespace))
                    .data(apinamespace+'.this').events
            }
        } // end of methods declaration.

        $.fn[apinamespace] = function(method) {
            'use strict'
            if ( !method || typeof method === 'object' ) {
                return methods.init.apply( this, arguments )
            } else if ( typeof method === 'string' && methods[method] ) {
                return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ))
            } else {
                $.error( 'Method ' +  String(method) + ' does not exist on jQuery.' + apinamespace )
            }
        }

    } // end of GlobalJSignatureObjectInitializer

    GlobalJSignatureObjectInitializer(window)

})();

/** @license
 jSignature v2 jSignature's Undo Button and undo functionality plugin

 */
/**
 Copyright (c) 2011 Willow Systems Corp http://willow-systems.com
 MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

;(function(){

    var apinamespace = 'jSignature'

    function attachHandlers(buttonRenderer, apinamespace, extensionName) {
        var $undoButton = buttonRenderer.call(this)

        ;(function(jSignatureInstance, $undoButton, apinamespace) {
            jSignatureInstance.events.subscribe(
                apinamespace + '.change'
                , function(){
                    if (jSignatureInstance.dataEngine.data.length) {
                        $undoButton.show()
                    } else {
                        $undoButton.hide()
                    }
                }
            )
        })( this, $undoButton, apinamespace )

        ;(function(jSignatureInstance, $undoButton, apinamespace) {

            var eventName = apinamespace + '.undo'

            $undoButton.bind('click', function(){
                jSignatureInstance.events.publish(eventName)
            })

            // This one creates new "undo" event listener to jSignature instance
            // It handles the actual undo-ing.
            jSignatureInstance.events.subscribe(
                eventName
                , function(){
                    var data = jSignatureInstance.dataEngine.data
                    if (data.length) {
                        data.pop()
                        jSignatureInstance.resetCanvas(data)
                    }
                }
            )
        })(
            this
            , $undoButton
            , this.events.topics.hasOwnProperty( apinamespace + '.undo' ) ?
                // oops, seems some other plugin or code has already claimed "jSignature.undo" event
                // we will use this extension's name for event name prefix
                extensionName :
                // Great! we will use 'jSignature' for event name prefix.
                apinamespace
        )
    }

    function ExtensionInitializer(extensionName){
        // we are called very early in instance's life.
        // right after the settings are resolved and
        // jSignatureInstance.events is created
        // and right before first ("jSignature.initializing") event is called.
        // You don't really need to manupilate
        // jSignatureInstance directly, just attach
        // a bunch of events to jSignatureInstance.events
        // (look at the source of jSignatureClass to see when these fire)
        // and your special pieces of code will attach by themselves.

        // this function runs every time a new instance is set up.
        // this means every var you create will live only for one instance
        // unless you attach it to something outside, like "window."
        // and pick it up later from there.

        // when globalEvents' events fire, 'this' is globalEvents object
        // when jSignatureInstance's events fire, 'this' is jSignatureInstance

        // Here,
        // this = is new jSignatureClass's instance.

        // The way you COULD approch setting this up is:
        // if you have multistep set up, attach event to "jSignature.initializing"
        // that attaches other events to be fired further lower the init stream.
        // Or, if you know for sure you rely on only one jSignatureInstance's event,
        // just attach to it directly

        var apinamespace = 'jSignature'

        this.events.subscribe(
            // name of the event
            apinamespace + '.attachingEventHandlers'
            // event handlers, can pass args too, but in majority of cases,
            // 'this' which is jSignatureClass object instance pointer is enough to get by.
            , function(){

                // hooking up "undo" button	to lower edge of Canvas.
                // but only when options passed to jSignature('init', options)
                // contain "undoButton":renderingFunction pair.
                // or "undoButton":true (in which case default, internal rendering fn is used)
                if (this.settings[extensionName]) {
                    var oursettings = this.settings[extensionName]
                    if (typeof oursettings !== 'function') {
                        // we make it a function.

                        // we allow people to override the button rendering code,
                        // but when developler is OK with default look (and just passes "truthy" value)
                        // this defines default look for the button:
                        // centered against canvas, hanging on its lower side.
                        oursettings = function(){
                            // this === jSignatureInstance
                            var undoButtonSytle = ''
                                , $undoButton = $('<input class="jsig-undo-button" type="button" value="Undo last stroke" />')
                                .appendTo(this.$controlbarLower)

                            // this centers the button against the canvas.
                            var buttonWidth = $undoButton.width()
                            $undoButton.css(
                                'left'
                                , Math.round(( this.canvas.width - buttonWidth ) / 2)
                            )
                            // IE 7 grows the button. Correcting for that.
                            if ( buttonWidth !== $undoButton.width() ) {
                                $undoButton.width(buttonWidth)
                            }

                            return $undoButton
                        }
                    }

                    attachHandlers.call(
                        this
                        , oursettings
                        , apinamespace
                        , extensionName
                    )
                }
            }
        )
    }

    var ExtensionAttacher = function(){
        $.fn[apinamespace](
            'addPlugin'
            ,'instance' // type of plugin
            ,'UndoButton' // extension name
            ,ExtensionInitializer
        )
    }


//  //Because plugins are minified together with jSignature, multiple defines per (minified) file blow up and dont make sense
//	//Need to revisit this later.

//	if ( typeof define === "function" && define.amd != null) {
//		// AMD-loader compatible resource declaration
//		// you need to call this one with jQuery as argument.
//		define(function(){return Initializer} )
//	} else {
    ExtensionAttacher()
//	}

})();

/** @preserve
 jSignature v2 jSignature's custom "base30" format export and import plugins.

 */
/**
 Copyright (c) 2011 Willow Systems Corp http://willow-systems.com
 MIT License <http://www.opensource.org/licenses/mit-license.php>
 */

;(function(){

    var chunkSeparator = '_'
        , charmap = {} // {'1':'g','2':'h','3':'i','4':'j','5':'k','6':'l','7':'m','8':'n','9':'o','a':'p','b':'q','c':'r','d':'s','e':'t','f':'u','0':'v'}
        , charmap_reverse = {} // will be filled by 'uncompress*" function
        // need to split below for IE7 (possibly others), which does not understand string[position] it seems (returns undefined)
        , allchars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWX'.split('')
        , bitness = allchars.length / 2
        , minus = 'Z'
        , plus = 'Y'

    for(var i = bitness-1; i > -1; i--){
        charmap[allchars[i]] = allchars[i+bitness]
        charmap_reverse[allchars[i+bitness]] = allchars[i]
    }
    var remapTailChars = function(number){
        // for any given number as string, returning string with trailing chars remapped something like so:
        // '345' -> '3de'
        var chars = number.split('')
            , l = chars.length
        // we are skipping first char. standard hex number char = delimiter
        for (var i = 1; i < l; i++ ){
            chars[i] = charmap[chars[i]]
        }
        return chars.join('')
    }
        , compressstrokeleg = function(data){
        // we convert half-stroke (only 'x' series or only 'y' series of numbers)
        // data is like this:
        // [517,516,514,513,513,513,514,516,519,524,529,537,541,543,544,544,539,536]
        // that is converted into this:
        // "5agm12100p1235584210m53"
        // each number in the chain is converted such:
        // - find diff from previous number
        // - first significant digit is kept as digit char. digit char = start of new number.
        // - consecutive numbers are mapped to letters, where 1 to 9 are A to I, 0 is O
        // Sign changes are denoted by "P" - plus, "M" for minus.
        var answer = []
            , lastwhole = 0
            , last = 0
            , lastpolarity = 1
            , l = data.length
            , nwhole, n, absn

        for(var i = 0; i < l; i++){
            // we start with whole coordinates for each point
            // coords are converted into series of vectors:
            // [512, 514, 520]
            // [512, +2, +6]
            nwhole = Math.round(data[i])
            n = nwhole - lastwhole
            lastwhole = nwhole

            // inserting sign change when needed.
            if (n < 0 && lastpolarity > 0) {
                lastpolarity = -1
                answer.push(minus)
            }
            else if (n > 0 && lastpolarity < 0) {
                lastpolarity = 1
                answer.push(plus)
            }

            // since we have dealt with sign. let's absolute the value.
            absn = Math.abs(n)
            // adding number to list  We convert these to Hex before storing on the string.
            if (absn >= bitness) {
                answer.push(remapTailChars(absn.toString(bitness)))
            } else {
                answer.push(absn.toString(bitness))
            }
        }
        return answer.join('')
    }
        , uncompressstrokeleg = function(datastring){
        // we convert half-stroke (only 'x' series or only 'y' series of numbers)
        // datastring like this:
        // "5agm12100p1235584210m53"
        // is converted into this:
        // [517,516,514,513,513,513,514,516,519,524,529,537,541,543,544,544,539,536]
        // each number in the chain is converted such:
        // - digit char = start of new whole number. Alpha chars except "p","m" are numbers in hiding.
        //   These consecutive digist expressed as alphas mapped back to digit char.
        //   resurrected number is the diff between this point and prior coord.
        // - running polaritiy is attached to the number.
        // - we undiff (signed number + prior coord) the number.
        // - if char 'm','p', flip running polarity
        var answer = []
            , chars = datastring.split('')
            , l = chars.length
            , ch
            , polarity = 1
            , partial = []
            , preprewhole = 0
            , prewhole
        for(var i = 0; i < l; i++){
            ch = chars[i]
            if (ch in charmap || ch === minus || ch === plus){
                // this is new number - start of a new whole number.
                // before we can deal with it, we need to flush out what we already
                // parsed out from string, but keep in limbo, waiting for this sign
                // that prior number is done.
                // we deal with 3 numbers here:
                // 1. start of this number - a diff from previous number to
                //    whole, new number, which we cannot do anything with cause
                //    we don't know its ending yet.
                // 2. number that we now realize have just finished parsing = prewhole
                // 3. number we keep around that came before prewhole = preprewhole

                if (partial.length !== 0) {
                    // yep, we have some number parts in there.
                    prewhole = parseInt( partial.join(''), bitness) * polarity + preprewhole
                    answer.push( prewhole )
                    preprewhole = prewhole
                }

                if (ch === minus){
                    polarity = -1
                    partial = []
                } else if (ch === plus){
                    polarity = 1
                    partial = []
                } else {
                    // now, let's start collecting parts for the new number:
                    partial = [ch]
                }
            } else /* alphas replacing digits */ {
                // more parts for the new number
                partial.push(charmap_reverse[ch])
            }
        }
        // we always will have something stuck in partial
        // because we don't have closing delimiter
        answer.push( parseInt( partial.join(''), bitness ) * polarity + preprewhole )

        return answer
    }
        , compressstrokes = function(data){
        var answer = []
            , l = data.length
            , stroke
        for(var i = 0; i < l; i++){
            stroke = data[i]
            answer.push(compressstrokeleg(stroke.x))
            answer.push(compressstrokeleg(stroke.y))
        }
        return answer.join(chunkSeparator)
    }
        , uncompressstrokes = function(datastring){
        var data = []
            , chunks = datastring.split(chunkSeparator)
            , l = chunks.length / 2
        for (var i = 0; i < l; i++){
            data.push({
                'x':uncompressstrokeleg(chunks[i*2])
                , 'y':uncompressstrokeleg(chunks[i*2+1])
            })
        }
        return data
    }
        , acceptedformat = 'image/jsignature;base30'
        , pluginCompressor = function(data){
        return [acceptedformat , compressstrokes(data)]
    }
        , pluginDecompressor = function(data, formattype, importcallable){
        if (typeof data !== 'string') return
        if (data.substring(0, acceptedformat.length).toLowerCase() === acceptedformat) {
            data = data.substring(acceptedformat.length + 1) // chopping off "," there
        }
        importcallable( uncompressstrokes(data) )
    }
        , Initializer = function($){
        var mothership = $.fn['jSignature']
        mothership(
            'addPlugin'
            ,'export'
            ,'base30' // alias
            ,pluginCompressor
        )
        mothership(
            'addPlugin'
            ,'export'
            ,acceptedformat // full name
            ,pluginCompressor
        )
        mothership(
            'addPlugin'
            ,'import'
            ,'base30' // alias
            ,pluginDecompressor
        )
        mothership(
            'addPlugin'
            ,'import'
            ,acceptedformat // full name
            ,pluginDecompressor
        )
    }


//  //Because plugins are minified together with jSignature, multiple defines per (minified) file blow up and dont make sense
//	//Need to revisit this later.

//	if ( typeof define === "function" && define.amd != null) {
//		// AMD-loader compatible resource declaration
//		// you need to call this one with jQuery as argument.
//		define(function(){return Initializer} )
//	} else {
    // global-polluting outcome.
    if(this.jQuery == null) {throw new Error("We need jQuery for some of the functionality. jQuery is not detected. Failing to initialize...")}
    Initializer(this.jQuery)
//	}

    if (this.jSignatureDebug) {
        this.jSignatureDebug['base30'] = {
            'remapTailChars':remapTailChars
            , 'compressstrokeleg':compressstrokeleg
            , 'uncompressstrokeleg':uncompressstrokeleg
            , 'compressstrokes':compressstrokes
            , 'uncompressstrokes':uncompressstrokes
            , 'charmap': charmap
        }
    }

}).call(typeof window !== 'undefined'? window : this);

/** @license
 jSignature v2 jSignature's Sign Here "sticker" plugin
 Copyright (c) 2011 Willow Systems Corp http://willow-systems.com
 MIT License <http://www.opensource.org/licenses/mit-license.php>

 */
;(function(){

    var apinamespace = 'jSignature'

    function attachHandlers($obj, apinamespace, extensionName) {

        ;(function(jSignatureInstance, $obj, apinamespace) {
            $obj.bind('click', function(){
                // when user is annoyed enough to click on us, hide us
                $obj.hide()
            })

            jSignatureInstance.events.subscribe(
                apinamespace + '.change'
                , function(){
                    if (jSignatureInstance.dataEngine.data.length) {
                        $obj.hide()
                    } else {
                        $obj.show()
                    }
                }
            )
        })( this, $obj, apinamespace )
    }

    function ExtensionInitializer(extensionName){
        // we are called very early in instance's life.
        // right after the settings are resolved and
        // jSignatureInstance.events is created
        // and right before first ("jSignature.initializing") event is called.
        // You don't really need to manupilate
        // jSignatureInstance directly, just attach
        // a bunch of events to jSignatureInstance.events
        // (look at the source of jSignatureClass to see when these fire)
        // and your special pieces of code will attach by themselves.

        // this function runs every time a new instance is set up.
        // this means every var you create will live only for one instance
        // unless you attach it to something outside, like "window."
        // and pick it up later from there.

        // when globalEvents' events fire, 'this' is globalEvents object
        // when jSignatureInstance's events fire, 'this' is jSignatureInstance

        // Here,
        // this = is new jSignatureClass's instance.

        // The way you COULD approch setting this up is:
        // if you have multistep set up, attach event to "jSignature.initializing"
        // that attaches other events to be fired further lower the init stream.
        // Or, if you know for sure you rely on only one jSignatureInstance's event,
        // just attach to it directly

        var apinamespace = 'jSignature'

        this.events.subscribe(
            // name of the event
            apinamespace + '.attachingEventHandlers'
            // event handlers, can pass args too, but in majority of cases,
            // 'this' which is jSignatureClass object instance pointer is enough to get by.
            , function(){

                var renderer = function(){
                    var data = "data:image/gif;base64,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"
                        , $img = $('<img class="sign-here" />')
                    try {
                        $img[0].src = data
                        return $img
                    } catch (ex) {
                        return $() // empty jQuery obj
                    }
                }
                if (this.settings[extensionName] && typeof this.settings[extensionName].renderer === 'function') {
                    renderer = this.settings[extensionName].renderer
                }

                var $obj = renderer()

                if ($obj.length) {
                    $obj.appendTo(this.$controlbarUpper)

                    attachHandlers.call(
                        this
                        , $obj
                        , apinamespace
                        , extensionName
                    )
                }
            }
        )
    }

    var ExtensionAttacher = function(){
        $.fn[apinamespace](
            'addPlugin'
            , 'instance' // type of plugin
            , 'SignHere' // extension name
            , ExtensionInitializer
        )
    }


//  //Because plugins are minified together with jSignature, multiple defines per (minified) file blow up and dont make sense
//	//Need to revisit this later.

//	if ( typeof define === "function" && define.amd != null) {
//		// AMD-loader compatible resource declaration
//		// you need to call this one with jQuery as argument.
//		define(function(){return Initializer} )
//	} else {
    ExtensionAttacher()
//	}

})();