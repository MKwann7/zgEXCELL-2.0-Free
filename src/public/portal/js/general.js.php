<?php
    global $app;
?>
const touchEvent = 'ontouchstart' in window ? 'touchend' : 'click';

function ezLog(obj, label)
{
    if (typeof label !== "undefined" && label !== null) {
        console.log("[" + label + "]")
    }
    console.log(obj);
}

function elm(element)
{
    return document.getElementById(element);
}

function insertAfterNode(target, node)
{
    if  (typeof target === "undefined" || target === null) return;
    target.parentNode.insertBefore(node, target.nextSibling)
}

function appendToNode(target, node)
{
    var fragment = document.createDocumentFragment();
    fragment.appendChild(node);

    target.appendChild(fragment);
}

function fadeNodeTo(node, duration, opacity, callback)
{
    let nodeOpacity = node.style.opacity;
    if(!nodeOpacity && node.style.display === "none") { nodeOpacity = 0; node.style.opacity = nodeOpacity; node.style.removeProperty('display'); }

    node.style.transitionProperty = 'opacity';
    node.style.transitionDuration = duration + 'ms';
    node.style.opacity = opacity;

    window.setTimeout( () =>
    {
        node.style.removeProperty('transition-duration');
        node.style.removeProperty('transition-property');

        if (typeof callback === "function")
        {
            callback(node);
        }
    }, duration);
}

function getChildOfNode(node, targetByAttribute)
{
    return node.querySelector(targetByAttribute);
}

function removeNodeByClass(className)
{
    classListGlobal(className, function(el) {
        el.remove();
    });
}

function classFirst(element, className)
{
    return classList(element, className)[0];
}

function classFirstGlobal(className)
{
    return classListGlobal(className)[0];
}

function windowLoad(callback)
{
    window.onload = function(event)
    {
        callback(event)
    };
}

function addListener(element, type, callback)
{
    if (type.toLowerCase() === "click") { type = touchEvent; }

    if (getObjectName(element) === "HTMLCollection")
    {
        for (let currElementIndex in  Array.from(element))
        {
            element[currElementIndex].addEventListener(touchEvent, function(event){callback(event)});
        }

        return;
    }

    element.addEventListener(touchEvent, function(event){callback(event)});
}

function addListenerById(id, type, callback)
{
    if (type.toLowerCase() === "click") { type = touchEvent; }
    elm(id).addEventListener(touchEvent, function(event){callback(event)});
}

function classListGlobal(className, callback)
{
    if (typeof callback === "function")
    {
        let elm = document.getElementsByClassName(className);

        for (let currElm of  Array.from(elm))
        {
            callback(currElm);
        }

        return elm;
    }

    return document.getElementsByClassName(className);
}

function classList(element, className, callback)
{
    if (typeof callback === "function") {
        let elm = element.getElementsByClassName(className);

        for (let currElm of Array.from(elm)) {
            callback(currElm);
        }

        return elm;
    }

    return element.getElementsByClassName(element);
}

function globalClassList(className, callback)
{
    if (typeof callback === "function") {
        let elm = document.getElementsByClassName(className);

        for (let currElm of Array.from(elm)) {
            callback(currElm);
        }

        return elm;
    }

    return document.getElementsByClassName(className);
}

function createNode(type, parameters, text)
{
    let node  = document.createElement(type);

    for (let currParameter of Array.from(parameters)) {
        if (currParameter.substr(0,1) === ".") {
            node.classList.add(currParameter.substr(1, currParameter.length))
        }
        if (currParameter.substr(0,1) === "#") {
            node.id = currParameter.substr(1, currParameter.length)
        }
        if (currParameter.includes("=")) {
            const customParameter = currParameter.split("=");
            node.setAttribute(customParameter[0], customParameter[1])
        }
    }
    if (typeof text !== "undefined") {
        node.innerHTML = text
    }

    return node;
}

