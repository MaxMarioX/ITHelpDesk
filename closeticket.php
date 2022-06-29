<?php

require_once('install/netcnf/data_connect.php');

$TicketNumber = $_POST['TicketNumber'];

$ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

if(!($ConnectToDataBase->connect_error))
{
    $ConnStatus = $ConnectToDataBase->query("UPDATE notifications set closed=1 where ID_Notification='".$TicketNumber."';");

	if($ConnStatus)
	{
        exit("1");
    } else {
        exit("0");
    }
} else {

}
?>