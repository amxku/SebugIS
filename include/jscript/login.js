function checkregform() {
	if ($('username').value == "") {
		alert("Please enter your username.");
		return false;
	}
	if ($('password').value == "" || ($('confirmpassword') && $('confirmpassword').value == "")) {
		alert("Please enter your password/Re-enter password.");
		return false;
	}
	if ($('confirmpassword') && $('password').value !== $('confirmpassword').value) {
		alert("[password] and [Re-enter password] is not the same.");
		return false;
	}
	if ($('email') && $('email').value == ""){
		alert("Please enter your email.");
		return false;
	}
	if ($('clientcode') && $('clientcode').value == ""){
		alert("Please enter your clientcode.");
		return false;
	}
	return true;
}
function checkloginform() {
	if ($('username').value == "") {
		alert("Please enter your username.");
		return false;
	}
	if ($('password') && $('password').value == ""){
		alert("Please enter your password.");
		return false;
	}
	if ($('clientcode') && $('clientcode').value == ""){
		alert("Please enter your clientcode.");
		return false;
	}
	return true;
}

function checkproform() {
	if ($('oldpassword').value == "") {
		alert("Please enter your oldpassword.");
		return false;
	}
	if ($('clientcode') && $('clientcode').value == ""){
		alert("Please enter your clientcode.");
		return false;
	}
	return true;
}