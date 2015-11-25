<?php
session_start();
if ($_SESSION['Zarazeni'] != "Administrator")
{
  echo "Nemate dostatecna opravneni.";
  exit;
	//header('Location: selecting.php');
}
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
    <h1>Správa učeben</h1>
    <?php
		include "menu.php";
		//include "login.php";
    echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		showMenu($_SESSION['Zarazeni']);
		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>