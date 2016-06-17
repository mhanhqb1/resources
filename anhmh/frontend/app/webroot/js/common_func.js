
/**
 * detect IE
 * returns version of IE or false, if browser is not Internet Explorer
 */
function detectIE() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf('MSIE ');
    if (msie > 0) {
        // IE 10 or older => return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
    }

    var trident = ua.indexOf('Trident/');
    if (trident > 0) {
        // IE 11 => return version number
        var rv = ua.indexOf('rv:');
        return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
    }

    var edge = ua.indexOf('Edge/');
    if (edge > 0) {
        // IE 12 => return version number
        return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
    }

    // other browser
    return false;
}

/**
 * Add bind function if not exist
 */
if (!Function.prototype.bind) {
    Function.prototype.bind = function (oThis) {
        if (typeof this !== 'function') {
            // closest thing possible to the ECMAScript 5
            // internal IsCallable function
            throw new TypeError('Function.prototype.bind - what is trying to be bound is not callable');
        }

        var aArgs = Array.prototype.slice.call(arguments, 1),
            fToBind = this,
            fNOP = function () {},
            fBound = function () {
                return fToBind.apply(this instanceof fNOP && oThis ? this : oThis, aArgs.concat(Array.prototype.slice.call(arguments)));
            };

        fNOP.prototype = this.prototype;
        fBound.prototype = new fNOP();

        return fBound;
    };
}

function isNumber(str) {
    var alphaExp = /^[0-9]+$/;
    if (str.match(alphaExp)) {
        return true;
    }
    return false;
}

if (!String.prototype.format) {
    String.prototype.format = function () {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function (match, number) {
            return typeof args[number] !== 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

function buildUrlPage() {
    var url = window.location.href; 
    var posQuery = url.indexOf("?");
    var query = '';
    
    if (posQuery > 0) {
        var url2 = url.substr(0, posQuery);
        query = url.substr(posQuery);
        url = url2;
    }
    var p = url.lastIndexOf("/");
    if (p > 0) {
        page = url.substr(p + 1);
        if (isNumber(page) === false) {
            page = 1;
        } else {
            url = url.substr(0, p);
        }
    }     
    if (url.substr(-1, 1) == '/') {
        url = url + (parseInt(page)+1);    
    } else {
        url = url + '/' + (parseInt(page)+1);       
    }
    url = url + query;
    
    return url;
}
