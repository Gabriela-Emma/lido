import{a as r}from"./Modal-1e812f2b.js";import{o as c,c as d,w as i,a as t,m as o}from"./app-c2d50864.js";const n={class:"px-6 py-4"},m={class:"text-lg font-medium text-gray-900 dark:text-gray-100"},x={class:"mt-4 text-sm text-gray-600 dark:text-gray-400"},h={class:"flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-right"},_={__name:"DialogModal",props:{show:{type:Boolean,default:!1},maxWidth:{type:String,default:"2xl"},closeable:{type:Boolean,default:!0}},emits:["close"],setup(e,{emit:a}){const l=()=>{a("close")};return(s,f)=>(c(),d(r,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:l},{default:i(()=>[t("div",n,[t("div",m,[o(s.$slots,"title")]),t("div",x,[o(s.$slots,"content")])]),t("div",h,[o(s.$slots,"footer")])]),_:3},8,["show","max-width","closeable"]))}};export{_};
