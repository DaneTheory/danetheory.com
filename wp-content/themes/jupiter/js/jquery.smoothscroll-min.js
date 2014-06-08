/* 
SmoothScroll v0.9.9
Licensed under the terms of the MIT license.

People involved
- Balazs Galambosi: maintainer (CHANGELOG.txt)
- Patrick Brunner (patrickb1991@gmail.com)
- Michael Herf: ssc_pulse Algorithm
*/jQuery(document).ready(function(e){function m(){if(!document.body)return;var e=document.body,t=document.documentElement,n=window.innerHeight,r=e.scrollHeight;p=document.compatMode.indexOf("CSS")>=0?t:e;d=e;c=!0;if(top!=self)f=!0;else if(r>n&&(e.offsetHeight<=n||t.offsetHeight<=n)){p.style.height="auto";if(p.offsetHeight<=n){var i=document.createElement("div");i.style.clear="both";e.appendChild(i)}}if(!h){e.style.backgroundAttachment="scroll";t.style.backgroundAttachment="scroll"}u&&k("keydown",E)}function b(e,r,s,o){o||(o=1e3);O(r,s);g.push({x:r,y:s,lastX:r<0?.99:-0.99,lastY:s<0?.99:-0.99,start:+(new Date)});if(y)return;var u=function(){var a=+(new Date),f=0,l=0;for(var c=0;c<g.length;c++){var h=g[c],p=a-h.start,d=p>=n,v=d?1:p/n;i&&(v=_(v));var m=h.x*v-h.lastX>>0,b=h.y*v-h.lastY>>0;f+=m;l+=b;h.lastX+=m;h.lastY+=b;if(d){g.splice(c,1);c--}}if(r){var w=e.scrollLeft;e.scrollLeft+=f;f&&e.scrollLeft===w&&(r=0)}if(s){var E=e.scrollTop;e.scrollTop+=l;l&&e.scrollTop===E&&(s=0)}!r&&!s&&(g=[]);g.length?setTimeout(u,o/t+1):y=!1};setTimeout(u,0);y=!0}function w(e){c||init();var t=e.target,n=C(t);if(!n||e.defaultPrevented||A(d,"embed")||A(t,"embed")&&/\.pdf/i.test(t.src))return!0;var i=e.wheelDeltaX||0,s=e.wheelDeltaY||0;!i&&!s&&(s=e.wheelDelta||0);Math.abs(i)>1.2&&(i*=r/120);Math.abs(s)>1.2&&(s*=r/120);b(n,-i,-s);e.preventDefault()}function E(e){var t=e.target,n=e.ctrlKey||e.altKey||e.metaKey;if(/input|textarea|embed/i.test(t.nodeName)||t.isContentEditable||e.defaultPrevented||n)return!0;if(A(t,"button")&&e.keyCode===v.spacebar)return!0;var r,i=0,s=0,o=C(d),u=o.clientHeight;o==document.body&&(u=window.innerHeight);switch(e.keyCode){case v.up:s=-a;break;case v.down:s=a;break;case v.spacebar:r=e.shiftKey?1:-1;s=-r*u*.9;break;case v.pageup:s=-u*.9;break;case v.pagedown:s=u*.9;break;case v.home:s=-o.scrollTop;break;case v.end:var f=o.scrollHeight-o.scrollTop-u;s=f>0?f+10:0;break;case v.left:i=-a;break;case v.right:i=a;break;default:return!0}b(o,i,s);e.preventDefault()}function S(e){d=e.target}function N(e,t){for(var n=e.length;n--;)x[T(e[n])]=t;return t}function C(e){var t=[],n=p.scrollHeight;do{var r=x[T(e)];if(r)return N(t,r);t.push(e);if(n===e.scrollHeight){if(!f||p.clientHeight+10<n)return N(t,document.body)}else if(e.clientHeight+10<e.scrollHeight){overflow=getComputedStyle(e,"").getPropertyValue("overflow");if(overflow==="scroll"||overflow==="auto")return N(t,e)}}while(e=e.parentNode)}function k(e,t,n){window.addEventListener(e,t,n||!1)}function L(e,t,n){window.removeEventListener(e,t,n||!1)}function A(e,t){return e.nodeName.toLowerCase()===t.toLowerCase()}function O(e,t){e=e>0?1:-1;t=t>0?1:-1;if(l.x!==e||l.y!==t){l.x=e;l.y=t;g=[]}}function M(e){var t,n,r;e*=s;if(e<1)t=e-(1-Math.exp(-e));else{n=Math.exp(-1);e-=1;r=1-Math.exp(-e);t=n+r*(1-n)}return t*o}function _(e){if(e>=1)return 1;if(e<=0)return 0;o==1&&(o/=M(1));return M(e)}var t=150,n=700,r=170,i=!0,s=6,o=1,u=!0,a=60,f=!1,l={x:0,y:0},c=!1,h=!0,p=document.documentElement,d,v={left:37,up:38,right:39,down:40,spacebar:32,pageup:33,pagedown:34,end:35,home:36},g=[],y=!1,x={};setInterval(function(){x={}},1e4);var T=function(){var e=0;return function(t){return t.ssc_uniqueID||(t.ssc_uniqueID=e++)}}();e.browser.chrome=/chrome/.test(navigator.userAgent.toLowerCase());if(e.browser.chrome){k("mousedown",S);k("mousewheel",w);k("load",m)}});