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

	function getUsersOptions($tabulka, $PK, $nazev)
	{
		connectDB();
		$result = mysql_query("select * from $tabulka");
		$i = 0;
		while($record = MySQL_Fetch_Array($result))
		{
			$zkratka = $record[$PK];
			if ($nazev == $zkratka)
			{
				echo "<option value='$zkratka' selected='selected'>";
			}
			else
			{
				echo "<option value='$zkratka'>";
			}
			echo "$zkratka";
			echo "</option><br>";
			$i++;
		}
	}

function optionSelect($typ)
{
	if ($typ == 'Projektor')
	{
		echo "
		<option value='Projektor' selected='selected'>Projektor</option><br>
		<option value='Tabule'>Tabule</option><br>
		<option value='Židle'>Židle</option><br>
		<option value='Kamera'>Kamera</option><br>
		<option value='Interaktivní tabule'>Interaktivní tabule</option><br>";
	}
	if ($typ == 'Tabule')
	{
		echo "
		<option value='Projektor'>Projektor</option><br>
		<option value='Tabule' selected='selected'>Tabule</option><br>
		<option value='Židle'>Židle</option><br>
		<option value='Kamera'>Kamera</option><br>
		<option value='Interaktivní tabule'>Interaktivní tabule</option><br>";
	}
	if ($typ == 'Židle')
	{
		echo "
		<option value='Projektor'>Projektor</option><br>
		<option value='Tabule'>Tabule</option><br>
		<option value='Židle' selected='selected'>Židle</option><br>
		<option value='Kamera'>Kamera</option><br>
		<option value='Interaktivní tabule'>Interaktivní tabule</option><br>";
	}
	if ($typ == 'Kamera')
	{
		echo "
		<option value='Projektor'>Projektor</option><br>
		<option value='Tabule'>Tabule</option><br>
		<option value='Židle'>Židle</option><br>
		<option value='Kamera' selected='selected'>Kamera</option><br>
		<option value='Interaktivní tabule'>Interaktivní tabule</option><br>";
	}
	if ($typ == 'Interaktivní tabule')
	{
		echo "
		<option value='Projektor'>Projektor</option><br>
		<option value='Tabule'>Tabule</option><br>
		<option value='Židle'>Židle</option><br>
		<option value='Kamera'>Kamera</option><br>
		<option value='Interaktivní tabule' selected='selected'>Interaktivní tabule</option><br>";
	}
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
<html>
  <head>
    <title>Informační systém - Učebny</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="styl.css" />

    <link rel="stylesheet" type="text/css" media="all" href="js/jsDatePick_ltr.min.css" />
		<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
		<script type="text/javascript">
			window.onload = function()
			{
				new JsDatePick(
				{
					useMode:2,
					target:"inputField",
					dateFormat:"%Y-%m-%d"
				});
			};
		</script>
  </head>
  
  <body>  
    <div id="wrapper">
        <div id="header">
    		<h1>&nbsp;Učebny</h1>
    	</div>
    	<?php
    		if ((($_SESSION['Zarazeni']) == "Administrator") || (($_SESSION['Zarazeni']) == "Akademicky pracovnik"))
    		echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";
		    connectDB();
		    include "menu.php";
			showMenu();
			administraceMenu();
			?>
		<div id="telo">	
		<h2 class="nadpis">Upravení příslušenství</h2>

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
    <tr>
    	<td>Název:</td>
	    <td>
	    	<select name="nazev" style="width: 173px">
	    		<?php
			    	optionSelect($DB_Nazev);
		    	?>
		    </select>
		</td>
    </tr>

    <tr>
    	<td>Místnost:</td>
	    <td>
		    <select name="mistnost" style="width: 173px">>
		    <?php 
		      getUsersOptions('ucebna', 'Oznaceni', $DB_Mistnost);
		    ?>
		    </select>
	    </td>
    </tr>

    <tr>
    	<td>Pořizovací cena:</td>
	    <td><input type="text" name="cena" size="20" value="<?php echo $DB_Cena; ?>"></td>
    </tr>

    <tr>
    	<td>Datum pořízení:</td>
	    <td><input type="text" name="datum" size="20" id="inputField" value="<?php echo $DB_Datum; ?>"></td>
    </tr>

    <tr>
    	<td>Určení:</td>
	    <td><input type="text" name="urceni" size="20" value="<?php echo $DB_Urceni; ?>"></td>
    </tr>
	
	
	</table></center>
	<br>
    <center><input type="submit" name="submit" size="20" value="Upravit příslušenství"></center>
    </form>


    <!-- -->
    <br>
    </div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  </body>
</html>