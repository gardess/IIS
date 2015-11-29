<?php
session_start();
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function vytvorUcebnu($nazev, $urceni, $cena, $datum, $mistnost)
	{
		connectDB();
		$request = "insert into prislusenstvi(Inventarni_cislo, Nazev, Urceni, Porizovaci_cena, Datum_porizeni, Mistnost) values('','$nazev','$urceni','$cena','$datum','$mistnost')";

		if(!mysql_query($request))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Příslušenství " . $nazev . " bylo úspěšně přidáno do učebny " . $mistnost . ".";
			header('Location: spravaprislusenstvi.php');
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
		<h1>Vytvoření příslušenství</h1>
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
    	
        if(vytvorUcebnu($_POST['nazev'], $_POST['urceni'], $_POST['cena'], $_POST['datum'], $_POST['mistnost']))
          echo "Příslušenství vytvořeno.<br>";
        else
          echo "Příslušenství se nepodařilo vytvořit!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Přidat příslušenství</h3></center></td></tr>
    <tr>
    	<td>Název:</td>
	    <td><input type="text" name="nazev"></td>
    </tr>

    <tr>
    	<td>Místnost:</td>
	    <td>
		    <select name="mistnost">
		    <?php 
		      getUsersOptions('ucebna', 'Oznaceni');
		    ?>
		    </select>
	    </td>
    </tr>

	<tr>
    	<td>Pořizovací cena:</td>
	    <td><input type="text" name="cena"></td>
    </tr>

    <tr>
    	<td>Datum pořízení:</td>
	    <td><input type="text" name="datum"></td>
    </tr>

    <tr>
    	<td>Určení:</td>
	    <td><input type="textarea" name="urceni"></td>
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