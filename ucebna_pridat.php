<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function vytvorUcebnu($oznaceni, $cislo, $budova, $kapacita)
	{
		connectDB();
		$request = "insert into ucebna(Oznaceni, Cislo_mistnosti, Budova, Kapacita) values('$oznaceni','$cislo','$budova','$kapacita')";

		if(!mysql_query($request))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Učebna " . $zkratka . " byla úspěšně vytvořena.";
			header('Location: spravauceben.php');
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
		<h2 class="nadpis">Vytvoření učebny</h2>

    <!-- Formulář pro vytvoření nového uživatele -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      //echo "ucebna: " . $_POST['ucebna'] . "rodne cislo: " . $_POST['RC'] . "predmet: " . $_POST['zkratka'] . "jednorazova: " . $_POST['jed']. "datum: " . $_POST['datum']. "cas: " . $_POST['cas'] . "</br>";
        if(vytvorUcebnu($_POST['oznaceni'], $_POST['cislo'], $_POST['budova'], $_POST['kapacita']))
          echo "Učebna vytvořena.<br>";
        else
          echo "Učebnu se nepodařilo vytvořit!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td>Označení:</td>
	    <td><input type="text" size="20" name="oznaceni"></td>
    </tr>

    <tr>
    	<td>Číslo místnosti:</td>
	    <td><input type="text" size="20" name="cislo"></td>
    </tr>

	<tr>
    	<td>Budova:</td>
	    <td><input type="text" size="20" name="budova"></td>
    </tr>

    <tr>
    	<td>Kapacita:</td>
	    <td><input type="text" size="20" name="kapacita"></td>
    </tr>

	</table>
	<br>
	<center><input type="submit" name="submit" value="Přidat učebnu"></center>
	</center>
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