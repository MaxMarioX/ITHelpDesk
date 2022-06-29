//Dodaje nowy DIV, w którym będzie zapisane okno do przypisania zgłoszenia użytkownikowi
function NewDivForAssignTicket()
{
	$('.AssignBox').remove();
	var $newdiv1 = $( "<div class=\"AssignBox\"></div>" );
	$("#Main_Window").append( $newdiv1);	
}
//Dodaje nowy DIV, w którym będzie zapisane okno z historią zgłoszenia
function NewDivForHistoryTicket()
{
	$('.HistoryBox').remove();
	var $newdiv1 = $( "<div class=\"HistoryBox\"></div>" );
	$("#Main_Window").append( $newdiv1);	
}
//Dodaje nowy DIV, w którym będzie zapisane okno do utworzenia nowego zgłoszenia
function NewDivForCreateTicket()
{
	$('.CreateTicketBox').remove();
	var $newdiv1 = $( "<div class=\"CreateTicketBox\"></div>" );
	$("#Main_Window").append( $newdiv1);	
}
//Odświeża okno z nowymi ticketami
function RefreshNewTickets()
{
    $.ajax(
        {
            url: "getnewtickets.php",
            type: "post",
            success: function(response) {
                $('.DynamicDataForNewTickets').empty().append(response);
            }
    });    
}
//Odświeża okno z przejętymi zgłoszeniami
function RefreshEscalatedTickets()
{
    $.ajax(
        {
            url: "getescalatedtickets.php",
            type: "post",
            success: function(response) {
                $('.DynamicDataForEscalatedTickets').empty().append(response);
            }
    }); 
}

//Wyświetla okno do tworzenia nowego zgłoszenia
function CreateNewTicket()
{
    $.ajax(
        {
            url: "createnewticket.php",
            type: "post",
            data: "TicketID=1",
            success: function(inf){
                NewDivForCreateTicket();
                ShowShadow(1);
                ShowBox(inf);                
            }
        });    
}
//Rejestracja zgłoszenia w systemie
function CreateTicketNow()
{
	var p1 = $('input[name=place_1]').val();
    var p2 = $('input[name=place_2]').val();
    var p3 = $('input[name=place_3]').val();
    var p4 = $('input[name=place_4]').val();
    var p5 = $('textarea[name=place_5]').val();

    if(confirm("Czy jesteś pewien ?")) {
        $.ajax(
            {
                url: "registernewticket.php",
                type: "post",
                data: "p1="+p1+"&p2="+p2+"&p3="+p3+"&p4="+p4+"&p5="+p5,
                success: function(inf){
                    alert(inf);
                }
            }
        );
    }
}

