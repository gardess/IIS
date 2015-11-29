<?php
session_start();
header('Content-type: text/html; charset=utf-8');

	include "database.php";
	function upravUdaje($jmeno, $prijmeni, $RC, $login)
	{
		connectDB();
		

    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE akademicky_pracovnik SET 
		Jmeno='$jmeno',
		Prijmeni='$prijmeni',
		Rodne_cislo='$RC',
		Login='$login'
		WHERE Rodne_cislo ='".$_SESSION['Rodne_cislo']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			$_SESSION['Rodne_cislo'] = $RC;
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
    <meta http-equiv="content-type" 
    content="text/html; charset=utf-8">
  </head>
  
  <body>  
    <h1>Rezervace - UPRAVIT</h1>
     <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		showMenu($_SESSION['Zarazeni']);
		
  	?>
    
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
      
        if(upravUdaje($_POST['jmeno'], $_POST['prijmeni'], $_POST['RC'], $_POST['login']))
          {;}//echo "Předmět přidán.<br>";
        else
          {;}//echo "Předmět se nepodařilo přidat!<br>";
        endif;
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Upravit uživatele</h3></center></td></tr>
    <tr>
    	<td>Jméno:</td>
	    <td><input type="text" name="jmeno" value="<?php echo $DB_Jmeno; ?>"></td>
    </tr>

    <tr>
    	<td>Příjmení:</td>
	    <td><input type="text" name="prijmeni" value="<?php echo $DB_Prijmeni; ?>"></td>
    </tr>

    <tr>
    	<td>Rodné číslo:</td>
	    <td><input type="text" name="RC" value="<?php echo $DB_RC; ?>"></td>
    </tr>

    <tr>
    	<td>Login:</td>
	    <td><input type="text" name="login" value="<?php echo $DB_Login; ?>"></td>
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