<?php
/*
Sprawdza czy w bazie danych pojawiły się nowe zgoszenia.
*/

$ntID;      //Numer ID zgłoszenia
$ntCL;      //Czy zgłoszenie zostało zamknięte
$ntTitle;   //Tytuł zgłoszenia
$ntIDAcc;   //Numer ID konta użytkownika, który zarejestrował zgłoszenie
$ntuser;    //Imię i nazwisko osoby, której dotyczy zgłoszenie
$ntdate;    //Data zarejestrowania zgłoszenia
$nttime;    //Czas zarejestrowania zgłoszenia

$code = '
<table class="TicketsList">
    <thead>
    <tr><th class="n1">Numer</th><th class="n2">Data</th><th class="n3">Czas</th><th class="n4">Tytuł</th><th class="n5">Zgłaszający</th></tr>
    </thead>
    <tbody>
        ';

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(!($ConnectToDataBase->connect_error))
{
    $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications where free=1 AND closed = 0;");

	if(mysqli_num_rows($ConnStatus))  
	{
        while($DataRow = mysqli_fetch_array($ConnStatus))  
        {
            $ntID = $DataRow['ID_Notification'];    
            $ntIDAcc = $DataRow['ID_ACCOUNT'];
            
            $ConnStatusText = $ConnectToDataBase->query("SELECT title, ID_Notification from notifications_text where ID_Notification='".$ntID."';");
            $DataRowText = mysqli_fetch_array($ConnStatusText);
            $ntTitle = $DataRowText['title'];

            $ConnStatusDetail = $ConnectToDataBase->query("SELECT * from notifications_detail where ID_Notification='".$ntID."';");
            $DataRowDetail = mysqli_fetch_array($ConnStatusDetail);
            $ntuser = $DataRowDetail['user'];
            $ntdate = $DataRowDetail['date'];
            $nttime = $DataRowDetail['time'];

            $code .= '
            <tr onclick="GetTicketInformation('.$ntID.',1)">
            <td class="n1">'.$ntID.'</td><td>'.$ntdate.'</td><td>'.$nttime.'</td><td>'.$ntTitle.'</td><td>'.$ntuser.'</td>
            </tr>
            ';
        }
    } else {

    }
} else {

}
$ConnectToDataBase->close();
$code .= '
</tbody>
</table>
';

?>


