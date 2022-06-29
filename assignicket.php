<?php
session_start();
require_once('install/netcnf/data_connect.php');

$TicketID = $_POST['TicketNumber'];
$User = $_POST['User'];

$code = '

<table id="AssignTicket">
   <th id="Assigncol1">Login</th><th id="Assigncol2">Imię i Nazwisko</th>

    ';
    $ConnectToDataBase = new mysqli($host,$db_user,$db_password,$db_name);

    if(!($ConnectToDataBase->connect_error))
    {
        $ConnStatus = $ConnectToDataBase->query("SELECT ID_ACCOUNT, login from accounts where ID_ACCOUNT <> '".$User."';");
    
        if(mysqli_num_rows($ConnStatus))  
        {
            while($DataRow = mysqli_fetch_array($ConnStatus))  
            {
                $accID = $DataRow['ID_ACCOUNT'];
                $accLogin = $DataRow['login'];
    
                $ConnStatusDetail = $ConnectToDataBase->query("SELECT name, surname from owners where ID_ACCOUNT='".$accID."';");
                $DataRowDetail = mysqli_fetch_array($ConnStatusDetail);
                $accname = $DataRowDetail['name'];
                $accsurname = $DataRowDetail['surname'];
    
                $code .= '
                <tr onmouseover="ovStyle(this)" onmouseout="ouStyle(this)" onclick="TakeTicket(\''.$TicketID.'\',\''.$accID.'\')">
                <td>'.$accLogin.'</td><td>'.$accname.' '.$accsurname.'</td>
                </tr>
                ';
            }
        } else {
    
        }
    } else {
    
    }
    $ConnectToDataBase->close();
    $code .= '
    </table>
    <div class="TicketButtonPanel">
    <input type="button" name="CloseWindowButton" id="dButton" onclick="CloseWindow(\'.AssignBox\',1)" value="Wyjdź"/>
    </div>
    ';

echo $code;

?>