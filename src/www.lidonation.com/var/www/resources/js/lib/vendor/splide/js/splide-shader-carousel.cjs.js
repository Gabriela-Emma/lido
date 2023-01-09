"use strict";var _=Object.defineProperty;var V=(i,e,t)=>e in i?_(i,e,{enumerable:!0,configurable:!0,writable:!0,value:t}):i[e]=t;var o=(i,e,t)=>(V(i,typeof e!="symbol"?e+"":e,t),t);Object.defineProperties(exports,{__esModule:{value:!0},[Symbol.toStringTag]:{value:"Module"}});const l=require("@splidejs/splide"),v=require("three"),M=i=>i&&typeof i=="object"&&"default"in i?i:{default:i},O=M(l),b=`varying vec2 vUv;\r
uniform float fTime;\r
\r
void main() {\r
  vUv = uv;\r
  gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);\r
}`;class k{constructor(e,t){o(this,"canvas");o(this,"renderer");o(this,"mesh");o(this,"camera");o(this,"scene",new v.Scene);o(this,"geometry",new v.PlaneGeometry(1,1));this.renderer=this.createRenderer(e),this.canvas=e,this.camera=this.createCamera(),this.mesh=new v.Mesh(this.geometry,t),this.scene.add(this.mesh)}decode(e){e.forEach(t=>{this.renderer.initTexture(t)})}render(){this.renderer.render(this.scene,this.camera)}setSize(e,t){const r=e/t||1,[n,a]=this.computeViewDimension(r);this.mesh.scale.set(n,a,1),this.renderer.setSize(e,t),this.camera.aspect=r,this.camera.updateProjectionMatrix()}createRenderer(e){const t=new v.WebGLRenderer({canvas:e});return t.setPixelRatio(window.devicePixelRatio),t}createCamera(){const e=new v.PerspectiveCamera(45,1,1,1e4);return e.position.z=50,e}computeViewDimension(e){const{camera:t}=this,r=t.fov*Math.PI/180,n=Math.abs(t.position.z*Math.tan(r/2)*2);return[n*e,n]}}class z{constructor(e,t,r=[],n){o(this,"material");o(this,"textures",[]);o(this,"uniforms",{tTexture:{value:null},tNextTexture:{value:null},tMask:{value:null},fIntensity:{value:.5},fProgress:{value:0},vUVOffset:{value:new v.Vector2(1,1)},vRatio:{value:new v.Vector2(1,1)},vNextRatio:{value:new v.Vector2(1,1)}});o(this,"sources");o(this,"mask");o(this,"index",0);o(this,"nextIndex",0);this.material=new v.ShaderMaterial({vertexShader:e,fragmentShader:t,uniforms:this.uniforms}),this.sources=r,this.mask=n}destroy(){this.sources.length=0}add(e){this.sources.push(...e)}load(){return this.loadMask().then(()=>this.loadSources().then(e=>(this.textures.push(...e.map(t=>({texture:t,ratio:new v.Vector2(1,1)}))),this.uniforms.tTexture.value=e[0]||null,e)))}setSize(e,t){this.textures.forEach((r,n)=>{const a=e/t||1,[h,c]=this.getTextureDimension(r.texture);r.ratio=new v.Vector2(Math.min(a/(h/c),1),Math.min(1/a/(c/h),1)),n===this.index&&(this.uniforms.vRatio.value=r.ratio),n===this.nextIndex&&(this.uniforms.vNextRatio.value=r.ratio)})}setIndex(e,t){const{textures:r,index:n}=this;0<=e&&e<r.length&&n!==e&&(t===void 0&&n>e||t?(this.setProgress(1),this.setTexture(e,n),this.nextIndex=n):(this.setProgress(0),this.setTexture(n,e),this.nextIndex=e),this.index=e)}getIndex(){return this.index}setTexture(e,t){const r=this.textures[e],n=this.textures[t];if(r&&n){const{uniforms:a}=this;a.tTexture.value=r.texture,a.vRatio.value=r.ratio,a.tNextTexture.value=n.texture,a.vNextRatio.value=n.ratio}}setProgress(e){this.uniforms.fProgress.value=e}setParams(e){const{intensity:t=.5,uvOffset:r=[1,1]}=e;this.uniforms.fIntensity.value=t,this.uniforms.vUVOffset.value=r}getLength(){return this.textures.length}loadSources(){return Promise.all(this.sources.map(e=>e instanceof HTMLVideoElement?this.loadVideo(e):new v.TextureLoader().loadAsync(e instanceof HTMLImageElement?e.src:e).then(t=>(t.needsUpdate=!0,t))))}loadVideo(e){return new Promise(t=>{const r=new v.VideoTexture(e);r.needsUpdate=!0,e.readyState>=2?t(r):e.addEventListener("canplay",function n(){t(r),e.removeEventListener("canplay",n)})})}loadMask(){return this.mask?new v.TextureLoader().loadAsync(this.mask).then(e=>{this.uniforms.tMask.value=e}):Promise.resolve()}getTextureDimension(e){const{image:t}=e;return t instanceof HTMLVideoElement?[t.videoWidth,t.videoHeight]:[t.width,t.height]}}const U={awaitInit:!0};function R(i,e,t){return Math.max(Math.min(i,t),e)}class H{constructor(e,t,r={}){o(this,"canvas");o(this,"renderer");o(this,"material");o(this,"event");o(this,"options");o(this,"interval");this.canvas=e,this.options=Object.assign({},U,r),this.event=l.EventInterface(),this.material=new z(r.vertexShader||b,t,r.sources,r.mask),this.renderer=new k(e,this.material.material)}mount(e,t){e&&this.material.add(e);const{preDecoding:r}=this.options;this.material.load().then(()=>{this.resize(),r==="load"&&this.decode(),r==="nearby"&&this.decodeAround(),t&&t()}).catch(console.error),this.resize(),this.listen()}mountAsync(e){return new Promise(t=>{this.mount(e,t)})}destroy(){this.event.destroy(),this.material.destroy()}go(e,t){const r=t===void 0,n=this.material.getIndex();e=R(e,0,this.getLength()-1),e!==n&&(this.material.setIndex(e,t),this.transition(r&&n>e||!!t))}resize(){const e=this.getWidth(),t=this.getHeight();e&&t&&(this.renderer.setSize(e,t),this.material.setSize(e,t)),this.render()}setProgress(e){this.material.setProgress(R(e,0,1))}getWidth(){var e;return((e=this.canvas.parentElement)==null?void 0:e.clientWidth)||0}getHeight(){var e;return((e=this.canvas.parentElement)==null?void 0:e.clientHeight)||0}getLength(){return this.material.getLength()}decode(){this.renderer.decode(this.material.textures.map(e=>e.texture))}decodeAround(){const{material:e}=this,t=e.getLength();if(t){const{textures:r}=this.material,n=e.getIndex(),a=(n+1)%t,h=(n-1+t)%t;this.renderer.decode([r[a].texture,r[h].texture])}}render(){this.renderer.render()}listen(){this.event.bind(window,"resize",l.Throttle(()=>{this.resize(),this.render()}))}transition(e){this.interval&&this.interval.cancel();const{speed:t=1e3}=this.options;this.interval=l.RequestInterval(t,this.onTransitionEnd.bind(this),this.onProgress.bind(this,e),1),this.interval.start()}onProgress(e,t){const{easingFunc:r=n=>1-Math.pow(1-n,4)}=this.options;t=r(t),this.setProgress(e?1-t:t),this.render()}onTransitionEnd(){this.interval=void 0,this.options.preDecoding==="nearby"&&this.decodeAround()}}const F="shaderCarousel:initialized",E="shaderCarousel:ready",g="shaderCarousel:error";function j(i,e,t){const{on:r,emit:n}=l.EventInterface(i),{track:a}=e.Elements,h=document.createElement("canvas");let c;const d=[],T=[],p=[];function y(){w(),C(),L(),N(),I()}function I(){if(d.length>1){const{classList:s}=i.root;s.add(l.CLASS_LOADING),c==null||c.mountAsync(d).then(()=>{h.style.visibility="visible",s.add(l.CLASS_INITIALIZED),s.remove(l.CLASS_LOADING),n(E)}).catch(u=>{throw n(g),new Error(u)}),D()}else console.error("Requires at least 2 images."),n(g)}function D(){r("move",(s,u)=>{const{length:f}=i;let m;(t.continuous||i.is(l.LOOP))&&(u===f-1&&s===0?m=!1:u===0&&s===f-1&&(m=!0)),c==null||c.go(s,m)})}function P(){a.removeChild(h),p.forEach(s=>{var u;(u=s.parentElement)==null||u.removeChild(s)}),T.forEach(s=>{s.style.display=""}),d.length=0,p.length=0,T.length=0,c==null||c.destroy(),c=void 0}function w(){const{style:s}=h;s.position="absolute",s.zIndex="-1",s.top="0",s.left="0",s.visibility="hidden",a.appendChild(h)}function C(){c=new H(h,i.fragmentShader,{speed:t.speed,mask:t.mask,easingFunc:t.easingFunc||U.easingFunc,preDecoding:t.preDecoding,vertexShader:t.vertexShader})}function L(){const{sources:s}=t;s&&s.length?d.push(...s):e.Slides.forEach(A)}function A(s){var f;const u=s.slide.querySelector("img");if(u){const{alt:m}=u;if(m&&t.keepAlt){const x=document.createElement("span");x.textContent=m,x.classList.add(l.CLASS_SR),(f=u.parentElement)==null||f.insertBefore(x,u),p.push(x)}s.isClone||(d.push(u.src),T.push(u)),u.style.display="none"}}function N(){const{material:s}=t;s&&(c==null||c.material.setParams({intensity:s.intensity,uvOffset:s.uvOffset}))}return{mount:y,destroy:P}}class S extends O.default{constructor(t,r,n){super(t,Object.assign({},U,n));o(this,"fragmentShader");this.fragmentShader=r}static isAvailable(){try{const t=document.createElement("canvas"),r=t.getContext("webgl")||t.getContext("experimental-webgl");return!!(WebGLRenderingContext&&r)}catch{return!1}}mount(t={}){return super.mount(Object.assign(t,{BackgroundShaderCarousel:j})),this.options.awaitInit&&this.root.classList.remove(l.CLASS_INITIALIZED),this}mountAsync(t){return new Promise((r,n)=>{this.mount(t);const{on:a}=l.EventInterface(this);a(E,r),a(g,n)})}}const W=`varying vec2 vUv;\r
uniform sampler2D tTexture;\r
uniform sampler2D tNextTexture;\r
uniform float fProgress;\r
uniform float fIntensity;\r
uniform vec2 vRatio;\r
uniform vec2 vNextRatio;\r
uniform vec2 vUVOffset;\r
\r
vec2 mirrorUV(vec2 uv) {\r
  vec2 vec = mod(uv, 2.0);\r
  return mix(vec, 2.0 - vec, step(1.0, vec));\r
}\r
\r
float normalizeTexture(vec4 texture) {\r
  float fMax = length(vec4(1.0));\r
  return length(texture) / fMax;\r
}\r
\r
void main() {\r
  vec2 currUv = vUv * vRatio + (1.0 - vRatio) * 0.5;\r
  vec2 nextUv = vUv * vNextRatio + (1.0 - vNextRatio) * 0.5;\r
\r
  vec4 currTexture = texture2D(tTexture, currUv);\r
  vec4 nextTexture = texture2D(tNextTexture, nextUv);\r
\r
  vec2 currTranslatedUv = currUv + fProgress * normalizeTexture(nextTexture) * fIntensity * vUVOffset;\r
  vec2 nextTranslatedUv = nextUv + (1.0 - fProgress) * normalizeTexture(nextTexture) * fIntensity * vUVOffset;\r
\r
  vec4 currColor = texture2D(tTexture, mirrorUV(currTranslatedUv));\r
  vec4 nextColor = texture2D(tNextTexture, mirrorUV(nextTranslatedUv));\r
\r
  gl_FragColor = mix(currColor, nextColor, fProgress);\r
}`,q=`varying vec2 vUv;\r
uniform sampler2D tTexture;\r
uniform sampler2D tNextTexture;\r
uniform sampler2D tMask;\r
uniform float fProgress;\r
uniform float fIntensity;\r
uniform vec2 vRatio;\r
uniform vec2 vNextRatio;\r
uniform vec2 vUVOffset;\r
\r
vec2 mirror(vec2 uv) {\r
  vec2 vec = mod(uv, 2.0);\r
  return mix(vec, 2.0 - vec, step(1.0, vec));\r
}\r
\r
void main() {\r
  vec2 currUv = vUv * vRatio + (1.0 - vRatio) * 0.5;\r
  vec2 nextUv = vUv * vNextRatio + (1.0 - vNextRatio) * 0.5;\r
\r
  vec4 curr = texture2D(tTexture, currUv);\r
  vec4 next = texture2D(tNextTexture, nextUv);\r
  vec4 mask = texture2D(tMask, vUv);\r
\r
  vec2 currTranslatedUv = currUv + mask.xy * fProgress * fIntensity * vUVOffset;\r
  vec2 nextTranslatedUv = nextUv - mask.xy * (1.0 - fProgress) * fIntensity * vUVOffset;\r
\r
  vec4 currColor = texture2D(tTexture, mirror(currTranslatedUv));\r
  vec4 nextColor = texture2D(tNextTexture, mirror(nextTranslatedUv));\r
\r
  gl_FragColor = mix(currColor, nextColor, fProgress);\r
}`,G=`varying vec2 vUv;\r
uniform sampler2D tTexture;\r
uniform sampler2D tNextTexture;\r
uniform float fProgress;\r
uniform vec2 vRatio;\r
uniform vec2 vNextRatio;\r
\r
const float PI  = 3.141592653589793;\r
\r
vec2 mirror(vec2 uv) {\r
  vec2 vec = mod(uv, 2.0);\r
  return mix(vec, 2.0 - vec, step(1.0, vec));\r
}\r
\r
void main() {\r
  vec2 currUv = vUv * vRatio + (1.0 - vRatio) * 0.5;\r
  vec2 nextUv = vUv * vNextRatio + (1.0 - vNextRatio) * 0.5;\r
\r
  float progress = fProgress * 6.0 + (pow(currUv.x, 4.0) - 1.0) - currUv.y * 4.0;\r
  progress = clamp(progress, 0.0, 1.0);\r
\r
  //  vec2 offset = vec2( 0.2, sin( currUv.x * PI * 2.0 ) * 0.2 - sin( currUv.y * PI * 2.0 ) * 0.3 - fProgress );\r
  vec2 offset = vec2(- 0.2, 1.5 - sin(currUv.x * 2.0));\r
  vec2 currTranslatedUv = currUv + vec2(-0.5, 1.0) * progress + offset * fProgress;\r
  vec2 nextTranslatedUv = nextUv + vec2(-0.5, 1.0) * (1.0 - progress) + offset * (1.0 - fProgress);\r
\r
  vec4 currColor = texture2D(tTexture, mirror(currTranslatedUv));\r
  vec4 nextColor = texture2D(tNextTexture, mirror(nextTranslatedUv));\r
\r
  gl_FragColor = mix(currColor, nextColor, progress);\r
}`;exports.EVENT_SHADER_CAROUSEL_ERROR=g;exports.EVENT_SHADER_CAROUSEL_INITIALIZED=F;exports.EVENT_SHADER_CAROUSEL_READY=E;exports.SplideShaderCarousel=S;exports.default=S;exports.dissolveShader=W;exports.maskShader=q;exports.wipeShader=G;
