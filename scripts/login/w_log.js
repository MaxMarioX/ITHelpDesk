function ShowErrorMessage(dStatus,message)
{
	if(dStatus) {
		$(".ErrorMessage").css({
			"color": "rgb(0, 190, 0)"
		});
		location.reload();
	} else {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
		}).empty().append(message).fadeIn("slow").delay(1500).fadeOut("slow");
	}
}
function Action(NULL)
{
	var dLogin = $('input[name=login]').val();
	var dPassword = $('input[name=password]').val();
	$("#LoginButton").fadeOut("slow", function() { 		
		$.ajax(
		{
			url: "verify.php",
			type: "POST",
			data: "login="+dLogin+"&password="+dPassword,
			success: function(phpmessages){
				if(phpmessages == "#UserLoginSuccess"){
					ShowErrorMessage(true);
				} else {
					ShowErrorMessage(false,phpmessages);
				}
			},
			error: function () {
				ShowErrorMessage(false,"Nie można połączyć się z serwerem aplikacji!");
			}
		});
	}).delay(3000).fadeIn("slow");	
}
$(document).ready(function() {
	$(this).on('keypress', function(e) {
		if(e.which == 13) {
			Action();
		}
	});
	$("#LoginButton").click(function() {
		Action();
	});
});