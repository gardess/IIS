<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

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

	include "database.php";
	function vytvorUcebnu($nazev, $urceni, $cena, $datum, $mistnost)
	{
		connectDB();

		$nazevU = htmlspecialchars($nazev);
		$urceniU = htmlspecialchars($urceni);
		$cenaU = htmlspecialchars($cena);
		$datumU = htmlspecialchars($datum);
		$mistnostU = htmlspecialchars($mistnost);


		$request = "insert into prislusenstvi(Inventarni_cislo, Nazev, Urceni, Porizovaci_cena, Datum_porizeni, Mistnost) values('','$nazevU','$urceniU','$cenaU','$datumU','$mistnostU')";

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
		<h2 class="nadpis">Vytvoření příslušenství</h2>

    <!-- Formulář pro vytvoření nového uživatele -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit']))
    {
		$_SESSION['nazevPrislusentvi'] = $_POST['nazev'];
		$_SESSION['urceniPrislusentvi'] = $_POST['urceni'];
		$_SESSION['cenaPrislusentvi'] = $_POST['cena'];
		$_SESSION['datumPrislusentvi'] = $_POST['datum'];
		$_SESSION['mistnostPrislusentvi'] = $_POST['mistnost'];

    	if ((($_POST['nazev'] == "")) || (($_POST['cena'] == "")) || (($_POST['datum'] == "")) || (($_POST['mistnost'] == "")))
    	{
    		echo "Nezadal jsi všechna povinná pole!<br>";
    	}
    	else
    	{
	        if(vytvorUcebnu($_POST['nazev'], $_POST['urceni'], $_POST['cena'], $_POST['datum'], $_POST['mistnost']))
	        {
	          echo "Příslušenství vytvořeno.<br>";
	        }
	        else
	        {
	          echo "Příslušenství se nepodařilo vytvořit!<br>";
	        }
	    }
    
    }
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Název:</b></td>
	    <td>
	    	<select name="nazev" style="width: 173px">
			    	<option value='Projektor'>Projektor</option><br>
			    	<option value='Tabule'>Tabule</option><br>
			    	<option value='Židle'>Židle</option><br>
			    	<option value='Kamera'>Kamera</option><br>
			    	<option value='Interaktivní tabule'>Interaktivní tabule</option><br>
		    </select>
		</td>
    </tr>

    <tr>
    	<td><b>Místnost:</b></td>
	    <td>
		    <select name="mistnost" style="width: 173px">
		    <?php 
		      getUsersOptions('ucebna', 'Oznaceni');
		    ?>
		    </select>
	    </td>
    </tr>

	<tr>
    	<td><b>Pořizovací cena:</b></td>
	    <td><input type="text" name="cena" size="20" value="<?php if ((isset($_SESSION['cenaPrislusentvi'])) && ($_SESSION['cenaPrislusentvi'] != "")) {echo $_SESSION['cenaPrislusentvi'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Datum pořízení:</b></td>
	    <td><input type="text" name="datum" id="inputField" size="20" value="<?php if ((isset($_SESSION['datumPrislusentvi'])) && ($_SESSION['datumPrislusentvi'] != "")) {echo $_SESSION['datumPrislusentvi'];} ?>"></td>
    </tr>

    <tr>
    	<td>Určení:</td>
	    <td><input type="text" name="urceni" size="20"></td>
    </tr>

	</table></center>
	<br>
	<center><input type="submit" name="submit" value="Přidat příslušenství"></center>
    </form>

    <br>
    <!-- -->
    </div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  </body>
</html>