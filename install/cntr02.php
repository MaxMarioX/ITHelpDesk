<?php
//Sprawdza poprawność danych
session_start();

$dHost = $_POST['dhost_b'];
$dUser = $_POST['dUser_b'];
$dPassword = $_POST['dPassword_b'];
$dPassword2 = $_POST['dPassword_c'];
$dDataBaseName = $_POST['dDataBaseName'];

require_once('control/text_lenght.php');
require_once('control/text_ascii.php');

function CheckDataFields($Host, $User, $Password, $Password2, $DataBaseName)
{
	$_mStat = '0';

	if(!((empty($Host)) || (empty($User)) || (empty($Password)) || (empty($Password2)) ||(empty($DataBaseName))))
	{
		if(!((TextLenght($Host,'20',"MAX")) && (TextLenght($Host,'3',"MIN")) && (TextAscii($Host))))
		{			
				//Błąd: Pole host zawiera za krótką lub za długą nazwę
				$_mStat = '2';
        }
		else if(!((TextLenght($User,'20',"MAX")) && (TextLenght($User,'3',"MIN")) && (TextAscii($User))))
		{			
				//Błąd: Pole user zawiera za krótką lub za długą nazwę
				$_mStat = '4';
        }
		else if(!((TextLenght($Password,'20',"MAX")) && (TextLenght($Password,'3',"MIN"))))
		{			
				//Błąd: Pole password zawiera za krótką lub za długą nazwę
				$_mStat = '5';
        }
		else if(!($Password == $Password2))
		{			
				//Błąd: Hasła różnią się
				$_mStat = '6';
        }
		else if(!((TextLenght($DataBaseName,'20',"MAX")) && (TextLenght($DataBaseName,'3',"MIN")) && (TextAscii($DataBaseName))))
		{			
				//Błąd: Pole database zawiera za krótką lub za długą nazwę
				$_mStat = '7';
		}
		else {
				//Jeżeli się uda zapisujem te dane w zmiennych globalnych serwera
				$_SESSION['dbHost'] = $Host;
				$_SESSION['dbUser'] = $User;
				$_SESSION['dbPassword'] = $Password;	
				$_SESSION['dbDataBaseName']	= $DataBaseName;	
		}
	}
	else{
		//Błąd: Nie wypełniono wszystkich pól
		$_mStat = '1';
	}
	
	return $_mStat;
}

exit(CheckDataFields($dHost, $dUser, $dPassword, $dPassword2, $dDataBaseName));

?>