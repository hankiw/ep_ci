var __certverify=function(c){var p=function(h){function n(e,a,g){if(!e||!a)return null;var b=null;if(4<=c.ESVS.Mode&&!c.uiUtil().isItPFDevice(c.SELECTINFO.curdevice))if(c.SELECTINFO.curdevice!=c.CONST.__USFB_M_DISK.device&&c.SELECTINFO.curdevice!=c.CONST.__USFB_M_HDD.device||null==c.Whale())if(c.nimservice())c.nimservice().VerifyCertificate(e,1,function(d,e){if(0==d)b=a.IDS_VERIFY_CERT_OK;else if("MPKI"!=c.ESVS.PKI)switch(d){case 3001:b=a.IDS_VERIFY_CERT_ERROR_INVALID_TYPE;break;case 3002:b=a.IDS_VERIFY_CERT_ERROR_DECODING_FAIL;break;case 3003:b=a.IDS_VERIFY_CERT_ERROR_LOADING_FAIL;break;case 3005:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED;break;case 3009:b=a.IDS_VERIFY_CERT_ERROR_NO_DP;break;case 3010:b=a.IDS_VERIFY_CERT_ERROR_WRONG_DP;break;case 3013:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3014:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED_CRL;break;case 3015:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3016:b=a.IDS_VERIFY_CERT_ERROR_HOLDED+"<br><br>Code [ "+d+" ]";break;case 3017:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3059:b=a.IDS_VERIFY_CERT_ERROR_GETTING_CRL_FROM_LDAP_FAIL;break;case 3060:b=a.IDS_VERIFY_CERT_ERROR_CHECKING_ISSUER_FAIL;break;case 3062:b=a.IDS_VERIFY_CERT_ERROR_CA_CERT_PATH;break;case 3063:b=a.IDS_VERIFY_CERT_ERROR_ROOTCA_CERT_PATH;break;case 3900:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_UNSUPERSEDED;break;case 3901:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_KEYCOMPROMISE;break;case 3902:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_CACOMPROMISE;break;case 3903:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_AFFILIATIONCHANGED;break;case 3904:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_SUPERSEDED;break;case 3905:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_CESSATIONOFOPERATION;break;case 3906:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_HOLD;break;case 3907:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_REMOVEFROMCRL;break;case 3908:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3909:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3999:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;default:b=a.IDS_VERIFY_CERT_ERROR_UNKNOWN+"<br><br>Code [ "+d+" ]"}else switch(d){case 3001:b=a.IDS_VERIFY_CERT_ERROR_INVALID_TYPE;break;case 3002:b=a.IDS_VERIFY_CERT_ERROR_DECODING_FAIL;break;case 3003:b=a.IDS_VERIFY_CERT_ERROR_LOADING_FAIL;break;case 3005:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED;break;case 3009:b=a.IDS_VERIFY_CERT_ERROR_NO_DP;break;case 3010:b=a.IDS_VERIFY_CERT_ERROR_WRONG_DP;break;case 3013:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3014:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED_CRL;break;case 3015:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3059:b=a.IDS_VERIFY_CERT_ERROR_GETTING_CRL_FROM_LDAP_FAIL;break;case 3060:b=a.IDS_VERIFY_CERT_ERROR_CHECKING_ISSUER_FAIL;break;case 3062:b=a.IDS_VERIFY_CERT_ERROR_CA_CERT_PATH;break;case 3063:b=a.IDS_VERIFY_CERT_ERROR_ROOTCA_CERT_PATH;break;case 3016:case 3017:case 3900:case 3901:case 3902:case 3903:case 3904:case 3905:case 3906:case 3907:case 3908:case 3909:case 3999:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 4212E4:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED+"<br>Code [ "+d+" ]";break;default:b=a.IDS_VERIFY_CERT_ERROR_UNKNOWN+"<br><br>Code [ "+d+" ]"}g(b)});else return c.uiUtil().msgBox(a.IDS_MSGBOX_NIM_ERROR_UNLOAD),b=null;else c.Whale().verifyCertitficate(e,function(d,e){if(0===d)b=a.IDS_VERIFY_CERT_OK;else if("MPKI"!=c.ESVS.PKI)switch(d){case 3001:b=a.IDS_VERIFY_CERT_ERROR_INVALID_TYPE;break;case 3002:b=a.IDS_VERIFY_CERT_ERROR_DECODING_FAIL;break;case 3003:b=a.IDS_VERIFY_CERT_ERROR_LOADING_FAIL;break;case 3005:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED;break;case 3009:b=a.IDS_VERIFY_CERT_ERROR_NO_DP;break;case 3010:b=a.IDS_VERIFY_CERT_ERROR_WRONG_DP;break;case 3013:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3014:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED_CRL;break;case 3015:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3016:b=a.IDS_VERIFY_CERT_ERROR_HOLDED+"<br><br>Code [ "+d+" ]";break;case 3017:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3059:b=a.IDS_VERIFY_CERT_ERROR_GETTING_CRL_FROM_LDAP_FAIL;break;case 3060:b=a.IDS_VERIFY_CERT_ERROR_CHECKING_ISSUER_FAIL;break;case 3062:b=a.IDS_VERIFY_CERT_ERROR_CA_CERT_PATH;break;case 3063:b=a.IDS_VERIFY_CERT_ERROR_ROOTCA_CERT_PATH;break;case 3900:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_UNSUPERSEDED;break;case 3901:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_KEYCOMPROMISE;break;case 3902:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_CACOMPROMISE;break;case 3903:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_AFFILIATIONCHANGED;break;case 3904:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_SUPERSEDED;break;case 3905:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_CESSATIONOFOPERATION;break;case 3906:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_HOLD;break;case 3907:b=a.IDS_VERIFY_CERT_ERROR_REVOKED_REMOVEFROMCRL;break;case 3908:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3909:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 3999:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;default:b=a.IDS_VERIFY_CERT_ERROR_UNKNOWN+"<br><br>Code [ "+d+" ]"}else switch(d){case 3001:b=a.IDS_VERIFY_CERT_ERROR_INVALID_TYPE;break;case 3002:b=a.IDS_VERIFY_CERT_ERROR_DECODING_FAIL;break;case 3003:b=a.IDS_VERIFY_CERT_ERROR_LOADING_FAIL;break;case 3005:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED;break;case 3009:b=a.IDS_VERIFY_CERT_ERROR_NO_DP;break;case 3010:b=a.IDS_VERIFY_CERT_ERROR_WRONG_DP;break;case 3013:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3014:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED_CRL;break;case 3015:b=a.IDS_VERIFY_CERT_ERROR_WRONG_CRL+"<br><br>Code [ "+d+" ]";break;case 3059:b=a.IDS_VERIFY_CERT_ERROR_GETTING_CRL_FROM_LDAP_FAIL;break;case 3060:b=a.IDS_VERIFY_CERT_ERROR_CHECKING_ISSUER_FAIL;break;case 3062:b=a.IDS_VERIFY_CERT_ERROR_CA_CERT_PATH;break;case 3063:b=a.IDS_VERIFY_CERT_ERROR_ROOTCA_CERT_PATH;break;case 3016:case 3017:case 3900:case 3901:case 3902:case 3903:case 3904:case 3905:case 3906:case 3907:case 3908:case 3909:case 3999:b=a.IDS_VERIFY_CERT_ERROR_REVOKED+"<br><br>Code [ "+d+" ]";break;case 4212E4:b=a.IDS_VERIFY_CERT_ERROR_EXPIRED+"<br>Code [ "+d+" ]";break;default:b=a.IDS_VERIFY_CERT_ERROR_UNKNOWN+"<br><br>Code [ "+d+" ]"}g(b)});else if(2&c.ESVS.Mode){var f=null;try{var l=c.usWebToolkit.pki.createCaStore();f=c.PFSH.GetCACerts();for(var h in f)caCert=f[h],l.addCertificate(c.usWebToolkit.pki.certificateFromBase64(caCert));if(null==c.certsList||null==c.certsList.list||0>=c.certsList.list.length)return"";var k=c.usWebToolkit.pki.certificateFromBase64(c.certsList.list[e-1].cert);c.usWebToolkit.pki.verifyCertificateChain(l,k,function(c,e,f){!0===c?(result=0,b=a.IDS_VERIFY_CERT_OK):(result=-1,null!=f&&void 0!=f&&0<=f.indexOf("Certificate is not valid yet or has expired")?(errCode=3005,b=a.IDS_VERIFY_CERT_ERROR_EXPIRED):null!=f&&void 0!=f&&0<=f.indexOf("no parent issuer, so certificate not trusted")?(errCode=3060,b=a.IDS_VERIFY_CERT_ERROR_CHECKING_ISSUER_FAIL):(errCode=-1,b=f));g(b)})}catch(d){errCode=d.code,b=d.message,g(b)}}}function k(c){if(!c)return alert("UI load error."),!1;var a=document.createElement("div");document.body.insertBefore(a,document.body.firstChild);a.innerHTML=c;return!0}var f=function(){var e=window.XMLHttpRequest?new window.XMLHttpRequest:new ActiveXObject("MSXML2.XMLHTTP.3.0");e.open("GET",c.ESVS.SRCPath+"unisignweb/rsrc/layout/certverify.html?version="+c.ver,!1);e.send(null);return e.responseText},m=function(){var e=window.XMLHttpRequest?new window.XMLHttpRequest:new ActiveXObject("MSXML2.XMLHTTP.3.0");e.open("GET",c.ESVS.SRCPath+"unisignweb/rsrc/lang/"+c.ESVS.Language+"/certverify_"+c.ESVS.Language+".js?version="+c.ver,!1);e.send(null);return e.responseText},l=c.ESVS.TabIndex;return function(){var e=c.CustomEval(f),a=c.CustomEval(m,!0),g=h.args.idx;k(e());e=document.getElementById("us-cert-verify-lbl-title");e.appendChild(document.createTextNode(a.IDS_VERIFY_CERT));e.setAttribute("tabindex",l,0);var b=document.getElementById("us-cert-verify-lbl");4&c.ESVS.Mode||2&c.ESVS.Mode?n(g,a,function(a){a&&b&&(b.innerHTML=a,b.setAttribute("tabindex",l+1,0))}):(g=n(g,a))&&b&&(b.innerHTML=g,b.setAttribute("tabindex",l+1,0));g=document.getElementById("us-cert-verify-confirm-btn");g.setAttribute("value",a.IDS_CONFIRM,0);g.setAttribute("title",a.IDS_CONFIRM+a.IDS_BUTTON,0);g.setAttribute("tabindex",l+2,0);g.onclick=function(){h.onConfirm()};a=document.getElementById("us-cert-verify-cls-img-btn");a.setAttribute("tabindex",l+3,0);a.onclick=function(){h.onCancel()};document.getElementById("us-cert-verify-cls-btn-img").setAttribute("src",c.ESVS.SRCPath+"unisignweb/rsrc/img/x-btn.png",0);c.uiUtil().setRotationTabFocus(g,b,e);c.uiUtil().setRotationTabFocus(e,g,b);return document.getElementById("us-div-cert-verify")}()};return function(h){var n=c.uiLayerLevel,k=c.uiUtil().getOverlay(n),f=p({type:h.type,args:h.args,onConfirm:h.onConfirm,onCancel:h.onCancel});f.style.zIndex=n+1;c.ESVS.TargetObj.insertBefore(k,c.ESVS.TargetObj.firstChild);var m=window.onresize;return{show:function(){c.ActiveUI=this;draggable(f,document.getElementById("us-div-cert-verify-title"));k.style.display="block";c.uiUtil().offsetResize(f);window.onresize=function(){c.uiUtil().offsetResize(f);m&&m()};c.uiLayerLevel+=10;c.ESVS.TabIndex+=30;setTimeout(function(){var c=f.getElementsByTagName("p");if(0<c.length)for(var e=0;e<c.length;e++)"us-cert-verify-lbl-title"==c[e].id&&c[e].focus()},10)},hide:function(){k.style.display="none";f.style.display="none"},dispose:function(){window.onresize=function(){m&&m()};f.parentNode.parentNode.removeChild(f.parentNode);k.parentNode.removeChild(k);c.uiLayerLevel-=10;c.ESVS.TabIndex-=30}}}};