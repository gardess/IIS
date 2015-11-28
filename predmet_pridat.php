<?php
session_start();
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function vytvorPredmet($zkratka, $nazev, $garant, $dotace, $kredity)
	{
		connectDB();
		echo "Rodne cislo: " . $RC;
		$request = "insert into predmet(Zkratka, Nazev, Garant, Hodinova_dotace, Kredity) values('$zkratka','$nazev','$garant','$dotace','$kredity')";

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

	function getUsersOptions($tabulka, $PK)
	{
		connectDB();
	    
		$result = mysql_query("select * from $tabulka");
		$i = 0;
		while($record = MySQL_Fetch_Array($result))
		{
			$zkratka = $record[$PK];
			echo "<option value='$zkratka'>";
			echo "$zkratka";
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
		?>

    <!-- Formulář pro vytvoření nového uživatele -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      //echo "ucebna: " . $_POST['ucebna'] . "rodne cislo: " . $_POST['RC'] . "predmet: " . $_POST['zkratka'] . "jednorazova: " . $_POST['jed']. "datum: " . $_POST['datum']. "cas: " . $_POST['cas'] . "</br>";
        if(vytvorPredmet($_POST['zkratka'], $_POST['nazev'], $_POST['garant'], $_POST['dotace'], $_POST['kredity']))
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
	    <td><input type="text" name="garant"></td>
    </tr>

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