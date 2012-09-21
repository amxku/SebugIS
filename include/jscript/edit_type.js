function $(id) {
return document.getElementById(id);
}
function showajaxdiv(action, url, width) {
var x = new Ajax('statusid', 'XML');
x.get(url, function(s) {
if($("ajax-div-"+action)) {
var oDiv = $("ajax-div-"+action);
} else {
var oDiv = document.createElement("DIV");
oDiv.id = "ajax-div-"+action;
oDiv.className = "ajaxdiv";
document.body.appendChild(oDiv);
}
var oDivStyle = oDiv.style;
oDivStyle.display = "";
oDivStyle.width = width + "px";

var userAgent = navigator.userAgent.toLowerCase();
var is_opera = (userAgent.indexOf('opera') != -1);
var clientHeight = scrollTop = 0; 
if(is_opera) {
clientHeight = document.body.clientHeight /2;
scrollTop = document.body.scrollTop;
} else {
clientHeight = document.documentElement.clientHeight /2;
scrollTop = document.documentElement.scrollTop;
}
oDiv.innerHTML = s.lastChild.firstChild.nodeValue;
oDivStyle.left = (document.documentElement.clientWidth /2 +document.documentElement.scrollLeft - width/2)+"px";
oDivStyle.top = (clientHeight +　scrollTop - oDiv.clientHeight/2)+"px";
});
}
function tagshow(tag) {
var width = 300;
var x = new Ajax('statusid', 'XML');
x.get(typeck_aj_url + '?action=type&item=' + encodeURIComponent(tag), function(s) {
if($("ajax-div-tagshow")) {
var oDiv = $("ajax-div-tagshow");
} else {
var oDiv = document.createElement("DIV");
oDiv.id = "ajax-div-tagshow";
oDiv.className = "ajaxdiv";
document.body.appendChild(oDiv);
}
var oDivStyle = oDiv.style;
oDivStyle.display = "";
oDivStyle.width = width + "px";

var userAgent = navigator.userAgent.toLowerCase();
var is_opera = (userAgent.indexOf('opera') != -1);
var clientHeight = scrollTop = 0; 
if(is_opera) {
clientHeight = document.body.clientHeight /2;
scrollTop = document.body.scrollTop;
} else {
clientHeight = document.documentElement.clientHeight /2;
scrollTop = document.documentElement.scrollTop;
}
oDiv.innerHTML = s.lastChild.firstChild.nodeValue;
oDivStyle.left = (document.documentElement.clientWidth /2 +document.documentElement.scrollLeft - width/2)+"px";
oDivStyle.top = (clientHeight +　scrollTop - oDiv.clientHeight/2)+"px";
});
}

//添加type
function showaddtype(tag) {
var width = 400;
var x = new Ajax('statusid', 'XML');
x.get(typeck_aj_url + '?action=addtype&item=' + encodeURIComponent(tag), function(s) {
if($("ajax-div-tagshow")) {
var oDiv = $("ajax-div-tagshow");
} else {
var oDiv = document.createElement("DIV");
oDiv.id = "ajax-div-tagshow";
oDiv.className = "ajaxdiv";
document.body.appendChild(oDiv);
}
var oDivStyle = oDiv.style;
oDivStyle.display = "";
oDivStyle.width = width + "px";

var userAgent = navigator.userAgent.toLowerCase();
var is_opera = (userAgent.indexOf('opera') != -1);
var clientHeight = scrollTop = 0; 
if(is_opera) {
clientHeight = document.body.clientHeight /2;
scrollTop = document.body.scrollTop;
} else {
clientHeight = document.documentElement.clientHeight /2;
scrollTop = document.documentElement.scrollTop;
}
oDiv.innerHTML = s.lastChild.firstChild.nodeValue;
oDivStyle.left = (document.documentElement.clientWidth /2 +document.documentElement.scrollLeft - width/2)+"px";
oDivStyle.top = (clientHeight +　scrollTop - oDiv.clientHeight/2)+"px";
});
}

function showhide(obj) {
$(obj).style.display = $(obj).style.display == 'none' ? 'block' : 'none';
}

function save_typecheck()
{
    var msg = document.getElementById("msg");
    var f = document.check_type;    
    var bugid = f.bugid.value;
    var typeid = f.typeid.value;
    var ne_id = f.ne_id.value;
    var url = typeck_aj_url + '?action=checktype';    
    var postStr = "&bugid="+ bugid +"&typeid="+ typeid +"&ne_id="+ ne_id;
    var ajax = null;
    if(window.XMLHttpRequest){
        ajax = new XMLHttpRequest();
       }
    else if(window.ActiveXObject){
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
       }
    else{
        return;
       }
    ajax.open("POST", url, true); 
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send(postStr);
    ajax.onreadystatechange = function(){
        if (ajax.readyState == 4 && ajax.status == 200){
               msg.innerHTML = ajax.responseText;
            }
      }
}

function save_type(){
    var msg = document.getElementById("msg");
    var f = document.check_type;    
    var type_name = f.type_name.value;
    var website = f.website.value;
    var type_info = f.type_info.value;
    var t_checked = f.t_checked.value;
    var check_view = f.check_view.value;
    var item = f.item.value;
    var url = typeck_aj_url + '?action=doaddtype';
    var postStr = "&type_name="+ type_name +"&website="+ website +"&type_info="+ type_info +"&t_checked="+ t_checked +"&check_view="+ check_view +"&item="+ item;
    var ajax = null;
    if(window.XMLHttpRequest){
        ajax = new XMLHttpRequest();
       }
    else if(window.ActiveXObject){
        ajax = new ActiveXObject("Microsoft.XMLHTTP");
       }
    else{
        return;
       }
    ajax.open("POST", url, true); 
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send(postStr);
    ajax.onreadystatechange = function(){
        if (ajax.readyState == 4 && ajax.status == 200){
               msg.innerHTML = ajax.responseText;
            }
      }
}