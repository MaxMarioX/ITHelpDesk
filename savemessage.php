<?php
//Zapisuje wiadomość do bazy danych

session_start();

require_once('install/netcnf/data_connect.php');
require_once('main/Log.php');

//Przechowuje numer zgłoszenia
$TicketID = $_POST['TicketNumber'];

//Przechowuje tekst zgłoszenie
$Msg = $_POST['Message'];

//Informacja kto obecnie jest zalogowany
$IdAccount = $_SESSION['IdAccount'];

//Zapisuje komunikat
$ErrMsg;

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(SaveLog($ConnectToDataBase, $Msg, $IdAccount, $TicketID))
{
    $ErrMsg = "Wiadomość została zapisana!";
} else {
    $ErrMsg = "Błąd: Nie udało się zapisać wiadomości!";
}

$ConnectToDataBase->close();

exit($ErrMsg);

?>