//Przyjmuje numer danej wiadomości (od tickethistory.php) z historii zgłoszenia i wysyła żądanie o wyświetlenie pełnej treści wiadomości zgłoszenia
function GetHInformation(MsgNr)
{
    $.ajax(
        {
            url: "showfullmessage.php",
            type: "post",
            data: "MsgNumber="+MsgNr,
            success: function(inf){
                $(".MyMessage").fadeOut("slow", function() {
                    $(".MyMessage").empty().append(inf);
                }).fadeIn("slow");
            }      
        }
    );
}
//Wyświetla okno z historią zgłoszenia
function TicketHistory(TicketNumber,flags)
{
    $.ajax(
        {
            url: "tickethistory.php",
            type: "post",
            data: "TicketNumber="+TicketNumber+"&Flags="+flags,
            success: function(inf){
                CloseWindow(".InfoBox",0);
                NewDivForHistoryTicket();
                $(".HistoryBox").empty().append(inf).fadeIn("slow");
            }
        });    
}
//Powrót z okna wyświetlającego historię zgłoszenia do okna pokazujące szczegóły zgłoszenia
function TicketHistoryBack(number,flags)
{
    $('.HistoryBox').fadeOut("slow");
    GetTicketInformation(number,flags);

}
//Czyści zawartość TextArea
function CleanMessage()
{
    if(confirm("Czy jesteś pewien ?")) {
        $('textarea').val('');
    }
}
//Czyści zamyka możliwość wpisania zgłoszenia
function NoMessage()
{
    $("#nButton").fadeOut("slow", function() {
        $("#clButton").fadeOut("slow", function () {
            $("#sButton").fadeOut("slow", function() {
                $("#mButton").fadeIn("slow");
                $(".MyMessage").fadeOut("slow", function() {
                    $(this).empty();
                });
            });
        });
    });   
}
//Zapisuje wiadomość do bazy
function SaveMessage(TicketNumber)
{
    if ($("#mTextArea").val()) {
        if(confirm("Czy jesteś pewien ?")) {
            var Message = $("#mTextArea").val();
            $.ajax(
                {
                    url: "savemessage.php",
                    type: "post",
                    data: "TicketNumber="+TicketNumber+"&Message="+Message,
                    success: function(inf){
                        alert(inf);
                    }
                });         
        }        
    } else {
        alert("Proszę wpisać wiadomość!");
    }
}
//Otwiera okno do wpisywania wiadomości do historii zgłoszenia
function NewMessage(TicketNumber)
{
    $.ajax(
        {
            url: "newmessage.php",
            type: "post",
            data: "TicketNumber="+TicketNumber,
            success: function(inf){
                $(".MyMessage").fadeOut("slow", function() {
                    $(".MyMessage").empty().append(inf);
                }).fadeIn("slow"); 
                $("#mButton").fadeOut("slow", function() {
                    $("#sButton").fadeIn("slow", function () {
                        $("#clButton").fadeIn("slow", function() {
                            $("#nButton").fadeIn("slow");
                        });
                    });
                });
            }      
        }
    );
}
//Wysyła żądanie o otwarcie okna, z możliwością przypisania zgłoszenia innemu użytkownikowi
function AssignTicket(TicketNumber, User)
{
    $.ajax(
        {
            url: "assignicket.php",
            type: "post",
            data: "TicketNumber="+TicketNumber+"&User="+User,
            success: function(inf){
                CloseWindow(".InfoBox",0);
                NewDivForAssignTicket();
                $(".AssignBox").empty().append(inf).fadeIn("slow");
            }
        });    
}
//Przypisuje zgłoszenie aktualnie zalogowanemu użytkownikowi
function TakeTicket(TicketNumber, User)
{
    if(confirm("Czy jesteś pewien ?")) {
        $.ajax(
            {
                url: "getticket.php",
                type: "post",
                data: "TicketNumber="+TicketNumber+"&User="+User,
                success: function(inf){
                    alert(inf);
                    CloseWindow(".InfoBox",1);
                }
            }
        ); 
    }
}
//Zamyka zgłoszenie w systemie
function CloseTicket(TicketNumber)
{
    if(confirm("Czy na pewno chcesz zamknąć zgłoszenie?")) {
        $.ajax(
            {
                url: "closeticket.php",
                type: "post",
                data: "TicketNumber="+TicketNumber,
                success: function(inf){
                    if(inf)
                    {
                        alert("Zgłoszenie zostało zamknięte!");
                        CloseWindow(".InfoBox",1);
                    } else {
                        alert("Błąd!");
                    }
                }
            }
        );
    }
}
//Pokazuje jedynie zgłoszenia użytkownika
function ShowMyTickets()
{
    $.ajax(
        {
            url: "mytickets.php",
            type: "post",
            data: "run",
            success : function(inf) {
                ShowShadow(1);
                ShowInformationV2(inf);
            }

        }
    );
}
//Zamyka okno (div w którym znajduje się okno, efekt cienia)
function CloseWindow(Mydiv,DisableShadow)
{
    if(DisableShadow)
        ShowShadow(0);

    $(Mydiv).fadeOut("slow");
}
//Efekt cienia - 1 włącz cień, 0 wyłącz cień
function ShowShadow(opt)
{
    if(opt)
    {
        $(".Shadow").fadeIn("slow");
    } else {
        $(".Shadow").fadeOut("slow");
    }
}
//Przypisuje kod html tworzenie nowego zgłoszenia
function ShowBox(inf)
{
    $(".CreateTicketBox").empty().append(inf).fadeIn("slow");
}
//Przypisuje kod html nt szczegółów zgłoszenia
function ShowInformation(inf)
{
    $(".InfoBox").empty().append(inf).fadeIn("slow");
}
//Przypisuje kod html nt szczegółów zgłoszenia (wersja 2)
function ShowInformationV2(inf)
{
    $(".InfoBox").fadeOut("slow", function() {
        $(this).empty().append(inf);
    }).fadeIn("slow");
}
//Pokazuje szczegółowe informacje nt zgłoszenia
//Zmienna flags informuje czy będą wyświetlone dodatkowe buttony czy nie
function GetTicketInformation(number,flags)
{
    $.ajax(
    {
        url: "getticketinformation.php",
        type: "post",
        data: "TicketID="+number+"&Flags="+flags,
        success: function(inf){
            if(flags == 2)
            {
                ShowInformationV2(inf);
            }
            else {
                ShowShadow(1);
                ShowInformation(inf);
            }
        }
    });
}
