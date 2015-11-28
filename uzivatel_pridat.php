<?php
session_start();
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
        if(vytvorUzivatele($_POST['jmeno'], $_POST['prijmeni'], $_POST['rodne_cislo'], $_POST['login'], $_POST['heslo'], $_POST['funkce']))
          echo "Rezervace přidána.<br>";
        else
          echo "Rezervaci se nepodařilo přidat!<br>";
        endif;
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Přidat uživatele</h3></center></td></tr>
    <tr>
    	<td>Jméno:</td>
	    <td><input type="text" name="jmeno"></td>
    </tr>

    <tr>
    	<td>Příjmení:</td>
	    <td><input type="text" name="prijmeni"></td>
    </tr>

    <tr>
    	<td>Rodné číslo:</td>
	    <td><input type="text" name="rodne_cislo"></td>
    </tr>

    <tr>
    	<td>Login:</td>
	    <td><input type="text" name="login"></td>
    </tr>

    <tr>
    	<td>Heslo:</td>
	    <td><input type="text" name="heslo"></td>
    </tr>

    <tr>
    	<td>Funkce:</td>
	    <td>
	    	<select name="funkce">
		    	<option value='Akademicky pracovnik'>Akademický pracovník</option><br>
		    	<option value='Administrator'>Administrátor</option><br>
	    	</select>
	    </td>
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