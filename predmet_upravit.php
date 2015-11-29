<?php
session_start();
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function upravRezervaci($zkratka, $nazev, $garant, $dotace, $kredity)
	{
		connectDB();

    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE predmet SET 
		Zkratka='$zkratka',
		Nazev='$nazev',
		Garant='$garant',
		Hodinova_dotace='$dotace',
		Kredity='$kredity'
		WHERE Zkratka ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Úprava předmětu proběhla úspěšně.";
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
    <meta http-equiv="content-type" 
    content="text/html; charset=utf-8">
  </head>
  
  <body>  
    <h1>Rezervace - UPRAVIT</h1>
     <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		showMenu($_SESSION['Zarazeni']);
		administraceMenu();
  	?>
    
  	<?php
  		connectDB();
  		$req = "SELECT * FROM predmet WHERE Zkratka ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_Zkratka = $rec['Zkratka'];
    	   	$DB_Nazev = $rec['Nazev'];
    	   	$DB_Garant = $rec['Garant'];
    	   	$DB_Hodinova_dotace = $rec['Hodinova_dotace'];
    	   	$DB_Kredity = $rec['Kredity'];    	   	
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravRezervaci($_POST['zkratka'], $_POST['nazev'], $_POST['garant'], $_POST['dotace'], $_POST['kredity']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Upravit uživatele</h3></center></td></tr>
    <tr>
    	<td>Zkratka:</td>
	    <td><input type="text" name="zkratka" value="<?php echo $DB_Zkratka; ?>"></td>
    </tr>

    <tr>
    	<td>Název:</td>
	    <td><input type="text" name="nazev" value="<?php echo $DB_Nazev; ?>"></td>
    </tr>

    <tr>
    	<td>Garant:</td>
	    <td><input type="text" name="garant" value="<?php echo $DB_Garant; ?>"></td>
    </tr>

    <tr>
    	<td>Hodinová dotace:</td>
	    <td><input type="text" name="dotace" value="<?php echo $DB_Hodinova_dotace; ?>"></td>
    </tr>

    <tr>
    	<td>Počet kreditů:</td>
	    <td><input type="text" name="kredity" value="<?php echo $DB_Kredity; ?>"></td>
    </tr>
	
	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Upravit"></center></td>
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