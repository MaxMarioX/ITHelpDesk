<?php
//Rozpoczęcie sesji
session_start();

//Zmienna przechowująca info o tym czy użytkownik musi się zalogować (domyślnie tak)
$LogInReguire = true;

//Sprawdzanie czy użytkownik jest zalogowany
if(isset($_SESSION['UserStatus']))
{
    if($_SESSION['UserStatus'] == true) //Jeśli jest zalogowany...
    {
        $LogInReguire = false; //... nie musi się logować ponownie
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <?php
    if($LogInReguire)
    {
    echo "<link rel=\"stylesheet\" href=\"styles/login.css\" type=\"text/css\"/>";
    } else {
    echo "<link rel=\"stylesheet\" href=\"styles/main.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/panel.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/buttons.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_main.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_panels.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_assign.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_history.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_info.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/tickets_create.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/menu.css\" type=\"text/css\"/>";
    echo "<link rel=\"stylesheet\" href=\"styles/menu-login.css\" type=\"text/css\"/>";
    }   
    ?>
    <script src="scripts/jquery-library/jquery-3.2.1.js"></script>
    <?php
    if($LogInReguire)
    {
    echo "<script src=\"scripts/login/w_log.js\"></script>";
    } else {
        echo "<script src=\"scripts/panel/panel.js\"></script>";
        echo "<script src=\"scripts/panel/tickets.js\"></script>";
        echo "<script src=\"scripts/panel/styles.js\"></script>";
        echo "<script src=\"scripts/panel/menu.js\"></script>";
    }   
    ?>
</head>
<body>

<div id="Main_Window">

<?php

if($LogInReguire)
{
    require_once('login.php');
} else {
    require_once('Panel.php');
}

?>

</div>
</body>
</html>