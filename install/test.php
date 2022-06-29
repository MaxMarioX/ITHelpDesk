<?php
$AddNewUser = "INSERT INTO Accounts set login='MM00', password='MM', date='2017-06-23'";
//$AddNewOwner = "INSERT INTO Owners set name='Admin', surname='Admin', e-mail='adminadmin.pl', ID_ACCOUNT=1";
$AddNewOwner = "INSERT INTO Privileges set w0=b'1', r0=b'1', m0=b'1', a0=b'1', ID_ACCOUNT=1;";
//Nawiązanie połączenia z serwerem bazodanowym na prawach administratora
$ConnectToAdminAccount = mysqli_connect('localhost','Mariusz','9vgf');

if($ConnectToAdminAccount){
		//Zaznaczenie bazy
        mysqli_select_db($ConnectToAdminAccount,'mybase');
			//Utworzenie tabeli Accounts
				//Dodawanie użytkownika do bazy danych
				if(!(mysqli_query($ConnectToAdminAccount,$AddNewOwner)))
				{
                   // return $error_messages = "Błąd: ".mysqli_error($ConnectToAdminAccount);	
				}
    mysqli_close($ConnectToAdminAccount);
    return $error_messages = "Sukces";
}else{
	return $error_messages = "Błąd:".mysqli_error($ConnectToAdminAccount);
}
?>