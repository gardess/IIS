<?php
session_start();
/*if (isset($_SESSION['Zarazeni']))
{
	header('Location: selecting.php');
}*/
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Informační systém - Učebny</title>
    <meta http-equiv="content-type" 
    content="text/html; charset=utf-8">
  </head>
  
  <body>  
    <h1>Rezervace</h1>
    <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		//include "login.php";
		showMenu($_SESSION['Zarazeni']);
		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>