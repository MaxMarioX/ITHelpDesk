<?php
//Sprawdza poprawność danych
session_start();

$dAdminAccount = $_POST['dAdminAcc'];
$dAdminPasswd = $_POST['dAdminPasswd'];
$dAdminPasswd2 = $_POST['dAdminPasswd2'];

require_once('control/text_lenght.php');
require_once('control/text_ascii.php');

function CheckDataFields($AdminAccount, $AdminPasswd, $AdminPasswd2)
{
	$_mStat = '0';

	if(!((empty($AdminAccount)) || (empty($AdminPasswd)) || (empty($AdminPasswd2)) ))
	{
		if(!((TextLenght($AdminAccount,'20',"MAX")) && (TextLenght($AdminAccount,'3',"MIN")) && (TextAscii($AdminAccount))))
		{			
				//Błąd: Pole Nazwa konta zawiera za krótką lub za długą nazwę
				$_mStat = '2';
        }
		else if(!((TextLenght($AdminPasswd,'20',"MAX")) && (TextLenght($AdminPasswd,'3',"MIN"))))
		{			
				//Błąd: Pole Password zawiera za krótką lub za długą nazwę
				$_mStat = '3';
        }
		else if(!($AdminPasswd == $AdminPasswd2))
		{			
				//Błąd: Hasła różnią się
				$_mStat = '4';
        }
		else {
				//Jeżeli się uda zapisujem te dane w zmiennych globalnych serwera
				$_SESSION['AdminAccount'] = $AdminAccount;
				$_SESSION['AdminPassword'] = $AdminPasswd;	
		}
	}
	else{
		//Błąd: Nie wypełniono wszystkich pól
		$_mStat = '1';
	}
	
	return $_mStat;
}

exit(CheckDataFields($dAdminAccount, $dAdminPasswd, $dAdminPasswd2));

?>