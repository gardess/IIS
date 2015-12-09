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
  
	function upravUdaje($heslo)
	{
		connectDB();
		
    $heslo1 = sha1($heslo);
    //$request = "insert into rezervace(Datum_pridani, Cas_pridani, Oznaceni, Rodne_cislo, Zkratka, Jednorazova) values('$datum','$cas','$ozn','$RC','$zkr','$jed')";
		$sql = "UPDATE akademicky_pracovnik SET 
		heslo='$heslo1'
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
    <div id="telo">	
		<h2 class="nadpis">Změna hesla</h2>
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
            }
            else
            {
            	;
            }
		}
		else
		{
			echo "Zadaná hesla nejsou stejná.";
		}
	}
    $script_url = $_SERVER['PHP_SELF'];   
      echo "<form action='$script_url' method='post'>"; ?>
    <center><table border="1">
    <tr>
    	<td><b>Nové heslo:</b></td>
	    <td><input type="password" name="heslo1" value=""></td>
    </tr>

    <tr>
    	<td><b>Nové heslo znovu:</b></td>
	    <td><input type="password" name="heslo2" value=""></td>
    </tr>

    

	<tr>
		<td colspan="2"><center><input type="submit" name="submit" value="Změnit heslo"></center></td>
	</tr>
	</table></center>
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