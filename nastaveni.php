<?php
session_start();
include "database.php";
if (isset($_POST['upravit_button']))
{
	header('Location: nastaveni_udaje.php');
}
elseif (isset($_POST['heslo_button']))
{
	header('Location: nastaveni_heslo.php');
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
    <h1>Profil</h1>
    <?php
    
    echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		//include "login.php";
		showMenu($_SESSION['Zarazeni']);
    ?>
    <!-- -->
    <?php
  	
		  	connectDB();
		  	$result = mysql_query("select * from akademicky_pracovnik where Rodne_cislo='".$_SESSION['Rodne_cislo']."' ");
				    
				    if(mysql_num_rows($result) == 0)
				    {
				    	echo "<center><h3>Neexistuje žádný Akademicky pracovnik!</h3></center>";
				    	return false;
				    }
				    while($record = MySQL_Fetch_Array($result))
				    {
				        $a = $record['Jmeno'];
				        $b = $record['Prijmeni'];
				        $c = $record['Rodne_cislo'];   
				        $d = $record['Login'];
				        $e = $record['Zarazeni'];    
				    }
				    echo "<center><h2>Profil</h2>";
				    echo "<table border=\"1\"><form method=\"post\"";
				    //echo "<tr><td>ID</td><td>Jméno</td><td>Příjmení</td><td>Rodné číslo</td><td>Funkce</td></tr>";
				    echo "
				    <tr><td>Jméno</td><td>$a</td></tr>
				    <tr><td>Příjmení</td><td>$b</td></tr>
				    <tr><td>Rodné číslo</td><td>$c</td></tr>
				    <tr><td>Login</td><td>$d</td></tr>
				    <tr><td>Funkce</td><td>$e</td></tr>";
				    
				    echo "<tr><td colspan=\"7\"><center>
				    	<input type=\"submit\" name=\"upravit_button\" value=\"Změnit údaje\">
				    	<input type=\"submit\" name=\"heslo_button\" value=\"Změnit heslo\">
				    	</center></td></tr>";
				    echo "</table></center>";
		?>	
    <!-- -->
    <?php
		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>