function classListById(id, className, callback)
{
    if (typeof callback === "function") {
        let elm = elm(id).getElementsByClassName(className);

        for (let currElm of Array.from(elm)) {
            callback(currElm);
        }

        return elm;
    }

    return elm(id).getElementsByClassName(element);
}

function getObjectName(element)
{
    return element.constructor.toString().replace("function ", "").split("()")[0];
}

if (typeof randomIntFromInterval === "undefined")
{
    function randomIntFromInterval(min,max)
    {
        return Math.floor(Math.random()*(max-min+1)+min);
    }
}

function sortObject(obj, sortedBy, isNumericSort, reverse)
{
    sortedBy = sortedBy || 1; // by default first key
    isNumericSort = isNumericSort || false; // by default text sort
    reverse = reverse || false; // by default no reverse

    var reversed = (reverse) ? -1 : 1;

    var sortable = [];
    for (var key in obj) {
        if (obj.hasOwnProperty(key)) {
            sortable.push(obj[key]);
        }
    }
    if (isNumericSort)
        sortable.sort(function (a, b) {
            return reversed * (a[sortedBy] - b[sortedBy]);
        });
    else
        sortable.sort(function (a, b) {
            var x = a[sortedBy].toLowerCase(),
                y = b[sortedBy].toLowerCase();
            return x < y ? reversed * -1 : x > y ? reversed : 0;
        });
    return sortable;
}

if (typeof formatAsPhoneIfApplicable === "undefined")
{
    function formatAsPhoneIfApplicable(phoneNumberString)
    {
        let cleaned = ('' + phoneNumberString).replace(/\D/g, '');
        let match = cleaned.match(/^(1|)?(\d{3})(\d{3})(\d{4})$/);

        if (match)
        {
            let intlCode = (match[1] ? '+1 ' : '');
            return [intlCode, '(', match[2], ') ', match[3], '-', match[4]].join('');
        }

        return phoneNumberString;
    }
}

