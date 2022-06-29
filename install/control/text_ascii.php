<?php
//text_ascii_pl.php - sprawdza czy nie podano znaków potencjalnie niebezpiecznych (wersja z polskimi znakami)

function TextAscii($TextField)
{
	$TextStatus = false;
	
	if((preg_match("/^[a-zA-Z0-9]+$/",$TextField)) == 1)
		$TextStatus = true;
	
	return $TextStatus;
}
?>