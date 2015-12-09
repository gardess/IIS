<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');
include "database.php";

if (time() - $_SESSION['cas'] > 900)
{
	unset($_SESSION['Jmeno'], $_SESSION['Prijmeni'], $_SESSION['Rodne_cislo'], $_SESSION['login_user']);
	$_SESSION['Zarazeni'] = "null";
	header('Location: prihlaseni2.php');
}
else
{
	$_SESSION['cas'] = time();
}

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
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="styl.css" />
  </head>
  
  <body>  
  <div id="wrapper">
        <div id="header">
    		<h1>&nbsp;Učebny</h1>
    	</div>
    <?php
    
    	echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";
		include "menu.php";
		showMenu($_SESSION['Zarazeni']);
    ?>
    <!-- -->
    <div id="telo">	
		<h2 class="nadpis">Profil</h2>
    <?php
  	
		  	connectDB();
		  	$result = mysql_query("select * from akademicky_pracovnik where Rodne_cislo='".$_SESSION['Rodne_cislo']."' ");
				    
				    if(mysql_num_rows($result) == 0)
				    {
				    	echo "<center><h3>Neexistuje žádný Akademicky pracovnik!</h3></center>";
				    	echo "
				    		</div>
		   					<div id=\"footer\">
		   						Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
						</div>";
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
				    echo "<center><table border=\"1\"><form method=\"post\"";
				    //echo "<tr><td>ID</td><td>Jméno</td><td>Příjmení</td><td>Rodné číslo</td><td>Funkce</td></tr>";
				    echo "
				    <tr><td>Jméno</td><td>$a</td></tr>
				    <tr><td>Příjmení</td><td>$b</td></tr>
				    <tr><td>Rodné číslo&nbsp;</td><td>$c</td></tr>
				    <tr><td>Login</td><td>$d</td></tr>
				    <tr><td>Funkce</td><td>$e</td></tr>";
				    echo "</table></center><br>";
				    echo "<center>
				    	<input type=\"submit\" name=\"upravit_button\" value=\"Změnit údaje\">
				    	<input type=\"submit\" name=\"heslo_button\" value=\"Změnit heslo\">
				    	</center><br>";
				    
		?>	
    <!-- -->
    </div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  </body>
</html>