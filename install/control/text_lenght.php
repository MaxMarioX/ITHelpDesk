<?php
//text_lenght.php - funkcja sprawdzająca długość wpisanego przez użytkownika tekstu

function TextLenght($TextField, $MaxChar, $Mode)
{

$TextStatus = true;

if($Mode == "MAX"){
	if((strlen($TextField)) > $MaxChar)
		$TextStatus = false;
}
if($Mode == "MIN"){
	if((strlen($TextField)) < $MaxChar)
		$TextStatus = false;
}

return $TextStatus;
}

?>