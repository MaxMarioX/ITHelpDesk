<?php
//Tworzy nowe zgłoszenie w systemie
session_start();

//Dane do połączenia z bazą danych
require_once('install/netcnf/data_connect.php');

//Pobiera informację kto jest obecnie zalogowany
$User_ID = $_SESSION['IdAccount'];

//Pobiera dane z pól
$p1 = $_POST['p1'];
$p2 = $_POST['p2'];
$p3 = $_POST['p3'];
$p4 = $_POST['p4'];
$p5 = $_POST['p5'];

//Wygenerowany kod
$Code = '';

/*
Zapis informacji do tabeli Notification.
Jeżeli funkcja wykona się poprawnie, zwróci Numer ID zarejestrowanego ticketu.
Jeżeli funkcja nie wykona się poprawnie, zwróci wartość 0 (false).
*/

function SaveNotification($ConnectToDataBase, $IDAccount)
{
    $Status = false;
  
    if(!($ConnectToDataBase->connect_error))
    {
        if($ConnectToDataBase->query("INSERT INTO notifications set closed=b'0', free=b'1', ID_ACCOUNT_REG='".$IDAccount."', ID_ACCOUNT='".$IDAccount."';"))
        {
            $Status = $ConnectToDataBase->insert_id;
        }
    }

    return $Status;
}

/*
Zapis informacji do tabeli NotificationDetail
Jeżeli funkcja wykona się poprawnie, zwróci wartość 1
*/
function SaveNotificationDetail($ConnectToDataBase, $IDAccount, $NotificationID)
{
    $Status = false;
    $AccountName;

    $MyDate = getdate();
    $Day = $MyDate['mday'];
    $Month = $MyDate['mon'];
    $Year = $MyDate['year'];

    $Hour = $MyDate['hours'];
    $Minutes = $MyDate['minutes'];
    $Seconds = $MyDate['seconds'];

    $Today = $Year."-".$Month."-".$Day;
    $Time = $Hour.":".$Minutes.":".$Seconds;

    if(!($ConnectToDataBase->connect_error))
    {
        if($ConnectionStatus = $ConnectToDataBase->query("select login from accounts where ID_ACCOUNT='".$IDAccount."';"))
        {
            if(mysqli_num_rows($ConnectionStatus))  
            {
                $DataRow = mysqli_fetch_array($ConnectionStatus);
                $AccountName = $DataRow['login'];
            }
        }
    
        if($ConnectToDataBase->query("INSERT INTO notifications_detail set user='".$GLOBALS['p1']."', date='".$Today."', time='".$Time."', company= '".$GLOBALS['p2']."', system='".$GLOBALS['p3']."', ID_Notification='".$NotificationID."';"));
            $Status = true;   
    }

    return $Status;
}
/*
Funkcja zapisująca treść zgłoszenia.
*/
function SaveNotificationText($ConnectToDataBase, $NotificationID)
{
    $Status = false;
  
    if(!($ConnectToDataBase->connect_error))
    {
        if($ConnectToDataBase->query("INSERT INTO notifications_text set title='".$GLOBALS['p4']."', text='".$GLOBALS['p5']."', ID_Notification='".$NotificationID."';"))
        {
            $Status = true;
        }
    }

    return $Status;
}

if($ConnectToDataBase = new mysqli($host, $db_user, $db_password, $db_name))
{
    if($IDT = SaveNotification($ConnectToDataBase, $User_ID))
    {
        if(SaveNotificationDetail($ConnectToDataBase, $User_ID, $IDT))
        {
            if(SaveNotificationText($ConnectToDataBase, $IDT))
            {
                $Code .= "Pomyślnie zarejestrowano zgłoszenie o numerze ".$IDT.".";
            } else {
                $Code .= "Błąd krytyczny L3: Nie można zarejestrować szczegółów zgłoszenia!";
            }
        } else {
            $Code .= "Błąd krytyczny L2: Nie można zarejestrować szczegółów zgłoszenia!";
        }
    } else {
        $Code .= "Błąd: Nie można zarejestrować zgłoszenia w bazie danych!";
    }
    $ConnectToDataBase->close();
} else {
    $Code .= "Błąd: Nie można nawiązać połączenia z bazą danych!";
}

echo $Code;

?>