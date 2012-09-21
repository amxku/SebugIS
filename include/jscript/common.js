function $(id) {
return document.getElementById(id);
}
function updateseccode() {
	var rand = Math.random();
	$('seccodeimage').innerHTML = '<img id="seccode" onclick="updateseccode()" src="' + sebugurl + 'include/seccode.php?update=' + rand + '" alt="单击图片换张图片" border="0"/>';
}