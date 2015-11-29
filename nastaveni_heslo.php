<?php
session_start();

	include "database.php";
	function upravUdaje($heslo)
	{
		connectDB();
		

    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE akademicky_pracovnik SET 
		heslo='$heslo'
		WHERE Rodne_cislo ='".$_SESSION['Rodne_cislo']."' ";
		if(!mysql_query($sql))
		{
			echo mysql_error();
			return false;
		}
		else
		{
			echo "Změna hesla proběhla úspěšně.";
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
    		$DB_Heslo = $rec['Heslo'];    	   	
    	}
    	
  	?>

    <!-- Formulář pro úpravu rezervace-->
    <?php
    $uzivatel = $_SESSION['Rodne_cislo'];
    if(isset($_POST['submit']))
    {
		if (strcmp($_POST['heslo1'], $_POST['heslo2']) == 0)
		{
        	if (upravUdaje($_POST['heslo1']))
            {
            	;
            }//echo "Předmět přidán.<br>";
            else
            {
            	;
            }//echo "Předmět se nepodařilo přidat!<br>";
		}
		else
		{
			echo "Zadaná hesla nejsou stejná.";
		}
	}
    //$script_url = "rezervace.php";
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr><td colspan="2"><center><h3>Změna hesla</h3></center></td></tr>
    <tr>
    	<td>Nové heslo:</td>
	    <td><input type="password" name="heslo1" value=""></td>
    </tr>

    <tr>
    	<td>Nové heslo znovu:</td>
	    <td><input type="password" name="heslo2" value=""></td>
    </tr>

    

	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Změnit heslo"></center></td>
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