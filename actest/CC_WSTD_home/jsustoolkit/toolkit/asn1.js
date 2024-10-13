(function(){function s(k){var l=k.jsustoolkitErrCode=k.jsustoolkitErrCode||{},c=k.asn1=k.asn1||{};c.Class={UNIVERSAL:0,APPLICATION:64,CONTEXT_SPECIFIC:128,PRIVATE:192};c.Type={NONE:0,BOOLEAN:1,INTEGER:2,BITSTRING:3,OCTETSTRING:4,NULL:5,OID:6,ODESC:7,EXTERNAL:8,REAL:9,ENUMERATED:10,EMBEDDED:11,UTF8:12,ROID:13,SEQUENCE:16,SET:17,PRINTABLESTRING:19,IA5STRING:22,UTCTIME:23,GENERALIZEDTIME:24,BMPSTRING:30};c.create=function(a,d,f,b){if(b.constructor==Array){for(var e=[],c=0;c<b.length;++c)void 0!==b[c]&&e.push(b[c]);b=e}return{tagClass:a,type:d,constructed:f,composed:f||b.constructor==Array,value:b}};c.fromDer=function(a){if(null==a||"undefined"==typeof a)throw{code:"110005",message:l["110005"]};a.constructor==String&&(a=k.util.createBuffer(a));if(2>a.length())throw{code:"110001",message:l["110001"]+"(bytes:"+a.length()+")"};var d=a.getByte(),f=d&192,b=d&31,e;e=a;var g=e.getByte();e=128==g?void 0:g&128?e.getInt((g&127)<<3):g;if(a.length()<e)throw{code:"110002",message:l["110002"]+"(detail:"+a.length()+" < "+e+")"};g=d=32==(d&32);if(!g&&f===c.Class.UNIVERSAL&&b===c.Type.BITSTRING&&1<e){var h=a.read;0===a.getByte()&&(g=!1);a.read=h}if(g)if(g=[],void 0===e)for(;;){if(a.bytes(2)===String.fromCharCode(0,0)){a.getBytes(2);break}g.push(c.fromDer(a))}else for(h=a.length();0<e;)g.push(c.fromDer(a)),e-=h-a.length(),h=a.length();else{if(void 0===e)throw{code:"110004",message:l["110004"]};if(b===c.Type.BMPSTRING)for(g="",h=0;h<e;h+=2)g+=String.fromCharCode(a.getInt16());else g=a.getBytes(e)}return c.create(f,b,d,g)};c.toDer=function(a){var d=k.util.createBuffer(),f=a.tagClass|a.type,b=k.util.createBuffer();if(a.composed){a.constructed?f|=32:b.putByte(0);for(var e=0;e<a.value.length;++e)void 0!==a.value[e]&&b.putBuffer(c.toDer(a.value[e]))}else if(a.type===c.Type.BMPSTRING)for(e=0;e<a.value.length;++e)b.putInt16(a.value.charCodeAt(e));else b.putBytes(a.value);d.putByte(f);if(127>=b.length())d.putByte(b.length()&127);else{e=b.length();a="";do a+=String.fromCharCode(e&255),e>>>=8;while(0<e);d.putByte(a.length|128);for(e=a.length-1;0<=e;--e)d.putByte(a.charCodeAt(e))}d.putBuffer(b);return d};c.oidToDer=function(a){a=a.split(".");var d=k.util.createBuffer();d.putByte(40*parseInt(a[0],10)+parseInt(a[1],10));for(var c,b,e,g,h=2;h<a.length;++h){c=!0;b=[];e=parseInt(a[h],10);do g=e&127,e>>>=7,c||(g|=128),b.push(g),c=!1;while(0<e);for(c=b.length-1;0<=c;--c)d.putByte(b[c])}return d};c.derToOid=function(a){var d;a.constructor==String&&(a=k.util.createBuffer(a));var c=a.getByte();d=Math.floor(c/40)+"."+c%40;for(var b=0;0<a.length();)c=a.getByte(),b<<=7,c&128?b+=c&127:(d+="."+(b+c),b=0);return d};c.utcTimeToDate=function(a){var d=new Date,c=parseInt(a.substr(0,2),10),c=50<=c?1900+c:2E3+c,b=parseInt(a.substr(2,2),10)-1,e=parseInt(a.substr(4,2),10),g=parseInt(a.substr(6,2),10),h=parseInt(a.substr(8,2),10),k=0;if(11<a.length){var n=a.charAt(10),m=10;"+"!==n&&"-"!==n&&(k=parseInt(a.substr(10,2),10),m+=2)}d.setUTCFullYear(c,b,e);d.setUTCHours(g,h,k,0);m&&(n=a.charAt(m),"+"===n||"-"===n)&&(c=parseInt(a.substr(m+1,2),10),a=parseInt(a.substr(m+4,2),10),a=6E4*(60*c+a),"+"===n?d.setTime(+d-a):d.setTime(+d+a));return d};c.generalizedTimeToDate=function(a){var d=new Date,c=parseInt(a.substr(0,4),10),b=parseInt(a.substr(4,2),10)-1,e=parseInt(a.substr(6,2),10),g=parseInt(a.substr(8,2),10),h=parseInt(a.substr(10,2),10),k=parseInt(a.substr(12,2),10),n=0,m=0,l=!1;"Z"==a.charAt(a.length-1)&&(l=!0);var p=a.length-5,q=a.charAt(p);if("+"===q||"-"===q)m=parseInt(a.substr(p+1,2),10),p=parseInt(a.substr(p+4,2),10),m=6E4*(60*m+p),"+"===q&&(m*=-1),l=!0;"."==a.charAt(14)&&(n=1E3*parseFloat(a.substr(14),10));l?(d.setUTCFullYear(c,b,e),d.setUTCHours(g,h,k,n),d.setTime(+d+m)):(d.setFullYear(c,b,e),d.setHours(g,h,k,n));return d};c.dateToUtcTime=function(a){var c="",f=[];f.push((""+a.getUTCFullYear()).substr(2));f.push(""+(a.getUTCMonth()+1));f.push(""+a.getUTCDate());f.push(""+a.getUTCHours());f.push(""+a.getUTCMinutes());f.push(""+a.getUTCSeconds());for(a=0;a<f.length;++a)2>f[a].length&&(c+="0"),c+=f[a];return c+"Z"};c.dateToGeneralizedTime=function(a){var c="",f=[];f.push(""+a.getUTCFullYear());f.push(""+(a.getUTCMonth()+1));f.push(""+a.getUTCDate());f.push(""+a.getUTCHours());f.push(""+a.getUTCMinutes());f.push(""+a.getUTCSeconds());for(a=0;a<f.length;++a)0==a?4>f[a].length&&(c+="0"):2>f[a].length&&(c+="0"),c+=f[a];return c+"Z"};c.validate=function(a,d,f,b){var e=!1;if(a.tagClass!==d.tagClass&&"undefined"!==typeof d.tagClass||a.type!==d.type&&"undefined"!==typeof d.type)b&&(a.tagClass!==d.tagClass&&b.push("["+d.name+'] Expected tag class "'+d.tagClass+'", got "'+a.tagClass+'"'),a.type!==d.type&&b.push("["+d.name+'] Expected type "'+d.type+'", got "'+a.type+'"'));else if(a.constructed===d.constructed||"undefined"===typeof d.constructed){e=!0;if(d.value&&d.value.constructor==Array)for(var g=0,h=0;e&&h<d.value.length;++h)e=d.value[h].optional||!1,a.value[g]&&((e=c.validate(a.value[g],d.value[h],f,b))?++g:d.value[h].optional&&(e=!0)),!e&&b&&b.push("["+d.name+'] Tag class "'+d.tagClass+'", type "'+d.type+'" expected value length "'+d.value.length+'", got "'+a.value.length+'"');e&&f&&(d.capture&&(f[d.capture]=a.value),d.captureAsn1&&(f[d.captureAsn1]=a))}else b&&b.push("["+d.name+'] Expected constructed "'+d.constructed+'", got "'+a.constructed+'"');return e};var q=/[^\\u0000-\\u00ff]/;c.prettyPrint=function(a,d,f){var b="";d=d||0;f=f||2;0<d&&(b+="\n");for(var e="",g=0;g<d*f;++g)e+=" ";b+=e+"Tag: ";switch(a.tagClass){case c.Class.UNIVERSAL:b+="Universal:";break;case c.Class.APPLICATION:b+="Application:";break;case c.Class.CONTEXT_SPECIFIC:b+="Context-Specific:";break;case c.Class.PRIVATE:b+="Private:"}if(a.tagClass===c.Class.UNIVERSAL)switch(b+=a.type,a.type){case c.Type.NONE:b+=" (None)";break;case c.Type.BOOLEAN:b+=" (Boolean)";break;case c.Type.BITSTRING:b+=" (Bit string)";break;case c.Type.INTEGER:b+=" (Integer)";break;case c.Type.OCTETSTRING:b+=" (Octet string)";break;case c.Type.NULL:b+=" (Null)";break;case c.Type.OID:b+=" (Object Identifier)";break;case c.Type.ODESC:b+=" (Object Descriptor)";break;case c.Type.EXTERNAL:b+=" (External or Instance of)";break;case c.Type.REAL:b+=" (Real)";break;case c.Type.ENUMERATED:b+=" (Enumerated)";break;case c.Type.EMBEDDED:b+=" (Embedded PDV)";break;case c.Type.UTF8:b+=" (UTF8)";break;case c.Type.ROID:b+=" (Relative Object Identifier)";break;case c.Type.SEQUENCE:b+=" (Sequence)";break;case c.Type.SET:b+=" (Set)";break;case c.Type.PRINTABLESTRING:b+=" (Printable String)";break;case c.Type.IA5String:b+=" (IA5String (ASCII))";break;case c.Type.UTCTIME:b+=" (UTC time)";break;case c.Type.GENERALIZEDTIME:b+=" (Generalized time)";break;case c.Type.BMPSTRING:b+=" (BMP String)"}else b+=a.type;b=b+"\n"+(e+"Constructed: "+a.constructed+"\n");if(a.composed){for(var h=0,l="",g=0;g<a.value.length;++g)void 0!==a.value[g]&&(h+=1,l+=c.prettyPrint(a.value[g],d+1,f),g+1<a.value.length&&(l+=","));b+=e+"Sub values: "+h+l}else b+=e+"Value: ",a.type===c.Type.OID?(a=c.derToOid(a.value),b+=a,k.pki&&k.pki.oids&&a in k.pki.oids&&(b+=" ("+k.pki.oids[a]+")")):b=q.test(a.value)?b+("0x"+k.util.createBuffer(a.value,"utf8").toHex()):0===a.value.length?b+"[null]":b+a.value;return b}}var t=["./util","./oids","./jsustoolkitErrCode"],r=null;"function"!==typeof define&&("object"===typeof module&&module.exports?r=function(k,l){l(require,module)}:(crosscert=window.crosscert=window.crosscert||{},s(crosscert)));(r||"function"===typeof define)&&(r||define)(["require","module"].concat(t),function(k,l){l.exports=function(c){var l=t.map(function(a){return k(a)}).concat(s);c=c||{};c.defined=c.defined||{};if(c.defined.asn1)return c.asn1;c.defined.asn1=!0;for(var a=0;a<l.length;++a)l[a](c);return c.asn1}})})();