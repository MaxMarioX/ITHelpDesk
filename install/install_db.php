<?php

//install_db.php - instalacja bazy danych

session_start();

//Dane do pliku konfiguracyjnego database_connect.php
$Config_file = "<?php\n\$host = '".$_SESSION['dbHost']."';\n\$db_user = '".$_SESSION['dbUser']."';\n\$db_password = '".$_SESSION['dbPassword']."';\n\$db_name = '".$_SESSION['dbDataBaseName']."';\n?>";
//Polecenie sql tworzące bazę danych z kodowaniem utf8 
$CreateDatabase = "CREATE DATABASE ".$_SESSION['dbDataBaseName']." CHARACTER SET utf8 COLLATE utf8_polish_ci ;";
//Szyfrowanie hasła
$_uSecurityPass = password_hash($_SESSION['AdminPassword'], PASSWORD_DEFAULT);
//Pobranie aktualnej daty i czasu
$MyDate = getdate();
$Day = $MyDate['mday'];
$Month = $MyDate['mon'];
$Year = $MyDate['year'];

$Hour = $MyDate['hours'];
$Minutes = $MyDate['minutes'];
$Seconds = $MyDate['seconds'];

$Today = $Year."-".$Month."-".$Day;
$Time = $Hour.":".$Minutes.":".$Seconds;

//Polecenie sql dodające nowego użytkownika(administratora) do bazy danych
$userAdmin = $_SESSION['AdminAccount'];
$AddNewUser = "INSERT INTO Accounts set login='".$userAdmin."', password='".$_uSecurityPass."', date='".$Today."';";
//Polecenie sql dodające informacje o użytkowniku do bazy danych
$AddNewOwner = "INSERT INTO Owners set name='Admin', surname='Admin', email='admin@admin.pl', ID_ACCOUNT=1;";
//Polecenie sql dodające uprawnienia użytkownika do bazy danych
$AddNewPrivileges = "INSERT INTO Privileges set w0=b'1', r0=b'1', m0=b'1', a0=b'1', b0=b'0', ID_ACCOUNT=1;";
//Polecenie sql (1) zostawiające zgłoszenie powitalne
$AddNewNotifications = "INSERT INTO Notifications set closed=b'0', free=b'1', ID_ACCOUNT_REG=1, ID_ACCOUNT=1";
//Polecenie sql (2)zostawiające zgłoszenie powitalne
$AddNewNotificationsText = "INSERT INTO Notifications_Text set title='Instalacja programu', text='Program został zainstalowany pomyślnie!', ID_Notification=1;";
//Polecenie sql wprowadzające detale do powyższego zgłoszenia powitalnego
$AddNewNotificationsDetail = "INSERT INTO Notifications_Detail set user='System', date='".$Today."', time='".$Time."', ID_Notification=1;";

//Polecenia sql tworzące strukturę w bazie danych
require_once('database_structure/Accounts.php');
require_once('database_structure/Privileges.php');
require_once('database_structure/Owners.php');
require_once('database_structure/Notifications.php');
require_once('database_structure/Notifications_detail.php');
require_once('database_structure/Notifications_Text.php');
require_once('database_structure/Notifications_messages.php');

$error_messages;

function CreateStructure()
{
$error = false;

//Nawiązanie połączenia z serwerem bazodanowym na prawach administratora
$ConnectToAdminAccount = new mysqli($_SESSION['admHost'],$_SESSION['admUser'],$_SESSION['admPassword']);

//Jeżeli połączenie powiodło się...
if(!($ConnectToAdminAccount->connect_error)){
    //Utwórz bazę danych, następnie...
	if($ConnectToAdminAccount->query($GLOBALS['CreateDatabase'])){
		//Zaznaczenie bazy
		$ConnectToAdminAccount->select_db($_SESSION['dbDataBaseName']);
			//Utworzenie tabeli Accounts
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_accounts']))
			{
				//Dodawanie użytkownika do bazy danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewUser'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error;	
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}  
			//Utworzenie tabeli Owners
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_owners']))
			{
				//Dodawanie danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewOwner'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error; 
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
			//Utworzenie tabeli Privileges
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_privileges']))
			{
				//Dodawanie danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewPrivileges'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error;
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
			//Utworzenie tabeli Notifications
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_notifications']))
			{
				//Dodawanie danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewNotifications'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error;
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
			//Utworzenie tabeli Notifications_detail
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_notifications_detail']))
			{
				//Dodawanie danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewNotificationsDetail'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error;
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
			//Utworzenie tabeli Notifications_Text
			if($ConnectToAdminAccount->query($GLOBALS['CreateTable_notifications_text']))
			{
				//Dodawanie danych
				if(!($ConnectToAdminAccount->query($GLOBALS['AddNewNotificationsText'])))
				{
					$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
					return $error;
				}
			}else{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
			//Utworzenie tabeli Notifications_messages
			if(!($ConnectToAdminAccount->query($GLOBALS['CreateTable_notifications_msg'])))
			{
				$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
				return $error;
			}
    }else{
		$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
		return $error;
	}
	$ConnectToAdminAccount->close();
	session_unset();
	return $error = true;
}else{
	$GLOBALS['error_messages'] = "Błąd: ".$ConnectToAdminAccount->connect_error;
	return $error;
}
}

function CreateConfigFile()
{
	//Utworzenie pliku konfiguracyjnego			
	if($ConfigFile = fopen("netcnf/data_connect.php","w")){
		fputs($ConfigFile,$GLOBALS['Config_file']);
		fclose($ConfigFile);
		return true;
	}else{
		$GLOBALS['error_messages'] = "Błąd: Nie można utworzyć pliku konfiguracyjnego";
		return false;
	}
}

function InstallApp()
{
	$error = true;

	if(CreateStructure()){
		if(!CreateConfigFile())
			$error = false;
	} else {
		$error = false;
	}

	return $error;
}

if(InstallApp()) {
	$error_messages = "Instalacja zakończona sukcesem!";
	echo $error_messages;
} else {
	echo $error_messages;
}