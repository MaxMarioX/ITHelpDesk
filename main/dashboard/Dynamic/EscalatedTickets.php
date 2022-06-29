<?php
/*
Przedstawia zgłoszenia, które zostały już przejęte przez użytkowników.
*/

$ntID;
$ntTitle;
$ntIDAcc;
$ntuser;
$ntdate;
$nttime;

$code = '

<table class="TicketsList">
    <thead>
    <tr><th class="n1">Numer</th><th class="n2">Data</th><th class="n3">Czas</th><th class="n4">Tytuł</th><th class="n5">Przejął</th></tr>
    </thead>
    <tbody>
        ';

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(!($ConnectToDataBase->connect_error))
{
    $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications where free = 0 AND closed = 0");

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
            $ntdate = $DataRowDetail['date'];
            $nttime = $DataRowDetail['time'];

            $ConnStatusDetailAcc = $ConnectToDataBase->query("SELECT name, surname from owners where ID_ACCOUNT='".$ntIDAcc."';");
            $DataRowDetail = mysqli_fetch_array($ConnStatusDetailAcc);
            $ntAccUsrName = $DataRowDetail['name'];
            $ntAccUsrSurname = $DataRowDetail['surname'];

            $code .= '
            <tr onclick="GetTicketInformation('.$ntID.',1)">
            <td class="n1">'.$ntID.'</td><td>'.$ntdate.'</td><td>'.$nttime.'</td><td>'.$ntTitle.'</td><td>'.$ntAccUsrName.' '.$ntAccUsrSurname.'</td>
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