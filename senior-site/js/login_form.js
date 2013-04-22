$(document).ready(function() {
$("#ajax-login-form").submit(function() {

var str = $(this).serialize();

	$.ajax(){
	type: "POST",
	url: "login.php",
	data: str,
	success: function(msg) {
$("#note").ajaxComplete(function(event, request, settings) {
	if (msg == 'OK') {
		result = '<div class="notification_ok">Welcome!</div>';
	$("fields").hide();
	}
	else {
	result = msg;
	}

$(this).hide();
$(this.html(result).slideDown("slow");

$(this).html(result);

});

}

});

	