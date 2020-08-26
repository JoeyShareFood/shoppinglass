﻿(function(g,f,b,d,c,e,z){/*! Jssor */
$Jssor$=g.$Jssor$=g.$Jssor$||{};new(function(){});var m=function(){var b=this,a={};b.$On=b.addEventListener=function(b,c){if(typeof c!="function")return;if(!a[b])a[b]=[];a[b].push(c)};b.$Off=b.removeEventListener=function(e,d){var b=a[e];if(typeof d!="function")return;else if(!b)return;for(var c=0;c<b.length;c++)if(d==b[c]){b.splice(c,1);return}};b.f=function(e){var c=a[e],d=[];if(!c)return;for(var b=1;b<arguments.length;b++)d.push(arguments[b]);for(var b=0;b<c.length;b++)try{c[b].apply(g,d)}catch(f){}}},h;(function(){h=function(a,b){this.x=typeof a=="number"?a:0;this.y=typeof b=="number"?b:0};})();var l=g.$JssorEasing$={$EaseLinear:function(a){return a},$EaseGoBack:function(a){return 1-b.abs(2-1)},$EaseSwing:function(a){return-b.cos(a*b.PI)/2+.5},$EaseInQuad:function(a){return a*a},$EaseOutQuad:function(a){return-a*(a-2)},$EaseInOutQuad:function(a){return(a*=2)<1?1/2*a*a:-1/2*(--a*(a-2)-1)},$EaseInCubic:function(a){return a*a*a},$EaseOutCubic:function(a){return(a-=1)*a*a+1},$EaseInOutCubic:function(a){return(a*=2)<1?1/2*a*a*a:1/2*((a-=2)*a*a+2)},$EaseInQuart:function(a){return a*a*a*a},$EaseOutQuart:function(a){return-((a-=1)*a*a*a-1)},$EaseInOutQuart:function(a){return(a*=2)<1?1/2*a*a*a*a:-1/2*((a-=2)*a*a*a-2)},$EaseInQuint:function(a){return a*a*a*a*a},$EaseOutQuint:function(a){return(a-=1)*a*a*a*a+1},$EaseInOutQuint:function(a){return(a*=2)<1?1/2*a*a*a*a*a:1/2*((a-=2)*a*a*a*a+2)},$EaseInSine:function(a){return 1-b.cos(a*b.PI/2)},$EaseOutSine:function(a){return b.sin(a*b.PI/2)},$EaseInOutSine:function(a){return-1/2*(b.cos(b.PI*a)-1)},$EaseInExpo:function(a){return a==0?0:b.pow(2,10*(a-1))},$EaseOutExpo:function(a){return a==1?1:-b.pow(2,-10*a)+1},$EaseInOutExpo:function(a){return a==0||a==1?a:(a*=2)<1?1/2*b.pow(2,10*(a-1)):1/2*(-b.pow(2,-10*--a)+2)},$EaseInCirc:function(a){return-(b.sqrt(1-a*a)-1)},$EaseOutCirc:function(a){return b.sqrt(1-(a-=1)*a)},$EaseInOutCirc:function(a){return(a*=2)<1?-1/2*(b.sqrt(1-a*a)-1):1/2*(b.sqrt(1-(a-=2)*a)+1)},$EaseInElastic:function(a){if(!a||a==1)return a;var c=.3,d=.075;return-(b.pow(2,10*(a-=1))*b.sin((a-d)*2*b.PI/c))},$EaseOutElastic:function(a){if(!a||a==1)return a;var c=.3,d=.075;return b.pow(2,-10*a)*b.sin((a-d)*2*b.PI/c)+1},$EaseInOutElastic:function(a){if(!a||a==1)return a;var c=.45,d=.1125;return(a*=2)<1?-.5*b.pow(2,10*(a-=1))*b.sin((a-d)*2*b.PI/c):b.pow(2,-10*(a-=1))*b.sin((a-d)*2*b.PI/c)*.5+1},$EaseInBack:function(a){var b=1.70158;return a*a*((b+1)*a-b)},$EaseOutBack:function(a){var b=1.70158;return(a-=1)*a*((b+1)*a+b)+1},$EaseInOutBack:function(a){var b=1.70158;return(a*=2)<1?1/2*a*a*(((b*=1.525)+1)*a-b):1/2*((a-=2)*a*(((b*=1.525)+1)*a+b)+2)},$EaseInBounce:function(a){return 1-l.$EaseOutBounce(1-a)},$EaseOutBounce:function(a){return a<1/2.75?7.5625*a*a:a<2/2.75?7.5625*(a-=1.5/2.75)*a+.75:a<2.5/2.75?7.5625*(a-=2.25/2.75)*a+.9375:7.5625*(a-=2.625/2.75)*a+.984375},$EaseInOutBounce:function(a){return a<1/2?l.$EaseInBounce(a*2)*.5:l.$EaseOutBounce(a*2-1)*.5+.5},$EaseInWave:function(a){return 1-b.cos(a*b.PI*2)},$EaseOutWave:function(a){return b.sin(a*b.PI*2)},$EaseOutJump:function(a){return 1-((a*=2)<1?(a=1-a)*a*a:(a-=1)*a*a)},$EaseInJump:function(a){return(a*=2)<1?a*a*a:(a=2-a)*a*a}},i={Qe:function(a){return(a&3)==1},Pe:function(a){return(a&3)==2},De:function(a){return(a&12)==4},Be:function(a){return(a&12)==8}},q={Te:37,Ue:39},o,n={bf:0,af:1,df:2,Ze:3,Ye:4,Xe:5},y=1,u=2,w=3,v=4,x=5,j,a=new function(){var i=this,m=n.bf,j=0,q=0,P=0,t=0,cb=navigator.appName,k=navigator.userAgent;function D(){if(!m)if(cb=="Microsoft Internet Explorer"&&!!g.attachEvent&&!!g.ActiveXObject){var d=k.indexOf("MSIE");m=n.af;q=parseFloat(k.substring(d+5,k.indexOf(";",d)));/*@cc_on P=@_jscript_version@*/;j=f.documentMode||q}else if(cb=="Netscape"&&!!g.addEventListener){var c=k.indexOf("Firefox"),a=k.indexOf("Safari"),h=k.indexOf("Chrome"),b=k.indexOf("AppleWebKit");if(c>=0){m=n.df;j=parseFloat(k.substring(c+8))}else if(a>=0){var i=k.substring(0,a).lastIndexOf("/");m=h>=0?n.Ye:n.Ze;j=parseFloat(k.substring(i+1,a))}if(b>=0)t=parseFloat(k.substring(b+12))}else{var e=/(opera)(?:.*version|)[ \/]([\w.]+)/i.exec(k);if(e){m=n.Xe;j=parseFloat(e[2])}}}function l(){D();return m==y}function G(){return l()&&(j<6||f.compatMode=="BackCompat")}function V(){D();return m==u}function M(){D();return m==w}function hb(){D();return m==v}function ib(){D();return m==x}function R(){return M()&&t>534&&t<535}function s(){return l()&&j<9}var B;function r(a){if(!B){p(["transform","WebkitTransform","msTransform","MozTransform","OTransform"],function(b){if(!i.Vb(a.style[b])){B=b;return c}});B=B||"transform"}return B}function ab(a){return Object.prototype.toString.call(a)}var J;function p(a,c){if(ab(a)=="[object Array]"){for(var b=0;b<a.length;b++)if(c(a[b],b,a))break}else for(var d in a)if(c(a[d],d,a))break}function jb(){if(!J){J={};p(["Boolean","Number","String","Function","Array","Date","RegExp","Object"],function(a){J["[object "+a+"]"]=a.toLowerCase()})}return J}function A(a){return a==d?String(a):jb()[ab(a)]||"object"}function bb(b,a){setTimeout(b,a||0)}function I(b,d,c){var a=!b||b=="inherit"?"":b;p(d,function(c){var b=c.exec(a);if(b){var d=a.substr(0,b.index),e=a.substr(b.lastIndex+1,a.length-(b.lastIndex+1));a=d+e}});a=c+(a.indexOf(" ")!=0?" ":"")+a;return a}function W(b,a){if(j<9)b.style.filter=a}function fb(b,a,c){if(P<9){var e=b.style.filter,g=new RegExp(/[\s]*progid:DXImageTransform\.Microsoft\.Matrix\([^\)]*\)/g),f=a?"progid:DXImageTransform.Microsoft.Matrix(M11="+a[0][0]+", M12="+a[0][1]+", M21="+a[1][0]+", M22="+a[1][1]+", SizingMethod='auto expand')":"",d=I(e,[g],f);W(b,d);i.cd(b,c.y);i.Xc(b,c.x)}}i.Ob=l;i.Qb=hb;i.Hb=ib;i.xb=s;i.bb=function(){return j};i.rc=function(){return t};i.$Delay=bb;i.N=function(a){if(i.hc(a))a=f.getElementById(a);return a};i.Tb=function(a){return a?a:g.event};i.Bc=function(a){a=i.Tb(a);var b=new h;if(a.type=="DOMMouseScroll"&&V()&&j<3){b.x=a.screenX;b.y=a.screenY}else if(typeof a.pageX=="number"){b.x=a.pageX;b.y=a.pageY}else if(typeof a.clientX=="number"){b.x=a.clientX+f.body.scrollLeft+f.documentElement.scrollLeft;b.y=a.clientY+f.body.scrollTop+f.documentElement.scrollTop}return b};i.ef=function(b){if(l()&&q<9){var a=/opacity=([^)]*)/.exec(b.style.filter||"");return a?parseFloat(a[1])/100:1}else return parseFloat(b.style.opacity||"1")};i.Kb=function(c,a,f){if(l()&&q<9){var h=c.style.filter||"",i=new RegExp(/[\s]*alpha\([^\)]*\)/g),e=b.round(100*a),d="";if(e<100||f)d="alpha(opacity="+e+") ";var g=I(h,[i],d);W(c,g)}else c.style.opacity=a==1?"":b.round(a*100)/100};function O(g,c){var f=c.$Rotate||0,e=c.Dc||1;if(s()){var k=i.Fe(f/180*b.PI,e,e);fb(g,!f&&e==1?d:k,i.Ee(k,c.U,c.jb))}else{var h=r(g);if(h){var j="rotate("+f%360+"deg) scale("+e+")";if(a.Qb()&&t>535)j+=" perspective(2000px)";g.style[h]=j}}}i.Ge=function(b,a){if(R())bb(i.r(d,O,b,a));else O(b,a)};i.Ie=function(b,c){var a=r(b);if(a)b.style[a+"Origin"]=c};i.He=function(a,c){if(l()&&q<9||q<10&&G())a.style.zoom=c==1?"":c;else{var b=r(a);if(b){var f="scale("+c+")",e=a.style[b],g=new RegExp(/[\s]*scale\(.*?\)/g),d=I(e,[g],f);a.style[b]=d}}};i.Ae=function(a){if(!a.style[r(a)]||a.style[r(a)]=="none")a.style[r(a)]="perspective(2000px)"};i.e=function(a,c,d,b){a=i.N(a);if(a.addEventListener){c=="mousewheel"&&a.addEventListener("DOMMouseScroll",d,b);a.addEventListener(c,d,b)}else if(a.attachEvent){a.attachEvent("on"+c,d);b&&a.setCapture&&a.setCapture()}};i.Ce=function(a,c,d,b){a=i.N(a);if(a.removeEventListener){c=="mousewheel"&&a.removeEventListener("DOMMouseScroll",d,b);a.removeEventListener(c,d,b)}else if(a.detachEvent){a.detachEvent("on"+c,d);b&&a.releaseCapture&&a.releaseCapture()}};i.Re=function(b,a){i.e(s()?f:g,"mouseup",b,a)};i.ib=function(a){a=i.Tb(a);a.preventDefault&&a.preventDefault();a.cancel=c;a.returnValue=e};i.r=function(e,d){for(var b=[],a=2;a<arguments.length;a++)b.push(arguments[a]);var c=function(){for(var c=b.concat([]),a=0;a<arguments.length;a++)c.push(arguments[a]);return d.apply(e,c)};return c};i.Me=function(a,c){var b=f.createTextNode(c);i.tc(a);a.appendChild(b)};i.tc=function(a){a.innerHTML=""};i.T=function(c){for(var b=[],a=c.firstChild;a;a=a.nextSibling)a.nodeType==1&&b.push(a);return b};function N(a,c,b,f){if(!b)b="u";for(a=a?a.firstChild:d;a;a=a.nextSibling)if(a.nodeType==1){if(i.w(a,b)==c)return a;if(f){var e=N(a,c,b,f);if(e)return e}}}i.q=N;function S(a,c,e){for(a=a?a.firstChild:d;a;a=a.nextSibling)if(a.nodeType==1){if(a.tagName==c)return a;if(e){var b=S(a,c,e);if(b)return b}}}i.Ke=S;i.Se=function(b,a){return b.getElementsByTagName(a)};i.h=function(c){for(var b=1;b<arguments.length;b++){var a=arguments[b];if(a)for(var d in a)c[d]=a[d]}return c};i.Vb=function(a){return A(a)=="undefined"};i.Oe=function(a){return A(a)=="function"};i.Nb=Array.isArray||function(a){return A(a)=="array"};i.hc=function(a){return A(a)=="string"};i.cf=function(a){return!isNaN(parseFloat(a))&&isFinite(a)};i.d=p;i.ub=function(a){return i.lc("DIV",a)};i.We=function(a){return i.lc("SPAN",a)};i.lc=function(b,a){a=a||f;return a.createElement(b)};i.cb=function(){};i.Vc=function(a,b){return a.getAttribute(b)};i.w=function(a,b){return i.Vc(a,b)||i.Vc(a,"data-"+b)};i.Ve=function(b,c,a){b.setAttribute(c,a)};i.Zc=function(a){return a.className};i.dd=function(b,a){b.className=a?a:""};i.Lc=function(a){return a.style.display};i.Z=function(b,a){b.style.display=a||""};i.W=function(b,a){b.style.overflow=a};i.gb=function(a){return a.parentNode};i.C=function(a){i.Z(a,"none")};i.s=function(a,b){i.Z(a,b==e?"none":"")};i.gd=function(a){return a.style.position};i.t=function(b,a){b.style.position=a};i.Ic=function(a){return parseInt(a.style.top,10)};i.n=function(a,b){a.style.top=b+"px"};i.Hc=function(a){return parseInt(a.style.left,10)};i.k=function(a,b){a.style.left=b+"px"};i.g=function(a){return parseInt(a.style.width,10)};i.H=function(c,a){c.style.width=b.max(a,0)+"px"};i.i=function(a){return parseInt(a.style.height,10)};i.R=function(c,a){c.style.height=b.max(a,0)+"px"};i.sc=function(a){return a.style.cssText};i.Ub=function(b,a){b.style.cssText=a};i.Wb=function(b,a){b.removeAttribute(a)};i.Xc=function(b,a){b.style.marginLeft=a+"px"};i.cd=function(b,a){b.style.marginTop=a+"px"};i.Pb=function(a){return parseInt(a.style.zIndex)||0};i.lb=function(c,a){c.style.zIndex=b.ceil(a)};i.Cc=function(b,a){b.style.backgroundColor=a};i.sd=function(){return l()&&j<10};i.od=function(d,c){if(c)d.style.clip="rect("+b.round(c.$Top)+"px "+b.round(c.$Right)+"px "+b.round(c.$Bottom)+"px "+b.round(c.$Left)+"px)";else{var g=i.sc(d),f=[new RegExp(/[\s]*clip: rect\(.*?\)[;]?/i),new RegExp(/[\s]*cliptop: .*?[;]?/i),new RegExp(/[\s]*clipright: .*?[;]?/i),new RegExp(/[\s]*clipbottom: .*?[;]?/i),new RegExp(/[\s]*clipleft: .*?[;]?/i)],e=I(g,f,"");a.Ub(d,e)}};i.y=function(){return+new Date};i.v=function(b,a){b.appendChild(a)};i.wd=function(b,a){p(a,function(a){i.v(b,a)})};i.Db=function(c,b,a){c.insertBefore(b,a)};i.fb=function(b,a){b.removeChild(a)};i.md=function(b,a){p(a,function(a){i.fb(b,a)})};i.jd=function(a){i.md(a,i.T(a))};i.ie=function(b,a){return parseInt(b,a||10)};i.xc=function(a){return parseFloat(a)};i.yc=function(b,a){var c=f.body;while(a&&b!=a&&c!=a)try{a=a.parentNode}catch(d){return e}return b==a};i.u=function(b,a){return b.cloneNode(a)};function L(b,a,c){a.onload=d;a.abort=d;b&&b(a,c)}i.eb=function(e,b){if(i.Hb()&&j<11.6||!e)L(b,d);else{var a=new Image;a.onload=i.r(d,L,b,a);a.onabort=i.r(d,L,b,a,c);a.src=e}};i.le=function(e,b,f){var d=e.length+1;function c(a){d--;if(b&&a&&a.src==b.src)b=a;!d&&f&&f(b)}a.d(e,function(b){a.eb(b.src,c)});c()};i.wc=function(d,k,j,i){if(i)d=a.u(d,c);for(var h=a.Se(d,k),f=h.length-1;f>-1;f--){var b=h[f],e=a.u(j,c);a.dd(e,a.Zc(b));a.Ub(e,a.sc(b));var g=a.gb(b);a.Db(g,e,b);a.fb(g,b)}return d};var C;function lb(b){var g=this,h,d,j;function f(){var c=h;if(d)c+="dn";else if(j)c+="av";a.dd(b,c)}function k(){C.push(g);d=c;f()}g.je=function(){d=e;f()};g.uc=function(a){j=a;f()};b=i.N(b);if(!C){i.Re(function(){var a=C;C=[];p(a,function(a){a.je()})});C=[]}h=i.Zc(b);a.e(b,"mousedown",k)}i.wb=function(a){return new lb(a)};var Z={$Opacity:i.ef,$Top:i.Ic,$Left:i.Hc,Bb:i.g,Ab:i.i,F:i.gd,me:i.Lc,$ZIndex:i.Pb},F={$Opacity:i.Kb,$Top:i.n,$Left:i.k,Bb:i.H,Ab:i.R,me:i.Z,$Clip:i.od,pg:i.Xc,og:i.cd,yb:i.Ge,F:i.t,$ZIndex:i.lb};function H(){return F}function U(){H();F.yb=F.yb;return F}i.ye=H;i.xe=U;i.we=function(c,b){H();var a={};p(b,function(d,b){if(Z[b])a[b]=Z[b](c)});return a};i.Q=function(c,b){var a=H();p(b,function(d,b){a[b]&&a[b](c,d)})};o=new function(){var a=this;function b(d,g){for(var j=d[0].length,i=d.length,h=g[0].length,f=[],c=0;c<i;c++)for(var k=f[c]=[],b=0;b<h;b++){for(var e=0,a=0;a<j;a++)e+=d[c][a]*g[a][b];k[b]=e}return f}a.zb=function(d,c){var a=b(d,[[c.x],[c.y]]);return new h(a[0][0],a[1][0])}};i.Fe=function(d,a,c){var e=b.cos(d),f=b.sin(d);return[[e*a,-f*c],[f*a,e*c]]};i.Ee=function(d,c,a){var e=o.zb(d,new h(-c/2,-a/2)),f=o.zb(d,new h(c/2,-a/2)),g=o.zb(d,new h(c/2,a/2)),i=o.zb(d,new h(-c/2,a/2));return new h(b.min(e.x,f.x,g.x,i.x)+c/2,b.min(e.y,f.y,g.y,i.y)+a/2)}};j=function(n,m,g,O,z,x){n=n||0;var f=this,r,o,p,y,A=0,C,M,L,D,j=0,t=0,E,k=n,i,h,q,u=[],B;function I(b){i+=b;h+=b;k+=b;j+=b;t+=b;a.d(u,function(a){a,a.$Shift(b)})}function N(a,b){var c=a-i+n*b;I(c);return h}function w(w,G){var n=w;if(q&&(n>=h||n<=i))n=((n-i)%q+q)%q+i;if(!E||y||G||j!=n){var p=b.min(n,h);p=b.max(p,i);if(!E||y||G||p!=t){if(x){var e=x;if(z){var s=(p-k)/(m||1);if(g.re&&a.Qb()&&m)s=b.round(s*m/16)/m*16;if(g.$Reverse)s=1-s;e={};for(var o in x){var R=M[o]||1,J=L[o]||[0,1],l=(s-J[0])/J[1];l=b.min(b.max(l,0),1);l=l*R;var H=b.floor(l);if(l!=H)l-=H;var Q=C[o]||C.M,I=Q(l),r,K=z[o],F=x[o];if(a.cf(F))r=K+(F-K)*I;else{r=a.h({L:{}},z[o]);a.d(F.L,function(c,b){var a=c*I;r.L[b]=a;r[b]+=a})}e[o]=r}}if(z.$Zoom)e.yb={$Rotate:e.$Rotate||0,Dc:e.$Zoom,U:g.U,jb:g.jb};if(x.$Clip&&g.$Move){var v=e.$Clip.L,D=(v.$Top||0)+(v.$Bottom||0),A=(v.$Left||0)+(v.$Right||0);e.$Left=(e.$Left||0)+A;e.$Top=(e.$Top||0)+D;e.$Clip.$Left-=A;e.$Clip.$Right-=A;e.$Clip.$Top-=D;e.$Clip.$Bottom-=D}if(e.$Clip&&a.sd()&&!e.$Clip.$Top&&!e.$Clip.$Left&&e.$Clip.$Right==g.U&&e.$Clip.$Bottom==g.jb)e.$Clip=d;a.d(e,function(b,a){B[a]&&B[a](O,b)})}f.Rb(t-k,p-k)}t=p;a.d(u,function(b,c){var a=w<j?u[u.length-c-1]:b;a.x(w,G)});var P=j,N=w;j=n;E=c;f.pb(P,N)}}function F(a,c){c&&a.qb(h,1);h=b.max(h,a.E());u.push(a)}function H(){if(r){var d=a.y(),e=b.min(d-A,a.Hb()?80:20),c=j+e*p;A=d;if(c*p>=o*p)c=o;w(c);if(!y&&c*p>=o*p)J(D);else a.$Delay(H,g.$Interval)}}function v(d,e,g){if(!r){r=c;y=g;D=e;d=b.max(d,i);d=b.min(d,h);o=d;p=o<j?-1:1;f.Yc();A=a.y();H()}}function J(a){if(r){y=r=D=e;f.Wc();a&&a()}}f.$Play=function(a,b,c){v(a?j+a:h,b,c)};f.Kc=function(b,a,c){v(b,a,c)};f.D=function(){J()};f.Wd=function(a){v(a)};f.G=function(){return j};f.Mc=function(){return o};f.rb=function(){return t};f.x=w;f.Gb=function(){w(i,c)};f.$Move=function(a){w(j+a)};f.$IsPlaying=function(){return r};f.Xd=function(a){q=a};f.qb=N;f.$Shift=I;f.J=function(a){F(a,0)};f.Lb=function(a){F(a,1)};f.E=function(){return h};f.pb=a.cb;f.Yc=a.cb;f.Wc=a.cb;f.Rb=a.cb;f.Mb=a.y();g=a.h({$Interval:15},g);q=g.Sc;B=a.h({},a.ye(),g.Tc);i=k=n;h=n+m;var M=g.$Round||{},L=g.$During||{};C=a.h({M:a.Oe(g.$Easing)&&g.$Easing||l.$EaseSwing},g.$Easing)};var r;new function(){;function n(o,Yb){var k=this;function uc(){var a=this;j.call(a,-1e8,2e8);a.Zd=function(){var c=a.rb(),d=b.floor(c),f=u(d),e=c-b.floor(c);return{I:f,Ud:d,F:e}};a.pb=function(d,a){var e=b.floor(a);if(e!=a&&a>d)e++;Nb(e,c);k.f(n.$EVT_POSITION_CHANGE,u(a),u(d),a,d)}}function tc(){var b=this;j.call(b,0,0,{Sc:t});a.d(C,function(a){P&1&&a.Xd(t);b.Lb(a);a.$Shift(sb/Tb)})}function sc(){var a=this,b=Mb.$Elmt;j.call(a,-1,2,{$Easing:l.$EaseLinear,Tc:{F:Sb},Sc:t},b,{F:1},{F:-1});a.tb=b}function gc(o,m){var a=this,f,g,h,l,b;j.call(a,-1e8,2e8);a.Yc=function(){M=c;R=d;k.f(n.$EVT_SWIPE_START,u(x.G()),x.G())};a.Wc=function(){M=e;l=e;var a=x.Zd();k.f(n.$EVT_SWIPE_END,u(x.G()),x.G());!a.F&&wc(a.Ud,r)};a.pb=function(d,c){var a;if(l)a=b;else{a=g;if(h)a=i.$SlideEasing(c/h)*(g-f)+f}x.x(a)};a.mb=function(b,d,c,e){f=b;g=d;h=c;x.x(b);a.x(0);a.Kc(c,e)};a.Fd=function(e){l=c;b=e;a.$Play(e,d,c)};a.Ad=function(a){b=a};x=new uc;x.J(o);x.J(m)}function hc(){var c=this,b=Rb();a.lb(b,0);c.$Elmt=b;c.sb=function(){a.C(b);a.tc(b)}}function rc(p,o){var f=this,s,w,J,x,g,y=[],X,q,bb,H,T,G,l,v,h;j.call(f,-B,B+1,{});function E(a){w&&w.fc();s&&s.fc();Y(p,a);G=c;s=new I.$Class(p,I,1);w=new I.$Class(p,I);w.Gb();s.Gb()}function db(){s.Mb<I.Mb&&E()}function M(o,q,m){if(!H){H=c;if(g&&m){var d=m.width,b=m.height,l=d,j=b;if(d&&b&&i.$FillMode){if(i.$FillMode&3){var h=e,p=L/K*b/d;if(i.$FillMode&1)h=p>1;else if(i.$FillMode&2)h=p<1;l=h?d*K/b:L;j=h?K:b*L/d}a.H(g,l);a.R(g,j);a.n(g,(K-j)/2);a.k(g,(L-l)/2)}a.t(g,"absolute");k.f(n.$EVT_LOAD_END,Wb)}}a.C(q);o&&o(f)}function cb(b,c,d,e){if(e==R&&r==o&&N)if(!vc){var a=u(b);z.Pd(a,o,c,f,d);c.Cd();V.qb(a,1);V.x(a);A.mb(b,b,0)}}function eb(b){if(b==R&&r==o){if(!l){var a=d;if(z)if(z.I==o)a=z.Qd();else z.sb();db();l=new pc(o,a,f.Kd(),f.Ld());l.mc(h)}!l.$IsPlaying()&&l.gc()}}function U(e,c){if(e==o){if(e!=c)C[c]&&C[c].Md();h&&h.$Enable();var k=R=a.y();f.eb(a.r(d,eb,k))}else{var j=b.abs(o-e),g=B+i.$LazyLoading;(!T||j<=g||t-j<=g)&&f.eb()}}function fb(){if(r==o&&l){l.D();h&&h.$Quit();h&&h.$Disable();l.qc()}}function gb(){r==o&&l&&l.D()}function S(b){if(Q)a.ib(b);else k.f(n.$EVT_CLICK,o,b)}function P(){h=v.pInstance;l&&l.mc(h)}f.eb=function(e,b){b=b||x;if(y.length&&!H){a.s(b);if(!bb){bb=c;k.f(n.$EVT_LOAD_START);a.d(y,function(b){if(!b.src){b.src=a.w(b,"src2");a.Z(b,b["display-origin"])}})}a.le(y,g,a.r(d,M,e,b))}else M(e,b)};f.oe=function(){if(z){var b=z.Od(t);if(b){var f=R=a.y(),c=o+1,e=C[u(c)];return e.eb(a.r(d,cb,c,e,b,f),x)}}W(r+i.$AutoPlaySteps)};f.bc=function(){U(o,o)};f.Md=function(){h&&h.$Quit();h&&h.$Disable();f.Ac();l&&l.te();l=d;E()};f.Cd=function(){a.C(p)};f.Ac=function(){a.s(p)};f.ue=function(){h&&h.$Enable()};function Y(b,f,d){if(b["jssor-slider"])return;d=d||0;if(!G){if(b.tagName=="IMG"){y.push(b);if(!b.src){T=c;b["display-origin"]=a.Lc(b);a.C(b)}}a.xb()&&a.lb(b,a.Pb(b)+1);if(i.$HWA&&a.rc()>0)(!F||a.rc()<534||!ab)&&a.Ae(b)}var h=a.T(b);a.d(h,function(h){var j=a.w(h,"u");if(j=="player"&&!v){v=h;if(v.pInstance)P();else a.e(v,"dataavailable",P)}if(j=="caption"){if(!a.Ob()&&!f){var i=a.u(h,c);a.Db(b,i,h);a.fb(b,h);h=i;f=c}}else if(!G&&!d&&!g&&a.w(h,"u")=="image"){g=h;if(g){if(g.tagName=="A"){X=g;a.Q(X,O);q=a.u(g,e);a.e(q,"click",S);a.Q(q,O);a.Z(q,"block");a.Kb(q,0);a.Cc(q,"#000");g=a.Ke(g,"IMG")}g.border=0;a.Q(g,O)}}Y(h,f,d+1)})}f.Rb=function(c,b){var a=B-b;Sb(J,a)};f.Kd=function(){return s};f.Ld=function(){return w};f.I=o;m.call(f);var D=a.q(p,"thumb");if(D){f.de=a.u(D,c);a.Wb(D,"id");a.C(D)}a.s(p);x=a.u(Z,c);a.lb(x,1e3);a.e(p,"click",S);E(c);f.Jc=g;f.Fc=q;f.tb=J=p;a.v(J,x);k.$On(203,U);k.$On(22,gb);k.$On(24,fb)}function pc(h,q,v,u){var b=this,m=0,x=0,o,g,d,f,l,s,w,t,p=C[h];j.call(b,0,0);function y(){a.jd(J);Xb&&l&&p.Fc&&a.v(J,p.Fc);a.s(J,l||!p.Jc)}function A(){if(s){s=e;k.f(n.$EVT_ROLLBACK_END,h,d,m,g,d,f);b.x(g)}b.gc()}function B(a){t=a;b.D();b.gc()}b.gc=function(){var a=b.rb();if(!G&&!M&&!t&&(a!=d||N&&(!Pb||U))&&r==h){if(!a){if(o&&!l){l=c;b.qc(c);k.f(n.$EVT_SLIDESHOW_START,h,m,x,o,f)}y()}var e,i=n.$EVT_STATE_CHANGE;if(a==f){d==f&&b.x(g);return p.oe()}else if(a==d)e=f;else if(a==g)e=d;else if(!a)e=g;else if(a>d){s=c;e=d;i=n.$EVT_ROLLBACK_START}else e=b.Mc();k.f(i,h,a,m,g,d,f);b.Kc(e,A)}};b.te=function(){z&&z.I==h&&z.sb();var a=b.rb();a<f&&k.f(n.$EVT_STATE_CHANGE,h,-a-1,m,g,d,f)};b.qc=function(b){q&&a.W(db,b&&q.ab.$Outside?"":"hidden")};b.Rb=function(b,a){if(l&&a>=o){l=e;y();p.Ac();z.sb();k.f(n.$EVT_SLIDESHOW_END,h,m,x,o,f)}k.f(n.$EVT_PROGRESS_CHANGE,h,a,m,g,d,f)};b.mc=function(a){if(a&&!w){w=a;a.$On($JssorPlayer$.Td,B)}};q&&b.Lb(q);o=b.E();b.E();b.Lb(v);g=v.E();d=g+i.$AutoPlayInterval;u.$Shift(d);b.J(u);f=b.E()}function Sb(c,g){var f=w>0?w:i.$PlayOrientation,d=b.round(xb*g*(f&1)),e=b.round(yb*g*(f>>1&1));if(a.Ob()&&a.bb()>=10&&a.bb()<11)c.style.msTransform="translate("+d+"px, "+e+"px)";else if(a.Qb()&&a.bb()>=30&&a.bb()<34){c.style.WebkitTransition="transform 0s";c.style.WebkitTransform="translate3d("+d+"px, "+e+"px, 0px) perspective(2000px)"}else{a.k(c,d);a.n(c,e)}}function nc(a){Q=0;!H&&kc()&&mc(a)}function mc(b){kb=M;G=c;wb=e;R=d;a.e(f,ib,Ub);a.y();Fb=A.Mc();A.D();if(!kb)w=0;if(F){var h=b.touches[0];qb=h.clientX;rb=h.clientY}else{var g=a.Bc(b);qb=g.x;rb=g.y;a.ib(b)}E=0;Y=0;cb=0;D=x.G();k.f(n.$EVT_DRAG_START,u(D),D,b)}function Ub(e){if(G&&(!a.xb()||e.button)){var f;if(F){var n=e.touches;if(n&&n.length>0)f=new h(n[0].clientX,n[0].clientY)}else f=a.Bc(e);if(f){var l=f.x-qb,m=f.y-rb;if(b.floor(D)!=D)w=w||i.$PlayOrientation&H;if((l||m)&&!w){if(H==3)if(b.abs(m)>b.abs(l))w=2;else w=1;else w=H;if(F&&w==1&&b.abs(m)-b.abs(l)>3)wb=c}if(w){var d=m,k=yb;if(w==1){d=l;k=xb}if(!(P&1)){if(d>0){var g=k*r,j=d-g;if(j>0)d=g+b.sqrt(j)*5}if(d<0){var g=k*(t-B-r),j=-d-g;if(j>0)d=-g-b.sqrt(j)*5}}if(E-Y<-2)cb=1;else if(E-Y>2)cb=0;Y=E;E=d;ob=D-E/k/(hb||1);if(E&&w&&!wb){a.ib(e);if(!M)A.Fd(ob);else A.Ad(ob)}else a.xb()&&a.ib(e)}}}else Bb(e)}function Bb(h){ic();if(G){G=e;a.y();a.Ce(f,ib,Ub);Q=E;Q&&a.ib(h);A.D();var d=x.G();k.f(n.$EVT_DRAG_END,u(d),d,u(D),D,h);var c=b.floor(D);if(b.abs(E)>=i.$MinDragOffsetToSlide){c=b.floor(d);c+=cb}if(!(P&1))c=b.min(t-B,b.max(c,0));var g=b.abs(c-d);g=1-b.pow(1-g,5);if(!Q&&kb)A.Wd(Fb);else if(d==c){pb.ue();pb.bc()}else A.mb(d,c,g*Ob)}}function fc(a){C[r];r=u(a);pb=C[r];Nb(a);return r}function wc(a,b){w=0;fc(a);k.f(n.$EVT_PARK,u(a),b)}function Nb(b,c){ub=b;a.d(S,function(a){a.Zb(u(b),b,c)})}function kc(){var b=n.vc||0,a=i.$DragOrientation;if(F)a&1&&(a&=1);n.vc|=a;return H=a&~b}function ic(){if(H){n.vc&=~i.$DragOrientation;H=0}}function Rb(){var b=a.ub();a.Q(b,O);a.t(b,"absolute");return b}function u(a){return(a%t+t)%t}function cc(a,c){if(c)if(!P){a=b.min(b.max(a+ub,0),t-1);c=e}else if(P&2){a=u(a+ub);c=e}W(a,i.$SlideDuration,c)}function vb(){a.d(S,function(a){a.Xb(a.Cb.$ChanceToShow>U)})}function ac(b){b=a.Tb(b);var c=b.target?b.target:b.srcElement,d=b.relatedTarget?b.relatedTarget:b.toElement;if(!a.yc(o,c)||a.yc(o,d))return;U=1;vb();C[r].bc()}function Zb(){U=0;vb()}function bc(){O={Bb:L,Ab:K,$Top:0,$Left:0};a.d(T,function(b){a.Q(b,O);a.t(b,"absolute");a.W(b,"hidden");a.C(b)});a.Q(Z,O)}function fb(b,a){W(b,a,c)}function W(h,g,l){if(Lb&&(!G||i.$NaviQuitDrag)){M=c;G=e;A.D();if(a.Vb(g))g=Ob;var f=Cb.rb(),d=h;if(l){d=f+h;if(h>0)d=b.ceil(d);else d=b.floor(d)}if(!(P&1)){d=u(d);d=b.max(0,b.min(d,t-B))}var k=(d-f)%t;d=f+k;var j=f==d?0:g*b.abs(k);j=b.min(j,g*B*1.5);A.mb(f,d,j||1)}}k.$PlayTo=W;k.$GoTo=function(a){W(a,1)};k.$Next=function(){fb(1)};k.$Prev=function(){fb(-1)};k.$Pause=function(){N=e};k.$Play=function(){if(!N){N=c;C[r]&&C[r].bc()}};k.$SetSlideshowTransitions=function(a){i.$SlideshowOptions.$Transitions=a};k.$SetCaptionTransitions=function(b){I.$CaptionTransitions=b;I.Mb=a.y()};k.$SlidesCount=function(){return T.length};k.$CurrentIndex=function(){return r};k.$IsAutoPlaying=function(){return N};k.$IsDragging=function(){return G};k.$IsSliding=function(){return M};k.$IsMouseOver=function(){return!U};k.$LastDragSucceded=function(){return Q};k.$GetOriginalWidth=function(){return a.g(v||o)};k.$GetOriginalHeight=function(){return a.i(v||o)};k.$GetScaleWidth=function(){return a.g(o)};k.$GetScaleHeight=function(){return a.i(o)};k.$SetScaleWidth=function(c){if(!v){var b=a.u(o,e);a.Wb(b,"id");a.t(b,"relative");a.n(b,0);a.k(b,0);a.W(b,"visible");v=a.u(o,e);a.Wb(v,"id");a.Ub(v,"");a.t(v,"absolute");a.n(v,0);a.k(v,0);a.H(v,a.g(o));a.R(v,a.i(o));a.Ie(v,"0 0");a.v(v,b);var d=a.T(o);a.v(o,v);a.wd(b,d);a.s(b);a.s(v)}hb=c/a.g(v);a.He(v,hb);a.H(o,c);a.R(o,hb*a.i(v))};k.jc=function(a){var d=b.ceil(u(sb/Tb)),c=u(a-r+d);if(c>B){if(a-r>t/2)a-=t;else if(a-r<=-t/2)a+=t}else a=r+c-d;return a};m.call(this);k.$Elmt=o=a.N(o);var i=a.h({$FillMode:0,$LazyLoading:1,$StartIndex:0,$AutoPlay:e,$Loop:1,$HWA:c,$NaviQuitDrag:c,$AutoPlaySteps:1,$AutoPlayInterval:3e3,$PauseOnHover:1,$HwaMode:1,$SlideDuration:500,$SlideEasing:l.$EaseOutQuad,$MinDragOffsetToSlide:20,$SlideSpacing:0,$DisplayPieces:1,$ParkingPosition:0,$UISearchMode:1,$PlayOrientation:1,$DragOrientation:1},Yb),bb=i.$SlideshowOptions,I=a.h({$Class:s,$PlayInMode:1,$PlayOutMode:1},i.$CaptionSliderOptions),lb=i.$BulletNavigatorOptions,mb=i.$ArrowNavigatorOptions,X=i.$ThumbnailNavigatorOptions,eb=i.$UISearchMode,v,y=a.q(o,"slides",d,eb),Z=a.q(o,"loading",d,eb)||a.ub(f),Ib=a.q(o,"navigator",d,eb),Eb=a.q(o,"thumbnavigator",d,eb),ec=a.g(y),dc=a.i(y),O,T=[],oc=a.T(y);a.d(oc,function(b){b.tagName=="DIV"&&!a.w(b,"u")&&T.push(b)});var r=-1,ub,pb,t=T.length,L=i.$SlideWidth||ec,K=i.$SlideHeight||dc,Qb=i.$SlideSpacing,xb=L+Qb,yb=K+Qb,Tb=i.$PlayOrientation==1?xb:yb,B=b.min(i.$DisplayPieces,t),db,w,H,wb,F,S=[],Vb,Gb,Kb,Xb,vc,N,Pb=i.$PauseOnHover,Ob=i.$SlideDuration,nb,ab,sb,Lb=B<t,P=Lb?i.$Loop:0;if(!(P&1))i.$ParkingPosition=0;if(i.$DisplayPieces>1||i.$ParkingPosition)i.$DragOrientation&=i.$PlayOrientation;var lc=i.$DragOrientation,Q,U=1,M,G,R,qb=0,rb=0,E,Y,cb,Cb,x,V,A,Mb=new hc,hb;N=i.$AutoPlay;k.Cb=Yb;bc();o["jssor-slider"]=c;a.lb(y,a.Pb(y));a.t(y,"absolute");db=a.u(y);a.Db(a.gb(y),db,y);if(bb){Xb=bb.$ShowLink;nb=bb.$Class;ab=B==1&&t>1&&nb&&(!a.Ob()||a.bb()>=8)}sb=ab||B>=t?0:i.$ParkingPosition;var tb=y,C=[],z,J,Ab="mousedown",ib="mousemove",Db="mouseup",gb,D,kb,Fb,ob;if(g.navigator.msPointerEnabled){Ab="MSPointerDown";ib="MSPointerMove";Db="MSPointerUp";gb="MSPointerCancel";if(i.$DragOrientation){var zb="none";if(i.$DragOrientation==1)zb="pan-y";else if(i.$DragOrientation==2)zb="pan-x";a.Ve(tb.style,"-ms-touch-action",zb)}}else if("ontouchstart"in g||"createTouch"in f){F=c;Ab="touchstart";ib="touchmove";Db="touchend";gb="touchcancel"}V=new sc;if(ab)z=new nb(Mb,L,K,bb,F);a.v(db,V.tb);a.W(y,"hidden");J=Rb();a.Cc(J,"#000");a.Kb(J,0);a.Db(tb,J,tb.firstChild);for(var jb=0;jb<T.length;jb++){var qc=T[jb],Wb=new rc(qc,jb);C.push(Wb)}a.C(Z);Cb=new tc;A=new gc(Cb,V);if(lc){a.e(y,Ab,nc);a.e(f,Db,Bb);gb&&a.e(f,gb,Bb)}Pb&=F?2:1;if(Ib&&lb){Vb=new lb.$Class(Ib,lb);S.push(Vb)}if(mb){Gb=new mb.$Class(o,mb,i.$UISearchMode);S.push(Gb)}if(Eb&&X){X.$StartIndex=i.$StartIndex;Kb=new X.$Class(Eb,X);S.push(Kb)}a.d(S,function(a){a.cc(t,C,Z);a.$On(p.vb,cc)});a.e(o,"mouseout",ac);a.e(o,"mouseover",Zb);vb();i.$ArrowKeyNavigation&&a.e(f,"keydown",function(a){if(a.keyCode==q.Te)fb(-1);else a.keyCode==q.Ue&&fb(1)});k.$SetScaleWidth(k.$GetOriginalWidth());A.mb(i.$StartIndex,i.$StartIndex,0)}n.$EVT_CLICK=21;n.$EVT_DRAG_START=22;n.$EVT_DRAG_END=23;n.$EVT_SWIPE_START=24;n.$EVT_SWIPE_END=25;n.$EVT_LOAD_START=26;n.$EVT_LOAD_END=27;n.$EVT_POSITION_CHANGE=202;n.$EVT_PARK=203;n.$EVT_SLIDESHOW_START=206;n.$EVT_SLIDESHOW_END=207;n.$EVT_PROGRESS_CHANGE=208;n.$EVT_STATE_CHANGE=209;n.$EVT_ROLLBACK_START=210;n.$EVT_ROLLBACK_END=211;g.$JssorSlider$=r=n};var p={vb:1};g.$JssorBulletNavigator$=function(e,B){var g=this;m.call(g);e=a.N(e);var s,t,r,q,k=0,f,l,j,x,y,i,h,o,n,A=[],z=[];function w(a){a!=-1&&z[a].uc(a==k)}function u(a){g.f(p.vb,a*l)}g.$Elmt=e;g.Zb=function(a){if(a!=q){var d=k,c=b.floor(a/l);k=c;q=a;w(d);w(c)}};g.Xb=function(b){a.s(e,b)};var v;g.cc=function(E){if(!v){s=b.ceil(E/l);k=0;var q=o+x,w=n+y,p=b.ceil(s/j)-1;t=o+q*(!i?p:j-1);r=n+w*(i?p:j-1);a.H(e,t);a.R(e,r);f.$AutoCenter&1&&a.k(e,(a.g(a.gb(e))-t)/2);f.$AutoCenter&2&&a.n(e,(a.i(a.gb(e))-r)/2);for(var g=0;g<s;g++){var D=a.We();a.Me(D,g+1);var m=a.wc(h,"NumberTemplate",D,c);a.t(m,"absolute");var B=g%(p+1);a.k(m,!i?q*B:g%j*q);a.n(m,i?w*B:b.floor(g/(p+1))*w);a.v(e,m);A[g]=m;f.$ActionMode&1&&a.e(m,"click",a.r(d,u,g));f.$ActionMode&2&&a.e(m,"mouseover",a.r(d,u,g));z[g]=a.wb(m)}v=c}};g.Cb=f=a.h({$SpacingX:0,$SpacingY:0,$Orientation:1,$ActionMode:1},B);h=a.q(e,"prototype");o=a.g(h);n=a.i(h);a.fb(e,h);l=f.$Steps||1;j=f.$Lanes||1;x=f.$SpacingX;y=f.$SpacingY;i=f.$Orientation-1};g.$JssorArrowNavigator$=function(i,t,o){var e=this;m.call(e);var b=a.q(i,"arrowleft",d,o),f=a.q(i,"arrowright",d,o),h,j,n=a.g(i),l=a.i(i),r=a.g(b),q=a.i(b);function k(a){e.f(p.vb,a,c)}e.Zb=function(b,a,c){if(c);};e.Xb=function(c){a.s(b,c);a.s(f,c)};var s;e.cc=function(c){if(!s){if(h.$AutoCenter&1){a.k(b,(n-r)/2);a.k(f,(n-r)/2)}if(h.$AutoCenter&2){a.n(b,(l-q)/2);a.n(f,(l-q)/2)}a.e(b,"click",a.r(d,k,-j));a.e(f,"click",a.r(d,k,j));a.wb(b);a.wb(f)}};e.Cb=h=a.h({$Steps:1},t);j=h.$Steps};g.$JssorThumbnailNavigator$=function(i,A){var h=this,x,l,d,u=[],y,w,f,n,o,t,s,k,q,g,j;m.call(h);i=a.N(i);function z(n,e){var g=this,b,m,k;function o(){m.uc(l==e)}function i(){if(!q.$LastDragSucceded()){var a=(f-e%f)%f,b=q.jc((e+a)/f),c=b*f-a;h.f(p.vb,c)}}g.I=e;g.Oc=o;k=n.de||n.Jc||a.ub();g.tb=b=a.wc(j,"ThumbnailTemplate",k,c);m=a.wb(b);d.$ActionMode&1&&a.e(b,"click",i);d.$ActionMode&2&&a.e(b,"mouseover",i)}h.Zb=function(c,d,e){var a=l;l=c;a!=-1&&u[a].Oc();u[c].Oc();!e&&q.$PlayTo(q.jc(b.floor(d/f)))};h.Xb=function(b){a.s(i,b)};var v;h.cc=function(F,D){if(!v){x=F;b.ceil(x/f);l=-1;k=b.min(k,D.length);var h=d.$Orientation&1,p=t+(t+n)*(f-1)*(1-h),m=s+(s+o)*(f-1)*h,C=p+(p+n)*(k-1)*h,A=m+(m+o)*(k-1)*(1-h);a.t(g,"absolute");a.W(g,"hidden");d.$AutoCenter&1&&a.k(g,(y-C)/2);d.$AutoCenter&2&&a.n(g,(w-A)/2);a.H(g,C);a.R(g,A);var j=[];a.d(D,function(l,e){var i=new z(l,e),d=i.tb,c=b.floor(e/f),k=e%f;a.k(d,(t+n)*k*(1-h));a.n(d,(s+o)*k*h);if(!j[c]){j[c]=a.ub();a.v(g,j[c])}a.v(j[c],d);u.push(i)});var E=a.h({$AutoPlay:e,$NaviQuitDrag:e,$SlideWidth:p,$SlideHeight:m,$SlideSpacing:n*h+o*(1-h),$MinDragOffsetToSlide:12,$SlideDuration:200,$PauseOnHover:1,$PlayOrientation:d.$Orientation,$DragOrientation:d.$DisableDrag?0:d.$Orientation},d);q=new r(i,E);v=c}};h.Cb=d=a.h({$SpacingX:3,$SpacingY:3,$DisplayPieces:1,$Orientation:1,$AutoCenter:3,$ActionMode:1},A);y=a.g(i);w=a.i(i);g=a.q(i,"slides");j=a.q(g,"prototype");a.fb(g,j);f=d.$Lanes||1;n=d.$SpacingX;o=d.$SpacingY;t=a.g(j);s=a.i(j);k=d.$DisplayPieces};function s(){j.call(this,0,0);this.fc=a.cb}g.$JssorCaptionSlider$=function(p,k,g){var d=this,h,f=k.$CaptionTransitions,o={ab:"t",$Delay:"d",$Duration:"du",$ScaleHorizontal:"x",$ScaleVertical:"y",$Rotate:"r",$Zoom:"z",$Opacity:"f",O:"b"},e={M:function(b,a){if(!isNaN(a.P))b=a.P;else b*=a.hd;return b},$Opacity:function(b,a){return this.M(b-1,a)}};e.$Zoom=e.$Opacity;j.call(d,0,0);function m(r,n){var l=[],i,j=[],c=[];function h(c,d){var b={};a.d(o,function(g,h){var e=a.w(c,g+(d||""));if(e){var f={};if(g=="t")f.P=e;else if(e.indexOf("%")+1)f.hd=a.xc(e)/100;else f.P=a.xc(e);b[h]=f}});return b}function p(){return f[b.floor(b.random()*f.length)]}function d(g){var h;if(g=="*")h=p();else if(g){var e=f[a.ie(g)]||f[g];if(a.Nb(e)){if(g!=i){i=g;c[g]=0;j[g]=e[b.floor(b.random()*e.length)]}else c[g]++;e=j[g];if(a.Nb(e)){e=e.length&&e[c[g]%e.length];if(a.Nb(e))e=e[b.floor(b.random()*e.length)]}}h=e;if(a.hc(h))h=d(h)}return h}var q=a.T(r);a.d(q,function(b){var c=[];c.$Elmt=b;var f=a.w(b,"u")=="caption";a.d(g?[0,3]:[2],function(o,p){if(f){var l,i;if(o!=2||!a.w(b,"t3")){i=h(b,o);if(o==2&&!i.ab){i.$Delay=i.$Delay||{P:0};i=a.h(h(b,0),i)}}if(i&&i.ab){l=d(i.ab.P);if(l){var j=a.h({$Delay:0,$ScaleHorizontal:1,$ScaleVertical:1},l);a.d(i,function(c,a){var b=(e[a]||e.M).apply(e,[j[a],i[a]]);if(!isNaN(b))j[a]=b});if(!p)if(i.O)j.O=i.O.P||0;else if((g?k.$PlayInMode:k.$PlayOutMode)&2)j.O=0}}c.push(j)}if(n%2&&!p)c.rd=m(b,n+1)});l.push(c)});return l}function n(E,d,F){var h={$Easing:d.$Easing,$Round:d.$Round,$During:d.$During,$Reverse:g&&!F,re:c},k=E,y=a.gb(E),o=a.g(k),n=a.i(k),u=a.g(y),t=a.i(y),f={},l={},m=d.$ScaleClip||1;if(d.$Opacity)f.$Opacity=2-d.$Opacity;h.U=o;h.jb=n;if(d.$Zoom||d.$Rotate){f.$Zoom=d.$Zoom?d.$Zoom-1:1;if(a.xb()||a.Hb())f.$Zoom=b.min(f.$Zoom,2);l.$Zoom=1;var s=d.$Rotate||0;if(s==c)s=1;f.$Rotate=s*360;l.$Rotate=0}else if(d.$Clip){var z={$Top:0,$Right:o,$Bottom:n,$Left:0},D=a.h({},z),e=D.L={},C=d.$Clip&4,v=d.$Clip&8,A=d.$Clip&1,x=d.$Clip&2;if(C&&v){e.$Top=n/2*m;e.$Bottom=-e.$Top}else if(C)e.$Bottom=-n*m;else if(v)e.$Top=n*m;if(A&&x){e.$Left=o/2*m;e.$Right=-e.$Left}else if(A)e.$Right=-o*m;else if(x)e.$Left=o*m;h.$Move=d.$Move;f.$Clip=D;l.$Clip=z}var p=d.$FlyDirection,q=0,r=0,w=d.$ScaleHorizontal,B=d.$ScaleVertical;if(i.Qe(p))q-=u*w;else if(i.Pe(p))q+=u*w;if(i.De(p))r-=t*B;else if(i.Be(p))r+=t*B;if(q||r||h.$Move){f.$Left=q+a.Hc(k);f.$Top=r+a.Ic(k)}var G=d.$Duration;l=a.h(l,a.we(k,f));h.Tc=a.xe();return new j(d.$Delay,G,h,k,l,f)}function l(b,c){a.d(c,function(c){var f,i=c.$Elmt,e=c[0],j=c[1];if(e){f=n(i,e);b=f.qb(a.Vb(e.O)?b:e.O,1)}b=l(b,c.rd);if(j){var g=n(i,j,1);g.qb(b,1);d.J(g);h.J(g)}f&&d.J(f)});return b}d.fc=function(){d.x(d.E()*(g||0));h.Gb()};h=new j(0,0);l(0,m(p,1))}})(window,document,Math,null,true,false)