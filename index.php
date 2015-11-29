<?php
session_start();
if (!isset($_SESSION['logged']))
{
	$_SESSION['logged'] = 1;
	$_SESSION['Zarazeni'] = "null";
}
?>
<!-- Hlavní stránka - Výpis rozvrhu, který se zobrazuje všem -->


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
    	<title>Informační systém - Učebny</title>
    	<meta http-equiv="content-type" content="text/html; charset=utf-8">
  	</head>
  
  	<body>  
    	<h1>Informační systém - Učebny</h1>
    	<?php
    		if ((($_SESSION['Zarazeni']) == "Administrator") || (($_SESSION['Zarazeni']) == "Akademicky pracovnik"))
    		echo "Přihlášen uživatel: " . $_SESSION['Jmeno'] . " " . $_SESSION['Prijmeni'];
      		//include "login.php";
		    include "database.php";
		    connectDB();
		    //echo $_SERVER['PHP_SELF'];
		    //$typUzivatele = prihlaseni();
		    include "menu.php";
			showMenu();
		    //connectDB();
		    $result = mysql_query("select * from rezervace");
		    
		    if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace!</h3></center>";
		    	return false;
		    }
		    echo "<center><h2>Aktuální rezervace</h2>";
		    echo "<table border=\"1\">";
		    echo "<tr><td>ID</td><td>Učebna</td><td>Jméno a příjmení</td><td>Zkratka</td><td>Jednorázová</td><td>Datum přidání</td><td>Čas přidání</td></tr>";
		    while($record = MySQL_Fetch_Array($result))
		    {
		    	$aa = $record['ID'];
		        $a = $record['Oznaceni'];

		        $b = $record['Rodne_cislo'];
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
		      	echo "<tr><td>$aa</td><td>$a</td><td>$ba $bb</td><td>$c</td><td>$d</td><td>$e</td><td>$f</td></tr>";
		    }
		    echo "</table></center>";


		    echo "</br>";
		    print_r($_SESSION);
   		?>  
  	</body>
</html>