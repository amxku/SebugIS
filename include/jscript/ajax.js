//sablog
var xml_http_building_link = '正在建立连接...';
var xml_http_sending = '正在发送数据...';
var xml_http_loading = '正在接收数据...';
var xml_http_load_failed = '通信失败, 请刷新重新尝试.';
function Ajax(statusId, recvType) {
var aj = new Object();
aj.statusId = $('statusmsg');
var oDivStyle = $('statusmsg').style;
var width = 200;
var oDiv = aj.statusId;
//判断显示的位置-居中
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = (userAgent.indexOf('opera') != -1);
var clientHeight = scrollTop = 0; 
if(is_opera) {
clientHeight = document.body.clientHeight / 2;
scrollTop = document.body.scrollTop;
} else {
clientHeight = document.documentElement.clientHeight / 2;
scrollTop = document.documentElement.scrollTop;
}
oDivStyle.display = '';
oDivStyle.left = (document.documentElement.clientWidth / 2 + document.documentElement.scrollLeft - width / 2) + 'px';
oDivStyle.top = (clientHeight +　scrollTop - oDiv.clientHeight / 2) + 'px';
//by angel
oDivStyle.position = 'absolute';
oDivStyle.fontSize = '12px';
oDivStyle.fontFamily = 'Verdana';
oDivStyle.width = width + 'px';
oDivStyle.padding = '5px';
oDivStyle.backgroundColor = '#f00';
oDivStyle.color = '#fff';
oDivStyle.textAlign = 'center';
aj.targetUrl = '';
aj.sendString = '';
aj.recvType = recvType ? recvType : 'XML';//HTML XML
aj.resultHandle = null;
aj.createXMLHttpRequest = function() {
var request = false;
if(window.XMLHttpRequest) {
request = new XMLHttpRequest();
if(request.overrideMimeType) {
request.overrideMimeType('text/xml');
}
} else if(window.ActiveXObject) {
var versions = ['Microsoft.XMLHTTP', 'MSXML.XMLHTTP', 'Microsoft.XMLHTTP', 'Msxml2.XMLHTTP.7.0', 'Msxml2.XMLHTTP.6.0', 'Msxml2.XMLHTTP.5.0', 'Msxml2.XMLHTTP.4.0', 'MSXML2.XMLHTTP.3.0', 'MSXML2.XMLHTTP'];
for(var i=0; i<versions.length; i++) {
try {
request = new ActiveXObject(versions[i]);
if(request) {
return request;
}
} catch(e) {
//alert(e.message);
}
}
}
return request;
}
aj.XMLHttpRequest = aj.createXMLHttpRequest();
aj.processHandle = function() {
aj.statusId.style.display = '';
if(aj.XMLHttpRequest.readyState == 1) {
aj.statusId.innerHTML = xml_http_building_link;
} else if(aj.XMLHttpRequest.readyState == 2) {
aj.statusId.innerHTML = xml_http_sending;
} else if(aj.XMLHttpRequest.readyState == 3) {
aj.statusId.innerHTML = xml_http_loading;
} else if(aj.XMLHttpRequest.readyState == 4) {
if(aj.XMLHttpRequest.status == 200) {
aj.statusId.style.display = 'none';
if(aj.recvType == 'HTML') {
aj.resultHandle(aj.XMLHttpRequest.responseText);
} else if(aj.recvType == 'XML') {
aj.resultHandle(aj.XMLHttpRequest.responseXML);
}
} else {
aj.statusId.innerHTML = xml_http_load_failed;
}
}
}
aj.get = function(targetUrl, resultHandle) {
aj.targetUrl = targetUrl;
aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
aj.resultHandle = resultHandle;
if(window.XMLHttpRequest) {
aj.XMLHttpRequest.open('GET', aj.targetUrl);
aj.XMLHttpRequest.send(null);
} else {
aj.XMLHttpRequest.open('GET', targetUrl, true);
aj.XMLHttpRequest.send();
}
}
aj.post = function(targetUrl, sendString, resultHandle) {
aj.targetUrl = targetUrl;
aj.sendString = sendString;
aj.XMLHttpRequest.onreadystatechange = aj.processHandle;
aj.resultHandle = resultHandle;
aj.XMLHttpRequest.open('POST', targetUrl);
aj.XMLHttpRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
aj.XMLHttpRequest.send(aj.sendString);
}
return aj;
}