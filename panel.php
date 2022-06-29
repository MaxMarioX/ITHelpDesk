<?php
//Rozpoczęcie sesji
@session_start();

//Funkcja sprawdzająca czy dostęp do panelu jest legalny
require_once('main/security/canyoubehere.php');

if(CheckEnter())
{
    require_once('main/dashboard/panel.php');
}
else{
	echo '<script type="text/javascript">alert(\'Dostęp do panelu zabroniony!\');</script>';
	exit();
}


?>