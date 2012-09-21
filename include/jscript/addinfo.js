function checkexpform() {
	if ($('exp_title').value == "") {
		alert("Please enter title.");
		return false;
	}
	if ($('exp_putime').value == "yyyy-mm-dd") {
		alert("Please enter Published.");
		return false;
	}
	if ($('bug_be_type').value == "") {
		alert("Please enter type.");
		return false;
	}
	if ($('bug_os').value == "") {
		alert("Please enter system.");
		return false;
	}
	if ($('exp_exp').value == "") {
		alert("Please enter Exploit.");
		return false;
	}
	if ($('clientcode').value == ""){
		alert("Please enter clientcode.");
		return false;
	}
	return true;
}

function checkvulform() {
	if ($('bug_title').value == "") {
		alert("Please enter title.");
		return false;
	}
	if ($('bug_os').value == "") {
		alert("Please enter system.");
		return false;
	}
	if ($('bug_be_type').value == "") {
		alert("Please enter type.");
		return false;
	}
	if ($('bug_putime').value == "yyyy-mm-dd") {
		alert("Please enter Published.");
		return false;
	}
	if ($('bug_Impact').value == "") {
		alert("Please enter Vulnerable.");
		return false;
	}
	if ($('bug_grades').value == "") {
		alert("Please enter grades.");
		return false;
	}
	if ($('bug_buginfo').value == "") {
		alert("Please enter Discussion.");
		return false;
	}
	if ($('bug_ress').value == "") {
		alert("Please enter Solution.");
		return false;
	}
	if ($('bug_reference').value == "") {
		alert("Please enter References.");
		return false;
	}
	if ($('clientcode').value == ""){
		alert("Please enter clientcode.");
		return false;
	}
	return true;
}