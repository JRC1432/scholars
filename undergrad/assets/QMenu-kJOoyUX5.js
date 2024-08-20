import{v as D,F as k,I as p,L as se,z as re,x as Ce,B as O,C as ce,b9 as Te,r as W,aV as de,N as fe,V as He,at as J,a0 as Se,aM as Z,G as M,$ as Me,H as j,aP as We,bc as K,bs as ee,ai as Be,bt as Le,y as pe,b2 as Pe,A as Ae,aX as $e,X as Re,b3 as ze,E as Fe,b4 as _e,bu as Ke,aO as Qe,bv as De,bw as te,b5 as Oe,bx as je,aQ as Ie,by as Ve,bz as Ne,bA as Xe}from"./index-Lhrr584p.js";import{c as Ue}from"./selection-Dtef2Nxx.js";const at=D({name:"QItemSection",props:{avatar:Boolean,thumbnail:Boolean,side:Boolean,top:Boolean,noWrap:Boolean},setup(e,{slots:n}){const l=k(()=>`q-item__section column q-item__section--${e.avatar===!0||e.side===!0||e.thumbnail===!0?"side":"main"}`+(e.top===!0?" q-item__section--top justify-start":" justify-center")+(e.avatar===!0?" q-item__section--avatar":"")+(e.thumbnail===!0?" q-item__section--thumbnail":"")+(e.noWrap===!0?" q-item__section--nowrap":""));return()=>p("div",{class:l.value},se(n.default))}}),ut=D({name:"QItem",props:{...re,...Ce,tag:{type:String,default:"div"},active:{type:Boolean,default:null},clickable:Boolean,dense:Boolean,insetLevel:Number,tabindex:[String,Number],focused:Boolean,manualFocus:Boolean},emits:["click","keyup"],setup(e,{slots:n,emit:l}){const{proxy:{$q:t}}=O(),i=ce(e,t),{hasLink:d,linkAttrs:a,linkClass:v,linkTag:h,navigateOnClick:c}=Te(),f=W(null),m=W(null),b=k(()=>e.clickable===!0||d.value===!0||e.tag==="label"),o=k(()=>e.disable!==!0&&b.value===!0),s=k(()=>"q-item q-item-type row no-wrap"+(e.dense===!0?" q-item--dense":"")+(i.value===!0?" q-item--dark":"")+(d.value===!0&&e.active===null?v.value:e.active===!0?` q-item--active${e.activeClass!==void 0?` ${e.activeClass}`:""}`:"")+(e.disable===!0?" disabled":"")+(o.value===!0?" q-item--clickable q-link cursor-pointer "+(e.manualFocus===!0?"q-manual-focusable":"q-focusable q-hoverable")+(e.focused===!0?" q-manual-focusable--focused":""):"")),T=k(()=>e.insetLevel===void 0?null:{["padding"+(t.lang.rtl===!0?"Right":"Left")]:16+e.insetLevel*56+"px"});function w(r){o.value===!0&&(m.value!==null&&(r.qKeyEvent!==!0&&document.activeElement===f.value?m.value.focus():document.activeElement===m.value&&f.value.focus()),c(r))}function H(r){if(o.value===!0&&de(r,[13,32])===!0){fe(r),r.qKeyEvent=!0;const x=new MouseEvent("click",r);x.qKeyEvent=!0,f.value.dispatchEvent(x)}l("keyup",r)}function B(){const r=He(n.default,[]);return o.value===!0&&r.unshift(p("div",{class:"q-focus-helper",tabindex:-1,ref:m})),r}return()=>{const r={ref:f,class:s.value,style:T.value,role:"listitem",onClick:w,onKeyup:H};return o.value===!0?(r.tabindex=e.tabindex||"0",Object.assign(r,a.value)):b.value===!0&&(r["aria-disabled"]="true"),p(h.value,r,B())}}}),Ye={target:{default:!0},noParentEvent:Boolean,contextMenu:Boolean};function Ge({showing:e,avoidEmit:n,configureAnchorEl:l}){const{props:t,proxy:i,emit:d}=O(),a=W(null);let v=null;function h(o){return a.value===null?!1:o===void 0||o.touches===void 0||o.touches.length<=1}const c={};l===void 0&&(Object.assign(c,{hide(o){i.hide(o)},toggle(o){i.toggle(o),o.qAnchorHandled=!0},toggleKey(o){de(o,13)===!0&&c.toggle(o)},contextClick(o){i.hide(o),J(o),Se(()=>{i.show(o),o.qAnchorHandled=!0})},prevent:J,mobileTouch(o){if(c.mobileCleanup(o),h(o)!==!0)return;i.hide(o),a.value.classList.add("non-selectable");const s=o.target;Z(c,"anchor",[[s,"touchmove","mobileCleanup","passive"],[s,"touchend","mobileCleanup","passive"],[s,"touchcancel","mobileCleanup","passive"],[a.value,"contextmenu","prevent","notPassive"]]),v=setTimeout(()=>{v=null,i.show(o),o.qAnchorHandled=!0},300)},mobileCleanup(o){a.value.classList.remove("non-selectable"),v!==null&&(clearTimeout(v),v=null),e.value===!0&&o!==void 0&&Ue()}}),l=function(o=t.contextMenu){if(t.noParentEvent===!0||a.value===null)return;let s;o===!0?i.$q.platform.is.mobile===!0?s=[[a.value,"touchstart","mobileTouch","passive"]]:s=[[a.value,"mousedown","hide","passive"],[a.value,"contextmenu","contextClick","notPassive"]]:s=[[a.value,"click","toggle","passive"],[a.value,"keyup","toggleKey","passive"]],Z(c,"anchor",s)});function f(){We(c,"anchor")}function m(o){for(a.value=o;a.value.classList.contains("q-anchor--skip");)a.value=a.value.parentNode;l()}function b(){if(t.target===!1||t.target===""||i.$el.parentNode===null)a.value=null;else if(t.target===!0)m(i.$el.parentNode);else{let o=t.target;if(typeof t.target=="string")try{o=document.querySelector(t.target)}catch{o=void 0}o!=null?(a.value=o.$el||o,l()):(a.value=null,console.error(`Anchor: target "${t.target}" not found`))}}return M(()=>t.contextMenu,o=>{a.value!==null&&(f(),l(o))}),M(()=>t.target,()=>{a.value!==null&&f(),b()}),M(()=>t.noParentEvent,o=>{a.value!==null&&(o===!0?f():l())}),Me(()=>{b(),n!==!0&&t.modelValue===!0&&a.value===null&&d("update:modelValue",!1)}),j(()=>{v!==null&&clearTimeout(v),f()}),{anchorEl:a,canShow:h,anchorEvents:c}}function Je(e,n){const l=W(null);let t;function i(v,h){const c=`${h!==void 0?"add":"remove"}EventListener`,f=h!==void 0?h:t;v!==window&&v[c]("scroll",f,K.passive),window[c]("scroll",f,K.passive),t=h}function d(){l.value!==null&&(i(l.value),l.value=null)}const a=M(()=>e.noParentEvent,()=>{l.value!==null&&(d(),n())});return j(a),{localScrollTarget:l,unconfigureScrollTarget:d,changeScrollEvent:i}}const{notPassiveCapture:P}=K,C=[];function A(e){const n=e.target;if(n===void 0||n.nodeType===8||n.classList.contains("no-pointer-events")===!0)return;let l=ee.length-1;for(;l>=0;){const t=ee[l].$;if(t.type.name==="QTooltip"){l--;continue}if(t.type.name!=="QDialog")break;if(t.props.seamless!==!0)return;l--}for(let t=C.length-1;t>=0;t--){const i=C[t];if((i.anchorEl.value===null||i.anchorEl.value.contains(n)===!1)&&(n===document.body||i.innerRef.value!==null&&i.innerRef.value.contains(n)===!1))e.qClickOutside=!0,i.onClickOutside(e);else return}}function Ze(e){C.push(e),C.length===1&&(document.addEventListener("mousedown",A,P),document.addEventListener("touchstart",A,P))}function ne(e){const n=C.findIndex(l=>l===e);n!==-1&&(C.splice(n,1),C.length===0&&(document.removeEventListener("mousedown",A,P),document.removeEventListener("touchstart",A,P)))}let le,oe;function ie(e){const n=e.split(" ");return n.length!==2?!1:["top","center","bottom"].includes(n[0])!==!0?(console.error("Anchor/Self position must start with one of top/center/bottom"),!1):["left","middle","right","start","end"].includes(n[1])!==!0?(console.error("Anchor/Self position must end with one of left/middle/right/start/end"),!1):!0}function et(e){return e?!(e.length!==2||typeof e[0]!="number"||typeof e[1]!="number"):!0}const Q={"start#ltr":"left","start#rtl":"right","end#ltr":"right","end#rtl":"left"};["left","middle","right"].forEach(e=>{Q[`${e}#ltr`]=e,Q[`${e}#rtl`]=e});function ae(e,n){const l=e.split(" ");return{vertical:l[0],horizontal:Q[`${l[1]}#${n===!0?"rtl":"ltr"}`]}}function tt(e,n){let{top:l,left:t,right:i,bottom:d,width:a,height:v}=e.getBoundingClientRect();return n!==void 0&&(l-=n[1],t-=n[0],d+=n[1],i+=n[0],a+=n[0],v+=n[1]),{top:l,bottom:d,height:v,left:t,right:i,width:a,middle:t+(i-t)/2,center:l+(d-l)/2}}function nt(e,n,l){let{top:t,left:i}=e.getBoundingClientRect();return t+=n.top,i+=n.left,l!==void 0&&(t+=l[1],i+=l[0]),{top:t,bottom:t+1,height:1,left:i,right:i+1,width:1,middle:i,center:t}}function lt(e,n){return{top:0,center:n/2,bottom:n,left:0,middle:e/2,right:e}}function ue(e,n,l,t){return{top:e[l.vertical]-n[t.vertical],left:e[l.horizontal]-n[t.horizontal]}}function ve(e,n=0){if(e.targetEl===null||e.anchorEl===null||n>5)return;if(e.targetEl.offsetHeight===0||e.targetEl.offsetWidth===0){setTimeout(()=>{ve(e,n+1)},10);return}const{targetEl:l,offset:t,anchorEl:i,anchorOrigin:d,selfOrigin:a,absoluteOffset:v,fit:h,cover:c,maxHeight:f,maxWidth:m}=e;if(Be.is.ios===!0&&window.visualViewport!==void 0){const S=document.body.style,{offsetLeft:y,offsetTop:q}=window.visualViewport;y!==le&&(S.setProperty("--q-pe-left",y+"px"),le=y),q!==oe&&(S.setProperty("--q-pe-top",q+"px"),oe=q)}const{scrollLeft:b,scrollTop:o}=l,s=v===void 0?tt(i,c===!0?[0,0]:t):nt(i,v,t);Object.assign(l.style,{top:0,left:0,minWidth:null,minHeight:null,maxWidth:m||"100vw",maxHeight:f||"100vh",visibility:"visible"});const{offsetWidth:T,offsetHeight:w}=l,{elWidth:H,elHeight:B}=h===!0||c===!0?{elWidth:Math.max(s.width,T),elHeight:c===!0?Math.max(s.height,w):w}:{elWidth:T,elHeight:w};let r={maxWidth:m,maxHeight:f};(h===!0||c===!0)&&(r.minWidth=s.width+"px",c===!0&&(r.minHeight=s.height+"px")),Object.assign(l.style,r);const x=lt(H,B);let g=ue(s,x,d,a);if(v===void 0||t===void 0)_(g,s,x,d,a);else{const{top:S,left:y}=g;_(g,s,x,d,a);let q=!1;if(g.top!==S){q=!0;const E=2*t[1];s.center=s.top-=E,s.bottom-=E+2}if(g.left!==y){q=!0;const E=2*t[0];s.middle=s.left-=E,s.right-=E+2}q===!0&&(g=ue(s,x,d,a),_(g,s,x,d,a))}r={top:g.top+"px",left:g.left+"px"},g.maxHeight!==void 0&&(r.maxHeight=g.maxHeight+"px",s.height>g.maxHeight&&(r.minHeight=r.maxHeight)),g.maxWidth!==void 0&&(r.maxWidth=g.maxWidth+"px",s.width>g.maxWidth&&(r.minWidth=r.maxWidth)),Object.assign(l.style,r),l.scrollTop!==o&&(l.scrollTop=o),l.scrollLeft!==b&&(l.scrollLeft=b)}function _(e,n,l,t,i){const d=l.bottom,a=l.right,v=Le(),h=window.innerHeight-v,c=document.body.clientWidth;if(e.top<0||e.top+d>h)if(i.vertical==="center")e.top=n[t.vertical]>h/2?Math.max(0,h-d):0,e.maxHeight=Math.min(d,h);else if(n[t.vertical]>h/2){const f=Math.min(h,t.vertical==="center"?n.center:t.vertical===i.vertical?n.bottom:n.top);e.maxHeight=Math.min(d,f),e.top=Math.max(0,f-d)}else e.top=Math.max(0,t.vertical==="center"?n.center:t.vertical===i.vertical?n.top:n.bottom),e.maxHeight=Math.min(d,h-e.top);if(e.left<0||e.left+a>c)if(e.maxWidth=Math.min(a,c),i.horizontal==="middle")e.left=n[t.horizontal]>c/2?Math.max(0,c-a):0;else if(n[t.horizontal]>c/2){const f=Math.min(c,t.horizontal==="middle"?n.middle:t.horizontal===i.horizontal?n.right:n.left);e.maxWidth=Math.min(a,f),e.left=Math.max(0,f-e.maxWidth)}else e.left=Math.max(0,t.horizontal==="middle"?n.middle:t.horizontal===i.horizontal?n.left:n.right),e.maxWidth=Math.min(a,c-e.left)}const st=D({name:"QMenu",inheritAttrs:!1,props:{...Ye,...pe,...re,...Pe,persistent:Boolean,autoClose:Boolean,separateClosePopup:Boolean,noRouteDismiss:Boolean,noRefocus:Boolean,noFocus:Boolean,fit:Boolean,cover:Boolean,square:Boolean,anchor:{type:String,validator:ie},self:{type:String,validator:ie},offset:{type:Array,validator:et},scrollTarget:{default:void 0},touchPosition:Boolean,maxHeight:{type:String,default:null},maxWidth:{type:String,default:null}},emits:[...Ae,"click","escapeKey"],setup(e,{slots:n,emit:l,attrs:t}){let i=null,d,a,v;const h=O(),{proxy:c}=h,{$q:f}=c,m=W(null),b=W(!1),o=k(()=>e.persistent!==!0&&e.noRouteDismiss!==!0),s=ce(e,f),{registerTick:T,removeTick:w}=$e(),{registerTimeout:H}=Re(),{transitionProps:B,transitionStyle:r}=ze(e),{localScrollTarget:x,changeScrollEvent:g,unconfigureScrollTarget:S}=Je(e,Y),{anchorEl:y,canShow:q}=Ge({showing:b}),{hide:E}=Fe({showing:b,canShow:q,handleShow:xe,handleHide:ye,hideOnRouteChange:o,processOnMount:!0}),{showPortal:I,hidePortal:V,renderPortal:he}=_e(h,m,qe,"menu"),$={anchorEl:y,innerRef:m,onClickOutside(u){if(e.persistent!==!0&&b.value===!0)return E(u),(u.type==="touchstart"||u.target.classList.contains("q-dialog__backdrop"))&&fe(u),!0}},N=k(()=>ae(e.anchor||(e.cover===!0?"center middle":"bottom start"),f.lang.rtl)),me=k(()=>e.cover===!0?N.value:ae(e.self||"top start",f.lang.rtl)),ge=k(()=>(e.square===!0?" q-menu--square":"")+(s.value===!0?" q-menu--dark q-dark":"")),be=k(()=>e.autoClose===!0?{onClick:ke}:{}),X=k(()=>b.value===!0&&e.persistent!==!0);M(X,u=>{u===!0?(Ve(z),Ze($)):(te(z),ne($))});function R(){Ne(()=>{let u=m.value;u&&u.contains(document.activeElement)!==!0&&(u=u.querySelector("[autofocus][tabindex], [data-autofocus][tabindex]")||u.querySelector("[autofocus] [tabindex], [data-autofocus] [tabindex]")||u.querySelector("[autofocus], [data-autofocus]")||u,u.focus({preventScroll:!0}))})}function xe(u){if(i=e.noRefocus===!1?document.activeElement:null,Ke(G),I(),Y(),d=void 0,u!==void 0&&(e.touchPosition||e.contextMenu)){const F=Qe(u);if(F.left!==void 0){const{top:Ee,left:we}=y.value.getBoundingClientRect();d={left:F.left-we,top:F.top-Ee}}}a===void 0&&(a=M(()=>f.screen.width+"|"+f.screen.height+"|"+e.self+"|"+e.anchor+"|"+f.lang.rtl,L)),e.noFocus!==!0&&document.activeElement.blur(),T(()=>{L(),e.noFocus!==!0&&R()}),H(()=>{f.platform.is.ios===!0&&(v=e.autoClose,m.value.click()),L(),I(!0),l("show",u)},e.transitionDuration)}function ye(u){w(),V(),U(!0),i!==null&&(u===void 0||u.qClickOutside!==!0)&&(((u&&u.type.indexOf("key")===0?i.closest('[tabindex]:not([tabindex^="-"])'):void 0)||i).focus(),i=null),H(()=>{V(!0),l("hide",u)},e.transitionDuration)}function U(u){d=void 0,a!==void 0&&(a(),a=void 0),(u===!0||b.value===!0)&&(De(G),S(),ne($),te(z)),u!==!0&&(i=null)}function Y(){(y.value!==null||e.scrollTarget!==void 0)&&(x.value=Oe(y.value,e.scrollTarget),g(x.value,L))}function ke(u){v!==!0?(je(c,u),l("click",u)):v=!1}function G(u){X.value===!0&&e.noFocus!==!0&&Xe(m.value,u.target)!==!0&&R()}function z(u){l("escapeKey"),E(u)}function L(){ve({targetEl:m.value,offset:e.offset,anchorEl:y.value,anchorOrigin:N.value,selfOrigin:me.value,absoluteOffset:d,fit:e.fit,cover:e.cover,maxHeight:e.maxHeight,maxWidth:e.maxWidth})}function qe(){return p(Ie,B.value,()=>b.value===!0?p("div",{role:"menu",...t,ref:m,tabindex:-1,class:["q-menu q-position-engine scroll"+ge.value,t.class],style:[t.style,r.value],...be.value},se(n.default)):null)}return j(U),Object.assign(c,{focus:R,updatePosition:L}),he}});export{ut as Q,at as a,st as b,et as c,Je as d,Ge as e,Ze as f,ae as p,ne as r,ve as s,Ye as u,ie as v};
