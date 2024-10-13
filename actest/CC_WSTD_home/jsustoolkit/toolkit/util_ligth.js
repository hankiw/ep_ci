(function(){function q(k){var b=k.util=k.util||{},l=k.jsustoolkitErrCode=k.jsustoolkitErrCode||{};b.ByteBuffer=function(a){this.data=a||"";this.read=0};b.ByteBuffer.prototype.length=function(){return this.data.length-this.read};b.ByteBuffer.prototype.isEmpty=function(){return 0===this.data.length-this.read};b.ByteBuffer.prototype.putByte=function(a){this.data+=String.fromCharCode(a)};b.ByteBuffer.prototype.fillWithByte=function(a,c){a=String.fromCharCode(a);for(var d=this.data;0<c;)c&1&&(d+=a),c>>>=
1,0<c&&(a+=a);this.data=d};b.ByteBuffer.prototype.putBytes=function(a){this.data+=a};b.ByteBuffer.prototype.putString=function(a){this.data+=b.encodeUtf8(a)};b.ByteBuffer.prototype.putInt32=function(a){this.data+=String.fromCharCode(a>>24&255)+String.fromCharCode(a>>16&255)+String.fromCharCode(a>>8&255)+String.fromCharCode(a&255)};b.ByteBuffer.prototype.putBuffer=function(a){this.data+=a.getBytes()};b.ByteBuffer.prototype.getByte=function(){return this.data.charCodeAt(this.read++)};b.ByteBuffer.prototype.getInt32=
function(){var a=this.data.charCodeAt(this.read)<<24^this.data.charCodeAt(this.read+1)<<16^this.data.charCodeAt(this.read+2)<<8^this.data.charCodeAt(this.read+3);this.read+=4;return a<<32>>>32};b.ByteBuffer.prototype.getInt=function(a){var c=0;do c=(c<<a)+this.data.charCodeAt(this.read++),a-=8;while(0<a);return c};b.ByteBuffer.prototype.getBytes=function(a){var c;a?(a=Math.min(this.length(),a),c=this.data.slice(this.read,this.read+a),this.read+=a):0===a?c="":(c=0===this.read?this.data:this.data.slice(this.read),
this.clear());return c};b.ByteBuffer.prototype.bytes=function(a){return"undefined"===typeof a?this.data.slice(this.read):this.data.slice(this.read,this.read+a)};b.ByteBuffer.prototype.at=function(a){return this.data.charCodeAt(this.read+a)};b.ByteBuffer.prototype.setAt=function(a,c){this.data=this.data.substr(0,this.read+a)+String.fromCharCode(c)+this.data.substr(this.read+a+1)};b.ByteBuffer.prototype.last=function(){return this.data.charCodeAt(this.data.length-1)};b.ByteBuffer.prototype.copy=function(){var a=
b.createBuffer(this.data);a.read=this.read;return a};b.ByteBuffer.prototype.compact=function(){0<this.read&&(this.data=this.data.slice(this.read),this.read=0)};b.ByteBuffer.prototype.clear=function(){this.data="";this.read=0};b.ByteBuffer.prototype.truncate=function(a){a=Math.max(0,this.length()-a);this.data=this.data.substr(this.read,a);this.read=0};b.ByteBuffer.prototype.toHex=function(){for(var a="",c=this.read;c<this.data.length;++c){var d=this.data.charCodeAt(c);16>d&&(a+="0");a+=d.toString(16)}return a};
b.ByteBuffer.prototype.toBinaryString=function(){for(var a="",c=this.read;c<this.data.length;++c){var d=this.data.charCodeAt(c);16>d&&(a+="0000");a+=d.toString(2)}return a};b.ByteBuffer.prototype.toSubHex=function(a){for(var c="",d=this.read;d<this.read+a;++d){var b=this.data.charCodeAt(d);16>b&&(c+="0");c+=b.toString(16)}return c};b.ByteBuffer.prototype.toString=function(){return b.decodeUtf8(this.bytes())};b.createBuffer=function(a,c){void 0!==a&&"utf8"===(c||"raw")&&(a=b.encodeUtf8(a));return new b.ByteBuffer(a)};
b.fillString=function(a,c){for(var d="";0<c;)c&1&&(d+=a),c>>>=1,0<c&&(a+=a);return d};b.hexToBytes=function(a){var c="";a.length&1&&(a="0"+a);for(var d=0;d<a.length;d+=2)c+=String.fromCharCode(parseInt(a.substr(d,2),16));return c};b.bytesToHex=function(a){return b.createBuffer(a).toHex()};b.bytesToBinaryString=function(a){return b.createBuffer(a).toBinaryString()};b.stringToBytes=function(a){return b.hexToBytes(b.createBuffer(a).toHex())};b.bytesToString=function(a){return b.createBuffer(a).toString()};
b.int32ToBytes=function(a){return String.fromCharCode(a>>24&255)+String.fromCharCode(a>>16&255)+String.fromCharCode(a>>8&255)+String.fromCharCode(a&255)};var m=[62,-1,-1,-1,63,52,53,54,55,56,57,58,59,60,61,-1,-1,-1,64,-1,-1,-1,0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,-1,-1,-1,-1,-1,-1,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51];b.encode64=function(a,c){for(var d="",b="",f,e,g,l=0;l<a.length;)f=a.charCodeAt(l++),e=a.charCodeAt(l++),g=a.charCodeAt(l++),
d+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(f>>2),d+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt((f&3)<<4|e>>4),isNaN(e)?d+="==":(d+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt((e&15)<<2|g>>6),d+=isNaN(g)?"=":"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=".charAt(g&63)),c&&d.length>c&&(b+=d.substr(0,c)+"\r\n",d=d.substr(c));return b+d};b.decode64=function(a){if(null==a||"undefined"==
typeof a)throw{code:"119005",message:l["119005"]};a=a.replace(/[^A-Za-z0-9\+\/\=]/g,"");for(var c="",d,b,f,e,g=0;g<a.length;)d=m[a.charCodeAt(g++)-43],b=m[a.charCodeAt(g++)-43],f=m[a.charCodeAt(g++)-43],e=m[a.charCodeAt(g++)-43],c+=String.fromCharCode(d<<2|b>>4),64!==f&&(c+=String.fromCharCode((b&15)<<4|f>>2),64!==e&&(c+=String.fromCharCode((f&3)<<6|e)));return c};b.encodeUtf8=function(a){return unescape(encodeURIComponent(a))};b.decodeUtf8=function(a){return decodeURIComponent(escape(a))};b.deflate=
function(a,c,d){c=b.decode64(a.deflate(b.encode64(c)).rval);d&&(a=2,c.charCodeAt(1)&32&&(a=6),c=c.substring(a,c.length-4));return c};b.inflate=function(a,c,d){a=a.inflate(b.encode64(c)).rval;return null===a?null:b.decode64(a)};b.trim=function(a){return a.replace(/^\s*|\s*$/g,"")};var n=function(a,c,d){if(!a)throw{code:"119001",message:l["119001"]};null===d?a=a.removeItem(c):(d=b.encode64(JSON.stringify(d)),a=a.setItem(c,d));if("undefined"!==typeof a&&!0!==a.rval)throw{code:"119002",message:l["119002"]+
a.error};},t=function(a,c){if(!a)throw{code:"119003",message:l["119003"]};var d=a.getItem(c);if(a.init)if(null===d.rval){if(d.error)throw d.error;d=null}else d=d.rval;null!==d&&(d=JSON.parse(b.decode64(d)));return d},p=function(a,c,d,b){var f=t(a,c);null===f&&(f={});f[d]=b;n(a,c,f)},q=function(a,c,d){a=t(a,c);null!==a&&(a=d in a?a[d]:null);return a},s=function(a,c,d){var b=t(a,c);if(null!==b&&d in b){delete b[d];d=!0;for(var f in b){d=!1;break}d&&(b=null);n(a,c,b)}},v=function(a,c){n(a,c,null)},r=
function(a,c,d){var b=null;"undefined"===typeof d&&(d=["web","flash"]);var f,e=!1,g=null,k;for(k in d){f=d[k];try{if("flash"===f||"both"===f){if(null===c[0])throw{code:"119004",message:l["119004"]};b=a.apply(this,c);e="flash"===f}if("web"===f||"both"===f)c[0]=localStorage,b=a.apply(this,c),e=!0}catch(m){g=m}if(e)break}if(!e)throw g;return b};b.setItem=function(a,c,d,b,f){r(p,arguments,f)};b.getItem=function(a,c,d,b){return r(q,arguments,b)};b.removeItem=function(a,c,d,b){r(s,arguments,b)};b.clearItems=
function(a,c,d){r(v,arguments,d)};b.parseUrl=function(a){var c=/^(https?):\/\/([^:&^\/]*):?(\d*)(.*)$/g;c.lastIndex=0;c=c.exec(a);if(a=null===c?null:{full:a,scheme:c[1],host:c[2],port:c[3],path:c[4]})a.fullHost=a.host,a.port?80!==a.port&&"http"===a.scheme?a.fullHost+=":"+a.port:443!==a.port&&"https"===a.scheme&&(a.fullHost+=":"+a.port):"http"===a.scheme?a.port=80:"https"===a.scheme&&(a.port=443),a.full=a.scheme+"://"+a.fullHost;return a};var u=null;b.getQueryVariables=function(a){var c=function(a){var c=
{};a=a.split("&");for(var b=0;b<a.length;b++){var e=a[b].indexOf("="),g;0<e?(g=a[b].substring(0,e),e=a[b].substring(e+1)):(g=a[b],e=null);g in c||(c[g]=[]);null!==e&&c[g].push(unescape(e))}return c};"undefined"===typeof a?(null===u&&(u="undefined"===typeof window?{}:c(window.location.search.substring(1))),a=u):a=c(a);return a};b.parseFragment=function(a){var c=a,d="",h=a.indexOf("?");0<h&&(c=a.substring(0,h),d=a.substring(h+1));a=c.split("/");0<a.length&&""==a[0]&&a.shift();h=""==d?{}:b.getQueryVariables(d);
return{pathString:c,queryString:d,path:a,query:h}};b.makeRequest=function(a){var c=b.parseFragment(a),d={path:c.pathString,query:c.queryString,getPath:function(a){return"undefined"===typeof a?c.path:c.path[a]},getQuery:function(a,b){var d;"undefined"===typeof a?d=c.query:(d=c.query[a])&&"undefined"!==typeof b&&(d=d[b]);return d},getQueryLast:function(a,c){var b=d.getQuery(a);return b?b[b.length-1]:c}};return d};b.makeLink=function(a,c,b){a=jQuery.isArray(a)?a.join("/"):a;c=jQuery.param(c||{});b=b||
"";return a+(0<c.length?"?"+c:"")+(0<b.length?"#"+b:"")};b.setPath=function(a,c,b){if("object"===typeof a&&null!==a)for(var h=0,f=c.length;h<f;){var e=c[h++];if(h==f)a[e]=b;else{var g=e in a;if(!g||g&&"object"!==typeof a[e]||g&&null===a[e])a[e]={};a=a[e]}}};b.getPath=function(a,c,b){for(var h=0,f=c.length,e=!0;e&&h<f&&"object"===typeof a&&null!==a;){var g=c[h++];(e=g in a)&&(a=a[g])}return e?a:b};b.deletePath=function(a,c){if("object"===typeof a&&null!==a)for(var b=0,h=c.length;b<h;){var f=c[b++];
if(b==h)delete a[f];else{if(!(f in a)||"object"!==typeof a[f]||null===a[f])break;a=a[f]}}};b.isEmpty=function(a){for(var c in a)if(a.hasOwnProperty(c))return!1;return!0};b.format=function(a){var c=/%./g,b,h,f=0,e=[];for(h=0;b=c.exec(a);)switch(h=a.substring(h,c.lastIndex-2),0<h.length&&e.push(h),h=c.lastIndex,b=b[0][1],b){case "s":case "o":f<arguments.length?e.push(arguments[f++ +1]):e.push("<?>");break;case "%":e.push("%");break;default:e.push("<%"+b+"?>")}e.push(a.substring(h));return e.join("")};
b.formatNumber=function(a,b,d,h){var f=isNaN(b=Math.abs(b))?2:b;b=void 0===d?",":d;h=void 0===h?".":h;d=0>a?"-":"";var e=parseInt(a=Math.abs(+a||0).toFixed(f),10)+"",g=3<e.length?e.length%3:0;return d+(g?e.substr(0,g)+h:"")+e.substr(g).replace(/(\d{3})(?=\d)/g,"$1"+h)+(f?b+Math.abs(a-e).toFixed(f).slice(2):"")};b.formatSize=function(a){return a=1073741824<=a?b.formatNumber(a/1073741824,2,".","")+" GiB":1048576<=a?b.formatNumber(a/1048576,2,".","")+" MiB":1024<=a?b.formatNumber(a/1024,0)+" KiB":b.formatNumber(a,
0)+" bytes"};window.crosscert=window.crosscert;k.util=k.util;b.hexToBytes=k.util.hexToBytes;b.encode64=k.util.encode64;b.decode64=k.util.decode64;b.createBuffer=k.util.createBuffer}var s=[],p=null;"function"!==typeof define&&("object"===typeof module&&module.exports?p=function(k,b){b(require,module)}:(crosscert=window.crosscert=window.crosscert||{},q(crosscert)));(p||"function"===typeof define)&&(p||define)(["require","module"].concat(s),function(k,b){b.exports=function(b){var m=s.map(function(b){return k(b)}).concat(q);
b=b||{};b.defined=b.defined||{};if(b.defined.util)return b.util;b.defined.util=!0;for(var n=0;n<m.length;++n)m[n](b);return b.util}})})();