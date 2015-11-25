<?php
session_start();
if (!isset($_SESSION['logged']))
{
	$_SESSION['logged'] = 1;
	$_SESSION['Zarazeni'] = "null";
}
?>
<!-- Hlavní stránka - Výpis rozvrhu, který se zobrazuje všem -->


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
     "http://www.w3.org/TR/html4/strict.dtd">
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
		    	echo "Nenalezeny žádné záznamy!";
		    	return false;
		    }
		    echo "<center><h2>Aktuální rezervace</h2>";
		    echo "<table>";
		    echo "<tr><td>Označení</td><td>Rodné číslo</td><td>Zkratka</td><td>Jednorazova</td></tr>";
		    while($record = MySQL_Fetch_Array($result))
		    {
		        $first = $record['Oznaceni'];
		        $second = $record['Rodne_cislo'];
		        $third = $record['Zkratka'];
		        $fourth = $record['Jednorazova'];      
		      	echo "<tr><td>$first</td><td>$second</td><td>$third</td><td>$fourth</td></tr>";
		    }
		    echo "</table></center>";


		    echo "</br>";
		    print_r($_SESSION);
   		?>  
  	</body>
</html>