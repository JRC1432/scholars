import{c as W}from"./createVueComponent-CH2njvqE.js";import{a as K}from"./QSelect-CbOoRKNU.js";import{B as Q,r as E,F as c,ah as X,N as U,ai as Y,I as h,v as G,aj as H,ak as J,al as Z,am as ee,an as te,ao as ae,ap as le,aq as ne,ar as B,as as ie,at as ue}from"./index-Lhrr584p.js";/**
 * @license @tabler/icons-vue v3.2.0 - MIT
 *
 * This source code is licensed under the MIT license.
 * See the LICENSE file in the root directory of this source tree.
 */var ve=W("outline","file-type-csv","IconFileTypeCsv",[["path",{d:"M14 3v4a1 1 0 0 0 1 1h4",key:"svg-0"}],["path",{d:"M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4",key:"svg-1"}],["path",{d:"M7 16.5a1.5 1.5 0 0 0 -3 0v3a1.5 1.5 0 0 0 3 0",key:"svg-2"}],["path",{d:"M10 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75",key:"svg-3"}],["path",{d:"M16 15l2 6l2 -6",key:"svg-4"}]]);function b(e,f,x,F){const u=[];return e.forEach(s=>{F(s)===!0?u.push(s):f.push({failedPropValidation:x,file:s})}),u}function A(e){e&&e.dataTransfer&&(e.dataTransfer.dropEffect="copy"),U(e)}const re={multiple:Boolean,accept:String,capture:String,maxFileSize:[Number,String],maxTotalSize:[Number,String],maxFiles:[Number,String],filter:Function},se=["rejected"];function oe({editable:e,dnd:f,getFileInput:x,addFilesToQueue:F}){const{props:u,emit:s,proxy:p}=Q(),y=E(null),z=c(()=>u.accept!==void 0?u.accept.split(",").map(t=>(t=t.trim(),t==="*"?"*/":(t.endsWith("/*")&&(t=t.slice(0,t.length-1)),t.toUpperCase()))):null),V=c(()=>parseInt(u.maxFiles,10)),k=c(()=>parseInt(u.maxTotalSize,10));function j(t){if(e.value)if(t!==Object(t)&&(t={target:null}),t.target!==null&&t.target.matches('input[type="file"]')===!0)t.clientX===0&&t.clientY===0&&X(t);else{const v=x();v&&v!==t.target&&v.click(t)}}function I(t){e.value&&t&&F(null,t)}function D(t,v,S,C){let l=Array.from(v||t.target.files);const d=[],g=()=>{d.length!==0&&s("rejected",d)};if(u.accept!==void 0&&z.value.indexOf("*/")===-1&&(l=b(l,d,"accept",n=>z.value.some(r=>n.type.toUpperCase().startsWith(r)||n.name.toUpperCase().endsWith(r))),l.length===0))return g();if(u.maxFileSize!==void 0){const n=parseInt(u.maxFileSize,10);if(l=b(l,d,"max-file-size",r=>r.size<=n),l.length===0)return g()}if(u.multiple!==!0&&l.length!==0&&(l=[l[0]]),l.forEach(n=>{n.__key=n.webkitRelativePath+n.lastModified+n.name+n.size}),C===!0){const n=S.map(r=>r.__key);l=b(l,d,"duplicate",r=>n.includes(r.__key)===!1)}if(l.length===0)return g();if(u.maxTotalSize!==void 0){let n=C===!0?S.reduce((r,O)=>r+O.size,0):0;if(l=b(l,d,"max-total-size",r=>(n+=r.size,n<=k.value)),l.length===0)return g()}if(typeof u.filter=="function"){const n=u.filter(l);l=b(l,d,"filter",r=>n.includes(r))}if(u.maxFiles!==void 0){let n=C===!0?S.length:0;if(l=b(l,d,"max-files",()=>(n++,n<=V.value)),l.length===0)return g()}if(g(),l.length!==0)return l}function P(t){A(t),f.value!==!0&&(f.value=!0)}function i(t){U(t),(t.relatedTarget!==null||Y.is.safari!==!0?t.relatedTarget!==y.value:document.elementsFromPoint(t.clientX,t.clientY).includes(y.value)===!1)===!0&&(f.value=!1)}function N(t){A(t);const v=t.dataTransfer.files;v.length!==0&&F(null,v),f.value=!1}function T(t){if(f.value===!0)return h("div",{ref:y,class:`q-${t}__dnd absolute-full`,onDragenter:A,onDragover:A,onDragleave:i,onDrop:N})}return Object.assign(p,{pickFiles:j,addFiles:I}),{pickFiles:j,addFiles:I,onDragover:P,onDragleave:i,processFiles:D,getDndNode:T,maxFilesNumber:V,maxTotalSizeNumber:k}}const me=G({name:"QFile",inheritAttrs:!1,props:{...H,...J,...re,modelValue:[File,FileList,Array],append:Boolean,useChips:Boolean,displayValue:[String,Number],tabindex:{type:[String,Number],default:0},counterLabel:Function,inputClass:[Array,String,Object],inputStyle:[Array,String,Object]},emits:[...Z,...se],setup(e,{slots:f,emit:x,attrs:F}){const{proxy:u}=Q(),s=ee(),p=E(null),y=E(!1),z=te(e),{pickFiles:V,onDragover:k,onDragleave:j,processFiles:I,getDndNode:D}=oe({editable:s.editable,dnd:y,getFileInput:M,addFilesToQueue:R}),P=ae(e),i=c(()=>Object(e.modelValue)===e.modelValue?"length"in e.modelValue?Array.from(e.modelValue):[e.modelValue]:[]),N=c(()=>B(i.value)),T=c(()=>i.value.map(a=>a.name).join(", ")),t=c(()=>ie(i.value.reduce((a,o)=>a+o.size,0))),v=c(()=>({totalSize:t.value,filesNumber:i.value.length,maxFiles:e.maxFiles})),S=c(()=>({tabindex:-1,type:"file",title:"",accept:e.accept,capture:e.capture,name:z.value,...F,id:s.targetUid.value,disabled:s.editable.value!==!0})),C=c(()=>"q-file q-field--auto-height"+(y.value===!0?" q-file--dnd":"")),l=c(()=>e.multiple===!0&&e.append===!0);function d(a){const o=i.value.slice();o.splice(a,1),n(o)}function g(a){const o=i.value.indexOf(a);o!==-1&&d(o)}function n(a){x("update:modelValue",e.multiple===!0?a:a[0])}function r(a){a.keyCode===13&&ue(a)}function O(a){(a.keyCode===13||a.keyCode===32)&&V(a)}function M(){return p.value}function R(a,o){const m=I(a,o,i.value,l.value),q=M();q!=null&&(q.value=""),m!==void 0&&((e.multiple===!0?e.modelValue&&m.every(L=>i.value.includes(L)):e.modelValue===m[0])||n(l.value===!0?i.value.concat(m):m))}function _(){return[h("input",{class:[e.inputClass,"q-file__filler"],style:e.inputStyle})]}function $(){if(f.file!==void 0)return i.value.length===0?_():i.value.map((o,m)=>f.file({index:m,file:o,ref:this}));if(f.selected!==void 0)return i.value.length===0?_():f.selected({files:i.value,ref:this});if(e.useChips===!0)return i.value.length===0?_():i.value.map((o,m)=>h(K,{key:"file-"+m,removable:s.editable.value,dense:!0,textColor:e.color,tabindex:e.tabindex,onRemove:()=>{d(m)}},()=>h("span",{class:"ellipsis",textContent:o.name})));const a=e.displayValue!==void 0?e.displayValue:T.value;return a.length!==0?[h("div",{class:e.inputClass,style:e.inputStyle,textContent:a})]:_()}function w(){const a={ref:p,...S.value,...P.value,class:"q-field__input fit absolute-full cursor-pointer",onChange:R};return e.multiple===!0&&(a.multiple=!0),h("input",a)}return Object.assign(s,{fieldClass:C,emitValue:n,hasValue:N,inputRef:p,innerValue:i,floatingLabel:c(()=>N.value===!0||B(e.displayValue)),computedCounter:c(()=>{if(e.counterLabel!==void 0)return e.counterLabel(v.value);const a=e.maxFiles;return`${i.value.length}${a!==void 0?" / "+a:""} (${t.value})`}),getControlChild:()=>D("file"),getControl:()=>{const a={ref:s.targetRef,class:"q-field__native row items-center cursor-pointer",tabindex:e.tabindex};return s.editable.value===!0&&Object.assign(a,{onDragover:k,onDragleave:j,onKeydown:r,onKeyup:O}),h("div",a,[w()].concat($()))}}),Object.assign(u,{removeAtIndex:d,removeFile:g,getNativeElement:()=>p.value}),le(u,"nativeEl",()=>p.value),ne(s)}});export{ve as I,me as Q};
