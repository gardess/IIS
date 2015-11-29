<?php
session_start();
header('Content-type: text/html; charset=utf-8');
if (!isset($_SESSION['logged']))
{
	$_SESSION['logged'] = 1;
	$_SESSION['Zarazeni'] = "null";
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
			rozvrhMenu()
			?>

		<?php
			if(isset($_POST['ucebna']))
			{
				$vybranaUcebna = $_POST['ucebna'];
				$vybraneDatum = $_POST['datum'];
			}
			else
			{
				$vybranaUcebna = "D105";
				$vybraneDatum = date("Y-m-d");
			}
		?>


		<?php
			echo "<form method='post'>";
		?>
    		</br><center><table border="1">
    			<tr>
    				<td>Zvol učebnu:</td>
    				<td>
	    				<select name="ucebna">
		    				<?php
						    	getUsersOptions("ucebna","Oznaceni");
							?>
						</select>
					</td>
				</tr>
				<tr>
    				<td>Zvol datum:</td>
    				<td>
	    				<input type="text" name="datum" value="<?php echo date("Y-m-d"); ?>">
					</td>
				</tr>
				<tr>
					<td colspan="2"><center><input type="submit" name="submit" value="Zobrazit rozvrh"></center></td>
    			</tr>
    		</table></center>
    		</form></br>

    	




    	<?php
			
			$sql="SELECT * FROM rezervace WHERE Oznaceni ='$vybranaUcebna' AND Datum ='$vybraneDatum'";
      		$result=mysql_query($sql);
      		if(mysql_num_rows($result) == 0)
		    {
		    	echo "<center><h3>Není zadána žádná rezervace!</h3></center>";
		    	return false;
		    }
		    echo "<center><h2>Rozvrh pro učebnu ". $vybranaUcebna ." dne ". $vybraneDatum ."</h2></center>";
		    $barvaPrednaska = "#99FF99";
		    $barvaCviceni = "FFE8B4";
		    $barvaDemoCviceni = "CCFFFF";
		    $barvaZkouska = "FFFFCC";
		    echo " <center>
			   		<table border=\"1\">
			   			<tr>
			   				<td> 0:00</td>
			   				<td> 1:00</td>
			   				<td> 2:00</td>
			   				<td> 3:00</td>
			   				<td> 4:00</td>
			   				<td> 5:00</td>
			   				<td> 6:00</td>
			   				<td> 7:00</td>
			   				<td> 8:00</td>
			   				<td> 9:00</td>
			   				<td>10:00</td>
			   				<td>11:00</td>
			   				<td>12:00</td>
			   				<td>13:00</td>
			   				<td>14:00</td>
			   				<td>15:00</td>
			   				<td>16:00</td>
			   				<td>17:00</td>
			   				<td>18:00</td>
			   				<td>19:00</td>
			   				<td>20:00</td>
			   				<td>21:00</td>
			   				<td>22:00</td>
			   				<td>23:00</td>
			   			</tr>"; 
		    while($record = MySQL_Fetch_Array($result))
		    {
		    	$posun = $record['Cas'];
		    	$delka = $record['Delka'];
		    	$predmet = $record['Zkratka'];
		    	$RC = $record['Rodne_cislo'];
		    	$mistnost = $record['Oznaceni'];
		    	$typ = $record['Typ'];
		    	$ress = mysql_query("SELECT * from predmet where Zkratka ='".$predmet."' ");
		        	while($recc = MySQL_Fetch_Array($ress))
		        	{
		        		$rocnik = $recc['Rocnik'];
		        	}
		    	 $res = mysql_query("SELECT * from akademicky_pracovnik where Rodne_cislo ='".$RC."' ");
		        	while($rec = MySQL_Fetch_Array($res))
		        	{
		        		$jmeno = $rec['Jmeno'];
		        		$prijmeni = $rec['Prijmeni'];
		        	}
		    	echo "<tr>";
		    	$prom = false;
		    	for ($i = 0; $i < 25; $i++)
		    	{
		    		if ($i == $posun)
		    		{
		    			if (strcmp($typ,"Přednáška") == 0)
		    			{
		    				echo "<td colspan=\"$delka\" bgcolor=\"$barvaPrednaska\">";
		    				echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
		    				$i = $i + $delka;
		    				continue;
		    			}
		    			if (strcmp($typ,"Cvičení") == 0)
		    			{
		    				echo "<td colspan=\"$delka\" bgcolor=\"$barvaCviceni\">";
		    				echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
		    				$i = $i + $delka;
		    				continue;
		    			}
		    			if (strcmp($typ,"Demonstrační cvičení") == 0)
		    			{
		    				echo "<td colspan=\"$delka\" bgcolor=\"$barvaDemoCviceni\">";
		    				echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
		    				$i = $i + $delka;
		    				continue;
		    			}
		    			else
		    			{
		    				echo "<td colspan=\"$delka\" bgcolor=\"$barvaZkouska\">";
		    				echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
		    				$i = $i + $delka;
		    				continue;
		    			}
		    			
		    			//echo "<center>".$predmet."</br>".$rocnik."</br>".$jmeno." ".$prijmeni."</br>".$mistnost."</center></td>";
		    			$i = $i + $delka;
		    			continue;
		    		}
		    		/*elseif ($prom == true)
		    		{
		    			continue;
		    		}
		    		elseif ($i == ($posun+$delka))
		    		{
		    			$prom = false;
		    		}*/
		    		
		    			echo "<td></td>";
		    		
		    	}


		    	echo "</tr>";

		    }
		    echo "</table></center>";
		    /*$result = mysql_query("select * from rezervace");
		    
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
		    echo "</table></center>";*/


		    echo "</br>";
		    print_r($_SESSION);
   		?>  
   		
   		



  	</body>
</html>