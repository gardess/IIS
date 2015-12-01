<?php
session_start();
header('Content-type: text/html; charset=utf-8');
	if ($_SESSION['Zarazeni'] != "Administrator")
	{
		echo "Nemate dostatecna opravneni.";
		exit;
	}

	include "database.php";
	function vytvorUzivatele($jmeno, $prijmeni, $RC, $login, $heslo, $zarazeni)
	{
		connectDB();
		echo "Rodne cislo: " . $RC;
		$request = "insert into akademicky_pracovnik(ID, Rodne_cislo, Jmeno, Prijmeni, Login, Heslo, Zarazeni) values('','$RC','$jmeno','$prijmeni','$login','$heslo','$zarazeni')";

		if(!mysql_query($request))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Uživatel " . $jmeno . " " . $prijmeni . " byl úspěšně přidán.";
			header('Location: spravauzivatelu.php');
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
		<h2 class="nadpis">Vytvoření uživatele</h2>

    <!-- Formulář pro vytvoření nového uživatele -->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      //echo "ucebna: " . $_POST['ucebna'] . "rodne cislo: " . $_POST['RC'] . "predmet: " . $_POST['zkratka'] . "jednorazova: " . $_POST['jed']. "datum: " . $_POST['datum']. "cas: " . $_POST['cas'] . "</br>";
        if(vytvorUzivatele($_POST['jmeno'], $_POST['prijmeni'], $_POST['rodne_cislo'], $_POST['login'], $_POST['heslo'], $_POST['funkce']))
          echo "Rezervace přidána.<br>";
        else
          echo "Rezervaci se nepodařilo přidat!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td>Jméno:</td>
	    <td><input type="text" name="jmeno" size="20"></td>
    </tr>

    <tr>
    	<td>Příjmení:</td>
	    <td><input type="text" name="prijmeni" size="20"></td>
    </tr>

    <tr>
    	<td>Rodné číslo:</td>
	    <td><input type="text" name="rodne_cislo" size="20"></td>
    </tr>

    <tr>
    	<td>Login:</td>
	    <td><input type="text" name="login" size="20"></td>
    </tr>

    <tr>
    	<td>Heslo:</td>
	    <td><input type="text" name="heslo" size="20"></td>
    </tr>

    <tr>
    	<td>Funkce:</td>
	    <td>
	    	<select name="funkce" style="width: 173px">
		    	<option value='Akademicky pracovnik'>Akademický pracovník</option><br>
		    	<option value='Administrator'>Administrátor</option><br>
	    	</select>
	    </td>
    </tr>
    
	</table>
	<br>
	<center><input type="submit" name="submit" value="Přidat uživatele"></center>
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