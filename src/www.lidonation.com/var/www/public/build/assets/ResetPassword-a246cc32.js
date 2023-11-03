import{T as c,o as f,d as w,b as o,u as e,w as l,F as _,Z as g,a as r,n as V,f as b,h as k}from"./app-c2d50864.js";import{A as v}from"./AuthenticationCard-6565b307.js";import{_ as x}from"./AuthenticationCardLogo-18f460c8.js";import{_ as m,a as i}from"./TextInput-89141df7.js";import{_ as n}from"./InputLabel-adbf3b92.js";import{_ as y}from"./PrimaryButton-c8cac642.js";import"./_plugin-vue_export-helper-c27b6911.js";const P=["onSubmit"],$={class:"mt-4"},h={class:"mt-4"},C={class:"flex items-center justify-end mt-4"},E={__name:"ResetPassword",props:{email:String,token:String},setup(p){const d=p,s=c({token:d.token,email:d.email,password:"",password_confirmation:""}),u=()=>{s.post(route("password.update"),{onFinish:()=>s.reset("password","password_confirmation")})};return(S,a)=>(f(),w(_,null,[o(e(g),{title:"Reset Password"}),o(v,null,{logo:l(()=>[o(x)]),default:l(()=>[r("form",{onSubmit:k(u,["prevent"])},[r("div",null,[o(n,{for:"email",value:"Email"}),o(m,{id:"email",modelValue:e(s).email,"onUpdate:modelValue":a[0]||(a[0]=t=>e(s).email=t),type:"email",class:"mt-1 block w-full",required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.email},null,8,["message"])]),r("div",$,[o(n,{for:"password",value:"Password"}),o(m,{id:"password",modelValue:e(s).password,"onUpdate:modelValue":a[1]||(a[1]=t=>e(s).password=t),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password},null,8,["message"])]),r("div",h,[o(n,{for:"password_confirmation",value:"Confirm Password"}),o(m,{id:"password_confirmation",modelValue:e(s).password_confirmation,"onUpdate:modelValue":a[2]||(a[2]=t=>e(s).password_confirmation=t),type:"password",class:"mt-1 block w-full",required:"",autocomplete:"new-password"},null,8,["modelValue"]),o(i,{class:"mt-2",message:e(s).errors.password_confirmation},null,8,["message"])]),r("div",C,[o(y,{class:V({"opacity-25":e(s).processing}),disabled:e(s).processing},{default:l(()=>[b(" Reset Password ")]),_:1},8,["class","disabled"])])],40,P)]),_:1})],64))}};export{E as default};
