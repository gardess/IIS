<?php
session_start();
header('Content-type: text/html; charset=utf-8');
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
			?>
		<div id="telo">	
		<h2 class="nadpis">Seznam rezervací</h2>


  	<?php
  	
  	connectDB();
  	$result = mysql_query("select * from rezervace");
		    
		    if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace!</h3></center>";
		    	echo "<form method=\"post\"><center>";
		    	echo "<input type=\"submit\" name=\"pridat_button\" value=\"Přidat rezervaci\">";
		    	echo "</center></form>";
		    	echo "</div>
				   		<div id=\"footer\">
				   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
						</div>
				   	</div>";
		    	return false;
		    }
		    echo "<center>";
		    echo "<form method=\"post\"><table border=\"1\">";
		    echo "<tr><td></td><td>Učebna</td><td>Jméno a příjmení</td><td>Předmět</td><td>Ročník</td><td>Typ výuky</td><td>Datum</td><td>Čas</td><td>Datum přidání</td><td>Čas přidání</td></tr>";
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
		        $d = $record['Datum'];
		        $dd = $record['Cas'];
		        $e = $record['Datum_pridani'];
		        $f = $record['Cas_pridani'];
		        $delka = $record['Delka'];
		        $typ = $record['Typ'];
		        $ress = mysql_query("SELECT * from predmet where Zkratka ='".$c."' ");
		        	while($recc = MySQL_Fetch_Array($ress))
		        	{
		        		$h = $recc['Rocnik'];
		        	}
		              
		      	echo "<tr><td><input type=\"radio\" name=\"vyber\" value=\"$aa\"></td><td>$a</td><td>$ba $bb</td><td>$c</td><td>$h</td><td>$typ</td><td>$d</td><td>$dd".":00 - ";
		      	echo $dd+$delka-1;
		      	echo ":50</td><td>$e</td><td>$f</td></tr>";

		    }
		    
		    echo "</table>";
		    echo " <br>
		    	<input type=\"submit\" name=\"pridat_button\" value=\"Přidat rezervaci\">
		    	<input type=\"submit\" name=\"upravit_button\" value=\"Upravit rezervaci\">
		    	<input type=\"submit\" name=\"odebrat_button\" value=\"Odebrat rezervaci\">
		    	</form></center>";
    ?>
    </br>
    </div>
   		<div id="footer">
   		Vytvořil Milan Gardáš a Filip Pobořil&nbsp;
		</div>
   	</div>
  </body>
</html>

