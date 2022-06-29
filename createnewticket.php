<?php
//Wyświetla okno do tworzenia nowego zgłoszenia w systemie
session_start();

//Pobiera informację kto jest obecnie zalogowany
$User_ID = $_SESSION['IdAccount'];
//Wygenerowany kod
$Code = '';

function GenerateCode()
{
$GLOBALS['Code'] .= '
<div class="cNewTicket">
    <div class="cTicketTitle">
        <p>Tworzenie nowego zgłoszenia</p>
    </div>
    <div class="cTicketDetails">
        <table class="cTableA">
            <tr><td><span>Zgłaszający</span></td><td><input type="text" name="place_1" id="place_1"/></td></tr>
            <tr><td><span>Odział/Firma</span></td><td><input type="text" name="place_2" id="place_2"/></td></tr>
            <tr><td><span>Program</span></td><td><input type="text" name="place_3" id="place_3"/></td></tr>
            <tr><td><span>Tytuł</span></td><td><input type="text" name="place_4" id="place_4"/></td></tr>
            <tr><td><span>Wiadomość</span></td><td><textarea id="cTextarea" name="place_5"></textarea></td></tr>
        </table>
    </div>
</div>
<div class="TicketButtonPanel">
';
//Przycisk niezależny od powyższych warunków
$GLOBALS['Code'] .= '
    <input type="button" name="CreateTicketButton" id="c_crButton" onclick="CreateTicketNow()" value="Zarejestruj"/>
    <input type="button" name="CloseWindowButton" id="c_cButton" onclick="CloseWindow(\'.CreateTicketBox\',1)" value="Wyjdź"/>
</div>';
}

GenerateCode();

echo $Code;

?>