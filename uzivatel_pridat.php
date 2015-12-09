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

function kontrolaRC($rc)
{
    if (!preg_match('#^\s*(\d\d)(\d\d)(\d\d)[ /]*(\d\d\d)(\d?)\s*$#', $rc, $matches)) {
        return FALSE;
    }

    list(, $rok, $mesic, $den, $ext, $c) = $matches;

    if ($c === '')
    {
        $rok += $rok < 54 ? 1900 : 1800;
    }
    else
    {
        $mod = ($rok . $mesic . $den . $ext) % 11;
        if ($mod === 10) $mod = 0;
        if ($mod !== (int) $c)
        {
            return FALSE;
        }

        $rok += $rok < 54 ? 2000 : 1900;
    }

    if ($mesic > 70 && $rok > 2003)
    {
        $mesic -= 70;
    }
    elseif ($mesic > 50)
    {
        $mesic -= 50;
    }
    elseif ($mesic > 20 && $rok > 2003)
    {
        $mesic -= 20;
    }

    if (!checkdate($mesic, $den, $rok))
    {
        return FALSE;
    }

    return TRUE;
}

	include "database.php";
	function vytvorUzivatele($jmeno, $prijmeni, $RC, $login, $heslo, $zarazeni)
	{
		connectDB();
		
		if (kontrolaRC($RC) == FALSE)
		{
			echo "Zadal jsi chybné rodné číslo.<br>";
			return false;
		}

		$jmenoU = htmlspecialchars($jmeno);
		$prijmeniU = htmlspecialchars($prijmeni);
		$RCU = htmlspecialchars($RC);
		$loginU = htmlspecialchars($login);
		$zarazeniU = htmlspecialchars($zarazeni);

		$request = "insert into akademicky_pracovnik(ID, Rodne_cislo, Jmeno, Prijmeni, Login, Heslo, Zarazeni) values('','$RCU','$jmenoU','$prijmeniU','$loginU','$heslo','$zarazeniU')";

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
    if(isset($_POST['submit']))
    {
    	$_SESSION['jmenoUzivatel'] = $_POST['jmeno'];
		$_SESSION['prijmeniUzivatel'] = $_POST['prijmeni'];
		$_SESSION['rodne_cisloUzivatel'] = $_POST['rodne_cislo'];
		$_SESSION['loginUzivatel'] = $_POST['login'];
		$_SESSION['hesloUzivatel'] = $_POST['heslo'];
		$_SESSION['funkceUzivatel'] = $_POST['funkce'];

    	if ((($_POST['jmeno'] == "")) || (($_POST['prijmeni'] == "")) || (($_POST['rodne_cislo'] == "")) || (($_POST['login'] == ""))  || (($_POST['heslo'] == "")) || (($_POST['funkce'] == "")))
    	{
    		echo "Nezadal jsi všechna povinná pole!<br>";
    	}
    	else
    	{
	        if(vytvorUzivatele($_POST['jmeno'], $_POST['prijmeni'], $_POST['rodne_cislo'], $_POST['login'], $_POST['heslo'], $_POST['funkce']))
	        {
	          echo "Rezervace přidána.<br>";
	        }
	        else
	        {
	          echo "Rezervaci se nepodařilo přidat!<br>";
	        }
    	}
    }
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Jméno:</b></td>
	    <td><input type="text" name="jmeno" size="20" value="<?php if ($_SESSION['jmenoUzivatel'] != "") {echo $_SESSION['jmenoUzivatel'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Příjmení:</b></td>
	    <td><input type="text" name="prijmeni" size="20" value="<?php if ($_SESSION['prijmeniUzivatel'] != "") {echo $_SESSION['prijmeniUzivatel'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Rodné číslo:</b></td>
	    <td><input type="text" name="rodne_cislo" size="20" value="<?php if ($_SESSION['rodne_cisloUzivatel'] != "") {echo $_SESSION['rodne_cisloUzivatel'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Login:</b></td>
	    <td><input type="text" name="login" size="20" value="<?php if ($_SESSION['loginUzivatel'] != "") {echo $_SESSION['loginUzivatel'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Heslo:</b></td>
	    <td><input type="text" name="heslo" size="20" value="<?php if ($_SESSION['hesloUzivatel'] != "") {echo $_SESSION['hesloUzivatel'];} ?>"></td>
    </tr>

    <tr>
    	<td><b>Funkce:</b></td>
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