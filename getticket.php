<?php
/*
Przypisuje ticket do konkrentego użytkownika oraz odnotowuje ten fakt w historii zgłoszenia
*/
session_start();

require_once('install/netcnf/data_connect.php');
require_once('main/Log.php');

$TicketNumber = $_POST['TicketNumber']; //Numer zgłoszenia
$User = $_POST['User'];                 //Użytkownik, któremu należy przypisać zgłoszenie
$UserName;                              //Imię i nazwisko osoby, której należy przypisać zgłoszenie
$ActualUsr = $_SESSION['IdAccount'];    //Użytkownik aktualnie zalogowany
$ActualUsrName;                         //Imię i nazwisko osoby, która jest aktualnie zalogowana
$ErrMsg;                                //Komunikat

//Przypisujemy zgłoszenie do danego użytkownika
function AssignTicket($Connect)
{
    $ConnStatus = $Connect->query("UPDATE notifications set ID_ACCOUNT='".$GLOBALS['User']."', free=0 where ID_Notification='".$GLOBALS['TicketNumber']."';");
    if($ConnStatus)
        return true;
}
//Odszukuje rekord pod danym ID by odczytać imię i nazwisko
function GetDataUser($Connect)
{ 
    $InfAcc = $Connect->query("SELECT * from owners where ID_Account='".$GLOBALS['User']."';");
        
    if(mysqli_num_rows($InfAcc))
    {
        $InfAccDataRow = mysqli_fetch_array($InfAcc);
        
        $GLOBALS['UserName'] = $InfAccDataRow['name']." ".$InfAccDataRow['surname'];

        $InfAccV2 = $Connect->query("SELECT * from owners where ID_Account='".$GLOBALS['ActualUsr']."';");

        if(mysqli_num_rows($InfAccV2))
        {
            $InfAccDataRowV2 = mysqli_fetch_array($InfAccV2);
        
            $GLOBALS['ActualUsrName'] = $InfAccDataRowV2['name']." ".$InfAccDataRowV2['surname'];
            
            return true;

        } else {
            return false;           
        }
    } else {
        return false;
    }
}

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(!($ConnectToDataBase->connect_error))
{
    if(AssignTicket($ConnectToDataBase))
    {
        if(GetDataUser($ConnectToDataBase))
        {
            if(SaveLog($ConnectToDataBase, "Użytkownik ".$GLOBALS['ActualUsrName']." przypisał zgłoszenie do ".$UserName."", $User, $TicketNumber))
            {
                $ErrMsg = "Przypisano użytkownikowi ".$UserName."!";
            } else {
                $ErrMsg = "Przypisano użytkownikowi ".$UserName." ale nie można odnotować tego faktu w bazie danych!";
            }
            
        } else {
            $ErrMsg = "Zgłoszenie zostało przypisane ale pojawiły się błędy!";
        }
    } else {
        $ErrMsg = "Błąd: Nie można przypisać zgłoszenia!";
    }
    $ConnectToDataBase->Close();
} else {
    $ErrMsg = "Błąd: Nie można nawiązać połączenia z bazą danych!";
}
exit($ErrMsg);

;
?>