if (typeof formatDate === "undefined")
{
    function formatDate(date, format, utc) {
        var MMMM = ["\x00", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var MMM = ["\x01", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
        var dddd = ["\x02", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var ddd = ["\x03", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

        function ii(i, len) {
            var s = i + "";
            len = len || 2;
            while (s.length < len) s = "0" + s;
            return s;
        }

        var y = utc ? date.getUTCFullYear() : date.getFullYear();
        format = format.replace(/(^|[^\\])yyyy+/g, "$1" + y);
        format = format.replace(/(^|[^\\])yy/g, "$1" + y.toString().substr(2, 2));
        format = format.replace(/(^|[^\\])y/g, "$1" + y);

        var M = (utc ? date.getUTCMonth() : date.getMonth()) + 1;
        format = format.replace(/(^|[^\\])MMMM+/g, "$1" + MMMM[0]);
        format = format.replace(/(^|[^\\])MMM/g, "$1" + MMM[0]);
        format = format.replace(/(^|[^\\])MM/g, "$1" + ii(M));
        format = format.replace(/(^|[^\\])M/g, "$1" + M);

        var d = utc ? date.getUTCDate() : date.getDate();
        format = format.replace(/(^|[^\\])dddd+/g, "$1" + dddd[0]);
        format = format.replace(/(^|[^\\])ddd/g, "$1" + ddd[0]);
        format = format.replace(/(^|[^\\])dd/g, "$1" + ii(d));
        format = format.replace(/(^|[^\\])d/g, "$1" + d);

        var H = utc ? date.getUTCHours() : date.getHours();
        format = format.replace(/(^|[^\\])HH+/g, "$1" + ii(H));
        format = format.replace(/(^|[^\\])H/g, "$1" + H);

        var h = H > 12 ? H - 12 : H == 0 ? 12 : H;
        format = format.replace(/(^|[^\\])hh+/g, "$1" + ii(h));
        format = format.replace(/(^|[^\\])h/g, "$1" + h);

        var m = utc ? date.getUTCMinutes() : date.getMinutes();
        format = format.replace(/(^|[^\\])mm+/g, "$1" + ii(m));
        format = format.replace(/(^|[^\\])m/g, "$1" + m);

        var s = utc ? date.getUTCSeconds() : date.getSeconds();
        format = format.replace(/(^|[^\\])ss+/g, "$1" + ii(s));
        format = format.replace(/(^|[^\\])s/g, "$1" + s);

        var f = utc ? date.getUTCMilliseconds() : date.getMilliseconds();
        format = format.replace(/(^|[^\\])fff+/g, "$1" + ii(f, 3));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])ff/g, "$1" + ii(f));
        f = Math.round(f / 10);
        format = format.replace(/(^|[^\\])f/g, "$1" + f);

        var T = H < 12 ? "AM" : "PM";
        format = format.replace(/(^|[^\\])TT+/g, "$1" + T);
        format = format.replace(/(^|[^\\])T/g, "$1" + T.charAt(0));

        var t = T.toLowerCase();
        format = format.replace(/(^|[^\\])tt+/g, "$1" + t);
        format = format.replace(/(^|[^\\])t/g, "$1" + t.charAt(0));

        var tz = -date.getTimezoneOffset();
        var K = utc || !tz ? "Z" : tz > 0 ? "+" : "-";
        if (!utc) {
            tz = Math.abs(tz);
            var tzHrs = Math.floor(tz / 60);
            var tzMin = tz % 60;
            K += ii(tzHrs) + ":" + ii(tzMin);
        }
        format = format.replace(/(^|[^\\])K/g, "$1" + K);

        var day = (utc ? date.getUTCDay() : date.getDay()) + 1;
        format = format.replace(new RegExp(dddd[0], "g"), dddd[day]);
        format = format.replace(new RegExp(ddd[0], "g"), ddd[day]);

        format = format.replace(new RegExp(MMMM[0], "g"), MMMM[M]);
        format = format.replace(new RegExp(MMM[0], "g"), MMM[M]);

        format = format.replace(/\\(.)/g, "$1");

        return format;
    };

    Date.prototype.format = function (format, utc){
        return formatDate(this, format, utc);
    };
}

if (typeof trunc === "undefined")
{
    function trunc(text, n, useWordBoundary)
    {
        if (typeof text === "undefined" || ( typeof text !== "string" && typeof text !== "number")) { return ""; }
        if (typeof text === "number") { text = text.toString(); }

        if (text.length <= n) { return text.substr(0, text.length); }

        let subString = text.substr(0, n-1);

        if (useWordBoundary && subString.lastIndexOf(' ') >= 0)
        {
            return subString.substr(0, subString.lastIndexOf(' ')) + "...";
        }

        return subString + "...";
    }
}

if (typeof ucwords === "undefined")
{
    function ucwords(str)
    {
        if (typeof str === "undefined" || str === null) return "";
        return str.replace(/_/g," ").replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }
}

if (typeof getCart === "undefined")
{
    function getCart()
    {
        // return vue cart object
    }
}

if (typeof getJsonSetting === "undefined")
{
    function getJsonSetting(list, trail, def)
    {
        if (typeof list === "undefined" || list === null)
        {
            return null;
        }
        let trailList = trail.split(".");
        const trailCheck = trailList.shift();

        if (typeof list[trailCheck] === "undefined" || typeof list[trailCheck] === "function")
        {
            if (typeof def !== "undefined") return def;

            return null;
        }

        if (typeof list[trailCheck] !== "array" && typeof list[trailCheck] !== "object")
        {
            return list[trailCheck];
        }

        return getJsonSetting(list[trailCheck], trailList.join("."));
    }
}


if (typeof getJsonSettingDecoded === "undefined")
{
    function getJsonSettingDecoded(list, trail, def)
    {
        let string = getJsonSetting(list, trail);

        return (string !== null) ? atob(string) : def;
    }
}

function siteRoot()
{
    let url = `${window.location.protocol}//${window.location.hostname}`;
    let port = window.location.port;

    if ((port !== '80' || port !== '443') && (port !== ''))
    {
        url += `:${port}`
    }

    return url + "/";
}

function eachInList( obj, callback )
{
    var length, i = 0;

    if ( isArrayLike( obj ) ) {
        length = obj.length;
        for ( ; i < length; i++ ) {
            if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
                break;
            }
        }
    } else {
        for ( i in obj ) {
            if ( callback.call( obj[ i ], i, obj[ i ] ) === false ) {
                break;
            }
        }
    }

    return obj;
}

