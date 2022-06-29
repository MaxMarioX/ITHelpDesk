<?php
/*
Rejestruje zmiany dokonane na zgłoszeniu
*/

function SaveLog($Connect, $Message, $IdAccount, $IdNotification){
    $Status = true;

    $MyDate = getdate();
    $Day = $MyDate['mday'];
    $Month = $MyDate['mon'];
    $Year = $MyDate['year'];

    $Hour = $MyDate['hours'];
    $Minutes = $MyDate['minutes'];
    $Seconds = $MyDate['seconds'];

    $Today = $Year."-".$Month."-".$Day;
    $Time = $Hour.":".$Minutes.":".$Seconds;


    if(!($Connect->query("INSERT INTO notifications_msg set text='".$Message."', date='".$Today."', time='".$Time."', ID_ACCOUNT='".$IdAccount."', ID_Notification='".$IdNotification."';")))
        $Status = false;
    
    return $Status; 
}
?>