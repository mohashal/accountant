/*فنكشن مودال لجميع الموقع*/
function mymodalbox(header,text,type){//0=normal text ,type => 1=iframe ,2=load from page
if(type==1){text="<iframe src='"+text+"'></iframe>";}
if(type==3){text="<img src='"+text+"' style='width:100%;height:100%;'/>";}

var js='<script id="modal_script">var modal = document.getElementById("myModal");\
var span = document.getElementsByClassName("close")[0];\
\
span.onclick = function() {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
window.onclick = function(event) {\
if (event.target == modal) {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
};</script>';

var modal='<div id="myModal" class="modal">\
<div class="modal-content">\
<div class="modal-header">\
<span class="close">×</span>\
<p>'+header+'</p></div>\
<div class="modal-body">\
'+text+'\
</div>\
</div>\
</div>';

$('body').append(modal);
if(type==2){text=$('.modal-body').load(text);}
/*var jscript=document.createElement("script");
jscript.id="modal_script";
jscript.innerHTML=js;*/
$('body').append(js);
}

/*فنكشن مودال لجميع الموقع*/
function imagebox(header,text){

text="<img src='"+text+"' style='width:100%;height:100%;'/>";

var js='<script id="modal_script">var modal = document.getElementById("myModal");\
var span = document.getElementsByClassName("close1")[0];\
\
span.onclick = function() {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
window.onclick = function(event) {\
if (event.target == modal) {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
};</script>';

var modal='<div id="myModal" class="modal">\
<div class="modal-content" style="width:40%;height:60%;margin:auto;">\
<div class="modal-header">\
<span class="close1">×</span>\
<p>'+header+'</p></div>\
'+text+'\
</div>\
</div>';

$('body').append(modal);

/*var jscript=document.createElement("script");
jscript.id="modal_script";
jscript.innerHTML=js;*/
$('body').append(js);
}
/*---------------مودال تسجيل الدخول------------------*/
function login_modal(header,text){
text="<iframe src='"+text+"'></iframe>";

var js='<script id="modal_script">var modal = document.getElementById("loginModal");\
var span = document.getElementsByClassName("close")[0];\
\
span.onclick = function() {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
window.onclick = function(event) {\
if (event.target == modal) {modal.style.display = "none";$(".modal").remove();$("#modal_script").remove();};\
};</script>';

var modal='<div id="loginModal" class="modal">\
<div class="modal-content-login">\
<div class="modal-header-login">\
<span class="close">×</span>\
<p>'+header+'</p></div>\
<div class="modal-body-login">\
'+text+'\
</div>\
</div>\
</div>';

$('body').append(modal);
$('body').append(js);
}
/*---------- get rotation deg value ---------------*/
function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
    } else { var angle = 0; }
    return (angle < 0) ? angle + 360 : angle;
}
/*-------------- rotate sympol ----------------*/
function rotate_menu_sympol(obj){
var a1=getRotationDegrees(obj);
if(a1===0){
obj.css({"-webkit-transform" : "rotate(-180deg)",
                 "-moz-transform" : "rotate(-180deg)",
                 "-ms-transform" : "rotate(-180deg)",
                 "transform" : "rotate(-180deg)"});
}

else {
obj.css({"-webkit-transform" : "rotate(0deg)",
                 "-moz-transform" : "rotate(0deg)",
                 "-ms-transform" : "rotate(0deg)",
                 "transform" : "rotate(0deg)"});
}
}

/*------------ menu bar toggle -------------*/
function menu_toogle(){
    $('.main_sidebar').animate({width: 'toggle',opacity: 'toggle'},300);
    //$('.main_sidebar').fadeToggle(500);

if($('.menu_bar').attr('data-open')==1){$('.menu_bar').attr('data-open',0);$('.menu_bar').html('');}
else{$('.menu_bar').attr('data-open',1);$('.menu_bar').html('');}
}

/*-------- select / deselect all -------*/
function select_deselect_all(){
var check=document.getElementById('selectall');
if(check.checked){$(".saveit").prop('checked', 'checked');}
else{$(".saveit").prop('checked',false);}
}

/*حفظ الفواتير الغير مرحلة المحددة*/
function save_select_temp(checkboxName,url) {
var checkboxes = document.querySelectorAll('input[name="' + checkboxName + '"]:checked');
var num=checkboxes.length;
if(num>0){
Array.prototype.forEach.call(checkboxes, function(el) {
    $.get(url+el.value);
});
var te="<div class='msg success'>تم الترحيل بنجاح</div><script>setTimeout(\"window.top.location.reload()\",1000);</script>";
mymodalbox('ترحيل',te,0);}

else{
var te="<div class='msg fail'>لم يتم اختيار عناصر للترحيل</div><script>setTimeout(\"window.top.location.reload()\",1000);</script>";
mymodalbox('ترحيل',te,0);
}

}