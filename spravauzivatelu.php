<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	include "database.php";
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	if (isset($_POST['pridat_button']))
	{
		header('Location: uzivatel_pridat.php');
	}
	elseif (isset($_POST['upravit_button']))
	{
		if (!isset($_POST['vyber']))
		{
			echo "Nebyla vybrána žádná rezervace pro úpravu.";
		}
		else
		{
			$_SESSION['value'] = $_POST['vyber'];
			if ($_SESSION['value'] != "")
			{
		    	header('Location: uzivatel_upravit.php');
		    }
		    else
		    {
		    	echo "Nebyla vybrána žádná rezervace.";
		    }
	    }
	}
	elseif (isset($_POST['odebrat_button']))
	{
		if (!isset($_POST['vyber']))
		{
			echo "Nebyla vybrána žádná rezervace pro smazání.";
		}
		else
	    {
	    	if(smazUzivatele($_POST['vyber']))
	        {
	        	echo "Uživatel odebrán.<br>";
	        }
	    	else
	    	{
	            echo "Uživatele se nepodařilo odebrat!<br>";
	    	}
	    }
	}
	else
	{
	    $_SESSION['value'] = "";
	    
	}

	function smazUzivatele($id)
  	{
  		connectDB();

	    $requestt = "DELETE FROM akademicky_pracovnik WHERE id = $id";
	    if(!mysql_query($requestt))
	    {
	      echo mysql_error();
	      return false;
	    }
	    else
	    {
	    	echo "Smazání proběhlo úspěšně.";
	    	return true;
	    }
  	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
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
		showMenu();
		administraceMenu();
    ?>
    <!-- -->
    <div id="telo">	
		<h2 class="nadpis">Seznam uživatelů</h2>
	    <!-- Zobrazeni tabulky s uzivateli -->
	    <?php
  	
		  	connectDB();
		  	$result = mysql_query("select * from akademicky_pracovnik");
				    
				    if(mysql_num_rows($result) == 0) // nemůže nikdy nastat
				    {
				    	echo "<center><h3>Neexistuje žádný Akademicky pracovnik!</h3></center>";
				    	echo "
				    		</div>
		   					<div id=\"footer\">
		   						Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
						</div>";
				    	return false;
				    }
				    echo "<center>";
				    echo "<table border=\"1\"><form method=\"post\"";
				    echo "<tr><td></td><td>Jméno</td><td>Příjmení</td><td>Rodné číslo</td><td>Funkce</td></tr>";
				    while($record = MySQL_Fetch_Array($result))
				    {
				    	$aa = $record['ID'];
				        $a = $record['Jmeno'];
				        $b = $record['Prijmeni'];
				        $c = $record['Rodne_cislo'];   
				        $d = $record['Zarazeni'];     
				      	echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$aa\"></td><td>$a</td><td>$b</td><td>$c</td><td>$d</td></tr>";

				    }
				    
				    echo "</table><br>";
				    echo "<input type=\"submit\" name=\"pridat_button\" value=\"Přidat uživatele\">
				    	<input type=\"submit\" name=\"upravit_button\" value=\"Upravit uživatele\">
				    	<input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat uživatele\">
				    	</form></center>";
		?>	
		<br>
	    <!-- -->
		</div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
	</body>
</html>