<?php
session_start();
include "database.php";
if (isset($_POST['pridat_button']))
{
	header('Location: rezervace_pridat.php');
}
elseif (isset($_POST['upravit_button']))
{
	if (!isset($_POST['vyber']))
	{
		echo "Nebyla vybrána žádná rezervace pro úpravu.";
	}
	else
	{
		$_SESSION['value'] = $_POST['vyber'];
		if ($_SESSION['value'] != "")
		{
			//$_SESSION['value'] = $_POST['vyber'];
	    	header('Location: rezervace_upravit.php');
	    }
	    else
	    {
	    	echo "Nebyla vybrána žádná rezervace.";
	    }
    }
}
elseif (isset($_POST['odebrat_button']))
{
	if (!isset($_POST['vyber']))
	{
		echo "Nebyla vybrána žádná rezervace pro smazání.";
	}
	else
    {
    	if(smazRezervaci($_POST['vyber'], $_SESSION['Rodne_cislo']))
        {
        	echo "Rezervace odebrána.<br>";
        }
    	else
    	{
            echo "Rezervaci se nepodařilo odebrat!<br>";
    	}
    }
}
else
{
    $_SESSION['value'] = "";
    
}
/*if (isset($_SESSION['Zarazeni']))
{
	header('Location: selecting.php');
}*/
function smazRezervaci($id, $RC)
  {
  	connectDB();
    if ($_SESSION['Zarazeni'] != "Administrator")
    {
        $ress = mysql_query("select Rodne_cislo from rezervace where ID = $id");
        while($recc = MySQL_Fetch_Array($ress))
    	{
    	   	$ID_RC = $recc['Rodne_cislo'];
    	}
    	if ($ID_RC != $RC)
    	{
    		echo "Nemáte dostatečná oprávnění pro smazání této rezervace.</br>";
    		return false;
    	}
    }

    $requestt = "DELETE FROM rezervace WHERE id = $id";
    if(!mysql_query($requestt))
    {
      echo mysql_error();
      return false;
    }
    else
    {
    	echo "Smazání proběhlo úspěšně.";
    	return true;
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
    <h1>Rezervace</h1>
     <?php
    	echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
		include "menu.php";
		//include "login.php";
		showMenu($_SESSION['Zarazeni']);
		
  	?>


  	<?php
  	
  	connectDB();
  	$result = mysql_query("select * from rezervace");
		    
		    if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace!</h3></center>";
		    	echo "<form method=\"post\"><center>";
		    	echo "<input type=\"submit\" name=\"pridat_button\" value=\"Přidat rezervaci\">";
		    	echo "</center></form>";
		    	return false;
		    }
		    echo "<center><h2>Aktuální rezervace</h2>";
		    echo "<form method=\"post\"><table border=\"1\">";
		    echo "<tr><td>ID</td><td>Učebna</td><td>Jméno a příjmení</td><td>Zkratka</td><td>Jednorázová</td><td>Datum přidání</td><td>Čas přidání</td></tr>";
		    while($record = MySQL_Fetch_Array($result))
		    {
		    	$aa = $record['ID'];
		        $a = $record['Oznaceni'];

		        $b = $record['Rodne_cislo'];
		        //$pozadavek = mysql_query("select * from akademicky_pracovnik where Mistnost ='".$a."' AND Nazev ='".$e."' ");
		        $res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$b."' ");
		        	while($rec = MySQL_Fetch_Array($res))
		        	{
		        		$ba = $rec['Jmeno'];
		        		$bb = $rec['Prijmeni'];
		        	}
		        $c = $record['Zkratka'];
		        $d = $record['Jednorazova'];
		        $e = $record['Datum_pridani'];
		        $f = $record['Cas_pridani'];      
		      	echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$aa\">$aa</td><td>$a</td><td>$ba $bb</td><td>$c</td><td>$d</td><td>$e</td><td>$f</td></tr>";

		    }
		    echo "<tr><td colspan=\"7\"><center>
		    	<input type=\"submit\" name=\"pridat_button\" value=\"Přidat\">
		    	<input type=\"submit\" name=\"upravit_button\" value=\"Upravit\">
		    	<input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat\">
		    	</center></td></tr>";
		    echo "</table></form></center>";
    ?>
    </br>
    <?php
   		echo "</br>";
		print_r($_SESSION);
  	?>
  </body>
</html>