function slideUp(target, duration = 250, callback)
{
    if (target.style.display === "none" && typeof callback === "function") {
        callback();
    }

    target.style.transitionProperty = 'height, margin, padding';
    target.style.transitionDuration = duration + 'ms';
    target.style.boxSizing = 'border-box';
    target.style.height = target.offsetHeight + 'px';
    target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;

    window.setTimeout( () => {
        target.style.display = 'none';
        target.style.removeProperty('height');
        target.style.removeProperty('padding-top');
        target.style.removeProperty('padding-bottom');
        target.style.removeProperty('margin-top');
        target.style.removeProperty('margin-bottom');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');

        if (typeof callback === "function") {
            callback();
        }
    }, duration);
}

function slideDown(target, duration = 250, callback)
{
    target.style.removeProperty('display');
    let display = window.getComputedStyle(target).display;

    if (display === 'none')
        display = 'block';

    target.style.display = display;
    let height = target.offsetHeight;
    target.style.overflow = 'hidden';
    target.style.height = 0;
    target.style.paddingTop = 0;
    target.style.paddingBottom = 0;
    target.style.marginTop = 0;
    target.style.marginBottom = 0;
    target.offsetHeight;
    target.style.boxSizing = 'border-box';
    target.style.transitionProperty = "height, margin, padding";
    target.style.transitionDuration = duration + 'ms';
    target.style.height = height + 'px';
    target.style.removeProperty('padding-top');
    target.style.removeProperty('padding-bottom');
    target.style.removeProperty('margin-top');
    target.style.removeProperty('margin-bottom');

    window.setTimeout( () =>
    {
        target.style.removeProperty('height');
        target.style.removeProperty('overflow');
        target.style.removeProperty('transition-duration');
        target.style.removeProperty('transition-property');

        if (typeof callback === "function")
        {
            callback();
        }
    }, duration);
}

function slideOver(direction, target, duration = 250, callback)
{
    _.el.style.overflowX = "hidden";
    newComponent.style.display = "block";
    newComponent.style.position = "absolute";
    newComponent.style.left = componentWidth + "px";
    newComponent.style.top = "0px";
    target.style.display = "block";
    target.style.left = "0px";
    target.style.top = "0px";
    target.style.position = "relative";

    vueWrapper.style.removeProperty("right");
    vueWrapper.style.removeProperty("transform");
    vueWrapper.style.removeProperty("transition");
    vueWrapper.style.position = "relative";
    vueWrapper.style.width = (componentWidth * 2) + "px";

    vueWrapper.style.transition = "transform " + transitionTime + "ms ease-out";
    vueWrapper.style.transform = "translateX(-" + componentWidth + "px)";

    window.setTimeout( function() {
        _.el.style.overflowX = "visible";
        if (typeof callback === "function") {
            callback();
        }
    }, transitionTime);
}

const slideToggle = (target, duration = 250) => {
    if (window.getComputedStyle(target).display === 'none') {
        return slideDown(target, duration);
    } else {
        return slideUp(target, duration);
    }
}

function isArrayLike( obj )
{
    var length = !!obj && "length" in obj && obj.length,
        type = toType( obj );

    if ( isFunction( obj ) || isWindow( obj ) ) {
        return false;
    }

    return type === "array" || length === 0 ||
        typeof length === "number" && length > 0 && ( length - 1 ) in obj;
}

