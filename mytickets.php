<?php
session_start();

require_once('install/netcnf/data_connect.php');

//Pobiera informację kto jest obecnie zalogowany
$User_ID = $_SESSION['IdAccount'];

$ntID;
$ntTitle;
$ntIDAcc;
$ntuser;
$ntdate;
$nttime;

$code = '
<div class="cTicketTitle">
<p>Moje zgłoszenia</p>
</div>
<table class="TicketsList">
    <thead>
    <tr><th class="n1">Numer</th><th class="n2">Data</th><th class="n3">Czas</th><th class="n4">Tytuł</th><th class="n5">Przejął</th></tr>
    </thead>
    <tbody>
        ';

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(!($ConnectToDataBase->connect_error))
{
    $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications where ID_ACCOUNT='".$User_ID."' AND free = 0 AND closed = 0;");

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
            <tr onclick="GetTicketInformation('.$ntID.',2)">
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
<div class="TicketButtonPanel">
    <input type="button" name="CloseWindowButton" id="cButton" onclick="CloseWindow(\'.InfoBox\',1)" value="Wyjdź"/>
</div>
';

echo $code;

?>