// colormath.js
// code extracted from www.colormatch.dk
var hs=new Object();
var rg=new Object();
rg.r=rg.g=rg.b=0;

function setc(c) {
f=document.calculator;
color=eval("f.t"+c).value;
f.tPrim.value=color;
calculate(f);
}
function init() {
calculate(document.forms["calculator"]);
}
function html2rg(html) {
// pass it a html color string like '#001122'
rg.r = parseInt ( html.substring (1,3),16);
rg.g = parseInt ( html.substring (3,5),16);
rg.b = parseInt ( html.substring (5,7),16);
// alert("r:"+rg.r+" g:)"+rg.g+" b:"+rg.b)
}
function update(whichPos, rg) {
f=document.calculator
// alert("setting "+whichPos+" to "+rg2html(rg))
eval("f.t"+whichPos).value=rg2html(rg);
elem = eval("document.getElementById('c"+whichPos+"')");
if(elem) { elem.style.backgroundColor=rg2html(rg); }
else { alert(whichPos); }
}
function calculate(f){
prim = f.tPrim.value;
html2rg(prim);
rg2hs(rg);
update("1", rg);
z=new Object();
y=new Object();
yx=new Object();
y.s=hs.s;
y.h=hs.h;
if(hs.v>70){ y.v=hs.v-30 }
else{ y.v=hs.v+30 };
z=h2r(y);
update("2",z);
if((hs.h>=0)&&(hs.h<30)){
yx.h=y.h=hs.h+20;
yx.s=y.s=hs.s;
y.v=hs.v;
if(hs.v>70){ yx.v=hs.v-30 }
else{ yx.v=hs.v+30 }
}
if((hs.h>=30)&&(hs.h<60)){
yx.h=y.h=hs.h+150;
y.s=rc(hs.s-30,100);
y.v=rc(hs.v-20,100);
yx.s=rc(hs.s-70,100);
yx.v=rc(hs.v+20,100);
}
if((hs.h>=60)&&(hs.h<180)){
yx.h=y.h=hs.h-40;
y.s=yx.s=hs.s;
y.v=hs.v;
if(hs.v>70){ yx.v=hs.v-30 }
else{ yx.v=hs.v+30 }
}
if((hs.h>=180)&&(hs.h<220)){
yx.h=hs.h-170;
y.h=hs.h-160;
yx.s=y.s=hs.s;
y.v=hs.v;
if(hs.v>70){ yx.v=hs.v-30 }
else{ yx.v=hs.v+30 }
}
if((hs.h>=220)&&(hs.h<300)){
yx.h=y.h=hs.h;
yx.s=y.s=rc(hs.s-60,100);
y.v=hs.v;
if(hs.v>70){ yx.v=hs.v-30 }
else{ yx.v=hs.v+30 }
}
if(hs.h>=300){
if(hs.s>50){ y.s=yx.s=hs.s-40 }
else { y.s=yx.s=hs.s+40 }
yx.h=y.h=(hs.h+20)%360;
y.v=hs.v;
if(hs.v>70){ yx.v=hs.v-30 }
else{ yx.v=hs.v+30 }
}
z=h2r(y);
update("3",z);
z=h2r(yx);
update("4",z);
y.h=0;
y.s=0;
y.v=100-hs.v;
z=h2r(y);
update("5",z);
y.h=0;
y.s=0;
y.v=hs.v;
z=h2r(y);
update("6",z);
}
function rc(x,m){
if(x>m){ return m }
if(x<0){ return 0 }
else{ return x}
}
function rg2hs(rg){
m=rg.r;
if(rg.g<m){ m=rg.g };
if(rg.b<m){ m=rg.b };
v=rg.r;
if(rg.g>v){ v=rg.g };
if(rg.b>v){ v=rg.b };
value=100*v/255;
delta=v-m;
if(v==0.0){ hs.s=0 }
else{ hs.s=100*delta/v };
if(hs.s==0){ hs.h=0 }
else{
if(rg.r==v){ hs.h=60.0*(rg.g-rg.b)/delta }
else if(rg.g==v){ hs.h=120.0+60.0*(rg.b-rg.r)/delta }
else if(rg.b=v){ hs.h=240.0+60.0*(rg.r-rg.g)/delta }
if(hs.h<0.0){ hs.h=hs.h+360.0 }
}
hs.v=Math.round(value);
hs.h=Math.round(hs.h);
hs.s=Math.round(hs.s);
return(true);
}
function rg2html(z){
return "#"+d2h(z.r)+d2h(z.g)+d2h(z.b);
}
function d2h(d){
hch="0123456789ABCDEF";
a=d%16;
b=(d-a)/16;
return hch.charAt(b)+hch.charAt(a);
}
function c2r(d){
k=window.event.srcElement.style.backgroundColor;
j=(k.substr(4,k.indexOf(")")-4)).split(",");
click(parseInt(j[0])+10,"r");
click(parseInt(j[1])+10,"g");
click(parseInt(j[2])+10,"b");
}
function h2r(hs){
var rg=new Object();
if(hs.s==0){
rg.r=rg.g=rg.b=Math.round(hs.v*2.55);
return rg;
}
hs.s=hs.s/100;
hs.v=hs.v/100;
hs.h/=60;
i=Math.floor(hs.h);
f=hs.h-i;
p=hs.v*(1-hs.s);
q=hs.v*(1-hs.s*f);
t=hs.v*(1-hs.s*(1-f));
switch(i){
case 0:
rg.r=hs.v;
rg.g=t;
rg.b=p;
break;
case 1:
rg.r=q;
rg.g=hs.v;
rg.b=p;
break;
case 2:
rg.r=p;
rg.g=hs.v;
rg.b=t;
break;
case 3:
rg.r=p;
rg.g=q;
rg.b=hs.v;
break;
case 4:
rg.r=t;
rg.g=p;
rg.b=hs.v;
break;
default:
rg.r=hs.v;
rg.g=p;
rg.b=q;
}
rg.r=Math.round(rg.r*255);
rg.g=Math.round(rg.g*255);
rg.b=Math.round(rg.b*255);
return rg;
}