function validateEmail(email)
{
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function imageServerUrl()
{
    return "<?php echo $app->getCustomPlatform()->getFullMediaDomainName(false); ?>";
}

function apiServerUrl()
{
    return "<?php echo $app->getCustomPlatform()->getFullApiDomainName(false); ?>";
}

function socketServerUrl()
{
    return "<?php echo $app->getCustomPlatform()->getFullSocketDomainName(false); ?>";
}

function processServerUrl()
{
    return "<?php echo $app->getCustomPlatform()->getFullProcessDomainName(false); ?>";
}

String.prototype.pick = function(min, max) {
    var n, chars = '';

    if (typeof max === 'undefined') {
        n = min;
    } else {
        n = min + Math.floor(Math.random() * (max - min + 1));
    }

    for (var i = 0; i < n; i++) {
        chars += this.charAt(Math.floor(Math.random() * this.length));
    }

    return chars;
};

String.prototype.shuffle = function() {
    var array = this.split('');
    var tmp, current, top = array.length;

    if (top) while (--top) {
        current = Math.floor(Math.random() * (top + 1));
        tmp = array[current];
        array[current] = array[top];
        array[top] = tmp;
    }

    return array.join('');
};

const Cookie =
{
    set: function(name, value, days)
    {
        let domain, domainParts, date, expires, host;

        if (days)
        {
            date = new Date();
            date.setTime(date.getTime()+(days*24*60*60*1000));
            expires = "; expires="+date.toUTCString();
        }
        else
        {
            expires = "";
        }

        host = location.host;
        if (host.split('.').length === 1)
        {
            // no "." in a domain - it's localhost or something similar
            document.cookie = name+"="+value+expires+"; path=/";
        }
        else
        {
            // Remember the cookie on all subdomains.
            //
            // Start with trying to set cookie to the top domain.
            // (example: if user is on foo.com, try to set
            //  cookie to domain ".com")
            //
            // If the cookie will not be set, it means ".com"
            // is a top level domain and we need to
            // set the cookie to ".foo.com"
            domainParts = host.split('.');
            domainParts.shift();
            domain = '.'+domainParts.join('.');

            document.cookie = name+"="+value+expires+"; path=/; domain="+domain;

            // check if cookie was successfuly set to the given domain
            // (otherwise it was a Top-Level Domain)
            if (Cookie.get(name) == null || Cookie.get(name) != value)
            {
                // append "." to current domain
                domain = '.'+host;
                document.cookie = name+"="+value+expires+"; path=/; domain="+domain;
            }
        }
    },

    get: function(name)
    {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for (var i=0; i < ca.length; i++)
        {
            var c = ca[i];
            while (c.charAt(0)==' ')
            {
                c = c.substring(1,c.length);
            }

            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    },

    erase: function(name)
    {
        Cookie.set(name, '', -1);
    }
};

const AutoFillSearch = function(var1, var2) 
{
    const self = this
    const var1Data = var1;
    const var2Data = var2;

    let dynamicSearch = false;
    let entityList = [];
    this.entitySearch = "";
    this.entitySearchResult = "";
    this.entitySearchHighlight = 0;
    this.searchBox = 0;
    this.searchBoxInner = 0;
    this.totalSearchDisplayCount = 0;
    
    const __construct = function()
    {
           
    }

    this.engageDynamicSearch = function(user)
    {
        this.dynamicSearch = true;
    }
    
    this.hideDynamicSearch = function()
    {
        setTimeout(function() {
            if (self.entitySearchResult === "") {
                self.dynamicSearch = false;
            }
        }, 250);
    }
    
    this.keyMonitorEntityList = function(event)
    {
        switch(event.keyCode)
        {
            case 38:
                this.decreaseUserSearchHighlight();
                break;
            case 40:
                this.increaseUserSearchHighlight();
                break;
            case 13:
                let entityByIndex = this.getUserByIndex(this.entitySearchHighlight);
                this.assignEntityToCard(entityByIndex, this.entitySearchHighlight);
                break;
            default:
                this.entitySearchHighlight = 0;
                break;
        }

        this.customerList = this.customerList;
        this.$forceUpdate();
    }
    
    const getMiddleOffset = function()
    {
        const boxHeight = (this.searchBoxInner.offsetHeight / (this.totalSearchDisplayCount + 1));
        const boxContains = Math.ceil(this.searchBox.offsetHeight / boxHeight);
        return [boxHeight, (boxContains / 2) - 2];
    }
    
    const increaseUserSearchHighlight = function()
    {
        this.entitySearchHighlight++;
        const [boxHeight, middleOffset] = getMiddleOffset();
        this.searchBox.scroll(0, ((this.entitySearchHighlight - middleOffset) * boxHeight));
    }
    
    const decreaseUserSearchHighlight = function()
    {
        if (this.entitySearchHighlight === 0) { return; }
        this.entitySearchHighlight--;
        const [boxHeight, middleOffset] = getMiddleOffset();
        this.searchBox.scroll(0, ((this.entitySearchHighlight - middleOffset) * boxHeight));
    }
    
    const entitySearchMatchesIndex = function(index)
    {
        if (index !== this.entitySearchHighlight)
        {
            return false;
        }

        return true;
    }
    
    const parseEntitiesBySearch = function(usersList)
    {
        const self = this;
        let newUserList = [];

        if (typeof usersList.length !== "number" || usersList.length === 0)
        {
            return newUserList;
        }

        let intTotalCount = 0;

        for (let currUser of usersList)
        {
            if (intTotalCount > 25) { break; }
            if (
                currUser.first_name.toLowerCase().includes(self.entitySearch.toLowerCase()) ||
                currUser.last_name.toLowerCase().includes(self.entitySearch.toLowerCase()) ||
                (currUser.first_name.toLowerCase() + " " + currUser.last_name.toLowerCase()).includes(self.entitySearch.toLowerCase()) ||
                currUser.user_id.toString().toLowerCase().includes(self.entitySearch.toLowerCase())
            )
            {
                newUserList.push(currUser);
                intTotalCount++;
            }
        }

        return newUserList;
    }
    
    const getUserByIndex = function(index)
    {
        const users = this.cartCustomerSearchList;

        for(let currUserIndex in users)
        {
            if (currUserIndex == index)
            {
                return users[currUserIndex];
            }
        }

        return null;
    }
    
    const assignCustomerToCard = function(user, index)
    {
        if (user === null) { return; }

        this.entitySearch = ""
        this.entitySearchResult = user.first_name + " " + user.last_name;
        this.entityClone.card_user_id = user.user_id;
        this.entityClone.card_user_email = user.user_email;
        this.entityClone.card_user_phone = user.user_phone;
        this.dynamicSearch = false;
        this.entitySearchHighlight = index;
    }
    
    const loadCustomers = function(callback)
    {
        const self = this;
        const url = "' . $app->objCustomPlatform->getFullPortalDomainName() . '/cart/get-all-card-users-count";

        ajax.GetExternal(url, {}, true, function(result)
        {
            if (result.success === false)
            {
                return;
            }

            if (self.customerList.length == result.response.data.count)
            {
                const customersList = Object.entries(self.customerList);
                customersList.forEach(function([user_id, currUser])
                {
                    if (currUser.user_id == self.entityClone.card_user_id)
                    {
                        self.entitySearchResult = currUser.first_name + " " + currUser.last_name;
                    }
                });

                return;
            }

            self.customerList = [];
            const url = "' . $app->objCustomPlatform->getFullPortalDomainName() . '/cart/get-all-card-users";

            ajax.GetExternal(url, {}, true, function(result)
            {
                if (result.success === false)
                {
                    return;
                }

                const users = Object.entries(result.response.data.list);

                users.forEach(function([user_id, currUser])
                {
                    if (user_id == self.entityClone.card_user_id)
                    {
                        self.entitySearchResult = currUser.first_name + " " + currUser.last_name;
                    }

                    self.customerList.push(currUser);
                });

                self.$forceUpdate();
            });
        });


    }
    
    this.clearSelectedValue = function()
    {
        this.entitySearchResult = "";
        this.entitySearch = "";
    }

    __construct();
}



let thisNewVar = new AutoFillSearch();