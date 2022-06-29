<?php

session_start();

$nLogin = $_POST['login'];
$nPassword = $_POST['password'];
$error_message;

require_once('install\netcnf\data_connect.php');

function AccountBL($CnDB, $ID)
{
    $IdPr = $CnDB->query("SELECT * from privileges WHERE id_privileges='".$ID."';");
    $DataRow = mysqli_fetch_array($IdPr);
    if($DataRow['b0'])
    {
        return false;
    } else {
        return true;
    }
}

function GetDataFromDataBase()
{
//Nawiązanie połączenia z serwerem bazodanowym
$ConnectToDataBase = new mysqli($GLOBALS['host'],$GLOBALS['db_user'],$GLOBALS['db_password'],$GLOBALS['db_name']);

//Jeśli udało się nawiązać połączenie z serwerem bazodanowym...
if(!($ConnectToDataBase->connect_error))
{
    //...sprawdzenie czy istnieje użytkownik w bazie
    $ConnStatus = $ConnectToDataBase->query(sprintf("SELECT * from accounts WHERE login='%s'", mysqli_real_escape_string($ConnectToDataBase,$GLOBALS['nLogin'])));
    //Sprawdzenie ile krotek zwróciło zapytanie (zawsze zwróci 1)
	if(mysqli_num_rows($ConnStatus))  
	{       
		//Pobranie zawartości tablicy
        $DataRow = mysqli_fetch_array($ConnStatus);
        
        //Sprawdzamy czu użytkownik nie jest zablokowany
        //Jeśli nie jest zablokowany, sprawdzamy czy podał poprawne hasło
        if(AccountBL($ConnectToDataBase, $DataRow['ID_ACCOUNT']))
        {
            //Sprawdzenie czy użytkownik podał poprawne hasło
            if(password_verify($GLOBALS['nPassword'], $DataRow['password']))
            {
                //Jeżeli jest poprawne, fakt ten zostaje odnotowany w pamięci serwera
                $_SESSION['UserStatus'] = true;
                $_SESSION['IdAccount'] = $DataRow['ID_ACCOUNT'];
                $ConnectToDataBase->close();
                return true;
            } else {
                $GLOBALS['error_message'] = "Niepoprawne hasło!";
                $ConnectToDataBase->close();
                return false;
            }
        } else {
            $GLOBALS['error_message'] = "Użytkownik ".$DataRow['login']." jest zablokowany!";
            $ConnectToDataBase->close();
            return false;
        }

	} else{
        $GLOBALS['error_message'] = "Użytkownik o podanej nazwie nie istnieje!";
        return false;       
    }
} else {
    $GLOBALS['error_message'] = "Nie można nawiązać połączenia z serwerem bazy danych!";
    return false;
}
}

if(GetDataFromDataBase()){
    exit("#UserLoginSuccess");
} else {
    exit($error_message);
}
?>