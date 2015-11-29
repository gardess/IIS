<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function vytvorPredmet($zkratka, $nazev, $garant, $dotace, $kredity, $rocnik)
	{
		connectDB();
		echo "Rodne cislo: " . $RC;
		$request = "insert into predmet(Zkratka, Nazev, Garant, Hodinova_dotace, Kredity, Rocnik) values('$zkratka','$nazev','$garant','$dotace','$kredity','$rocnik')";

		if(!mysql_query($request))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Předmět " . $nazev . " byl úspěšně vytvořen.";
			header('Location: spravapredmetu.php');
			return true;
		}                
	}

	function ziskejGaranta()
	{
		connectDB();
	    
		$result = mysql_query("select * from akademicky_pracovnik");
		$i = 0;
		while($record = MySQL_Fetch_Array($result))
		{
			$RC = $record['Rodne_cislo'];
			$Jmeno = $record['Jmeno'];
			$Prijmeni = $record['Prijmeni'];
			echo "<option value='$RC'>";
			echo $Jmeno." ". $Prijmeni;
			echo "</option><br>";
			$i++;
		}
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<title>Informační systém - Učebny</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
  
	<body>  
		<h1>Rezervace</h1>
		<?php
			echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
			include "menu.php";
			showMenu($_SESSION['Zarazeni']);
			administraceMenu();
		?>

    <!-- Formulář pro vytvoření nového uživatele -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      //echo "ucebna: " . $_POST['ucebna'] . "rodne cislo: " . $_POST['RC'] . "predmet: " . $_POST['zkratka'] . "jednorazova: " . $_POST['jed']. "datum: " . $_POST['datum']. "cas: " . $_POST['cas'] . "</br>";
        if(vytvorPredmet($_POST['zkratka'], $_POST['nazev'], $_POST['garant'], $_POST['dotace'], $_POST['kredity'], $_POST['rocnik']))
          echo "Předmět přidán.<br>";
        else
          echo "Předmět se nepodařilo vytvořit!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Přidat předmět</h3></center></td></tr>
    <tr>
    	<td>Zkratka:</td>
	    <td><input type="text" name="zkratka"></td>
    </tr>

    <tr>
    	<td>Název:</td>
	    <td><input type="text" name="nazev"></td>
    </tr>

    <tr>
    	<td>Garant:</td>
    	<td>
		    <select name="garant">
			    <?php 
			      ziskejGaranta();
			    ?>
			</select>
    	</td>
    </tr>

    <tr>
    	<td>Ročník:<td>
    	<select name="rocnik">
		    	<option value='1BIT'>1BIT</option><br>
		    	<option value='2BIT'>2BIT</option><br>
		    	<option value='3BIT'>3BIT</option><br>
		    	<option value='1MIT'>1MIT</option><br>
		    	<option value='2MIT'>2MIT</option><br>
	    	</select>

    <tr>
    	<td>Hodinová dotace:</td>
	    <td><input type="text" name="dotace"></td>
    </tr>

    <tr>
    	<td>Počet kreditů:</td>
	    <td><input type="text" name="kredity"></td>
    </tr>

    
    
	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Přidat"></center></td>
	</tr>
	</table></center>
    </form>


    <!-- -->
    <?php
   		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>