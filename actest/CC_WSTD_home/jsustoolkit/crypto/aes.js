(function(){function x(c){var r=c.jsustoolkitErrCode=c.jsustoolkitErrCode||{},s=c.aes=c.aes||{};c.cipher=c.cipher||{};c.cipher.algorithms=c.cipher.algorithms||{};c.cipher.aes=c.cipher.algorithms.aes=s;var A=!1,k,B,w,v,t,x=function(){A=!0;w=[0,1,2,4,8,16,32,64,128,27,54];for(var a=Array(256),e=0;128>e;++e)a[e]=e<<1,a[e+128]=e+128<<1^283;k=Array(256);B=Array(256);v=Array(4);t=Array(4);for(e=0;4>e;++e)v[e]=Array(256),t[e]=Array(256);for(var g=0,b=0,c,f,p,d,l,e=0;256>e;++e){d=b^b<<1^b<<2^b<<3^b<<4;d=d>>8^d&255^99;k[g]=d;B[d]=g;l=a[d];c=a[g];f=a[c];p=a[f];l^=l<<24^d<<16^d<<8^d;f=(c^f^p)<<24^(g^p)<<16^(g^f^p)<<8^g^c^p;for(var h=0;4>h;++h)v[h][g]=l,t[h][d]=f,l=l<<24|l>>>8,f=f<<24|f>>>8;0===g?g=b=1:(g=c^a[a[a[c^p]]],b^=a[a[b]])}},y=function(a,e){for(var g=a.slice(0),b,c=1,f=g.length,p=4*(f+6+1),d=f;d<p;++d)b=g[d-1],0===d%f?(b=k[b>>>16&255]<<24^k[b>>>8&255]<<16^k[b&255]<<8^k[b>>>24]^w[c]<<24,c++):6<f&&4==d%f&&(b=k[b>>>24]<<24^k[b>>>16&255]<<16^k[b>>>8&255]<<8^k[b&255]),g[d]=g[d-f]^b;if(e){for(var c=t[0],f=t[1],l=t[2],h=t[3],n=g.slice(0),p=g.length,d=0,m=p-4;d<p;d+=4,m-=4)if(0===d||d===p-4)n[d]=g[m],n[d+1]=g[m+3],n[d+2]=g[m+2],n[d+3]=g[m+1];else for(var q=0;4>q;++q)b=g[m+q],n[d+(3&-q)]=c[k[b>>>24]]^f[k[b>>>16&255]]^l[k[b>>>8&255]]^h[k[b&255]];g=n}return g},F=function(a,e,c,b){var r=a.length/4-1,f,p,d,l,h;b?(f=t[0],p=t[1],d=t[2],l=t[3],h=B):(f=v[0],p=v[1],d=v[2],l=v[3],h=k);var n,m,q,C,D,E;n=e[0]^a[0];m=e[b?3:1]^a[1];q=e[2]^a[2];e=e[b?1:3]^a[3];for(var u=3,s=1;s<r;++s)C=f[n>>>24]^p[m>>>16&255]^d[q>>>8&255]^l[e&255]^a[++u],D=f[m>>>24]^p[q>>>16&255]^d[e>>>8&255]^l[n&255]^a[++u],E=f[q>>>24]^p[e>>>16&255]^d[n>>>8&255]^l[m&255]^a[++u],e=f[e>>>24]^p[n>>>16&255]^d[m>>>8&255]^l[q&255]^a[++u],n=C,m=D,q=E;c[0]=h[n>>>24]<<24^h[m>>>16&255]<<16^h[q>>>8&255]<<8^h[e&255]^a[++u];c[b?3:1]=h[m>>>24]<<24^h[q>>>16&255]<<16^h[e>>>8&255]<<8^h[n&255]^a[++u];c[2]=h[q>>>24]<<24^h[e>>>16&255]<<16^h[n>>>8&255]<<8^h[m&255]^a[++u];c[b?1:3]=h[e>>>24]<<24^h[n>>>16&255]<<16^h[m>>>8&255]<<8^h[q&255]^a[++u]},z=function(a,e){var g=null;if(null==a||"undefined"==typeof a)throw{code:"100011",message:r["100011"]};A||x();if(a.constructor==String&&(16==a.length||32==a.length))a=c.util.createBuffer(a);else if(a.constructor==Array&&(16==a.length||32==a.length)){var b=a;a=c.util.createBuffer();for(var k=0;k<b.length;++k)a.putByte(b[k])}else if(a.constructor==String||16!=a.length()&&32!=a.length())throw{code:"100012",message:r["100012"]};if(a.constructor!=Array){b=a;a=[];var f=b.length();if(16==f||32==f)for(f>>>=2,k=0;k<f;++k)a.push(b.getInt32())}if(a.constructor==Array&&(4==a.length||8==a.length))var p=y(a,e),d,l,h,n,m,q,g={output:null,start:function(a,e){if(null==a||"undefined"==typeof a)throw{code:"100015",message:r["100015"]};if(16!=a.length)throw{code:"100016",message:r["100016"]};if(a.constructor==String&&16==a.length)a=c.util.createBuffer(a);else if(a.constructor==Array&&16==a.length){var b=a;a=c.util.createBuffer();for(var f=0;16>f;++f)a.putByte(b[f])}a.constructor!=Array&&(b=a,a=Array(4),a[0]=b.getInt32(),a[1]=b.getInt32(),a[2]=b.getInt32(),a[3]=b.getInt32());d=c.util.createBuffer();l=e||c.util.createBuffer();m=a.slice(0);h=Array(4);n=Array(4);q=!1;g.output=l},update:function(a){if(null==d&&null==l)throw{code:"100014",message:r["100014"]};null!=a&&a.constructor==String&&(a=c.util.createBuffer(a));if(!q){if(null==a||"undefined"==typeof a)throw{code:"100013",message:r["100013"]};d.putBuffer(a)}for(a=e&&!q?32:16;d.length()>=a;){if(e)for(var b=0;4>b;++b)h[b]=d.getInt32();else for(b=0;4>b;++b)h[b]=m[b]^d.getInt32();F(p,h,n,e);if(e){for(b=0;4>b;++b)l.putInt32(m[b]^n[b]);m=h.slice(0)}else{for(b=0;4>b;++b)l.putInt32(n[b]);m=n}}},finish:function(a){var b=!0;if(!e)if(a)b=a(e,16,d);else{var c=16==d.length()?16:16-d.length();d.fillWithByte(c,c)}b&&(q=!0,g.update());if(e)if(b=0===d.length())a?b=a(e,16,l):(a=l.length(),a=l.at(a-1),16<a?b=!1:l.truncate(a));else throw{code:"100017",message:r["100017"]};return b},tmonetpadding:function(a,b,e){if(a){a=e.length();for(var d=0,c=0,c=1;c<b+1;c++){var f=e.at(a-c);if(128==f){d++;break}else if(0==f)d++;else break}e.truncate(d);return!0}}};return g};c.aes.startEncrypting=function(a,e,c){a=z(a,!1);a.start(e,c);return a};c.aes.createEncryptionCipher=function(a){return z(a,!1)};c.aes.startDecrypting=function(a,c,g){a=z(a,!0);a.start(c,g);return a};c.aes.createDecryptionCipher=function(a){return z(a,!0)};c.aes._expandKey=function(a,c){A||x();return y(a,c)};c.aes._updateBlock=F}var y=["./util","./jsustoolkitErrCode"],w=null;"function"!==typeof define&&("object"===typeof module&&module.exports?w=function(c,r){r(require,module)}:(crosscert=window.crosscert=window.crosscert||{},x(crosscert)));(w||"function"===typeof define)&&(w||define)(["require","module"].concat(y),function(c,r){r.exports=function(s){var r=y.map(function(k){return c(k)}).concat(x);s=s||{};s.defined=s.defined||{};if(s.defined.aes)return s.aes;s.defined.aes=!0;for(var k=0;k<r.length;++k)r[k](s);return s.aes}})})();