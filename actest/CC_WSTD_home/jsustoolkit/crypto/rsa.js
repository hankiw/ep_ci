(function(){function r(e){"undefined"===typeof BigInteger&&(BigInteger=e.jsbn.BigInteger);var c=e.asn1,h=e.jsustoolkitErrCode=e.jsustoolkitErrCode||{};e.pki=e.pki||{};e.pki.rsa=e.rsa=e.rsa||{};var f=e.pki,l=function(a){var b;if(a.algorithm in e.pki.oids)b=e.pki.oids[a.algorithm];else throw{code:"101001",message:h["101001"]+"("+a.algorithm+")"};var d=c.oidToDer(b).getBytes();b=c.create(c.Class.UNIVERSAL,c.Type.SEQUENCE,!0,[]);var g=c.create(c.Class.UNIVERSAL,c.Type.SEQUENCE,!0,[]);g.value.push(c.create(c.Class.UNIVERSAL,c.Type.OID,!1,d));g.value.push(c.create(c.Class.UNIVERSAL,c.Type.NULL,!1,""));a=c.create(c.Class.UNIVERSAL,c.Type.OCTETSTRING,!1,a.digest().getBytes());b.value.push(g);b.value.push(a);return c.toDer(b).getBytes()},q=function(a,b,d){if(d)b=a.modPow(b.e,b.n);else{b.dP||(b.dP=b.d.mod(b.p.subtract(BigInteger.ONE)));b.dQ||(b.dQ=b.d.mod(b.q.subtract(BigInteger.ONE)));b.qInv||(b.qInv=b.q.modInverse(b.p));d=a.mod(b.p).modPow(b.dP,b.p);for(a=a.mod(b.q).modPow(b.dQ,b.q);0>d.compareTo(a);)d=d.add(b.p);b=d.subtract(a).multiply(b.qInv).mod(b.p).multiply(b.q).add(a)}return b};f.rsa.encrypt=function(a,b,d){if(null==a||"undefined"==typeof a)throw{code:"101002",message:h["101002"]};if(null==b||"undefined"==typeof b)throw{code:"101003",message:h["101003"]};if(null==d||"undefined"==typeof d)throw{code:"101004",message:h["101004"]};var g=d,c=e.util.createBuffer(),k=Math.ceil(b.n.bitLength()/8);if(!1!==d&&!0!==d){if(a.length>k-11)throw{code:"101005",message:h["101005"]+"(length:"+a.length+", max:"+(k-11)+")"};c.putByte(0);c.putByte(d);var f=k-3-a.length;if(0===d||1===d){g=!1;d=0===d?0:255;for(var m=0;m<f;++m)c.putByte(d)}else for(g=!0,m=0;m<f;++m)d=Math.floor(255*Math.random())+1,c.putByte(d);c.putByte(0)}c.putBytes(a);a=new BigInteger(c.toHex(),16);b=q(a,b,g).toString(16);g=e.util.createBuffer();for(k-=Math.ceil(b.length/2);0<k;)g.putByte(0),--k;g.putBytes(e.util.hexToBytes(b));return g.getBytes()};f.rsa.decrypt=function(a,b,d,c){if(null==a||"undefined"==typeof a)throw{code:"101006",message:h["101006"]};if(null==b||"undefined"==typeof b)throw{code:"101007",message:h["101007"]};if(null==d||"undefined"==typeof d)throw{code:"101008",message:h["101008"]};var f=Math.ceil(b.n.bitLength()/8);if(a.length!=f)throw{code:"101009",message:h["101009"]+"(length: "+a.length+", expected: "+f+")"};a=new BigInteger(e.util.createBuffer(a).toHex(),16);a=q(a,b,d).toString(16);b=e.util.createBuffer();for(var k=f-Math.ceil(a.length/2);0<k;)b.putByte(0),--k;b.putBytes(e.util.hexToBytes(a));if(!1!==c){k=b.getByte();a=b.getByte();if(0!==k||d&&0!==a&&1!==a||!d&&2!=a||d&&0===a&&"undefined"===typeof c)throw{code:"101010",message:h["101010"]};d=0;if(0===a)for(d=f-3-c,c=0;c<d;++c){if(0!==b.getByte())throw{code:"101011",message:h["101011"]};}else if(1===a)for(d=0;1<b.length();){if(255!==b.getByte()){--b.read;break}++d}else if(2===a)for(d=0;1<b.length();){if(0===b.getByte()){--b.read;break}++d}if(0!==b.getByte()||d!==f-3-b.length())throw{code:"101013",message:h["101013"]};}return b.getBytes()};f.rsa.createKeyPairGenerationState=function(a,b){"string"===typeof a&&(a=parseInt(a,10));a=a||1024;var c={state:0,itrs:0,maxItrs:100,bits:a,rng:{nextBytes:function(a){for(var b=e.random.getBytes(a.length),c=0;c<a.length;++c)a[c]=b.charCodeAt(c)}},e:new BigInteger((b||65537).toString(16),16),p:null,q:null,qBits:a>>1,pBits:a-(a>>1),pqState:0,num:null,six:new BigInteger(null),addNext:2,keys:null};c.six.fromInt(6);return c};f.rsa.stepKeyPairGenerationState=function(a,b){for(var c=+new Date,g,h=0;null===a.keys&&(0>=b||h<b);){if(0===a.state){g=null===a.p?a.pBits:a.qBits;var f=g-1;if(0===a.pqState)a.itrs=0,a.num=new BigInteger(g,a.rng),a.r=null,a.num.isEven()&&a.num.dAddOffset(1,0),a.num.testBit(f)||a.num.bitwiseTo(BigInteger.ONE.shiftLeft(f),function(a,b){return a|b},a.num),++a.pqState;else if(1===a.pqState){if(null===a.addNext){var l=a.num.mod(a.six).byteValue();3===l&&(a.num.mod.dAddOffset(2),l=5);a.addNext=1===l?2:4}a.num.isProbablePrime(1)?++a.pqState:a.itrs<a.maxItrs?(a.num.dAddOffset(a.addNext,0),a.num.bitLength()>g?(a.addNext=null,a.num.subTo(BigInteger.ONE.shiftLeft(f),a.num)):a.addNext=4===a.addNext?2:4,++a.itrs):a.pqState=0}else 2===a.pqState?a.pqState=0===a.num.subtract(BigInteger.ONE).gcd(a.e).compareTo(BigInteger.ONE)?3:0:3===a.pqState&&(a.pqState=0,a.num.isProbablePrime(10)&&(null===a.p?a.p=a.num:a.q=a.num,null!==a.p&&null!==a.q&&++a.state),a.num=null)}else 1===a.state?(0>a.p.compareTo(a.q)&&(a.num=a.p,a.p=a.q,a.q=a.num),++a.state):2===a.state?(a.p1=a.p.subtract(BigInteger.ONE),a.q1=a.q.subtract(BigInteger.ONE),a.phi=a.p1.multiply(a.q1),++a.state):3===a.state?0===a.phi.gcd(a.e).compareTo(BigInteger.ONE)?++a.state:(a.p=null,a.q=null,a.state=0):4===a.state?(a.n=a.p.multiply(a.q),a.n.bitLength()===a.bits?++a.state:(a.q=null,a.state=0)):5===a.state&&(g=a.e.modInverse(a.phi),a.keys={privateKey:e.pki.rsa.setPrivateKey(a.n,a.e,g,a.p,a.q,g.mod(a.p1),g.mod(a.q1),a.q.modInverse(a.p)),publicKey:e.pki.rsa.setPublicKey(a.n,a.e)});g=+new Date;h+=g-c;c=g}return null!==a.keys};f.rsa.generateKeyPair=function(a,b){var c=f.rsa.createKeyPairGenerationState(a,b);f.rsa.stepKeyPairGenerationState(c,0);return c.keys};f.rsa.setPublicKey=function(a,b){var d={n:a,e:b,encrypt:function(a){return f.rsa.encrypt(a,d,2)},verify:function(a,b,e){if(null==a||"undefined"==typeof a)throw{code:"104002",message:h["104002"]};if(null==b||"undefined"==typeof b)throw{code:"104003",message:h["104003"]};b=f.rsa.decrypt(b,d,!0,void 0===e?void 0:!1);return void 0===e?(e=c.fromDer(b),a===e.value[1].value):e.verify(a,b,d.n.bitLength())}};return d};f.rsa.setPrivateKey=function(a,b,d,g,q,k,p,m){var n={n:a,e:b,d:d,p:g,q:q,dP:k,dQ:p,qInv:m,decrypt:function(a){return f.rsa.decrypt(a,n,!1)},sign:function(a,b){if(null==a||"undefined"==typeof a)throw{code:"104001",message:h["104001"]};var c=!1;void 0===b&&(b={encode:l},c=1);var d=b.encode(a,n.n.bitLength());return f.rsa.encrypt(d,n,c)},signWithHash:function(a,b){if(null==a||"undefined"==typeof a)throw{code:"104002",message:h["104002"]};var d=!1;void 0===b&&(d=1);var g=c.oidToDer(e.pki.oids.sha256).getBytes(),k=c.create(c.Class.UNIVERSAL,c.Type.SEQUENCE,!0,[]),l=c.create(c.Class.UNIVERSAL,c.Type.SEQUENCE,!0,[]);l.value.push(c.create(c.Class.UNIVERSAL,c.Type.OID,!1,g));l.value.push(c.create(c.Class.UNIVERSAL,c.Type.NULL,!1,""));g=c.create(c.Class.UNIVERSAL,c.Type.OCTETSTRING,!1,a);k.value.push(l);k.value.push(g);return f.rsa.encrypt(c.toDer(k).getBytes(),n,d)}};return n}}var s="./asn1 ./oids ./random ./util ./jsbn ./jsustoolkitErrCode".split(" "),p=null;"function"!==typeof define&&("object"===typeof module&&module.exports?p=function(e,c){c(require,module)}:(crosscert=window.crosscert=window.crosscert||{},r(crosscert)));(p||"function"===typeof define)&&(p||define)(["require","module"].concat(s),function(e,c){c.exports=function(c){var f=s.map(function(c){return e(c)}).concat(r);c=c||{};c.defined=c.defined||{};if(c.defined.rsa)return c.rsa;c.defined.rsa=!0;for(var l=0;l<f.length;++l)f[l](c);return c.rsa}})})();