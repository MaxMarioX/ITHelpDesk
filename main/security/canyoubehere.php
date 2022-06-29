<?php
/*
CanYouBeHere.php - sprawdzanie czy wejście do panelu jest legalne
*/

function CheckEnter()
{
//Zmienna przechowująca wynik sprawdzania prawa użytkownika do pobytu tutaj
$CanIBeHere = false;

//Sprawdzenie użytkownika
if(isset($_SESSION['UserStatus'])){
	if($_SESSION['UserStatus'] == true){
		$CanIBeHere = true;
	}
}

return $CanIBeHere;	
}

?>