<?php
?>
function AjaxApp()
{
    this.Get = function(endPoint, data, callback)
    {
        return this.Send("GET", endPoint, data, callback);
    }

    this.Post = function(endPoint, data, callback)
    {
        return this.Send("POST", endPoint, data, callback);
    }

    this.Send = function(verb, endPoint, data, callback)
    {
        if ( !verb ) { verb = "POST"; }

        const url = siteRoot() + endPoint;

        if (typeof callback === "function")
        {
            sendAjax(url, verb, data, callback);
            return;
        }

        return new Promise(function(resolve, reject)
        {
            sendAjax(url, verb, data, {resolve: resolve, reject: reject});
        });
    }

    this.GetExternal = function(url, security, callback)
    {
        return this.SendExternal("GET", url, "", security, callback);
    }

    this.PostExternal = function(url, data, security, callback)
    {
        return this.SendExternal("POST", url, data, security, callback);
    }

    this.SendExternal = function(type, url, data, security, callback)
    {
        let processData = true;
        let verb = type;
        let options = {type: "json"};

        if (type === "form")
        {
            processData = false;
            options.type = "form"
            verb = "post";
        }

        if (data && processData && typeof data !== "string" ) {

            data = serializeData( data, false );
        }

        if (typeof callback === "function")
        {
            sendAjax(url, verb, data, callback, {security: security});
            return;
        }

        return new Promise(function(resolve, reject)
        {
            sendAjax(url, verb, data, null, {resolve: resolve, reject: reject, security: security});
        });
    }

    const sendAjax = function(url, verb, data, callback, options)
    {
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function()
        {
            if (this.readyState == 4)
            {
                processCallback(this, xhr, callback);
                processOptions(this, xhr, options);
            }
        };

        xhr.open(verb, url, true);

        const username = Cookie.get('user');
        const instance = Cookie.get('instance');

        if (typeof options !== "undefined" && options.security === true && username !== "visitor")
        {
            xhr.setRequestHeader ("Authorization", "Basic " + btoa(username + ":" + instance));
            xhr.setRequestHeader ("RequestType", "Ajax");
        }

        if ( typeof callback !== "function")
        {
            xhr.onerror = function() {
                options.reject(Error("network error"));
            };
        }

        xhr.setRequestHeader("Content-type", setAjaxSendType(options));

        xhr.send(JSON.stringify(data));
    }

    const processCallback = function(self, xhr, callback)
    {
        if (typeof callback === "function")
        {
            if (xhr.status === 200)
            {
                callback({success: true, response: parseReturnedText(self.responseText)});
            }
            else
            {
                callback({success: false, response: self.statusText});
            }
        }
    }

    const processOptions = function(self, xhr, options)
    {
        if (typeof options !== "undefined" && options !== null)
        {
            if (xhr.status === 200)
            {
                if (typeof options.resolve === "function")
                {
                    options.resolve({success: true, response: parseReturnedText(self.responseText)});
                }
            }
            else
            {
                if (typeof options.reject === "function")
                {
                    options.reject(Error(self.statusText));
                }
            }
        }
    }

    const parseReturnedText = function(text)
    {
        let data = {}
        try {
            data = JSON.parse(text);
        } catch (ex) {
            return {};
        }

        if ( data.title )
        {
            data.title = atob(data.title);
        }

        if ( data.html )
        {
            data.html = atob(data.html);
        }

        return data;
    }

    const setAjaxSendType = function (options)
    {
        if (typeof options === "undefined" || typeof options.type === "undefined"  || options.type === "json" ) { return "application/json;charset=UTF-8"; }

        switch(type)
        {
            case "form":
                return "application/x-www-form-urlencoded; charset=UTF-8";
        }
    }

    const siteRoot = function()
    {
        let url = `${window.location.protocol}//${window.location.hostname}`;
        let port = window.location.port;

        if ((port !== '80' || port !== '443') && (port !== ''))
        {
            url += `:${port}`
        }

        return url + "/";
    }

    const serializeData = function( a, traditional )
    {
        let prefix,
            s = [],
            add = function( key, valueOrFunction )
            {

                // If value is a function, invoke it and use its return value
                var value = isFunction( valueOrFunction ) ?
                    valueOrFunction() :
                    valueOrFunction;

                s[ s.length ] = key + "=" +
                    encodeURIComponent( value == null ? "" : value );
            };

        if ( a == null )
        {
            return "";
        }

        if (Array.isArray( a ))
        {
            for(let currEl in a)
            {
                add( currEl.name, currEl.value );
            };

        }
        else
        {
            for ( prefix in a ) {
                buildParams( prefix, a[ prefix ], traditional, add );
            }
        }

        return s.join( "&" );
    }

    const isFunction = function(obj)
    {
        return typeof obj === "function" && typeof obj.nodeType !== "number";
    }

    const buildParams = function(prefix, obj, traditional, add)
    {
        let name,
            rbracket = /\[\]$/;

        if ( Array.isArray( obj ) )
        {
            eachInList( obj, function( i, v ) {
                if ( traditional || rbracket.test( prefix ) )
                {
                    add( prefix, v );
                }
                else
                {
                    buildParams(
                        prefix + "[" + ( typeof v === "object" && v != null ? i : "" ) + "]",
                        v,
                        traditional,
                        add
                    );
                }
            } );

        }
        else if ( !traditional && (typeof obj === "object" || typeof obj === "function") )
        {
            // Serialize object item.
            for ( name in obj ) {
                buildParams( prefix + "[" + name + "]", obj[ name ], traditional, add );
            }
        }
        else
        {
            add( prefix, obj );
        }
    }

    const eachInList = function( obj, callback )
    {
        let length, i = 0;

        if ( isArrayLike( obj ) )
        {
            length = obj.length;
            for ( ; i < length; i++ )
            {
                if ( callback.call( obj[ i ], i, obj[ i ] ) === false )
                {
                    break;
                }
            }
        }
        else
        {
            for ( i in obj )
            {
                if ( callback.call( obj[ i ], i, obj[ i ] ) === false )
                {
                    break;
                }
            }
        }

        return obj;
    }

    const isArrayLike = function( obj )
    {
        let length = !!obj && "length" in obj && obj.length,
            type = toType( obj );

        if ( isFunction( obj ) || isWindow( obj ) ) {
            return false;
        }

        return type === "array" || length === 0 ||
            typeof length === "number" && length > 0 && ( length - 1 ) in obj;
    }

    const toType = function( obj ) {
        if ( obj == null ) {
            return obj + "";
        }

        // Support: Android <=2.3 only (functionish RegExp)
        return typeof obj === "object" || typeof obj === "function" ?
            class2type[ toString.call( obj ) ] || "object" :
            typeof obj;
    }

    const isWindow = function( obj ) {
        return obj != null && obj === obj.window;
    };

    let class2type = {};
}
