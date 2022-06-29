function LogOutNow()
{
    if(confirm("Czy jesteś pewien ?")) {
        $.ajax(
        {
            url: "logoutnow.php",
            type: "post",
            success: function(response) {
                alert("Zostałeś pomyślnie wylogowany z serwera!");
                location.reload();
            }
        });
    }
}

function LoadNewTickets()
{
    $.ajax(
	{
		url: "getnewtickets.php",
        type: "post",
        success: function(response) {
            $('.DynamicDataForNewTickets').empty().append(response);
            setTimeout(function() {
                LoadNewTickets();
            }, 10000);
        }
    });
}

function LoadEscalatedTickets()
{
    $.ajax(
    {
        url: "getescalatedtickets.php",
        type: "post",
        success : function(response){
            $('.DynamicDataForEscalatedTickets').empty().append(response);
            setTimeout(function() {
                LoadEscalatedTickets();
            }, 10500);
        }
    });
}

$(document).ready(function() {
    LoadNewTickets();
    LoadEscalatedTickets();
});