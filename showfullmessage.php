<?php
/*
Wyświetla pełną treść wiadomości do zgłoszenia
*/
session_start();

require_once('install/netcnf/data_connect.php');

//Zapisuje numer treści
$MsgID = $_POST['MsgNumber'];
//Zapisuje treść wiadomości
$code2; 

function GetDataFromDataBase()
{
    $error = false;

    $ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);
    
    if(!($ConnectToDataBase->connect_error))
    {
        $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications_msg where ID_Notification_msg='".$GLOBALS['MsgID']."';");

        if(mysqli_num_rows($ConnStatus))  
        {
            $DataRow = mysqli_fetch_array($ConnStatus);
            $GLOBALS['code2'] .= $DataRow['text'];
        } else {
            $GLOBALS['code2'] = "Błąd: Nie można pobrać pełnej treści wiadomości z bazy danych!";
            $error = true;
        }
    } else {
        $GLOBALS['code2'] = "Błąd: Nie można nawiązać połączenia z bazą danych!";
        $error = true;
    }
    $ConnectToDataBase->close();
    return $error;
}
function GenerateCodes()
{
    $GLOBALS['code2'] = '
    <textarea readonly>';
    GetDataFromDataBase();
    $GLOBALS['code2'] .= '
    </textarea>
    ';
}
GenerateCodes();
echo $code2;

?>