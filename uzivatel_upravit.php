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
	function upravRezervaci($jmeno, $prijmeni, $login, $zarazeni, $DB_Zarazeni)
	{
		connectDB();
		if (($DB_RC != $RC) && ($_SESSION['Zarazeni'] != "Administrator"))
		{
			echo "Nemáte dostatečná oprávnění pro úpravu uživatelů.";
			return false;
		}

		$jmenoU = htmlspecialchars($jmeno);
		$prijmeniU = htmlspecialchars($prijmeni);
		$loginU = htmlspecialchars($login);
		$zarazeniU = htmlspecialchars($zarazeni);

		$sql = "UPDATE akademicky_pracovnik SET 
		Jmeno='$jmenoU',
		Prijmeni='$prijmeniU',
		Login='$loginU',
		Zarazeni='$zarazeniU'
		WHERE ID ='".$_SESSION['value']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			if ($zarazeni != "Administrator")
			{
				$_SESSION['Zarazeni'] = "Akademicky pracovnik";
				header('Location: index.php');
			}
			echo "Úprava proběhla úspěšně.";
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

function optionSelect($typ)
{
	if ($typ == 'Akademicky pracovnik')
	{
		echo "
		<option value='Akademicky pracovnik' selected='selected'>Akademický pracovník</option><br>
		<option value='Administrator'>Administrátor</option><br>";
	}
	else if ($typ == 'Administrator')
	{
		echo "
		<option value='Akademicky pracovnik'>Akademický pracovník</option><br>
		<option value='Administrator' selected='selected'>Administrátor</option><br>";
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
		<h2 class="nadpis">Upravení uživatele</h2>
    
  	<?php
  		connectDB();
  		$req = "SELECT * FROM akademicky_pracovnik WHERE ID ='".$_SESSION['value']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_RC = $rec['Rodne_cislo'];
    	   	$DB_Jmeno = $rec['Jmeno'];
    	   	$DB_Prijmeni = $rec['Prijmeni'];
    	   	$DB_Login = $rec['Login'];
    	   	$DB_Zarazeni = $rec['Zarazeni'];
    	   	
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit']))
    {
        if ((($_POST['jmeno'] == "")) || (($_POST['prijmeni'] == "")) || (($_POST['login'] == ""))|| (($_POST['zarazeni'] == "")))
    	{
    		echo "Nezadal jsi všechna povinná pole!<br>";
    	}
    	else
    	{
	        if(upravRezervaci($_POST['jmeno'], $_POST['prijmeni'], $_POST['login'], $_POST['zarazeni'], $DB_Zarazeni))
	          {;}//echo "Předmět přidán.<br>";
	        else
	          {;}//echo "Předmět se nepodařilo přidat!<br>";
      	}
    }
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Jméno:</b></td>
	    <td><input type="text" name="jmeno" size="20" value="<?php echo $DB_Jmeno; ?>"></td>
    </tr>

    <tr>
    	<td><b>Příjmení:</b></td>
	    <td><input type="text" name="prijmeni" size="20" value="<?php echo $DB_Prijmeni; ?>"></td>
    </tr>

    <tr>
    	<td><b>Login:</b></td>
	    <td><input type="text" name="login" size="20" value="<?php echo $DB_Login; ?>"></td>
    </tr>
    
    <tr>
	    <td><b>Zařazení:</b></td>
	    <td>
		    <select name="zarazeni" style="width: 173px">
		    <?php
		    	optionSelect($DB_Zarazeni);
	    	?>
	    	</select>
	    </td>
	</tr>
	
	</table></center>
	<br>
	<center><input type="submit" name="submit" value="Upravit uživatele"></center>
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