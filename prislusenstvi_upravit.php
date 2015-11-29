<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function upravPrislusenstvi($nazev, $urceni, $cena, $datum, $mistnost)
	{
		connectDB();


    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE prislusenstvi SET 
		Nazev='$nazev',
		Urceni='$urceni',
		Porizovaci_cena='$cena',
		Datum_porizeni='$datum',
		Mistnost='$mistnost'
		WHERE Inventarni_cislo ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Úprava proběhla úspěšně.";
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
  		$req = "SELECT * FROM prislusenstvi WHERE Inventarni_cislo ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_Nazev = $rec['Nazev'];
    	   	$DB_Urceni = $rec['Urceni'];
    	   	$DB_Datum = $rec['Datum_porizeni'];
    	   	$DB_Cena = $rec['Porizovaci_cena'];
    	   	$DB_Mistnost = $rec['Mistnost'];
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravPrislusenstvi($_POST['nazev'], $_POST['urceni'], $_POST['cena'], $_POST['datum'], $_POST['mistnost']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Upravit příslušenství</h3></center></td></tr>
    <tr>
    	<td>Název:</td>
	    <td><input type="text" name="nazev" value="<?php echo $DB_Nazev; ?>"></td>
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
	    <td><input type="text" name="cena" value="<?php echo $DB_Cena; ?>"></td>
    </tr>

    <tr>
    	<td>Datum pořízení:</td>
	    <td><input type="text" name="datum" value="<?php echo $DB_Datum; ?>"></td>
    </tr>

    <tr>
    	<td>Určení:</td>
	    <td><input type="text" name="urceni" value="<?php echo $DB_Urceni; ?>"></td>
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