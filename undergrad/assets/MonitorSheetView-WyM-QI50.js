import{S as _,a3 as v,aE as k,r,aa as C,$ as T,b as S,o as N,c as E,e,a as s,w as o,a8 as b,ad as I,a5 as q,u as U,l as m,a9 as x,aF as A,M as B,af as h,g as d,f as F,k as M,n as D,ag as $,ab as j}from"./index-Lhrr584p.js";import{Q as z}from"./QSelect-CbOoRKNU.js";import{C as O}from"./ClosePopup-B8isQGvy.js";import{_ as P}from"./ScInfo-LJxXJbwl.js";import{I as Y}from"./IconTool-C8NaaGe4.js";import"./sweetalert2.all-Ced_kw8w.js";import"./QMenu-kJOoyUX5.js";import"./selection-Dtef2Nxx.js";import"./QItemLabel-DH87CdX2.js";import"./QBreadcrumbs-Bw8Un86e.js";import"./createVueComponent-CH2njvqE.js";const G={class:"q-pa-lg"},H={class:"q-pa-md text-center text-bold primary-text text-h4"},J=s("span",{class:"text-weight-bold",color:"primary"},"Add",-1),K={class:"q-px-sm"},L=s("span",{class:"text-bold"},"Term Record:",-1),W={class:"q-px-sm"},ie={__name:"MonitorSheetView",setup(X){_("$user"),v(),v();const R=_("$axios"),w=k(),y=a=>a==null||a===""?"You must make a selection!":!0,u=r(!1),p=r(),n=r("NO"),g=r(null),i=C({termRec:""});T(()=>{Q()});const c=r(),Q=()=>{c.value=w.params.id;var a=new FormData;a.append("id",c.value),R.post("/read.php?readTermRec",a).then(t=>{p.value=t.data})},f=()=>{u.value=!0};return(a,t)=>{const V=S("IconClipboardText");return N(),E(q,null,[e(P),s("div",G,[e(b,{flat:"",class:"my-card surface-container rounded-borders-20"},{default:o(()=>[s("div",H,[e(U(Y),{size:30,"stroke-width":"2"}),m(" Monitoring Sheet ")]),e(x,null,{default:o(()=>[e(A,{"inline-actions":"",class:"tertiary-container rounded-borders-10"},{avatar:o(()=>[e(B,{name:"error",color:"primary"})]),default:o(()=>[m(" No Records Found ")]),_:1})]),_:1}),e(h,{class:"row fit justify-start q-pt-xs"},{default:o(()=>[e(d,{rounded:"",outline:"",label:"Add Enrollment Info",style:{color:"goldenrod"},onClick:f})]),_:1})]),_:1})]),e(I,{modelValue:u.value,"onUpdate:modelValue":t[3]||(t[3]=l=>u.value=l),persistent:""},{default:o(()=>[e(b,{style:{"min-width":"500px",width:"500px"},class:"rounded-borders-20"},{default:o(()=>[s("form",{id:"UpReplyForm",onSubmit:t[2]||(t[2]=j((...l)=>a.UpdateReplyNow&&a.UpdateReplyNow(...l),["prevent","stop"]))},[e(F,null,{default:o(()=>[e(V,{size:30,"stroke-width":"2"}),e(M,null,{default:o(()=>[J,m(" Enrollment Info ")]),_:1}),D(e(d,{flat:"",round:"",dense:"",icon:"close"},null,512),[[O]])]),_:1}),e(x,null,{default:o(()=>[s("div",K,[L,e(z,{ref_key:"reftermRec",ref:g,options:p.value,modelValue:i.termRec,"onUpdate:modelValue":t[0]||(t[0]=l=>i.termRec=l),"emit-value":"",name:"termRec",outlined:"",dense:"","hide-bottom-space":"",rules:[y]},null,8,["options","modelValue","rules"])]),s("div",W,[e($,{label:n.value,modelValue:n.value,"onUpdate:modelValue":t[1]||(t[1]=l=>n.value=l),"checked-icon":"check",color:"green","unchecked-icon":"clear","false-value":"NO","true-value":"YES",name:"curriculum"},null,8,["label","modelValue"])])]),_:1}),e(h,{class:"row fit justify-center q-pt-xs"},{default:o(()=>[e(d,{outline:"",label:"Continue",style:{color:"goldenrod"},to:"/enrollmentinfo/"+c.value+i.termRec+n.value},null,8,["to"]),e(d,{outline:"",label:"Reset",style:{color:"goldenrod"},onClick:f})]),_:1})],32)]),_:1})]),_:1},8,["modelValue"])],64)}}};export{ie as default};
