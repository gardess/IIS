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
	function vytvorUcebnu($oznaceni, $cislo, $budova, $kapacita)
	{
		connectDB();

		$oznaceniU = htmlspecialchars($oznaceni);
		$cisloU = htmlspecialchars($cislo);
		$budovaU = htmlspecialchars($budova);
		$kapacitaU = htmlspecialchars($kapacita);

		$request = "insert into ucebna(Oznaceni, Cislo_mistnosti, Budova, Kapacita) values('$oznaceniu','$cisloU','$budovau','$kapacitau')";

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
    if(isset($_POST['submit']))
    {
    	$_SESSION['oznaceniUcebna'] = $_POST['oznaceni'];
		$_SESSION['cisloUcebna'] = $_POST['cislo'];
		$_SESSION['budovaUcebna'] = $_POST['budova'];
		$_SESSION['kapacitaUcebna'] = $_POST['kapacita'];

    	if ((($_POST['oznaceni'] == "")) || (($_POST['cislo'] == "")) || (($_POST['budova'] == "")) || (($_POST['kapacita'] == "")))
    	{
    		echo "Nezadal jsi všechna povinná pole!<br>";
    	}
    	else
    	{
	        if(vytvorUcebnu($_POST['oznaceni'], $_POST['cislo'], $_POST['budova'], $_POST['kapacita']))
	        {
	          echo "Učebna vytvořena.<br>";
	        }
	        else
	        {
	          echo "Učebnu se nepodařilo vytvořit!<br>";
	        }
	    }
    }
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Označení:</b></td>
	    <td><input type="text" size="20" name="oznaceni" value="<?php if ($_SESSION['oznaceniUcebna'] != "") {echo $_SESSION['oznaceniUcebna'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Číslo místnosti:</b></td>
	    <td><input type="text" size="20" name="cislo" value="<?php if ($_SESSION['cisloUcebna'] != "") {echo $_SESSION['cisloUcebna'];} ?>"></td>
    </tr>

	<tr>
    	<td><b>Budova:</b></td>
	    <td><input type="text" size="20" name="budova" value="<?php if ($_SESSION['budovaUcebna'] != "") {echo $_SESSION['budovaUcebna'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Kapacita:</b></td>
	    <td><input type="text" size="20" name="kapacita" value="<?php if ($_SESSION['kapacitaUcebna'] != "") {echo $_SESSION['kapacitaUcebna'];} ?>"></td>
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