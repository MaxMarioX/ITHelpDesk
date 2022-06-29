<?php
//Umożliwia wpisanie nowej wiadomości do zgłoszenia

session_start();

require_once('install/netcnf/data_connect.php');

//Przechowuje numer zgłoszenia
$TicketID = $_POST['TicketNumber'];

//Informacja kto obecnie jest zalogowany
$IdAccount = $_SESSION['IdAccount'];

//Kod html do wyświetlania
$code = '';

function GenerateCodes()
{
    $GLOBALS['code'] = '
    <textarea id="mTextArea" placeholder="Wpisz wiadomość..."></textarea>
    ';
}
GenerateCodes();
echo $code;
?>