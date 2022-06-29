<?php
/*
Umożliwia wpisanie wiadomości/komentarza do zgłoszenia oraz wyświetla komentarze przypisane do danego zgłoszenia
*/
session_start();

require_once('install/netcnf/data_connect.php');

//Przechowuje numer zgłoszenia
$TicketID = $_POST['TicketNumber'];
//Przechowuje numer flagi
$Flags = $_POST['Flags'];
//Informacja kto obecnie jest zalogowany
$IdAccount = $_SESSION['IdAccount'];

$IDmsg;         //Numer ID wiadomości
$Text;          //Treść wiadomości
$Date;          //Data utworzenia wiadomości
$Time;          //Czas utworzenia wiadomości

//Kod html do wyświetlania
$code2 = '';

//Sprawdza czy użytkownik jest właścicielem zgłoszenia i czy tym samym ma prawo zostawić wiadomość/komentarz do zgłoszenia
function AmIOwner()
{
    $error = false;

    $ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);

    if(!($ConnectToDataBase->connect_error))
    {
        $ConnStatus = $ConnectToDataBase->query("SELECT ID_ACCOUNT from notifications where ID_Notification='".$GLOBALS['TicketID']."';");
        
        if(mysqli_num_rows($ConnStatus))
        {
            $InfDataRow = mysqli_fetch_array($ConnStatus);

            if($GLOBALS['IdAccount'] == $InfDataRow['ID_ACCOUNT']){
                $error = true;
            }
            
        } else {
            $GLOBALS['code2'] .= "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
            $error = true;
        }      

    } else {
        $GLOBALS['code2'] .= "Błąd: Nie można nawiązać połączenia z bazą danych!";
        $error = true;
    }
    $ConnectToDataBase->close();
    return $error;
}

//Pobiera dane o zgłoszeniu z bazy danych 
function GetDataFromDataBase()
{
    $error = false;
    $ptr = 1;

    $ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);
    
    if(!($ConnectToDataBase->connect_error))
    {
        $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications_msg where ID_Notification='".$GLOBALS['TicketID']."' ORDER BY ID_Notification_msg DESC;");

        if(mysqli_num_rows($ConnStatus))  
        {
            while($DataRow = mysqli_fetch_array($ConnStatus))  
            {
                $GLOBALS['code2'] .= '<tr onclick="GetHInformation('.$DataRow['ID_Notification_msg'].')"><td><b>'.$DataRow['date'].' '.$DataRow['time'].'</b><br/>'.substr($DataRow['text'],0,60).'...</td></tr>';
                $ptr++;
            }            
        } else {
            $GLOBALS['code2'] .= "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
            return $error = true;
        }
        

    } else {
        $GLOBALS['code2'] .= "Błąd: Nie można nawiązać połączenia z bazą danych!";
        return $error = true;
    }
    $ConnectToDataBase->close();
}

//Funkcja generująca kod HTML
function GenerateCodes()
{
    $GLOBALS['code2'] = '
    <div class="TicketTitle">
        <p>Historia zgłoszenia nr '.$GLOBALS['TicketID'].'</p>
    </div>
    <div class="TicketHistory">
        <div class="MessagesList">
            <table class="HistoryList">
        ';
        GetDataFromDataBase();
        $GLOBALS['code2'] .= '
            </table>
        </div>
        <div class="MyMessage">

        </div>
    </div>
    ';

    $GLOBALS['code2'] .= '
        <div class="TicketButtonPanel">
        <input type="button" name="HistoryTicketButton" id="hButton" onclick="TicketHistoryBack('.$GLOBALS['TicketID'].','.$GLOBALS['Flags'].')" value="Wróć"/>
        ';
    if(AmIOwner())
    {
        $GLOBALS['code2'] .= '
            <input type="button" name="MessageTicketButton" id="mButton" onclick="NewMessage(\''.$GLOBALS['TicketID'].'\')" value="Nowa wiadomość"/>
            <input type="button" name="MessageTicketButton" id="sButton" onclick="SaveMessage(\''.$GLOBALS['TicketID'].'\')" value="Zapisz"/>
            <input type="button" name="MessageTicketButton" id="clButton" onclick="CleanMessage()" value="Wyczyść"/>
            <input type="button" name="MessageTicketButton" id="nButton" onclick="NoMessage()" value="Anuluj"/>
            </div>
        ';
    }
}

if(!GetDataFromDataBase())
   GenerateCodes();

echo $code2;
?>