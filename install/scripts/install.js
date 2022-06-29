function ShowErrorMessage(dStatus)
{
	if(dStatus == '0') {
		$(".ErrorMessage").css({
			"color": "rgb(0, 190, 0)"
        }).empty().append("Sukces").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#InstallBoxA').delay(2500).fadeOut("slow");        
        $('#InstallBoxB').delay(3500).fadeIn("slow");
    } 
    else if(dStatus == '1') {
        $(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę uzupełnić wszystkie pola!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NA').delay(3500).fadeIn("slow");      
    }
    else if(dStatus == '2') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawnie wpisać nazwę użytkownika i hasło!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NA').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '3') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Nie można nawiązać połączenia z serwerem!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NA').delay(3500).fadeIn("slow");
    }
    else {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Nie znany błąd!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NA').delay(3500).fadeIn("slow");
	}
}

function ShowErrorMessage_b(dStatus)
{
	if(dStatus == '0') {
		$(".ErrorMessage").css({
			"color": "rgb(0, 190, 0)"
        }).empty().append("Sukces").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#InstallBoxB').delay(2500).fadeOut("slow");        
        $('#InstallBoxC').delay(3500).fadeIn("slow");
    } 
    else if(dStatus == '1') {
        $(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę uzupełnić wszystkie pola!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");      
    }
    else if(dStatus == '2') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawić pole Nazwa hosta!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '3') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Nie można nawiązać połączenia z serwerem!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '4') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawić pole Nazwa użytkownika!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '5') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawić pole Hasło!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '6') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Podane hasła różnią się!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '7') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę sprawdzić pole Nazwa bazy danych!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
    }
    else {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Nie znany błąd!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NB').delay(3500).fadeIn("slow");
	}
}

function ShowErrorMessage_c(dStatus)
{
    if(dStatus == '0') {
		$(".ErrorMessage").css({
			"color": "rgb(0, 190, 0)"
        }).empty().append("Sukces").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#InstallBoxC').delay(2500).fadeOut("slow");        
        $('#InstallBoxD').delay(3500).fadeIn("slow");
    } 
    else if(dStatus == '1') {
        $(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę uzupełnić wszystkie pola!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NC').delay(3500).fadeIn("slow");      
    }
    else if(dStatus == '2') {
        $(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawić pole Nazwa Konta!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NC').delay(3500).fadeIn("slow");      
    }
    else if(dStatus == '3') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Proszę poprawić pole Hasło!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NC').delay(3500).fadeIn("slow");
    }
    else if(dStatus == '4') {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Podane hasła różnią się!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NC').delay(3500).fadeIn("slow");
    }
    else {
		$(".ErrorMessage").css({
			"color": "rgb(190, 0, 0)"
        }).empty().append("Nie znany błąd!").fadeIn("slow").delay(1500).fadeOut("slow");
        $('#ButtonInstall_NC').delay(3500).fadeIn("slow");
	}
}

function ShowErrorMessage_d(dStatus)
{
	$(".ErrorMessage").css({
		"color": "rgb(0, 190, 0)"
    }).empty().append(dStatus).fadeIn("slow");
}

function CheckData(NULL)
{
    var dHost = $('input[name=Field-host]').val();
    var dUser = $('input[name=Field-user').val();
    var dPassword = $('input[name=Field-password').val();

	$("#ButtonInstall_NA").fadeOut("slow", function() {	
		$.ajax(
		{
			url: "cntr01.php",
			type: "POST",
            data: "dhost="+dHost+"&dUser="+dUser+"&dPassword="+dPassword,
			success: function(phpmessages){
                ShowErrorMessage(phpmessages);
            },
            error: function() {
                ShowErrorMessage('3');
            }
		});
	});  
}

function CheckData_b(NULL)
{
    var dHost = $('input[name=Field-host-2]').val();
    var dUser = $('input[name=Field-user-2]').val();
    var dPassword = $('input[name=Field-password-2]').val();
    var dPassword2 = $('input[name=Field-password-3]').val();
    var dDataBase = $('input[name=Field-database]').val();

	$("#ButtonInstall_NB").fadeOut("slow", function() {	
		$.ajax(
		{
			url: "cntr02.php",
			type: "POST",
            data: "dhost_b="+dHost+"&dUser_b="+dUser+"&dPassword_b="+dPassword+"&dPassword_c="+dPassword2+"&dDataBaseName="+dDataBase,
			success: function(phpmessages){
                ShowErrorMessage_b(phpmessages);
            },
            error: function() {
                ShowErrorMessage_b('3');
            }
		});
	});  
}

function CheckData_c(NULL)
{
    var dAccountName = $('input[name=Field-admin-account]').val();
    var dPassword = $('input[name=Field-admin-password]').val();
    var dPassword2 = $('input[name=Field-admin-password-2]').val();

    $("#ButtonInstall_NC").fadeOut("slow", function() {
        $.ajax(
        {  
            url: "cntr03.php",
            type: "POST",
            data: "dAdminAcc="+dAccountName+"&dAdminPasswd="+dPassword+"&dAdminPasswd2="+dPassword2,
            success: function(phpmessages){
                ShowErrorMessage_c(phpmessages);
            },
            error: function() {
                ShowErrorMessage_c('3');
            }
        });
    });
}

function Install(NULL)
{
    $("#ButtonInstall_ND").fadeOut("slow", function() {
        $.ajax(
        {  
            url: "install_db.php",
            type: "POST",
            data: "start=1",
            success: function(phpmessages){
                ShowErrorMessage_d(phpmessages);
            },
            error: function() {
                ShowErrorMessage_d('3');
            }
        });
    });
}

$(document).ready(function(){
    $(this).on('keypress', function(e){
        if(e.which == 13) {
            CheckData();
        }
    });
    $('#ButtonInstall_NA').click(function() {
        CheckData();
    });
    $('#ButtonInstall_NB').click(function() {
        CheckData_b();
    });
    $('#ButtonInstall_NC').click(function() {
        CheckData_c();
    });
    $('#ButtonInstall_ND').click(function() {
        Install();
    });
});