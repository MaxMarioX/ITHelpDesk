<?php
/*
Wyświetla zawartość zgłoszenia i umożliwia wykonanie pewnych operacji w zależności czy
użytkownik jest właścicielem zgłoszenia czy nie.

Uwaga: Ktoś kto nie jest właścicielem zgłoszenia, nie może wprowadzać żadnych modyfikacji 
*/
session_start();

//Przechowuje numer zgłoszenia
$TicketID = $_POST['TicketID'];
//Informacja kto obecnie jest zalogowany
$IdAccount = $_SESSION['IdAccount'];
//Informacja czy i jakie wyświetlać dodatkowe buttony do nawigacji strony
$Flags = $_POST['Flags'];

$TicketFree ='';//Czy zgłoszenie zostało przejęte czy nie
$Owner = '';    //Czy użytkownik jest właścicielem zgłoszenia
$Status;        //Informacja czy zgłoszenie jest otwarte czy zamknięte
$UserDataOwner; //Użytkownik, który zarejestrował zgłoszenie w systemie
$User;          //Imię i Nazwisko osoby, która zgłosiła problem
$Company;       //Firma / oddział, w którym przebywa osoba potrzebująca pomocy
$Program;       //Kategoria problemu
$TimeReg;       //Czas zarejestrowania zgłoszenia
$DateReg;       //Data zarejestrowania zgłoszenia
$DateClose;     //Data zamknięcia zgłoszenia
$UserR;         //Użytkownik, który zarejestrował zgłoszenie
$Title;         //Tytuł zgłoszenia
$Text;          //Treść zgłoszenia
$ErrMsg;        //Treść komunikatu z błędem
$code;          //Kod html do wyświetlania

//Sprawdza czy użytkownik jest właścicielem zgłoszenia i czy zgłoszenie zostało już przejęte
function AmIOwner()
{
    $error = false;

    $ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);

    if(!($ConnectToDataBase->connect_error))
    {
        $ConnStatus = $ConnectToDataBase->query("SELECT ID_ACCOUNT, free from notifications where ID_Notification='".$GLOBALS['TicketID']."';");
        
        if(mysqli_num_rows($ConnStatus))
        {
            $InfDataRow = mysqli_fetch_array($ConnStatus);
            
            //Sprawdzanie czy użytkownik jest właścicielem zgłoszenia
            if($GLOBALS['IdAccount'] == $InfDataRow['ID_ACCOUNT']){
                $GLOBALS['Owner'] = true;
            }
            //Sprawdzanie czy zgłoszenie zostało przejęte
            if($InfDataRow['free'] == 1){
                $GLOBALS['TicketFree'] = true;
            } else {
                $GLOBALS['TicketFree'] = false;
            }
            
        } else {
            $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
            $error = true;
        }      
        
        $ConnectToDataBase->close();
    } else {
        $GLOBALS['ErrMsg'] = "Błąd: Nie można nawiązać połączenia z bazą danych!";
        $error = true;
    }
    return $error;
}

