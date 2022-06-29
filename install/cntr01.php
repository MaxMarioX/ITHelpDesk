<?php
//Sprawdza czy można nawiązać połączenie z bazą danych z użyciem użytkownika z uprawnieniami administratora
session_start();

$dHost = $_POST['dhost'];
$dUser = $_POST['dUser'];
$dPassword = $_POST['dPassword'];

function CheckConnection($Host, $User, $Password)
{
	$_ConnectStatus;

	if(!((empty($Host)) || (empty($User)) || (empty($Password))))
	{
		if(@$_myConnect = mysqli_connect($Host,$User,$Password))
		{
				//Jeżeli się uda zapisujem te dane w zmiennych globalnych serwera
				$_SESSION['admHost'] = $Host;
				$_SESSION['admUser'] = $User;
				$_SESSION['admPassword'] = $Password;
				
				//Zapisujemy sukces
				$_ConnectStatus = '0';
		}
		else{
				//Błąd: Podany użytkownik w systemie nie istnieje.
				$_ConnectStatus = '2';
		}
	}
	else{
		//Błąd: Nie wypełniono wszystkich pól
		$_ConnectStatus = '1';
	}
	
	return $_ConnectStatus;
}
exit(CheckConnection($dHost, $dUser, $dPassword));

?>