<?php
session_save_path("tmp/");
session_start();
header('Content-type: text/html; charset=utf-8');

	include "database.php";

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
  
	function upravUdaje($jmeno, $prijmeni, $login)
	{
		connectDB();
		



    $jmenoU = htmlspecialchars($jmeno);
    $prijmeniU = htmlspecialchars($prijmeni);
    $loginU = htmlspecialchars($login);
    
		$sql = "UPDATE akademicky_pracovnik SET 
		Jmeno='$jmenoU',
		Prijmeni='$prijmeniU',
		Login='$loginU'
		WHERE Rodne_cislo ='".$_SESSION['Rodne_cislo']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			
			$_SESSION['Jmeno'] = $jmeno;
			$_SESSION['Prijmeni'] = $prijmeni;
			$_SESSION['login_user'] = $login;
			echo "Úprava proběhla úspěšně.";
			header('Location: nastaveni.php');
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
    
      echo "<div id=\"prihlasen\">Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni']."&nbsp;</div>";
    include "menu.php";
    showMenu($_SESSION['Zarazeni']);
    ?>
    <!-- -->
    <div id="telo"> 
    <h2 class="nadpis">Změna údajů</h2>

  	<?php
  		connectDB();
  		$req = "SELECT * FROM akademicky_pracovnik WHERE Rodne_cislo ='".$_SESSION['Rodne_cislo']."' ";
        $res = mysql_query($req);
        while($rec = MySQL_Fetch_Array($res))
    	{
    		$DB_RC = $rec['Rodne_cislo'];
    	   	$DB_Jmeno = $rec['Jmeno'];
    	   	$DB_Prijmeni = $rec['Prijmeni'];
    	   	$DB_Login = $rec['Login'];    	   	
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit'])):
      
        if(upravUdaje($_POST['jmeno'], $_POST['prijmeni'], $_POST['login']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Jméno:</b></td>
	    <td><input type="text" name="jmeno" value="<?php echo $DB_Jmeno; ?>"></td>
    </tr>

    <tr>
    	<td><b>Příjmení:</b></td>
	    <td><input type="text" name="prijmeni" value="<?php echo $DB_Prijmeni; ?>"></td>
    </tr>

    <tr>
    	<td><b>Login:</b></td>
	    <td><input type="text" name="login" value="<?php echo $DB_Login; ?>"></td>
    </tr>

	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Upravit"></center></td>
	</tr>
	</table></center>
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