//Pobiera dane o zgłoszeniu z bazy danych 
function GetDataFromDataBase($ConnectToDataBase)
{
    $error = false;
   
        $ConnStatus = $ConnectToDataBase->query("SELECT * from notifications where ID_Notification='".$GLOBALS['TicketID']."';");

        if(mysqli_num_rows($ConnStatus))  
        {
            while($DataRow = mysqli_fetch_array($ConnStatus))  
            {
                //Krok 1
                if($DataRow['closed']){
                    $GLOBALS['Status'] = 'Zamknięte';
                }else{
                    $GLOBALS['Status'] = 'Otwarte';
                }

                //Krok 2
                $InfTxt = $ConnectToDataBase->query("SELECT title, text from notifications_text where ID_Notification='".$DataRow['ID_Notification']."';");
                if(mysqli_num_rows($InfTxt))
                {
                    $InfTxtDataRow = mysqli_fetch_array($InfTxt);
                    
                    $GLOBALS['Title'] = $InfTxtDataRow['title'];
                    $GLOBALS['Text'] = $InfTxtDataRow['text'];

                } else {
                    $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
                    return $error = true;
                }               

                //Krok 3
                $InfAcc = $ConnectToDataBase->query("SELECT * from owners where ID_Account='".$DataRow['ID_ACCOUNT_REG']."';");
                if(mysqli_num_rows($InfAcc))
                {
                    $InfAccDataRow = mysqli_fetch_array($InfAcc);
                    
                    $GLOBALS['UserDataOwner'] = $InfAccDataRow['name']." ".$InfAccDataRow['surname'];

                } else {
                    $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
                    return $error = true;
                }
                //Krok 4
                $InfDet = $ConnectToDataBase->query("SELECT * from notifications_detail where ID_Notification='".$GLOBALS['TicketID']."';");
                if(mysqli_num_rows($InfDet))
                {
                    $InfDetDataRow = mysqli_fetch_array($InfDet);
                   
                    $GLOBALS['User'] = $InfDetDataRow['user'];
                    $GLOBALS['Company'] = $InfDetDataRow['company'];
                    $GLOBALS['Program'] = $InfDetDataRow['system'];
                    $GLOBALS['TimeReg'] = $InfDetDataRow['time'];
                    $GLOBALS['DateReg'] = $InfDetDataRow['date'];

                    if($DataRow['closed']){
                        $GLOBALS['DateClose'] = $InfDetDataRow['date_end'];
        
                        $InfAccEnd = $ConnectToDataBase->query("SELECT * from owners where ID_Account='".$InfDetDataRow['acc_end']."';");
                        if(mysqli_num_rows($InfAccEnd))
                        {
                            $InfAccDataRow = mysqli_fetch_array($InfAccEnd);
                            
                            $GLOBALS['UserC'] = $InfAccDataRow['name']." ".$InfAccDataRow['surname'];

                        } else {
                            $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
                            return $error = true;
                        }                     
                    } else {
                        $GLOBALS['DateClose'] = "";
                        $GLOBALS['UserC'] = "";
                    }   
                } else {
                    $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
                    return $error = true;
                }
            }            
        } else {
            $GLOBALS['ErrMsg'] = "Błąd: Nie można pobrać informacji o zgłoszeniu z bazy danych!";
            return $error = true;
        }
}
//Funkcja generująca kod HTML
function GenerateCode()
{
$GLOBALS['code'] = '
<div class="TicketTitle">
<p>Szczegóły zgłoszenia numer '.$GLOBALS['TicketID'].'</p>
</div>
<div class="TicketDetails">
    <div class="TableA">
        <table id="TicketInfo">
            <tr><td id="col1">Status</td><td id="col2">'.$GLOBALS['Status'].'</td></tr>
            <tr><td id="col1">Zarejestrował</td><td id="col2">'.$GLOBALS['UserDataOwner'].'</td></tr>
            <tr><td id="col1">Zgłosił</td><td id="col2">'.$GLOBALS['User'].'</td></tr>
            <tr><td id="col1">Odział/Firma</td><td id="col2">'.$GLOBALS['Company'].'</td></tr>
            <tr><td id="col1">Program</td><td id="col2">'.$GLOBALS['Program'].'</td></tr>
            <tr><td id="col1">Data rejestracji</td><td id="col2">'.$GLOBALS['DateReg'].'</td></tr>
            <tr><td id="col1">Czas rejestracji</td><td id="col2">'.$GLOBALS['TimeReg'].'</td></tr>
            ';
            if($GLOBALS['DateClose'] != ""){
                $GLOBALS['code'].='<tr><td id="col1">Data zamknięcia</td><td id="col2">'.$GLOBALS['DateClose'].'</td></tr>';
            }
            if($GLOBALS['UserC'] != ""){       
                $GLOBALS['code'].='<tr><td id="col1">Zamknął</td><td id="col2">'.$GLOBALS['UserC'].'</td></tr>';
            }

        $GLOBALS['code'] .='
        </table>
    </div>
    <div class="TableB">
    <p><strong>'.$GLOBALS['Title'].'</strong></p>
    <p>'.$GLOBALS['Text'].'</p>
    </div>
</div>
<div class="TicketButtonPanel">
';
if($GLOBALS['Flags'] == "1")
{
    //Zgłoszenie nie zostało przejęte
    if($GLOBALS['TicketFree'] == 1)
    {
        $GLOBALS['code'] .= '
        <input type="button" name="TakeTicketButton" id="tButton" onclick="TakeTicket(\''.$GLOBALS['TicketID'].'\',\''.$GLOBALS['IdAccount'].'\')" value="Przejmij"/>
        <input type="button" name="AssignTicketButton" id="aButton" onclick="AssignTicket(\''.$GLOBALS['TicketID'].'\',\''.$GLOBALS['IdAccount'].'\')" value="Przypisz"/>
        ';
        
    }
    //Zgłoszenie zostało przejęte i jesteśmy właścicielem zgłoszenia
    else if(($GLOBALS['TicketFree'] == 0) && ($GLOBALS['Owner'] == 1)){
        $GLOBALS['code'] .= '
        <input type="button" name="CloseWindowButton" id="wButton" onclick="CloseTicket('.$GLOBALS['TicketID'].')" value="Zamknij"/>
        <input type="button" name="AssignTicketButton" id="aButton" onclick="AssignTicket(\''.$GLOBALS['TicketID'].'\',\''.$GLOBALS['IdAccount'].'\')" value="Przypisz"/>
        <input type="button" name="HistoryTicketButton" id="hButton" onclick="TicketHistory(\''.$GLOBALS['TicketID'].'\','.$GLOBALS['Flags'].')" value="Historia"/>
        ';
        
    }
    //Zgłoszenie zostało przejęte i nie jesteśmy właścicielem zgłoszenia
    else if(($GLOBALS['TicketFree'] == 0) && ($GLOBALS['Owner'] == 0)){
        $GLOBALS['code'] .= '
        <input type="button" name="HistoryTicketButton" id="hButton" onclick="TicketHistory(\''.$GLOBALS['TicketID'].'\')" value="Historia"/>
        ';
    }

    //Przycisk niezależny od powyższych warunków
    $GLOBALS['code'] .= '
        <input type="button" name="CloseWindowButton" id="cButton" onclick="CloseWindow(\'.InfoBox\',1)" value="Wyjdź"/>
    </div>';
}
else if($GLOBALS['Flags'] == "2")
{
    //Przycisk powrotu do listy zgłoszeń przypisanych tylko konkretnemu użytkownikowi
    $GLOBALS['code'] .= '
    <input type="button" name="CloseWindowButton" id="wButton" onclick="CloseTicket('.$GLOBALS['TicketID'].')" value="Zamknij"/>
    <input type="button" name="AssignTicketButton" id="aButton" onclick="AssignTicket(\''.$GLOBALS['TicketID'].'\',\''.$GLOBALS['IdAccount'].'\')" value="Przypisz"/>
    <input type="button" name="HistoryTicketButton" id="hButton" onclick="TicketHistory(\''.$GLOBALS['TicketID'].'\','.$GLOBALS['Flags'].')" value="Historia"/>
    <input type="button" name="ComeBackButton" id="cmbButton" onclick="ShowMyTickets()" value="Wróć"/>
    </div>';
}
else {

}
}
//Sprawdzanie czy użytkownik jest właścicielem zgłoszenia
if(!AmIOwner())
{
    //Pozyskiwanie informacji o zgłoszeniu i generowanie kody HTML
    $ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);

    if(!($ConnectToDataBase->connect_error))
    {
        if(!GetDataFromDataBase($ConnectToDataBase))
        {
            $ConnectToDataBase->Close();
            GenerateCode();
        } else {
            $code = $ErrMsg;
        }
    } else {
        $ErrMsg = "Błąd: Nie można nawiązać połączenia z bazą danych!";
        $code = $ErrMsg;
    }
} else {
    $code = $ErrMsg;
}
?>