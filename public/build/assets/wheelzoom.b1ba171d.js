/*!
    Wheelzoom 4.0.1
    license: MIT
    http://www.jacklmoore.com/wheelzoom
*/window.wheelzoom=function(){const m={zoom:.1,maxZoom:!1,initialZoom:1,initialX:.5,initialY:.5},g=function(e,u){if(!e||!e.nodeName||e.nodeName!=="IMG")return;const a={};let l,d,o,n,r,s,i,f;function z(t){t.style.backgroundRepeat="no-repeat",t.style.backgroundImage='url("'+t.src+'")',f="data:image/svg+xml;base64,"+window.btoa('<svg xmlns="http://www.w3.org/2000/svg" width="'+t.naturalWidth+'" height="'+t.naturalHeight+'"></svg>'),t.src=f}function v(){r>0?r=0:r<l-o&&(r=l-o),s>0?s=0:s<d-n&&(s=d-n),e.style.backgroundSize=o+"px "+n+"px",e.style.backgroundPosition=r+"px "+s+"px"}function p(){o=l,n=d,r=s=0,v()}function E(t){let c=0;t.preventDefault(),t.deltaY?c=t.deltaY:t.wheelDelta&&(c=-t.wheelDelta);const x=e.getBoundingClientRect(),k=t.pageX-x.left-window.scrollX,Y=t.pageY-x.top-window.scrollY,X=k-r,I=Y-s,R=X/o,S=I/n;c<0?(o+=o*a.zoom,n+=n*a.zoom):(o-=o*a.zoom,n-=n*a.zoom),a.maxZoom&&(o=Math.min(l*a.maxZoom,o),n=Math.min(d*a.maxZoom,n)),r=k-o*R,s=Y-n*S,o<=l||n<=d?p():v()}function w(t){t.preventDefault(),r+=t.pageX-i.pageX,s+=t.pageY-i.pageY,i=t,v()}function h(){document.removeEventListener("mouseup",h),document.removeEventListener("mousemove",w)}function y(t){t.preventDefault(),i=t,document.addEventListener("mousemove",w),document.addEventListener("mouseup",h)}function b(){const t=Math.max(a.initialZoom,1);if(e.src===f)return;const c=window.getComputedStyle(e,null);l=parseInt(c.width,10),d=parseInt(c.height,10),o=l*t,n=d*t,r=-(o-l)*a.initialX,s=-(n-d)*a.initialY,z(e),e.style.backgroundSize=o+"px "+n+"px",e.style.backgroundPosition=r+"px "+s+"px",e.addEventListener("wheelzoom.reset",p),e.addEventListener("wheel",E),e.addEventListener("mousedown",y)}const L=function(t){e.removeEventListener("wheelzoom.destroy",L),e.removeEventListener("wheelzoom.reset",p),e.removeEventListener("load",b),e.removeEventListener("mouseup",h),e.removeEventListener("mousemove",w),e.removeEventListener("mousedown",y),e.removeEventListener("wheel",E),e.style.backgroundImage=t.backgroundImage,e.style.backgroundRepeat=t.backgroundRepeat,e.src=t.src}.bind(null,{backgroundImage:e.style.backgroundImage,backgroundRepeat:e.style.backgroundRepeat,src:e.src});e.addEventListener("wheelzoom.destroy",L),u=u||{},Object.keys(m).forEach(function(t){a[t]=u[t]!==void 0?u[t]:m[t]}),e.complete&&b(),e.addEventListener("load",b)};return typeof window.btoa!="function"?function(e){return e}:function(e,u){return e&&e.length?Array.prototype.forEach.call(e,function(a){g(a,u)}):e&&e.nodeName&&g(e,u),e}}();
